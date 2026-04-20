@extends('layouts.main')

@section('title', 'Analytics - ' . $partner->libelle)

@push('styles')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        --danger-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    
    .kpi-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
    }
    
    .kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.15);
    }
    
    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    }
    
    .bg-premium-blue {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .bg-premium-dark {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: white;
    }
    
    .stat-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.8;
        font-weight: 600;
    }
    
    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        line-height: 1.2;
    }
    
    .stat-unit {
        font-size: 0.8rem;
        font-weight: 400;
        opacity: 0.7;
    }
    
    .filter-bar {
        background: white;
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .table-modern {
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    
    /* .table-modern tbody tr {
        background: white;
        border-radius: 12px;
        transition: all 0.2s;
    } */
    
    /* .table-modern tbody tr:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    } */

    .table-modern tbody tr { transition: all 0.2s; border-bottom: 1px solid #f1f4f8; }
    .table-modern tbody tr:hover { background-color: #f8f9fc; }
    .badge-soft {
        padding: 0.35em 1em;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .avatar-sm { width: 32px; height: 32px; font-size: 0.8rem; }
    /* Optimisation Mobile */
    @media (max-width: 768px) {
        .filter-form { width: 100%; }
        .stat-summary { overflow-x: auto; white-space: nowrap; padding-bottom: 10px; }
    }
    
    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    
    .chart-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
    }
    
    .chart-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        border-radius: 20px;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    
    {{-- Header avec breadcrumb --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('ddc.index') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ddc.partners.index') }}" class="text-decoration-none">Partenaires</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $partner->libelle }}</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class='bx bx-building fs-3'></i>
                </div>
                <div>
                    <h1 class="h3 mb-0 fw-bold text-gray-800">{{ $partner->libelle }}</h1>
                    <p class="text-muted mb-0">Code: <strong>{{ $partner->codepartenaire }}</strong> | Membre depuis {{ $partner->created_at ? $partner->created_at->format('F Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <button onclick="refreshData()" class="btn btn-outline-primary rounded-pill px-3" id="refreshBtn">
                <i class='bx bx-refresh'></i> Rafraîchir
            </button>
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-3">
                <i class='bx bx-printer'></i> Imprimer
            </button>
            <a href="{{ route('ddc.partners.index') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class='bx bx-arrow-back'></i> Retour
            </a>
        </div>
    </div>

    {{-- KPIs avec animations --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="kpi-card bg-info p-3 text-white animate-pulse">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Production Annuelle</div>
                        <div class="stat-value">{{ number_format($statsAnnuel['prod_annuelle'], 0, ',', ' ') }}</div>
                        <div class="stat-unit mt-1">FCFA</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class='bx bx-line-chart-down fs-4'></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">
                        <i class='bx bx-calendar'></i> Année {{ now()->year }}
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="kpi-card bg-secondary p-3 text-white">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Mois en cours</div>
                        <div class="stat-value">{{ number_format($statsAnnuel['prod_mensuelle'], 0, ',', ' ') }}</div>
                        <div class="stat-unit mt-1">FCFA</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class='bx bx-calendar-week fs-4'></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">
                        <i class='bx bx-time'></i> {{ now()->format('F Y') }}
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="kpi-card p-3 bg-danger" style="color: white;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Taux de Rejet</div>
                        <div class="stat-value">{{ $statsAnnuel['taux_rejet'] }}<span class="stat-unit">%</span></div>
                        <div class="stat-unit mt-1">Dossiers rejetés</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class='bx bx-block fs-4'></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">
                        {{ $statsAnnuel['rejets'] }} / {{ $statsAnnuel['total'] }} dossiers
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="kpi-card p-3 bg-success text-white" style="color: #1e293b;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Dossiers Acceptés</div>
                        <div class="stat-value">{{ number_format($statsAnnuel['acceptes'], 0, ',', ' ') }}</div>
                        <div class="stat-unit mt-1">Taux succès</div>
                    </div>
                    <div class="bg-white bg-opacity-50 rounded-circle p-2">
                        <i class='bx bx-check-circle fs-4'></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">
                        Taux: {{ $statsAnnuel['total'] > 0 ? round(($statsAnnuel['acceptes'] / $statsAnnuel['total']) * 100, 1) : 0 }}% de réussite
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="chart-card card h-100">
                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold text-gray-800 mb-1">Courbe de Performance Mensuelle</h6>
                            <p class="text-muted small mb-0">Évolution de la production {{ now()->year }}</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light rounded-pill" type="button" data-bs-toggle="dropdown">
                                <i class='bx bx-dots-vertical-rounded'></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="exportChartAsImage()">Exporter l'image</a></li>
                                <li><a class="dropdown-item" href="#" onclick="toggleDataLabels()">Afficher les valeurs</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="growthChart" style="height: 320px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4">
            <div class="chart-card card h-100">
                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                    <h6 class="fw-bold text-gray-800 mb-1">Mix Produits</h6>
                    <p class="text-muted small mb-0">Top 5 produits vendus</p>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <canvas id="produitsDoughnut" style="height: 260px; width: 100%;"></canvas>
                    <div class="mt-3" id="produitsLegend"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Contrats avec filtres améliorés --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <div class="d-flex flex-column gap-3">
                {{-- Ligne Titre + Actions --}}
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column flex-md-row justify-content-btween align-items-md-center gap-3">
                        <h6 class="fw-bold text-gray-800 mb-1">Historique des Contrats</h6>
                        <p class="text-muted small mb-0">Liste détaillée des transactions</p>
                    </div>
                    
                    {{-- Formulaire Filtre (Desktop: inline, Mobile: stacked via classes) --}}
                    <form action="{{ url()->current() }}" method="GET" class="d-none d-md-flex gap-2 align-items-center">
                        <div class="input-group input-group-sm">
                            <input type="date" name="start_date" class="form-control border-0 bg-light rounded-start-pill ps-3" 
                                value="{{ request('start_date') }}">
                            <span class="input-group-text bg-light border-0"><i class='bx bx-right-arrow-alt'></i></span>
                            <input type="date" name="end_date" class="form-control border-0 bg-light rounded-end-pill pe-3" 
                                value="{{ request('end_date') }}">
                        </div>
                        <button type="submit" class="btn btn-sm btn-dark rounded-pill px-3">Filtrer</button>
                        @if(request()->has('start_date'))
                            <a href="{{ url()->current() }}" class="btn btn-sm btn-light rounded-circle"><i class='bx bx-refresh'></i></a>
                        @endif
                    </form>
                </div>

                {{-- Ligne des Compteurs Rapides --}}
                <div class="stat-summary d-flex gap-2 flex-wrap">
                    <span class="badge-soft bg-secondary-light text-secondary border border-secondary-subtle p-2">
                        <span class="fw-bold">{{ $statsShow['total'] }}</span> Saisies
                    </span>
                    <span class="badge-soft bg-info-light text-info border border-info-subtle p-2">
                        <span class="fw-bold">{{ $statsShow['transmis'] }}</span> Transmis
                    </span>
                    <span class="badge-soft bg-success-light text-success border border-success-subtle p-2">
                        <span class="fw-bold">{{ $statsShow['acceptes'] }}</span> Acceptés
                    </span>
                    <span class="badge-soft bg-danger-light text-danger border border-danger-subtle p-2">
                        <span class="fw-bold">{{ $statsShow['rejets'] }}</span> Rejetés
                    </span>
                </div>

                {{-- Filtre Mobile Uniquement (Visible seulement sur petit écran) --}}
                <form action="{{ url()->current() }}" method="GET" class="d-md-none row g-2">
                    <div class="col-6"><input type="date" name="start_date" class="form-control form-control-sm bg-light border-0" value="{{ request('start_date') }}"></div>
                    <div class="col-6"><input type="date" name="end_date" class="form-control form-control-sm bg-light border-0" value="{{ request('end_date') }}"></div>
                    <div class="col-12"><button type="submit" class="btn btn-sm btn-dark w-100 rounded-pill">Appliquer les filtres</button></div>
                </form>
            </div>
        </div>
        
        <div class="card-body p-0 mt-2">
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead class="bg-light/50">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold">RÉFÉRENCE</th>
                            <th class="ps-4 py-3 text-muted small fw-bold">SOUSCRIPTEUR</th>
                            <th class="py-3 text-muted small fw-bold">DATE DE SAISSIE</th>
                            <th class="py-3 text-muted small fw-bold">PRODUIT</th>
                            <th class="py-3 text-muted small fw-bold text-end">MONTANT</th>
                            <th class="pe-4 py-3 text-muted small fw-bold text-center">STATUT</th>
                            <th class="pe-4 py-3 text-muted small fw-bold text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contrats as $contrat)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark small">#{{ $contrat->id }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        <div class="fw-semibold text-gray-800" style="font-size: 0.85rem;">{{ $contrat->adherent->nom . ' ' . $contrat->adherent->prenom ?? 'Client Inconnu' }}</div>
                                        
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small">{{ date('d M Y', strtotime($contrat->saisiele)) ?? '-' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-white border text-dark fw-normal rounded-pill px-2">
                                    {{ $contrat->libelleproduit ?? 'Produit Inconnu' }}
                                </span>
                            </td>
                            <td class="text-end fw-bold text-dark">
                                {{ number_format($contrat->prime, 0, ',', ' ') }} <small class="fw-light">FCFA</small>
                            </td>
                            <td class="pe-4 text-center">
                                @php
                                    $conf = [
                                        1 => ['c' => 'secondary', 'i' => 'bx-edit-alt', 'l' => 'Saisi'],
                                        2 => ['c' => 'info', 'i' => 'bx-paper-plane', 'l' => 'Transmis'],
                                        3 => ['c' => 'success', 'i' => 'bx-check-double', 'l' => 'Accepté'],
                                        4 => ['c' => 'danger', 'i' => 'bx-error-circle', 'l' => 'Rejeté']
                                    ][$contrat->etape] ?? ['c' => 'light', 'i' => 'bx-help-circle', 'l' => 'Inconnu'];
                                @endphp
                                <span class="badge-soft bg-{{ $conf['c'] }}-light text-{{ $conf['c'] }} py-1 px-2">
                                    <i class='bx {{ $conf['i'] }}'></i> {{ $conf['l'] }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('prod.show', $contrat->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class='bx bx-show'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Aucun contrat sur cette période.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-transparent border-0 py-3 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Total: <strong>{{ $contrats->total() }}</strong></span>
                <div>{{ $contrats->links('pagination::bootstrap-4') }}</div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
let growthChart, produitsChart;
let showDataLabels = false;

// Configuration des couleurs modernes
const colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69'];

document.addEventListener('DOMContentLoaded', function() {
    initCharts();
});

function initCharts() {
    // Graphique Doughnut
    const ctxDoughnut = document.getElementById('produitsDoughnut').getContext('2d');
    const produitsData = @json($topProduits);
    
    produitsChart = new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: produitsData.map(p => p.produit),
            datasets: [{
                data: produitsData.map(p => p.count),
                backgroundColor: colors.slice(0, produitsData.length),
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        font: { size: 11 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} contrats (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });

    // Graphique d'évolution
    const ctxGrowth = document.getElementById('growthChart').getContext('2d');
    const evolutionData = @json($evolution);
    const maxValue = Math.max(...evolutionData, 100000);
    
    growthChart = new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Production (FCFA)',
                data: evolutionData,
                borderColor: '#4e73df',
                borderWidth: 3,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 8,
                pointBackgroundColor: '#4e73df',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            let value = context.raw;
                            return `${label}: ${new Intl.NumberFormat('fr-FR').format(value)} FCFA`;
                        }
                    }
                },
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5] },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}

// Rafraîchir les données via AJAX
function refreshData() {
    const btn = document.getElementById('refreshBtn');
    const originalHtml = btn.innerHTML;
    
    btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Chargement...';
    btn.disabled = true;
    
    // Afficher un overlay de chargement
    showLoadingOverlay();
    
    setTimeout(() => {
        location.reload();
    }, 500);
}

function showLoadingOverlay() {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay';
    overlay.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p class="mt-2 text-muted">Mise à jour des données...</p>
        </div>
    `;
    document.querySelector('.container-fluid').appendChild(overlay);
}

function exportChartAsImage() {
    const canvas = document.getElementById('growthChart');
    const link = document.createElement('a');
    link.download = 'performance_partenaire.png';
    link.href = canvas.toDataURL();
    link.click();
}

function toggleDataLabels() {
    showDataLabels = !showDataLabels;
    if (growthChart) {
        growthChart.update();
    }
}

// Auto-refresh toutes les 5 minutes (optionnel)
setInterval(() => {
    if (!document.hidden) {
        refreshData();
    }
}, 300000);
</script>

@push('styles')
<style>
    .bg-success-light { background-color: #d1fae5; }
    .bg-danger-light { background-color: #fee2e2; }
    .bg-info-light { background-color: #d1f5ff; }
    .bg-secondary-light { background-color: #f3f4f6; }
    
    .avatar-sm {
        width: 32px;
        height: 32px;
    }
    
    .rounded-4 {
        border-radius: 1rem !important;
    }
    
    .btn:active {
        transform: scale(0.98);
    }
    
    @media print {
        .btn, .dropdown, .filter-bar, #refreshBtn {
            display: none !important;
        }
        .kpi-card {
            break-inside: avoid;
        }
        body {
            padding: 0;
            margin: 0;
        }
    }
</style>
@endpush
@endsection