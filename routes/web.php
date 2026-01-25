<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/about-studio', 'about-studio')->name('about-studio');
Route::view('/portfolio', 'portfolio')->name('portfolio');
Route::view('/services', 'services')->name('services');


//Client Route
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/client/home', function () {
        // Get the logged-in user's appointments
        $appointments = Auth::user()->appointments()->orderBy('appointment_date', 'asc')->get();
        
        return view('client.home', compact('appointments'));
    })->middleware(['auth', 'verified'])->name('home');
    
    Route::get('/my-appointments', function () {
        // Get only the current user's appointments using the relationship we built
        $appointments = Auth::user()->appointments()->latest('appointment_date')->get();
        
        return view('client.appointments', compact('appointments'));
    })->middleware(['auth', 'verified'])->name('client.appointments');

    // Appointment Booking Routes
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    
});


// Admin Route Group
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // Create this blade file
    })->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
