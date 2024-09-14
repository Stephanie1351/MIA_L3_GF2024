<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Permet de lister tous les utilisateurs
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::all();

        return view("users.list", [
            "users" => $users
        ]);
    }

    /**
     * Formulaire d'ajout de nouveau utilisateur
     *
     * @return View
     */
    public function add(): View
    {
        return view("users.add");
    }

    /**
     * Enregistrer un nouvel utilisateur dans la base de données
     *
     * @param Request $request L'objet de requête contenant les données du nouvel utilisateur
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            "name" => ["required", "string"],
            "email" => ["required", "email", "unique:users,email"],
            "role" => ["required", "in:0,1"],
            "password" => ["required"]
        ]);

        $data["password"] = Hash::make($data["password"]);
        $data["is_admin"] = $data["role"];
        $user = User::create($data);

        if ($user) return to_route("users.list")->with("success", "Utilisateur créé avec succès");
        return back()->with("error", "Impossible de créer l'utilisateur")->withInput();
    }

    /**
     * Afficher le formulaire de modification d'un utilisateur
     *
     * @param User $user L'utilisateur à modifier
     * @return View
     */
    public function edit(User $user): View
    {
        return view("users.edit", [
            "user" => $user
        ]);
    }

    /**
     * Mettre à jour les informations d'un utilisateur dans la base de données
     *
     * @param Request $request L'objet de requête contenant les données mises à jour de l'utilisateur
     * @param User $user L'utilisateur à mettre à jour
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            "name" => ["required", "string"],
            "email" => ["required", "email", "unique:users,email,{$user->id},id"],
            "role" => ["required", "in:0,1"],
            "password" => ["nullable"]
        ]);

        $data["password"] = $data["password"] ? Hash::make($data["password"]) : $user->password;
        $data["is_admin"] = $data["role"];
        $update = $user->update($data);

        if ($update) return to_route("users.list")->with("success", "Utilisateur modifié");
        return back()->with("error", "Impossible de modifier l'utilisateur")->withInput();
    }

    /**
     * Supprimer un utilisateur de la base de données
     *
     * @param User $user L'utilisateur à supprimer
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $delete = $user->delete();
        if ($delete) return back()->with("success", "Supprimé");
        return back()->with("error", "Impossible de supprimer l'utilisateur");
    }
}
