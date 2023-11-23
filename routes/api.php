<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FrontController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\EmpresaController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Client\EmpresaController as EmpresaClientController;


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
    Route::group(['middleware' => 'auth:sanctum'], function(){
        //::auth
        Route::post('/auth/logout',[AuthController::class, 'logout']);

        //::rol client
        Route::apiResource('/client/empresa',EmpresaClientController::class);

        //::rol admin
        Route::apiResource('/admin/user',UserController::class);
        Route::apiResource('/admin/category',CategoryController::class);
        Route::apiResource('/admin/empresa',EmpresaController::class);
        
    });


});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
