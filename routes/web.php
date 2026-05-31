<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/up', function () {
    return response('OK', 200);
});

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('home');
    }

    $featuredProjects = \App\Models\Project::where('category', 'Design')
        ->latest()
        ->take(3)
        ->get();
    return view('welcome', compact('featuredProjects'));
});

Route::view('/about-studio', 'about-studio')->name('about-studio');
Route::view('/services', 'services')->name('services');

Route::get('/portfolio', [ProjectController::class, 'index'])->name('portfolio');
Route::get('/portfolio/{project}', [ProjectController::class, 'show'])->name('portfolio.show');


// Shared Auth Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    
    Route::get('/support', function() {
        return view('support.index');
    })->name('support');
});

//Client Route
Route::middleware(['auth', 'verified', 'client'])->group(function () {
    Route::get('/client/dashboard', function () {
        // Get the logged-in user's appointments
        $appointments = Auth::user()->appointments()->orderBy('appointment_date', 'asc')->get();
        $recentProjects = \App\Models\Project::latest()->take(3)->get();
        
        return view('client.home', compact('appointments', 'recentProjects'));
    })->middleware(['auth', 'verified'])->name('home');

    Route::get('/my-appointments', function () {
        // Get only the current user's appointments using the relationship we built
        $appointments = Auth::user()->appointments()->latest('appointment_date')->get();
        
        return view('client.appointments', compact('appointments'));
    })->middleware(['auth', 'verified'])->name('client.appointments');

    Route::get('/client/calendar', [AppointmentController::class, 'clientCalendar'])->name('client.calendar.index');

    Route::get('/client/portfolio', [ProjectController::class, 'portalIndex'])->name('client.portfolio');

    // Appointment Booking Routes
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
});


// Admin Route Group
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $totalUsers = \App\Models\User::where('role', '!=', 'admin')->count();
        $totalProjects = \App\Models\Project::count();
        $totalAppointments = \App\Models\Appointment::count();
        $upcomingAppointments = \App\Models\Appointment::where('status', 'confirmed')->count();
        $declinedAppointments = \App\Models\Appointment::where('status', 'declined')->count();
        $latestAppointments = \App\Models\Appointment::latest()->take(5)->get();
        
        // Find if there's any pending or upcoming appointment
        $ongoingAppointment = \App\Models\Appointment::where('status', 'pending')
            ->orWhere('status', 'confirmed')
            ->latest('appointment_date')
            ->first();

        return view('admin.dashboard', compact('totalUsers', 'totalProjects', 'totalAppointments', 'upcomingAppointments', 'declinedAppointments', 'latestAppointments', 'ongoingAppointment'));
    })->name('admin.dashboard');

    // --- Appointment Management Routes ---
    Route::get('/admin/appointments', [AppointmentController::class, 'index'])->name('admin.appointments.index');
    Route::get('/admin/calendar', [AppointmentController::class, 'calendar'])->name('admin.calendar.index');
    Route::patch('/admin/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('admin.appointments.confirm');
    Route::get('/admin/schedule', [\App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('admin.schedule.index');
    Route::post('/admin/schedule', [\App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('admin.schedule.update');

    // --- Client Management Routes ---
    Route::get('/admin/clients', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.clients.index');

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

    // Financial Overview (Dedicated Construction Projects)
    Route::get('/admin/budgets', [\App\Http\Controllers\Admin\ConstructionProjectController::class, 'index'])->name('admin.budgets.index');
    Route::post('/admin/budgets', [\App\Http\Controllers\Admin\ConstructionProjectController::class, 'store'])->name('admin.budgets.store');
    Route::get('/admin/budgets/{project}', [\App\Http\Controllers\Admin\ConstructionProjectController::class, 'show'])->name('admin.budgets.show');
    Route::patch('/admin/budgets/{project}/update', [\App\Http\Controllers\Admin\ConstructionProjectController::class, 'update'])->name('admin.budgets.update');
    Route::delete('/admin/budgets/{project}', [\App\Http\Controllers\Admin\ConstructionProjectController::class, 'destroy'])->name('admin.budgets.destroy');

    // --- Material Management Routes ---
    Route::resource('/admin/materials', \App\Http\Controllers\Admin\MaterialController::class)->names('admin.materials');

    // --- Project Cost Management Routes ---
    Route::post('/admin/projects/{project}/costs', [\App\Http\Controllers\Admin\ProjectCostController::class, 'store'])->name('admin.projects.costs.store');
    Route::get('/admin/projects/{project}/costs', function(\App\Models\ConstructionProject $project) {
        return redirect()->route('admin.budgets.show', $project);
    });
    // Project Labor Costs
    Route::get('/admin/labors', [\App\Http\Controllers\Admin\ProjectLaborController::class, 'index'])->name('admin.labors.index');
    Route::post('/admin/projects/{project}/labors', [\App\Http\Controllers\Admin\ProjectLaborController::class, 'store'])->name('admin.projects.labors.store');
    Route::patch('/admin/labors/{labor}', [\App\Http\Controllers\Admin\ProjectLaborController::class, 'update'])->name('admin.labors.update');
    Route::delete('/admin/labors/{labor}', [\App\Http\Controllers\Admin\ProjectLaborController::class, 'destroy'])->name('admin.labors.destroy');

    Route::patch('/admin/costs/{cost}', [\App\Http\Controllers\Admin\ProjectCostController::class, 'update'])->name('admin.costs.update');
    Route::delete('/admin/costs/{cost}', [\App\Http\Controllers\Admin\ProjectCostController::class, 'destroy'])->name('admin.costs.destroy');

    // Project Expenses (Miscellaneous)
    Route::post('/admin/projects/{project}/expenses', [\App\Http\Controllers\Admin\ProjectExpenseController::class, 'store'])->name('admin.projects.expenses.store');
    Route::patch('/admin/expenses/{expense}', [\App\Http\Controllers\Admin\ProjectExpenseController::class, 'update'])->name('admin.expenses.update');
    Route::delete('/admin/expenses/{expense}', [\App\Http\Controllers\Admin\ProjectExpenseController::class, 'destroy'])->name('admin.expenses.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
