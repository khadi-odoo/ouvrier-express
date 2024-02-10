<?php

namespace App\Http\Controllers;

use App\Models\Mail;
use App\Http\Requests\StoreMailRequest;
use App\Http\Requests\UpdateMailRequest;
use Illuminate\Support\Facades\Auth;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Ouvrier-Express",
 *     version="1.0.0",
 *     description="Application de gestion de relation prestataire-client"
 * )
 */

class MailController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/listeMail",
     * tags={"Contact"},
     *     summary="liste des messages",
     *     @OA\Response(response="200", description="succes")
     * )
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
     * @OA\Post(
     *     path="/api/ajoutMail",
     *     summary="Envoyer un mail",
     *     
     *     tags={"Contact"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="message", type="string"),
     *         )
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Message envoyé avec succés",
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function store(StoreMailRequest $request)
    {
        $request->validated($request->all());
        $mail = new Mail();


        $mail->email = $request->email;
        $mail->message = $request->message;

        $mail->save();

        return response()->json(['message' => 'Message envoyé avec succès', 'data' => $mail]);
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
     * @OA\Post(
     *     path="/api/supprimMail/{id}",
     *     tags={"Contact"},
     *     summary="Annuler l'envoi",
     *    
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Annuler l'envoi de mail à partir de l'id",
     *         @OA\Schema(type="integer")
     * ),
     *     @OA\Response(response="200", description="succes")
     * )
     */
    public function destroy($id)
    {
        $mail = Mail::findOrFail($id);
        // dd($categorieService);
        if ($mail->estArchive == 0) {
            $mail->estArchive = 1;
            $mail->save();

            return response()->json(['message' => 'message annulé']);
        }
    }
}
