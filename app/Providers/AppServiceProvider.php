<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider

{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Chia sẻ dữ liệu với tất cả các views
        
        View::share('genresList', DB::table('genres')->select('id', 'name', 'slug')->get());
        View::share('countries', DB::table('countries')->select('id', 'name', 'slug')->get());
        View::share('release_years', DB::table('release_years')->select('id', 'year')->orderBy('year', 'desc')->get());
        View::share('categories', DB::table('categories')->select('id', 'name', 'slug')->get());
        
        
        /*Chia sẻ dữ liệu với chỉ view header
        View::composer('partials.header', function ($view) {
            $view->with('genres', DB::table('genres')->select('id', 'name')->get());
            $view->with('countries', DB::table('countries')->select('id', 'name')->get());
            $view->with('release_years', DB::table('release_years')->select('id', 'year')->orderBy('year', 'desc')->get());
            $view->with('categories', DB::table('categories')->select('id', 'name')->get());
        });
        */

        View::composer('partials.aside', function ($view) {
            $view->with('movies', DB::table('movies')
            ->limit(3)
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name')
            ->groupBy('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name')
            ->orderByRaw('MAX(episodes.id) DESC')
            ->get());

            $view->with('moviesByRating', DB::table('movies')
            ->limit(3)
            ->leftJoin('ratings', 'movies.id', '=', 'ratings.movie_id')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', DB::raw('AVG(ratings.rating) as avg_rating'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug', 'movies.image')
            ->orderByDesc('avg_rating') // Sắp xếp theo rating trung bình từ cao xuống thấp
            ->get());

            $view->with('moviesByView', DB::table('movies')
            ->limit(3)
            ->leftJoin('views', 'movies.id', '=', 'views.movie_id')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'views.views_count')
            ->orderBy('views_count', 'DESC')
            ->get());

            $view->with('moviesByComment', DB::table('movies')
            ->limit(3)
            ->leftJoin('comments', 'movies.id', '=', 'comments.movie_id')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', DB::raw('COUNT(comments.id) as count_comment'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug', 'movies.image')
            ->orderBy('count_comment', 'DESC')
            ->get());

            if(Auth::check()){
                $userId = auth()->id();

                // Lịch sử xem phim của người dùng
                $view->with('watchHistories', DB::table('movies')
                ->limit(4)
                ->join('watch_histories', 'movies.id', '=', 'watch_histories.movie_id')
                ->select('movies.id', 'movies.image', 'movies.slug')
                ->groupBy('movies.id', 'movies.image', 'movies.slug')
                ->where('watch_histories.user_id', $userId)
                ->orderByRaw('MAX(watch_histories.id) DESC') 
                ->get());
                
                // Lấy các thể loại phim từ lịch sử xem phim mà người dùng đã xem
                $watchedGenres = DB::table('watch_histories')
                    ->join('movies', 'watch_histories.movie_id', '=', 'movies.id')
                    ->join('movie_genres', 'movies.id', '=', 'movie_genres.movie_id')
                    ->join('genres', 'movie_genres.genre_id', '=', 'genres.id')
                    ->where('watch_histories.user_id', $userId)
                    ->select('genres.id', 'genres.name', DB::raw('COUNT(genres.id) as genre_count'))
                    ->groupBy('genres.id', 'genres.name')
                    ->orderByDesc('genre_count')
                    ->get();

                if ($watchedGenres->isEmpty()) {
                    return []; // Nếu không có thể loại đã xem, không gợi ý phim
                }

                // Lấy danh sách phim đã xem
                $watchedMovieIds = DB::table('watch_histories')
                    ->where('user_id', $userId)
                    ->pluck('movie_id');

                // Gợi ý các bộ phim chưa xem thuộc các thể loại đã xem
                $view->with('recommendedMovies', DB::table('movies')
                    ->limit(4)
                    ->join('movie_genres', 'movies.id', '=', 'movie_genres.movie_id')
                    ->leftJoin('views', 'movies.id', '=', 'views.movie_id')
                    ->leftJoin('ratings', 'movies.id', '=', 'ratings.movie_id')
                    ->whereIn('movie_genres.genre_id', $watchedGenres->pluck('id'))
                    ->whereNotIn('movies.id', $watchedMovieIds)
                    ->select('movies.id','movies.image', 'movies.slug',
                    'views.views_count', DB::raw('AVG(ratings.rating) as average_rating'), 
                    DB::raw('0.5 * AVG(ratings.rating) + 0.5 * views.views_count as weighted_score'))
                    ->groupBy('movies.id', 'movies.image', 'movies.slug', 'views.views_count')
                    ->orderByDesc('weighted_score')
                    ->distinct()
                    ->get());
            }
        });
    }
}