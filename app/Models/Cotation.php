<?php

namespace App\Models;

use App\Models\Contrat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotation extends Model
{
    use HasFactory;

    protected $table = 'cotations';

    protected $fillable = [
        'uuid',
        'code',
        'id_contrat',
        'nomCompletSouscripteur',
        'telephoneSouscripteur',
        'autheur',
        'note',
        'status',
        'etat'
    ];

    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'id_contrat', 'id');
    }
}
