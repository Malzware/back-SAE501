<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ResourceController extends Controller
{
    /**
     * Affiche toutes les ressources avec leurs semestres.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        // Charger les ressources avec leurs relations 'semester'
        $resources = Resource::with('semester')->get();

        return response()->json($resources);
    }

    /**
     * Affiche une ressource spécifique avec son semestre.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        // Charger une ressource avec son semestre
        $resource = Resource::with('semester')->findOrFail($id);

        return response()->json($resource);
    }

    /**
     * Gère la soumission du formulaire pour ajouter une nouvelle ressource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'resource_code' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'id_semester' => 'required|integer|exists:semesters,id',
            'cm' => 'nullable|integer',
            'td' => 'nullable|integer',
            'tp' => 'nullable|integer',
            'national_total' => 'nullable|integer',
            'national_tp' => 'nullable|integer',
            'adapt' => 'nullable|integer',
            'adapt_tp' => 'nullable|integer',
            'projet_ne' => 'nullable|integer',
            'projet_e' => 'nullable|integer',
            'comment' => 'nullable|string',
        ]);

        $resource = Resource::create($validatedData);

        return response()->json(['success' => true, 'resource' => $resource], 201);
    }

    /**
     * Met à jour une ressource existante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $resource = Resource::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'resource_code' => 'sometimes|required|string|max:255',
            'title' => 'sometimes|required|string|max:255',
            'id_semester' => 'sometimes|required|integer|exists:semesters,id',
            'cm' => 'sometimes|nullable|integer',
            'td' => 'sometimes|nullable|integer',
            'tp' => 'sometimes|nullable|integer',
            'national_total' => 'nullable|integer',
            'national_tp' => 'nullable|integer',
            'adapt' => 'nullable|integer',
            'adapt_tp' => 'nullable|integer',
            'projet_ne' => 'nullable|integer',
            'projet_e' => 'nullable|integer',
            'comment' => 'nullable|string',
        ]);

        $resource->update($validatedData);

        return response()->json(['success' => true, 'resource' => $resource]);
    }

    /**
     * Supprime une ressource spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $resource = Resource::findOrFail($id);
        
        // Supprimer la ressource elle-même
        $resource->delete();

        return response()->json(['success' => true]);
    }
}
