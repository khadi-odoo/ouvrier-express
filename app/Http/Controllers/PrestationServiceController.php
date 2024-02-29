<?php


namespace App\Http\Controllers;

use App\Models\prestataire;
use App\Models\CategorieService;
use App\Models\User;
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
     *     summary="liste de toutes les prestations de service avec leur catégorie",
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function index()
    {
        $prestataires = prestataire::all();
        $info = [];
        foreach ($prestataires as $prestataire) {
            //dd($prestataires);
            $prestataire_service = PrestationService::where('prestataire_id', $prestataire->id)->first();
            if ($prestataire_service != null) {
                $user = User::where('id', $prestataire->user_id)->first();

                $info[] = [
                    'id' => $user->id,
                    '$prestataire_service_id' => $prestataire_service->id,
                    'nom'    => $user->nom,
                    'prenom' => $user->prenom,
                    'tel'   => $user->tel,
                    'email'  => $user->email,
                    'images' => $prestataire_service->image,
                    'presentation' => $prestataire_service->presentation,
                    'experience' => $prestataire_service->experience,
                    'competence' => $prestataire_service->competence,
                    'motivation' => $prestataire_service->motivation,
                    'metier' => $prestataire_service->nomService,

                ];
            }
        }

        return response()->json($info);

        return response()->json(PrestationService::where('estArchive', false)->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function categorieprestataire(CategorieService $categorie)
    {
        if ($categorie != null) {
            //dd($categorie);
            $prestationservices = PrestationService::where('categorie_id', $categorie->id)->get();
            $tabprestataires = [];
            foreach ($prestationservices as $prestationservice) {
                $prestataire = prestataire::where('id', $prestationservice->prestataire_id)->get();
                if ($prestataire != null) {
                    $tabprestataires[] = [
                        'prestataires' => $prestataire
                    ];
                }
            }

            $info = [];
            foreach ($tabprestataires as $tabprestataire) {
                if ($tabprestataire['prestataires'] != null) {
                    $id = $tabprestataire['prestataires'][0]->user_id;
                    $user = User::where('id', $id)->first();
                    $prestUser = prestataire::where('user_id', $user->id)->first();

                    if ($prestUser != null) {
                        $prestservice = PrestationService::where('prestataire_id', $prestUser->id)->first();

                        if ($prestservice != null) {
                            $info[] = [
                                'id' => $user->id,
                                'nom'    => $user->nom,
                                'prenom' => $user->prenom,
                                'tel'   => $user->tel,
                                'email'  => $user->email,
                                'images' => $prestservice->image,
                                'presentation' => $prestservice->presentation,
                                'experience' => $prestservice->experience,
                                'competence' => $prestservice->competence,
                                'motivation' => $prestservice->motivation,
                                'metier' => $prestservice->nomService,
                            ];
                        }
                    }
                }
            }

            return response()->json($info);
            // dd($info);
        } else {
            return response()->json([
                'message' => 'Categorie inexistant',
                'status' => 400
            ]);
        }
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

            $prestation->nomService = $request->nomService;
            $imagePath = $request->file('image')->store('images/PrestationService', 'public');
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
        $prestationService = PrestationService::Find($id);
        if ($prestationService == null) {
            return response()->json([
                "Message" => 'Ressources introuvable',

            ]);
        }
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

            if ($request->image) {
                $imagePath = $request->file('image')->store('images/Prestations', 'public');
                $prestationService->image = $imagePath;
            }
            $prestationService->presentation = $request->presentation;
            //$prestationService->disponibilite = $request->disponibilite;
            $prestationService->experience = $request->experience;
            $prestationService->competence = $request->competence;
            $prestationService->motivation = $request->motivation;
            $prestationService->categorie_id = $request->categorie_id;
            // $prestationService => $prestationService->id;

            $prestationService->update();

            return response()->json(['message' => 'Profil modifié avec succès', 'data' => $prestationService]);
        } else {
            return response()->json(['message' => 'Vous n\'êtes pas prestataire'], 404);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/supprimPrestaService/{id}",
     *     tags={"Prestation de service"},
     *     summary="Supprimer profil prestataire",
     * security={
     *         {"bearerAuth": {}}
     *     },
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
