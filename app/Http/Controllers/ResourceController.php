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
        // Récupère toutes les ressources avec les heures données
        return response()->json(Resource::all()->map(function ($resource) {
            return [
                'id' => $resource->id,
                'name' => $resource->name,
                'resource_code' => $resource->resource_code,
                'title' => $resource->title,
                'id_semester' => $resource->id_semester,
                'national_total' => $resource->national_total,
                'national_tp' => $resource->national_tp,
                'adapt' => $resource->adapt,
                'adapt_tp' => $resource->adapt_tp,
                'projet_ne' => $resource->projet_ne,
                'projet_e' => $resource->projet_e,
                'comment' => $resource->comment,
                'semester' => $resource->semester,
                'given_hours' => GivenHour::where('resource_id', $resource->id)->first(),
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
        // Récupérer la ressource spécifique avec ses heures données
        $resource = Resource::findOrFail($id);
        $givenHours = GivenHour::where('resource_id', $resource->id)->first();

        return response()->json([
            'id' => $resource->id,
            'name' => $resource->name,
            'resource_code' => $resource->resource_code,
            'title' => $resource->title,
            'id_semester' => $resource->id_semester,
            'national_total' => $resource->national_total,
            'national_tp' => $resource->national_tp,
            'adapt' => $resource->adapt,
            'adapt_tp' => $resource->adapt_tp,
            'projet_ne' => $resource->projet_ne,
            'projet_e' => $resource->projet_e,
            'comment' => $resource->comment,
            'semester' => $resource->semester,
            'given_hours' => $givenHours,
        ]);
    }
}
