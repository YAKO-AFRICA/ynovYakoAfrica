@extends('layouts.main')

@section('content')
<style>
    input[readonly],
        textarea[readonly],
        select[readonly] {
            background-color: #f0f0f0;
            /* Couleur de fond gris pour les champs en readonly */
            border: 1px solid #ccc;
            /* Bordure gris clair */
            /* cursor: not-allowed;        Curseur indiquant que l'action est interdite */
            cursor: no-drop;
            /* pointer-events: none; */
            /* Empêche toute interaction avec ces éléments */
        }

        /* Remplacer le curseur par l'emoji 🚫 lors du survol des champs readonly */
        input[readonly]:hover,
        textarea[readonly]:hover,
        select[readonly]:hover {
            cursor: no-drop;
            /* cursor: wait; */
        }
</style>
    <div class="row">
        <div class="col-12 col-lg-3">
            <div class="card">

                <center>
                    <div class="card-header">
                        <p>
                            <strong>Code de la prestation :</strong> <span>{{ $prestation->code ?? ''}}</span>
                        </p>
                        
                        <p>
                            <center>Status : 
                                @if ($prestation->etape == 0)
                                    <span class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                        <i class="bx bxs-circle me-1"></i>En attente de transmission
                                    </span>
                                @elseif ($prestation->etape == 1)
                                    <span class="badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3">
                                        <i class="bx bxs-circle me-1"></i>Demande transmise
                                    </span>
                                @elseif ($prestation->etape == 2)
                                    <span class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                        <i class="bx bxs-circle me-1"></i>Demande acceptée
                                    </span>
                                @elseif ($prestation->etape == 3)
                                    <span class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                        <i class="bx bxs-circle me-1"></i>Demande rejétée
                                    </span>
                                @elseif ($prestation->etape == 4)
                                    --
                                @endif
                            </center>
                        </p>
                    </div>
                </center>
    
                <div class="card-body">
    
                    <h5 class="my-3 text-center text-uppercase">Editer la prestation</h5>
    
                </div>
    
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0 text-primary font-weight-bold">Documents joint </h5>
                    </p>
                    <div class="mt-3"></div>
                    @if (
                        $prestation &&
                            $prestation->docPrestation &&
                            $prestation->docPrestation->where('idPrestation', $prestation->id)->count() > 0)
                        @forelse ($prestation->docPrestation->where('idPrestation', $prestation->id) as $doc)
                            <div class="d-flex align-items-center mt-3">
                                <div class="fm-file-box text-success"><i class='bx bxs-file-doc'></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0" style="font-size: 10px">
                                        {{ $doc->type == 'Police'
                                            ? "Police du contrat d'assurance"
                                            : ($doc->type == 'bulletin'
                                                ? "Bulletin du contrat d'assurance"
                                                : ($doc->type == 'RIB'
                                                    ? 'RIB du compte courant'
                                                    : ($doc->type == 'CNI'
                                                        ? 'CNI'
                                                        : ($doc->type == 'FicheIDNum'
                                                            ? 'Fiche ID numéro'
                                                            : ($doc->type == 'AttestationPerteContrat'
                                                                ? 'Attestation de perte de contrat'
                                                                : ($doc->type == 'etatPrestation'
                                                                    ? 'Fiche de la prestation'
                                                                    : '')))))) }}
                                    </h6>
                                    <p class="mb-0 text-secondary" style="font-size: 0.6em">
                                        {{ $doc->created_at ?? '' }}
                                    </p>
                                </div>
                                <h6 class="text-primary mb-0 text-center">
                                    <a class="btn btn-primary px-2" data-bs-target="#view-bulletin{{ $doc->id }}"
                                        data-bs-toggle="modal" title="Preview">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </h6>
                                <div class="modal fade" id="view-bulletin{{ $doc->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Preview
                                                    {{ $doc->type == 'Police'
                                                        ? "Police du contrat d'assurance"
                                                        : ($doc->type == 'bulletin'
                                                            ? "Bulletin du contrat d'assurance"
                                                            : ($doc->type == 'RIB'
                                                                ? 'RIB du compte courant'
                                                                : ($doc->type == 'CNI'
                                                                    ? 'CNI'
                                                                    : ($doc->type == 'FicheIDNum'
                                                                        ? 'Fiche ID numéro'
                                                                        : ($doc->type == 'AttestationPerteContrat'
                                                                            ? 'Attestation de perte de contrat'
                                                                            : ($doc->type == 'etatPrestation'
                                                                                ? 'Fiche de la prestation'
                                                                                : '')))))) }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="width: 100%; height: 80vh">
                                                @if ($doc->type == 'etatPrestation')
                                                    <iframe style="width: 100%; height: 100%" src="{{ asset($doc->path) }}"
                                                        frameborder="0"></iframe>
                                                @else
                                                    <iframe style="width: 100%; height: 100%" src="{{ asset($doc->path) }}"
                                                        frameborder="0"></iframe>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                @if ($doc->type == 'etatPrestation')
                                                    <a class="btn btn-primary text-white" href="{{ asset($doc->path) }}"
                                                        id="download-bulletin" title="Preview" download
                                                        >Telecharger
                                                        <i class="bx bx-download"></i>
                                                    </a>
                                                @else
                                                    <a class="btn btn-primary text-white" href="{{ asset($doc->path) }}"
                                                        id="download-bulletin" title="Preview" download
                                                        >Telecharger
                                                        <i class="bx bx-download"></i>
                                                    </a>
                                                @endif

                                                <button type="button" class="btn btn-primary"
                                                    data-bs-dismiss="modal">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-secondary">Aucun document joint</p>
                        @endforelse
                    @else
                        <p class="text-secondary">Aucun document joint</p>
                    @endif


                </div>
            </div>
        </div>
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-body">
                    <section id="info-contrat" class="section-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <dl class="row col-md-4">
                                                @if ($prestation && $prestation->membre != null && $prestation->membre->typ_membre !== 3)
                                                <dt class="col-xs-12 col-sm-6 col-md-5 col-lg-5">Saisie par :</dt>
                                                <dd class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
                                                    {{ $prestation->membre->prenom ?? '' }}
                                                    {{ $prestation->membre->nom ?? '' }} </dd>
                                                @endif
                                            </dl>
                                            <dl class="row col-md-8">
                                                @if ($prestation && $prestation->etape == 0)
                                                <form action="{{ route('prestation.transmettrePrest', $prestation->code)}}" method="post" class="submitForm d-flex justify-content-end">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary p-1 px-3  text-center"> Transmettre</button>
                                                </form>
                                                @endif
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('prestation.update', $prestation->code)}}" method="post" class="submitForm">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="card" style="width: 90%">
                                        <div class="card-body">
                                            <h3>Prestation</h3>
                                            @if ($prestation)
                                                <div class="mt-4">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="" class="form-label">Type de prestation</label>
                                                            <input type="text" name="typeprestation" value="{{ $prestation->typeprestation ?? '' }}" readonly class="form-control">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="" class="form-label">ID du contrat</label>
                                                            <input type="text" name="idcontrat" value="{{ $prestation->idcontrat ?? '' }}" readonly class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="" class="form-label">Montant souhaité</label>
                                                            <input type="text" name="montantSouhaite" value="{{ $prestation->montantSouhaite ?? '' }}" class="form-control">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="" class="form-label"> Moyen de paiement</label>
                                                            <div class="mb-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" name="moyenPaiement" type="radio" disabled value="Virement_Bancaire" id="Virement_Bancaire" 
                                                                        @if ($prestation->moyenPaiement === 'Virement_Bancaire')
                                                                                checked
                                                                        @endif>
                                                                    <label class="form-check-label" for="Virement_Bancaire">Virement Bancaire</label>
                                                                </div>
                                    
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" name="moyenPaiement" type="radio" disabled value="Mobile_Money" id="Mobile_Money" 
                                                                        @if ($prestation->moyenPaiement === 'Mobile_Money')
                                                                                checked
                                                                        @endif>
                                                                    <label class="form-check-label" for="Mobile_Money">Mobile Money</label>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($prestation->moyenPaiement == 'Mobile_Money')
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="" class="form-label"> Moyen de paiement</label>
                                                            <div class="mb-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" name="Operateur" type="radio" disabled value="Orange_money" id="Orange_money" 
                                                                        @if ($prestation->Operateur === 'Orange_money')
                                                                                checked
                                                                        @endif>
                                                                    <label class="form-check-label" for="Orange_money">Orange Money</label>
                                                                </div>
                                    
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" name="Operateur" type="radio" disabled value="Moov_Money" id="Moov_Money" 
                                                                        @if ($prestation->Operateur === 'Moov_Money')
                                                                                checked
                                                                        @endif>
                                                                    <label class="form-check-label" for="Moov_Money">Moov Money</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" name="Operateur" type="radio" disabled value="MTN_Money" id="MTN_Money" 
                                                                        @if ($prestation->Operateur === 'MTN_Money')
                                                                                checked
                                                                        @endif>
                                                                    <label class="form-check-label" for="MTN_Money">MTN Money</label>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="" class="form-label">N° de paiement</label>
                                                            <input type="number" name="telPaiement" value="{{ $prestation->telPaiement ?? '' }}" readonly class="form-control">
                                                        </div>
                                                    </div>
                                                    @elseif ($prestation->moyenPaiement == 'Virement_Bancaire')
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="" class="form-label">RIB</label>
                                                            <input type="text" name="IBAN" value="{{ $prestation->IBAN ?? '' }}" maxlength="24" minlength="24" class="form-control">
                                                        </div>
                                                    </div>
                                                    @endif
    
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <textarea name="msgClient" class="form-control" id="" cols="30" rows="5">{{ $prestation->msgClient ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-secondary">Aucune prestation trouvée</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3>Client</h3>
                                            <div class="mt-4">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Nom</label>
                                                        <input type="text" name="nom" value="{{ $prestation->membreClient->nom ?? ($prestation->nom ?? '') }}" readonly class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Prenom</label>
                                                        <input type="text" name="prenom" value="{{ $prestation->membreClient->prenom ?? ($prestation->prenom ?? '') }}" readonly class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Date de naissance</label>
                                                        <input type="datetime" name="datenaissance" value="{{ $prestation->membreClient->datenaissance ?? ($prestation->datenaissance ?? '') }}" readonly class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Genre</label>
                                                        <input type="text" name="sexe" value="{{ $prestation->membreClient->sexe ?? ($prestation->sexe ?? '') }}" readonly class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">N° de téléphone</label>
                                                        <input type="datetime" name="cel" value="{{ $prestation->membreClient->cel ?? ($prestation->cel ?? '') }}" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Tel WhatsApp</label>
                                                        <input type="text" name="tel" value="{{ $prestation->membreClient->tel ?? ($prestation->tel ?? '') }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">E-mail</label>
                                                        <input type="datetime" name="email" value="{{ $prestation->membreClient->email ?? ($prestation->email ?? '') }}" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Lieu de residence</label>
                                                        <input type="text" name="lieuderesidence" value="{{ $prestation->membreClient->lieuresidence ?? ($prestation->lieuresidence ?? '') }}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
