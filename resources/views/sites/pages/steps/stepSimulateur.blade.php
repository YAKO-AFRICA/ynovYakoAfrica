@extends('sites.layouts.main')
@section('content')
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }

        .simulation-container {
            background-color: white;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .result-box {
            background-color: #f0f8ff;
            border-left: 4px solid #073811;
            padding: 20px;
            border-radius: 5px;
            height: 100%;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-calculate {
            background-color: #10441b;
            color: white;
            font-weight: 500;
        }

        .btn-reset {
            background-color: #6c757d;
            color: white;
            font-weight: 500;
        }

        .btn-calculate:hover {
            background-color: #0b5ed7;
            color: white;
        }

        .btn-reset:hover {
            background-color: #5a6268;
            color: white;
        }

        .btn-subscribe {
            margin-top: 20px;
            display: none;
        }

        .btn-prime {
            color: white;
            text-decoration: none;
        }

        .btn-prime:hover {
            color: white;
        }

        .button-group {
            display: flex;
            {{-- gap: 10px; --}}
        }

        .button-group button {
            flex: 1;
        }
    </style>

    <div class="page-content">

        <div class="container card">
            <div class="card-header">
                <h1 class="text-center mb-4">Simulateur de Prime d'Assurance</h1>
            </div>
            <div class="card-body">
                <style>
                    /* Couleur de fond du bouton sélectionné */
                    .nav-pills .nav-link.active {
                        background-color: #076633 !important;
                        color: #fff !important;
                        /* Pour que le texte reste lisible */
                    }

                    .nav-pills .nav-link {
                        color: #076633 !important;
                    }
                </style>

                <div class="row simulation-container">
                    <div class="nav col-md-2 nav-pills" aria-orientation="vertical">
                        <button class="nav-link w-100 fs-5 active">
                            {{ $user->membre->codepartenaire == 'DIASPORA' && $product->CodeProduit == 'LFFUN' ? 'YAKO OBSEQUE DIASPORA' : $product->MonLibelle }}
                        </button>

                    </div>
                    <div class="col-6">

                        <div class="row">
                            <div class="col-md-12">
                                <form id="simulationForm">
                                    <div class="row">
                                        <div class="mb-3 col-12">
                                            <label for="birthDate-{{ $product->CodeProduit }}"
                                                class="form-label">Date de naissance</label>
                                            <input type="date" class="form-control"
                                                id="birthDate-{{ $product->CodeProduit }}" required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="productCode-{{ $product->CodeProduit }}"
                                        id="productCode-{{ $product->CodeProduit }}"
                                        value="{{ $product->CodeProduit }}">
                                    <div class="row">
                                        <div class="mb-3 col-12">
                                            <label class="form-label">Type de souscription</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="subscriptionType-{{ $product->CodeProduit }}"
                                                    id="individuel-{{ $product->CodeProduit }}" value="individuel"
                                                    checked>
                                                <label class="form-check-label"
                                                    for="individuel-{{ $product->CodeProduit }}">
                                                    Individuel
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="subscriptionType-{{ $product->CodeProduit }}"
                                                    id="famille-{{ $product->CodeProduit }}" value="famille">
                                                <label class="form-check-label"
                                                    for="famille-{{ $product->CodeProduit }}">
                                                    Famille
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-4 col-12">
                                            <label class="form-label">Zone de souscription</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="subscriptionZone-{{ $product->CodeProduit }}"
                                                    id="france-{{ $product->CodeProduit }}" value="france" checked>
                                                <label class="form-check-label"
                                                    for="france-{{ $product->CodeProduit }}">
                                                    France
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="subscriptionZone-{{ $product->CodeProduit }}"
                                                    id="cima-{{ $product->CodeProduit }}" value="cima">
                                                <label class="form-check-label"
                                                    for="cima-{{ $product->CodeProduit }}">
                                                    Zone CIMA
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6  mb-2">
                                            <button type="button" class="btn btn-calculate w-100"
                                                onclick="calculatePrime('{{ $product->CodeProduit }}')">Calculer la
                                                prime</button>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <button type="button" class="btn btn-reset w-100"
                                                onclick="resetSimulation('{{ $product->CodeProduit }}')">Réinitialiser</button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-4 p-0">
                        <div class="result-box">
                            <h4 class="text-center mb-3">Résultat de la simulation</h4>
                            <div id="resultContent" class="text-center">
                                <p class="text-muted">Veuillez remplir le formulaire et cliquer sur "Calculer la prime"</p>
                            </div>
                            <div id="simulationResult" style="display: none;">
                                <p><strong>Âge:</strong> <span id="ageResult"></span> ans</p>
                                <p><strong>Type:</strong> <span id="typeResult"></span></p>
                                <p><strong>Zone:</strong> <span id="zoneResult"></span></p>
                                <hr>
                                <p><strong>Capital assuré:</strong> <span id="capitalResult"></span> €</p>
                                <p><strong>Prime annuelle:</strong> <span id="primeResult"></span> €</p>
                            </div>

                            <div class="bbe">
                                <form id="simulationForm">
                                    @csrf
                                    <input type="hidden" name="productCode" id="productCode">
                                    <input type="hidden" name="primeSimulateur" id="primeSimulateur">
                                    <input type="hidden" name="capitalSimulateur" id="capitalSimulateur">
                                    <input type="hidden" name="birthDateSimulateur" id="birthDateSimulateur">
                                    <input type="hidden" name="typeSimulateur" id="typeSimulateur">
                                    <button type="button" class="btn btn-calculate w-100 d-none" id="subscribeButton">
                                        Souscrire
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const user = @json($user);

                let data = JSON.parse(sessionStorage.getItem('souscriptionData') || '{}');

                // Met à jour uniquement si l'utilisateur n'est pas encore sauvegardé
                if (!data.utilisateur) {
                    data.utilisateur = user;
                    sessionStorage.setItem('souscriptionData', JSON.stringify(data));
                    console.log('✅ Utilisateur sauvegardé dans la session :', data.utilisateur);
                } else {
                    console.log('ℹ️ Utilisateur déjà présent dans la session :', data.utilisateur);
                }
            });
            function calculatePrime(codeProduit) {
                // Récupérer les valeurs du formulaire spécifique au produit
                const birthDateInput = document.getElementById('birthDate-' + codeProduit);
                const birthDate = new Date(birthDateInput.value);

                const subscriptionType = document.querySelector(`input[name="subscriptionType-${codeProduit}"]:checked`).value;
                const subscriptionZone = document.querySelector(`input[name="subscriptionZone-${codeProduit}"]:checked`).value;

                // Vérifier la date
                if (isNaN(birthDate.getTime())) {
                    swal.fire({
                        icon: 'warning',
                        title: 'Désolé',
                        text: 'Veuillez entrer une date de naissance valide',
                        confirmButtonText: 'Fermer'
                    });
                    return;
                }

                // Calcul de l'âge
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                // Limite d'âge
                if (age > 80) {
                    swal.fire({
                        icon: 'warning',
                        title: 'Désolé',
                        text: 'Ce simulateur est valable pour les personnes de 80 ans maximum',
                        confirmButtonText: 'Fermer'
                    });
                    return;
                }

                // Calcul capital & prime
                let capital, prime;
                if (age < 66) {
                    if (subscriptionType === 'individuel') {
                        if (subscriptionZone === 'france') {
                            capital = 7500;
                            prime = 198;
                        } else {
                            capital = 4500;
                            prime = 119;
                        }
                    } else { // famille
                        if (subscriptionZone === 'france') {
                            capital = 30000;
                            prime = 390;
                        } else {
                            capital = 18000;
                            prime = 233;
                        }
                    }
                } else { // 66-75 ans
                    if (subscriptionType === 'individuel') {
                        if (subscriptionZone === 'france') {
                            capital = 7500;
                            prime = 297;
                        } else {
                            capital = 4500;
                            prime = 178;
                        }
                    } else {
                        if (subscriptionZone === 'france') {
                            capital = 30000;
                            prime = 585;
                        } else {
                            capital = 18000;
                            prime = 349;
                        }
                    }
                }

                // Mise à jour des résultats
                document.getElementById('ageResult').textContent = age;
                document.getElementById('typeResult').textContent = (subscriptionType === 'individuel') ? 'Individuel' :
                    'Famille';
                document.getElementById('zoneResult').textContent = (subscriptionZone === 'france') ? 'France' : 'Zone CIMA';
                document.getElementById('capitalResult').textContent = capital.toLocaleString('fr-FR');
                document.getElementById('primeResult').textContent = prime.toLocaleString('fr-FR');

                document.getElementById('productCode').value = codeProduit;
                document.getElementById('primeSimulateur').value = prime;
                document.getElementById('capitalSimulateur').value = capital;
                document.getElementById('birthDateSimulateur').value = birthDateInput.value.replace(/\//g, '-');
                document.getElementById('typeSimulateur').value = subscriptionType;

                // Affichage des résultats
                document.getElementById('resultContent').style.display = 'none';
                document.getElementById('simulationResult').style.display = 'block';
                document.getElementById('subscribeButton').classList.remove('d-none');
                document.getElementById('subscribeButton').style.display = 'block';
            }

            function getSouscriptionData() {
                const data = sessionStorage.getItem('souscriptionData');
                return data ? JSON.parse(data) : {};
            }

            function saveSouscriptionData(data) {
                sessionStorage.setItem('souscriptionData', JSON.stringify(data));
                console.log('✅ Données mises à jour dans la session :', data);
            }

            function updateSimulationData(fields) {
                const data = getSouscriptionData();
                if (!data.simulationData) data.simulationData = {};
                Object.assign(data.simulationData, fields);
                saveSouscriptionData(data);
            }

            function attachSimulationListeners() {
                const codeProduit = document.getElementById('productCode-{{ $product->CodeProduit }}').value;

                document.getElementById('birthDate-' + codeProduit)?.addEventListener('change', (e) => {
                    updateSimulationData({ birthDate: e.target.value });
                });

                document.querySelectorAll(`input[name="subscriptionType-${codeProduit}"]`).forEach(input => {
                    input.addEventListener('change', (e) => {
                        updateSimulationData({ subscriptionType: e.target.value });
                    });
                });

                document.querySelectorAll(`input[name="subscriptionZone-${codeProduit}"]`).forEach(input => {
                    input.addEventListener('change', (e) => {
                        updateSimulationData({ subscriptionZone: e.target.value });
                    });
                });
            }

            function saveSimulationResult(age, type, zone, capital, prime) {
                updateSimulationData({
                    age,
                    type,
                    zone,
                    capital,
                    prime,
                    productCode: document.getElementById('productCode-{{ $product->CodeProduit }}').value
                });
            }

            function resetSimulation(codeProduit) {
                const form = document.getElementById('simulationForm');
                form.reset();

                document.getElementById('resultContent').style.display = 'block';
                document.getElementById('simulationResult').style.display = 'none';
                document.getElementById('subscribeButton').style.display = 'none';

                const user = @json($user);
                
                sessionStorage.removeItem('souscriptionData');
                 console.log('🔁 Session réinitialisée, avant suppression :', sessionStorage.getItem('souscriptionData'));
                
                // Recréer l'objet de session avec l'utilisateur
                const newSessionData = {
                    utilisateur: user,
                };
                

                sessionStorage.setItem('souscriptionData', JSON.stringify(newSessionData));
                
                console.log('🔁 Session réinitialisée, utilisateur conservé :', newSessionData);
            }

            const originalCalculatePrime = calculatePrime;
            calculatePrime = function (codeProduit) {
                originalCalculatePrime(codeProduit);

                const age = document.getElementById('ageResult').textContent;
                const type = document.getElementById('typeResult').textContent;
                const zone = document.getElementById('zoneResult').textContent;
                const capital = document.getElementById('capitalResult').textContent;
                const prime = document.getElementById('primeResult').textContent;

                saveSimulationResult(age, type, zone, capital, prime);

                console.log('📊 Résultats de simulation sauvegardés :', { age, type, zone, capital, prime });
            };

            document.addEventListener('DOMContentLoaded', () => {
                attachSimulationListeners();

                const data = getSouscriptionData();
                console.log('📦 Session actuelle à l\'initialisation :', data);
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {

                sessionStorage.removeItem('souscriptionData');

                const user = @json($user);

                // Recréer l'objet de session avec l'utilisateur
                const newSessionData = {
                    utilisateur: user,
                };
                sessionStorage.setItem('souscriptionData', JSON.stringify(newSessionData));

                const subscribeBtn = document.getElementById('subscribeButton');

                if (subscribeBtn) {
                    subscribeBtn.addEventListener('click', () => {

                        const souscriptionData = getSouscriptionData();
                        
                        const codeProduit = souscriptionData.simulationData.productCode;
                        const codePartner = souscriptionData.utilisateur.codepartenaire;

                        if (codeProduit && codePartner) {
                            const url = `/site/create/${codeProduit}/${codePartner}`;
                            console.log('🔗 Redirection vers :', url);
                            window.location.href = url;
                        } else {
                            console.warn('❌ Code produit ou code partenaire manquant dans la session');
                            Swal.fire({
                                icon: 'warning',
                                title: 'Données manquantes',
                                text: 'Impossible de continuer, certaines données de simulation ou utilisateur sont absentes.',
                                confirmButtonText: 'Fermer'
                            });
                        }
                    });
                } else {
                    console.error('❌ Bouton "Souscrire" introuvable dans le DOM');
                }
            });
        </script>


    </div>
    @endsection
