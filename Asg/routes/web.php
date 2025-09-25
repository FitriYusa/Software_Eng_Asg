<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportFaultController;
// Route::view('/', 'welcome1');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/', function () {
    return view('welcome1');
})->name('welcome1');

Route::middleware(['auth'])->group(function () {
    Route::get('/report-fault', [ReportFaultController::class, 'create'])->name('report_fault.create');
    Route::post('/report-fault', [ReportFaultController::class, 'store'])->name('report_fault.store');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // or wherever you want to redirect after logout
})->name('logout');


require __DIR__.'/auth.php';
