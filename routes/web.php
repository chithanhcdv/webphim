<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BotManController;

Route::get('/', [MovieController::class, 'index'])->name('index');
Route::get('/phim/{slug}', [MovieController::class, 'show'])->name('movies.show');
Route::get('//xem-phim/{slug}/tap-{episode}', [MovieController::class, 'watch'])->name('movies.watch');
Route::get('/the-loai/{slug}', [MovieController::class, 'moviesByGenre'])->name('movies.genre');
Route::get('/quoc-gia/{slug}', [MovieController::class, 'moviesByCountry'])->name('movies.country');
Route::get('/nam-san-xuat/{year}', [MovieController::class, 'moviesByReleaseYear'])->name('movies.release_year');
Route::get('/danh-muc/{slug}', [MovieController::class, 'moviesByCategory'])->name('movies.category');
Route::get('/tim-kiem', [MovieController::class, 'search'])->name('movies.search');
Route::get('/search-ajax', [MovieController::class, 'searchAjax'])->name('movies.searchAjax');
Route::get('/phim-moi-cap-nhat', [MovieController::class, 'newUpdate'])->name('movies.newUpdate');
Route::get('/bang-xep-hang/luot-xem', [MovieController::class, 'moviesByTopView'])->name('movies.topView');
Route::get('/bang-xep-hang/luot-danh-gia', [MovieController::class, 'moviesByTopRating'])->name('movies.topRating');
Route::get('/bang-xep-hang/luot-binh-luan', [MovieController::class, 'moviesByTopComment'])->name('movies.topComment');
Route::get('/loc-phim', [MovieController::class, 'moviesByFilter'])->name('movies.filter');
Route::get('/tin-phim/moi-cap-nhat', [NewsController::class, 'newUpdate'])->name('news.newUpdate');
Route::get('/tin-phim/{slug}', [NewsController::class, 'show'])->name('news.show');


Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

// Route người dùng thao tác
// Lưu bình luận, phản hồi
Route::post('/movies/comment', [CommentController::class, 'storeComment'])->name('comment.store');
Route::post('/movies/reply', [CommentController::class, 'storeReply'])->name('reply.store');

// đánh giá của sao người dùng
Route::post('/movies/{id}/rating', [UserController::class, 'storeRating'])->name('rating.store');

// Lưu phim người dùng theo dõi
Route::post('/movies/{id}/watchList', [UserController::class, 'storeWatchList'])->name('watchList.store');

// Danh sách phim theo lịch sử xem phim
Route::get('/phim-theo-doi', [MovieController::class, 'moviesByWatchList'])->name('movies.watchList')->middleware('verified');
// Danh sách phim theo danh sách theo dõi của người dùng
Route::get('/lich-su-xem-phim', [MovieController::class, 'moviesByWatchHistory'])->name('movies.watchHistory')->middleware('verified');
// Danh sách phim theo gợi ý phim
Route::get('goi-y-phim', [MovieController::class, 'moviesByRecommended'])->name('movies.recommended')->middleware('verified');

// Đổi mật khẩu
Route::get('/doi-mat-khau', [UserController::class, 'editPassword'])->name('password.edit')->middleware('verified');
Route::post('/user/password-change', [UserController::class, 'updatePassword'])->name('password.update');

// Đặt mật khẩu khi đăng nhập bằng gg hoặc fb
Route::get('/dat-mat-khau', [UserController::class, 'setPassword'])->name('password.set')->middleware('verified');
Route::post('/user/password-set', [UserController::class, 'setUpPassword'])->name('password.setUp');

// Profile người dùng
Route::get('/thong-tin-tai-khoan', [UserController::class, 'profile'])->name('user.profile')->middleware('verified');

//Form chỉnh sửa profile
Route::get('/thong-tin-tai-khoan/cap-nhat-thong-tin', [UserController::class, 'profileEdit'])->name('user.profileEdit')->middleware('verified');
Route::post('/user/profile/edit', [UserController::class, 'storeProfileUpdate'])->name('user.profileUpdate')->middleware('verified');

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

//Thích bình luận và thích phản hồi
Route::get('/comments/{id}/like', [CommentController::class, 'likeComment'])->name('comment.like');
Route::get('/replies/{id}/like', [CommentController::class, 'likeReply'])->name('reply.like');

//Bỏ thích
Route::get('/comments/{id}/dislike', [CommentController::class, 'dislikeComment'])->name('comment.dislike');
Route::get('/replies/{id}/dislike', [CommentController::class, 'dislikeReply'])->name('reply.dislike');

// Xóa bình luận và phản hồi
Route::get('/comments/{id}/delete', [CommentController::class, 'deleteComment'])->name('comment.delete');
Route::get('/replies/{id}/delete', [CommentController::class, 'deleteReply'])->name('reply.delete');

// Dịch vụ người dùng
Route::get('/goi-dich-vu', [UserController::class, 'service'])->name('user.service')->middleware('verified');
Route::get('/goi-dich-vu/thanh-toan/{id}', [UserController::class, 'servicePayment'])->name('user.payment')->middleware('verified');

// Thanh toán dịch vụ
Route::post('/payment/momo', [PaymentController::class, 'momoPayment'])->name('payment.momo');
Route::get('/payment/momo/return', [PaymentController::class, 'momoReturn'])->name('momo.return');

Route::post('/payment/paypal', [PaymentController::class, 'paypalPayment'])->name('payment.paypal');
Route::get('/payment/paypal/capture', [PaymentController::class, 'paypalCapture'])->name('payment.paypal.capture');
Route::post('/payment/vnpay', [PaymentController::class, 'vnpayPayment'])->name('payment.vnpay');
Route::get('/vnpay-return', [PaymentController::class, 'vnpayReturn'])->name('vnpay.return');

Route::get('/thanh-toan-thanh-cong', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/thanh-toan-that-bai', [PaymentController::class, 'paymentFail'])->name('payment.fail');
// Xóa dịch vụ
Route::get('/service/remove/{id}', [UserController::class, 'serviceRemove'])->name('service.remove');

// Botman
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);
