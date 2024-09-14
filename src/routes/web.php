<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActifController;
use App\Http\Controllers\BilanController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\PassifController;
use App\Http\Controllers\FormuleController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompteResultatController;

// Routes protégées par l'authentification
Route::middleware('auth')->group(function () {
    // Page d'accueil
    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::middleware(['admin'])->group(function() {
        // Liste
        Route::get('/users', [UserController::class, 'index'])->name('users.list');

        // Ajouter
        Route::get('/users/add', [UserController::class, 'add'])->name('users.add');
        Route::post('/users/add', [UserController::class, 'store'])->name('users.post.add');

        // Editer un utilisateur
        Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/add/{user}', [UserController::class, 'update'])->name('users.post.edit');

        // Supprimer un utilisateur
        Route::post('/users/delete/{user}', [UserController::class, 'destroy'])->name('users.post.delete');
    });

    // Gestion des bilans
    Route::prefix('/bilan')->group(function () {
        // Gestion des passifs
        Route::get('/passifs', [PassifController::class, 'index'])->name('passif.list');
        Route::get('/passifs/add', [PassifController::class, 'create'])->name('passif.add');
        Route::post('/passifs/add', [PassifController::class, 'store'])->name('passif.post.add');
        Route::get('/passifs/edit/{passif}', [PassifController::class, 'edit'])->name('passif.edit');
        Route::post('/passifs/edit/{passif}', [PassifController::class, 'update'])->name('passif.post.edit');
        Route::post('/passifs/delete/{passif}', [PassifController::class, 'destroy'])->name('passif.post.delete');

        // Gestion des actifs
        Route::get('/actifs', [ActifController::class, 'index'])->name('actif.list');
        Route::get('/actifs/add', [ActifController::class, 'create'])->name('actif.add');
        Route::post('/actifs/add', [ActifController::class, 'store'])->name('actif.post.add');
        Route::get('/actifs/edit/{actif}', [ActifController::class, 'edit'])->name('actif.edit');
        Route::post('/actifs/edit/{actif}', [ActifController::class, 'update'])->name('actif.post.edit');
        Route::post('/actifs/delete/{actif}', [ActifController::class, 'destroy'])->name('actif.post.delete');

        // Gestion des bilans
        Route::get('/', [BilanController::class, 'index'])->name('bilan.list');
        Route::get('/add', [BilanController::class, 'create'])->name('bilan.add');
        Route::post('/add', [BilanController::class, 'store'])->name('bilan.post.add');
        Route::get('/edit/{bilan}', [BilanController::class, 'edit'])->name('bilan.edit');
        Route::post('/edit/{bilan}', [BilanController::class, 'update'])->name('bilan.post.edit');
        Route::post('/delete/{bilan}', [BilanController::class, 'destroy'])->name('bilan.post.delete');
        Route::get('/show/{bilan}', [BilanController::class, 'show'])->name('bilan.show');
    });

    // Gestion des comptes de résultat
    Route::prefix('/compte-resultat')->group(function () {
        // Gestion des produits
        Route::get('/produits', [ProduitController::class, 'index'])->name('produit.list');
        Route::get('/produits/add', [ProduitController::class, 'create'])->name('produit.add');
        Route::post('/produits/add', [ProduitController::class, 'store'])->name('produit.post.add');
        Route::get('/produits/edit/{produit}', [ProduitController::class, 'edit'])->name('produit.edit');
        Route::post('/produits/edit/{produit}', [ProduitController::class, 'update'])->name('produit.post.edit');
        Route::post('/produits/delete/{produit}', [ProduitController::class, 'destroy'])->name('produit.post.delete');

        // Gestion des charges
        Route::get('/charges', [ChargeController::class, 'index'])->name('charge.list');
        Route::get('/charges/add', [ChargeController::class, 'create'])->name('charge.add');
        Route::post('/charges/add', [ChargeController::class, 'store'])->name('charge.post.add');
        Route::get('/charges/edit/{charge}', [ChargeController::class, 'edit'])->name('charge.edit');
        Route::post('/charges/edit/{charge}', [ChargeController::class, 'update'])->name('charge.post.edit');
        Route::post('/charges/delete/{charge}', [ChargeController::class, 'destroy'])->name('charge.post.delete');

        // Gestion des comptes des resultats
        Route::get('/', [CompteResultatController::class, 'index'])->name('compte-resultat.list');
        Route::get('/add', [CompteResultatController::class, 'create'])->name('compte-resultat.add');
        Route::post('/add', [CompteResultatController::class, 'store'])->name('compte-resultat.post.add');
        Route::get('/edit/{compteResultat}', [CompteResultatController::class, 'edit'])->name('compte-resultat.edit');
        Route::post('/edit/{compteResultat}', [CompteResultatController::class, 'update'])->name('compte-resultat.post.edit');
        Route::post('/delete/{compteResultat}', [CompteResultatController::class, 'destroy'])->name('compte-resultat.post.delete');
        Route::get('/show/{compteResultat}', [CompteResultatController::class, 'show'])->name('compte-resultat.show');
    });

    Route::middleware(['admin'])->group(function() {
        // Gestion des formules
        Route::get('/formules/compte-resultat', [FormuleController::class, 'compteResultat'])->name('formulas.compte-resultat');
        Route::get('/formules/ratios', [FormuleController::class, 'ratios'])->name('formules.ratios');
    });

    // Profil de l'utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Mettre à jour le profil de l'utilisateur
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Supprimer le compte de l'utilisateur
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes d'authentification
require __DIR__.'/auth.php';
