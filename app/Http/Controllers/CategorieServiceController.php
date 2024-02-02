<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\categorieService;
use App\Http\Requests\StorecategorieServiceRequest;
use App\Http\Requests\UpdatecategorieServiceRequest;
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

class CategorieServiceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/listeCétegorie",
     * tags={"Catégorie de service"},
     *     summary="liste de toutes les catégories de service",
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function index()
    {
        return response()->json(CategorieService::where('estArchive', false)->get()); //
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
     *     path="/api/ajouterCategorie",
     *     summary="Ajouter une catégorie de service",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     tags={"Catégorie de service"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="libelleCategorie", type="string"),
     *             @OA\Property(property="image", type="string", format="binary", description="Fichier de photo"),
     *             @OA\Property(property="description", type="string"),
     * )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Catégorie de service ajoutée avec succées",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function store(StorecategorieServiceRequest $request)
    {


        $request->validated($request->all());


        // $categorie->user_id = $user;
        //$categorie->user_id = Auth::user()->id;
        if (Auth::check() && auth()->user()->role === 'admin') {
            $categorie = new CategorieService();
            // dd('ok');
            //$categorie->user_id = Auth::user()->id;
            $categorie->libelleCategorie = $request->libelleCategorie;
            $categorie->description = $request->description;

            $categorie->save();

            return response()->json(['message' => 'Catégorie de service ajoutée avec succès', 'data' => $categorie]);
        }



        // $imagePath = $request->file('image')->store('images/Categorie', 'public');
        // $categorie->image = $imagePath;



        else {
            return response()->json(['message' => 'Vous n\' êtes pas admin'], 404);
        }
    }


    // $imagePath = $request->file('image')->store('images/Categorie', 'public');
    // $categorie->image = $imagePath;




    /**
     * @OA\Get(
     *     path="/api/affichCategorie/{id}",
     *     tags={"Catégorie de service"},
     *     summary="Details d'une categorie de service",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la catégorie à afficher",
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
        $categorieService = categorieService::findOrFail($id);
        return response()->json([

            "categorie" => $categorieService,


        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(categorieService $categorieService)
    {
        //
    }

    /**
     * @OA\Patch(
     *     path="/api/modifCategorie/{id}",
     *     summary="Modificier une catégorie de service",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     tags={"Catégorie de service"},
     * 
     *         @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Modifier la catégorie à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),    
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="libelleCategorie", type="string"),
     *             @OA\Property(property="image", type="string", format="binary", description="Fichier de photo"),
     *             @OA\Property(property="desription", type="string"),
     * )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Catégorie de service modifiée avec succées",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function update(UpdatecategorieServiceRequest $request, categorieService $categorieService)
    {
        //$request->all();
        $request->validated();

        $categorieService->libelleCategorie = $request->libelleCategorie;
        $categorieService->description = $request->description;

        // if ($request->file('image')) {
        //     $imagePath = $request->file('image')->store('images/Categorie', 'public');
        //     $categorieService->image = $imagePath;
        // }

        $categorieService->update();

        return response()->json(['message' => 'Catégorie de service modifiée avec succès', 'data' => $categorieService]);
    }

    /**
     * @OA\Patch(
     *     path="/api/supprimCategorie/{id}",
     *     tags={"Catégorie de service"}, 
     *     summary="Supprimer une catégorie de service",
     *    
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Suppression d'une catégorie à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function destroy($id)
    {

        $categorieService = categorieService::findOrFail($id);
        // dd($categorieService);
        if ($categorieService->estArchive == 0) {
            $categorieService->estArchive = 1;
            $categorieService->save();

            return response()->json(['message' => 'Catégorie supprimée']);
        }
    }
}
