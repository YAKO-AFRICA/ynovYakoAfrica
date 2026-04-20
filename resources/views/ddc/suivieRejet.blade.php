@extends('layouts.main')

@section('title', 'Suivi des Rejets')

@push('styles')
<style>
    :root {
        --rejet-primary: #dc2626;
        --rejet-secondary: #ef4444;
        --rejet-gradient: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }
    
    .rejet-kpi-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
    }
    
    .rejet-kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 35px -10px rgba(220, 38, 38, 0.2);
    }
    
    .bg-rejet-gradient {
        background: #dc2626;
        color: white;
    }
    
    .bg-rejet-light {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        color: #991b1b;
    }
    
    .bg-rejet-dark {
        background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);
        color: white;
    }
    
    .badge-rejet {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    
    .badge-traite {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    
    .btn-traiter {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: white;
        transition: all 0.2s;
    }
    
    .btn-traiter:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(5, 150, 105, 0.3);
        color: white;
    }
    
    .filter-card {
        background: white;
        border-radius: 20px;
        border: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }
    
    .table-rejets tbody tr {
        transition: all 0.2s;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .table-rejets tbody tr:hover {
        background: linear-gradient(90deg, #fef2f2 0%, #ffffff 100%);
    }
    
    .rejet-highlight {
        border-left: 3px solid #dc2626;
        background: linear-gradient(90deg, #fef2f2 0%, #ffffff 50%);
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .rejet-row {
        animation: slideIn 0.3s ease-out;
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
    
    .avatar-sm {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('ddc.index') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Suivi des rejets</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-3 mt-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px; background: linear-gradient(135deg, #dc2626, #b91c1c);">
                    <i class='bx bx-block fs-2 text-white'></i>
                </div>
                <div>
                    <h1 class="h3 mb-0 fw-bold" style="background: linear-gradient(135deg, #dc2626, #991b1b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Suivi des Rejets
                    </h1>
                    <p class="text-muted mb-0">Gérez et analysez les dossiers rejetés</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <button onclick="refreshData()" class="btn btn-outline-secondary rounded-pill px-3">
                <i class='bx bx-refresh'></i> Rafraîchir
            </button>
            <a href="{{ route('ddc.rejets.export', request()->query()) }}" class="btn btn-outline-primary rounded-pill px-3">
                <i class='bx bx-export'></i> Exporter
            </a>
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-3">
                <i class='bx bx-printer'></i> Imprimer
            </button>
        </div>
    </div>

    {{-- KPIs Rejets --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="rejet-kpi-card bg-white p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Total Rejets</div>
                        <div class="stat-value">{{ number_format($kpis['total_rejets'], 0, ',', ' ') }}</div>
                        <div class="stat-unit mt-1">Dossiers rejetés</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class='bx bx-block fs-4'></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">
                        <i class='bx bx-calendar'></i> Tous les rejets
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="rejet-kpi-card bg-white p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Rejets Aujourd'hui</div>
                        <div class="stat-value">{{ number_format($kpis['rejets_aujourdhui'], 0, ',', ' ') }}</div>
                        <div class="stat-unit mt-1">Nouveaux rejets</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class='bx bx-calendar-today fs-4'></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">
                        <i class='bx bx-time'></i> {{ now()->format('d/m/Y') }}
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="rejet-kpi-card bg-white p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Taux de Rejet Global</div>
                        <div class="stat-value">{{ $kpis['taux_rejet_global'] }}<span class="stat-unit">%</span></div>
                        <div class="stat-unit mt-1">Part des rejets</div>
                    </div>
                    <div class="bg-white bg-opacity-50 rounded-circle p-2">
                        <i class='bx bx-pie-chart-alt fs-4'></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">
                        <i class='bx bx-trending-{{ $kpis['evolution_direction'] }}'></i> 
                        {{ $kpis['evolution'] >= 0 ? '+' : '' }}{{ $kpis['evolution'] }}% vs mois dernier
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="rejet-kpi-card bg-white p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label text-muted">Motifs distincts</div>
                        <div class="stat-value text-gray-800">{{ $motifsRejet->count() }}</div>
                        <div class="stat-unit mt-1">Causes de rejet</div>
                    </div>
                    <div class="bg-light rounded-circle p-2">
                        <i class='bx bx-list-ul fs-4 text-primary'></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-muted">
                        <i class='bx bx-info-circle'></i> Analyser les causes
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphiques d'analyse --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h6 class="fw-bold mb-0">
                        <i class='bx bx-pie-chart-alt text-danger'></i> Top 5 Motifs de Rejet
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="motifsChart" style="height: 280px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h6 class="fw-bold mb-0">
                        <i class='bx bx-building text-danger'></i> Top 5 Partenaires avec Rejets
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="partenairesChart" style="height: 280px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="filter-card card mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('ddc.suivieRejet') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-muted">Partenaire</label>
                    <select name="partenaire" class="form-select">
                        <option value="">Tous les partenaires</option>
                        @foreach($partenaires as $partenaire)
                            <option value="{{ $partenaire->codepartenaire }}" 
                                {{ request('partenaire') == $partenaire->codepartenaire ? 'selected' : '' }}>
                                {{ $partenaire->libelle }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-muted">Motif de rejet</label>
                    <select name="motif" class="form-select">
                        <option value="">Tous les motifs</option>
                        @foreach($motifsRejet as $motif)
                            <option value="{{ $motif }}" {{ request('motif') == $motif ? 'selected' : '' }}>
                                {{ $motif }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-muted">Date début</label>
                    <input type="date" name="start_date" class="form-control" 
                           value="{{ request('start_date') }}">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-muted">Date fin</label>
                    <input type="date" name="end_date" class="form-control" 
                           value="{{ request('end_date') }}">
                </div>
                
                <div class="col-12">
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                            <i class='bx bx-search'></i> Appliquer les filtres
                        </button>
                        @if(request()->anyFilled(['partenaire', 'motif', 'start_date', 'end_date']))
                            <a href="{{ route('ddc.suivieRejet') }}" class="btn btn-light rounded-pill px-4">
                                <i class='bx bx-reset'></i> Réinitialiser
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Liste des rejets --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h6 class="fw-bold mb-0">
                        <i class='bx bx-list-ul text-danger'></i> Liste des dossiers rejetés
                    </h6>
                    <p class="text-muted small mb-0">Gérez les rejets et marquez-les comme traités</p>
                </div>
                <div class="text-muted small">
                    <i class='bx bx-data'></i> Total: <strong class="text-danger">{{ $rejets->total() }}</strong> rejets
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-rejets align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold">N° Contrat</th>
                            <th class="py-3 text-muted small fw-bold">Partenaire</th>
                            <th class="py-3 text-muted small fw-bold">Souscripteur</th>
                            <th class="py-3 text-muted small fw-bold">Produit</th>
                            <th class="py-3 text-muted small fw-bold text-end">Prime</th>
                            <th class="py-3 text-muted small fw-bold">Motif</th>
                            <th class="py-3 text-muted small fw-bold">Date rejet</th>
                            <th class="pe-4 py-3 text-muted small fw-bold text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rejets as $rejet)
                        <tr class="rejet-row {{ ($rejet->rejet_traite ?? false) ? '' : 'rejet-highlight' }}">
                            <td class="ps-4">
                                <div class="fw-bold text-dark small">
                                    <i class='bx bx-receipt text-danger'></i> 
                                    {{ $rejet->id ?? '--' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge-rejet">
                                    <i class='bx bx-building'></i> {{ $rejet->partenaire ?? '--' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center">
                                        <i class='bx bx-user text-muted'></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-gray-800" style="font-size: 0.85rem;">
                                            {{ $rejet->adherent->nom . ' ' . ($rejet->adherent->prenom ?? '') ?? 'Client Inconnu' }}
                                        </div>
                                        @if(isset($rejet->adherent->telephone))
                                            <small class="text-muted">{{ $rejet->adherent->telephone ?? '--' }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                    {{ Str::limit($rejet->libelleproduit ?? 'Produit Inconnu', 30) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <span class="fw-bold text-danger">
                                    {{ number_format($rejet->prime, 0, ',', ' ') }}
                                </span>
                                <small class="text-muted">FCFA</small>
                            </td>
                            <td>
                                <span class="badge-rejet">
                                    <i class='bx bx-error-circle'></i>
                                    {{ Str::limit($rejet->motifrejet ?? 'Non spécifié', 35) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="small fw-semibold">
                                        {{ $rejet->annulerle ? date('d/m/Y', strtotime($rejet->annulerle)) : '-' }}
                                    </span>
                                    <small class="text-muted">
                                        {{ $rejet->annulerle ? date('H:i', strtotime($rejet->annulerle)) : '' }}
                                    </small>
                                </div>
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('prod.show', $rejet->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class='bx bx-show'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class='bx bx-check-circle fs-1 text-success'></i>
                                <p class="text-muted mt-2 mb-0">Aucun rejet trouvé</p>
                                <p class="text-muted small">Modifiez vos filtres pour voir plus de résultats</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-transparent border-0 py-3 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-muted small">
                    Affichage de {{ $rejets->firstItem() ?? 0 }} à {{ $rejets->lastItem() ?? 0 }} sur {{ $rejets->total() }} rejets
                </div>
                <div>
                    {{ $rejets->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphiques
const motifsData = @json($kpis['top_motifs']);
const partenairesData = @json($kpis['top_partenaires']);

// Graphique des motifs de rejet
if (motifsData && motifsData.length > 0) {
    const ctxMotifs = document.getElementById('motifsChart').getContext('2d');
    new Chart(ctxMotifs, {
        type: 'bar',
        data: {
            labels: motifsData.map(m => {
                let label = m.motifrejet || 'Non spécifié';
                return label.length > 25 ? label.substring(0, 25) + '...' : label;
            }),
            datasets: [{
                label: 'Nombre de rejets',
                data: motifsData.map(m => m.total),
                backgroundColor: 'rgba(220, 38, 38, 0.7)',
                borderColor: '#dc2626',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Rejets: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5] },
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
}

// Graphique des partenaires
if (partenairesData && partenairesData.length > 0) {
    const ctxPartenaires = document.getElementById('partenairesChart').getContext('2d');
    new Chart(ctxPartenaires, {
        type: 'bar',
        data: {
            labels: partenairesData.map(p => p.partenaire),
            datasets: [{
                label: 'Nombre de rejets',
                data: partenairesData.map(p => p.total),
                backgroundColor: 'rgba(239, 68, 68, 0.7)',
                borderColor: '#ef4444',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Rejets: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5] },
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
}



// Notification
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed top-0 end-0 m-3 shadow`;
    notification.style.zIndex = '9999';
    notification.style.animation = 'slideIn 0.3s ease-out';
    notification.innerHTML = `
        <div class="d-flex align-items-center gap-2">
            <i class='bx bx-${type === 'success' ? 'check-circle' : 'x-circle'} fs-5'></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}

// Rafraîchir
function refreshData() {
    location.reload();
}
</script>
@endsection