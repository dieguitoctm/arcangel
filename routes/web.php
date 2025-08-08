<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscripcionController;

// Página de bienvenida
Route::get('/', [InscripcionController::class, 'bienvenida'])->name('inscripcion.bienvenida');

// Formulario de inscripción
Route::get('/formulario', [InscripcionController::class, 'formulario'])->name('inscripcion.formulario');

// Guardar datos del formulario
Route::post('/guardar', [InscripcionController::class, 'guardar'])->name('inscripcion.guardar');

// Página de despedida tras registro exitoso
Route::get('/despedida', [InscripcionController::class, 'despedida'])->name('inscripcion.despedida');

// Rutas para administración (CRUD de usuarios)
Route::get('/admin', [InscripcionController::class, 'index'])->name('admin.index');
Route::get('/admin/{usuario}/edit', [InscripcionController::class, 'edit'])->name('admin.edit');
Route::put('/admin/{usuario}', [InscripcionController::class, 'update'])->name('admin.update');
Route::delete('/admin/{usuario}', [InscripcionController::class, 'destroy'])->name('admin.destroy');
