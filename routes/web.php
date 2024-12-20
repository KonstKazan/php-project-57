<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskStatusController;


Route::get('/', static function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('task_statuses', TaskStatusController::class)
    ->names([
        'store' => 'status.create',
        'create' => 'status.build',
        'edit' => 'status.edit',
        'update' => 'status.update',
        'destroy' => 'status.destroy',
        'index' => 'status.index'
    ]);

require __DIR__.'/auth.php';
