<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    public function index()
    {
        $roleUsers = RoleUser::all(); // Assurez-vous que les données existent dans la table
        return response()->json($roleUsers);
    }

    public function show($id)
    {
        $roleUser = RoleUser::findOrFail($id);
        return response()->json($roleUser);
    }

    public function store(Request $request)
    {
        $roleUser = RoleUser::create($request->all());
        return response()->json($roleUser, 201);
    }

    public function update(Request $request, $id)
    {
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->update($request->all());
        return response()->json($roleUser, 200);
    }

    public function destroy($id)
    {
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->delete();
        return response()->json(null, 204);
    }
}