<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function storeRating(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('status', 'Bạn cần đăng nhập để đánh giá.');
        }

        $request->validate([
            'rating' => 'required|integer|between:1,10',
        ]);

        try {
            $existingRating = DB::table('ratings')
                ->where('movie_id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if ($existingRating) {
                DB::table('ratings')
                    ->where('movie_id', $id)
                    ->where('user_id', Auth::id())
                    ->update(['rating' => $request->input('rating')]);
            } else {
                DB::table('ratings')->insert([
                    'movie_id' => $id,
                    'user_id' => Auth::id(),
                    'rating' => $request->input('rating'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return redirect()->back()->with('status', 'Đánh giá thành công');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Có lỗi xảy ra khi lưu đánh giá. Vui lòng thử lại.');
        }
    }

    public function storeWatchList(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('status', 'Bạn cần đăng nhập để theo dõi phim.');
        }

        try {
            $existingWatchList = DB::table('watch_lists')
                ->where('movie_id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if ($existingWatchList) {
                DB::table('watch_lists')
                    ->where('movie_id', $id)
                    ->where('user_id', Auth::id())
                    ->delete();

                return redirect()->back()->with('status', 'Bỏ theo dõi phim thành công');
            } else {
                DB::table('watch_lists')->insert([
                    'movie_id' => $id,
                    'user_id' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return redirect()->back()->with('status', 'Theo dõi phim thành công');
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Có lỗi xảy ra khi xử lý yêu cầu của bạn.');
        }
    }

    public function editPassword()
    {
        return view('user.changePassword');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        try {
            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('password.edit')->with('status', 'Mật khẩu đã được thay đổi thành công.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Có lỗi xảy ra khi cập nhật mật khẩu.');
        }
    }

    public function setPassword()
    {
        return view('user.setPassword');
    }

    public function setUpPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();        

        // Cập nhật mật khẩu
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('index')->with('status', 'Mật khẩu đã được đặt thành công.');
    }

    public function profile() {
        return view('user.profile');
    }

    public function profileEdit(){
        return view('user.profileEdit');
    }

    public function storeProfileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $user = Auth::user();
            $user->name = $request->name;

            if ($request->hasFile('avatar')) {
                $avatarName = $request->file('avatar')->getClientOriginalName();
                $request->file('avatar')->storeAs('images/avatar', $avatarName);
                $user->avatar = $avatarName;
            }

            $user->save();

            return redirect()->route('user.profile')->with('status', 'Cập nhật thông tin người dùng thành công!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Có lỗi xảy ra khi cập nhật thông tin người dùng.');
        }
    }

    public function service()
    {
        $services = DB::table('services')
            ->select('*')
            ->get();

        // Lấy thông tin gói dịch vụ hiện tại từ bảng services_orders
        $currentService = DB::table('services_orders')
            ->join('services', 'services_orders.service_id', '=', 'services.id')
            ->select(
                'services_orders.service_start_at',
                'services_orders.service_end_at',
                'services.*'
            )
            ->where('services_orders.user_id', Auth::user()->id)
            ->where('services_orders.status', 'đang sử dụng')
            ->first();

        // Lấy lịch sử dịch vụ
        $servicesHistory = DB::table('services_orders')
            ->join('services', 'services_orders.service_id', '=', 'services.id')
            ->select('services_orders.*', 'services.name')
            ->where('services_orders.user_id', Auth::user()->id)
            ->orderByDesc('services_orders.service_start_at')
            ->get();

        return view('user.service', compact('services', 'currentService', 'servicesHistory'));
    }

    public function servicePayment($id)
    {
        $service = DB::table('services')
            ->select('*')
            ->where('id', $id)
            ->first();

        return view('user.payment.pay', compact('service'));
    }

    public function serviceRemove($id)
    {
        try {
            DB::table('services_orders')
                ->where('user_id', $id)
                ->update(['status' => 'đã hủy']);

            return redirect()->back()->with('status', 'Hủy gói dịch vụ thành công');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Có lỗi xảy ra khi hủy gói dịch vụ.');
        }
    }

}
