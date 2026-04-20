@extends('layouts.main')

@section('content')
<div class="container-fluid py-4">
    <header class="bg-white shadow-sm border-bottom mb-4 rounded">
        <div class="container-fluid px-4 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="bg-primary p-2 rounded-3 me-3">
                        <i class="fas fa-chart-line text-white fs-4"></i>
                    </div>
                    <div>
                        <h1 class="h4 fw-bold mb-0 text-dark">Suivi des Activités BANKASSURANCE</h1>
                        <p class="small text-muted mb-0">Direction du Développement Commercial - Assurance</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="d-none d-md-block text-end">
                        <span class="small text-muted d-block">Mise à jour:</span>
                        <span class="small fw-bold text-dark" id="current-date"></span>
                    </div>
                    <select id="period-select" class="form-select form-select-sm shadow-sm">
                        <option value="year" selected>Annuel</option>
                        <option value="month">Mensuel</option>
                    </select>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Indicateur de chargement -->
    <div id="loader" class="text-center py-5 d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>

    <div id="dashboard-content">
        <div id="kpi-cards-container" class="row g-4 mb-4"></div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card h-100 shadow-sm border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="h6 fw-bold mb-0">Évolution des Primes</h2>
                        </div>
                        <div style="height: 320px;">
                            <canvas id="prime-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100 shadow-sm border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="h6 fw-bold mb-0">Production par Partenaire</h2>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-primary btn-sm" data-chart-type="partner" data-metric="count">Nombre</button>
                                <button class="btn btn-light border btn-sm" data-chart-type="partner" data-metric="amount">Cumul Prime</button>
                            </div>
                        </div>
                        <div style="height: 320px;">
                            <canvas id="partner-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card h-100 shadow-sm border">
                    <div class="card-body">
                        <h2 class="h6 fw-bold mb-4">Distribution des Produits</h2>
                        <div class="row align-items-center">
                            <div class="col-md-5 mb-4 mb-md-0 text-center text-md-start">
                                <div style="height: 250px; width: 250px; margin: auto;">
                                    <canvas id="product-chart"></canvas>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div id="product-list" class="vstack gap-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100 shadow-sm border">
                    <div class="card-body">
                        <h2 class="h6 fw-bold mb-4">Statut des Contrats</h2>
                        <div id="contract-status-container" class="vstack gap-3"></div>
                        
                        <div class="mt-4 pt-4 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted">Taux de rejet:</span>
                                <span class="small fw-bold text-danger" id="rejection-rate">0%</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Taux de transmission:</span>
                                <span class="small fw-bold text-success" id="transmission-rate">0%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Variables globales pour les graphiques
    let primeChart = null;
    let partnerChart = null;
    let productChart = null;
    let currentData = null;

    // --- Fonction pour appeler l'API getDdcData ---
    async function getDdcData(type = 'year') {
        try {
            const response = await fetch(`/ddc/calculDataDDC?type=${type}`);
            const data = await response.json();
            console.log('Données DDC chargées:', data);
            return data;
        } catch (error) {
            console.error('Erreur lors du chargement des données:', error);
            return null;
        }
    }

    // --- Formatage des nombres ---
    function formatNumber(num) {
        if (!num && num !== 0) return '0';
        return new Intl.NumberFormat('fr-FR').format(num);
    }

    function formatCurrency(amount) {
        if (amount >= 1000000) {
            return (amount / 1000000).toFixed(1) + 'M';
        }
        if (amount >= 1000) {
            return (amount / 1000).toFixed(0) + 'K';
        }
        return formatNumber(amount);
    }

    // --- Rendu des KPI avec les données réelles ---
    function renderKPICards(kpi) {
        return `
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="text-muted mb-0">Cumul des Primes</h6>
                            <i class="fas fa-coins text-primary"></i>
                        </div>
                        <h3 class="fw-bold text-primary">${formatCurrency(kpi.primeAnnuel)}</h3>
                        <small class="text-muted">Annuel (Fcfa)</small>
                        <hr class="my-2">
                        <div class="bg-light rounded text-center p-2">
                            <small class="text-muted">Mois en cours</small><br>
                            <strong>${formatCurrency(kpi.primeMensuel)} Fcfa</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="text-muted mb-0">Contrats</h6>
                            <i class="fas fa-file-contract text-success"></i>
                        </div>
                        <h3 class="fw-bold text-success">${formatNumber(kpi.totalAnnuel)}</h3>
                        <small class="text-muted">Annuel</small>
                        <hr class="my-2">
                        <div class="bg-light rounded text-center p-2">
                            <small class="text-muted">Mois en cours</small><br>
                            <strong>${formatNumber(kpi.totalMensuel)}</strong>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // --- Rendu liste produits ---
    function renderProductList(products) {
        if (!products || products.length === 0) {
            return '<p class="text-muted">Aucune donnée disponible</p>';
        }
        
        return products.map(product => `
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small text-dark fw-medium">
                        <i class="fas fa-circle me-2" style="color: ${product.color}; font-size: 8px;"></i>${product.name}
                    </span>
                    <span class="small fw-bold">${product.value}%</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar" role="progressbar" style="width: ${product.value}%; background-color: ${product.color}"></div>
                </div>
            </div>
        `).join('');
    }

    // --- Rendu statuts contrats ---
    function renderContractStatus(statusItems) {
        if (!statusItems || statusItems.length === 0) {
            return '<p class="text-muted">Aucune donnée disponible</p>';
        }
        
        // Filtrer pour n'afficher que les statuts pertinents
        const relevantStatuses = statusItems.filter(item => 
            ['Saisie Non Transmis', 'Transmis Annuel', 'Transmis Actif', 'Rejetés', 'Acceptées'].includes(item.status)
        );
        
        return relevantStatuses.map(item => `
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small text-muted">${item.status}</span>
                    <span class="small fw-bold">${formatNumber(item.count)}</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-${item.color}" role="progressbar" style="width: ${item.percentage}%"></div>
                </div>
            </div>
        `).join('');
    }

    // --- Mise à jour des graphiques ---
    function updateCharts(data) {
        // 1. Graphique d'évolution des primes
        if (primeChart) primeChart.destroy();
        
        const monthNames = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        const primeData = new Array(12).fill(0);
        
        if (data.charts.evolution) {
            data.charts.evolution.forEach(item => {
                if (item.mois >= 1 && item.mois <= 12) {
                    primeData[item.mois - 1] = item.prime;
                }
            });
        }
        
        const ctxPrime = document.getElementById('prime-chart').getContext('2d');
        primeChart = new Chart(ctxPrime, {
            type: 'line',
            data: {
                labels: monthNames,
                datasets: [{
                    label: 'Primes (Fcfa)',
                    data: primeData,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.05)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Primes: ${formatCurrency(context.raw)} Fcfa`;
                            }
                        }
                    }
                }
            }
        });

        // 2. Graphique des partenaires
        if (partnerChart) partnerChart.destroy();
        
        const partners = data.charts.partnersData || [];
        const ctxPartner = document.getElementById('partner-chart').getContext('2d');
        const currentMetric = document.querySelector('[data-chart-type="partner"].btn-primary')?.getAttribute('data-metric') || 'count';
        
        let dataset;
        if (currentMetric === 'amount') {
            dataset = {
                label: 'Primes (Fcfa)',
                data: partners.map(p => p.premium),
                backgroundColor: '#0d6efd'
            };
        } else {
            dataset = {
                label: 'Nombre de contrats',
                data: partners.map(p => p.contracts),
                backgroundColor: '#198754'
            };
        }
        
        partnerChart = new Chart(ctxPartner, {
            type: 'bar',
            data: {
                labels: partners.map(p => p.name),
                datasets: [dataset]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                if (currentMetric === 'amount') {
                                    return `Primes: ${formatCurrency(value)} Fcfa`;
                                }
                                return `Contrats: ${formatNumber(value)}`;
                            }
                        }
                    }
                }
            }
        });

        // 3. Graphique des produits
        if (productChart) productChart.destroy();
        
        const products = data.charts.products || [];
        const ctxProduct = document.getElementById('product-chart').getContext('2d');
        
        // Générer des couleurs automatiquement si non définies
        const defaultColors = ['#0d6efd', '#198754', '#ffc107', '#6f42c1', '#dc3545', '#fd7e14', '#20c997'];
        const productsWithColors = products.map((product, index) => ({
            ...product,
            color: product.color !== '#6c757d' ? product.color : defaultColors[index % defaultColors.length]
        }));
        
        productChart = new Chart(ctxProduct, {
            type: 'doughnut',
            data: {
                labels: productsWithColors.map(p => p.name),
                datasets: [{
                    data: productsWithColors.map(p => p.value),
                    backgroundColor: productsWithColors.map(p => p.color),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}%`;
                            }
                        }
                    }
                }
            }
        });
    }

    // --- Chargement du dashboard ---
    async function loadDashboard(type = 'year') {
        const loader = document.getElementById('loader');
        const content = document.getElementById('dashboard-content');
        
        // Afficher le loader
        loader.classList.remove('d-none');
        content.style.opacity = '0.5';
        
        try {
            // Appel à l'API
            const data = await getDdcData(type);
            
            if (!data || !data.success) {
                throw new Error(data?.message || 'Erreur de chargement des données');
            }
            
            // Sauvegarder les données
            currentData = data;
            
            // Mettre à jour les KPI
            document.getElementById('kpi-cards-container').innerHTML = renderKPICards(data.kpi);
            
            // Mettre à jour la liste des produits
            document.getElementById('product-list').innerHTML = renderProductList(data.charts.products);
            
            // Mettre à jour les statuts des contrats
            document.getElementById('contract-status-container').innerHTML = renderContractStatus(data.charts.status.items);
            
            // Calculer et afficher les taux
            const statusItems = data.charts.status.items;
            const rejectionItem = statusItems.find(s => s.status === 'Rejetés');
            const transmissionItems = statusItems.filter(s => s.status === 'Transmis Annuel' || s.status === 'Transmis Actif');
            const totalTransmis = transmissionItems.reduce((sum, item) => sum + item.count, 0);
            
            const rejectionRate = rejectionItem ? rejectionItem.percentage : 0;
            const transmissionRate = data.kpi.totalAnnuel > 0 ? (totalTransmis / data.kpi.totalAnnuel) * 100 : 0;
            
            document.getElementById('rejection-rate').textContent = rejectionRate.toFixed(1) + '%';
            document.getElementById('transmission-rate').textContent = transmissionRate.toFixed(1) + '%';
            
            // Mettre à jour les graphiques
            updateCharts(data);
            
        } catch (error) {
            console.error('Erreur:', error);
            // Afficher une erreur dans les conteneurs
            document.getElementById('kpi-cards-container').innerHTML = `
                <div class="col-12">
                    <div class="alert alert-danger">
                        Erreur lors du chargement des données: ${error.message}
                    </div>
                </div>
            `;
        } finally {
            // Cacher le loader
            loader.classList.add('d-none');
            content.style.opacity = '1';
        }
    }

    // --- Gestion des événements ---
    document.addEventListener('DOMContentLoaded', function() {
        // Date courante
        const now = new Date();
        document.getElementById('current-date').textContent = now.toLocaleDateString('fr-FR', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        
        // Chargement initial (Annuel par défaut)
        loadDashboard('year');
        
        // Changement de période
        document.getElementById('period-select').addEventListener('change', function(e) {
            loadDashboard(e.target.value);
        });
        
        // Boutons pour le graphique des partenaires
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('[data-chart-type="partner"]');
            if (btn && currentData) {
                const metric = btn.getAttribute('data-metric');
                
                // Mise à jour visuelle des boutons
                document.querySelectorAll('[data-chart-type="partner"]').forEach(b => {
                    b.classList.remove('btn-primary');
                    b.classList.add('btn-light', 'border');
                });
                btn.classList.remove('btn-light', 'border');
                btn.classList.add('btn-primary');
                
                // Mettre à jour le graphique avec la nouvelle métrique
                updateCharts(currentData);
            }
        });
    });
</script>

<style>
    .extra-small { font-size: 0.75rem; }
    .card { transition: transform 0.2s ease-in-out; }
    .card:hover { transform: translateY(-2px); }
    #dashboard-content { transition: opacity 0.3s ease; }
    .progress-bar { transition: width 0.6s ease; }
</style>

@endsection