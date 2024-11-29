<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class NewsController extends Controller
{
    public function show($slug)
    {
        try {
            $news = DB::table('news')
                ->select('title', 'content', 'content_image', 'other_content', 'other_image')
                ->where('slug', $slug)
                ->first();

            if (!$news) {
                return abort(404, 'Bản tin không tồn tại.');
            }

            $other_news = DB::table('news')
                ->select('id', 'title', 'slug')
                ->orderBy('id', 'desc')
                ->limit(3)
                ->get();

            return view('news.show', compact('news', 'other_news'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Có lỗi xảy ra khi tải bản tin.');
        }
    }

    public function newUpdate()
    {
        try {
            $news = DB::table('news')
                ->select('id', 'title', 'slug', 'title_image')
                ->orderBy('id', 'desc')
                ->paginate(6);

            return view('news.newUpdate', compact('news'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Có lỗi xảy ra khi tải danh sách bản tin.');
        }
    }
}
