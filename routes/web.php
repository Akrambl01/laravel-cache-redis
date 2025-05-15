<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index']);

Route::get('/clear-users-cache', function () {
    Redis::del('users.list');
    return response()->json(['status' => 'Cache cleared!']);
});
