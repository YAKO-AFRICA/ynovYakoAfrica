<?php

namespace App\Models;

use App\Models\ProduitGarantie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'tblproduit';

    protected $fillable = [
        'CodeProduit',
        'MonLibelle',
        'DateProduit',
        'CodeBranche',
        'CodeProduitNature',
        'CodeDocument',
        'CodeTxTech',
        'Statut',
        'CodeGroupeAssure',
        'CodeGroupeProfil',
        'AgeMiniAdh',
        'AgeMaxiAdh',
        'TableTarification',
        'TableReglementaire',
        'TableFiscale',
        'TableComptable',
        'CodeContractant',
        'NumSeq',
        'DelaiCarrence',
        'CapitalAssurePMOK',
        'CapitalassureVersExcpOK',
        'CodeBrancheDeux',
        'TypeContrat',
        'Capital',
        'CodeProduitCourt',
        'ID_Old',
        'DureeSouscriptionAnnee',
        'DureeSouscriptionMois',
        'VieEntiere',
        'DureeCotisationAns',
        'DureeCotisationMois',
        'CodeMarque',
    ];

    public function garanties()
    {
        return $this->hasMany(ProduitGarantie::class, 'CodeProduit', 'codeproduit');
    }
    
}


