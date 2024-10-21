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
Route::get('/resources', [ResourceController::class, 'index']);
Route::get('/resources/{id}', [ResourceController::class, 'show']);

Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users', [UserController::class, 'index']); // Affiche tous les utilisateurs
Route::get('/users/{id}', [UserController::class, 'show']);

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

Route::get('/role-users', [RoleUserController::class, 'index']);  // Afficher tous les role_users
Route::get('/role-users/{id}', [RoleUserController::class, 'show']);  // Afficher un role_user spécifique
Route::post('/role-users', [RoleUserController::class, 'store']);  // Créer un role_user
Route::put('/role-users/{id}', [RoleUserController::class, 'update']);  // Mettre à jour un role_user
Route::delete('/role-users/{id}', [RoleUserController::class, 'destroy']);  // Supprimer un role_user

Route::get('/roles', [RoleController::class, 'index']); // Afficher tous les rôles
Route::post('/roles', [RoleController::class, 'store']); // Créer un nouveau rôle
Route::get('/roles/{id}', [RoleController::class, 'show']); // Afficher un rôle spécifique
Route::put('/roles/{id}', [RoleController::class, 'update']); // Mettre à jour un rôle
Route::delete('/roles/{id}', [RoleController::class, 'destroy']); // Supprimer un rôle

Route::get('/pdfs', [PdfController::class, 'index']); // Afficher tous les PDF
Route::get('/pdfs/{id}', [PdfController::class, 'show']); // Afficher un PDF spécifique