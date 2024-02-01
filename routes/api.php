<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CategorieServiceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PrestataireController;
use App\Http\Controllers\PrestationController;
use App\Http\Controllers\PrestationServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(PrestataireController::class)->group(function () {
    Route::get('listePresta', 'index');
    Route::post('ajouterPresta', 'store');
    Route::post('ajouterPrestataire', 'ajouterPrestataire');
    Route::get('affichPresta{id}', 'show');
    Route::post('modifPresta/{prestataire}', 'update');
    Route::post('supprimPresta/{id}', 'destroy');
});


Route::controller(ClientController::class)->group(function () {
    Route::get('listeclient', 'index');
    Route::post('ajouterclient', 'store');
    Route::get('afficherclient/{id}', 'show');
    Route::post('modifclient/{client}', 'update');
    Route::post('supprimclient/{id}', 'destroy');
});


Route::controller(CategorieServiceController::class)->group(function () {
    Route::get('listeCategorie', 'index');
    Route::post('ajouterCategorie', 'store');
    Route::get('affichCategorie/{id}', 'show');
    Route::post('modifCategorie/{categorieservice}', 'update');
    Route::post('supprimCategorie/{id}', 'destroy');
});


Route::controller(PrestationServiceController::class)->group(function () {
    Route::get('listePrestaService', 'index');
    Route::post('ajoutPrestaService', 'store');
    Route::get('affichPrestaService/{id}', 'show');
    Route::post('modifPrestaService/{prestatationservice}', 'update');
    Route::post('supprimPrestaService/{id}', 'destroy');
});


Route::controller(CommentaireController::class)->group(function () {
    Route::get('listeComment', 'index');
    Route::post('ajoutComment', 'store');
    Route::get('affichComment/{id}', 'show');
    Route::post('modifComment/{commentaire}', 'update');
    Route::post('supprimComment/{id}', 'destroy');
});

Route::controller(PrestationController::class)->group(function () {
    Route::get('listePrestation', 'index');
    Route::post('ajoutPrestation', 'store');
    Route::get('affichPrestation/{id}', 'show');
    Route::post('modifPrestation/{prestation}', 'update');
    Route::post('supprimPrestation/{id}', 'destroy');
});


Route::controller(MailController::class)->group(function () {
    Route::get('listeMail', 'index');
    Route::post('ajoutMail', 'store');
    Route::get('affichMail/{id}', 'show');
    Route::post('modifMail/{mail}', 'update');
    Route::post('supprimMail/{id}', 'destroy');
});
