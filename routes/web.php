<?php

use App\Http\Containers\AuthenticationsContainer\Controllers\AuthenticationsController;
use App\Http\Containers\EventsContainer\Controllers\EventsController;
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
        Route::get('/{id}/comments', [NewsController::class, 'getComments'])->withoutMiddleware(['auth:sanctum']);

        Route::get('/{id}', [NewsController::class, 'show'])->withoutMiddleware(['auth:sanctum']);

        Route::get('/', [NewsController::class, 'read'])->withoutMiddleware(['auth:sanctum']);

        Route::post('/{id}/comments', [NewsController::class, 'addComment'])->withoutMiddleware(['auth:sanctum']);

        Route::post('/', [NewsController::class, 'store']);

        Route::patch('/{id}', [NewsController::class, 'update']);

        Route::delete('/{id}', [NewsController::class, 'delete']);
    });

    Route::group(['prefix' => 'events'], function () {
        Route::get('/{id}/comments', [EventsController::class, 'getComments'])->withoutMiddleware(['auth:sanctum']);

        Route::get('/{id}', [EventsController::class, 'show'])->withoutMiddleware(['auth:sanctum']);

        Route::get('/', [EventsController::class, 'read'])->withoutMiddleware(['auth:sanctum']);

        Route::post('/{id}/comments', [EventsController::class, 'addComment'])->withoutMiddleware(['auth:sanctum']);

        Route::post('/', [EventsController::class, 'store']);

        Route::patch('/{id}', [EventsController::class, 'update']);

        Route::delete('/{id}', [EventsController::class, 'delete']);
    });
});
