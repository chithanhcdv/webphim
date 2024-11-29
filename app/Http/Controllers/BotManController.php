<?php
namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Country;
use App\Models\View;
use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Support\Str;

class BotManController extends Controller
{
    public function handle(Request $request)
    {
        $botman = app('botman');

        $botman->hears('{message}', function($botman, $message) {
            if (strpos($message, 'giới thiệu') !== false || strpos($message, 'gợi ý') !== false ||
            strpos($message, 'hot') !== false || strpos($message, 'đề xuất') !== false) { 
                $botman->startConversation(new MovieConversation);
            } 
            else { 
                $botman->reply("Lỗi! Hãy nhập câu hỏi khác liên quan đến phim, ví dụ như đề xuất phim hoặc gợi ý phim");
            } 
        });

        $botman->listen();
    }
}

class MovieConversation extends Conversation
{
    protected $genre;
    protected $country;

    public function askGenre()
    {
        $this->ask('Bạn muốn xem phim theo thể loại nào?', function(Answer $answer) {
            $genreName = $answer->getText();

            try {
                $genre = Genre::where('name', 'like', '%' . $genreName . '%')->first();
                if ($genre) {
                    $this->genre = $genre;
                    //$this->say('Thể loại bạn đã chọn: ' . $genre->name);
                    $this->askCountry();
                } else {
                    $this->say("Không có thể loại phim này, vui lòng nhập lại.");
                    $this->repeat();
                }
            } catch (\Exception $e) {
                $this->say("Có lỗi khi tìm thể loại phim. Vui lòng thử lại.");
                $this->repeat();
            }
        });
    }

    public function askCountry()
    {
        $this->ask('Bạn muốn xem phim thuộc quốc gia nào?', function(Answer $answer) {
            $countryName = $answer->getText();

            try {
                $country = Country::where('name', 'like', '%' . $countryName . '%')->first();
                if ($country) {
                    $this->country = $country;
                    //$this->say('Quốc gia bạn đã chọn: ' . $country->name);
                    $this->showMovies();
                } else {
                    $this->say("Không có quốc gia phim này, vui lòng thử lại.");
                    $this->repeat();
                }
            } catch (\Exception $e) {
                $this->say("Có lỗi khi tìm quốc gia phim. Vui lòng thử lại.");
                $this->repeat();
            }
        });
    }

    public function showMovies()
    {
        try {
            // Lấy danh sách phim từ cơ sở dữ liệu theo thể loại và quốc gia
            $movies = Movie::where('country_id', $this->country->id)
                ->whereHas('genres', function($query) {
                    $query->where('genre_id', $this->genre->id);
                })
                ->limit(4)
                ->get();

            // Nếu không có phim, trả về thông báo
            if ($movies->isEmpty()) {
                $this->say("Không có phim nào phù hợp với thể loại và quốc gia này, vui lòng nhập lại.");
                $this->askGenre();
            } else {
                $this->say("Các bộ phim có thể loại {$this->genre->name} và quốc gia {$this->country->name} được đề xuất cho bạn");

                // Sắp xếp phim theo lượt xem, đánh giá và số lượng bình luận
                $sortedMovies = $movies->sortByDesc(function($movie) {
                    // Lấy thông tin về lượt xem, đánh giá và bình luận
                  
                    $views = $movie->views ? $movie->views->views_count : 0;
                    $ratings = $movie->ratings()->avg('rating') ?: 0; // Nếu không có điểm đánh giá, gán là 0
                    $comments = $movie->comments()->count(); // Đếm số lượng bình luận

                    // Trả về điểm tổng hợp dựa trên các tiêu chí
                    return $views * 0.4 + $ratings * 0.4 + $comments * 0.2;
                });

                // Hiển thị danh sách phim sau khi sắp xếp
                foreach ($sortedMovies as $movie) {
                    // Lấy mô tả ngắn của phim
                    $shortDescription = Str::limit($movie->description, 150);
                    $movieUrl = route('movies.show', ['slug' => $movie->slug]);

                    // Lấy số lượt xem, điểm đánh giá và số lượng bình luận
                    $views = $movie->views ? $movie->views->views_count : 0;
                    $ratings = $movie->ratings()->avg('rating') ?: 0;
                    $comments = $movie->comments()->count();

                    // Hiển thị thông tin phim
                    $this->say("
                        <div class='chatbot'>
                            <a href='{$movieUrl}' class='movie-link' target='_blank'>{$movie->name}
                                <img src='" . asset('storage/images/movies/' . $movie->image) . "' class='movie-image' alt='{$movie->name}' style='display:none'>
                            </a>
                            <br>Mô tả: " . $shortDescription . "
                            <br>Số lượt xem: " . $views . "
                            <br>Điểm đánh giá: " . number_format($ratings, 1) . "
                            <br>Số bình luận: " . $comments . "
                        </div>
                        <style>
                            .chatbot .movie-link {
                                position: relative;
                                text-decoration: none; /* Optional: Remove underline from links */
                            }
                            .chatbot img {
                                position: absolute;
                                top: 0;  /* Place the image just below the link */
                                left: 0;
                                z-index: 10; /* Ensure the image appears above other elements */
                                width:80px;
                                height:120px;
                                border-radius:3px;
                            }
                            .chatbot .movie-link:hover img {
                                display: block !important;
                            }
                        </style>
                    ");
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching movies: ' . $e->getMessage());
            $this->say("Có lỗi khi tìm kiếm phim. Vui lòng thử lại.");
        }
    }

    public function run()
    {
        $this->askGenre();
    }
}
