<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size', 'country_id'];

    public function users()
    {
        // TÂCHE : corrigez cette méthode en ajoutant le code nécessaire pour exposer les champs supplémentaires de la table pivot (withPivot)
        return $this->belongsToMany(User::class);
    }

}
