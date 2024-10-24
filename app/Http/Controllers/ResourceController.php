<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ResourceController extends Controller
{
    /**
     * Affiche toutes les ressources avec leurs semestres et utilisateurs.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        // Charger les ressources avec leurs relations 'semester' et 'users'
        $resources = Resource::with(['semester', 'users'])->get();

        return response()->json($resources);
    }

    /**
     * Affiche une ressource spécifique avec son semestre et ses utilisateurs.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        // Charger une ressource avec son semestre, ses utilisateurs, et leurs heures données filtrées par resource_id
        $resource = Resource::with(['semester', 'users.givenHours' => function ($query) use ($id) {
            $query->where('resource_id', $id);
        }])->findOrFail($id);

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
        $resource->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Retire un utilisateur d'une ressource spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $resourceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeUserFromResource(Request $request, $resourceId): JsonResponse
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $resource = Resource::findOrFail($resourceId);

        // Supprimer l'association entre l'utilisateur et la ressource
        $resource->users()->detach($validatedData['user_id']);

        return response()->json(['message' => 'User removed from resource successfully']);
    }

    public function getUsersFromResource($resourceId): JsonResponse
    {
        $resource = Resource::with('users')->findOrFail($resourceId);
        return response()->json($resource->users);
    }
    public function updateUserGivenHours(Request $request, $resourceId, $userId): JsonResponse
    {
        // Valider les données d'entrée
        $validatedData = $request->validate([
            'hours_cm' => 'nullable|integer',
            'hours_td' => 'nullable|integer',
            'hours_tp' => 'nullable|integer',
            'comment'  => 'nullable|string|max:255',
        ]);

        // Trouver les heures données par utilisateur et ressource
        $givenHour = \App\Models\GivenHour::where('user_id', $userId)
            ->where('resource_id', $resourceId)
            ->first();

        if (!$givenHour) {
            return response()->json(['error' => 'Given hours not found for the specified user and resource.'], 404);
        }

        // Mettre à jour les heures données seulement si elles ont changé
        $hasChanged = true;
        // foreach ($validatedData as $key => $value) {
        //     // Vérifie si la propriété est définie dans les données validées
        //     if (array_key_exists($key, $validatedData) && $givenHour->$key != $value) {
        //         $hasChanged = true;
        //         break;
        //     }
        // }

        // Mettre à jour les heures données seulement si elles ont changé
        if ($hasChanged) {

            $newhours = $givenHour->update($validatedData);
            return response()->json(['success' => true, 'givenHour' => $givenHour]);
        } else {
            return response()->json(['success' => false, 'message' => 'No changes made.']);
        }
    }
}
