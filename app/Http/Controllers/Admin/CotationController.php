<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomerMail;
use App\Models\Adherent;
use App\Models\Contrat;
use App\Models\Cotation;
use App\Models\Membre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CotationController extends Controller
{
    public function index()
    {

        $cotations = Cotation::where('etat', 'actif')->with('contrat')->orderBy('created_at', 'desc')->get();
        
        return view('cotations.index', compact('cotations'));
    }

    public function show($uuid)
    {

        $cotation = Cotation::where('uuid', $uuid)->first();

        $contrat = $cotation->contrat;

        // dd($contrat);

        return view('cotations.show', compact('cotation', 'contrat'));
    }

    public function update(Request $request, $uuid)
    {


        $cotation = Cotation::where('uuid', $uuid)->first();

        $cotation->update([
            'status' => 'accepted',
            'note' => $request->note,
        ]);

        $contrats = Contrat::where('id', $cotation->id_contrat)->update([
            'prime' => $request->prime,
            'primepricipale' => $request->prime,
            'surprime' => $request->surprime,
            'accepterle' => now(),
            'accepterpar' => Auth::user()->membre->idmembre,
            'etape' => 1,
        ]);

        // envoie d'e mail de notification à l'agent et au souscripteur

        // $this->sendMail($request);

        return response()->json([
            'type' => 'success',
            'urlback' => "back",
            'message' => "Cotation N° " . $cotation->code . " validée avec succès!",
            'code' => 200,
        ]);
    }

    public function store(Request $request, $uuid)
    {

        try{
            $cotation = Cotation::where('uuid', $uuid)->first();
            $idAdherent = Adherent::max('id') + 1;
            $idContrat = Contrat::max('id') + 1;

            $conseiller = Membre::where('idmembre', $cotation->autheur)->first();

            $adherent = Adherent::create([
                'id' => $idAdherent,
                'nom' => $cotation->nomCompletSouscripteur,
                'prenom' => $cotation->nomCompletSouscripteur,
                'mobile1' => $cotation->telephoneSouscripteur,
                
            ])->save;

            $contrat = Contrat::create([
                'id' => $idContrat,
                'codeConseiller' => $conseiller->codeagent,
                'nomagent' => $conseiller->nom . ' ' . $conseiller->prenom,
                'codeadherent' => $idAdherent,
                'codeproduit' => 'loyemp',
                'libelleproduit' => 'loyale emprunteur DIFIN',
            ])->save;

            return response()->json(
                [
                    'type' => 'success',
                    'urlback' => \route('cotation.create',$idContrat),
                    'message' => 'Cotation traitée avec succès'
                ]
            );

        }catch(Exception $e){
            return response()->json(
                [
                    'type' => 'error',
                    'message' => 'Une erreur est survenue lors du traitement de la cotation',
                    'error' => $e->getMessage(),
                ]
            );
        }   

    }

    public function create($id)
    {

        $contrat = Contrat::where('id', $id)->first();
        
        return view('cotations.create' , compact('contrat'));
    }

    public function sendMail(Request $request)
    {
        try {
            $mailData = [
                'title' => 'La demande de cotation a été acceptée !',
            ];

            $emailSubject = 'Acceptation de la demande de cotation';

            Mail::to('jhon001doe@gmail.com')->send(new CustomerMail($mailData, $emailSubject));

            return response()->json([
                'type' => 'success',
                'message' => "Mail envoyé avec succès!",
                'code' => 200,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => "Erreur d'envoi du mail! " . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }
}
