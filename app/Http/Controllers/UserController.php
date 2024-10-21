<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Ajout de l'importation pour Response
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Affiche toutes les utilisateurs.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index2(): \Illuminate\Contracts\View\View|Response
    {
        $successMessage = session('success'); 
        echo "blah".$successMessage."blih";
        $users = User::all(); // Récupère tous les utilisateurs
        return view('users.index', compact('users')); // Affiche la vue avec les utilisateurs
    }
    public function index()
    {
        $successMessage = session('success'); 
        // Récupère toutes les ressources avec la relation vers le semestre
        $resources = User::all();
        echo "blah".$successMessage."blih";
        // Retourne les données à une vue ou une réponse JSON
        return response()->json($resources);
    }

    /**
     * Affiche le formulaire de création d'un utilisateur.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(): \Illuminate\Contracts\View\View|Response
    {
        return view('users.create'); // Affiche le formulaire de création
    }


    public function show($id)
    {
        // Récupère la ressource spécifique avec la relation vers le semestre
       
        $users = User::all(); // Récupère tous les utilisateurs
        // Retourne les données à une vue ou une réponse JSON
        return response()->json($users);
    }

    /**
     * Gère la soumission du formulaire pour ajouter un nouvel utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Création de l'utilisateur dans la base de données
      //  $validatedData['password'] = bcrypt($validatedData['password']); // Hachage du mot de passe
        User::create($validatedData);

        // Redirection avec un message de succès
        return redirect('/users')->with('success', 'Utilisateur avec succès');
    }
}
