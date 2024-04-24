<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProtocolsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DepartamentsController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('person', PersonController::class)->middleware(HandlePrecognitiveRequests::class);
    Route::resource('protocols', ProtocolsController::class)->middleware(HandlePrecognitiveRequests::class);
    Route::resource('user', RegisteredUserController::class)->middleware(HandlePrecognitiveRequests::class);
    Route::resource('departaments', DepartamentsController::class)->middleware(HandlePrecognitiveRequests::class);
    Route::post('departaments/{departament}/permission', [DepartamentsController::class, 'grantPermission'])->name('departaments.permission');
    Route::delete('departaments/{departament}/permission/{access}', [DepartamentsController::class, 'deletePermission'])->name('departaments.deletePermission');
    Route::resource('attendances', AttendanceController::class)->middleware(HandlePrecognitiveRequests::class);
});

require __DIR__ . '/auth.php';
