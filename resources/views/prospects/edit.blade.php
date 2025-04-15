@extends('layouts.main')

@section('content')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"><a href="/shared/home"><i class="bx bx-home-alt"></i></a></div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Prospect</li>
                    <li class="breadcrumb-item active" aria-current="page">Mise a jour</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Reglages</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                    <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#columnsModalPart">Personnaliser les colonnes</a>
                </div>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header text-white" style="background-color: #1e4520">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-edit me-2"></i>Modifier le Prospect
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('prospect.update', $prospect->uuid) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <!-- Section Informations Personnelles -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Informations Personnelles</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="first_name" class="form-label">Prénom <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $prospect->first_name) }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="last_name" class="form-label">Nom <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $prospect->last_name) }}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $prospect->email) }}">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="mobile" class="form-label">Téléphone Mobile</label>
                                            <input type="tel" class="form-control" id="mobile" name="mobile" maxlength="10" value="{{ old('mobile', $prospect->mobile) }}">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="adress" class="form-label">Adresse</label>
                                            <textarea class="form-control" id="adress" name="adress" rows="2">{{ old('adress', $prospect->adress) }}</textarea>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="city" class="form-label">Ville</label>
                                            <select type="select" class="form-control" name="city">
                                                @foreach ($villes as $item)
                                                    <option value="{{ $item->idville}}" class="form-option">{{ $item->libelleVillle ?? " "}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section Professionnelle -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Informations Professionnelles</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="profession_uuid" class="form-label">Profession</label>
                                            <select class="form-select" id="profession_uuid" name="profession_uuid">
                                                <option value="" disabled selected>Sélectionner...</option>
                                                @foreach($professions as $profession)
                                                    <option value="{{ $profession->IdProfession }}" {{ old('profession_uuid', $prospect->profession_uuid) == $profession->IdProfession ? 'selected' : '' }}>
                                                        {{ $profession->MonLibelle }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="secteurActivity_uuid" class="form-label">Secteur d'Activité</label>
                                            <select class="form-select" id="secteurActivity_uuid" name="secteurActivity_uuid">
                                                <option value="">Sélectionner...</option>
                                                @foreach($secteurActivites as $secteur)
                                                    <option value="{{ $secteur->IdSecteurActiviteSocietes }}" {{ old('secteurActivity_uuid', $prospect->secteurActivity_uuid) == $secteur->IdSecteurActiviteSocietes ? 'selected' : '' }}>
                                                        {{ $secteur->MonLibelle }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="natureProspect" class="form-label">Nature du Prospect <span class="text-danger">*</span></label>
                                            <select class="form-select" id="natureProspect" name="natureProspect" required>
                                                <option value="Suspect" {{ old('natureProspect', $prospect->natureProspect) == 'Suspect' ? 'selected' : '' }}>Suspect</option>
                                                <option value="Prospect" {{ old('natureProspect', $prospect->natureProspect) == 'Prospect' ? 'selected' : '' }}>Prospect</option>
                                                <option value="Déjà client" {{ old('natureProspect', $prospect->natureProspect) == 'Déjà client' ? 'selected' : '' }}>Déjà client</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section Assurance -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Informations Assurance</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="produit_id" class="form-label">Produit</label>
                                            <select class="form-select" id="products" name="products[]">
                                                @foreach ($product as $item)
                                                    <option value="{{ $item->IdProduit }}">
                                                        {{ $item->MonLibelle }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="typeCompagnie" class="form-label">Type de Compagnie</label>
                                            <select class="form-select" id="typeCompagnie" name="typeCompagnie">
                                                <option value="">Sélectionner...</option>
                                                <option value="assurance" {{ old('typeCompagnie', $prospect->typeCompagnie) == 'assurance' ? 'selected' : '' }}>Assurance</option>
                                                <option value="banque" {{ old('typeCompagnie', $prospect->typeCompagnie) == 'banque' ? 'selected' : '' }}>Banque</option>
                                                <option value="microfinance" {{ old('typeCompagnie', $prospect->typeCompagnie) == 'microfinance' ? 'selected' : '' }}>Microfinance</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section Statut -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Statut</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="lieuEvenement" class="form-label">Lieu de prospection</label>
                                            <input type="text" class="form-control" id="lieuEvenement" name="lieuEvenement" value="{{ old('lieuEvenement', $prospect->lieuEvenement) }}">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Statut <span class="text-danger">*</span></label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="nouveau" {{ old('status', $prospect->status) == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                                                <option value="en_cours" {{ old('status', $prospect->status) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                                <option value="finalise" {{ old('status', $prospect->status) == 'finalise' ? 'selected' : '' }}>Finalisé</option>
                                                <option value="annule" {{ old('status', $prospect->status) == 'annule' ? 'selected' : '' }}>Annulé</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="note" class="form-label">Notes</label>
                                            <textarea class="form-control" id="note" name="note" rows="3">{{ old('note', $prospect->note) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('prospect.show', $prospect->uuid) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary" style="background-color: #1e4520; border-color: #1e4520">
                                <i class="fas fa-save me-2"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .selection + .select2-container {
        width: 100% !important;
    }
    
    .selection + .select2-container .select2-selection {
        height: 38px;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }
    
    .selection + .select2-container .select2-selection__arrow {
        height: 36px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser Select2 pour les selects
    $('.selection').select2({
        width: '100%',
        dropdownParent: $('body'), // Important pour les modals
        placeholder: "Sélectionner...",
        allowClear: true
    });
});
</script>
@endsection