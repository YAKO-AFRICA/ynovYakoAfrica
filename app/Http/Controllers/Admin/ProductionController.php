<?php

namespace App\Http\Controllers\Admin;

use PDF;

use Carbon\Carbon;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\User;
use App\Models\Assurer;
use App\Models\Contrat;
use App\Models\Product;
use BaconQrCode\Writer;
use setasign\Fpdi\Fpdi;
use App\Models\Adherent;
use App\Models\Document;
use App\Models\Prospect;
use App\Models\TblVille;
use App\Models\TblAgence;
use App\Models\Filliation;
use App\Models\Profession;
use App\Models\TblSociete;
use Illuminate\Support\Str;
use App\Models\Beneficiaire;
use Illuminate\Http\Request;
use App\Models\ReseauProduct;
use App\Models\TblProfession;
use App\Models\AssureGarantie;
use App\Models\ProduitGarantie;
use BaconQrCode\Encoder\QrCode;
use App\Models\DeclarationSante;
use App\Models\TblSecteurActivite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Notifications\SystemeNotify;

use Illuminate\Support\Facades\Notification;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use BaconQrCode\Renderer\ImageRenderer;
use Illuminate\Support\Facades\Session;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd; // Alternative SVG
use BaconQrCode\Renderer\Image\ImagickImageBackEnd; // Utilisez Imagick si disponible

