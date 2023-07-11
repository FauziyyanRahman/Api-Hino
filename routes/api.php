<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * Api default
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Api category & sub category
 */
Route::resource('category', 'App\Http\Controllers\Category\CategoryController', ['only' => ['index', 'show']]);
Route::resource('category/sub', 'App\Http\Controllers\Category\SubCategoryController', ['only' => ['index', 'show']]);

/**
 * Api home
 */
Route::resource('home', 'App\Http\Controllers\Home\HomeController', ['only' => ['index', 'create']]);
Route::get('home/admin', 'App\Http\Controllers\Home\HomeController@adminPanel');

/**
 * Api contact
 */
Route::resource('contact', 'App\Http\Controllers\Contact\ContactController', ['only' => ['index', 'show']]);

/**
 * Api karoseri
 */
Route::resource('karoseri', 'App\Http\Controllers\Karoseri\KaroseriController', ['only' => ['index', 'show']]);

/**
 * Api login
 */
Route::resource('login', 'App\Http\Controllers\Login\LoginController', ['only' => ['index', 'show']]);

/**
 * Api news
 */
Route::resource('news', 'App\Http\Controllers\News\NewsController', ['only' => ['index', 'show']]);

/**
 * Api report
 */
Route::resource('report', 'App\Http\Controllers\Report\ReportController', ['only' => ['index', 'show']]);

/**
 * Api sidebar
 */
Route::resource('sidebar', 'App\Http\Controllers\Sidebar\SidebarController', ['only' => ['index', 'show']]);

/**
 * Api sidebar
 */
Route::resource('users', 'App\Http\Controllers\Users\UsersController', ['only' => ['index', 'show']]);