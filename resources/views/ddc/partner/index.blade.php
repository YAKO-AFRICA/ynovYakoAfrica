@extends('layouts.main')

@section('title', 'Partenaires BANKASS')

@push('styles')
<style>
    /* Style des Cartes KPIs du haut */
    .card-kpi { border: none; border-radius: 12px; transition: transform 0.2s; }
    
    /* Style des Cartes Partenaires */
    .partner-card {
        border: 1px solid #edf2f9;
        border-radius: 16px;
        transition: all 0.3s ease;
        cursor: pointer;
        background: #fff;
        height: 100%;
    }
    .partner-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08) !important;
        border-color: #4e73df;
    }
    .avatar-circle {
        width: 50px;
        height: 50px;
        background: #f8f9fc;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #4e73df;
        font-size: 1.2rem;
    }
    .status-dot {
        height: 8px;
        width: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    .search-container {
        position: relative;
        max-width: 500px;
    }
    .search-container i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #a1a1a1;
    }
    .search-input {
        padding: 12px 12px 12px 50px;
        border-radius: 30px;
        border: 1px solid #e3e6f0;
        background-color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    
    {{-- Top Header & Search --}}
    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <h1 class="h3 mb-1 text-gray-800 fw-bold">Réseau Partenaires</h1>
            <p class="text-muted">Gérez et suivez les performances de vos agences BANKASS</p>
        </div>
        <div class="col-lg-6">
            <div class="search-container ms-auto">
                <i class='bx bx-search fs-4'></i>
                <input type="text" id="partnerSearch" class="form-control search-input shadow-sm" placeholder="Rechercher par nom ou par code partenaire...">
            </div>
        </div>
    </div>

    {{-- Résumé des statistiques --}}
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card card-kpi shadow-sm border-0 bg-white p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar-circle bg-primary-light text-primary me-3">
                        <i class='bx bx-money'></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Production</div>
                        <div class="h4 fw-bold mb-0 text-gray-800">{{ number_format($data['productionCumul'], 0, ',', ' ') }} <small>FCFA</small></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-kpi shadow-sm border-0 bg-white p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar-circle bg-warning-light text-warning me-3">
                        <i class='bx bx-error'></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Taux Rejet</div>
                        <div class="h4 fw-bold mb-0 text-gray-800">{{ $data['tauxRejetAnnuel'] }}%</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-kpi shadow-sm border-0 bg-white p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar-circle bg-info-light text-info me-3">
                        <i class='bx bx-group'></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Actifs</div>
                        <div class="h4 fw-bold mb-0 text-gray-800">{{ count($data['partenaires']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grille des Partenaires --}}
    <div class="row g-4" id="partnersGrid">
        @foreach($data['partenaires'] as $partenaire)
        <div class="col-xl-3 col-lg-4 col-md-6 partner-item" 
             data-name="{{ strtolower($partenaire->libelle) }}" 
             data-code="{{ strtolower($partenaire->codepartenaire) }}">
            
            <div class="card partner-card shadow-sm" onclick="window.location.href='/ddc/partners/{{ $partenaire->codepartenaire }}'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="avatar-circle">
                            <i class='bx bxs-institution'></i>
                        </div>
                        <span class="badge bg-success-light text-success rounded-pill px-2 py-1" style="font-size: 10px;">
                            <span class="status-dot bg-success"></span> Actif
                        </span>
                    </div>
                    
                    <h6 class="fw-bold text-gray-800 mb-1">{{ $partenaire->libelle }}</h6>
                    <p class="text-primary small fw-bold mb-3">Code: {{ $partenaire->codepartenaire }}</p>
                    
                    <hr class="my-3 opacity-50">
                    
                    <div class="row text-center g-0">
                        <div class="col-6 border-end">
                            <small class="text-muted d-block">Secteur</small>
                            <span class="fw-bold small">BANKASS</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Contrats</small>
                            <span class="fw-bold small">--</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <button class="btn btn-outline-primary btn-sm w-100 rounded-pill">Consulter l'activité</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- État vide si aucune recherche ne correspond --}}
    <div id="noResults" class="text-center py-5 d-none">
        <i class='bx bx-search-alt text-muted display-1'></i>
        <p class="text-muted mt-3">Aucun partenaire ne correspond à votre recherche.</p>
    </div>
</div>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('partnerSearch');
    const noResults = document.getElementById('noResults');

    function normalize(text) {
        return (text || '')
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "");
    }

    searchInput.addEventListener('input', function () {

        const value = normalize(this.value);
        let visibleCount = 0;

        document.querySelectorAll('.partner-item').forEach(function (card) {

            const name = normalize(card.dataset.name);
            const code = normalize(card.dataset.code);

            if (!value || name.includes(value) || code.includes(value)) {
                card.style.display = ''; 
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        noResults.classList.toggle('d-none', visibleCount !== 0);
    });

});
</script>
@endsection

