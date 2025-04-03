@extends('layouts.main')

@section('content')

<style>
    .ribbon {
        position: relative;
        background: #11771f;
        color: white;
        padding: 10px;
        font-weight: bold;
        text-align: center;
        border-radius: 5px 5px 0 0;
    }

    .btn-inactif {
        background-color: #d9d9d9;
        color: #666;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    .optional-garantie {
        background-color: #f8f9fa;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border-left: 4px solid #6c757d;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="card p-4">
                <h4 class="text-center text-uppercase">Simulateur de prime</h4>
                <fieldset>
                    <legend class="text-center w-auto float-none px-2 "><small>Données de simulation</small></legend>
                
                    <form id="primeForm">
                        @csrf

                        <div class="form-group row">
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label class="form-label">Code Produit :</label>
                                <input type="text" class="form-control" id="CodeProduit" name="CodeProduit" value="{{ $product->CodeProduit}}" required readonly>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label class="form-label">Code Périodicité :</label>
                                <select name="codePeriodicite" id="codePeriodicite" class="form-control" required>
                                    <option value="M">MENSUEL</option>
                                    <option value="T">TRIMESTRIEL</option>
                                    <option value="S">SEMESTRIEL</option>
                                    <option value="A">ANNUEL</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label class="form-label">Prime souhaité :</label>
                                <select name="capitalSouscrit" id="capitalSouscrit" class="form-select" required>
                                    <option value="" selected>Selectionnez une prime</option>
                                    <option value="15000">15 000</option>
                                    <option value="20000">20 000</option>
                                    <option value="25000">25 000</option>
                                    <option value="30000">30 000</option>
                                    <option value="40000">40 000</option>
                                    <option value="50000">50 000</option>
                                    <option value="75000">75 000</option>
                                    <option value="100000">100 000</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label class="form-label">Date de naissance :</label>
                                <input type="Date" class="form-control" id="dateNaissance" name="dateNaissance" required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3 d-none">
                                <label class="form-label">Âge Calculé :</label>
                                <input type="hidden" class="form-control" id="age" name="age">
                            </div>
                        </div>
                        
                        <!-- Section pour les garanties optionnelles -->
                        <div id="optionalGaranties" class="mt-4">
                            <h5 class="mb-3">Garanties optionnelles</h5>
                            <!-- Les garanties optionnelles seront ajoutées ici dynamiquement -->
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mt-3">Simuler</button>
                    </form>
                </fieldset>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
           <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header text-white text-center py-3">
                    <h5 class="text-uppercase mb-0">Résultat du simulateur</h5>
                </div>

                <div class="card-body">
                    <div class="container">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Garantie</th>
                                    <th>Prime</th>
                                    <th>Capital</th>
                                </tr>
                            </thead>
                            <tbody id="result">
                                <!-- Les résultats seront affichés ici -->
                            </tbody>
                        </table>
                        <div class="ribbon">Prime Totale</div>

                        <table class="table">
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="2" class="text-end fw-bold">Montant Total :</td>
                                    <td id="primeTotal" class="fw-bold">0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <a href="{{ route('prod.create',$product->CodeProduit) }}" id="btn-souscription" class="btn btn-primary btn btn-inactif">Souscrire</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dateNaissanceInput = document.getElementById("dateNaissance");
        const ageInput = document.getElementById("age");
        const optionalGarantiesDiv = document.getElementById("optionalGaranties");
        const garanties = @json($productGarantie);
        
        // Charger les garanties optionnelles
        function loadOptionalGaranties() {
            optionalGarantiesDiv.innerHTML = '<h5 class="mb-3">Garanties optionnelles</h5>';
            
            garanties.forEach(garantie => {
                if (garantie.estobligatoire === 0) {
                    const div = document.createElement('div');
                    div.className = 'optional-garantie';
                    
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.id = `garantie_${garantie.id}`;
                    checkbox.name = `garantie_${garantie.id}`;
                    checkbox.value = garantie.codeproduitgarantie;
                    checkbox.className = 'form-check-input me-2 garantie-option';
                    
                    const label = document.createElement('label');
                    label.htmlFor = `garantie_${garantie.id}`;
                    label.textContent = garantie.libelle;
                    label.className = 'form-check-label';
                    
                    const container = document.createElement('div');
                    container.className = 'form-check mb-2';
                    container.appendChild(checkbox);
                    container.appendChild(label);
                    
                    div.appendChild(container);
                    
                    // Ajouter des champs supplémentaires pour SUR
                    if (garantie.codeproduitgarantie === 'SUR') {
                        const surContainer = document.createElement('div');
                        surContainer.id = `sur_fields_${garantie.id}`;
                        surContainer.className = 'mt-2';
                        surContainer.style.display = 'none';
                        
                        const capitalLabel = document.createElement('label');
                        capitalLabel.textContent = 'Capital souhaité :';
                        capitalLabel.className = 'form-label';
                        
                        const capitalSelect = document.createElement('select');
                        capitalSelect.className = 'form-select mb-2';
                        capitalSelect.name = `sur_capital_${garantie.id}`;
                        capitalSelect.id = `sur_capital_${garantie.id}`;
                        
                        const options = [
                            {value: '50000', text: '50 000'},
                            {value: '100000', text: '100 000'},
                            {value: '150000', text: '150 000'},
                            {value: '200000', text: '200 000'}
                        ];
                        
                        options.forEach(opt => {
                            const option = document.createElement('option');
                            option.value = opt.value;
                            option.textContent = opt.text;
                            capitalSelect.appendChild(option);
                        });
                        
                        const dateLabel = document.createElement('label');
                        dateLabel.textContent = 'Date de naissance :';
                        dateLabel.className = 'form-label';
                        
                        const dateInput = document.createElement('input');
                        dateInput.type = 'date';
                        dateInput.className = 'form-control';
                        dateInput.name = `sur_date_naissance_${garantie.id}`;
                        dateInput.id = `sur_date_naissance_${garantie.id}`;
                        
                        surContainer.appendChild(capitalLabel);
                        surContainer.appendChild(capitalSelect);
                        surContainer.appendChild(dateLabel);
                        surContainer.appendChild(dateInput);
                        
                        div.appendChild(surContainer);
                        
                        // Afficher/masquer les champs SUR quand la checkbox est cochée
                        checkbox.addEventListener('change', function() {
                            surContainer.style.display = this.checked ? 'block' : 'none';
                        });
                    }
                    
                    optionalGarantiesDiv.appendChild(div);
                }
            });
        }
        
        // Calculer l'âge à partir de la date de naissance
        dateNaissanceInput.addEventListener("change", function () {
            const dateNaissance = new Date(this.value);
            const today = new Date();

            let age = today.getFullYear() - dateNaissance.getFullYear();
            const m = today.getMonth() - dateNaissance.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < dateNaissance.getDate())) {
                age--;
            }

            ageInput.value = age;
        });
        
        // Soumission du formulaire
        document.getElementById("primeForm").addEventListener("submit", function (e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const capitalSouscrit = parseFloat(formData.get('capitalSouscrit'));
            const codePeriodicite = formData.get('codePeriodicite');
            const age = parseInt(formData.get('age'));
            
            // Vérifier l'âge pour chaque garantie
            let ageValid = true;
            garanties.forEach(garantie => {
                if (age < garantie.agemin || age > garantie.agemax) {
                    ageValid = false;
                }
            });
            
            if (!ageValid) {
                alert("L'âge doit être compris entre les limites spécifiées pour les garanties.");
                return;
            }
            
            let totalPrime = 0;

            let resultDiv = document.getElementById("result");
            resultDiv.innerHTML = "";
            
            // Traiter les garanties obligatoires
            garanties.forEach(garantie => {
                if (garantie.estobligatoire === 1) {
                    let prime = 0;
                    let capital = 0;
                    
                    switch(garantie.codeproduitgarantie) {
                        case 'LIB':
                            prime = capitalSouscrit * 0.5;
                            capital = 0;
                            break;
                        case 'DIG':
                            prime = capitalSouscrit * 0.5;
                            capital = 0;
                            break;
                        case 'DECESACC':
                            prime = capitalSouscrit * 0.095;
                            capital = capitalSouscrit;
                            break;
                        default:
                            prime = 0;
                            capital = 0;
                    }
                    
                    totalPrime += prime;
                    
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${garantie.libelle}</td>
                        <td>${prime.toLocaleString('fr-FR')}</td>
                        <td>${capital.toLocaleString('fr-FR')}</td>
                    `;
                    resultDiv.appendChild(row);
                }
            });
            
            // Traiter les garanties optionnelles cochées
            document.querySelectorAll('.garantie-option:checked').forEach(checkbox => {
                const garantieCode = checkbox.value;
                const garantie = garanties.find(g => g.codeproduitgarantie === garantieCode);
                
                if (garantie) {
                    let prime = 0;
                    let capital = 0;
                    
                    switch(garantieCode) {
                        case 'SUR':
                            const surCapital = parseFloat(document.getElementById(`sur_capital_${garantie.id}`).value);
                            prime = surCapital * 0.1; // Exemple de calcul, à adapter
                            capital = surCapital;
                            break;
                        // Ajouter d'autres cas pour les garanties optionnelles si nécessaire
                        default:
                            prime = capitalSouscrit * 0.05; // Valeur par défaut
                            capital = capitalSouscrit;
                    }
                    
                    totalPrime += prime;
                    
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${garantie.libelle} (option)</td>
                        <td>${prime.toLocaleString('fr-FR')}</td>
                        <td>${capital.toLocaleString('fr-FR')}</td>
                    `;
                    resultDiv.appendChild(row);
                }
            });
            
            // Mettre à jour le total
            document.getElementById('primeTotal').textContent = totalPrime.toLocaleString('fr-FR');
            
            // Activer le bouton de souscription
            document.getElementById('btn-souscription').classList.remove('btn-inactif');
        });
        
        // Charger les garanties optionnelles au démarrage
        loadOptionalGaranties();
    });
</script>


@endsection
