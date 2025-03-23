<?php

namespace App\Http\Controllers\Admin;


use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\Contrat;

use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class BulletinController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function demoBulletin(request $request)
     {
        try {

            $contrat = Contrat::where('id', 89)->first();

            // Chargement de la vue avec les données
            $pdf = Pdf::loadView('productions.components.bullettin.ykeBulletin', [
                'contrat' => $contrat
            ]);

            // Option 1 : Retourner directement le PDF pour téléchargement
            return $pdf->stream('bulletin_adhesion.pdf');

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contrat = Contrat::find($id);
        return view('productions.components.bullettin.basicBulletin', compact('contrat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function generate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $contrat = Contrat::find($id);
            if($contrat)
            {
                // Options pour Dompdf
                $options = new Options();
                $options->set('isRemoteEnabled', true);
            
                // Générer le bulletin PDF avec Dompdf
                $pdf = Pdf::loadView('productions.components.bullettin.ykeBulletin', [
                    'contrat' => $contrat
                ]);
            
                // Répertoire pour enregistrer les fichiers temporaires
                $bulletinDir = public_path('documents/bulletin/');
                if (!is_dir($bulletinDir)) {
                    mkdir($bulletinDir, 0777, true);
                }
            
                $bulletinFileName = $bulletinDir . 'temp_bulletin_' . $contrat->id . '.pdf';
                $pdf->save($bulletinFileName);
            
                // Chemin vers le fichier CGU
                // $cguFile = public_path('root/cgu/CGPLanggnant.pdf');
                $cguFile = public_path('root/cgu/cg_yke.pdf');
            
                // Fusionner les PDF avec FPDI
                $finalPdf = new Fpdi();
            
                // Ajouter les pages du bulletin
                $finalPdf->AddPage();
                $finalPdf->setSourceFile($bulletinFileName);
                $tplIdx = $finalPdf->importPage(1);
                $finalPdf->useTemplate($tplIdx);
            
                // Ajouter toutes les pages du fichier CGU
                $pageCount = $finalPdf->setSourceFile($cguFile);
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $finalPdf->AddPage();
                    $tplIdx = $finalPdf->importPage($pageNo);
                    $finalPdf->useTemplate($tplIdx);
                }
            
                // Nom final du fichier
                $finalFileName = $bulletinDir . 'assurcompte_' . $contrat->id . '.pdf';
            
                // Enregistrer le PDF final
                $finalPdf->Output($finalFileName, 'F');
            
                // Supprimer le fichier temporaire du bulletin
                unlink($bulletinFileName);

                DB::commit();
            
                // Retourner le PDF final en tant que réponse
                return response()->file($finalFileName, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . basename($finalFileName) . '"'
                ]);

                
            }else{
                DB::rollBack();
                return response()->json([
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Erreur lors de la generation du bullettin! $th",
                    'code' => 500,
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
