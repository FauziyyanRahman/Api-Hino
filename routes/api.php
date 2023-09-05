<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Karoseri\DesignToolsController;
use App\Http\Controllers\Karoseri\IdentityController;
use App\Http\Controllers\Karoseri\EquipmentController;
use App\Http\Controllers\Karoseri\PicController;
use App\Http\Controllers\Karoseri\ProductCapacityController;
use App\Http\Controllers\Karoseri\ChassisController;
use App\Http\Controllers\Karoseri\VariantController;
use App\Http\Controllers\Karoseri\SkrbController;
use App\Http\Controllers\Karoseri\WebUsersController;

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

    //Route::get('/main-category/{main}', [CategoryController::class, 'getMainCategory']);
    Route::get('/main-category', [CategoryController::class, 'getMainCategory']);
    //Route::get('/level-category/{id}', [CategoryController::class, 'getKategoriByLevel']);
    Route::post('/add-audit-trail', [CategoryController::class, 'insertAuditTrail']);
    Route::post('/add-respond', [CategoryController::class, 'respondRequestForm']); 
    Route::post('/add-request', [CategoryController::class, 'requestCategory']); 
    
    Route::post('/store', [MessageController::class, 'store']); 

    Route::get('/visitors', [HomeController::class, 'visitors']); 
    Route::get('/yajra', [HomeController::class, 'yajraData']); 

    Route::get('/identities', [IdentityController::class, 'index']);
    Route::get('/identities/{id}', [IdentityController::class, 'show']);
    Route::post('/identities', [IdentityController::class, 'store']);
    Route::put('/identities/{id}', [IdentityController::class, 'update']);
    Route::delete('/identities/{id}', [IdentityController::class, 'destroy']);

    Route::get('/design-tools', [DesignToolsController::class, 'index']);
    Route::get('/design-tools/{id}', [DesignToolsController::class, 'show']);
    Route::post('/design-tools', [DesignToolsController::class, 'store']);
    Route::put('/design-tools/{id}', [DesignToolsController::class, 'update']);
    Route::delete('/design-tools/{id}', [DesignToolsController::class, 'destroy']);

    Route::get('/equipment', [EquipmentController::class, 'index']);
    Route::get('/equipment/{id}', [EquipmentController::class, 'show']);
    Route::post('/equipment', [EquipmentController::class, 'store']);
    Route::put('/equipment/{id}', [EquipmentController::class, 'update']);
    Route::delete('/equipment/{id}', [EquipmentController::class, 'destroy']);

    Route::get('/pic', [PicController::class, 'index']);
    Route::get('/pic/{id}', [PicController::class, 'show']);
    Route::post('/pic', [PicController::class, 'store']);
    Route::put('/pic/{id}/{area}', [PicController::class, 'update']);
    Route::delete('/pic/{id}', [PicController::class, 'destroy']);

    Route::get('/product-capacity', [ProductCapacityController::class, 'index']);
    Route::get('/product-capacity/{id}', [ProductCapacityController::class, 'show']);
    Route::post('/product-capacity', [ProductCapacityController::class, 'store']);
    Route::put('/product-capacity/{id}', [ProductCapacityController::class, 'update']);
    Route::delete('/product-capacity/{id}', [ProductCapacityController::class, 'destroy']);

    Route::get('/chassis', [ChassisController::class, 'index']);
    Route::get('/chassis/{id}', [ChassisController::class, 'show']);
    Route::post('/chassis', [ChassisController::class, 'store']);
    Route::put('/chassis/{id}/{chassis}', [ChassisController::class, 'update']);
    Route::delete('/chassis/{id}', [ChassisController::class, 'destroy']);

    Route::get('/variant', [VariantController::class, 'index']);
    Route::get('/variant/{id}', [VariantController::class, 'show']);
    Route::post('/variant', [VariantController::class, 'store']);
    Route::put('/variant/{id}', [VariantController::class, 'update']);
    Route::delete('/variant/{id}', [VariantController::class, 'destroy']);

    Route::get('/skrb', [SkrbController::class, 'index']);
    Route::get('/skrb/{id}', [SkrbController::class, 'show']);
    Route::post('/skrb', [SkrbController::class, 'store']);
    Route::put('/skrb/{id}/{idSk}', [SkrbController::class, 'update']);
    Route::delete('/skrb/{id}', [SkrbController::class, 'destroy']);

    Route::get('/web-users', [WebUsersController::class, 'index']);
    Route::get('/web-users/{id}', [WebUsersController::class, 'show']);
    Route::post('/web-users', [WebUsersController::class, 'store']);
    Route::put('/web-users/{id}/{idPic}', [WebUsersController::class, 'update']);
    Route::delete('/web-users/{id}', [WebUsersController::class, 'destroy']);
});