<?php

namespace App\Http\Controllers\API;

use app\http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\prestataire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Ouvrier-Express",
 *     version="1.0.0",
 *     description="Application de gestion de relation prestataire-client"
 * )
 */



class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Connexion"},
     *     summary="Authentifier un utilisateur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur connecté avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="nom", type="string"),
     *                 @OA\Property(property="prenom", type="string"),
     *                 @OA\Property(property="tel", type="string"),
     *                 @OA\Property(property="adress", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="role", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Erreur d'authentification")
     * )
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Login u mot de passe incorrect',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Inscription"},
     *     summary="Ajouter un utilisateur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="nom", type="string"),
     *            @OA\Property(property="prenom", type="string"),
     *            @OA\Property(property="tel", type="string"),
     *            @OA\Property(property="adress", type="string"),
     *            @OA\Property(property="email", type="string"),
     *           @OA\Property(property="role", type="string"),
     *          @OA\Property(property="password", type="string"),
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Utilisateur ajouté avec succès",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'tel' => $request->tel,
            'adress' => $request->adress,
            'role' => $request->role,
            'email' => $request->email,
            // 'login' => $request->login,


            'password' => Hash::make($request->password),
        ]);
        if ($request->role == "client") {
            $client = new Client();
            $client->user_id = $user->id;
            $client->save();
        } elseif ($request->role == "prestataire") {
            $prestataire = new prestataire();
            $prestataire->user_id = $user->id;
            $prestataire->save();
        }
        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'data' => $user
        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Déconnexion"},
     *     summary="Se Déconnecter",
     *     security={"bearerAuth": {}},
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur déconnecté avec succès",
     *     ),
     * )
     */

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Utilisateur déconnecté avec succès',
        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     tags={"Connexion"},
     *     summary="Rafraîchir le token d'authentification",
     *     security={"bearerAuth": {}},
     *     @OA\Response(
     *         response=200,
     *         description="Token rafraîchi avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *         )
     *     ),
     *     @OA\Response(response=401, description="Erreur d'authentification")
     * )
     */

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
