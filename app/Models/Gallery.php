<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'adresse',
        'code_postal',
        'ville',
        'telephone',
        'email',
        'forme_juridique',
        'dirigeant',
        'immatriculation',
        'annee_ca',
        'ca',
        'resultat',
        'effectif',
        'naf_ape',
        'siret',
        'effectif_min',
        'effectif_max',
    ];
}