<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    Route::apiResource('register', 'RegisterController')->only('store');
    Route::post('login', 'AuthController@store')->name('login.store');

    Route::namespace('Article')->group(function () {
        Route::apiResource('articles', 'ArticleController');
        Route::patch('articles/{article}/favorite', 'ArticleController@favorite')
            ->name('articles.favorite.update');

        Route::apiResource('articles.comments', 'CommentController')->only('index', 'store', 'update', 'destroy');
        Route::patch('articles/{article}/comments/{comment}/ban', 'CommentController@ban')->name('articles.comments.ban');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::delete('logout', 'AuthController@destroy')->name('logout.destroy');

        Route::patch('password-reset', 'AuthController@passwordReset')->name('auth.passwordReset');

        Route::apiResource('member', 'MemberController')->only('index', 'update');
    });
});
