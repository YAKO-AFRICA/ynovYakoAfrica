<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contrat;
use App\Models\Partner;
use App\Models\Product;
use App\Models\TblVille;
use App\Models\TblAgence;
use App\Models\MotifRejet;
use App\Models\TblSociete;
use Illuminate\Http\Request;
use App\Models\TblProfession;
use App\Models\ProduitGarantie;
use App\Models\TblSecteurActivite;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contrats = Contrat::where(['etape'=> '2', 'estMigre' => '0'])->get();
        // dd($contrats);
        $partners = Partner::where('code' ,'!=' , '092')->get();
        $PartContrat = $partners->map(function ($partner) use ($contrats) {
            return [
                'partner' => $partner,
                'contrats' => $contrats->filter(function ($contrat) use ($partner) {
                    return $contrat->partenaire == $partner->code;
                })
            ];
        });

        $partBNI = Partner::where('code', '092')->first(); // Un seul partenaire

        if ($partBNI) {
            $PartBNIContrat = [
                'partner' => $partBNI,
                'contrats' => $contrats->filter(function ($contrat) use ($partBNI) {
                    return $contrat->partenaire == $partBNI->code;
                })
            ];
        } else {
            $PartBNIContrat = null; // Gérer le cas où aucun partenaire n'est trouvé
        }
        // dd($PartContrat);
        return view('productions.validations.index', compact('PartContrat', 'PartBNIContrat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function prodByPartner(Request $request, $code)
{
    set_time_limit(300);

    $partners = Partner::where('code', $code)->first();
    
    // Récupération des contrats du partenaire
    $allPropositions = Contrat::where('partenaire', $code)->with('user')->get();
    // dd($allPropositions);
    $acceptedPropositions = Contrat::where(['partenaire' => $code, 'estMigre' => 1, 'etape' => 3])->get();
    $contratsEtape2Today = Contrat::where(['etape' => 2, 'partenaire' => $code])
    ->whereDate('saisiele', now()->toDateString()) // Filtre pour aujourd'hui
    ->count();
    $defaultColumns = ['#', 'Produit', 'Date Effet', 'Prime', 'Capital', 'Saisir Par', 'Status'];

    $additionalColumns = [
        'Mode de Paiement' => 'modepaiement',
        'Organisme' => 'organisme',
        'Prime' => 'prime',
        'Prime Principale' => 'primepricipale',
        'Capital' => 'capital',
        'Surprime' => 'surprime',
        'Date Effet' => 'dateeffet',
        'N° Compte' => 'numerocompte',
        'Agence' => 'agence',
        'Saisie Le' => 'saisiele',
        'Code Conseiller' => 'codeConseiller',
        'Nom Agent' => 'nomagent',
        'Duree' => 'duree',
        'Periodicite' => 'periodicite',
        'Code Adherent' => 'codeadherent',
        'Est Migre' => 'estMigre',
        'Transmis Le' => 'transmisle',
        'Annuler Le' => 'annulerle',
        'Accepter Le' => 'accepterle',
        'Modifier Le' => 'modifierle',
        'Modifier Par' => 'modifierpar',
        'Libelle Produit' => 'libelleproduit',
        'Personne Ressourource' => 'personneressource',
        'Contact Ressourource' => 'contactpersonneressource',
        'Beneficiaire Auterme' => 'beneficiaireauterme',
        'Beneficiaire Audeces' => 'beneficiaireaudeces',
        'Accepter Par' => 'accepterpar',
        'Rejeter Par' => 'rejeterpar',
        'Transmis Par' => 'transmispar',
        'Personne Ressource 2' => 'personneressource2',
        'Contact Ressource 2' => 'contactpersonneressource2',
        'Code Banque' => 'codebanque',
        'Code Guichet' => 'codeguichet',
        'Rib' => 'rib',
        'Id Proposition' => 'idproposition',
        'Code Proposition' => 'codeproposition',
        'Branche' => 'branche',
        'Partenaire' => 'partenaire',
        'Nom Accepter Par' => 'nomaccepterpar',
        'Ref Contrat Source' => 'refcontratsource',
        'Cle Integration' => 'cleintegration',
        'Code Operation' => 'codeoperation',
        'N° Police' => 'numeropolice',
        'Frais Adhesion' => 'fraisadhesion',
        'Est Paye' => 'estpaye',
        'Pret Connexe' => 'pretconnexe',
        'Details' => 'details',
    ];

    $activeColumns = session('activeColumns', []);

    return view('productions.validations.prodByPartner', [
        'datas' => collect([
            'allPropositions' => $allPropositions,
            'contratsEtape2Today' => $contratsEtape2Today,
            'acceptedPropositions' => $acceptedPropositions,
            'partners' => $partners
        ]),
        'activeColumns' => $activeColumns,
        'defaultColumns' => $defaultColumns,
        'additionalColumns' => $additionalColumns
    ]);
}


    /**
     * Store a newly created resource in storage.
     */
    public function acceptContrat(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
                $contrat = Contrat::find($id);
    
                if ($contrat) {
                    $contrat->update(
                        
                        [
                            'accepterle' => now(),
                            'accepterpar' => Auth::user()->membre->idmembre,
                            'etape' => 3,
                            'estMigre' => 1,
                            'cleintegration' => now()->format('YmdHis'),
                        ]
                    );

                    DB::commit();
                
                    return response()->json([
                        'type' => 'success',
                        'urlback' => \route('prod.validation.prodByPartner', $contrat->partenaire),
                        'message' => "Proposition N° " . $id . " validée avec succès!",
                        'code' => 200,
                    ]);
                } else {
                    return response()->json([
                        'type' => 'error',
                        'urlback' => 'back',
                        'message' => "Erreur lors du rejet de la proposition N° " . $id . "!",
                        'code' => 200,
                    ]);
                }
       
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Erreur système! $th",
                    'code' => 500,
                ]);
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        set_time_limit(300);
        $CodeProduit = Contrat::where('id', $id)->first()->codeproduit;
        $productGarantie = ProduitGarantie::where('CodeProduit',$CodeProduit)->get();
        $motifs = MotifRejet::where('etat', 'actif')->get();

        $contrat = Contrat::where('id', $id)->first();

        return view('productions.validations.show', compact('contrat', 'productGarantie', 'motifs'));
    }

    public function rejetContrat(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
                $contrat = Contrat::find($id);
    
                if ($contrat) {
                    $contrat->update(
                        [
                            'annulerle' => now(),
                            'etape' => 4,
                            'motifrejet' => $request->motifrejet,
                            'rejeterpar' => Auth::user()->membre->idmembre
                        ]
                    );

                    DB::commit();
                
                    return response()->json([
                        'type' => 'success',
                        'urlback' => \route('prod.validation.prodByPartner', $contrat->partenaire),
                        'message' => "Proposition N° " . $id . " rejetée avec succès!",
                        'code' => 200,
                    ]);
                } else {
                    return response()->json([
                        'type' => 'error',
                        'urlback' => 'back',
                        'message' => "Erreur lors du rejet de la proposition N° " . $id . "!",
                        'code' => 200,
                    ]);
                }
       
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Erreur système! $th",
                    'code' => 500,
                ]);
            }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        // $contrat = Contrat::where('id', $id)->first();

        $contrat = Contrat::where('id', $id)->with('adherent','produit')->first();
        $productGarantie = ProduitGarantie::where('CodeProduit',$contrat->codeproduit)->get(); 
        $product = Product::where('CodeProduit',$contrat->codeproduit)->first(); 
        $villes =  TblVille::get();
        $professions =  TblProfession::select('MonLibelle')->get();
        $secteurActivites =  TblSecteurActivite::select('MonLibelle')->get();
        $societes =  TblSociete::select('MonLibelle')->get();
        $agences =  TblAgence::select('NOM_LONG')->get();
        return view('productions.validations.edit', compact('contrat', 'product', 'villes', 'secteurActivites', 'professions','productGarantie','societes','agences'));

    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
