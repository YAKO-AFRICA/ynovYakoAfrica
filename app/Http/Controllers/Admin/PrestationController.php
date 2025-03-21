<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Membre;
use App\Models\Tblotp;
use App\Models\Tblrdv;
use Illuminate\Http\Request;
use App\Models\MembreContrat;
use App\Models\TblPrestation;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TblDocPrestation;
use App\Models\TblTypePrestation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PrestationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $prestations = TblPrestation::where('etat', 'Actif')->with('docPrestation', 'otp', 'membre')->get();
        // dd($prestations);
        return view('prestations.index');
    }

    public function selectPrestation()
    {
        $typePrestations = TblTypePrestation::where('etat', 'Actif')->get();
        $contract = session('contractDetails', []);
        $contractDetails = $contract['details'][0] ?? [];
        $membreDetails   = $contract['membre'] ?? [];
        // dd($contractDetails, $membreDetails);
        return view('prestations.selectPrestation', compact('typePrestations', 'contractDetails'));
    }
    // $cMembre   = MembreContrat::where('idcontrat', 2259833)->first();
    // $membre = Membre::where('idmembre', $cMembre->codemembre)->first();
    // dd($membre);

    // dd($membre);
    // $membreContrat = MembreContrat::where('idcontrat', 2259833)->with('membre')->first();

    // if ($membreContrat) {
    //     $membre = $membreContrat->membre;
    //     dd($membre); // Vérifiez les données du membre
    // } else {
    //     dd('Aucun contrat trouvé.');
    // }

    /**
     * Show the form for creating a new resource.
     */

    public function printFichePrestation()
    {
        // $prestation = TblPrestation::where('id', $id)->first();
        // Génération de QR Code en base64
        $qrcode = base64_encode(QrCode::format('svg')->size(80)->generate("http://yakoafrica_live.test/espace-client/prestation/getInfoPrestation/1"));
        $pdf = Pdf::loadView('prestations.fiches.prestationtest', compact('qrcode'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true, // Permet le chargement des ressources distantes si nécessaire
                'margin-left' => 0,
                'margin-right' => 0,
                'margin-top' => 0,
                'margin-bottom' => 0,
            ]);

        $fileName = 'Prestation.pdf';
        return $pdf->stream($fileName);
        // $PrestationDir = public_path('documents/prestations/');
        // if (!is_dir($PrestationDir)) {
        //     mkdir($PrestationDir, 0777, true);
        // }
        // $pdf->save($PrestationDir . $fileName);
        // return view('users.espace_client.services.fiches.prestation');
    }
    public function getInfoPrestation(string $id)
    {
        $prestation = TblPrestation::where('id', $id)->first();
        // dd($prestation);
        return view('prestations.fiches.infoPrestByQrcode', compact('prestation'));
    }
    public function fetchContractDetails(Request $request)
    {
        $idcontrat = $request->input('idcontrat');
        // dd($idcontrat);
        if (!$idcontrat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aucun contrat sélectionné.',
            ], 400);
        }

        try {
            // Utiliser Guzzle directement pour un meilleur contrôle
            $response = Http::withOptions(['timeout' => 60,])->post('https://api.yakoafricassur.com/oldweb/encaissement-bis', ['idContrat' => $idcontrat]);

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $response->json(),
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Impossible de récupérer les informations du contrat.',
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite : ' . $e->getMessage(),
            ], 500);
        }
    }
    public function create(string $id)
    {
        $typePrestation = TblTypePrestation::where('id', $id)->first();
        $typePrestationAutre = TblTypePrestation::where('impact', 'Autre')->where('etat', 'Actif')->first();
        $contract = session('contractDetails', []);
        $contractDetails = $contract['details'][0] ?? [];
        $membreDetails   = $contract['membre'] ?? [];

        // dd($contractDetails);
        // $membreDetails = session('membreDetails', []);

        // dd($contractDetails, $membreDetails);
        if (empty($contract)) {
            return redirect()->back()->withErrors('Les détails du contrat sont introuvables.');
        }

        return view('prestations.create', compact('typePrestation', 'contractDetails', 'membreDetails', 'typePrestationAutre'));
    }

    public function createAutre(string $id)
    {
        $typePrestation = TblTypePrestation::where('id', $id)->first();
        $contract = session('contractDetails', []);
        $contractDetails = $contract['details'][0] ?? [];
        $membreDetails   = $contract['membre'] ?? [];
        $response = Http::withOptions(['timeout' => 60])
        ->post('https://api.laloyalevie.com/enov/op-type-operation-list', [
            'type' => 'AVT',
        ]);
        if ($response->successful()) {
            $typeOperation = $response->json();
            
        }
        return view('prestations.createAutre', compact('typePrestation', 'typeOperation', 'contractDetails', 'membreDetails'));
    }

    public function fetchCustomerDetails(Request $request)
    {
        $idcontrat = $request->input('idcontrat');

        if (!$idcontrat) {
            // retourner une erreur ou un message d'erreur approprié en json
            return response()->json([
                'type' => 'error',
                'urlback' => '', // URL du PDF
                'message' => "Aucun ID de contrat fourni.",
                'code' => 400,
            ]);
        }

        try {
            $response = Http::withOptions(['timeout' => 60])
                ->post('https://api.yakoafricassur.com/oldweb/encaissement-bis', [
                    'idContrat' => $idcontrat,
                ]);
                
            $contractMembre   = MembreContrat::where('idcontrat', $idcontrat)->with('membre')->first();

            if ($response->successful()) {
                $data = $response->json();
                $data['membre'] = $contractMembre->membre ?? [];
                if (!empty($data['details'])) {
                    // Stocker les informations dans la session pour l'utiliser après redirection
                    session(['contractDetails' => $data]);
                    // session(['membreDetails' => $data['membre']]);
                    // dd($data);
                    // dd($data['details']);
                    // return redirect()->route('prestation.selectPrestation');
                    if ($data['details'][0]['OnStdbyOff'] != "1") {
                        return response()->json([
                            'type' => 'error',
                            'urlback' => '', // URL du PDF
                            'message' => 'Ce contrat est arreté ou en veille.',
                            'code' => 400,
                        ]);
                    } else {
                        return response()->json([
                            'type' => 'success',
                            'urlback' => route('prestation.selectPrestation'), // URL du PDF
                            'message' => 'Détails du contrat trouvé avec succès.',
                            'code' => 200,
                        ]);
                    }
                }

                return response()->json([
                    'type' => 'error',
                    'urlback' => '', // URL du PDF
                    'message' => 'Aucun détail trouvé pour ce contrat.',
                    'code' => 400,
                ]);
            }

            return response()->json([
                'type' => 'error',
                'urlback' => '', // URL du PDF
                'message' => "Erreur : Impossible de récupérer les informations du contrat.",
                'code' => 400,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'urlback' => '', // URL du PDF
                'message' => 'Une erreur s\'est produite : ' . $e->getMessage(),
                'code' => 400,
            ]);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    // public function generate () {

    // 	# 2. On génère un QR code de taille 200 x 200 px
    // 	$qrcode = QrCode::size(150)->generate("Je suis un QR Code");

    // 	# 3. On envoie le QR code généré à la vue "simple-qrcode"
    // 	return view("users.espace_client.services.fiches.qrcode", compact('qrcode'));
    // }
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $saisiepar = auth()->user()->idmembre;
            $otp = $request->otp_1 . $request->otp_2 . $request->otp_3 . $request->otp_4 . $request->otp_5 . $request->otp_6;
            $otpVerif = Tblotp::where('codeOTP', $otp)->first();

            // if ($otpVerif) {
            $idOtp = $otpVerif->id ?? null;
            // Vérifier si une prestation similaire existe déjà

            $moyenPaiement = $request->moyenPaiement;
            $TelPaiement = ($moyenPaiement == 'Virement_Bancaire') ? null : $request->TelPaiement;
            $IBAN = ($moyenPaiement == 'Virement_Bancaire') ? $request->IBAN : null;

            // supprimer Espace en cas de $TelPaiement
            $montantSouhaite = preg_replace('/\s+/u', '', $request->montantSouhaite);

            // Création de la prestation
            $prestation = TblPrestation::create([
                'code' => RefgenerateCodePrest(TblPrestation::class, 'PREST-', 'code'),
                'idOtp' => $idOtp,
                'idcontrat' => $request->idcontrat,
                'typeprestation' => $request->typeprestation,
                'idclient' => $request->idclient,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'datenaissance' => $request->datenaissance,
                'lieunaissance' => $request->lieunaissance,
                'sexe' => $request->sexe,
                'cel' => $request->cel,
                'tel' => $request->tel,
                'email' => $request->email,
                'msgClient' => $request->msgClient,
                'lieuresidence' => $request->lieuresidence,
                'montantSouhaite' => $montantSouhaite,
                'moyenPaiement' => $moyenPaiement,
                'Operateur' => $request->Operateur,
                'telPaiement' => $TelPaiement,
                'IBAN' => $IBAN,
                'saisiepar' => $saisiepar,
                // 'villedeclaration' => $request->villedeclaration,
                // 'mailtraitement' => $request->mailtraitement,
            ]);

            // Vérification si la prestation a été créée
            if (!$prestation) {
                throw new \Exception("Erreur lors de l'enregistrement de la prestation");
            }

            // Chemin externe pour stocker les fichiers
            $externalUploadDir = base_path(env('UPLOAD_PRESTATION_FILE'));
            if (!is_dir($externalUploadDir)) {
                mkdir($externalUploadDir, 0777, true);
            }

            // Gestion des fichiers uploadés
            if ($request->hasFile('libelle')) {
                $contrat = $request->idcontrat;
                $rectoFile = null;
                $versoFile = null;
                $prestationFiles = [];

                if ($moyenPaiement != 'Virement_Bancaire') {
                    foreach ($request->file('libelle') as $index => $file) {
                        $fileType = $request->type[$index];

                        // Si le fichier est de type 'IBAN', ne pas l'enregistrer
                        if ($fileType === 'RIB') {
                            continue;
                        }

                        if ($fileType === 'CNIrecto') {
                            $rectoFile = $file;
                        } elseif ($fileType === 'CNIverso') {
                            $versoFile = $file;
                        } else {
                            $fileName = Carbon::now()->format('Ymd_His') . '_' . $contrat . '_' . $fileType . '.' . $file->extension();
                            $file->move($externalUploadDir . 'docsPrestation/', $fileName);
                            $prestationFiles[] = [
                                'idPrestation' => $prestation->id,
                                'libelle' => $fileName,
                                'path' => 'storage/prestations/docsPrestation/' . $fileName,
                                'type' => $fileType,
                            ];
                        }
                    }
                } else {
                    foreach ($request->file('libelle') as $index => $file) {
                        $fileType = $request->type[$index];

                        // Si le fichier est de type 'FicheIDNum', ne pas l'enregistrer
                        if ($fileType === 'FicheIDNum') {
                            continue;
                        }

                        if ($fileType === 'CNIrecto') {
                            $rectoFile = $file;
                        } elseif ($fileType === 'CNIverso') {
                            $versoFile = $file;
                        } else {
                            $fileName = Carbon::now()->format('Ymd_His') . '_' . $contrat . '_' . $fileType . '.' . $file->extension();
                            $file->move($externalUploadDir . 'docsPrestation/', $fileName);
                            $prestationFiles[] = [
                                'idPrestation' => $prestation->id,
                                'libelle' => $fileName,
                                'path' => 'storage/prestations/docsPrestation/' . $fileName,
                                'type' => $fileType,
                            ];
                        }
                    }
                }


                // Si les fichiers recto et verso sont présents, fusionner en un fichier PDF
                if ($rectoFile && $versoFile) {
                    $mergedFileName = Carbon::now()->format('Ymd_His') . '_CNI_' . $contrat . '.pdf';
                    $mergedFilePath = $externalUploadDir . 'docsPrestation/' . $mergedFileName;

                    // Charger les fichiers recto et verso
                    $rectoContent = file_get_contents($rectoFile->getPathname());
                    $versoContent = file_get_contents($versoFile->getPathname());

                    // Créer une vue HTML pour le PDF
                    $html = view('prestations.fiches.cni', [
                        'rectoContent' => base64_encode($rectoContent),
                        'versoContent' => base64_encode($versoContent)
                    ])->render();

                    // Générer le PDF
                    $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');
                    $pdf->save($mergedFilePath);

                    // Enregistrer dans la base de données
                    $prestationFiles[] = [
                        'idPrestation' => $prestation->id,
                        'libelle' => $mergedFileName,
                        'path' => 'storage/prestations/docsPrestation/' . $mergedFileName,
                        'type' => 'CNI',
                    ];
                }

                // Enregistrer tous les fichiers
                foreach ($prestationFiles as $fileData) {
                    TblDocPrestation::create($fileData);
                }
            }

            $prestationPdfUrl = $this->generatePrestationPdf($prestation);
            return response()->json([
                'type' => 'success',
                'urlback' => route('prestation.show', $prestation->code),
                'url' => $prestationPdfUrl['file_url'],
                'message' => "Enregistré avec succès !",
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

    private function generatePrestationPdf($prestation)
    {
        try {
            $externalUploadDir = base_path(env('UPLOAD_PRESTATION_FILE'));
            if (!is_dir($externalUploadDir)) {
                mkdir($externalUploadDir, 0777, true);
            }
            // Génération du QR code et du fichier PDF pour la prestation
            $qrcode = base64_encode(QrCode::format('svg')->size(80)->generate(url('prestation/getInfoPrestation/' . $prestation->id)));
            $pdf = Pdf::loadView('prestations.fiches.prestation', compact('qrcode', 'prestation'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'margin-left' => 0,
                    'margin-right' => 0,
                    'margin-top' => 0,
                    'margin-bottom' => 0,
                ]);

            // Dossier pour enregistrer l'état de la prestation
            $etatPrestationDir = $externalUploadDir . 'etatPrestations/';
            if (!is_dir($etatPrestationDir)) {
                mkdir($etatPrestationDir, 0777, true);
            }

            $fileName = 'Prestation_' . $prestation->code . '.pdf';
            $filePath = $etatPrestationDir . $fileName;
            $pdf->save($filePath);

            // Enregistrer le fichier dans la base de données
            TblDocPrestation::create([
                'idPrestation' => $prestation->id,
                'libelle' => $fileName,
                'path' => 'storage/prestations/etatPrestations/' . $fileName,
                'type' => 'etatPrestation',
            ]);

            DB::commit();

            // Retourner l'URL complète du fichier PDF
            $pdfUrl = url('storage/prestations/etatPrestations/' . $fileName);
            return [
                'success' => true,
                'file_url' => $pdfUrl,
                'redirect_url' => route('prestation.show', $prestation->code),
            ];
        } catch (\Exception $e) {
            Log::error("Erreur lors de la génération du bulletin : ", ['error' => $e]);
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    
    public function storePrestAutre(Request $request)
{
    DB::beginTransaction();
        try {
            $saisiepar = auth()->user()->idmembre;
            $otp = $request->otp_1 . $request->otp_2 . $request->otp_3 . $request->otp_4 . $request->otp_5 . $request->otp_6;
            // $idOtp = Tblotp::select('id')->where('codeOTP', $otp)->first();
            $otpVerif = Tblotp::where('codeOTP', $otp)->first();

            // if ($otpVerif) {
            $idOtp = $otpVerif->id ?? null;
            // Vérifier si une prestation similaire existe déjà
            
            $Operateur = ($otp == null || $otp == '') ? null : $request->Operateur;
            $TelPaiement = ($otp == null || $otp == '') ? null : $request->TelPaiement;
            $IBAN = ($otp == null || $otp == '') ? $request->IBAN : null;

            $PrestationEnCours = TblPrestation::where([
                ['idcontrat', '=', $request->idcontrat],
                ['typeprestation', '=', $request->typeprestation],
                ['idclient', '=', $request->idclient],
                ['etape', '=', 1]
            ])->first();
            if ($PrestationEnCours) {
                return response()->json([
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Une prestation N° $PrestationEnCours->code de type $PrestationEnCours->typeprestation pour le contrat $PrestationEnCours->idcontrat est en cours de traitement. Veuillez patienter.",
                    'code' => 500,
                ]);
            } else {
                $prestation = TblPrestation::create([
                    'code'              => RefgenerateCodePrest(TblPrestation::class, 'PREST-', 'code'),
                    'idOtp'             => $idOtp,
                    'idcontrat'         => $request->idcontrat,
                    'typeprestation'    => $request->typeprestation,
                    'idclient'          => $request->idclient,
                    'nom'               => $request->nom,
                    'prenom'            => $request->prenom,
                    'datenaissance'     => $request->datenaissance,
                    'lieunaissance'     => $request->lieunaissance,
                    'sexe'              => $request->sexe,
                    'cel'               => $request->cel,
                    'tel'               => $request->tel,
                    'email'             => $request->email,
                    'msgClient'         => $request->msgClient,
                    'lieuresidence'     => $request->lieuresidence,
                    'montantSouhaite'   => $request->montantSouhaite,
                    'moyenPaiement'     => $request->moyenPaiement,
                    'Operateur'         => $Operateur,
                    'telPaiement'       => $TelPaiement,
                    'IBAN'              => $IBAN,
                    'saisiepar'         => $saisiepar,
                    // 'villedeclaration' => $request->villedeclaration,
                    // 'mailtraitement' => $request->mailtraitement,
                ]);
                // Vérification si la prestation a été créée
                if (!$prestation) {
                    throw new \Exception("Erreur lors de l'enregistrement de la prestation");
                }

                // Chemin externe pour stocker les fichiers
                $externalUploadDir = base_path(env('UPLOAD_PRESTATION_FILE'));
                if (!is_dir($externalUploadDir)) {
                    mkdir($externalUploadDir, 0777, true);
                }

                // Gestion des fichiers uploadés
                if ($request->hasFile('libelle')) {
                    $contrat = $request->idcontrat;
                    $rectoFile = null;
                    $versoFile = null;
                    $prestationFiles = [];

                    foreach ($request->file('libelle') as $index => $file) {
                        $fileType = $request->type[$index];
                    
                        if ($fileType === 'CNIrecto') {
                            $rectoFile = $file;
                        } elseif ($fileType === 'CNIverso') {
                            $versoFile = $file;
                        } 
                        
                    }
                    // Si les fichiers recto et verso sont présents, fusionner en un fichier PDF
                    if ($rectoFile && $versoFile) {
                        $mergedFileName = Carbon::now()->format('Ymd_His') . '_CNI_' . $contrat . '.pdf';
                        $mergedFilePath = $externalUploadDir . 'docsPrestation/' . $mergedFileName;

                        // Charger les fichiers recto et verso
                        $rectoContent = file_get_contents($rectoFile->getPathname());
                        $versoContent = file_get_contents($versoFile->getPathname());

                        // Créer une vue HTML pour le PDF
                        $html = view('prestations.fiches.cni', [
                            'rectoContent' => base64_encode($rectoContent),
                            'versoContent' => base64_encode($versoContent)
                        ])->render();

                        // Générer le PDF
                        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');
                        $pdf->save($mergedFilePath);

                        // Enregistrer dans la base de données
                        $prestationFiles[] = [
                            'idPrestation' => $prestation->id,
                            'libelle' => $mergedFileName,
                            'path' => 'storage/prestations/docsPrestation/' . $mergedFileName,
                            'type' => 'CNI',
                        ];
                    }

                    // Enregistrer tous les fichiers
                    foreach ($prestationFiles as $fileData) {
                        TblDocPrestation::create($fileData);
                    }
                }
                
                DB::commit();
                return response()->json([
                    'type' => 'success',
                    'urlback' => "back",
                    'message' => "Enregistré avec succès!",
                ]);
            }
        }catch (\Throwable $th) {
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



    public function mesPrestations()
    {
        $user = auth()->user();
        $prestations = TblPrestation::where(['saisiepar' => $user->membre->idmembre])->where('moyenPaiement', '!=', null, 'and', 'montantSouhaite', '!=', null, 'and', 'telPaiement', '!=', null, 'and', 'Operateur', '!=', null, 'and', 'IBAN', '!=', null)->with('docPrestation')->orderBy('created_at', 'desc')->get();

        $AutrePrestations = TblPrestation::where(['saisiepar' => $user->membre->idmembre])->where('moyenPaiement', '=', null, 'and', 'montantSouhaite', '=', null, 'and', 'telPaiement', '=', null, 'and', 'Operateur', '=', null, 'and', 'IBAN', '=', null)->with('docPrestation')->orderBy('created_at', 'desc')->get();
        return view('prestations.mesPrestations', compact('prestations', 'AutrePrestations'));
    }

    // Récupère les prestations en fonction du contrat sélectionné
    public function getPrestations(Request $request)
    {
        $idcontrat = $request->input('idcontratPrest');

        try {
            $prestations = TblPrestation::where('idcontrat', $idcontrat)->with('docPrestation')->get();
            if ($prestations->isEmpty()) {
                return response()->json(['status' => 'success', 'data' => []]);
            }
            return response()->json([
                'status' => 'success',
                'data' => $prestations,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue : ' . $th->getMessage(),
            ], 500);
        }
    }
    // public function show(string $code)
    // {
    //     $prestation = TblPrestation::where('code', $code)->first();
    //     return view('prestations.show', compact('prestation'));
    // }

    public function show(string $code)
    {
        $prestation = TblPrestation::where('code', $code)->first();
        return view('prestations.show', compact('prestation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $code)
    {
        $prestation = TblPrestation::where('code', $code)->first();
        return view('prestations.edit', compact('prestation'));
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
    public function destroy(string $code)
    {
        DB::beginTransaction();
        try {
            $isDeleted = TblPrestation::where('code', $code)->delete();

            if ($isDeleted) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Prestation supprimée avec succès!",
                    'code'=>200,
                ];
                DB::commit();
            } else {
                DB::rollback();
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur lors de la suppression!",
                    'code'=>500,
                ];
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse =[
                'type'=>'error',
                'urlback'=>'',
                'message'=>"Erreur systeme! $th",
                'code'=>500,
            ];
        }
        return response()->json($dataResponse);
    }
}
