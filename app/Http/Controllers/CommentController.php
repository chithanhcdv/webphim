<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Exception;

class CommentController extends Controller
{
    public function storeComment(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'content' => 'required|string|max:500',
        ]);

        try {
            DB::table('comments')->insert([
                'user_id' => Auth::id(),
                'movie_id' => $request->movie_id,
                'content' => $request->content,
                'image' => $request->image ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('status', 'Bình luận của bạn đã được đăng thành công');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Đã xảy ra lỗi khi đăng bình luận: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Lỗi không xác định: ' . $e->getMessage());
        }
    }

    public function storeReply(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'content' => 'required|string|max:500',
        ]);

        try {
            DB::table('replies')->insert([
                'comment_id' => $request->comment_id,
                'user_id' => Auth::id(),
                'content' => $request->content,
                'image' => $request->image ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('status', 'Phản hồi của bạn đã được đăng thành công');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Đã xảy ra lỗi khi đăng phản hồi: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Lỗi không xác định: ' . $e->getMessage());
        }
    }

    public function likeComment($id)
    {
        if (!Auth::check()) {
            return redirect()->back()->withErrors('Bạn cần đăng nhập để thực hiện chức năng này.');
        }

        try {
            DB::table('likes')->insert([
                'user_id' => Auth::id(),
                'comment_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('status', 'Thích thành công');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Đã xảy ra lỗi khi thích bình luận: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Lỗi không xác định: ' . $e->getMessage());
        }
    }

    public function dislikeComment($id)
    {
        if (!Auth::check()) {
            return redirect()->back()->withErrors('Bạn cần đăng nhập để thực hiện chức năng này.');
        }

        try {
            DB::table('likes')
                ->where('comment_id', $id)
                ->where('user_id', Auth::id())
                ->delete();

            return redirect()->back()->with('status', 'Bỏ thích thành công');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Đã xảy ra lỗi khi bỏ thích bình luận: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Lỗi không xác định: ' . $e->getMessage());
        }
    }

    public function likeReply($id)
    {
        if (!Auth::check()) {
            return redirect()->back()->withErrors('Bạn cần đăng nhập để thực hiện chức năng này.');
        }

        try {
            DB::table('likes')->insert([
                'user_id' => Auth::id(),
                'reply_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('status', 'Thích thành công');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Đã xảy ra lỗi khi thích phản hồi: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Lỗi không xác định: ' . $e->getMessage());
        }
    }

    public function dislikeReply($id)
    {
        if (!Auth::check()) {
            return redirect()->back()->withErrors('Bạn cần đăng nhập để thực hiện chức năng này.');
        }

        try {
            DB::table('likes')
                ->where('reply_id', $id)
                ->where('user_id', Auth::id())
                ->delete();

            return redirect()->back()->with('status', 'Bỏ thích thành công');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Đã xảy ra lỗi khi bỏ thích phản hồi: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Lỗi không xác định: ' . $e->getMessage());
        }
    }

    public function deleteComment($id)
    {
        if (!Auth::check()) {
            return redirect()->back()->withErrors('Bạn cần đăng nhập để thực hiện chức năng này.');
        }

        try {
            DB::table('comments')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->delete();

            return redirect()->back()->with('status', 'Xóa bình luận thành công');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Đã xảy ra lỗi khi xóa bình luận: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Lỗi không xác định: ' . $e->getMessage());
        }
    }

    public function deleteReply($id)
    {
        if (!Auth::check()) {
            return redirect()->back()->withErrors('Bạn cần đăng nhập để thực hiện chức năng này.');
        }

        try {
            DB::table('replies')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->delete();

            return redirect()->back()->with('status', 'Xóa phản hồi thành công');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Đã xảy ra lỗi khi xóa phản hồi: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Lỗi không xác định: ' . $e->getMessage());
        }
    }
}
