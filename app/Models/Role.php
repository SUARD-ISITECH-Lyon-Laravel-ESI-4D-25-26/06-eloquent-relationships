<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        // TÂCHE : corrigez cette méthode en ajoutant le paramètre manquant (nom de la table pivot)
        return $this->belongsToMany(User::class);
    }
}
