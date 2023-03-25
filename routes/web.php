<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\MicropostsController;
use App\Http\Controllers\UserFolloeController;
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

Route::get('/', [MicropostsController::class,'index']);

Route::get('/dashboard', [MicropostsController::class,'index'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth']], function() {
    Route::group(['prefix' => 'users/{id}'], function() {
        Route::post('follow', [UserFolloeController::class, 'store'])->name('user.follow');
        Route::delete('unfollow', [UserFolloeController::class, 'destroy'])->name('user.unfollow');
        Route::get('followings', [UserFolloeController::class, 'followings'])->name('users.followings');
        Route::get('followers', [UserFolloeController::class, 'followers'])->name('users.followers');
    });
    
    Route::resource('users', UsersController::class, ['only' =>['index','show']]);
    Route::resource('microposts', MicropostsController::class, ['only' =>['store', 'destroy']]);
});