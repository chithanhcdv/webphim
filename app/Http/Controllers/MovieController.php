<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $swiperMovies = DB::table('movies')
            ->limit(18)
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name',
            'movies.total_episode', DB::raw('COUNT(episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name', 'movies.total_episode')
            ->orderByRaw('MAX(episodes.id) DESC')
            ->get();

        $carouselMovies = DB::table('movies')
            ->limit(5)
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->leftJoin('views', 'movies.id', '=', 'views.movie_id')
            ->leftJoin('ratings', 'movies.id', '=', 'ratings.movie_id')
            ->leftJoin('comments', 'movies.id', '=', 'comments.movie_id')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.background_image', 'movies.description', 
            'movies.other_name', 'views.views_count', DB::raw('AVG(ratings.rating) as avg_rating'),
            DB::raw('COUNT(DISTINCT comments.id) as count_comment'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug', 'movies.image', 
            'movies.background_image', 'movies.description','movies.other_name', 'views.views_count')
            ->orderByRaw('MAX(episodes.id) DESC')
            ->get();

        $movies = DB::table('movies')
            ->limit(8)
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name',
            'movies.total_episode', DB::raw('COUNT(episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug',
            'movies.image', 'movies.other_name', 'movies.total_episode')
            ->orderByRaw('MAX(episodes.id) DESC')
            ->get();

        $moviesByTopView = DB::table('movies')
            ->limit(8)
            ->leftJoin('views', 'movies.id', '=', 'views.movie_id')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'views.views_count', 
            'movies.total_episode', DB::raw('COUNT(episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug',
            'movies.image', 'movies.total_episode', 'views.views_count') 
            ->orderBy('views_count', 'DESC')
            ->get();
        
        $moviesByTopRating = DB::table('movies')
            ->limit(8)
            ->leftJoin('ratings', 'movies.id', '=', 'ratings.movie_id')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', DB::raw('AVG(ratings.rating) as avg_rating'),
            'movies.total_episode', DB::raw('COUNT(episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.total_episode')
            ->orderByDesc('avg_rating')
            ->get();

        $moviesByTopComment = DB::table('movies')
            ->limit(8)
            ->leftJoin('comments', 'movies.id', '=', 'comments.movie_id')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.total_episode',
            DB::raw('COUNT(DISTINCT comments.id) as count_comment'),
            DB::raw('COUNT(DISTINCT episodes.id) as episode_count')) 
            ->groupBy('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.total_episode')
            ->orderByDesc('count_comment')
            ->get();

        $news = DB::table('news')
            ->limit(6)
            ->select('id', 'title', 'slug', 'title_image')
            ->orderBy('id','DESC')
            ->get();

            

        return view('index', compact('swiperMovies', 'carouselMovies', 'movies',
        'moviesByTopView', 'moviesByTopRating', 'moviesByTopComment', 'news'));
    }

    public function show($slug)
    {
        $sortOrder = request()->input('sort', 'desc');

        // Tìm phim bằng slug
        $movie = DB::table('movies')
            ->join('countries', 'movies.country_id', '=', 'countries.id')
            ->join('release_years', 'movies.release_year_id', '=', 'release_years.id')
            ->join('categories', 'movies.category_id', '=', 'categories.id')
            ->select('movies.*', 'countries.name as country_name', 'countries.slug as country_slug',
            'release_years.year as release_year_year', 'movies.slug',
            'categories.slug as category_slug', 'categories.name as category_name')
            ->where('movies.slug', $slug)
            ->first();

        // Kiểm tra nếu phim không tồn tại
        if (!$movie) {
            abort(404); // Hoặc bạn có thể tạo một trang lỗi 404 tùy chỉnh
        }

        // Lấy tất cả thể loại của phim
        $genres = DB::table('movie_genres')
            ->join('genres', 'movie_genres.genre_id', '=', 'genres.id')
            ->select('genres.id', 'genres.name', 'genres.slug')
            ->where('movie_genres.movie_id', $movie->id)
            ->get();

        $relatedMovies = DB::table('movies')
            ->join('movie_genres', 'movies.id', '=', 'movie_genres.movie_id')
            ->whereIn('movie_genres.genre_id', $genres->pluck('id'))
            ->where('movies.id', '!=', $movie->id) // Loại trừ phim hiện tại
            ->select('movies.id', 'movies.name', 'movies.image', 'movies.slug')
            ->distinct() // Loại bỏ các bộ phim trùng lặp
            ->limit(10) // Giới hạn số phim
            ->get();

        $trailer = DB::table('trailers')
            ->select('url')
            ->where('movie_id', $movie->id)
            ->first();

        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->leftJoin('likes', 'comments.id', '=', 'likes.comment_id')
            ->where('comments.movie_id', $movie->id)
            ->select('comments.id', 'comments.content', 'users.name', 'users.avatar', 'users.google_id',
                'users.facebook_id', DB::raw('COUNT(likes.id) as like_count'),
                DB::raw('MAX(CASE WHEN likes.user_id = ' . (Auth::check() ? Auth::id() : 0) . ' THEN 1 ELSE 0 END) as user_liked'))
            ->groupBy('comments.id', 'comments.content', 'users.name', 'users.avatar', 'users.google_id', 'users.facebook_id')
            ->orderBy('comments.id', $sortOrder)
            ->paginate(10);

        foreach ($comments as $comment) {
            $comment->replies = DB::table('replies')
                ->join('users', 'replies.user_id', '=', 'users.id')
                ->leftJoin('likes', 'replies.id', '=', 'likes.reply_id')
                ->where('replies.comment_id', $comment->id)
                ->select('replies.content', 'users.name', 'users.avatar', 'replies.id',
                    DB::raw('COUNT(likes.id) as reply_like_count'),
                    DB::raw('MAX(CASE WHEN likes.user_id = ' . 
                    (Auth::check() ? Auth::id() : 0) . ' THEN 1 ELSE 0 END) as user_liked_reply'))
                ->groupBy('replies.content', 'users.name', 'users.avatar', 'replies.id')
                ->get();
        }

        $commentCount = DB::table('comments')
            ->where('movie_id', $movie->id)
            ->count();

        $viewCount = DB::table('views')
            ->select('views_count')
            ->where('movie_id', $movie->id)
            ->first();
        $views = $viewCount ? $viewCount->views_count : 0;

        $averageRating = DB::table('ratings')
            ->where('movie_id', $movie->id)
            ->avg('rating');

        $memberRating = DB::table('ratings')
            ->where('movie_id', $movie->id)
            ->count();

        $existingWatchList = DB::table('watch_lists')
            ->where('user_id', Auth::id())
            ->where('movie_id', $movie->id)
            ->first();

        $episodeLists = DB::table('episodes')
            ->limit(5)
            ->select('episode_number')
            ->where('movie_id', $movie->id)
            ->orderBy('episode_number', 'DESC')
            ->get();

        $duration = DB::table('episodes')
            ->where('movie_id', $movie->id)
            ->max('duration');

        $latestUpdate = DB::table('episodes')
            ->where('movie_id', $movie->id)  
            ->max('updated_at');

        // Trả về view chi tiết phim
        return view('movies.show', compact('movie', 'genres', 'trailer', 'comments',
            'commentCount', 'views', 'averageRating', 'memberRating', 'existingWatchList',
            'episodeLists', 'duration', 'latestUpdate', 'relatedMovies'));
    }

    public function watch($slug, $episode)
    {
        $movie = DB::table('movies')
            ->join('countries', 'movies.country_id', '=', 'countries.id')
            ->join('categories', 'movies.category_id', '=', 'categories.id')
            ->select('movies.id', 'movies.name', 'movies.description', 'movies.image', 'movies.background_image',
            'movies.other_name', 'countries.slug as country_slug', 'countries.name as country_name',
            'categories.slug as category_slug', 'categories.name as category_name', 'movies.hot', 'movies.slug')
            ->where('movies.slug', $slug)
            ->first();

        // Kiểm tra nếu phim không tồn tại
        if (!$movie) {
            abort(404); // Hoặc bạn có thể tạo một trang lỗi 404 tùy chỉnh
        }

        // Kiểm tra nếu phim hot yêu cầu người dùng đăng nhập và có gói dịch vụ
        if ($movie->hot == 1) {
            if (!Auth::check()) {
                return redirect()->back()->with('status', 'Bạn phải đăng nhập và mua gói dịch vụ để được xem phim này');
            }

            // Kiểm tra xem người dùng đã có dịch vụ trong bảng services_orders
            $serviceOrder = DB::table('services_orders')
            ->where('user_id', Auth::id())
            ->where('status', 'đang sử dụng')
            ->first();

            if ($serviceOrder == null) {
                return redirect()->back()->with('status', 'Bạn phải mua gói dịch vụ để được xem phim này');
            }
        }

        // Kiểm tra nếu tập phim tồn tại
        $checkEpisode = DB::table('episodes')
            ->select('episode_number')
            ->where('movie_id', $movie->id)
            ->first();

        if ($checkEpisode === null) {
            return redirect()->back()->with('status', 'Bộ phim này đang cập nhật, vui lòng quay lại sau');
        }

        // Cập nhật lượt xem
        DB::table('views')->updateOrInsert(
            ['movie_id' => $movie->id],
            [
                'views_count' => DB::raw('views_count + 1'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Cập nhật lịch sử xem phim của người dùng
        if (Auth::check()) {
            DB::table('watch_histories')->insert([
                'user_id' => Auth::id(),
                'movie_id' => $movie->id,
                'watched_at' => now(),
            ]);
        }

        $sortOrder = request()->input('sort', 'desc');

        // Lấy thể loại phim
        $genres = DB::table('movie_genres')
            ->join('genres', 'movie_genres.genre_id', '=', 'genres.id')
            ->select('genres.id', 'genres.name', 'genres.slug')
            ->where('movie_genres.movie_id', $movie->id)
            ->get();

        // Lấy danh sách phim liên quan
        $relatedMovies = DB::table('movies')
            ->join('movie_genres', 'movies.id', '=', 'movie_genres.movie_id')
            ->whereIn('movie_genres.genre_id', $genres->pluck('id'))
            ->where('movies.id', '!=', $movie->id) // Loại trừ phim hiện tại
            ->select('movies.id', 'movies.name', 'movies.image', 'movies.slug')
            ->distinct()
            ->limit(10)
            ->get();

        // Lấy trailer của phim
        $trailer = DB::table('trailers')
            ->select('url')
            ->where('movie_id', $movie->id)
            ->first();

        // Lấy danh sách bình luận
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->leftJoin('likes', 'comments.id', '=', 'likes.comment_id')
            ->where('comments.movie_id', $movie->id)
            ->select('comments.id', 'comments.content', 'users.name', 'users.avatar', 'users.google_id',
                'users.facebook_id', DB::raw('COUNT(likes.id) as like_count'),
                DB::raw('MAX(CASE WHEN likes.user_id = ' . (Auth::check() ? Auth::id() : 0) . ' THEN 1 ELSE 0 END) as user_liked'))
            ->groupBy('comments.id', 'comments.content', 'users.name', 'users.avatar', 'users.google_id', 'users.facebook_id')
            ->orderBy('comments.id', $sortOrder)
            ->paginate(10);

        foreach ($comments as $comment) {
            $comment->replies = DB::table('replies')
                ->join('users', 'replies.user_id', '=', 'users.id')
                ->leftJoin('likes', 'replies.id', '=', 'likes.reply_id')
                ->where('replies.comment_id', $comment->id)
                ->select('replies.content', 'users.name', 'users.avatar', 'replies.id',
                    DB::raw('COUNT(likes.id) as reply_like_count'),
                    DB::raw('MAX(CASE WHEN likes.user_id = ' . (Auth::check() ? Auth::id() : 0) . ' THEN 1 ELSE 0 END) as user_liked_reply'))
                ->groupBy('replies.content', 'users.name', 'users.avatar', 'replies.id')
                ->get();
        }

        $commentCount = DB::table('comments')
            ->where('movie_id', $movie->id)
            ->count();

        $averageRating = DB::table('ratings')
            ->where('movie_id', $movie->id)
            ->avg('rating');

        $memberRating = DB::table('ratings')
            ->where('movie_id', $movie->id)
            ->count();

        // Lấy tập phim được yêu cầu
        $episode = DB::table('episodes')
            ->select('server1', 'server2', 'episode_number')
            ->where('movie_id', $movie->id)
            ->where('episode_number', $episode)
            ->first();

        // Lấy danh sách tập phim
        $episodeLists = DB::table('episodes')
            ->select('episode_number')
            ->where('movie_id', $movie->id)
            ->get();

        $existingWatchList = DB::table('watch_lists')
            ->where('user_id', Auth::id())
            ->where('movie_id', $movie->id)
            ->first();

        // Trả về view
        return view('movies.watch', compact('movie', 'genres', 'trailer',
            'comments', 'commentCount', 'averageRating', 'memberRating', 'episode',
            'episodeLists', 'existingWatchList', 'relatedMovies'));
    }

    public function moviesByGenre($slug)
    {
        $genre = DB::table('genres')->where('slug', $slug)->first();

        $movies = DB::table('movies')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name',
            'movies.total_episode', DB::raw('COUNT(episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug',
            'movies.image', 'movies.other_name', 'movies.total_episode')
            ->join('movie_genres', 'movies.id', '=', 'movie_genres.movie_id') 
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->where('movie_genres.genre_id', '=', $genre->id) 
            ->orderByRaw('MAX(episodes.id) DESC')         
            ->paginate(8);     

        // Trả về view 'movies.genre' với dữ liệu đã phân trang
        return view('movies.genre', compact('genre', 'movies'));
    }

    public function moviesByCountry($slug)
    {
        $country = DB::table('countries')->where('slug', $slug)->first();

        $movies = DB::table('movies')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name',
            'movies.total_episode', DB::raw('COUNT(episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug',
            'movies.image', 'movies.other_name', 'movies.total_episode')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->where('country_id', '=', $country->id) 
            ->orderByRaw('MAX(episodes.id) DESC')   
            ->paginate(8);   

        // Trả về view 'movies.genre' với dữ liệu đã phân trang
        return view('movies.country', compact('country', 'movies'));
    }

    public function moviesByReleaseYear($year)
    {
        $release_year = DB::table('release_years')->where('year', $year)->first();

        $movies = DB::table('movies')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name',
            'movies.total_episode', DB::raw('COUNT(episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug',
            'movies.image', 'movies.other_name', 'movies.total_episode')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->where('release_year_id', '=', $release_year->id) 
            ->orderByRaw('MAX(episodes.id) DESC') 
            ->paginate(8);   

        // Trả về view 'movies.genre' với dữ liệu đã phân trang
        return view('movies.releaseYear', compact('release_year', 'movies'));
    }

    public function moviesByCategory($slug)
    {
        $category = DB::table('categories')->where('slug', $slug)->first();

        $movies = DB::table('movies')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name',
            'movies.total_episode', DB::raw('COUNT(episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug',
            'movies.image', 'movies.other_name', 'movies.total_episode')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->where('category_id', '=', $category->id) 
            ->orderByRaw('MAX(episodes.id) DESC')
            ->paginate(8);   

        return view('movies.category', compact('category', 'movies'));
    }

    public function newUpdate()
    {
        $movies = DB::table('movies')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name',
            'movies.total_episode', DB::raw('COUNT(episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug',
            'movies.image', 'movies.other_name', 'movies.total_episode')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->orderByRaw('MAX(episodes.id) DESC')  
            ->paginate(8);

        return view('movies.newUpdate', compact('movies'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('q'); // 'q' là tên input trong form tìm kiếm

        $movies = DB::table('movies')       
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name',
            'movies.total_episode', DB::raw('COUNT(episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug',
            'movies.image', 'movies.other_name', 'movies.total_episode')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->where(function ($query) use ($searchTerm) {
                $query->where('movies.name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('movies.other_name', 'LIKE', '%' . $searchTerm . '%');
            })
            ->orderByRaw('MAX(episodes.id) DESC')
            ->paginate(8);

        // Trả về view kết quả tìm kiếm
        return view('movies.search', compact('movies', 'searchTerm'));
    }

    public function searchAjax(Request $request)
    {
        $searchTerm = $request->input('query');

        $movies = DB::table('movies')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name',
            'movies.total_episode', DB::raw('COUNT(episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug',
            'movies.image', 'movies.other_name', 'movies.total_episode')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->where(function ($query) use ($searchTerm) {
                $query->where('movies.name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('movies.other_name', 'LIKE', '%' . $searchTerm . '%');
            })
            ->orderByRaw('MAX(episodes.id) DESC') 
            ->limit(5)
            ->get();

        // Trả về dữ liệu dạng JSON cho Ajax
        return response()->json($movies);
    }

    public function moviesByWatchList()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }

        $movies = DB::table('movies')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'other_name',
            'movies.total_episode', DB::raw('COUNT(DISTINCT episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug',
            'movies.image', 'movies.other_name', 'movies.total_episode')
            ->join('watch_lists', 'movies.id', '=', 'watch_lists.movie_id')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->where('user_id', '=', Auth::id()) 
            ->orderBy('watch_lists.id', 'DESC') 
            ->paginate(8);   

        return view('movies.watchList', compact('movies')); 
    }

    public function moviesByWatchHistory()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }
        
        $movies = DB::table('movies')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name',
            'movies.total_episode', DB::raw('COUNT(DISTINCT episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug',
            'movies.image', 'movies.other_name', 'movies.total_episode')
            ->join('watch_histories', 'movies.id', '=', 'watch_histories.movie_id')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->where('user_id', '=', Auth::id()) 
            ->orderByRaw('MAX(watch_histories.id) DESC')   
            ->paginate(8);   

        // Trả về view 'movies.genre' với dữ liệu đã phân trang
        return view('movies.watchHistory', compact('movies'));
    }

    public function moviesByTopView()
    {
        $movies = DB::table('movies')
        ->leftJoin('views', 'movies.id', '=', 'views.movie_id')
        ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image',
        'views.views_count', 'movies.other_name', 'movies.background_image')
        ->orderBy('views_count', 'DESC')
        ->paginate(8);

        return view('movies.topView', compact('movies'));
    }

     public function moviesByTopRating()
    {
        $movies = DB::table('movies')
        ->leftJoin('ratings', 'movies.id', '=', 'ratings.movie_id')
        ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.background_image',
        'movies.other_name', DB::raw('AVG(ratings.rating) as avg_rating'))
        ->groupBy('movies.id', 'movies.name', 'movies.slug',
        'movies.image', 'movies.background_image', 'movies.other_name')
        ->orderByDesc('avg_rating') // Sắp xếp theo rating trung bình từ cao xuống thấp
        ->paginate(8);

        return view('movies.topRating', compact('movies'));
    }

    public function moviesByTopComment()
    {
        $movies = DB::table('movies')
        ->leftJoin('comments', 'movies.id', '=', 'comments.movie_id')
        ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.background_image',
        'movies.other_name', DB::raw('COUNT(comments.id) as count_comment'))
        ->groupBy('movies.id', 'movies.name', 'movies.slug',
        'movies.image', 'movies.background_image', 'movies.other_name')
        ->orderByDesc('count_comment')
        ->paginate(8);

        return view('movies.topComment', compact('movies'));
    }

    public function moviesByFilter(Request $request)
    {
        // Lấy các tiêu chí lọc từ request
        $selectedGenres = $request->input('genre');
        $selectedCountry = $request->input('country');
        $selectedCategory = $request->input('category');
        $selectedReleaseYear = $request->input('release_year');

        // Khởi tạo query cơ bản
        $moviesQuery = DB::table('movies')
            ->select('movies.id', 'movies.name', 'movies.slug', 'movies.image', 'movies.other_name',
            'movies.total_episode', DB::raw('COUNT(episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.name', 'movies.slug', 
            'movies.image', 'movies.other_name', 'movies.total_episode')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id');

        // Áp dụng lọc thể loại nếu có (kiểm tra nếu là mảng)
        if (is_array($selectedGenres) && !empty($selectedGenres)) {
            $moviesQuery->join('movie_genres', 'movies.id', '=', 'movie_genres.movie_id')
                ->whereIn('movie_genres.genre_id', $selectedGenres);
        }

        // Áp dụng lọc quốc gia nếu có
        if (!empty($selectedCountry)) {
            $moviesQuery->where('movies.country_id', $selectedCountry);
        }

        // Áp dụng lọc danh mục nếu có
        if (!empty($selectedCategory)) {
            $moviesQuery->where('movies.category_id', $selectedCategory);
        }

        // Áp dụng lọc năm phát hành nếu có
        if (!empty($selectedReleaseYear)) {
            $moviesQuery->where('movies.release_year_id', $selectedReleaseYear);
        }

        // Sắp xếp và phân trang kết quả
        $movies = $moviesQuery->orderByRaw('MAX(episodes.id) DESC')->paginate(8);

        // Trả về view kết quả lọc
        return view('movies.filter', compact('movies', 'selectedGenres', 'selectedCountry', 'selectedCategory', 'selectedReleaseYear'));
    }

    public function moviesByRecommended(){
        $userId = auth()->id();

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
        $recommendedMovies = DB::table('movies')
            ->limit(16)
            ->join('movie_genres', 'movies.id', '=', 'movie_genres.movie_id')
            ->leftJoin('views', 'movies.id', '=', 'views.movie_id')
            ->leftJoin('ratings', 'movies.id', '=', 'ratings.movie_id')
            ->leftJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->whereIn('movie_genres.genre_id', $watchedGenres->pluck('id'))
            ->whereNotIn('movies.id', $watchedMovieIds)
            ->select('movies.id','movies.image', 'movies.name', 'movies.slug', 'movies.other_name', 'views.views_count', 
            DB::raw('AVG(ratings.rating) as average_rating'), 
            DB::raw('0.5 * AVG(ratings.rating) + 0.5 * views.views_count as weighted_score'),
            'movies.total_episode', DB::raw('COUNT(DISTINCT episodes.id) as episode_count'))
            ->groupBy('movies.id', 'movies.image', 'movies.name', 'movies.slug', 'movies.other_name', 'views.views_count', 'movies.total_episode')
            ->orderByDesc('weighted_score')
            ->distinct()
            ->paginate(8);

        return view('movies.recommended', compact('recommendedMovies'));
    }
}
