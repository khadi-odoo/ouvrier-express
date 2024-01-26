<?php

namespace App\Http\Controllers;

use App\Models\PrestationService;
use App\Http\Requests\StorePrestationServiceRequest;
use App\Http\Requests\UpdatePrestationServiceRequest;
use Illuminate\Support\Facades\Auth;

class PrestationServiceController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(StorePrestationServiceRequest $request)
    {
        $request->validated();
        $prestation = new PrestationService();
        //$prestation->user_id = $user;
        //$prestation->user_id = Auth::user()->id;
        $prestation->nomService = $request->nomService;
        // dd(Auth::user());
        if (Auth::check()) {
            $prestation->prestataire_id = Auth::user()->id;
            $prestation->categorie_id = $request->categorie_id;
        }

        $prestation->save();

        return response()->json(['message' => 'Prestation ajoutée avec succès', 'data' => $prestation]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PrestationService $prestationService)
    {
        return response()->json($prestationService);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrestationService $prestationService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrestationServiceRequest $request, PrestationService $prestationService)
    {
        $request->validated();

        $prestationService->nomService = $request->nomService;


        $prestationService->update();

        return response()->json(['message' => 'Prestation modifiée avec succès', 'data' => $prestationService]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrestationService $prestationService)
    {
        //$categorieService->delete();
        $prestationService->estArchive = true;
        $prestationService->update();

        return response()->json(['message' => 'Prestation de service supprimées']);
    }
}
