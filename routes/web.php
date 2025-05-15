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
    //? cache facade:
    Cache::forget('users.list');
    //? with redis facade
    // Redis::del('users.list');
    return redirect('/users')->with('status', 'Cache cleared!');
});
