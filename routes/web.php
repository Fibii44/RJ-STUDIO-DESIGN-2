<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/about-studio', 'about-studio')->name('about-studio');
Route::view('/services', 'services')->name('services');

// Change Route::view to Route::get
Route::get('/portfolio', [ProjectController::class, 'index'])->name('portfolio');


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
    Route::delete('/admin/portfolio/image/{image}', [ProjectController::class, 'destroyImage'])->name('admin.portfolio.image.destroy');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    
});


// Admin Route Group
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // --- Portfolio Management Routes ---
    Route::get('/admin/portfolio', [ProjectController::class, 'adminIndex'])->name('admin.portfolio.index');
    Route::post('/admin/portfolio', [ProjectController::class, 'store'])->name('admin.portfolio.store');
    
    // Inside Admin Route Group
    Route::patch('/admin/portfolio/{project}', [ProjectController::class, 'update'])->name('admin.portfolio.update');
    
    // NEW: Add images to an existing bundle
    Route::post('/admin/portfolio/{project}/add-images', [ProjectController::class, 'addImages'])->name('admin.portfolio.add-images');
    
    // Delete entire project
    Route::delete('/admin/portfolio/{project}', [ProjectController::class, 'destroy'])->name('admin.portfolio.destroy');
    
    // Delete specific image from bundle
    Route::delete('/admin/portfolio/image/{image}', [ProjectController::class, 'destroyImage'])->name('admin.portfolio.image.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
