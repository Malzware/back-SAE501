<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\GivenHour;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Affiche toutes les ressources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupère toutes les ressources avec leurs heures données et met à jour les colonnes cm, td, tp
        return response()->json(Resource::with('givenHours')->get()->map(function ($resource) {
            $totalHours = $this->calculateTotalHours($resource->givenHours); // Calcule les heures totales

            // Met à jour les colonnes cm, td, tp de la ressource
            $resource->cm = $totalHours['hours_cm'];
            $resource->td = $totalHours['hours_td'];
            $resource->tp = $totalHours['hours_tp'];
            $resource->save(); // Sauvegarde les nouvelles valeurs dans la table resource

            return [
                'id' => $resource->id,
                'name' => $resource->name,
                'resource_code' => $resource->resource_code,
                'title' => $resource->title,
                'id_semester' => $resource->id_semester,
                'cm' => $resource->cm, // heures CM calculées
                'td' => $resource->td, // heures TD calculées
                'tp' => $resource->tp, // heures TP calculées
                'national_total' => $resource->national_total,
                'national_tp' => $resource->national_tp,
                'adapt' => $resource->adapt,
                'adapt_tp' => $resource->adapt_tp,
                'projet_ne' => $resource->projet_ne,
                'projet_e' => $resource->projet_e,
                'comment' => $resource->comment,
                'semester' => $resource->semester,
                'given_hours' => $resource->givenHours, // Récupérer les heures données
            ];
        }));
    }

    /**
     * Affiche une ressource spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Récupère la ressource spécifique avec ses heures données
        $resource = Resource::with('givenHours')->findOrFail($id);

        // Calculer les heures totales pour cette ressource
        $totalHours = $this->calculateTotalHours($resource->givenHours);

        // Met à jour les colonnes cm, td, tp de la ressource
        $resource->cm = $totalHours['hours_cm'];
        $resource->td = $totalHours['hours_td'];
        $resource->tp = $totalHours['hours_tp'];
        $resource->save(); // Sauvegarde les nouvelles valeurs

        return response()->json([
            'id' => $resource->id,
            'name' => $resource->name,
            'resource_code' => $resource->resource_code,
            'title' => $resource->title,
            'id_semester' => $resource->id_semester,
            'cm' => $resource->cm, // heures CM calculées
            'td' => $resource->td, // heures TD calculées
            'tp' => $resource->tp, // heures TP calculées
            'national_total' => $resource->national_total,
            'national_tp' => $resource->national_tp,
            'adapt' => $resource->adapt,
            'adapt_tp' => $resource->adapt_tp,
            'projet_ne' => $resource->projet_ne,
            'projet_e' => $resource->projet_e,
            'comment' => $resource->comment,
            'semester' => $resource->semester,
            'given_hours' => $resource->givenHours, // heures données originales
        ]);
    }

    /**
     * Calculer les heures totales pour une collection de GivenHours
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $givenHours
     * @return array
     */
    private function calculateTotalHours($givenHours)
    {
        $total = [
            'hours_cm' => 0,
            'hours_td' => 0,
            'hours_tp' => 0,
        ];

        // Parcourir toutes les heures données pour les additionner
        foreach ($givenHours as $hour) {
            $total['hours_cm'] += $hour->hours_cm; // Additionne les heures CM
            $total['hours_td'] += $hour->hours_td; // Additionne les heures TD
            $total['hours_tp'] += $hour->hours_tp; // Additionne les heures TP
        }

        return $total; // Retourne le total
    }
}
