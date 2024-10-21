<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use App\Models\Semester; // Ajoute cette ligne
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class ResourceController extends Controller
{
    /**
     * Affiche toutes les ressources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
{
    $successMessage = session('success'); 
    // Récupère toutes les ressources avec la relation vers le semestre
    $resources = Resource::with('semester')->get();
    $semesters = Semester::all(); // Ajout pour récupérer tous les semestres
    return view('resources.index', compact('resources', 'semesters'));
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

    public function create()
    {
        // Récupère tous les semestres pour les afficher dans le formulaire
        $semesters = Semester::all();
        return view('resources.create', compact('semesters'));
    }

    // Gère la soumission du formulaire pour ajouter une nouvelle ressource
    public function store(Request $request)
    {

        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'resource_code' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'id_semester' => 'required|integer|exists:semesters,id',
            'cm' => 'nullable|integer',
            'td' => 'nullable|integer',
            'tp' => 'nullable|integer',
            'national_total' => 'nullable|integer', // Ajouté
            'national_tp' => 'nullable|integer', // Ajouté
            'adapt' => 'nullable|integer', // Ajouté
            'adapt_tp' => 'nullable|integer', // Ajouté
            'projet_ne' => 'nullable|integer', // Ajouté
            'projet_e' => 'nullable|integer', // Ajouté
            'comment' => 'nullable|string', // Commentaire déjà présent
        ]);
    
        // Création de la ressource dans la base de données
        Resource::create($validatedData);
    
        // Redirection avec un message de succès
        return redirect('/resources')->with('success', 'Ressource ajoutée avec succès');
    }
    public function update(Request $request, $id): JsonResponse
{
    $resource = Resource::findOrFail($id);

    // Validation des données
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'resource_code' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'id_semester' => 'required|integer|exists:semesters,id',
        'cm' => 'nullable|integer',
        'td' => 'nullable|integer',
        'tp' => 'nullable|integer',
        // Ajoutez d'autres champs selon vos besoins
    ]);

    // Mise à jour de la ressource
    $resource->update($validatedData);

    return response()->json(['success' => true]);
}
}    