<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Http\Requests\StoreclientRequest;
use App\Http\Requests\UpdateclientRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Ouvrier-Express",
 *     version="1.0.0",
 *     description="Application de gestion de relation prestataire-client"
 * )
 */
class ClientController extends Controller
{

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/ajouterclient",
     *     tags={"Profil client"},
     *     summary="Ajouter profil client",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="user_id", type="string"),
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="création profil reussie",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function store(StoreclientRequest $request)
    {
        // Récupérer l'identifiant de l'utilisateur à partir du champ user_id du formulaire
        $user_id = $request->user_id;

        // Trouver l'utilisateur avec cet identifiant et charger sa relation avec le client
        $user = User::with('client')->find($user_id);

        // Vérifier si l'utilisateur existe et a le rôle de client
        if ($user && $user->role('client')) {
            // Créer un nouveau client avec les données du formulaire
            $client = new Client();

            // Associer le client à l'utilisateur
            $client->user_id = $user->id;

            // Récupérer les autres champs de l'utilisateur et les mettre dans le client
            $client->nom = $user->nom;
            $client->prenom = $user->prenom;
            $client->tel = $user->tel;
            $client->adress = $user->adress;
            $client->login = $user->login;


            // Enregistrer le client dans la base de données
            $client->save();

            // Retourner une réponse JSON avec le client créé
            return response()->json(['message' => 'Client ajouté avec succès', 'data' => $client]);
        } else {
            // Retourner une erreur
            return response()->json(['message' => 'L\'utilisateur n\'existe pas ou n\'a pas le rôle de client'], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(client $client)
    {
        return response()->json($client);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateclientRequest $request, client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(client $client)
    {
        //
    }
}
