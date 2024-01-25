<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Http\Requests\StoreclientRequest;
use App\Http\Requests\UpdateclientRequest;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreclientRequest $request)
    {
        $client = new client();

        // $client->user_id = $user;
        // $client->user_id = Auth::user()->id;

        if (Auth::check()) {
            // dd('ok');
            $client->user_id = Auth::user()->id;
        }
        $client->user_id = $request->user_id;

        $client->save();

        return response()->json(['message' => 'Client ajouté avec succès', 'data' => $client]);
    }

    /**
     * Display the specified resource.
     */
    public function show(client $client)
    {
        return response()->json($client);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateclientRequest $request, client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(client $client)
    {
        //
    }
}
