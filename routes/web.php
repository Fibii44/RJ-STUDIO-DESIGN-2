<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/about-studio', 'about-studio')->name('about-studio');
Route::view('/portfolio', 'portfolio')->name('portfolio');
Route::view('/services', 'services')->name('services');


//Client Route
Route::get('/client/home', function () {
    return view('client.home');
})->middleware(['auth', 'verified'])->name('home');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
