<?php

namespace App\Http\Controllers;

use App\Models\Resource;
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
        // Récupère toutes les ressources avec la relation vers le semestre
        $resources = Resource::with('semester')->get();

        // Retourne les données à une vue ou une réponse JSON
        return response()->json($resources);
    }

    /**
     * Affiche une ressource spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Récupère la ressource spécifique avec la relation vers le semestre
        $resource = Resource::with('semester')->findOrFail($id);

        // Retourne les données à une vue ou une réponse JSON
        return response()->json($resource);
    }
}
