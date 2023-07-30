<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\Category\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
| Owner: Fauziyyan Thafhan Rahman
*/

/**
 * Default API route to get the authenticated user's information.
 * This route requires the user to be authenticated using Sanctum.
 */

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/**
 * Protect routes with JWT token (requires authentication).
 * All routes inside this group require a valid JWT token to access.
 */
Route::group(['middleware' => 'auth.api'], function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);    
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/survey', [AuthController::class, 'survey']);

    Route::get('/id-berita/{id}', [NewsController::class, 'getBeritaByID']);
    Route::get('/data-berita', [NewsController::class, 'dataBerita']);
    Route::post('/add-berita', [NewsController::class, 'AddMsBerita']);
    Route::post('/update-berita', [NewsController::class, 'ubahMsBerita']);
    Route::delete('/delete-berita/{news}', [NewsController::class, 'deleteMsBerita']);

    Route::get('/main-category/{main}', [CategoryController::class, 'getMainCategory']);
    Route::get('/level-category/{id}', [CategoryController::class, 'getKategoriByLevel']);
    Route::post('/add-audit-trail', [CategoryController::class, 'insertAuditTrail']);
    Route::post('/add-respond', [CategoryController::class, 'respondRequestForm']); 
    Route::post('/add-request', [CategoryController::class, 'requestCategory']); 
});