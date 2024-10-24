<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use App\Models\Resource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleUserController extends Controller
{
    public function index()
    {
        // Charger les relations user, role et resources
        $roleUsers = RoleUser::with(['user', 'role', 'resources'])->get();

        return response()->json($roleUsers);
    }

    public function show($id)
    {
        // Récupérer le RoleUser spécifique
        $roleUser = RoleUser::with(['user', 'role', 'resources'])->findOrFail($id);

        return response()->json($roleUser);
    }

    public function store(Request $request)
    {
        // Valider les données d'entrée
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Créer le RoleUser
        $roleUser = RoleUser::create($request->all());

        // Charger les relations après création
        $roleUser->load(['user', 'role', 'resources']);

        return response()->json($roleUser, 201);
    }

    public function update(Request $request, $id)
    {
        // Valider les données d'entrée
        $validator = Validator::make($request->all(), [
            'role_id' => 'sometimes|exists:roles,id',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Récupérer le RoleUser
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->update($request->all());

        // Recharger les relations après mise à jour
        $roleUser->load(['user', 'role', 'resources']);

        return response()->json($roleUser, 200);
    }

    public function destroy($id)
    {
        // Supprimer le RoleUser
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->delete();

        return response()->json(null, 204);
    }

    public function attachResources(Request $request, $id)
    {
        // Valider les IDs de ressources
        $request->validate([
            'resource_ids' => 'required|array',
            'resource_ids.*' => 'exists:resources,id', // Vérifie que chaque ressource existe
        ]);

        // Récupérer le RoleUser
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->resources()->attach($request->input('resource_ids'));

        // Recharger les relations après attachement
        $roleUser->load(['user', 'role', 'resources']);

        return response()->json([
            'message' => 'Resources attached successfully.',
            'role_user' => $roleUser,
        ], 200);
    }

    public function detachResources(Request $request, $id)
    {
        // Valider les IDs de ressources
        $request->validate([
            'resource_ids' => 'required|array',
            'resource_ids.*' => 'exists:resources,id', // Vérifie que chaque ressource existe
        ]);

        // Récupérer le RoleUser
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->resources()->detach($request->input('resource_ids'));

        // Recharger les relations après détachement
        $roleUser->load(['user', 'role', 'resources']);

        return response()->json($roleUser, 200);
    }

    public function attachRole(Request $request, $id)
    {
        // Valider les données
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Récupérer le RoleUser
        $roleUser = RoleUser::findOrFail($id);

        // Associer le rôle
        $roleUser->role()->associate($request->role_id);
        $roleUser->save();

        // Recharger les relations après association
        $roleUser->load(['user', 'role', 'resources']);

        return response()->json($roleUser, 200);
    }

    public function detachRole(Request $request, $id)
    {
        // Récupérer le RoleUser
        $roleUser = RoleUser::findOrFail($id);

        // Détacher le rôle
        $roleUser->role()->dissociate();
        $roleUser->save();

        // Recharger les relations après détachement
        $roleUser->load(['user', 'role', 'resources']);

        return response()->json($roleUser, 200);
    }
}
