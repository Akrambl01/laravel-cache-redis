# 🚀 Laravel Redis Cache Example

This project demonstrates how to use **Redis** as a caching driver in **Laravel 12**. It includes examples using both the `Cache` and `Redis` facades to store, retrieve, and manage cache data efficiently.

---

## 📂 Features

* Laravel 12 setup with Redis
* Cache data using `Cache` facade
* Direct Redis commands with `Redis` facade
* Example code snippets
* Environment and run instructions
* Route-based cache handling with performance check
* Detailed method explanations

---

## ⚙️ Requirements

Make sure you have the following installed:

* PHP >= 8.1
* Composer
* Redis server (local or remote)
* Laravel 12
* Either `predis/predis` package or PHP Redis extension

---

## 🧰 Installation & Setup

### 1. Clone the repository

```bash
git clone https://github.com/Akrambl01/laravel-cache-redis.git
cd laravel-cache-redis
```

### 2. Install Laravel dependencies

```bash
composer install
```

### 3. Set up environment file

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Redis in `.env`

```env
CACHE_DRIVER=redis
CACHE_STORE=redis
REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CACHE_DB=0
```

### 5. Run migrations and seeders (to populate sample data)

```bash
php artisan migrate --seed
```

### 6. Start Redis server (if not running)

```bash
redis-server
```

> Or use a service like `brew services start redis` on macOS.

### 7. Run Laravel development server

```bash
php artisan serve
```

App will be available at: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔄 Routes & Usage

### `/users`

Fetches users using the `Cache::remember()` method (or Redis fallback). Measures response duration to demonstrate caching performance.

```php
Route::get('/users', [UserController::class, 'index']);
```

### `/clear-users-cache`

Clears the `users.list` cache key using `Cache::forget()`.

```php
Route::get('/clear-users-cache', function () {
    Cache::forget('users.list');
    // Redis::del('users.list'); // Alternative
    return redirect('/users')->with('status', 'Cache cleared!');
});
```

### `UserController@index`

Handles caching logic with both `Cache` and `Redis` facades:

```php
public function index()
{
    $start = microtime(true);

    $users = Cache::remember('users.list', 600, function () {
        return User::all();
    });

    // Redis alternative:
    // if (Redis::exists("users.list")) {
    //     $users = json_decode(Redis::get("users.list"));
    // } else {
    //     $users = DB::table('users')->get();
    //     Redis::setex("users.list", 600,  $users);
    // }

    $duration = round((microtime(true) - $start) * 1000, 2);

    return view('users', compact('users', 'duration'));
}
```

## 📂 Using the Cache Facade

### `Cache::put($key, $value, $expiration)`

Stores data in the cache for a specified duration.

```php
Cache::put('key', 'value', now()->addMinutes(10));
```

### `Cache::get($key, $default = null)`

Retrieves data from cache or returns default if the key is missing.

```php
$value = Cache::get('key', 'default');
```

### `Cache::has($key)`

Checks if a cache key exists.

```php
if (Cache::has('key')) {
    // Key exists
}
```

### `Cache::forget($key)`

Deletes the given key from the cache.

```php
Cache::forget('key');
```

### `Cache::remember($key, $expiration, $callback)`

Caches the result of the callback if the key does not already exist.

```php
$data = Cache::remember('posts', now()->addMinutes(30), function () {
    return DB::table('posts')->get();
});
```

---

## 🔌 Using the Redis Facade

### `Redis::set($key, $value)`

Sets a key in Redis with no expiration.

```php
Redis::set('user:1:name', 'Akram');
```

### `Redis::get($key)`

Gets the value of a key from Redis.

```php
$name = Redis::get('user:1:name');
```

### `Redis::setex($key, $seconds, $value)`

Sets a key with a value and an expiration time in seconds.

```php
Redis::setex('token', 600, 'my_token');
```

### `Redis::del($key)`

Deletes a key from Redis.

```php
Redis::del('user:1:name');
```

---

## 🔍 Debug with Redis CLI

Use Redis CLI to inspect or manage your Redis keys:

```bash
redis-cli

> keys *
> get user:1:name
> ttl token
```

---

## 📌 Notes & Best Practices

* Use `Cache::remember()` to avoid redundant queries.
* Group cache keys using naming patterns (`user:1`, `session:user_1`).
* In production, monitor Redis memory usage to prevent overflow.
* You can use `tags()` with Redis if using `predis` or appropriate extensions.

---

## 📜 License

This project is licensed under the [MIT License](LICENSE).

---