class ProductionController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        set_time_limit(300);
        $mesPropositions = Contrat::where('saisiepar', Auth::user()->idmembre)->get();
        $allPropositionssss = Contrat::where('etape', "!=", "");
        $allPropositions = Contrat::where('saisiepar', Auth::user()->idmembre);

        $defaultColumns = ['#', 'Produit', 'Date Effet', 'Prime', 'Capital', 'Montant Rente', 'Saisir Par', 'Status'];

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

        $selectedStatus = $request->input('etape');

        if ($selectedStatus) {
            // Filtrez par statut si un statut est sélectionné
            $allPropositions->where('etape', $selectedStatus);
        }

        $allPropositionsFiltered = $allPropositions->get();


        $datas = collect([
            'allPropositionsFiltered' => $allPropositionsFiltered,
            'mesPropositions' => $mesPropositions,
            'allPropositions' => $allPropositions,
        ]);
        return view('productions.index', ['datas' => $datas, 'activeColumns' => $activeColumns, 'defaultColumns' => $defaultColumns, 'additionalColumns' => $additionalColumns]);
    }



    public function stepProduct()
    {

        $productByReseau = ReseauProduct::select('CodeProduit')
            ->where('codereseau', Auth::user()->membre->codereseau)
            ->get();


        $codeProduits = $productByReseau->pluck('CodeProduit')->toArray();


        if (Auth::user()->membre->codepartenaire === "LLV") {
            $products = Product::whereIn('CodeProduit', $codeProduits)->get();
        } else {
            $products = Product::whereIn('CodeProduit', $codeProduits)->get();
        }



        // dd($products);
        return view('productions.create.steps.stepProduct', compact('products'));
    }

    public function searchAdherant(Request $request)
    {
        $request->validate([
            'methodeRecherche' => 'required|in:numerocompte,numPiece',
            'query' => 'required|string'
        ]);
    
        $query = $request->input('query');
        $methodeRecherche = $request->input('methodeRecherche');
    
        $apiData = [
            $methodeRecherche => $query
        ];
    
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post('https://api.yakoafricassur.com/enov/search-personne-web', [
                'form_params' => $apiData,
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MjExODcyLCJlbWFpbCI6ImZvcm1hdGlvbi5ibmlAYm5pLmNvbSIsIm5vbSI6IkJOSSIsImNvZGVhZ2VudCI6IkIwNDAiLCJ0eXBlbWVicmUiOm51bGwsInByZW5vbSI6IkZvcm1hdGlvbiJ9.gwxwy43VeMDcfaTpgpFbuWkxjirIBqvuXq3UZOuw_nA',
                ]
            ]);
    
            $apiResponse = json_decode($response->getBody(), true);
    
            if (!empty($apiResponse['dataPersonne'])) {
                $clientData = $apiResponse['dataPersonne'];
                
                // Formater les données pour correspondre à vos champs de formulaire
                $formattedData = [
                    'civilite' => $clientData['civilite'] ?? '',
                    'nom' => $clientData['nom'] ?? '',
                    'prenom' => $clientData['prenom'] ?? '',
                    'datenaissance' => $clientData['datenaissance'] ?? '',
                    'lieunaissance' => $clientData['lieunaissance'] ?? '',
                    'naturepiece' => $clientData['naturepiece'] ?? '',
                    'numeropiece' => $clientData['numeropiece'] ?? '',
                    'lieuresidence' => $clientData['lieuresidence'] ?? '',
                    'profession' => $clientData['profession'] ?? '',
                    'employeur' => $clientData['employeur'] ?? '',
                    'email' => $clientData['email'] ?? '',
                    'mobile' => $clientData['mobile'] ?? '',
                    'mobile1' => $clientData['mobile1'] ?? '',
                    'telephone' => $clientData['telephone'] ?? '',
                    'numerocompte' => $clientData['numerocompte'] ?? ''
                ];
                
                session()->put('adherent', $formattedData);
                
                return response()->json([
                    'type' => 'success',
                    'message' => 'Client trouvé avec succès', 
                    'code' => 200,
                    'data' => $formattedData
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Aucun client trouvé avec ces informations',
                    'code' => 404
                ]);
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $errorMessage = 'Erreur lors de la connexion à l\'API';
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody(), true);
                $errorMessage = $response['message'] ?? $errorMessage;
            }
            
            return response()->json([
                'type' => 'error',
                'message' => $errorMessage,
                'code' => 500
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => 'Erreur lors de la recherche: ' . $e->getMessage(),
                'code' => 500
            ]);
        }
    }



    public function addAssureToSession(Request $request)
    {
        // Récupérer les assurés actuels dans la session ou initialiser un tableau vide
        $assures = session()->get('assures', []);

        // Ajouter les informations du nouvel assuré
        $assures[] = $request->only(['civiliteAssur', 'nomAssur', 'prenomAssur', 'datenaissanceAssur', 'lieunaissanceAssur', 'naturepieceAssur', 'numeropieceAssur', 'lieuresidenceAssur', 'lienParente', 'mobileAssur', 'emailAssur']);

        // Stocker les informations mises à jour dans la session
        session()->put('assures', $assures);

        return response()->json(['message' => 'Assuré ajouté avec succès', 'assures' => $assures]);
    }

    public function getAssuresFromSession()
    {
        $assures = session()->get('assures', []);
        return response()->json($assures);
    }

    public function create($codeProduit)
    {
        $product = Product::where('CodeProduit', $codeProduit)->first();
        $productGarantie = ProduitGarantie::where(['codeproduit' => $codeProduit, 'branche' => 'IND'])->get();
        $villes = TblVille::select('libelleVillle')->get();
        $professions = Profession::select('MonLibelle')->get();
        $secteurActivites = TblSecteurActivite::select('MonLibelle')->get();
        $societes = TblSociete::select('MonLibelle')->get();
        $agences = TblAgence::select('NOM_LONG')->get();
        $filliations = Filliation::select('MonLibelle')->get();
       
        $resultData = session()->get('adherent', []);
        $response = Http::withOptions(['timeout' => 60])
        ->get(env('API_GET_COUNTRIES'));
        if ($response->successful()) {
            $countries = $response->json();

            $detailCountries = $countries['countries'];
            // dd($detailCountries);
            
        }

        return view('productions.create.create', compact('product', 'villes', 'secteurActivites', 'professions', 'productGarantie', 'societes', 'agences', 'filliations', 'resultData', 'detailCountries'));
    }

 
    public function createdoihoo($codeProduit)
    {
        $product = Product::where('CodeProduit', $codeProduit)->first();
        $productGarantie = ProduitGarantie::where(['codeproduit' => $codeProduit, 'branche' => 'IND'])->get();

        return view('productions.create.simulateur.doihoSimulateur', compact('product', 'productGarantie'));
    }
    public function createCAD($codeProduit)
    {
        $product = Product::where('CodeProduit', $codeProduit)->first();
        $productGarantie = ProduitGarantie::where(['codeproduit' => $codeProduit, 'branche' => 'IND'])->get();

        return view('productions.create.simulateur.simulateurForm', compact('product', 'productGarantie'));
    }
    public function createYke($codeProduit)
    {

        $product = Product::where('CodeProduit', $codeProduit)->first();
        $productGarantie = ProduitGarantie::where(['codeproduit' => $codeProduit, 'branche' => 'IND'])->get();



        return view('productions.create.simulateur.ykeSimulateur', compact('product', 'productGarantie'));
    }
    public function createKds($codeProduit)
    {

        $product = Product::where('CodeProduit', $codeProduit)->first();
        $productGarantie = ProduitGarantie::where(['codeproduit' => $codeProduit, 'branche' => 'IND'])->get();



        return view('productions.create.simulateur.kdsSimulateur', compact('product', 'productGarantie'));
    }




    public function storeSimulationPrime(Request $request)
    {
        // Vérification des données reçues
        $garanties = $request->json()->all();  // Assure de récupérer un JSON valide

        if (empty($garanties)) {
            return response()->json(['error' => 'Aucune donnée reçue.'], 400);
        }

        // Stocker dans la session Laravel
        Session::put('simulation_primes', $garanties);

        return response()->json(['message' => 'Données enregistrées en session avec succès.', 'data' => $garanties], 200);
    }

    

    public function ykePrime(Request $request)
    {
        $ykeGar = ProduitGarantie::where(['codeproduit' => 'YKE_2018', 'branche' => 'IND'])->get();

        $ykePer = $request->input('periodicite');
        $ykeProd = "YKE_2018";

        foreach ($ykeGar as $gar) {
            $gar->prime = $request->input('prime' . $gar->id);
        }

        return response()->json($ykeGar);
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        if (!empty($request->inputSessionData)) {
            $simulationData = json_decode($request->inputSessionData);

            // Log::info('Données de simulation reçues:'. $simulationData);
        }

        DB::beginTransaction();
        try { 

            // Gestion de la civilité pour l'adhérent et l'assuré
            $sexe = $request->civilite === "Monsieur" ? "M" : "F";
            $sexeassur = $request->civiliteAssur === "Monsieur" ? "M" : "F";
            $primeCalcule = $request->primepricipale + $request->surprime + $request->fraisadhesion;
            $datenaissance = Carbon::parse($request->datenaissance)->format('Y-m-d H:i:s');

            $age = Carbon::parse($datenaissance)->diffInYears(Carbon::now());

            // creation id 
            $idAdherent = Adherent::max('id') + 1;
            $idAssure = Assurer::max('id') + 1;
            $idBenef = Beneficiaire::max('id') + 1;
            $idContrat = Contrat::max('id') + 1;
            $idDocument = Document::max('id') + 1;


            // creation de l'adhérent

            $Adherent = Adherent::create([
                'id' => $idAdherent,
                'civilite' => $request->civilite,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'datenaissance' => $datenaissance,
                'lieunaissance' => $request->lieunaissance,
                'sexe' => $sexe,
                'numeropiece' => $request->numeropiece,
                'naturepiece' => $request->naturepiece,
                'lieuresidence' => $request->lieuresidence,
                'profession' => $request->profession,
                'employeur' => $request->employeur,
                'pays' => $request->pays,
                'estmigre' => 0,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'telephone1' => $request->telephone1,
                'mobile' => $request->mobile,
                'codemembre' => 0,
                'mobile1' => $request->mobile1,
                'saisieLe' => now(),
                'saisiepar' => Auth::user()->membre->idmembre,
                'refcontratsource' => $request->refcontratsource,
                'cleintegration' => $request->cleintegration,
                'id_maj' => $request->id_maj,
                'connexe' => $request->connexe,
                'contratconnexe' => $request->contratconnexe,
                'capitalconnexe' => $request->capitalconnexe
            ]);

            // creation de l'assuré souscripteur

            if ($request->estAssure === "Oui") {

                $Assurer = Assurer::create([
                    'id' => $idAssure,
                    'civilite' => $request->civilite,
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'filiation' => "LUIMM",
                    'datenaissance' => $datenaissance,
                    'lieunaissance' => $request->lieunaissance,
                    'codecontrat' => $idContrat,
                    'codeadherent' => $idAdherent,
                    'sexe' => $sexe,
                    'numeropiece' => $request->numeropiece,
                    'naturepiece' => $request->naturepiece,
                    'lieuresidence' => $request->lieuresidence,
                    'profession' => $request->profession,
                    'employeur' => $request->employeur,
                    'pays' => $request->pays,
                    'email' => $request->email,
                    'telephone' => $request->telephone,
                    'telephone1' => $request->telephone1,
                    'mobile' => $request->mobile,
                    'codemembre' => 0,
                    'mobile1' => $request->mobile1,
                    'saisieLe' => now(),
                    'saisiepar' => auth::user()->membre->idmembre,
                ]);
            }


            // recupere & creer les assurer de la session

            $assures = json_decode($request->input('assures'), true);
            Log::info("assures". $assures);

            if ($assures) {
                foreach ($assures as $assure) {
                    $datenaissanceAssur = isset($assure['datenaissance']) ? Carbon::parse($assure['datenaissance'])->format('Y-m-d H:i:s') : null;
                    $idAssureInsert = Assurer::max('id') + 1;

                    $sexeassurAdd = $assure['civilite'] === "Monsieur" ? "M" : "F";
                    Assurer::create([
                        'id' => $idAssureInsert,
                        'civilite' => $assure['civilite'],
                        'nom' => $assure['nom'],
                        'prenom' => $assure['prenom'],
                        'datenaissance' => $datenaissanceAssur,
                        'codecontrat' => $idContrat,
                        'codeadherent' => $idAdherent,
                        'lieunaissance' => $assure['lieuNaissance'],
                        'numeropiece' => $assure['numeropieceAssur'] ?? null,
                        'naturepiece' => $assure['naturepieceAssur'] ?? null,
                        'lieuresidence' => $assure['lieuresidenceAssur'] ?? null,
                        'filiation' => $assure['lienParente'],
                        'mobile' => $assure['mobileAssur'] ?? null,
                        'estmigre' => $request->estmigre ?? null,
                        'email' => $assure['emailAssur'] ?? null,
                        'sexe' => $sexeassurAdd,
                        'saisieLe' => now(),
                        'saisiepar' => Auth::user()->membre->idmembre,
                    ]);
                    
                }
            }

            // creation des garanties

            foreach ($simulationData->garantieData as $garantie) {
                // Log::info("garantie". $garantie);
                $GarantieOnBD = ProduitGarantie::where('codeproduitgarantie', $garantie->codeGarantie)->first();

                AssureGarantie::create([
                    'codeproduitgarantie' => $garantie->codeGarantie,
                    'idproduitparantie' => $GarantieOnBD->id ?? null,
                    'monlibelle' => $garantie->libelle,
                    'prime' => $garantie->prime,
                    'primetotal' => $request->prime,
                    'primeaccesoire' => 0,
                    'type' => "Mixte",
                    'capitalgarantie' => $garantie->capital,
                    'codeassure' => $idAssure,
                    'codecontrat' => $idContrat,
                    'refcontratsource' => $idContrat,
                    'estmigre' => 0,
                ])->save();
            }

            $santeData = DeclarationSante::create([
                'taille' => $request->taille,
                'poids' => $request->poids,
                'tensionMin' => $request->tensionMin,
                'tensionMax' => $request->tensionMax,
                'smoking' => $request->smoking,
                'alcohol' => $request->alcohol,
                'sport' => $request->sport,
                'typeSport' => $request->typeSport,
                'accident' => $request->accident,
                'treatment' => $request->treatment, // trantement medical 6 dernier mois
                'transSang' => $request->transSang, // transfusion de sang 6 dernier mois
                'interChirugiale' => $request->interChirugiale, // intervention chirurgicaledeja subit
                'prochaineInterChirugiale' => $request->prochaineInterChirugiale, // intervention chirurgicale prochaine
                'diabetes' => $request->diabetes,
                'hypertension' => $request->hypertension,
                'sickleCell' => $request->sickleCell,
                'liverCirrhosis' => $request->liverCirrhosis,
                'lungDisease' => $request->lungDisease,
                'cancer' => $request->cancer,
                'anemia' => $request->anemia,
                'kidneyFailure' => $request->kidneyFailure,
                'stroke' => $request->stroke,
                'codeContrat' => $idContrat,
                'created_at' => now(),
            ]);

            // Récupérer et enregistrer les bénéficiaires
            $beneficiaires = json_decode($request->input('beneficiaires'), true);

            if ($request->addBeneficiary === "adherent") {
                $benefauterm = "adherent";
                $datenaissanceBenef = Carbon::parse($request->datenaissanceBenef)->format('Y-m-d H:i:s');

                Beneficiaire::create([
                    'id' => $idBenef,
                    'civilite' => $request->civilite,
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'datenaissance' => $datenaissanceBenef,
                    'codecontrat' => $idContrat,
                    'codeadherent' => $idAdherent,
                    'lieunaissance' => $request->lieunaissance,
                    'numeropiece' => $request->numeropiece,
                    'naturepiece' => $request->naturepiece,
                    'lieuresidence' => $request->lieuresidence,
                    'filiation' => $request->lienParente,
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'saisieLe' => now(),
                    'saisiepar' => Auth::user()->membre->idmembre,
                ])->save();
            }

            if ($beneficiaires) {

                foreach ($beneficiaires as $beneficiaire) {
                    $datenaissanceBeneficiaire = isset($beneficiaire['dateNaissance']) ? Carbon::parse($beneficiaire['dateNaissance'])->format('Y-m-d H:i:s') : null;
                    $idBenefInsert = Beneficiaire::max('id') + 1;
                    Beneficiaire::create([
                        'id' => $idBenefInsert,
                        'civilite' => $beneficiaire['civilite'] ?? null,
                        'nom' => $beneficiaire['nom'],
                        'prenom' => $beneficiaire['prenom'],
                        'datenaissance' => $datenaissanceBeneficiaire,
                        'codecontrat' => $idContrat,
                        'codeadherent' => $idAdherent,
                        'lieunaissance' => $beneficiaire['lieuNaissance'],
                        'numeropiece' => $beneficiaire['numeropiece'] ?? null,
                        'naturepiece' => $beneficiaire['naturepiece'] ?? null,
                        'lieuresidence' => $beneficiaire['lieuResidence'],
                        'filiation' => $beneficiaire['lienParente'],
                        'mobile' => $beneficiaire['telephone'],
                        'email' => $beneficiaire['email'],
                        'saisieLe' => now(),
                        'saisiepar' => Auth::user()->membre->idmembre,
                    ]);
                }
            }

            // ajout du contrat   numMobile

            if ($request->modepaiement === "Mobile_money") {
                $numerocompte = $request->numMobile;
            } else {
                $numerocompte = $request->numerocompte;
            }

            $product = Product::where('CodeProduit', $request->codeproduit)->first();

            $contratData = Contrat::create([
                'id' => $idContrat,
                'dateeffet' => $request->dateEffet,
                'modepaiement' => $request->modepaiement,
                'organisme' => $request->organisme,
                'agence' => $request->agence,
                'numerocompte' => $numerocompte,
                'periodicite' => $request->periodicite,

                'codeConseiller' => Auth::user()->membre->codeagent,
                'nomagent' => Auth::user()->membre->nom . ' ' . Auth::user()->membre->prenom,

                'primepricipale' => number_format($request->primepricipale, 2, ".", ""),
                'prime' => $request->primepricipale,
                'fraisadhesion' => $request->fraisadhesion,

                'surprime' => $request->surprime,
                // 'capital' => $request->capital,
                'capital' => number_format($request->capital, 2, ".", ""),
                'etape' => 1,

                'saisiele' => now(),
                'saisiepar' => Auth::user()->membre->idmembre,

                'duree' => $request->duree,

                'codeadherent' => $idAdherent,
                'estMigre' => 0,
                'codeproduit' => $request->codeproduit,
                // 'numBullettin' => $numBullettin,

                'libelleproduit' => $product->MonLibelle,
                'montantrente' => $request->montantrente,
                'periodiciterente' => $request->periodiciterente,
                'dureerente' => $request->dureerente,

                'personneressource' => $request->personneressource,
                'contactpersonneressource' => $request->contactpersonneressource,
                'beneficiaireauterme' => $benefauterm,
                'beneficiaireaudeces' => $request->audecesContrat,

                'personneressource2' => $request->personneressource2,
                'contactpersonneressource2' => $request->contactpersonneressource2,
                'codebanque' => $request->codebanque,
                'codeguichet' => $request->codeguichet,
                'rib' => $request->rib,

                'branche' => Auth::user()->membre->branche,

                'partenaire' => Auth::user()->membre->partenaire,
                // 'nomaccepterpar' => now(),
                // 'refcontratsource' => now(),
                'cleintegration' => now()->format('Ymd'),

                'estpaye' => 0,
                // 'pretconnexe' => now(),
                // 'details' => now(),
                'nomsouscipteur' => $idAdherent,
                'typesouscipteur' => Auth::user()->membre->branche,
            ])->save();

            
            $bulletinData = $this->generateBulletin($idContrat);

            // Si la génération du bulletin a échoué, lever une exception
            if (!$bulletinData['success']) {
                throw new \Exception("Erreur lors de la génération du bulletin : " . $bulletinData['message']);
            }

            $details_log = [
                'url' => route('prod.show', $idContrat),
                'user' => auth()->user()->membre->nom . ' ' . auth()->user()->membre->prenom,
                'date' => now(),
                'title' => "Enregistrement de la proposition ID $idContrat",
                'action' => "Voir",
               
            ];
            
            $usersToNotify = User::all();
            Notification::send($usersToNotify, new SystemeNotify($details_log));
            
            DB::commit();
            
            return response()->json([
                'type' => 'success',
                'urlback' => route('prod.edit', ['id' => $idContrat]),
                'url' => $bulletinData['file_url'],
                'message' => "Enregistré avec succès !",
                'code' => 200,
            ]);



        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error("Erreur système: ", ['error' => $th]);
            return response()->json([
                'type' => 'error',
                'urlback' => '',
                'message' => "Erreur système! $th",
                'code' => 500,
            ]);
        }
       
    }

    private function calculeprimeYke($request, $GarantiesOptionnelles, $idAssure, $idContrat)
    {
        $results = [];

        foreach ($GarantiesOptionnelles as $garantie) {
           
            $postData = [
                'codeProduit'      => $request->codeProduit,
                'codeGarantie'     => $garantie->codeproduitgarantie,
                'codePeriodicite'  => $request->codePeriodicite,
                'dureeCotisation'  => $request->duree,
                'capitalSouscrit'  => $request->capitalSouscrit,
                'age'              => $request->age,
                'dateEffet'        => $request->dateEffet
            ];

            $response = $this->callApi('https://api.yakoafricassur.com/enov/prime-garantie', $postData);
            $resultData = json_decode($response, true);

            Log::info("resultData", ['resultData' => $resultData]);

            // Vérifier si l'API a bien retourné des données
            if ($resultData && isset($resultData['prime']) && isset($resultData['capitalGarantie'])) {
                // Insérer dans la base de données
                AssureGarantie::create([
                    'codeproduitgarantie' => $garantie->codeproduitgarantie,
                    'idproduitparantie'   => $garantie->id,
                    'monlibelle'          => $garantie->libelle,
                    'prime'               => $resultData['prime'],  // Valeur retournée par l'API
                    'primetotal'          => $resultData['prime'],  // Valeur retournée par l'API (ajuster si nécessaire)
                    'primeaccesoire'      => 0,
                    'type'                => "Mixte",
                    'capitalgarantie'     => $resultData['capitalGarantie'], // Valeur retournée par l'API
                    'tauxinteret'         => $request->tauxinteret,
                    'codeassure'          => $idAssure,
                    'codecontrat'         => $idContrat,
                    'refcontratsource'    => 'qarty',
                    'estmigre'            => 0,
                ]);
            } else {
                // Stocker l'erreur si l'API n'a pas retourné les données attendues
                $results[$garantie->codeproduitgarantie] = [
                    'error'   => true,
                    'message' => 'Erreur lors de l\'appel API ou données manquantes'
                ];
            }
        }

        return $results;
    }


    // Fonction pour appeler l'API avec cURL
    private function callApi($url, $postData)
    {
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return ($httpCode == 200) ? $response : null;
    }


    private function generateBulletin($idContrat)
    {
        try {
            // Récupérer les données nécessaires au bulletin
            $contrat = Contrat::findOrFail($idContrat);

            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            );

            $qrContent = "Contrat bien enregistré\n";
            $qrContent .= "Date: " . $contrat->saisiele . "\n";
            $qrContent .= "Réf. Contrat: " . $contrat->id;
            
            $writer = new Writer($renderer);
        
            // Génération en base64 (sans fichier temporaire)
            $qrCodeImage = $writer->writeString($qrContent);
            $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCodeImage);
            
            // Passez $qrCodeBase64 à votre vue


            // Options pour DomPDF
            $options = new Options();
            $options->set('isRemoteEnabled', true);

            // Génération du bulletin PDF temporaire

            if($contrat->codeproduit == "YKE_2018"){
                $pdf = PDF::loadView('productions.components.bullettin.ykeBulletin', [
                    'contrat' => $contrat,
                    'qrCodeBase64' => $qrCodeBase64
                ]);
                $cguFile = public_path('root/cgu/cg_yke.pdf');

            }else if($contrat->codeproduit == "PFA_IND"){
                $pdf = PDF::loadView('productions.components.bullettin.pfaINDbulletin', [
                    'contrat' => $contrat,
                    'qrCodeBase64' => $qrCodeBase64
                ]);
                $cguFile = public_path('root/cgu/cg_yke.pdf');
                
            }else if($contrat->codeproduit == "CADENCE")
            {
                $pdf = PDF::loadView('productions.components.bullettin.Cadencebulletin', [
                    'contrat' => $contrat,
                    'qrCodeBase64' => $qrCodeBase64
                ]);
                $cguFile = public_path('root/cgu/CGPLanggnant.pdf');
                
            }else if($contrat->codeproduit == "DOIHOO"){
                $pdf = PDF::loadView('productions.components.bullettin.Doihoobulletin', [
                    'contrat' => $contrat,
                    'qrCodeBase64' => $qrCodeBase64
                ]);
                $cguFile = public_path('root/cgu/doihoo_cgu.pdf');
            }else{
                $pdf = PDF::loadView('productions.components.bullettin.basicBulletin', [
                    'contrat' => $contrat,
                    'qrCodeBase64' => $qrCodeBase64
                ]);
                $cguFile = public_path('root/cgu/CGPLanggnant.pdf');
            }
            

            $bulletinDir = public_path('documents/bulletin/');
            if (!is_dir($bulletinDir)) {
                mkdir($bulletinDir, 0777, true);
            }

            $tempBulletinPath = $bulletinDir . 'temp_bulletin_' . $contrat->id . '.pdf';
            $pdf->save($tempBulletinPath);

            // Chemin vers le fichier CGU
            $cguFilePath = public_path('root/cgu/cg_yke.pdf');

       

            // Initialiser FPDI pour fusionner les fichiers
            $finalPdf = new Fpdi();

            // Ajouter toutes les pages du bulletin
            $bulletinPageCount = $finalPdf->setSourceFile($tempBulletinPath);
            for ($pageNo = 1; $pageNo <= $bulletinPageCount; $pageNo++) {
                $finalPdf->AddPage();
                $tplIdx = $finalPdf->importPage($pageNo);
                $finalPdf->useTemplate($tplIdx);
            }
        
            // Ajouter toutes les pages du fichier CGU
            $cguPageCount = $finalPdf->setSourceFile($cguFile);
            for ($pageNo = 1; $pageNo <= $cguPageCount; $pageNo++) {
                $finalPdf->AddPage();
                $tplIdx = $finalPdf->importPage($pageNo);
                $finalPdf->useTemplate($tplIdx);
            }

            // Nom final du fichier fusionné
            $finalBulletinPath = $bulletinDir . 'bulletin_' . $contrat->id . '.pdf';
            $finalPdf->Output($finalBulletinPath, 'F');

            // Supprimer le fichier temporaire du bulletin
            unlink($tempBulletinPath);

            // Définir l'URL publique pour le fichier final
            $fileUrl = asset("documents/bulletin/bulletin_{$contrat->id}.pdf");

            return [
                'success' => true,
                'file_url' => $fileUrl,
                'redirect_url' => route('prod.edit', ['id' => $idContrat]),
                'qrCodeBase64' => $qrCodeBase64
            ];
        } catch (\Exception $e) {
            Log::error("Erreur lors de la génération du bulletin : ", ['error' => $e]);
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function transmettreContrat($id)
    {
        DB::beginTransaction();
        try {
            $contrat = Contrat::find($id);

            if ($contrat) {
                $contrat->update(
                    [
                        'transmisle' => now(),
                        'etape' => 2,
                        'transmispar' => Auth::user()->membre->idmembre
                    ]
                );

                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'urlback' => \route('prod.index'),
                    'message' => "Transmis avec succès!",
                    'code' => 200,
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'urlback' => 'back',
                    'message' => "Erreur erreur de transmission !",
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
        $productGarantie = ProduitGarantie::where('CodeProduit', $CodeProduit)->get();

        $contrat = Contrat::where('id', $id)->first();
        $filliations =  Filliation::select('MonLibelle')->get();

        return view('productions.show', compact('contrat', 'productGarantie','filliations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contrat = Contrat::where('id', $id)->with('adherent', 'assures', 'beneficiaires', 'produit')->first();
        $productGarantie = ProduitGarantie::where('CodeProduit', $contrat->codeproduit)->get();
        $product = Product::where('CodeProduit', $contrat->codeproduit)->first();
        $villes =  TblVille::get();
        $professions =  TblProfession::select('MonLibelle')->get();
        $secteurActivites =  TblSecteurActivite::select('MonLibelle')->get();
        $societes =  TblSociete::select('MonLibelle')->get();
        $agences =  TblAgence::select('NOM_LONG')->get();
        $filliations =  Filliation::select('MonLibelle')->get();
        return view('productions.edit', compact('contrat', 'product', 'villes', 'secteurActivites', 'professions', 'productGarantie', 'societes', 'agences','filliations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        DB::beginTransaction();
        try {

            if ($request->modepaiement === "Mobile_money") {
                $numerocompte = $request->numMobile;
            } else {
                $numerocompte = $request->numerocompte;
            }
            Contrat::where('id', $id)->update([
                'dateeffet' => $request->dateEffet,
                'modepaiement' => $request->modepaiement,
                'organisme' => $request->organisme,
                'agence' => $request->agence,
                'numerocompte' => $numerocompte,
                'periodicite' => $request->periodicite,

                'primepricipale' => $request->primepricipale,
                'prime' => $request->primepricipale,

                'fraisadhesion' => $request->fraisadhesion,

                // 'surprime' => $request->surprime,

                'capital' => number_format($request->capital, 2, ".", ""),

                'duree' => $request->duree,

                // 'codeproduit' => $request->codeproduit,

                'modifierle' => now(),
                'modifierpar' => Auth::user()->membre->idmembre,

                'personneressource' => $request->personneressource,
                'contactpersonneressource' => $request->contactpersonneressource,
                'personneressource2' => $request->personneressource2,
                'contactpersonneressource2' => $request->contactpersonneressource2,
                'codebanque' => $request->codebanque,
                'codeguichet' => $request->codeguichet,
                'rib' => $request->rib,

                // 'transmisle' => now(),
                // 'annulerle' => null,
                // 'accepterle' => null,

                // 'motifrejet' => null,
                // 'montantrente' => $request->montantrente,
                // 'periodiciterente' => $request->periodiciterente,
                // 'dureerente' => $request->dureerente,


                // 'beneficiaireauterme' => $benefauterm,
                // 'beneficiaireaudeces' => $request->audecesContrat,

                // 'accepterpar' => $idContrat,
                // 'rejeterpar' => $idAdherent,
                // 'transmispar' => $request->saisiepar,
                // 'capital' => $request->capital,

            ]);

            $details_log = [
                'url' => route('prod.show', $id),
                'user' => \auth()->user()->membre->nom . ' ' . \auth()->user()->membre->prenom,
                'date' => now(),
                'title' => "Modification de la proposition ID $id ",
                'action' => "Voir",
                'sound' => 'son1.wav' // Ajout du fichier son
            ];

            $usersToNotify = User::all();
            Notification::send($usersToNotify, new SystemeNotify($details_log));
            DB::commit();

            return response()->json([
                'type' => 'success',
                'urlback' => '',
                'message' => "Enregistré avec succès!",
                'code' => 200,
            ]);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}


// $files = $request->file('files');
//                 $libelles = $request->input('libelles');  // Récupérer les libellés

                
//                 foreach ($files as $key => $file) {
//                     $imageName = Str::uuid() . '.' . $file->getClientOriginalExtension();
//                     $destinationPath = public_path('documents/files');
//                     $file->move($destinationPath, $imageName);
//                     $filePath = 'documents/files/' . $imageName;

//                     // \dd($libelles[$key]);

//                     Document::create([
//                         'codecontrat' => $idContrat,
//                         'filename' => $imageName,
//                         'libelle' => $libelles[$key],
//                         'saisiele' => now(),
//                         'saisiepar' => Auth::user()->membre->idmembre,
//                         'source' => "ES",
//                     ])->save();
//                 }
