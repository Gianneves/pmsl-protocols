<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProtocolsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DepartamentsController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PdfController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Redirect::route('login');
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
    Route::get('pdf/protocolPdf', [PdfController::class, 'protocolPdf'])->name('pdf.protocolPdf');
    Route::get('pdf/{id}/', [PdfController::class, 'attendancePdf'])->name('pdf.attendancePdf');
    Route::resource('audit', AuditController::class);
    Route::delete('protocols/{protocol}/files/{fileName}', [ProtocolsController::class, 'deleteFile'])->name('protocols.deleteFile');
});

require __DIR__ . '/auth.php';
