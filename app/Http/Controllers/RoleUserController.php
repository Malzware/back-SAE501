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
        // Charger les relations user, role et resource
        $roleUsers = RoleUser::with(['user', 'role', 'resource.givenHours'])->get();

        return response()->json($roleUsers);
    }

    public function show($id)
    {
        // Récupérer le RoleUser spécifique
        $roleUser = RoleUser::with(['user', 'role', 'resource.givenHours'])->findOrFail($id);

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
        $roleUser->load(['user', 'role', 'resource.givenHours']);

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
        $roleUser->load(['user', 'role', 'resource.givenHours']);

        return response()->json($roleUser, 200);
    }

    public function destroy($id)
    {
        // Supprimer le RoleUser
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->delete();

        return response()->json(null, 204);
    }

    public function attachResource(Request $request, $id)
    {
        // Valider la requête pour s'assurer que resource_id est présent et valide
        $request->validate([
            'resource_id' => 'required|exists:resources,id', // Vérifie que la ressource existe dans la base de données
        ]);

        // Récupérer le RoleUser par son ID
        $roleUser = RoleUser::findOrFail($id);

        // Assigner la ressource au RoleUser
        $roleUser->resource_id = $request->input('resource_id');
        $roleUser->save(); // Enregistrer les changements

        // Charger les relations pour la réponse
        $roleUser->load('user', 'role', 'resource');

        return response()->json([
            'message' => 'Resource attached successfully.',
            'role_user' => $roleUser,
        ], 200);
    }

    public function detachResource(Request $request, $id)
    {
        // Valider les données
        $validator = Validator::make($request->all(), [
            'resource_id' => 'required|exists:resources,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Récupérer le RoleUser
        $roleUser = RoleUser::findOrFail($id);

        // Vérifiez si la resource_id correspond à celle du RoleUser
        if ($roleUser->resource_id == $request->resource_id) {
            // Détacher la ressource en mettant resource_id à null
            $roleUser->resource_id = null;
            $roleUser->save(); // Enregistrer les changements
        } else {
            return response()->json([
                'message' => 'The specified resource is not attached to this RoleUser.'
            ], 400);
        }

        // Recharger les relations après détachement
        $roleUser->load(['user', 'role', 'resource.givenHours']);

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
        $roleUser->load(['user', 'role', 'resource.givenHours']);

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
        $roleUser->load(['user', 'role', 'resource.givenHours']);

        return response()->json($roleUser, 200);
    }
}