<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrat;
use App\Models\Reseau;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DdcController extends Controller
{
    public function index()
    {
        return view('ddc.dashboard');
    }

    public function calculDataDDC(Request $request)
    {
        try {
            $type = $request->get('type', 'year'); // year | month

            // Récupération des partenaires DDC
            $partenaires = Reseau::whereIn('codebranche', ['BANKASS'])
                ->pluck('codepartenaire')
                ->unique()
                ->values();

            if ($partenaires->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun partenaire DDC trouvé'
                ]);
            }

            // Query de base
            $baseQuery = Contrat::whereIn('partenaire', $partenaires);

            // Filtrage par période
            if ($type === 'month') {
                $baseQuery->whereYear('saisiele', now()->year)
                    ->whereMonth('saisiele', now()->month);
            } else {
                $baseQuery->whereYear('saisiele', now()->year);
            }

            // KPI Annuel
            $totalAnnuel = $baseQuery->count();
            $primeAnnuel = $baseQuery->sum('prime');

            // KPI Mensuel (toujours pour comparaison)
            $monthlyQuery = Contrat::whereIn('partenaire', $partenaires)
                ->whereYear('saisiele', now()->year)
                ->whereMonth('saisiele', now()->month);

            $totalMensuel = $monthlyQuery->count();
            $primeMensuel = $monthlyQuery->sum('prime');

            // Évolution mensuelle des primes (pour l'année en cours)
            $evolution = Contrat::whereYear('saisiele', now()->year)
                ->whereIn('partenaire', $partenaires)
                ->select(DB::raw('MONTH(saisiele) as mois'), DB::raw('SUM(prime) as total_prime'), DB::raw('COUNT(*) as nb_contrats'))
                ->groupBy('mois')
                ->orderBy('mois')
                ->get()
                ->map(function($item) {
                    return [
                        'mois' => $item->mois,
                        'prime' => (float) $item->total_prime,
                        'nb_contrats' => (int) $item->nb_contrats
                    ];
                });

            // Top 5 partenaires
            $partnersData = Contrat::whereYear('saisiele', now()->year)
                ->whereIn('partenaire', $partenaires)
                ->select('partenaire', DB::raw('COUNT(*) as nb_contrats'), DB::raw('SUM(prime) as total_prime'))
                ->groupBy('partenaire')
                ->orderBy('total_prime', 'DESC')
                ->get()
                ->map(function($item) {
                    return [
                        'name' => $item->partenaire,
                        'contracts' => (int) $item->nb_contrats,
                        'premium' => (float) $item->total_prime
                    ];
                });

            // Distribution produits
            $totalContrats = Contrat::whereYear('saisiele', now()->year)
                ->whereIn('partenaire', $partenaires)
                ->count();

            $productsData = Contrat::whereYear('saisiele', now()->year)
                ->whereIn('partenaire', $partenaires)
                ->select('codeproduit', DB::raw('COUNT(*) as total'))
                ->groupBy('codeproduit')
                ->orderBy('total', 'DESC')
                ->get();

            // Couleurs pour les produits
            $productColors = [
                'Auto' => '#0d6efd',
                'Habitation' => '#198754',
                'Santé' => '#ffc107',
                'Vie' => '#6f42c1',
                'Professionnel' => '#dc3545',
                'MRH' => '#fd7e14',
                'Prévoyance' => '#20c997'
            ];

            $products = [];
            foreach ($productsData as $prod) {
                $percentage = $totalContrats > 0 ? round(($prod->total / $totalContrats) * 100, 1) : 0;
                $products[] = [
                    'name' => $prod->codeproduit,
                    'value' => $percentage,
                    'color' => $productColors[$prod->codeproduit] ?? '#6c757d'
                ];
            }

            // Statuts contrats
            $statusData = [
                'saisie_non_transmis' => Contrat::whereYear('saisiele', now()->year)
                    ->whereIn('partenaire', $partenaires)
                    ->where('etape', 1)
                    ->count(),
                'transmis_annuel' => Contrat::whereYear('saisiele', now()->year)
                    ->whereIn('partenaire', $partenaires)
                    ->whereNotIn('etape', [1,4])
                    ->count(),
                'transmis_actif' => Contrat::whereYear('saisiele', now()->year)
                    ->whereIn('partenaire', $partenaires)
                    ->where('etape', 2)
                    ->count(),
                'rejetes' => Contrat::whereYear('saisiele', now()->year)
                    ->whereIn('partenaire', $partenaires)
                    ->where('etape', 4)
                    ->count(),
                'acceptees' => Contrat::whereYear('saisiele', now()->year)
                    ->whereIn('partenaire', $partenaires)
                    ->where('etape', 3)
                    ->count()
            ];

            $statusItems = [
                ['status' => 'Saisie Non Transmis', 'count' => $statusData['saisie_non_transmis'], 'percentage' => $totalContrats > 0 ? round(($statusData['saisie_non_transmis'] / $totalContrats) * 100, 1) : 0, 'color' => 'primary'],

                ['status' => 'Transmis Annuel', 'count' => $statusData['transmis_annuel'], 'percentage' => $totalContrats > 0 ? round(($statusData['transmis_annuel'] / $totalContrats) * 100, 1) : 0, 'color' => 'success'],

                ['status' => 'Transmis Actif', 'count' => $statusData['transmis_actif'], 'percentage' => $totalContrats > 0 ? round(($statusData['transmis_actif'] / $totalContrats) * 100, 1) : 0, 'color' => 'success'],

                ['status' => 'Rejetés', 'count' => $statusData['rejetes'], 'percentage' => $totalContrats > 0 ? round(($statusData['rejetes'] / $totalContrats) * 100, 1) : 0, 'color' => 'danger'],
                
                ['status' => 'Acceptées', 'count' => $statusData['acceptees'], 'percentage' => $totalContrats > 0 ? round(($statusData['acceptees'] / $totalContrats) * 100, 1) : 0, 'color' => 'warning']
            ];

            return response()->json([
                'success' => true,
                'kpi' => [
                    'totalAnnuel' => $totalAnnuel,
                    'primeAnnuel' => round($primeAnnuel, 0),
                    'totalMensuel' => $totalMensuel,
                    'primeMensuel' => round($primeMensuel, 0),
                ],
                'partenaires' => $partenaires,
                'charts' => [
                    'evolution' => $evolution,
                    'partnersData' => $partnersData,
                    'products' => $products,
                    'status' => [
                        'totalAnnuel' => $totalContrats,
                        'items' => $statusItems
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur DDC Controller: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors du chargement des données',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // menu 2 : partenaires
    public function partenaires()
    {
        $partenairesPluck = Reseau::whereIn('codebranche', ['BANKASS'])
            ->pluck('codepartenaire')
            ->unique()
            ->values();

        $partenaires = Reseau::whereIn('codebranche', ['BANKASS'])
            ->select('codepartenaire', 'libelle')
            ->distinct()
            ->get();

            

        $baseQuery = Contrat::whereIn('partenaire', $partenairesPluck);

        // Production cumul du mois
        $productionCumul = (clone $baseQuery)
            ->whereYear('saisiele', now()->year)
            ->sum('prime');

        // Total contrats sur l'année
        $totalAnnuel = (clone $baseQuery)
            ->whereYear('saisiele', now()->year)
            ->count();

        // Contrats rejetés sur l'année 
        $rejetsAnnuel = (clone $baseQuery)
            ->whereYear('saisiele', now()->year)
            ->where('etape', 4)
            ->count();

        // Taux de rejet
        $tauxRejetAnnuel = $totalAnnuel > 0 
            ? ($rejetsAnnuel / $totalAnnuel) * 100 
            : 0;

        $data = [
            'partenaires' => $partenaires,
            'productionCumul' => $productionCumul,
            'tauxRejetAnnuel' => round($tauxRejetAnnuel, 2),
            'productionMensuelle' => round($tauxRejetAnnuel, 2)
        ];

        // dd($data['partenaires']);

        return view('ddc.partner.index', compact('data'));
    }

    public function showPartenaire(Request $request, $code)
    {
        // Gestion du cas spécial
        $valuecode = ($code === '092') ? 'BNI' : $code;
        
        // Chargement du partenaire
        $partner = Reseau::where('codepartenaire', $code)->firstOrFail();
        
        // Stats annuelles
        $baseQuery = Contrat::where('partenaire', $valuecode)
            ->whereYear('saisiele', now()->year);

            
        
        $statsAnnuel = [
            'total' => (clone $baseQuery)->count(),
            'transmis' => (clone $baseQuery)->whereIn('etape', [2])->count(),
            'acceptes' => (clone $baseQuery)->where('etape', 3)->count(),
            'rejets' => (clone $baseQuery)->where('etape', 4)->count(),
            'prod_mensuelle' => (clone $baseQuery)->whereMonth('saisiele', now()->month)->sum('prime'),
            'prod_annuelle' => (clone $baseQuery)->sum('prime'),
        ];
        $statsAnnuel['taux_rejet'] = $statsAnnuel['total'] > 0 ? round(($statsAnnuel['rejets'] / $statsAnnuel['total']) * 100, 2) : 0;
        
        // Top 5 Produits
        $topProduits = (clone $baseQuery)
            ->select('codeproduit as produit', DB::raw('count(*) as count'))
            ->groupBy('codeproduit')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
        
        // Évolution mensuelle
        $rawEvolution = (clone $baseQuery)
            ->select(DB::raw('MONTH(saisiele) as month'), DB::raw('SUM(prime) as amount'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('amount', 'month')
            ->toArray();
        
        $evolution = [];
        for ($i = 1; $i <= 12; $i++) {
            $evolution[] = (float) ($rawEvolution[$i] ?? 0);
        }
        
        // Liste des contrats avec pagination
        $contrats = $this->getContratsList($request, $valuecode);

        $statsShow = [
            'total' => (clone $contrats)->count(),
            'transmis' => (clone $contrats)->whereIn('etape', [2])->count(),
            'acceptes' => (clone $contrats)->where('etape', 3)->count(),
            'rejets' => (clone $contrats)->where('etape', 4)->count()
        ];

        
        return view('ddc.partner.show', compact('partner', 'statsAnnuel', 'topProduits', 'evolution', 'contrats', 'statsShow'));
    }
    
    private function calculateStats($valuecode)
    {
        $baseQuery = Contrat::where('partenaire', $valuecode)
            ->whereYear('saisiele', now()->year);
        
        // Utiliser une seule requête avec conditions multiples
        $totals = (clone $baseQuery)->selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN etape IN (2,3) THEN 1 ELSE 0 END) as transmis,
            SUM(CASE WHEN etape = 3 THEN 1 ELSE 0 END) as acceptes,
            SUM(CASE WHEN etape = 4 THEN 1 ELSE 0 END) as rejets,
            SUM(CASE WHEN MONTH(saisiele) = ? THEN prime ELSE 0 END) as prod_mensuelle,
            SUM(prime) as prod_annuelle
        ", [now()->month])->first();
        
        $taux_rejet = $totals->total > 0 ? round(($totals->rejets / $totals->total) * 100, 2) : 0;
        
        return [
            'total' => $totals->total,
            'transmis' => $totals->transmis,
            'acceptes' => $totals->acceptes,
            'rejets' => $totals->rejets,
            'prod_mensuelle' => (float) $totals->prod_mensuelle,
            'prod_annuelle' => (float) $totals->prod_annuelle,
            'taux_rejet' => $taux_rejet,
        ];
    }
    
    private function getTopProduits($valuecode)
    {
        return Contrat::where('partenaire', $valuecode)
            ->whereYear('saisiele', now()->year)
            ->select('codeproduit as produit', DB::raw('COUNT(*) as count'))
            ->groupBy('codeproduit')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
    }
    
    private function getMonthlyEvolution($valuecode)
    {
        $rawEvolution = Contrat::where('partenaire', $valuecode)
            ->whereYear('saisiele', now()->year)
            ->select(DB::raw('MONTH(saisiele) as month'), DB::raw('SUM(prime) as amount'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('amount', 'month')
            ->toArray();
        
        $evolution = [];
        for ($i = 1; $i <= 12; $i++) {
            $evolution[] = (float) ($rawEvolution[$i] ?? 0);
        }
        
        return $evolution;
    }
    

    private function getContratsList(Request $request, $valuecode)
    {
        $query = Contrat::where('partenaire', $valuecode);
        
        // Appliquer les filtres de date si présents
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('saisiele', [
                $request->start_date . ' 00:00:00', 
                $request->end_date . ' 23:59:59'
            ]);
        } else {
            $query->whereYear('saisiele', now()->year);
        }
        
        // Trier par date de saisie décroissante et paginer
        $contrats = $query->orderBy('saisiele', 'desc')->paginate(10);
        
        return $contrats;
    }

    public function suivieRejet(Request $request)
    {
        // Récupérer les partenaires pour le filtre
        $partenaires = Reseau::where('codebranche','BANKASS')->orderBy('libelle')->get();

        $partenairesPluck = Reseau::whereIn('codebranche', ['BANKASS'])
            ->pluck('codepartenaire')
            ->unique()
            ->values();

        
        // Récupérer les motifs de rejet uniques
        $motifsRejet = Contrat::where('etape', 4)
            ->whereIn('partenaire', $partenairesPluck)
            ->whereNotNull('motifrejet')
            ->select('motifrejet')
            ->distinct()
            ->pluck('motifrejet');
        
        // Calcul des KPIs
        $kpis = $this->calculateRejetKpis($request);
        
        // Récupérer la liste des rejets avec pagination
        $rejets = $this->getRejetsListQuery($request)->paginate(15);
        
        return view('ddc.suivieRejet', compact('partenaires', 'motifsRejet', 'kpis', 'rejets'));
    }

    /**
     * Calcule les KPIs des rejets
     */
    private function calculateRejetKpis($request)
    {
        // Récupération des partenaires BANKASS
        $partenairesPluck = Reseau::where('codebranche', 'BANKASS')
            ->pluck('codepartenaire')
            ->unique()
            ->toArray();

        // 🔥 Forcer inclusion BNI
        $partenairesPluck = array_unique(array_merge($partenairesPluck, ['BNI']));

        // Query de base
        $query = Contrat::where('etape', 4);

        /**
         * ============================
         * FILTRE PARTENAIRE
         * ============================
         */
        if ($request->filled('partenaire')) {

            $codes = [$request->partenaire];

            // Cas spécial BNI / 092
            if (in_array($request->partenaire, ['092', 'BNI'])) {
                $codes = ['092', 'BNI'];
            }

            $query->whereIn('partenaire', $codes);

        } else {

            $query->whereIn('partenaire', $partenairesPluck);
        }

        /**
         * ============================
         * FILTRE MOTIF
         * ============================
         */
        if ($request->filled('motif')) {
            $query->where('motifrejet', $request->motif);
        }

        /**
         * ============================
         * FILTRE DATES
         * ============================
         */
        if ($request->filled('start_date') && $request->filled('end_date')) {

            $query->whereBetween('annulerle', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);

        } elseif ($request->filled('start_date')) {

            $query->whereDate('annulerle', '>=', $request->start_date);

        } elseif ($request->filled('end_date')) {

            $query->whereDate('annulerle', '<=', $request->end_date);
        }

        /**
         * ============================
         * KPI CALCULS
         * ============================
         */

        $totalRejets = (clone $query)->count();

        $rejetsAujourdhui = (clone $query)
            ->whereDate('annulerle', today())
            ->count();

        // ⚠️ Correction mois (évite bug Carbon mutable)
        $now = now();
        $moisActuel = (clone $query)
            ->whereYear('annulerle', $now->year)
            ->whereMonth('annulerle', $now->month)
            ->count();

        $moisPrecedent = (clone $query)
            ->whereYear('annulerle', $now->copy()->subMonth()->year)
            ->whereMonth('annulerle', $now->copy()->subMonth()->month)
            ->count();

        $evolution = $moisPrecedent > 0
            ? round((($moisActuel - $moisPrecedent) / $moisPrecedent) * 100, 1)
            : ($moisActuel > 0 ? 100 : 0);

        // ⚠️ (Optionnel mais recommandé) appliquer les mêmes filtres ici aussi
        $totalContrats = Contrat::count();

        $tauxRejetGlobal = $totalContrats > 0
            ? round(($totalRejets / $totalContrats) * 100, 2)
            : 0;

        /**
         * ============================
         * TOPS
         * ============================
         */

        $topMotifs = (clone $query)
            ->select('motifrejet', DB::raw('COUNT(*) as total'))
            ->whereNotNull('motifrejet')
            ->groupBy('motifrejet')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topPartenaires = (clone $query)
            ->select('partenaire', DB::raw('COUNT(*) as total'))
            ->groupBy('partenaire')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return [
            'total_rejets' => $totalRejets,
            'rejets_aujourdhui' => $rejetsAujourdhui,
            'evolution' => $evolution,
            'evolution_direction' => $evolution >= 0 ? 'up' : 'down',
            'taux_rejet_global' => $tauxRejetGlobal,
            'top_motifs' => $topMotifs,
            'top_partenaires' => $topPartenaires,
        ];
    }

    /**
     * Récupère la requête des rejets avec filtres
     */
    private function getRejetsListQuery($request)
    {
        // Liste des partenaires BANKASS
        $partenairesPluck = Reseau::where('codebranche', 'BANKASS')
            ->pluck('codepartenaire')
            ->unique()
            ->toArray();

        // 🔥 Forcer l’inclusion de BNI
        $partenairesPluck = array_unique(array_merge($partenairesPluck, ['BNI']));

        // Query de base
        $query = Contrat::where('etape', 4)
            ->with(['adherent'])
            ->orderBy('annulerle', 'desc');

        /**
         * ============================
         * FILTRE PARTENAIRE
         * ============================
         */
        if ($request->filled('partenaire')) {

            $codes = [$request->partenaire];

            // Cas spécial BNI / 092
            if (in_array($request->partenaire, ['092', 'BNI'])) {
                $codes = ['092', 'BNI'];
            }

            $query->whereIn('partenaire', $codes);

        } else {

            // Tous les partenaires BANKASS + BNI
            $query->whereIn('partenaire', $partenairesPluck);
        }

        /**
         * ============================
         * FILTRE MOTIF
         * ============================
         */
        if ($request->filled('motif')) {
            $query->where('motifrejet', $request->motif);
        }

        /**
         * ============================
         * FILTRE DATES
         * ============================
         */
        if ($request->filled('start_date') && $request->filled('end_date')) {

            $query->whereBetween('annulerle', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);

        } elseif ($request->filled('start_date')) {

            $query->whereDate('annulerle', '>=', $request->start_date);

        } elseif ($request->filled('end_date')) {

            $query->whereDate('annulerle', '<=', $request->end_date);
        }

        return $query;
    }

    /**
     * API pour récupérer la liste des rejets (AJAX)
     */
    public function getRejetsList(Request $request)
    {
        $rejets = $this->getRejetsListQuery($request)->paginate(15);
        
        return response()->json([
            'data' => $rejets->items(),
            'pagination' => [
                'current_page' => $rejets->currentPage(),
                'last_page' => $rejets->lastPage(),
                'total' => $rejets->total(),
                'per_page' => $rejets->perPage()
            ]
        ]);
    }

    /**
     * Traite un rejet (marque comme traité)
     */
    public function traiterRejet($id)
    {
        try {
            $contrat = Contrat::findOrFail($id);
            
            // Vérifier si le contrat est bien un rejet
            if ($contrat->etape != 4) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce contrat n\'est pas un rejet'
                ], 400);
            }
            
            // Ajouter les champs de traitement (créez ces colonnes si nécessaire)
            // Si les colonnes n'existent pas, on peut utiliser un attribut ou une table séparée
            $contrat->update([
                'rejet_traite' => 1,
                'rejet_traite_le' => now(),
                'rejet_traite_par' => auth()->user()->name ?? auth()->user()->email ?? 'Système'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Le rejet a été marqué comme traité'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exporte la liste des rejets en CSV
     */
    public function exportRejets(Request $request)
    {
        $rejets = $this->getRejetsListQuery($request)->get();
        
        $filename = 'rejets_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Entête CSV
        fputcsv($output, [
            'ID',
            'N° Contrat',
            'Partenaire',
            'Client',
            'Contact',
            'Produit',
            'Prime (FCFA)',
            'Motif Rejet',
            'Date Rejet',
            'Rejeté par',
            'Statut'
        ]);
        
        // Données
        foreach ($rejets as $rejet) {
            fputcsv($output, [
                $rejet->id,
                $rejet->numeropolice ?? $rejet->id,
                $rejet->partenaire,
                $rejet->adherent->nom . ' ' . ($rejet->adherent->prenom ?? '') ?? 'N/A',
                $rejet->adherent->telephone ?? 'N/A',
                $rejet->codeproduit . ' - ' . ($rejet->libelleproduit ?? ''),
                $rejet->prime,
                $rejet->motifrejet ?? 'Non spécifié',
                $rejet->annulerle ? date('d/m/Y H:i', strtotime($rejet->annulerle)) : '-',
                $rejet->rejeterpar ?? 'Système',
                ($rejet->rejet_traite ?? false) ? 'Traité' : 'En attente'
            ]);
        }
        
        fclose($output);
        exit;
    }

    
}