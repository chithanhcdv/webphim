<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $this->registerOrLoginUser($user, 'google_id');
        return redirect()->route('index')->with('status', 'Đăng nhập thành công!');
    }

    // Redirect to Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Handle Facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        $this->registerOrLoginUser($user, 'facebook_id');
        return redirect()->route('index')->with('status', 'Đăng nhập thành công!');
    }

    // Register or Login User
    protected function registerOrLoginUser($data, $provider)
    {
        // Tìm người dùng dựa trên google_id hoặc facebook_id
        $user = User::where($provider, $data->id)->first();

        // Nếu không tìm thấy người dùng với provider_id, kiểm tra email
        if (!$user) {
            // Tìm người dùng dựa trên email
            $existingUser = User::where('email', $data->email)->first();

            // Nếu người dùng đã tồn tại nhưng không có google_id hoặc facebook_id, cập nhật thông tin
            if ($existingUser) {
                // Cập nhật ID của nhà cung cấp và avatar nếu avatar hiện tại là null
                $existingUser->{$provider} = $data->id;

                // Chỉ cập nhật avatar nếu avatar hiện tại là null
                if (is_null($existingUser->avatar)) {
                    $existingUser->avatar = $data->avatar; // Cập nhật avatar nếu cần
                }

                $existingUser->save();
                $user = $existingUser; // Đặt người dùng là người đã tồn tại
            } else {
                // Không có người dùng nào tồn tại, tạo mới
                $user = User::create([
                    'name' => $data->name,
                    'email' => $data->email,                   
                    $provider => $data->id, // Đặt giá trị cho provider ID
                    'avatar' => $data->avatar,
                    'email_verified_at' => now(),
                ]);
            }
        }

        // Đăng nhập vào tài khoản đã tìm thấy hoặc mới tạo
        Auth::login($user);
    }

}
