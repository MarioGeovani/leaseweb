<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\ServerDataController;

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

//Home
Route::get('/', function () {
    return view('welcome-api');
});

//Public Routes
Route::controller(LoginRegisterController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

//Authenticated Routes
Route::middleware('auth:sanctum')->group(function() {
    Route::controller(LoginRegisterController::class)->group(function() {
        Route::get('/user', 'user');
    });

    Route::group(['prefix' => '/servers'],
    function () {
        Route::controller(ServerDataController::class)->group(function() {
            Route::get('/', 'list', ['as' => 'server.data.list']);
            Route::post('/import', 'import', ['as' => 'server.file.import']);
            Route::get('/filters', 'filters', ['as' => 'filters.list']);
        });
    });

});