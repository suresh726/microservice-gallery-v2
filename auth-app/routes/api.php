<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/auth/signup', [AuthController::class, 'signupUser']);

Route::post('/auth/signin', [AuthController::class, 'signinUser'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/auth/current-user', function(Request $request) {
        return auth()->user();
    });

    Route::delete('/auth/signout', [AuthController::class, 'signoutUser']);
});

