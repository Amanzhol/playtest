<?php

use App\Http\Controllers\ProfileController;
use App\Jobs\StartDance;
use App\Models\User;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

//    dispatch(new StartDance(User::first()));
    StartDance::dispatch(User::first()) ;
    return 'Here Queue testing';

});

Route::get('/redis', function () {

    return Redis::command('incr',['visitors']);

});

Route::get('/cache/set', function () {

    dd(Cache::put('test','some_cache'));

});

Route::get('/cache/get', function () {

    dd(Cache::get('test'));

});



Route::get('/pipeline', function () {

    $pipeline = app(Pipeline::class);
    $pipeline->send('Whats up')
        ->through([
            function ($str, $next) {
                $str = ucwords($str);
                return $next($str);
            }
        ])
        ->then(function ($string){
            var_dump($string);
        });

    return "<br />".'Here Queue testing';

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
