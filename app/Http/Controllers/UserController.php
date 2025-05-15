<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function index()
    {
        //? cache facade
        // if (Cache::has("users.list")){
        //     $users = Cache::get("users.list");
        // } else {
        //     $users = DB::table('users')->get();
        //     Cache::put("users.list", $users, 600);
        // }
        
        // $users = Cache::remember(
            //     'users.list',
            //     300,
            //     fn() => DB::table('users')->get()
        // );

        //? redis facade
        if (Redis::exists("users:list")){
            $users = json_decode(Redis::get("users:list"));
        } else {
            $users = DB::table('users')->get();
            Redis::setex("users:list", 600,  $users);
        }

        
        return view('users', compact('users'));
    }
}
