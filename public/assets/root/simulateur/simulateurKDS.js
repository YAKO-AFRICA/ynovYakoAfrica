document.addEventListener("DOMContentLoaded", function () {
    const dateNaissanceInput = document.getElementById("dateNaissance");
    const ageInput = document.getElementById("age");
    const capitalSouscritInput = document.getElementById("capitalSouscrit");
    const codePeriodiciteInput = document.getElementById("codePeriodicite");
    const optionalGarantiesDiv = document.getElementById("optionalGaranties");
    const dureeInput = document.getElementById("duree");
    const resetBtn = document.getElementById('resetBtn');
    let resultDiv = document.getElementById("result");
    
    const authToken = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MjExODcyLCJlbWFpbCI6ImZvcm1hdGlvbi5ibmlAYm5pLmNvbSIsIm5vbSI6IkJOSSIsImNvZGVhZ2VudCI6IkIwNDAiLCJ0eXBlbWVicmUiOm51bGwsInByZW5vbSI6IkZvcm1hdGlvbiJ9.gwxwy43VeMDcfaTpgpFbuWkxjirIBqvuXq3UZOuw_nA";
    
    // Variables pour stocker les données de l'API
    let currentCodeGroupe = null;
    let currentCodeTable = null;
    let ageOptions = [];
    let debounceTimer;
    
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
                checkbox.dataset.garantieId = garantie.id;
                
                // Ajouter un événement pour le changement d'état
                checkbox.addEventListener('change', function() {
                    triggerAutoUpdate();
                });
                
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
                    
                    // Capital
                    const capitalLabel = document.createElement('label');
                    capitalLabel.textContent = 'Capital souhaité :';
                    capitalLabel.className = 'form-label';
                    
                    const capitalSelect = document.createElement('select');
                    capitalSelect.className = 'form-select mb-2 sur-capital';
                    capitalSelect.name = `sur_capital_${garantie.id}`;
                    capitalSelect.id = `sur_capital_${garantie.id}`;
                    
                    const capitalOptions = [
                        {value: '500000', text: '500 000'},
                        {value: '1000000', text: '1 000 000'},
                        {value: '1500000', text: '1 500 000'},
                        {value: '2000000', text: '2 000 000'},
                        {value: '2500000', text: '2 500 000'},
                        {value: '3000000', text: '3 000 000'},
                        {value: '3500000', text: '3 500 000'},
                        {value: '4000000', text: '4 000 000'},
                        {value: '4500000', text: '4 500 000'},
                        {value: '5000000', text: '5 000 000'},
                    ];
                    
                    capitalOptions.forEach(opt => {
                        const option = document.createElement('option');
                        option.value = opt.value;
                        option.textContent = opt.text;
                        capitalSelect.appendChild(option);
                    });
                    
                    // Ajouter un événement pour le changement de capital
                    capitalSelect.addEventListener('change', function() {
                        triggerAutoUpdate();
                    });
                    
                    // Tranche d'âge
                    const ageLabel = document.createElement('label');
                    ageLabel.textContent = 'Tranche d\'âge :';
                    ageLabel.className = 'form-label';
                    
                    const ageSelect = document.createElement('select');
                    ageSelect.className = 'form-select mb-2 sur-age';
                    ageSelect.name = `sur_age_assure_${garantie.id}`;
                    ageSelect.id = `sur_age_assure_${garantie.id}`;
                    
                    const defaultAgeOption = document.createElement('option');
                    defaultAgeOption.value = '';
                    defaultAgeOption.textContent = '-- Sélectionnez une tranche d\'âge --';
                    defaultAgeOption.selected = true;
                    defaultAgeOption.disabled = true;
                    ageSelect.appendChild(defaultAgeOption);
                    
                    // Ajouter un événement pour le changement d'âge
                    ageSelect.addEventListener('change', function() {
                        triggerAutoUpdate();
                    });
                    
                    // Informations API
                    const apiInfoDiv = document.createElement('div');
                    apiInfoDiv.id = `api_info_${garantie.id}`;
                    apiInfoDiv.className = 'api-info mt-2';
                    apiInfoDiv.style.display = 'none';
                    
                    const codeTableLabel = document.createElement('p');
                    codeTableLabel.id = `code_table_${garantie.id}`;
                    
                    const codeGroupeLabel = document.createElement('p');
                    codeGroupeLabel.id = `code_groupe_${garantie.id}`;
                    
                    apiInfoDiv.appendChild(codeTableLabel);
                    apiInfoDiv.appendChild(codeGroupeLabel);
                    
                    // Assemblage des éléments
                    surContainer.appendChild(capitalLabel);
                    surContainer.appendChild(capitalSelect);
                    surContainer.appendChild(ageLabel);
                    surContainer.appendChild(ageSelect);
                    surContainer.appendChild(apiInfoDiv);
                    
                    div.appendChild(surContainer);
                    
                    // Gestion de l'événement change pour la checkbox
                    checkbox.addEventListener('change', function() {
                        surContainer.style.display = this.checked ? 'block' : 'none';
                        apiInfoDiv.style.display = this.checked ? 'block' : 'none';
                        
                        if (this.checked && currentCodeGroupe) {
                            loadAgeOptions(ageSelect, currentCodeGroupe);
                        }
                    });
                }
                
                optionalGarantiesDiv.appendChild(div);
            }
        });
    }
    
    // Fonction pour charger les options d'âge
    function loadAgeOptions(selectElement, codeGroupe) {
        // Afficher un indicateur de chargement
        selectElement.innerHTML = '';
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '-- Chargement en cours --';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        selectElement.appendChild(defaultOption);
        
        fetch("https://api.yakoafricassur.com/enov/get-age-prime-web", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": authToken
            },
            body: JSON.stringify({
                CodeGroupe: codeGroupe
            }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Erreur lors de la requête get-age-prime-web");
            }
            return response.json();
        })
        .then(dataAge => {
            selectElement.innerHTML = '';
            
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '-- Sélectionnez une tranche --';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            selectElement.appendChild(defaultOption);
            
            if (dataAge.error === false && dataAge.dataTableAge && dataAge.dataTableAge.length > 0) {
                ageOptions = dataAge.dataTableAge;
                
                dataAge.dataTableAge.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.AgeAssure;
                    option.textContent = item.Titre;
                    selectElement.appendChild(option);
                });
                
                // Déclencher une mise à jour après le chargement des options
                triggerAutoUpdate();
            } else {
                const errorOption = document.createElement('option');
                errorOption.textContent = 'Aucune tranche disponible';
                selectElement.appendChild(errorOption);
            }
        })
        .catch(error => {
            console.error("Erreur API get-age-prime-web :", error);
            selectElement.innerHTML = '';
            
            const errorOption = document.createElement('option');
            errorOption.textContent = 'Erreur de chargement';
            selectElement.appendChild(errorOption);
        });
    }
    
    // Fonction pour calculer la prime SURETÉ via API
    async function calculatePrimeForSurete(garantieId) {
        const capital = document.getElementById(`sur_capital_${garantieId}`).value;
        const ageAssure = document.getElementById(`sur_age_assure_${garantieId}`).value;
        const duree = dureeInput.value;
        
        if (!capital || !ageAssure || !duree || !currentCodeGroupe || !currentCodeTable) {
            console.log("Paramètres manquants pour le calcul SURETÉ");
            return 0;
        }
        
        const params = {
            CodeGroupe: currentCodeGroupe,
            AgeAssure: ageAssure,
            Capital: capital,
            codeTable: currentCodeTable,
            Duree: duree
        };
        console.log("Paramètres pour le calcul SURETÉ:", params);
        
        try {
            const response = await fetch("https://api.yakoafricassur.com/enov/get-prime-by-param-web", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": authToken
                },
                body: JSON.stringify(params)
            });
            
            if (!response.ok) {
                throw new Error("Erreur lors de la requête get-prime-by-param-web");
            }
            
            const data = await response.json();
            
            if (data.error === false && data.dataTablePrimeRes && data.dataTablePrimeRes.length > 0) {
                return parseFloat(data.dataTablePrimeRes[0].Prime) || 0;
            } else {
                console.log("Erreur dans la réponse API pour SURETÉ");
                return 0;
            }
        } catch (error) {
            console.error("Erreur API get-prime-by-param-web :", error);
            return 0;
        }
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
        triggerAutoUpdate();
    });
    
    // Gestion du changement de périodicité
    document.getElementById("codePeriodicite").addEventListener("change", function () {
        const codeProduit = document.getElementById("CodeProduit").value;
        const codePeriodicite = this.value;
        
        fetch("https://api.yakoafricassur.com/enov/get-table-prime-web", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": authToken
            },
            body: JSON.stringify({
                CodeProduit: codeProduit,
                CodePeriodicite: codePeriodicite
            }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Erreur lors de la requête get-table-prime-web");
            }
            return response.json();
        })
        .then(data => {
            if (data.error === false && data.dataTablePrime && data.dataTablePrime.length > 0) {
                currentCodeGroupe = data.dataTablePrime[0].CodeGRoupeIntervalle;
                currentCodeTable = data.dataTablePrime[0].codeTable;

                // Recharger les options d'âge pour les garanties SUR cochées
                document.querySelectorAll('.garantie-option:checked').forEach(checkbox => {
                    if (checkbox.value === 'SUR') {
                        const garantieId = checkbox.dataset.garantieId;
                        const ageSelect = document.getElementById(`sur_age_assure_${garantieId}`);
                        loadAgeOptions(ageSelect, currentCodeGroupe);
                    }
                });
                
                // Déclencher une mise à jour après avoir obtenu les nouvelles données
                triggerAutoUpdate();
            }
        })
        .catch(error => {
            console.error("Erreur API get-table-prime-web :", error);
        });
    });
    
    // Fonction pour déclencher la mise à jour automatique avec debounce
    function triggerAutoUpdate() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(updateSimulationResults, 500);
    }
    
    // Fonction principale pour mettre à jour les résultats de simulation
    async function updateSimulationResults() {
        const capitalSouscrit = parseFloat(capitalSouscritInput.value);
        const age = parseInt(ageInput.value);
        const duree = dureeInput.value;
        
        // Vérifier que tous les champs requis sont remplis
        if (!capitalSouscrit || isNaN(age) || !codePeriodiciteInput.value || !duree) {
            document.getElementById("result").innerHTML = `
                <tr>
                    <td colspan="3" class="text-center">Veuillez remplir tous les champs obligatoires</td>
                </tr>
            `;
            document.getElementById('primeTotal').textContent = '0';
            document.getElementById('btn-souscription').classList.add('btn-inactif');
            return;
        }
        
        // Vérifier l'âge pour chaque garantie
        let ageValid = true;
        garanties.forEach(garantie => {
            if (age < garantie.agemin || age > garantie.agemax) {
                ageValid = false;
            }
        });
        
        if (!ageValid) {
            document.getElementById("result").innerHTML = `
                <tr>
                    <td colspan="3" class="text-center text-danger">L'âge doit être compris entre les limites spécifiées pour les garanties</td>
                </tr>
            `;
            document.getElementById('primeTotal').textContent = '0';
            document.getElementById('btn-souscription').classList.add('btn-inactif');
            return;
        }
        
        let totalPrime = 0;
        let resultDiv = document.getElementById("result");
        resultDiv.innerHTML = "";

        let fraieadhesion = 0;
        
        // Objet pour stocker toutes les données de simulation
        const simulationData = {
            garantieData: [],
            primeFinale: 0,
            infoSimulation: {
                primepricipale: 0,
                periodicite: codePeriodiciteInput.value,
                capital: 0,
                datenaissance: dateNaissanceInput.value,
                age: age,
                fraisAdhesion: fraieadhesion,
                duree: duree,
            }
        };
        
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
                
                // Ajouter la garantie aux données de simulation
                simulationData.garantieData.push({
                    codeGarantie: garantie.codeproduitgarantie,
                    libelle: garantie.libelle,
                    prime: prime,
                    capital: capital,
                    obligatoire: true
                });
                
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
        const selectedOptions = document.querySelectorAll('.garantie-option:checked');
        
        for (const checkbox of selectedOptions) {
            const garantieCode = checkbox.value;
            const garantieId = checkbox.dataset.garantieId;
            const garantie = garanties.find(g => g.codeproduitgarantie === garantieCode);
            
            if (garantie) {
                let prime = 0;
                let capital = 0;
                let surDetails = null;
                
                switch(garantieCode) {
                    case 'SUR':
                        const surCapital = parseFloat(document.getElementById(`sur_capital_${garantieId}`).value);
                        const selectedAge = document.getElementById(`sur_age_assure_${garantieId}`).value;
                        
                        if (!selectedAge) {
                            continue;
                        }
                        
                        // Calculer la prime via API
                        prime = await calculatePrimeForSurete(garantieId);
                        capital = surCapital;
                        
                        // Stocker les détails spécifiques à SUR
                        surDetails = {
                            capitalSouhaite: surCapital,
                            ageAssure: selectedAge,
                            duree: duree
                        };
                        break;
                    case 'DECESACC':
                        prime = capitalSouscrit * 0.05;
                        capital = capitalSouscrit;
                        break;
                    default:
                        prime = capitalSouscrit * 0.05;
                        capital = capitalSouscrit;
                }
                
                totalPrime += prime;
                
                // Ajouter la garantie optionnelle aux données de simulation
                simulationData.garantieData.push({
                    codeGarantie: garantieCode,
                    libelle: garantie.libelle,
                    prime: prime,
                    capital: capital,
                    obligatoire: false,
                    surDetails: surDetails
                });
                
                simulationData.infoSimulation.capital += capital;
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${garantie.libelle} (option)</td>
                    <td>${prime.toLocaleString('fr-FR')}</td>
                    <td>${capital.toLocaleString('fr-FR')}</td>
                `;
                resultDiv.appendChild(row);
            }
        }
        
        // Mettre à jour la prime finale
        simulationData.primeFinale = totalPrime;
        simulationData.infoSimulation.primepricipale = totalPrime;
        
        // Stocker toutes les données en session
        saveToSession(simulationData);
        
        // Mettre à jour le total affiché
        document.getElementById('primeTotal').textContent = totalPrime.toLocaleString('fr-FR');
        
        // Activer le bouton de souscription si tout est valide
        if (totalPrime > 0) {
            document.getElementById('btn-souscription').classList.remove('btn-inactif');
        } else {
            document.getElementById('btn-souscription').classList.add('btn-inactif');
        }
    }
    
    // Fonction pour sauvegarder les données en session
    function saveToSession(simulationData) {
        sessionStorage.setItem('simulationData', JSON.stringify(simulationData));
        console.log('Données de simulation sauvegardées:', simulationData);
    }
    
    // Écouteurs d'événements pour les changements
    dateNaissanceInput.addEventListener("change", triggerAutoUpdate);
    capitalSouscritInput.addEventListener("change", triggerAutoUpdate);
    codePeriodiciteInput.addEventListener("change", triggerAutoUpdate);
    dureeInput.addEventListener("change", triggerAutoUpdate);
    
    // Charger les garanties optionnelles au démarrage
    loadOptionalGaranties();


    // function pour reiniatialisé le simulateur
    resetBtn.addEventListener('click', function() {

        dureeInput.value = '6';
        capitalSouscritInput.value = '';
        codePeriodiciteInput.value = '';
        dateNaissanceInput.value = '';
        resultDiv.innerHTML = "";
        const selectedOptions = document.querySelectorAll('.garantie-option:checked');
        selectedOptions.forEach(option => option.checked = false);
        
        sessionStorage.removeItem('simulateurData');
        sessionStorage.removeItem('simulationData');

    });
    
    // Déclencher le changement de périodicité au chargement pour initialiser les données
    document.getElementById("codePeriodicite").dispatchEvent(new Event('change'));
});