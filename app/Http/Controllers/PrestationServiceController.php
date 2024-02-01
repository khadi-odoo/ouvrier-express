<?php

namespace App\Http\Controllers;

use App\Models\PrestationService;
use App\Http\Requests\StorePrestationServiceRequest;
use App\Http\Requests\UpdatePrestationServiceRequest;
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


class PrestationServiceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/listePrestaService",
     * tags={"Prestation de service"},
     *     summary="liste de toutes les prestations de service",
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function index()
    {
        return response()->json(PrestationService::where('estArchive', false)->get());
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
     *     path="/api/ajoutPrestaService",
     *     summary="Ajouter une prestation de service",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     tags={"Prestation de service"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="nomService", type="string"),
     *            @OA\Property(property="prestataire_id", type="integer"), 
     *            @OA\Property(property="categorie_id", type="integer"),            
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Prestation de service ajoutée avec succées",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function store(StorePrestationServiceRequest $request)
    {
        $request->validated($request->all());

        if (Auth::check() && auth()->user()->role === 'prestataire') {

            $prestation = new PrestationService();
            //$prestation->user_id = $user;
            //$prestation->user_id = Auth::user()->id;

            // dd(Auth::user());

            $prestation->nomService = $request->nomService;
            $prestation->prestataire_id = $request->prestataire_id;
            $prestation->categorie_id = $request->categorie_id;

            $prestation->prestataire_id = Auth::user()->id;

            $prestation->save();

            return response()->json(['message' => 'Prestation ajoutée avec succès', 'data' => $prestation]);
        } else {
            return response()->json(['message' => 'Vous n\' êtes pas prestataire'], 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/affichPrestaService/{id}",
     *     tags={"Prestation de service"},
     *     summary="Voir une prestation de service",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Prestation de service à afficher à partir de l'id",
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
        $prestationService = PrestationService::findOrFail($id);
        return response()->json([

            "Prestation" => $prestationService,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrestationService $prestationService)
    {
        //
    }

    /**
     * @OA\Patch(
     *     path="/api/modifPrestaService/{prestatationservice}",
     *     summary="Modificier une prestation de service",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     tags={"Prestation de service"},
     * 
     *         @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la prestation à modifier",
     *         @OA\Schema(type="integer")
     * ),    
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="nomService", type="string"),
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Prestation de service modifiée avec succés",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function update(UpdatePrestationServiceRequest $request, PrestationService $prestationService)
    {
        $request->validated($request->all());

        $prestationService->nomService = $request->nomService;


        $prestationService->update();

        return response()->json(['message' => 'Prestation modifiée avec succès', 'data' => $prestationService]);
    }

    /**
     * @OA\Patch(
     *     path="/api/supprimPrestaService/{id}",
     *     tags={"Prestation de service"}, 
     *     summary="Supprimer une prestation de service",
     *    
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Suppression d'une prestation de service à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function destroy($id)
    {
        $prestationService = PrestationService::findOrFail($id);
        // dd($$prestationService);
        if ($prestationService->estArchive == 0) {
            $prestationService->estArchive = 1;
            $prestationService->save();

            return response()->json(['message' => 'Prestation de service supprimée']);
        }
    }
}
