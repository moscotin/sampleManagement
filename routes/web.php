<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WaferController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\FabricationStepController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('wafers', WaferController::class);
    Route::resource('samples', SampleController::class);
    Route::post('samples/{sample}/images', [App\Http\Controllers\SampleImageController::class, 'store'])->name('sample-images.store');
    Route::delete('sample-images/{sampleImage}', [App\Http\Controllers\SampleImageController::class, 'destroy'])->name('sample-images.destroy');
    Route::get('samples/{sample}/fabrication-steps/create', [FabricationStepController::class, 'create'])->name('fabrication-steps.create');
    Route::post('samples/{sample}/fabrication-steps', [FabricationStepController::class, 'store'])->name('fabrication-steps.store');
    Route::get('fabrication-steps/{fabricationStep}/edit', [FabricationStepController::class, 'edit'])->name('fabrication-steps.edit');
    Route::put('fabrication-steps/{fabricationStep}', [FabricationStepController::class, 'update'])->name('fabrication-steps.update');
    Route::delete('fabrication-steps/{fabricationStep}', [FabricationStepController::class, 'destroy'])->name('fabrication-steps.destroy');
});

require __DIR__.'/auth.php';
