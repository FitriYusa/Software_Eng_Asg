<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportFaultController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TechnicianDashboardController;
use App\Models\FaultReport;
use App\Models\Classroom;

use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'technician') {
        return redirect()->route('technician.dashboard');
    }

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // default student/user dashboard
    $faults = FaultReport::where('user_id', $user->id)
                ->latest()
                ->paginate(5);

    $classrooms = Classroom::all();
    $equipments = \App\Models\Equipment::with('classroom')->get();

    return view('dashboard', compact('faults', 'classrooms','equipments'));
})->middleware(['auth', 'verified'])->name('dashboard');



Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/', function () {
    return view('welcome1');
})->name('welcome1');

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/report-fault', [ReportFaultController::class, 'create'])->name('report_fault.create');
    Route::post('/report-fault', [ReportFaultController::class, 'store'])->name('report_fault.store');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // or wherever you want to redirect after logout
})->name('logout');


Route::middleware(['auth', 'verified'])->group(function () {
    // Technician Dashboard
    Route::get('technician_dashboard', [TechnicianDashboardController::class, 'index'])
        ->name('technician.dashboard');

    // Update Task Status
    Route::post('/technician/update-status/{id}', [TechnicianDashboardController::class, 'updateStatus'])
        ->name('technician.updateStatus');
});


Route::middleware(['auth'])->group(function () {
    Route::get('admin_dashboard', [AdminDashboardController::class, 'admin_controller'])->name('admin.dashboard');
});



require __DIR__.'/auth.php';
