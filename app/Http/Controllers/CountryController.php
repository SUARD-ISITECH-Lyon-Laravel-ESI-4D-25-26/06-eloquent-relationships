<?php

namespace App\Http\Controllers;

use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        // TÂCHE : chargez la moyenne de la taille des équipes via la relation (withAvg)
        // Indice : consultez la documentation Eloquent sur withAvg (https://laravel.com/docs/eloquent-relationships#other-aggregate-functions)
        $countries = Country::all();

        return view('countries.index', compact('countries'));
    }
}
