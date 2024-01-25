<?php

namespace App\Http\Controllers;

use App\Models\prestataire;
use App\Http\Requests\StoreprestataireRequest;
use App\Http\Requests\UpdateprestataireRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestataireController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(StoreprestataireRequest $request)
    {

        $request->validated($request->all());
        $prestataire = new Prestataire();
        //dd('ok');
        // $imagePath = $request->file('image')->store('images/Prestataires', 'public');
        // $prestataire->image = $imagePath;
        $prestataire->metier = $request->metier;
        // dd(Auth::user());
        if (Auth::check()) {
            // dd('ok');
            $prestataire->user_id = Auth::user()->id;
        }

        // $prestataire->user_id = Auth::user()->id;
        //dd($prestataire);
        $prestataire->save();

        return response()->json(['message' => 'prestataire ajouté avec succès', 'data' => $prestataire]);
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

        return response()->json(['message' => 'prestataire ajouté avec succès']);
    }

    /**
     * Display the specified resource.
     */
    public function show(prestataire $prestataire)
    {
        return response()->json($prestataire);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(prestataire $prestataire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprestataireRequest $request, prestataire $prestataire)
    {
        $request->validated();
        if ($request->file('image')) {
            $imagePath = $request->file('image')->store('images/Prestataires', 'public');
            $prestataire->image = $imagePath;
        }
        $prestataire->metier = $request->metier;
        $prestataire->disponibilite = $request->disponibilite;
        $prestataire->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(prestataire $prestataire)
    {
        $prestataire->estArchive = true;
        $prestataire->update();

        return response()->json('Prestataire supprimé');
    }
}
