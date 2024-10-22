<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    public function index()
    {
        // Charger les relations user, role, resource et resource.givenHours
        $roleUsers = RoleUser::with(['user', 'role', 'resource.givenHours'])->get();

        // Initialiser un tableau pour regrouper les données par user_id
        $groupedRoleUsers = [];

        foreach ($roleUsers as $roleUser) {
            $userId = $roleUser->user_id;

            // Si le user_id n'existe pas dans le tableau, l'initialiser
            if (!isset($groupedRoleUsers[$userId])) {
                $groupedRoleUsers[$userId] = [
                    'id' => $roleUser->id, // Conserver l'id du premier RoleUser
                    'user_id' => $userId,
                    'role_id' => $roleUser->role_id,
                    'created_at' => $roleUser->created_at,
                    'updated_at' => $roleUser->updated_at,
                    'user' => $roleUser->user,
                    'role' => $roleUser->role,
                    'resources' => [], // Utiliser un tableau pour stocker les ressources
                ];
            }

            // Ajouter la ressource à la liste des ressources pour cet utilisateur
            $groupedRoleUsers[$userId]['resources'][] = $roleUser->resource;
        }

        // Convertir le tableau associatif en tableau d'objets
        $result = array_values($groupedRoleUsers);

        // Calculer les total heures pour chaque ressource
        foreach ($result as &$user) {
            foreach ($user['resources'] as &$resource) {
                // Vérifie si 'given_hours' existe et n'est pas vide
                if (!empty($resource->givenHours)) {
                    $resource->total_hours = $this->calculateTotalHours($resource->givenHours); // Calcule le total
                } else {
                    // Initialise 'total_hours' à zéro si 'given_hours' est vide
                    $resource->total_hours = [
                        'hours_cm' => 0,
                        'hours_td' => 0,
                        'hours_tp' => 0,
                    ];
                }
            }
        }

        return response()->json($result);
    }

    public function show($id)
    {
        // Récupérer le RoleUser spécifique
        $roleUser = RoleUser::with(['user', 'role', 'resource.givenHours'])
            ->findOrFail($id);

        // Récupérer toutes les ressources associées au user_id
        $resources = RoleUser::with(['resource.givenHours'])
            ->where('user_id', $roleUser->user_id)
            ->get()
            ->pluck('resource'); // Extraire uniquement les ressources

        return response()->json([
            'id' => $roleUser->id,
            'user_id' => $roleUser->user_id,
            'role_id' => $roleUser->role_id,
            'created_at' => $roleUser->created_at,
            'updated_at' => $roleUser->updated_at,
            'user' => $roleUser->user,
            'role' => $roleUser->role,
            'resources' => $resources // Renvoie toutes les ressources associées
        ]);
    }

    public function store(Request $request)
    {
        $roleUser = RoleUser::create($request->all());

        // Charger les relations après création
        $roleUser->load(['user', 'role', 'resource.givenHours']);

        return response()->json($roleUser, 201);
    }

    public function update(Request $request, $id)
    {
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->update($request->all());

        // Recharger les relations après mise à jour
        $roleUser->load(['user', 'role', 'resource.givenHours']);

        return response()->json($roleUser, 200);
    }

    public function destroy($id)
    {
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->delete();

        return response()->json(null, 204);
    }

    private function calculateTotalHours($givenHours)
    {
        $total = [
            'hours_cm' => 0,
            'hours_td' => 0,
            'hours_tp' => 0,
        ];

        foreach ($givenHours as $hour) {
            $total['hours_cm'] += $hour->hours_cm; // Additionne les heures CM
            $total['hours_td'] += $hour->hours_td; // Additionne les heures TD
            $total['hours_tp'] += $hour->hours_tp; // Additionne les heures TP
        }

        return $total; // Retourne le total
    }
}
