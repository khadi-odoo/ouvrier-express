<?php

namespace App\Http\Controllers;

use App\Models\prestataire;
use App\Http\Requests\StoreprestataireRequest;
use App\Http\Requests\UpdateprestataireRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Ouvrier-Express",
 *     version="1.0.0",
 *     description="Application de gestion de relation prestataire-client"
 * )
 */

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

        return response()->json(['message' => ' Prestataire ajouté avec succès', 'data' => $prestataire]);
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


    /**
     * @OA\Post(
     *     path="/api/modifPresta/{prestataire}",
     *     summary="Modifier ses coordonnées ",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     tags={"Mis à jour prestataire et archivage"},
     * 
     *         @OA\Parameter(
     *         name="prestataire",
     *         in="path",
     *         required=true,
     *         description="Modification des coordonnées du prestataire à partir de son id",
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
     *         description="Profil prestataire modifiée avec succées",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */

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

            return response()->json(['message' => ' Votre profil prestataire est modifié avec succès', 'data' => $user]);
        } else {
            return response()->json(['message' => 'Vous n\' êtes pas prestataire'], 404);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/supprimPresta/{id}",
     *     tags={"Mis à jour prestataire et archivage"},  
     *     summary="Archiver le prestataire",
     *    security={
     *         {"bearerAuth": {}}
     *     },
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Archivage du prestataire à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),
     *     @OA\Response(response="200", description="succes")
     * )
     */

    public function destroy($id)
    {
        if (Auth::check() && auth()->user()->role === 'prestataire') {
            $user = User::findOrFail($id);
            if ($user->estArchive == 0) {
                $user->estArchive = 1;
                $user->save();
                return response()->json(['message' => 'Prestataire archivé']);
            }
        }
    }
}
