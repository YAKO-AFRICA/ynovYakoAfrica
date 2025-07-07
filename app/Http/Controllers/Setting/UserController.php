<?php

namespace App\Http\Controllers\Setting;

use App\Models\User;
use App\Models\Zone;
use App\Models\Equipe;
use App\Models\Membre;
use App\Models\Reseau;
use App\Models\Partner;
use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

ini_set('memory_limit', '1024M');

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $membres = Membre::orderby('idmembre', 'desc')->where('typ_membre','!=','3')->get();
        

        $membres = Membre::orderby('idmembre', 'desc')
        ->where('typ_membre', '!=', '3')
        ->get()
        ->groupBy('codepartenaire');


        $reseaux = Reseau::all();
        $zones = Zone::all();
        $equipes = Equipe::all();
        $partners = Partner::all();
        $roles = Role::all();
        $profiles = Profile::all();
        
        return view('settings.users.index', compact('membres', 'reseaux', 'zones', 'equipes', 'partners', 'roles', 'profiles'));
    }

    public function indexByPartenaire($id)
    {
        $membresbypartenaire = Membre::orderby('idmembre', 'desc')->with('zone', 'equipe', 'reseau')
        ->where('codepartenaire', $id)->get();


        $reseaux = Reseau::all();
        $zones = Zone::all();
        $equipes = Equipe::all();
        $partners = Partner::all();
        $roles = Role::all();
        $profiles = Profile::all();
        $codepartenaire = $id;

        return view('settings.users.indexByPartner', compact('membresbypartenaire', 'reseaux', 'zones', 'equipes', 'partners', 'roles', 'codepartenaire', 'profiles'));
    }
    public function updateColumns(Request $request)
    {
        // Sauvegarde des colonnes dans la session
        $columns = $request->input('columns', []);
        session(['activeColumns' => $columns]);

        return redirect()->back()->with('success', 'Colonnes mises à jour avec succès.');
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

        // \dd($request->all());

        if ($request->codePart == "092") {
            $partenaire = "BNI";
            $type = null;
        } else {
            $partenaire = $request->codePart;
            $type = 2;
        }

<<<<<<< HEAD
        // $id = Membre::max('idmembre') + 2;
        $id = now()->format('mdHis');

        Log::info("ID du membre : $id");
=======
        // $id = Membre::max('idmembre') + 1;

        // $existe = Membre::where('idmembre', $id)->firstOrFail();

        // if($existe){
        //     $id + 1;
        // }
        // do {
        //     $id = Membre::max('idmembre') + 1;
        // } while (Membre::where('idmembre', $id )->exists() && User::where('idmembre', $id )->exists());

        // random de 6 caractere en chiffre
        do {
            $id = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Membre::where('idmembre', $id)->exists() && User::where('idmembre', $id)->exists());


>>>>>>> 249025b7a8b61bacf13d8e1667a7f0831d220896


        DB::beginTransaction();
        try {
            $membre = Membre::create([
                'idmembre' => $id,
                'codeagent' => $request->codeagent,
                'typ_membre' => $type,
                'codereseau' => $request->codereseau,
                'codepartenaire' => $request->codePart,
                'partenaire' => $partenaire,
                'codezone' => $request->codezone,
                'codeequipe' => $request->codeequipe, // id agence // equipe
                'sexe' => $request->sexe,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'datenaissance' => $request->datenaissance,
                'profession' => $request->profession,
                'agence' => $request->equipeCode,  // equipe es une aagence // code
                'branche' => $request->branche,
                'login' => $request->login,
                'role' => $request->profile,
                'coderole' => $request->profile_id,
                'pass' => $request->pass,
                'email' => $request->email,
                'cel' => $request->cel,
                'tel' => $request->tel,
            ])->save();

            if($membre){
                $user = User::create([
                    'idmembre' => $id,
                    'email' => $request->email,
                    'login' => $request->login,
                    'id_role' => $request->role_id,
                    'password' => bcrypt($request->pass),
                    'codepartenaire' => $request->codePart,
                    'branche' => $request->branche
                ]);

                $role = Role::find($request->role_id);
                $user->assignRole($role);

                $user->syncRoles([$role->id]);

                DB::commit();
                
            }

            DB::commit();

            if($membre){
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
            

        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse =[
                'type'=>'error',
                'urlback'=>'',
                'message'=>"Erreur systeme! ". $th->getMessage(),
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

        Log::info("ID du membre : $id");
        Log::info("code reseau : $request->codereseau");

        DB::beginTransaction();

        try {
            $membre = Membre::where('idmembre', $id)->update([
                'codereseau' => $request->codereseau,
                'codezone' => $request->codezone,
                'codeequipe' => $request->codeequipe,
                'sexe' => $request->sexe,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'datenaissance' => $request->datenaissance,
                'profession' => $request->profession,
                'agence' => $request->equipeCode,
                'branche' => $request->branche,
                'login' => $request->login,
                'role' => $request->profile,
                'coderole' => $request->role_id, // ou profile_id selon cohérence
                'email' => $request->email,
                'cel' => $request->cel,
                'tel' => $request->tel,
            ]);

            if ($membre) {
                Log::info("Membre mis à jour");

                $userAssign = User::where('idmembre', $id)->first();
                if ($userAssign) {
                    Log::info("User assigné trouvé");

                    $userAssign->update([
                        'email' => $request->email,
                        'login' => $request->login,
                        'id_role' => $request->role_id,
                        'branche' => $request->branche
                    ]);

                    $role = Role::find($request->role_id);
                    if ($role) {
                        $userAssign->assignRole($role);
                        $userAssign->syncRoles([$role->id]);
                        Log::info("Rôle synchronisé");
                    }
                }

                DB::commit();

                $dataResponse = [
                    'type' => 'success',
                    'urlback' => "back",
                    'message' => "Enregistré avec succès !",
                    'code' => 200,
                ];
            } else {
                DB::rollBack();
                $dataResponse = [
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Erreur d'enregistrement !",
                    'code' => 500,
                ];
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse = [
                'type' => 'error',
                'urlback' => '',
                'message' => "Erreur système ! " . $th->getMessage(),
                'code' => 500,
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

            $saving= Membre::where(['idmembre'=>$id])->delete();

            $user = User::where(['idmembre'=>$id])->delete();

            if ($saving) {

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


    public function userProfile()
    {
        return view('settings.users.profile.index');
    }
    public function updateProfile(Request $request, string $id)
    {
        // $user = TblUsers::where('idmembre', $id)->get();
        // dd($user);
        DB::beginTransaction();
        try {
            $user = Membre::where('idmembre', $id)->first();
            if($request->file('photo') == null){
                $imageName = Auth::user()->membre->photo;
            }else{
                $photoProfile = $request->file('photo');
                // dd($photoProfile);
                if ($photoProfile) {
                    $imageName = $user->idmembre .'_'.  now()->format('YmdHis'). '.' . $photoProfile->getClientOriginalExtension();
                    $destinationPath = public_path('images/userProfile');
                    $photoProfile->move($destinationPath, $imageName);   
                }
            }
            $user->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'cel' => $request->cel,
                'photo' => $imageName ?? '',           
            ]);
            if ($user) {
                $dataResponse = [
                    'type' => 'success',
                    'urlback' => "back",
                    'message' => "Modifié avec succès!",
                    'code' => 200,
                ];
                DB::commit();
            } else {
                DB::rollback();
                $dataResponse = [
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Erreur lors de la modification",
                    'code' => 500,
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

    public function updateMp(Request $request)
    {

        // dd($request->password);

        DB::beginTransaction();
        try {

            if ($request->password) {
                if ($request->password !== $request->confirm_password) {
                    DB::rollback();
                    $dataResponse = [
                        'type' => 'error',
                        'urlback' => '',
                        'message' => "Les mots de passe ne correspondent pas",
                        'code' => 400,
                    ];
                    return response()->json($dataResponse);
                }
                else{
                    $mp = auth()->user()->update([
                        'password' => bcrypt($request->password)
                    ]);

                    $id = auth()->user()->idmembre;
                    $membre = Membre::where('idmembre', $id)->firstOrFail();
                    if(!$membre){
                        $membre->update(['pass' => bcrypt($request->password)]);
                    }

                    if ($mp) {
                        // Déconnexion de l'utilisateur
                        auth()->logout();
    
                        $dataResponse = [
                            'type' => 'success',
                            'urlback' => "back",
                            'message' => "Modifié avec succès! Veuillez vous reconnecter avec votre nouveau mot de passe.",
                            'code' => 200,
                        ];
                        DB::commit();
                    } else {
                        DB::rollback();
                        $dataResponse = [
                            'type' => 'error',
                            'urlback' => '',
                            'message' => "Erreur lors de la modification",
                            'code' => 500,
                        ];
                    }
    

                }

            } else {
                $dataResponse = [
                    'type' => 'error',
                    'urlback' => 'back',
                    'message' => "Le mot de passe ne doit pas être vide",
                    'code' => 400,
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
