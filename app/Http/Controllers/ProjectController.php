<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        // TÂCHE : ajoutez une ligne pour enregistrer le projet de l'utilisateur connecté
        //   en utilisant $request->project_id et le paramètre $request->start_date
        // Indice : utilisez la méthode attach() ou sync() sur la relation belongsToMany (https://laravel.com/docs/eloquent-relationships#attaching-detaching)
        // Votre code ici

        return 'Success';
    }
}
