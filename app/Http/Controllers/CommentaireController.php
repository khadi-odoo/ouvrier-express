<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Http\Requests\StoreCommentaireRequest;
use App\Http\Requests\UpdateCommentaireRequest;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentaireRequest $request)
    {
        $request->validated($request->all());
        $comment = new Commentaire();

        //$comment->user_id = $user;
        //$comment->user_id = Auth::user()->id;


        // dd(Auth::user());


        if (Auth::check()) {
            $comment->client_id = Auth::user()->id;
        }
        $comment->client_id = $request->client_id;
        $comment->prestation_id = $request->prestation_id;
        $comment->statut_evaluation = $request->statut_evaluation;
        $comment->save();

        return response()->json(['message' => 'Commentaire envoyé avec succès', 'data' => $comment]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Commentaire $commentaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commentaire $commentaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentaireRequest $request, Commentaire $commentaire)
    {
        $request->validated();
        $commentaire->statut_evaluation = $request->statut_evaluation;
        $commentaire->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commentaire $commentaire)
    {
        //$categorieService->delete();
        $commentaire->estArchive = true;
        $commentaire->update();

        return response()->json('Commentaire supprimé');
    }
}
