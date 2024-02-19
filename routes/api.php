<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CategorieServiceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PrestataireController;
use App\Http\Controllers\PrestationController;
use App\Http\Controllers\PrestationServiceController;
use App\Models\User;
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
    Route::get('getAllUsers', 'getAllUsers');
});


Route::controller(PrestataireController::class)->group(function () {
    Route::post('ajouterPresta', 'store');
});
<<<<<<< HEAD
// });

// Route::middleware(['auth:api', 'role:client'])->group(function () {
// Route::controller(PrestataireController::class)->group(function () {
//     Route::get('listePrestataire', 'index');
//     Route::get('affichPrestataire{id}', 'show');
// });
// });

//Route::middleware(['auth:api', 'role:admin'])->group(function () {
Route::controller(CategorieServiceController::class)->group(function () {
    Route::get('listeCategorie', 'index');
    Route::get('listeCategorie', 'index');
    Route::post('ajouterCategorie', 'store');
    Route::get('affichCategorie/{id}', 'show');
    Route::post('modifCategorie/{categorieService}', 'update');
    Route::post('supprimCategorie/{id}', 'destroy');
});
//});

// Route::middleware(['auth:api', 'role:prestataire'])->group(function () {
// Route::controller(CategorieServiceController::class)->group(function () {
//     Route::get('listeCateg', 'index');

//     Route::get('affichCateg/{id}', 'show');
// });
// });

//Route::middleware(['auth:api', 'role:admin'])->group(function () {
Route::controller(PrestationServiceController::class)->group(function () {
    Route::get('listePrestaService', 'index');
    Route::post('ajoutPrestaService', 'store');
    Route::get('affichPrestaService/{id}', 'show');
    Route::post('modifPrestaService/{prestatationservice}', 'update');
    Route::post('supprimPrestaService/{id}', 'destroy');
     Route::get('affichPrestaire/{categorie}', 'categorieprestataire');
});
//});

// Route::middleware(['auth:api', 'role:prestataire'])->group(function () {
// Route::controller(PrestationServiceController::class)->group(function () {
//     Route::get('listePrestService', 'index');
//     Route::post('ajoutPrestService', 'store');
//     Route::get('affichPrestService/{id}', 'show');
//     Route::post('modifPrestService/{prestatationservice}', 'update');
//     Route::post('supprimPrestService/{id}', 'destroy');
// });
// });
=======
>>>>>>> 0ddf1a003936b0e21cb64d61766c2e78b4fa364b


Route::controller(ClientController::class)->group(function () {
    Route::post('ajouterclient', 'store');
});


//Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::controller(CategorieServiceController::class)->group(function () {
        Route::post('ajouterCategorie', 'store');
        Route::post('modifCategorie/{categorieService}', 'update');
        Route::post('supprimCategorie/{id}', 'destroy');
    });
//});


Route::controller(CategorieServiceController::class)->group(function () {
    Route::get('listeCategorie', 'index');
    Route::get('affichCategorie/{id}', 'show');
});

//Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::controller(PrestationServiceController::class)->group(function () {
        Route::post('ajoutPrestaS', 'store');
        Route::get('affichPrestaS/{id}', 'show');
        Route::post('modifPrestaS/{prestationService}', 'update');
        Route::post('supprimPrestaS/{id}', 'destroy');
    });
//});

//Route::middleware(['auth:api', 'role:client'])->group(function () {
    Route::controller(PrestationServiceController::class)->group(function () {
        Route::get('affichPrestService/{id}', 'show');
    });
//});

//Route::middleware(['auth:api', 'role:prestataire'])->group(function () {
    Route::controller(PrestationServiceController::class)->group(function () {
        Route::post('ajoutPrestaService', 'store');
        Route::get('affichPrestaService/{id}', 'show');
        Route::post('modifPrestaService/{prestationService}', 'update');
        Route::post('supprimPrestaService/{id}', 'destroy');
    });
//});


Route::controller(PrestationServiceController::class)->group(function () {
    Route::get('listePrestaService', 'index');
});


//Route::middleware(['auth:api', 'role:client'])->group(function () {
    Route::controller(PrestationController::class)->group(function () {
        Route::post('ajoutPrestation', 'store');
        Route::post('modifPrestation/{prestation}', 'update');
        Route::post('supprimPrestation/{id}', 'destroy');
    });
//});


//Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::controller(PrestationController::class)->group(function () {
        Route::post('ajoutPrestaclient', 'store');
        Route::post('modifPrestaclient/{prestation}', 'update');
        Route::post('supprimPrestaclient/{id}', 'destroy');
    });
//});


Route::controller(PrestationController::class)->group(function () {
    Route::get('listePrestation', 'index');
    Route::get('affichPrestation/{id}', 'show');
});

//Route::middleware(['auth:api', 'role:client'])->group(function () {
    Route::controller(CommentaireController::class)->group(function () {
        Route::post('ajoutComment', 'store');
        Route::post('modifComment/{commentaire}', 'update');
        Route::post('supprimComment/{id}', 'destroy');
    });
//});


Route::controller(CommentaireController::class)->group(function () {
    Route::get('listeComment', 'index');
    Route::get('affichComment/{id}', 'show');
});



Route::controller(MailController::class)->group(function () {
    Route::get('listeMail', 'index');
    Route::post('ajoutMail', 'store');
    //     Route::get('affichMail/{id}', 'show');
    //     Route::post('modifMail/{mail}', 'update');
    Route::post('supprimMail/{id}', 'destroy');
});
