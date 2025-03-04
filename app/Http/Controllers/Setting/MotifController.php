<?php

namespace App\Http\Controllers\Setting;

use App\Models\MotifRejet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MotifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motifs = MotifRejet::orderBy('id', 'desc')->where('etat', 'actif')->get();

        return view('settings.motifs.index', compact('motifs'));
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

        DB::beginTransaction();
        try {
            $MotifRejet = MotifRejet::create([
                'libelle' => $request->libelle,
                'etat' => 'actif',
                
            ])->save();

            DB::commit();

            if($MotifRejet){
                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Enregistré avec succes!",
                    'code'=>200,
                ];
                DB::commit();
            }else{
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur d'enregistrement !",
                    'code'=>500,
                ];
                DB::rollBack();
            }
            

        } catch (Throwable $th) {
            DB::rollBack();
            $dataResponse =[
                'type'=>'error',
                'urlback'=>'',
                'message'=>"Erreur systeme! .".$th->getMessage(),
                'code'=>500,
            ];
        }
        return response()->json($dataResponse);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        DB::beginTransaction();
        try {
            $MotifRejet = MotifRejet::where(['id'=>$id])->update([
                'libelle' => $request->libelle
            ]);

            DB::commit();

            if($MotifRejet){
                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Modification enregistré avec succes!",
                    'code'=>200,
                ];
                DB::commit();
            }else{
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur Modification !",
                    'code'=>500,
                ];
                DB::rollBack();
            }
            

        } catch (Throwable $th) {
            DB::rollBack();
            $dataResponse =[
                'type'=>'error',
                'urlback'=>'',
                'message'=>"Erreur systeme! .".$th->getMessage(),
                'code'=>500,
            ];
        }
        return response()->json($dataResponse);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        DB::beginTransaction();
        try {

            $deleted= MotifRejet::where(['id'=>$id])->update(['etat'=>'inactif']);

            if ($deleted) {

                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"Supprimé avec succes!",
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
