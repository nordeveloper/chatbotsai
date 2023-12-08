<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    
    Route::get('/', [App\Http\Controllers\CharactersController::class, 'index'])->name('home');
    Route::resource('/characters', App\Http\Controllers\CharactersController::class);
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat');
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [\App\Http\Controllers\SettingsController::class, 'save'])->name('settings.save');
    Route::any('/chat/send', [\App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/getHistory', [\App\Http\Controllers\ChatController::class, 'getHistory'])->name('chat.history');
    Route::get('/chat/removeHistory', [\App\Http\Controllers\ChatController::class, 'removeHistory'])->name('chat.removeHistory');
        
    Route::get('/user_profile', [\App\Http\Controllers\UserController::class, 'index'])->name('user.profile');
    Route::post('/user_update', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
});


require __DIR__.'/auth.php';
