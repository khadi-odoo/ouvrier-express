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

    public function store(StoreclientRequest $request)
    {
        // Récupérer l'identifiant de l'utilisateur à partir du champ user_id du formulaire
        //$user = auth()->user();
        // dd($user);


        // Vérifier si l'utilisateur existe et a le rôle de client
        //if ($user && $user->role == 'client') {
        // Créer un nouveau client avec les données du formulaire
        $client = new Client();

        // Associer le client à l'utilisateur
        $client->user_id = $request->user_id;

        // Enregistrer le client dans la base de données
        $client->save();

        // Retourner une réponse JSON avec le client créé
        return response()->json(['data' => $client]);
        //} else {
        // Retourner une erreur
        //     return response()->json(['message' => 'L\'utilisateur n\'existe pas ou n\'a pas le rôle de client'], 404);
        // }
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
     * @OA\Post(
     *     path="/api/modifClient/{client}",
     *     summary="Modifier ses coordonnées",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     tags={"Mis à jour client et archivage"}, 
     * 
     *         @OA\Parameter(
     *         name="client",
     *         in="path",
     *         required=true,
     *         description="Modification des coordonnées du client à partir de son id",
     *         @OA\Schema(type="integer")
     * ),    
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="nom", type="string"),
     *              @OA\Property(property="prenom", type="string"),
     *             @OA\Property(property="tel", type="string"),
     *              @OA\Property(property="adress", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     * )
     * )
     * )
     * )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Client modifiée avec succées",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */

    public function update(UpdateclientRequest $request, client $client)
    {
        $request->validated($request->all());
        if (Auth::check() && auth()->user()->role === 'client') {
            $user = User::where('id', $client->user_id)->first();
            // dd($user);
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->tel = $request->tel;
            $user->adress = $request->adress;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->update();

            return response()->json(['message' => ' Votre profil client modifié avec succès', 'data' => $user]);
        } else {
            return response()->json(['message' => 'Vous n\'êtes pas client'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/supprimClient/{id}",
     *     tags={"Mis à jour client et archivage"}, 
     *     summary="Archiver client",
     *    security={
     *         {"bearerAuth": {}}
     *     },
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Archivage du client à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function destroy($id)
    {
        if (Auth::check() && auth()->user()->role === 'client') {
            $user = User::findOrFail($id);
            if ($user->estArchive == 0) {
                $user->estArchive = 1;
                $user->save();
                return response()->json(['message' => 'Client archivé']);
            }
        }
    }
}
