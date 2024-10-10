<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    public function index()
    {
        // Charger les relations user, role, et resource
        $roleUsers = RoleUser::with(['user', 'role', 'resource'])->get();
        return response()->json($roleUsers);
    }

    public function show($id)
    {
        // Charger les relations user, role, et resource pour un seul enregistrement
        $roleUser = RoleUser::with(['user', 'role', 'resource'])->findOrFail($id);
        return response()->json($roleUser);
    }

    public function store(Request $request)
    {
        $roleUser = RoleUser::create($request->all());
        
        // Charger les relations après création
        $roleUser->load(['user', 'role', 'resource']);

        return response()->json($roleUser, 201);
    }

    public function update(Request $request, $id)
    {
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->update($request->all());

        // Recharger les relations après mise à jour
        $roleUser->load(['user', 'role', 'resource']);

        return response()->json($roleUser, 200);
    }

    public function destroy($id)
    {
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->delete();

        return response()->json(null, 204);
    }
}
