<?php

namespace App\Http\Controllers;

use App\Models\prestataire;
use App\Http\Requests\StoreprestataireRequest;
use App\Http\Requests\UpdateprestataireRequest;
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

/**
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * )
 */

class PrestataireController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/listePresta",
     *     tags={"Profil prestataire"},
     *     summary="liste des profills prestataires",
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function index()
    {
        return response()->json(Prestataire::where('estArchive', false)->get());
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
     *     path="/api/ajouterPresta",
     *     tags={"Profil prestataire"},
     *     summary="Ajouter profil",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="image", type="string", format="binary", description="Fichier de photo"),
     *             @OA\Property(property="metier", type="string"),
     *             @OA\Property(property="disponibilite", type="string"),
     *             @OA\Property(property="user_id", type="integer"),
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Création reussie",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function store(StoreprestataireRequest $request)
    {


        $request->validated($request->all());


        if (Auth::check() && auth()->user()->role === 'prestataire') {
            $prestataire = new Prestataire();
            //dd('ok');
            // $imagePath = $request->file('image')->store('images/Prestataires', 'public');
            // $prestataire->image = $imagePath;
            $prestataire->metier = $request->metier;
            $prestataire->disponibilite = $request->disponibilite;
            $prestataire->user_id = $request->user_id;


            $prestataire->user_id = Auth::user()->id;

            $prestataire->save();

            return response()->json(['message' => ' Profil prestataire ajouté avec succès', 'data' => $prestataire]);
        } else {
            return response()->json(['message' => 'Vous n\' êtes pas prestataire'], 404);
        }
        // $prestataire->user_id = Auth::user()->id;
        // dd($prestataire);



    }

    public function ajouterPrestataire(Request $request)
    {
        $request->validate([
            'metier' => 'required|string',
        ]);

        // $presta = Prestataire::create([
        //     'metier' => $request->input('metier'),
        //     'user_id' => Auth::user()->id,
        // ]);
        $presta = new Prestataire();
        $presta->metier = $request->metier;
        $presta->user_id = Auth::user()->id;
        //dd($presta);
        $presta->save();

        return response()->json(['message' => 'Inscription reussie']);
    }

    /**
     * @OA\Get(
     *     path="/api/affichPresta{id}",
     *     tags={"Profil prestataire"},
     *     summary="Voir profil",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Afficher un prestataire",
     *         @OA\Schema(type="integer")
     * ),
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *     ),
     * )
     */
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
     * @OA\Patch(
     *     path="/api/modifPresta/{prestataire}",
     *     tags={"Profil prestataire"},
     *     summary="Modificier un profil",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *         @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Modifier à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),    
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="image", type="string", format="binary", description="Fichier de photo"),
     *             @OA\Property(property="metier", type="string"),
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Profil modifiée avec succés",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function update(UpdateprestataireRequest $request, prestataire $prestataire)
    {
        $request->validated();
        // if ($request->file('image')) {
        //     $imagePath = $request->file('image')->store('images/Prestataires', 'public');
        //     $prestataire->image = $imagePath;
        // }
        $prestataire->metier = $request->metier;
        $prestataire->disponibilite = $request->disponibilite;
        $prestataire->update();

        return response()->json(['message' => 'prestataire modifié avec succès', 'data' => $prestataire]);
    }

    /**
     * @OA\Patch(
     *     path="/api/supprimPresta/{id}",
     *     tags={"Profil prestataire"}, 
     *     summary="Supprimer un profil",
     *    
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Supprimer un profil à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function destroy($id)
    {
        $presta = prestataire::findOrFail($id);
        // dd($presta);
        if ($presta->estArchive == 0) {
            $presta->estArchive = 1;
            $presta->save();

            return response()->json(['message' => 'Prestataire supprimé']);
        };
    }
}
