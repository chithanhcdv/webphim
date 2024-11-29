<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
    Route::crud('user', 'UserCrudController');
    Route::crud('genre', 'GenreCrudController');
    Route::crud('country', 'CountryCrudController');
    Route::crud('movie', 'MovieCrudController');
    Route::crud('episode', 'EpisodeCrudController');
    Route::crud('release-year', 'ReleaseYearCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('news', 'NewsCrudController');
    Route::crud('trailer', 'TrailerCrudController');
    Route::crud('service', 'ServiceCrudController');
    Route::crud('service-order', 'ServiceOrderCrudController');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/orders-data', [DashboardController::class, 'getOrdersData']);
    Route::get('/dashboard/prices-data', [DashboardController::class, 'getPricesData']);
    Route::crud('comment', 'CommentCrudController');
    Route::crud('rating', 'RatingCrudController');
    Route::crud('view', 'ViewCrudController');
}); 

