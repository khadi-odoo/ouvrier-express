<?php

namespace App\Http\Controllers;

use App\Models\Prestation;
use App\Http\Requests\StorePrestationRequest;
use App\Http\Requests\UpdatePrestationRequest;
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
class PrestationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/listePrestation",
     * tags={"Prestation Client"},
     *     summary="liste des prestations",
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function index()
    {
        return response()->json(Prestation::where('estArchive', false)->get());
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
     *     path="/api/ajoutPrestation",
     *     summary="Demander une prestation",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     tags={"Prestation Client"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="client_id", type="integer"),
     *             @OA\Property(property="prestation_id", type="integer"),
     *             @OA\Property(property="prestation_demande", type="string"),
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Prestation envoyé avec succés",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function store(StorePrestationRequest $request)
    {
        $request->validated($request->all());


        if (Auth::check() && auth()->user()->role === 'client') {
            $prestation = new Prestation();
            //$prestation->prestataire_id = Auth::user()->id;
            $prestation->client_id = $request->client_id;
            $prestation->prestation_id = $request->prestation_id;
            $prestation->prestation_demande = $request->prestation_demande;

            $prestation->save();

            return response()->json(['message' => 'Prestation Client ajoutée avec succès', 'data' => $prestation]);
        } else {
            return response()->json(['message' => 'Vous n\' êtes pas client'], 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/affichPrestation/{id}",
     *     tags={"Prestation Client"},
     *     summary="Voir détail d'une prestation",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Afficher la prestation à partir de l'id",
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
        $prestation = Prestation::findOrFail($id);
        return response()->json([

            "Prestation Client" => $prestation,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestation $prestation)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/modifPrestation/{prestation}",
     *     summary="Modificier une prestation",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     tags={"Prestation Client"},
     * 
     *         @OA\Parameter(
     *         name="prestation",
     *         in="path",
     *         required=true,
     *         description="Modifier une prestation à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),    
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="client_id", type="integer"),
     *             @OA\Property(property="prestation_id", type="integer"),
     *             @OA\Property(property="prestation_demande", type="string"),
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Prestation modifiée avec succées",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function update(UpdatePrestationRequest $request, Prestation $prestation)
    {
        $request->validated($request->all());

        $prestation->client_id = $request->client_id;
        $prestation->prestation_id = $request->prestation_id;
        $prestation->prestation_demande = $request->prestation_demande;


        $prestation->update();

        return response()->json(['message' => 'Prestation Client modifiée avec succès', 'data' => $prestation]);
    }

    /**
     * @OA\Post(
     *     path="/api/supprimPrestation/{id}",
     *     tags={"Prestation Client"},
     *     summary="Annuler une prestation demandée",
     *    
     * security={
     *         {"bearerAuth": {}}
     *     },
     * 
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Annuler une prestation à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function destroy($id)
    {
        $prestation = Prestation::findOrFail($id);
        // dd($$prestationService);
        if ($prestation->estArchive == 0) {
            $prestation->estArchive = 1;
            $prestation->save();

            return response()->json(['message' => 'Prestation client supprimée']);
        }
    }
}
