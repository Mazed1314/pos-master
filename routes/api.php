<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(UserController::class)->group(function(){
    Route:: post('login','authenticate');
});
Route::controller(UserController::class)->group(function(){
    Route:: get('user','getUserDetail');
    Route:: get('logout','userLogout');
})->middleware('auth:api');




// testing route

// Route::get('/products', function(){
//     return'products';
// });



// public routes

// route::post('/register', [AuthController::class, 'register']);
// route::post('/login', [AuthController::class, 'login']);
// route::get('/products',[ProductController::class, 'index']);
// route::get('/products/{id}',[ProductController::class, 'show']);
// Route::get('/products/search/{name}', [ProductController::class,'search']);



// Protected routes

// Route::group(['middleware' => ['auth:passport']], function () {
//     route::post('/products', [ProductController::class, 'store']);
//     route::put('/products/{id}', [ProductController::class, 'update']);
//     route::delete('/products/{id}', [ProductController::class, 'destroy']);
//     route::post('/logout', [AuthController::class, 'logout']);
// });