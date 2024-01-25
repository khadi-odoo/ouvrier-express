<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\categorieService;
use App\Http\Requests\StorecategorieServiceRequest;
use App\Http\Requests\UpdatecategorieServiceRequest;
use Illuminate\Support\Facades\Auth;

class CategorieServiceController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(StorecategorieServiceRequest $request)
    {


        $request->validated($request->all());
        $categorie = new CategorieService();

        // $categorie->user_id = $user;
        //$categorie->user_id = Auth::user()->id;
        if (Auth::check()) {
            // dd('ok');
            $categorie->user_id = Auth::user()->id;
        }

        $categorie->libelleCategorie = $request->libelleCategorie;

        // $imagePath = $request->file('image')->store('images/Categorie', 'public');
        // $categorie->image = $imagePath;

        $categorie->save();

        return response()->json(['message' => 'Catégorie de service ajouté avec succès', 'data' => $categorie]);
    }

    /**
     * Display the specified resource.
     */
    public function show(categorieService $categorieService)
    {
        return response()->json($categorieService);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(categorieService $categorieService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecategorieServiceRequest $request, categorieService $categorieService)
    {
        //$request->all();
        $request->validated();

        $categorieService->libelleCategorie = $request->libelleCategorie;

        if ($request->file('image')) {
            $imagePath = $request->file('image')->store('images/Categorie', 'public');
            $categorieService->image = $imagePath;
        }

        $categorieService->update();

        return response()->json($categorieService);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(categorieService $categorieService)
    {
        //$categorieService->delete();
        $categorieService->estArchive = true;
        $categorieService->update();

        return response()->json('Catégorie supprimées');
    }
}
