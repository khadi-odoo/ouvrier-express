<?php

namespace App\Http\Controllers;

use App\Models\Mail;
use App\Http\Requests\StoreMailRequest;
use App\Http\Requests\UpdateMailRequest;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Mail::where('estArchive', false)->get());
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
    public function store(StoreMailRequest $request)
    {
        $request->validated($request->all());
        $mail = new Mail();

        if (Auth::check()) {
            // dd('ok');
            //$categorie->user_id = Auth::user()->id;
            $mail->email = $request->email;
            $mail->message = $request->message;

            $mail->save();

            return response()->json(['message' => 'Mail envoyé avec succès', 'data' => $mail]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mail = Mail::findOrFail($id);
        return response()->json([

            "Mail" => $mail,


        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mail $mail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMailRequest $request, Mail $mail)
    {
        $request->validated();

        $mail->email = $request->email;
        $mail->message = $request->message;

    

        $mail->update();

        return response()->json(['message' => 'mail modifiée avec succès', 'data' => $mail]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mail = Mail::findOrFail($id);
        // dd($categorieService);
        if ($mail->estArchive == 0) {
            $mail->estArchive = 1;
            $mail->save();

            return response()->json(['message' => 'Mail supprimé']);
        }
    }
}
