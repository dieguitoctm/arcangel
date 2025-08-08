<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\MenorController;

// Página de bienvenida (inicio)
Route::get('/', [InscripcionController::class, 'bienvenida'])->name('inscripcion.bienvenida');

// Formulario de inscripción principal
Route::get('/formulario', [InscripcionController::class, 'formulario'])->name('inscripcion.formulario');
Route::post('/guardar', [InscripcionController::class, 'guardar'])->name('inscripcion.guardar');

// Página despedida tras registro exitoso
Route::get('/despedida', [InscripcionController::class, 'despedida'])->name('inscripcion.despedida');

// Rutas para administración (CRUD de usuarios)
Route::get('/admin', [InscripcionController::class, 'index'])->name('admin.index');
Route::get('/admin/{usuario}/edit', [InscripcionController::class, 'edit'])->name('admin.edit');
Route::put('/admin/{usuario}', [InscripcionController::class, 'update'])->name('admin.update');
Route::delete('/admin/{usuario}', [InscripcionController::class, 'destroy'])->name('admin.destroy');

// Flujo inscripción (opcional duplicado, si quieres separar rutas con prefijo)
Route::prefix('inscripcion')->group(function () {
    Route::get('/bienvenida', [InscripcionController::class, 'bienvenida'])->name('inscripcion.bienvenida');
    Route::get('/formulario', [InscripcionController::class, 'formulario'])->name('inscripcion.formulario');
    Route::post('/guardar', [InscripcionController::class, 'guardar'])->name('inscripcion.guardar');

    // Registro de menores ligados a un usuario (tutor)
    Route::get('/menor/{usuario_id}', [MenorController::class, 'formulario'])->name('menor.formulario');
    Route::post('/menor/{usuario_id}', [MenorController::class, 'guardar'])->name('menor.guardar');

    Route::get('/despedida', [InscripcionController::class, 'despedida'])->name('inscripcion.despedida');
});
