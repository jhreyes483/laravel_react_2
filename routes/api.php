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

Route::prefix('v1')->group(function(){
    // PUBLIC 
    //::public
    Route::get('public/{slug}',[FrontController::class, 'categoria']);
    //::auth
    Route::get('auth/register',[AuthController::class, 'register']);
    Route::get('auth/login',[AuthController::class, 'login']);


// PRIVATE


});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
