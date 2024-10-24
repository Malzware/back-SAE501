<?php 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; // Pour la validation
use App\Models\User; // Assurez-vous d'importer le modèle User

class AuthController extends Controller
{
    /**
     * Connecter un utilisateur.
     */
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('authToken')->plainTextToken;

    // Récupérer tous les rôles associés à l'utilisateur
    $roles = $user->roles->pluck('name')->toArray(); 

    return response()->json([
        'token' => $token,
        'roles' => $roles
    ]);
}

    /**
     * Déconnecter un utilisateur.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Déconnexion réussie'], 200);
    }

    /**
     * Enregistrer un nouvel utilisateur.
     */
    public function register(Request $request)
    {
        try {
            // Valider les données
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Créer un nouvel utilisateur
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password), // Hacher le mot de passe
            ]);

            // Authentifier l'utilisateur après l'enregistrement
            Auth::login($user);

            return response()->json(['message' => 'Utilisateur enregistré et connecté'], 201);
        } catch (\Exception $e) {
            // Gérer les exceptions et retourner une erreur
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
