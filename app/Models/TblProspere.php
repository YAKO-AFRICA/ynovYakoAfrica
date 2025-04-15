<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblProspere extends Model
{
    use HasFactory;
    protected $connection = 'mysql3';
    protected $table = 'prospects';
    protected $fillable = [
        'uuid',
        'code',
        'first_name',
        'last_name',
        'mobile',
        'email',
        'adress',
        'montantPrime',
        'dateEffet',
        'profession_uuid',
        'secteurActivity_uuid',
        'modeDePaiment',
        'typeCompagnie',
        'city',
        'lieuEvenement',
        'natureProspect',
        'note',
        'produit_id',
        'etat',
        'status',
        'userAdd_uuid',
        'userDestroy_uuid',
        'destroy_date',
    ];
}
