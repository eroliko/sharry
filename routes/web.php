<?php

use App\Http\Containers\AuthenticationsContainer\Controllers\AuthenticationsController;
use App\Http\Containers\NewsContainer\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/sanctum/token', [AuthenticationsController::class, 'authenticate']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix' => 'news'], function () {
        Route::get('/{id}', [NewsController::class, 'show'])->withoutMiddleware(['auth:sanctum']);

        Route::post('/', [NewsController::class, 'store']);

        Route::patch('/{id}', [NewsController::class, 'update']);

        Route::delete('/{id}', [NewsController::class, 'delete']);
    });
});
