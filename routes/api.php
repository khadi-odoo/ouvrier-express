<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CategorieServiceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\PrestataireController;
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
    Route::post('listePresta', 'index');
    Route::post('ajouterPresta', 'store');
    Route::post('ajouterPrestataire', 'ajouterPrestataire');
    Route::get('affichPresta', 'show');
    Route::patch('modifPresta', 'update');
    Route::patch('supprimPresta', 'destroy');
});


Route::controller(ClientController::class)->group(function () {
    Route::post('listeclient', 'index');
    Route::post('ajouterclient', 'store');
    Route::get('afficherclient', 'show');
    Route::patch('modifclient', 'update');
    Route::patch('supprimclient', 'destroy');
});


Route::controller(CategorieServiceController::class)->group(function () {
    Route::post('listeCétegorie', 'index');
    Route::post('ajouterCategorie', 'store');
    Route::get('affichCategorie', 'show');
    Route::patch('modifCategorie', 'update');
    Route::patch('supprimCat', 'destroy');
});


Route::controller(PrestationServiceController::class)->group(function () {
    Route::post('listePrestaService', 'index');
    Route::post('ajoutPrestaService', 'store');
    Route::get('affichPrestaService', 'show');
    Route::patch('modifPrestaService', 'update');
    Route::patch('supprimPrestaService', 'destroy');
});


Route::controller(CommentaireController::class)->group(function () {
    // Route::post('listeComment', 'index');
    Route::post('ajoutComment', 'store');
    Route::get('affichComment', 'show');
    Route::patch('modifComment', 'update');
    Route::patch('supprimComment', 'destroy');
});
