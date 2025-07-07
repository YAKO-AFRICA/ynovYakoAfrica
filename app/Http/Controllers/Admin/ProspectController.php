<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Membre;
use App\Models\Product;
use App\Models\Prospect;
use App\Models\TblVille;
use PDF;


use Dompdf\Dompdf;
use App\Models\Profession;
use Illuminate\Support\Str;
// use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use App\Models\ProspectProduct;
use App\Models\ProspectFollowup;
use App\Models\TblSecteurActivite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProspectController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $query = Prospect::where('userAdd_uuid', auth()->user()->id)->orderBy('id', 'desc');

        if ($request->has('code') && !empty($request->code)) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }

        if ($request->has('first_name') && !empty($request->first_name)) {
            $query->where('first_name', 'like', '%' . $request->first_name . '%');
        }

        if ($request->has('last_name') && !empty($request->last_name)) {
            $query->where('last_name', 'like', '%' . $request->last_name . '%');
        }

        if ($request->has('date_from') && !empty($request->date_from) && 
            $request->has('date_to') && !empty($request->date_to)) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->date_from)->startOfDay(),
                Carbon::parse($request->date_to)->endOfDay()
            ]);
        }

        $allPropects = $query->get();

        $product = Product::all();
        $villes = TblVille::select('libelleVillle')->get();
        $professions = Profession::select('MonLibelle')->get();
        $secteurActivites = TblSecteurActivite::select('MonLibelle')->get();

        if ($request->has('print')) {
            $pdf = PDF::loadView('prospects.print', compact('allPropects'));
            return $pdf->download('rapport_prospection_'.date('Y-m-d').'.pdf');
        }

        return view('prospects.index', compact('allPropects', 'villes', 'professions', 'secteurActivites', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function suivies()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            // 'code' => 'required|string|max:191|unique:prospects',
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'nullable|email|max:191',
            'mobile' => 'nullable|string|max:191',
            'adress' => 'nullable|string|max:191',
            'city' => 'nullable|string|max:191',
            'profession_uuid' => 'nullable|string|max:191',
            'secteurActivity_uuid' => 'nullable|string|max:191',
            'natureProspect' => 'nullable|string|max:191',
            'produit_id' => 'nullable|string|max:191',
            'montantPrime' => 'nullable|string|max:191',
            'dateEffet' => 'nullable|date',
            'typeCompagnie' => 'nullable|string|max:191',
            'modeDePaiment' => 'nullable|string|max:191',
            'lieuEvenement' => 'nullable|string|max:191',
            'etat' => 'nullable|string|max:191',
            'status' => 'nullable|string|max:191',
            'note' => 'nullable|string',
            'products' => 'nullable|array',
            'products.*' => 'integer|exists:tblproduit,IdProduit', 
        ]);

        DB::beginTransaction();

        try {
            $code = Refgenerate(Prospect::class, 'P', 'code');
            // Création du prospect
            $prospect = new Prospect();
            $prospect->uuid = Str::uuid();
            $prospect->code = $code;

            $prospect->first_name = $validated['first_name'];
            $prospect->last_name = $validated['last_name'];
            $prospect->email = $validated['email'] ?? null;
            $prospect->mobile = $validated['mobile'] ?? null;
            $prospect->adress = $validated['adress'] ?? null;
            $prospect->city = $validated['city'] ?? null;
            $prospect->profession_uuid = $validated['profession_uuid'] ?? null;
            $prospect->secteurActivity_uuid = $validated['secteurActivity_uuid'] ?? null;
            $prospect->natureProspect = $validated['natureProspect'] ?? null;
            // $prospect->produit_id = $validated['produit_id'] ?? null;
            $prospect->montantPrime = $validated['montantPrime'] ?? null;
            $prospect->dateEffet = $validated['dateEffet'] ?? null;
            $prospect->typeCompagnie = $validated['typeCompagnie'] ?? null;
            $prospect->modeDePaiment = $validated['modeDePaiment'] ?? null;
            $prospect->lieuEvenement = $validated['lieuEvenement'] ?? null;
            $prospect->etat = $validated['etat'] ?? 'actif';
            $prospect->status = $validated['status'] ?? 'nouveau';
            $prospect->note = $validated['note'] ?? null;
            $prospect->userAdd_uuid = auth()->user()->id;
            
            $prospect->save();

            // Vérifie s'il y a des produits sélectionnés
            if (!empty($request->products)) {
                foreach ($request->products as $productId) {
                    ProspectProduct::create([
                        'prospect_id' => $prospect->id,
                        'product_id' => $productId,
                    ]);
                }
            }



            return response()->json([
                'success' => true,
                'message' => 'Prospect créé avec succès',
                'data' => $prospect
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du prospect',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addProduct(request $request)
    {

        DB::beginTransaction();
        try {
            if (!empty($request->products)) {
                foreach ($request->products as $productId) {
                    ProspectProduct::create([
                        'prospect_id' => $request->prospect_id,
                        'product_id' => $productId,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'type' => 'success',
                'urlback' => 'back',
                'message' => "Enregistré avec succès!",
                'code' => 200,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Erreur lors de l'ajout de produit: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout des produits',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'Une erreur est survenue',
                'urlback' => '' // Vous devriez mettre une URL valide ici
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prospect = Prospect::with(['followups.user'])->where('id', $id)->firstOrFail();

        $commerciaux = Membre::whereNotNull('codeagent')->where('codepartenaire',"llv")->limit(500)->get();

        $professions = Profession::orderBy('MonLibelle')->get();
        $secteurActivites = TblSecteurActivite::orderBy('MonLibelle')->get();
        $products = Product::orderBy('MonLibelle')->get();
        $villes = TblVille::orderBy('idville')->get();

        return view('prospects.show', compact('prospect','commerciaux','products','professions','secteurActivites','villes'));
    }


    public function storeFollowup(Request $request, $uuid)
    {
    
        $prospect = Prospect::where('uuid', $uuid)->firstOrFail();
        
        $followup = ProspectFollowup::create([
            'uuid' => Str::uuid(),
            'prospect_id' => $prospect->id,
            'type' => $request->type,
            'notes' => $request->notes,
            'followup_date' => $request->followup_date,
            'next_followup_date' => $request->next_followup_date,
            'status' => $request->status,
            'user_id' => auth()->user()->id,
        ])->save();
        
        // Mettre à jour le statut du prospect si nécessaire
        if ($request->status === 'completed' && $prospect->status === 'nouveau') {
            $prospect->update(['status' => 'en_cours']);
        }
        
        return redirect()->back()->with('success', 'Suivi enregistré avec succès');
    }

    public function convertToClient(Request $request, $id)
    {
        // $request->validate([
        //     'client_code' => 'required|unique:clients,code'
        // ]);
        
        // $prospect = Prospect::where('id', $id)->firstOrFail();
        
        // // Créer le client
        // $client = Client::create([
        //     'uuid' => Str::uuid(),
        //     'code' => $request->client_code,
        //     'first_name' => $prospect->first_name,
        //     'last_name' => $prospect->last_name,
        //     // ... autres champs
        // ]);
        
        // // Mettre à jour le prospect
        // $prospect->update([
        //     'status' => 'converted',
        //     'client_id' => $client->id
        // ]);
        
        // return redirect()->route('clients.show', $client->id)
        //     ->with('success', 'Prospect converti en client avec succès');
    }

    public function edit($uuid)
    {
        $prospect = Prospect::where('uuid', $uuid)->firstOrFail();
        $professions = Profession::orderBy('MonLibelle')->get();
        $secteurActivites = TblSecteurActivite::orderBy('MonLibelle')->get();
        $product = Product::orderBy('MonLibelle')->get();
        $villes = TblVille::orderBy('idville')->get();
        
        return view('prospects.edit', compact('prospect', 'professions', 'secteurActivites', 'product', 'villes'));
    }

    public function update(Request $request, $uuid)
    {

        $prospectfirst = Prospect::where('uuid', $uuid)->firstOrFail();


        $prospect = Prospect::where('uuid', $uuid)->update(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'profession_uuid' => $request->profession_uuid,
                'secteurActivity_uuid' => $request->secteurActivity_uuid,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'adress' => $request->adress,
                'city' => $request->city,
                'natureProspect' => $request->natureProspect,
                'produit_id' => $request->produit_id,
                'typeCompagnie' => $request->typeCompagnie,
                'lieuEvenement' => $request->lieuEvenement,
                'status' => $request->status,
                'note' => $request->note,
                'update_by' => auth()->user()->idmembre,
                'updated_at' => now(),
            ]
        );

        if (!empty($request->products)) {
            foreach ($request->products as $productId) {
                ProspectProduct::create([
                    'prospect_id' => $prospectfirst->id,
                    'product_id' => $productId,
                ]);
            }
        }


        return redirect()->route('prospect.show', $prospectfirst->id)
            ->with('success', 'Prospect mis à jour avec succès');
    }

    public function assign(request $request, $uuid)
    {
        try {
            Prospect::where('uuid', $uuid)->update([
                'assign_to' => $request->assignedTo,
                'assigned_by' => auth()->user()->idmembre,
                'assign_date' => now(),
                'note' => $request->note,
            ]);

            DB::commit();

            return response()->json([
                'type' => 'success',
                'urlback' => " ",
                'message' => "Enregistré avec succès !",
                'code' => 200,
            ]);

            
        } catch (\Throwable $th) {
            Log::error("Erreur système: ", ['error' => $th]);
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

    /**
     * Update the specified resource in storage.
     */
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $prospectId, string $productId)
    {
        
        try {
            $deleted = ProspectProduct::where([
                'product_id' => $productId,
                'prospect_id' => $prospectId
            ])->delete();

            if (!$deleted) {
                throw new \Exception('Produit non trouvé');
            }

            return response()->json([
                'success' => true,
                'message' => 'Produit supprimé avec succès'
            ]);

            Log::info("mise a jour reussir");

        } catch (\Exception $e) {

            Log::info("une erreur es survenue");
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // App\Http\Controllers\ProspectionController.php
    public function showForm($token)
    {
        $commercial = User::where('qr_code_token', $token)->firstOrFail();

        $professions = Profession::orderBy('MonLibelle')->get();
        $secteurActivites = TblSecteurActivite::orderBy('MonLibelle')->get();
        $product = Product::orderBy('MonLibelle')->get();
        $villes = TblVille::orderBy('idville')->get();
        
        return view('prospects.apiPropect', [
            'commercial' => $commercial,
            'token' => $token,
            'professions' => $professions,
            'secteurActivites' => $secteurActivites,
            'product' => $product,
            'villes' => $villes,
        ]);
    }

    public function storeProspect(Request $request, $token)
    {
        $commercial = User::where('qr_code_token', $token)->firstOrFail();
        
        {
            // Validation des données
            $validated = $request->validate([
                // 'code' => 'required|string|max:191|unique:prospects',
                'first_name' => 'required|string|max:191',
                'last_name' => 'required|string|max:191',
                'email' => 'nullable|email|max:191',
                'mobile' => 'nullable|string|max:191',
                'adress' => 'nullable|string|max:191',
                'city' => 'nullable|string|max:191',
                'profession_uuid' => 'nullable|string|max:191',
                'secteurActivity_uuid' => 'nullable|string|max:191',
                'natureProspect' => 'nullable|string|max:191',
                'produit_id' => 'nullable|string|max:191',
                'montantPrime' => 'nullable|string|max:191',
                'dateEffet' => 'nullable|date',
                'typeCompagnie' => 'nullable|string|max:191',
                'modeDePaiment' => 'nullable|string|max:191',
                'lieuEvenement' => 'nullable|string|max:191',
                'etat' => 'nullable|string|max:191',
                'status' => 'nullable|string|max:191',
                'note' => 'nullable|string',
                'products' => 'nullable|array',
                'products.*' => 'integer|exists:tblproduit,IdProduit', 
            ]);
    
            
    
            try {
                $code = Refgenerate(Prospect::class, 'P', 'code');
                // Création du prospect
                $prospect = new Prospect();
                $prospect->uuid = Str::uuid();
                $prospect->code = $code;
    
                $prospect->first_name = $validated['first_name'];
                $prospect->last_name = $validated['last_name'];
                $prospect->email = $validated['email'] ?? null;
                $prospect->mobile = $validated['mobile'] ?? null;
                $prospect->adress = $validated['adress'] ?? null;
                $prospect->city = $validated['city'] ?? null;
                $prospect->profession_uuid = $validated['profession_uuid'] ?? null;
                $prospect->secteurActivity_uuid = $validated['secteurActivity_uuid'] ?? null;
                $prospect->natureProspect = $validated['natureProspect'] ?? null;
                // $prospect->produit_id = $validated['produit_id'] ?? null;
                $prospect->montantPrime = $validated['montantPrime'] ?? null;
                $prospect->dateEffet = $validated['dateEffet'] ?? null;
                $prospect->typeCompagnie = $validated['typeCompagnie'] ?? null;
                $prospect->modeDePaiment = $validated['modeDePaiment'] ?? null;
                $prospect->lieuEvenement = $validated['lieuEvenement'] ?? null;
                $prospect->etat = $validated['etat'] ?? 'actif';
                $prospect->status = $validated['status'] ?? 'nouveau';
                $prospect->note = $validated['note'] ?? null;
                $prospect->userAdd_uuid = $commercial->id;
                
                $prospect->save();
    
                // Vérifie s'il y a des produits sélectionnés
                if (!empty($request->products)) {
                    foreach ($request->products as $productId) {
                        ProspectProduct::create([
                            'prospect_id' => $prospect->id,
                            'product_id' => $productId,
                        ]);
                    }
                }
    
    
    
                return response()->json([
                    'success' => true,
                    'message' => 'Prospect créé avec succès',
                    'data' => $prospect
                ], 201);
    
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création du prospect',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function downloadQrCode()
    {
        $user = auth()->user();
        
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(500)
            ->generate(route('prospection.form', $user->qr_code_token));
        
        return response($qrCode)
            ->header('Content-Type', 'image/svg')
            ->header('Content-Disposition', 'attachment; filename="qr-code-prospection.svg"');
    }

  
}
