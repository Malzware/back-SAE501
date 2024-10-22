<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    // Affiche tous les utilisateurs.
    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json($users);
    }

    // Affiche un utilisateur spécifique.
    public function show($id): JsonResponse
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Gère la soumission du formulaire pour ajouter un nouvel utilisateur.
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        return response()->json(['success' => true, 'user' => $user], 201);
    }

    // Met à jour un utilisateur existant.
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'lastname' => 'sometimes|required|string|max:255',
            'firstname' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);
        

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json(['success' => true, 'user' => $user]);
    }

    // Supprime un utilisateur spécifique.
    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true]);
    }
}
