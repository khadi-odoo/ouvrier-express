<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Http\Requests\StoreclientRequest;
use App\Http\Requests\UpdateclientRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
     * Update the specified resource in storage.
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

            return response()->json(['message' => ' Profil client modifié avec succès', 'data' => $user]);
        } else {
            return response()->json(['message' => 'Vous n\'êtes pas client'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::check() && auth()->user()->role === 'client') {
            $user = User::findOrFail($id);
            if ($user->estArchive == 0) {
                $user->estArchive = 1;
                $user->save();
                return response()->json(['message' => 'Profil client archivé']);
            }
        }
    }
}
