<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GivenHoursController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\PdfController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('resources')->group(function () {
    Route::get('/', [ResourceController::class, 'index'])->name('resources.index');
    Route::post('/', [ResourceController::class, 'store'])->name('resources.store');
    Route::get('/{id}', [ResourceController::class, 'show'])->name('resources.show');
    Route::put('/{id}', [ResourceController::class, 'update'])->name('resources.update'); // Assurez-vous que c'est 'update', pas 'updatePost'
    Route::delete('/{id}', [ResourceController::class, 'destroy'])->name('resources.destroy');
    Route::post('/{id}/users', [ResourceController::class, 'addUserToResource'])->name('resources.addUser');
    Route::get('/{id}/users', [ResourceController::class, 'getUsersFromResource'])->name('resources.getUsers');
    Route::delete('/{id}/users', [ResourceController::class, 'removeUserFromResource']);
    Route::put('/{id}/users/{userId}/given-hours', [ResourceController::class, 'updateUserGivenHours'])->name('resources.updateGivenHours');
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});


Route::get('/given-hours', [GivenHoursController::class, 'index']); // Afficher toutes les heures données
Route::post('/given-hours', [GivenHoursController::class, 'store']); // Créer une nouvelle entrée d'heures données
Route::get('/given-hours/{id}', [GivenHoursController::class, 'show']); // Afficher une entrée d'heures données spécifique
Route::put('/given-hours/{id}', [GivenHoursController::class, 'update']); // Mettre à jour une entrée d'heures données
Route::delete('/given-hours/{id}', [GivenHoursController::class, 'destroy']); // Supprimer une entrée d'heures données

Route::get('/semesters', [SemesterController::class, 'index']); // Afficher tous les semestres
Route::post('/semesters', [SemesterController::class, 'store']); // Créer un nouveau semestre
Route::get('/semesters/{id}', [SemesterController::class, 'show']); // Afficher un semestre spécifique
Route::put('/semesters/{id}', [SemesterController::class, 'update']); // Mettre à jour un semestre
Route::delete('/semesters/{id}', [SemesterController::class, 'destroy']); // Supprimer un semestre

// Afficher tous les RoleUsers
Route::get('/role-users', [RoleUserController::class, 'index']);
// Afficher un RoleUser spécifique
Route::get('/role-users/{id}', [RoleUserController::class, 'show']);
// Créer un RoleUser
Route::post('/role-users', [RoleUserController::class, 'store']);
// Mettre à jour un RoleUser
Route::put('/role-users/{id}', [RoleUserController::class, 'update']);
// Supprimer un RoleUser
Route::delete('/role-users/{id}', [RoleUserController::class, 'destroy']);
// Attacher une ressource à un RoleUser
Route::post('/role-users/{id}/attach-resource', [RoleUserController::class, 'attachResource']);
// Détacher une ressource d'un RoleUser
Route::post('/role-users/{id}/detach-resource', [RoleUserController::class, 'detachResource']);

Route::get('/roles', [RoleController::class, 'index']); // Afficher tous les rôles
Route::post('/roles', [RoleController::class, 'store']); // Créer un nouveau rôle
Route::get('/roles/{id}', [RoleController::class, 'show']); // Afficher un rôle spécifique
Route::put('/roles/{id}', [RoleController::class, 'update']); // Mettre à jour un rôle
Route::delete('/roles/{id}', [RoleController::class, 'destroy']); // Supprimer un rôle

Route::get('/pdfs', [PdfController::class, 'index']); // Afficher tous les PDF
Route::get('/pdfs/{id}', [PdfController::class, 'show']); // Afficher un PDF spécifique