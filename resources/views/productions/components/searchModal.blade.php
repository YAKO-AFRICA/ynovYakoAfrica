<div class="modal fade" id="RechercherClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <style>
                .spinner {
                    display: inline-block;
                    width: 1rem;
                    height: 1rem;
                    border: 0.2em solid currentColor;
                    border-right-color: transparent;
                    border-radius: 50%;
                    animation: spin 0.75s linear infinite;
                }
                @keyframes spin {
                    to { transform: rotate(360deg); }
                }
                .client-card {
                    border-left: 4px solid #0d6efd;
                    transition: all 0.3s ease;
                }
                .client-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                }
            </style>
            <div class="modal-header">
                <h5 class="modal-title">Rechercher un adhérent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="searchAdherentForm">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Rechercher par :</label>
                                <select class="form-select" id="methodeRecherche" required>
                                    <option value="">Sélectionnez une option</option>
                                    <option value="numerocompte">Numéro de compte</option>
                                    <option value="numPiece">Numéro de pièce</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <input type="text" class="form-control" id="queryInput"
                                       placeholder="Sélectionnez d'abord une méthode" required>
                                <div class="form-text">Format attendu selon la méthode choisie</div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" id="searchBtn" class="btn btn-primary">
                                    <span id="searchText">Rechercher</span>
                                    <span id="searchSpinner" class="spinner d-none"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div id="searchResults" class="mt-3 d-none">
                    <div class="alert alert-danger d-none" id="errorMessage"></div>
                    <div id="clientDetails"></div>
                    <button id="useClientBtn" class="btn btn-success w-100 mt-3 d-none">
                        Utiliser ces informations
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1100;
        max-width: 350px;
    }

    .toast {
        position: relative;
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 0.25rem;
        color: white;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .toast.show {
        opacity: 1;
        transform: translateX(0);
    }

    .toast-success {
        background-color: #28a745;
    }

    .toast-error {
        background-color: #dc3545;
    }

    .toast-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .toast-info {
        background-color: #17a2b8;
    }

    .toast-close {
        background: none;
        border: none;
        color: inherit;
        font-size: 1.5rem;
        cursor: pointer;
        margin-left: 1rem;
        line-height: 1;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('RechercherClientModal');
        const methodSelect = document.getElementById('methodeRecherche');
        const queryInput = document.getElementById('queryInput');
        const searchBtn = document.getElementById('searchBtn');
        const searchResults = document.getElementById('searchResults');
        const errorMessage = document.getElementById('errorMessage');
        const clientDetails = document.getElementById('clientDetails');
        const useClientBtn = document.getElementById('useClientBtn');
        const searchText = document.getElementById('searchText');
        const searchSpinner = document.getElementById('searchSpinner');

        // Gestionnaire d'événements pour la sélection de méthode
        methodSelect.addEventListener('change', function() {
            const method = this.value;
            queryInput.disabled = !method;
            
            if (method === 'numerocompte') {
                queryInput.placeholder = 'Entrez le numéro de compte (ex: C123456789)';
                queryInput.nextElementSibling.textContent = 'Format: C suivi de 9 chiffres';
            } else if (method === 'numPiece') {
                queryInput.placeholder = 'Entrez le numéro de pièce';
                queryInput.nextElementSibling.textContent = 'Format: 123456789012';
            } else {
                queryInput.placeholder = 'Sélectionnez d\'abord une méthode';
                queryInput.nextElementSibling.textContent = '';
            }
        });

        // Gestionnaire de recherche
        searchBtn.addEventListener('click', async function() {
            const method = methodSelect.value;
            const query = queryInput.value.trim();
            if (!method || !query) {
                showError('Veuillez sélectionner une méthode et entrer une valeur');
                return;
            }

            toggleSearchLoading(true);
            
            try {
                const clientData = await searchClient(method, query);
                
                if (clientData) {
                    displayClientDetails(clientData);
                    sessionStorage.setItem('currentClient', JSON.stringify(clientData));
                    useClientBtn.classList.remove('d-none');
                    errorMessage.classList.add('d-none');
                    searchResults.classList.remove('d-none');
                    showToast('Client trouvé avec succès', 'success');
                } else {
                    showError('Aucun client trouvé avec ces informations');
                    showToast('Aucun client trouvé', 'error');
                }
            } catch (error) {
                console.error('Erreur recherche:', error);
                showError(error.message || 'Erreur lors de la recherche');
                showToast('Erreur lors de la recherche', 'error');
            } finally {
                toggleSearchLoading(false);
            }
        });

        // Remplissage du formulaire principal
        useClientBtn.addEventListener('click', function() {
            const clientJson = sessionStorage.getItem('currentClient');
            if (clientJson) {
                const client = JSON.parse(clientJson);
                fillMainForm(client);

                const modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.hide();
                
                showToast('Informations client chargées avec succès', 'success');
            } else {
                showToast('Aucune donnée client disponible', 'error');
            }
        });
        

        function toggleSearchLoading(isLoading) {
            if (isLoading) {
                searchText.classList.add('d-none');
                searchSpinner.classList.remove('d-none');
                searchBtn.disabled = true;
            } else {
                searchText.classList.remove('d-none');
                searchSpinner.classList.add('d-none');
                searchBtn.disabled = false;
            }
        }

        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.classList.remove('d-none');
            clientDetails.innerHTML = '';
            useClientBtn.classList.add('d-none');
            searchResults.classList.remove('d-none');
        }

        function displayClientDetails(client) {
            clientDetails.innerHTML = `
                <div class="card client-card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">${getCivilite(client.CodeCivilite)} ${client.Nom} ${client.Prenom}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Date naissance:</strong> ${formatDate(client.DateNaissance)}</p>
                                <p><strong>Lieu naissance:</strong> ${client.LieuNaissance || 'Non renseigné'}</p>
                                <p><strong>Profession:</strong> ${client.Profession || 'Non renseigné'}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Pièce:</strong> ${client.PieceType} ${client.NumPiece}</p>
                                <p><strong>Compte:</strong> ${client.NumCompte || 'Non renseigné'}</p>
                                <p><strong>Résidence:</strong> ${client.LieuResidence || 'Non renseigné'}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function getCivilite(code) {
            const civilites = {
                '1': 'Monsieur',
                '2': 'Madame',
                '3': 'Mademoiselle'
            };
            return civilites[code] || '';
        }

        function formatDate(dateString) {
            if (!dateString) return 'Non renseigné';
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR');
        }

        // Fonction de toast
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer') || createToastContainer();
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            
            toast.innerHTML = `
                <span>${message}</span>
                <button class="toast-close" aria-label="Fermer">&times;</button>
            `;

            container.appendChild(toast);

            // Animation d'apparition
            setTimeout(() => toast.classList.add('show'), 10);

            const autoClose = setTimeout(() => closeToast(toast), 5000);

            toast.querySelector('.toast-close').addEventListener('click', () => {
                clearTimeout(autoClose);
                closeToast(toast);
            });

            function closeToast(toastElement) {
                toastElement.classList.remove('show');
                setTimeout(() => {
                    toastElement.remove();
                    if (container.children.length === 0) {
                        container.remove();
                    }
                }, 300);
            }
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container';
            document.body.appendChild(container);
            return container;
        }

        async function searchClient(method, query) {
            const params = {
                [method === 'numerocompte' ? 'numerocompte' : 'numPiece']: query
            };

            const response = await fetch('https://api.yakoafricassur.com/enov/search-personne-web', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MjExODcyLCJlbWFpbCI6ImZvcm1hdGlvbi5ibmlAYm5pLmNvbSIsIm5vbSI6IkJOSSIsImNvZGVhZ2VudCI6IkIwNDAiLCJ0eXBlbWVicmUiOm51bGwsInByZW5vbSI6IkZvcm1hdGlvbiJ9.gwxwy43VeMDcfaTpgpFbuWkxjirIBqvuXq3UZOuw_nA'
                },
                body: JSON.stringify(params)
            });

            if (!response.ok) {
                throw new Error(`Erreur API: ${response.status}`);
            }

            const data = await response.json();
            
            if (data.error || !data.dataPersonne || data.dataPersonne.length === 0) {
                return null;
            }

            // Retourne le premier client trouvé
            return data.dataPersonne[0];
        }

        function fillMainForm(client) {
        try {
            // Civilité
            const civilite = getCivilite(client.CodeCivilite);
            setRadioValue('civilite', civilite);
            
            // Informations de base
            setInputValue('nom', client.Nom);
            setInputValue('prenom', client.Prenom);
            setInputValue('datenaissance', client.DateNaissance?.split(' ')[0]);
            
            // Lieux
            setSelectValue('lieunaissance', client.LieuNaissance);
            setSelectValue('lieuresidence', client.LieuResidence);
            
            // Pièce d'identité
            setRadioValue('naturepiece', client.PieceType || 'CNI');
            setInputValue('numeropiece', client.NumPiece);
            
            // Profession
            setSelectValue('profession', client.Profession);
            
            // Contacts
            setInputValue('mobile', '');
            
            // Déclencher les événements change pour les sélecteurs
            triggerChangeEvent('lieunaissance');
            triggerChangeEvent('lieuresidence');
            triggerChangeEvent('profession');
            
            showToast('Formulaire rempli avec succès', 'success');
        } catch (error) {
            console.error('Erreur remplissage formulaire:', error);
            showToast('Erreur lors du remplissage', 'error');
        }
    }

    // Helpers génériques
    function setInputValue(name, value) {
        const element = document.querySelector(`input[name="${name}"]`);
        if (element && value) element.value = value;
    }

    function setRadioValue(name, value) {
        const element = document.querySelector(`input[name="${name}"][value="${value}"]`);
        if (element) element.checked = true;
    }

    function setSelectValue(name, value) {
        if (!value) return;
        
        const select = document.querySelector(`select[name="${name}"]`);
        const option = findSelectOption(select, value);
        if (option) option.selected = true;
    }

    function findSelectOption(select, searchText) {
        if (!select || !searchText) return null;
        const searchLower = searchText.trim().toLowerCase();
        return Array.from(select.options).find(
            opt => opt.text.trim().toLowerCase() === searchLower
        );
    }

    function triggerChangeEvent(name) {
        const element = document.querySelector(`[name="${name}"]`);
        if (element) {
            element.dispatchEvent(new Event('change'));
        }
    }

        // Initialisation au chargement du modal
        modal.addEventListener('shown.bs.modal', function() {
            methodSelect.dispatchEvent(new Event('change'));
        });
    });
</script>