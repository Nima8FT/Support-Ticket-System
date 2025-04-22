<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketResponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

//route for authentication system with passport
Route::group(['middleware' => 'guest'], function () {
    Route::post('register', [RegisterController::class, 'register'])->name('register');
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
});


//route for ticket system
Route::group(['prefix' => 'tickets', 'middleware' => 'auth:api'], function () {
    Route::resource('ticket', TicketController::class);
    Route::resource('ticket-responses', TicketResponseController::class);
});
