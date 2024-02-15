<?php

namespace App\Http\Controllers;

use App\Models\PrestationService;
use App\Http\Requests\StorePrestationServiceRequest;
use App\Http\Requests\UpdatePrestationServiceRequest;
use App\Models\prestataire;
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
     *     summary="Ajouter un profil prestataire",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     tags={"Prestation de service"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *              @OA\Property(property="nomService", type="string"),
     *             @OA\Property(property="image", type="string", format="binary", description="Fichier de photo"),
     *             @OA\Property(property="presentation", type="string"),
     *             @OA\Property(property="disponibilte", type="boolean"),
     *             @OA\Property(property="experience", type="string"),
     *             @OA\Property(property="competence", type="string"),
     *             @OA\Property(property="motivation", type="string"),
     *             @OA\Property(property="prestataire_id", type="integer"),
     *             @OA\Property(property="categorie_id", type="integer"),           
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Profil ajoutée avec succées",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */

    public function store(StorePrestationServiceRequest $request)
    {
        $request->validated($request->all());
        if (Auth::check() && auth()->user()->role === 'prestataire') {

            $prestation = new PrestationService();
            // $prestation = prestataire::where('user_id', Auth::user()->id)->first();
            $prestation->nomService = $request->nomService;
            $imagePath = $request->file('image')->store('images/Categorie', 'public');
            $prestation->image = $imagePath;
            $prestation->presentation = $request->presentation;
            //$prestation->disponibilite = $request->disponibilite;
            $prestation->experience = $request->experience;
            $prestation->competence = $request->competence;
            $prestation->motivation = $request->motivation;
            $prestation->prestataire_id = $request->prestataire_id;
            $prestation->categorie_id = $request->categorie_id;

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
     *     summary="Voir un profil",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Profil à afficher à partir de l'id",
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
     * @OA\Post(
     *     path="/api/modifPrestaService/{prestatationservice}",
     *     summary="Modificier profil prestataire",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     tags={"Prestation de service"},
     * 
     *         @OA\Parameter(
     *         name="prestatationservice",
     *         in="path",
     *         required=true,
     *         description="Modifier le profil à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),    
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="nomService", type="string"),
     *             @OA\Property(property="image", type="string", format="binary", description="Fichier de photo"),
     *             @OA\Property(property="presentation", type="string"),
     *             @OA\Property(property="disponibilte", type="boolean"),
     *             @OA\Property(property="experience", type="string"),
     *             @OA\Property(property="competence", type="string"),
     *             @OA\Property(property="motivation", type="string"),
     *             @OA\Property(property="prestataire_id", type="integer"),
     *             @OA\Property(property="categorie_id", type="integer"),
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

        if (Auth::check() && auth()->user()->role === 'prestataire') {

            $prestationService->nomService = $request->nomService;

            if ($request->file('image')) {
                $imagePath = $request->file('image')->store('images/Prestations', 'public');
                $prestationService->image = $imagePath;
            }
            $prestationService->presentation = $request->presentation;
            //$prestationService->disponibilite = $request->disponibilite;
            $prestationService->experience = $request->experience;
            $prestationService->competence = $request->competence;
            $prestationService->motivation = $request->motivation;

            $prestationService->update();
            if ($prestationService->update()) {
                return response()->json(['message' => 'Profil modifié avec succès', 'data' => $prestationService]);
            } else {
                return response()->json([
                    'message' => 'error'
                ]);
            }
        } else {
            return response()->json(['message' => 'Vous n\'êtes pas prestataire'], 404);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/supprimPrestaService/{id}",
     *     tags={"Prestation de service"}, 
     *     summary="Supprimer profil prestataire",
     *    
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Suppression du profil à partir de l'id",
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

            return response()->json(['message' => 'Profil supprimé']);
        }
    }
}
