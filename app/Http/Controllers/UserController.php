<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function index()
    {
        // Measure time to test caching impact
        $start = microtime(true);

        //? with cache facade
        // Cache the data for 600 seconds (10 minutes)
        $users = Cache::remember('users.list', 600, function () {
            return User::all();
        });

        //? with redis facade
        //* check if the key exists in Redis 
        //  if (Redis::exists("users.list")){ 
        //     //if it exists, get the data from Redis
        //     $users = json_decode(Redis::get("users.list"));
        // } else {
        //     //if it doesn't exist, get the data from the database, and set it in Redis
        //     $users = DB::table('users')->get();
        //     Redis::setex("users.list", 600,  $users);
        // }

        $duration = round((microtime(true) - $start) * 1000, 2); // in ms

        return view('users', compact('users', 'duration'));
    }
}
