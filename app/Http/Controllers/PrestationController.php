<?php

namespace App\Http\Controllers;

use App\Models\Prestation;
use App\Http\Requests\StorePrestationRequest;
use App\Http\Requests\UpdatePrestationRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class PrestationController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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

            return response()->json(['message' => 'Prestation Clientajoutée avec succès', 'data' => $prestation]);
        } else {
            return response()->json(['message' => 'Vous n\' êtes pas client'], 404);
        }
    }

    /**
     * Display the specified resource.
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
     * Update the specified resource in storage.
     */
    public function update(UpdatePrestationRequest $request, Prestation $prestation)
    {
        $request->validated($request->all());

        $prestation->prestation_demande = $request->prestation_demande;


        $prestation->update();

        return response()->json(['message' => 'Prestation Client modifiée avec succès', 'data' => $prestation]);
    }

    /**
     * Remove the specified resource from storage.
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
