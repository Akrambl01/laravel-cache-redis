<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index']);

Route::get('/clear-users-cache', function () {
    return response()->json(['status' => 'Cache cleared!']);
});
