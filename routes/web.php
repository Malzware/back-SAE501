<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('resources', ResourceController::class);
Route::resource('users', UserController::class);
Route::put('/resources/{id}', [ResourceController::class, 'update']);

Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');

// Route pour afficher la liste des utilisateurs
//Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Route pour afficher le formulaire de création
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

// Route pour stocker un nouvel utilisateur
Route::post('/users', [UserController::class, 'store'])->name('users.store');