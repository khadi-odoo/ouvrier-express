<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commentaire;
use App\Http\Requests\StoreCommentaireRequest;
use App\Http\Requests\UpdateCommentaireRequest;
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

class CommentaireController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/listeComment",
     * tags={"Commentaire"},
     *     summary="liste de toutes les commentaires",
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function index()
    {
        return response()->json(Commentaire::where('estArchive', false)->get());
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
     *     path="/api/ajoutComment",
     *     summary="Ajouter un commentaire sur un prestataire",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     tags={"Commentaire"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="client_id", type="integer"),
     *             @OA\Property(property="prestation_id", type="integer"),
     *             @OA\Property(property="statut_evaluation", type="string"),
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Commentaire ajoutée avec succés",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function store(StoreCommentaireRequest $request)
    {
        $request->validated($request->all());


        if (Auth::check() && auth()->user()->role === 'client') {
        $comment = new Commentaire();
        $comment->client_id = $request->client_id;
        $comment->prestation_id = $request->prestation_id;
        $comment->statut_evaluation = $request->statut_evaluation;
        $comment->save();

        return response()->json(['message' => 'Commentaire envoyé avec succès', 'data' => $comment]);
        } else {
            return response()->json(['message' => 'Vous n\' êtes pas client'], 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/aaffichComment/{id}",
     *     tags={"Commentaire"},
     *     summary="Afficher un commentaire",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Id du commentaire à afficher",
     *         @OA\Schema(type="integer")
     * ),
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *     ),
     *     @OA\Response(response=401, description="Non autorisé"),
     * )
     */
    public function show($id)
    {
        $commentaire = Commentaire::findOrFail($id);
        return response()->json([

            "Statut" => $commentaire,


        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commentaire $commentaire)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/modifComment/{commentaire}",
     *     summary="Modificier un commentaire",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     tags={"Commentaire"},
     * 
     *         @OA\Parameter(
     *         name="commentaire",
     *         in="path",
     *         required=true,
     *         description="Modifier un commentaire à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),    
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="statut_evaluation", type="string"),
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Commentaire modifié avec succées",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function update(UpdateCommentaireRequest $request, Commentaire $commentaire)
    {
        $request->validated($request->all());
        $commentaire->statut_evaluation = $request->statut_evaluation;
        $commentaire->update();

        return response()->json(['message' => 'Commentaire modifiié avec succès', 'data' => $commentaire]);
    }

    /**
     * @OA\Post(
     *     path="/api/supprimComment/{id}",
     *     tags={"Commentaire"},
     *     summary="Supprimer un commentaire",
     * 
     * security={
     *         {"bearerAuth": {}}
     *     },
     *    
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Supprimer un commentaire à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function destroy($id)
    {
        $commentaire = Commentaire::findOrFail($id);
        // dd($commentaire);
        if ($commentaire->estArchive == 0) {
            $commentaire->estArchive = 1;
            $commentaire->save();

            return response()->json(['message' => 'Commentaire supprimé']);
        }
    }
}
