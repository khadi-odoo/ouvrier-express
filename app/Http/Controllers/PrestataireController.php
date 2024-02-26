<?php

namespace App\Http\Controllers;

use App\Models\prestataire;
use App\Http\Requests\StoreprestataireRequest;
use App\Http\Requests\UpdateprestataireRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestataireController extends Controller
{


    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(StoreprestataireRequest $request)
    {


        //$request->validated($request->all());


        // if (Auth::check() && auth()->user()->role === 'prestataire') {
        $prestataire = new Prestataire();
        //dd('ok');
        $prestataire->user_id = $request->user_id;
        $prestataire->save();

        return response()->json(['message' => ' Profil prestataire ajouté avec succès', 'data' => $prestataire]);
        // } else {
        //     return response()->json(['message' => 'Vous n\' êtes pas prestataire'], 404);
        // }
        // $prestataire->user_id = Auth::user()->id;
        // dd($prestataire);



    }


    public function show($id)
    {
        $prestataire = prestataire::findOrFail($id);
        return response()->json([

            "Profils" => $prestataire,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(prestataire $prestataire)
    {
        //
    }

    public function update(UpdateprestataireRequest $request, prestataire $prestataire)
    {
        $request->validated($request->all());
        if (Auth::check() && auth()->user()->role === 'prestataire') {
            $user = User::where('id', $prestataire->user_id)->first();
            // dd($user);
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->tel = $request->tel;
            $user->adress = $request->adress;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->update();

            return response()->json(['message' => ' Profil prestataire modifié avec succès', 'data' => $user]);
        } else {
            return response()->json(['message' => 'Vous n\' êtes pas prestataire'], 404);
        }
    }


    public function destroy($id)
    {
    }
}
