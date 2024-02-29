<?php

namespace App\Http\Controllers;

use App\Models\Mail;
use App\Http\Requests\StoreMailRequest;
use App\Http\Requests\UpdateMailRequest;
//use App\Http\Mail\ContactMail as ContactMail;
use App\Http\Requests;
use App\Mail\ContactMail as ContactMail;
use App\Mail\ResponseMail;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail as FacadesMail;
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
        return view('emails.contact');
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

        $validatedData = $request->validated(); // Validation des données du formulaire

        $mail = new \App\Models\Mail(); // Utilisation de la classe Mail du modèle
        $mail->email = $validatedData['email'];
        $mail->message = $validatedData['message'];
        $mail->save();

        FacadesMail::send('messageView', ['mail' => $mail], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Contactez-nous pour tout renseignement');
        });

        // if ($mail->save()) {
        //     $contact = $validatedData['message'];
        //     //dd($validatedData['email']);
        //     dd($contact);
        //     // Envoi de l'e-mail de contact avec la méthode to() correctement utilisée
        //     FacadesMail::to($validatedData['email'])->send(new ContactMail($contact));

        return response()->json(['message' => 'Accusé de réception']);
    }



    // Retourner une réponse en cas d'erreur de sauvegarde du mail
    // return response()->json(['message' => 'Erreur lors de l\'envoi de la réponse'], 500);


    // $request->validated($request->all());

    // $mail = new Mail();
    // $mail->email = $request->email; // Accès à l'e-mail à partir des données validées
    // $mail->message = $request->message;
    // if ($mail->save()) {
    //     $contact = $request->message;

    //     if (email::to($request->email)->send(new ContactMail($contact))) {
    //         return response()->json(['message' => 'reponse envoye avec success']);
    //     }
    //}

    // Mail::to($mail->email)->send(new ResponseMail($mail)); // Utilisation de $mail->email

    // return response()->json([
    //     'message' => 'reponse envoye avec success',
    //     'data' => $mail
    // ]);


    //return response()->json(['message' => 'Message envoyé avec succès', 'data' => $mail]);


    // public function reponse(Request $request)

    // {

    //     try {
    //         $contact = $request->message;
    //         //$mailable = new ContactMail($contact);
    //         // if ($mailable->to($request->email)->send()) {
    //         if (Mail::to($request->email)->send(new ContactMail($contact))) {
    //             return response()->json(['message' => 'reponse envoye avec success']);
    //         } else {
    //             return response()->json(['message' => 'reponse non envoyée']);
    //         }
    //     } catch (\Throwable $th) {
    //         return  $th->getMessage();
    //     }
    // }




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
        $mail->delete();

        // if ($mail->estArchive == 0) {
        //     $mail->estArchive = 1;
        //     $mail->save();

        return response()->json(['message' => 'message mis à la corbeille']);
        // }
    }
}
