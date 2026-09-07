<div class="row g-3">
    <div class="card-footer text-end">
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addBenefModal">
            <i class="fadeIn animated bx bx-plus"></i> Ajouter un autre bénéficiaire
        </button>
    </div>
    
    @if ($product->CodeProduit === "LPENSION")
    <div class="col-12 col-lg-6">
        <label for="" class="form-label">Au terme du contrat</label>
        <div class="card" style="width: 80%">
            <div class="card-body">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="benef_terme" id="benef_terme_adherent" value="adherent" required>
                    <label class="form-check-label" for="benef_terme_adherent">Adhérent</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="benef_terme" id="benef_terme_conjoint" value="conjoint" required>
                    <label class="form-check-label" for="benef_terme_conjoint">Conjoint</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="benef_terme" id="benef_terme_enfants" value="enfants" required>
                    <label class="form-check-label" for="benef_terme_enfants">Enfants</label>
                </div>
                {{-- <div class="form-check">
                    <input class="form-check-input" type="radio" name="benef_terme" id="benef_terme_autre" value="autre">
                    <label class="form-check-label" for="benef_terme_autre">Autre</label>
                </div> --}}
            </div>
        </div>
    </div>
    @endif
    
    <div class="col-12 col-lg-6">
        <label class="form-label">Au décès</label>
        <div class="card p-3">
            <div class="card-body">
                <div class="form-check mb-2">
                    <input class="form-check-input" name="benef_audeces" type="checkbox" value="Conjoint non divorcé, ni séparé de corps" id="conjointCheckbox">
                    <label class="form-check-label" for="conjointCheckbox">
                        Le conjoint non divorcé, ni séparé de corps
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="benef_audeces" type="checkbox" value="Enfants nés et à naitre" id="enfantsCheckbox">
                    <label class="form-check-label" for="enfantsCheckbox">
                        Les enfants nés et à naître
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="card">
        <div class="card-body overflow-auto overflow-scroll">
            <table class="table mb-0 table-striped" id="beneficiariesTable">
                <thead>
                    <tr>
                        <th scope="col">Nom & Prénoms</th>
                        <th scope="col">Né(e) le</th>
                        <th scope="col">Lieu de naissance</th>
                        <th scope="col">Lieu de residence</th>
                        <th scope="col">Filiation</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Beneficiary rows will be appended here -->
                </tbody>
            </table>
        </div>
    </div>
    @include('sites.pages.add.addBenefModal')
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const conjointCheckbox = document.getElementById('conjointCheckbox');
    const enfantsCheckbox = document.getElementById('enfantsCheckbox');
    const beneficiariesTable = document.querySelector('#beneficiariesTable tbody');
    
    // Récupérer les radios pour le terme du contrat (si existent)
    const benefTermeRadios = document.querySelectorAll('input[name="benef_terme"]');

    // Fonction pour récupérer les données du souscripteur
    function getAdherentData() {
        const souscription = JSON.parse(sessionStorage.getItem('souscriptionData')) || {};
        return souscription.adherentData || {};
    }

    // Met à jour benefData dans sessionStorage
    function updateBenefDataInSouscription(beneficiaires) {
        let souscription = JSON.parse(sessionStorage.getItem('souscriptionData')) || {};
        souscription.benefData = beneficiaires;
        sessionStorage.setItem('souscriptionData', JSON.stringify(souscription));
    }

    // Ajoute une ligne dans le tableau
    function addBeneficiaireRow(nom, prenom, lien, id, type = 'deces', datenaissance = '-', lieunaissance = '-', lieuresidence = '-', mobile = '-', email = '-') {
        const existingRow = beneficiariesTable.querySelector(`tr[data-id="${id}"]`);
        if (existingRow) return;

        const typeLabel = type === 'terme' ? 'Terme' : 'Décès';

        const newRow = `
            <tr data-id="${id}" data-type="${type}">
                <td>${nom} ${prenom}</td>
                <td>${datenaissance || '-'}</td>
                <td>${lieunaissance || '-'}</td>
                <td>${lieuresidence || '-'}</td>
                <td>${lien || '--'}</td>
                <td>${mobile || '-'}</td>
                <td>${email || '-'}</td>
                <td><span class="badge ${type === 'terme' ? 'bg-primary' : 'bg-secondary'}">${typeLabel}</span></td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="removeBeneficiaireAuto('${id}')">Supprimer</button>
                </td>
            </tr>
        `;
        beneficiariesTable.insertAdjacentHTML('beforeend', newRow);
    }

    // Supprime une ligne du tableau
    function removeBeneficiaireRow(id) {
        const row = beneficiariesTable.querySelector(`tr[data-id="${id}"]`);
        if (row) row.remove();
    }

    // Supprime un bénéficiaire automatiquement
    window.removeBeneficiaireAuto = function (id) {
        const souscription = JSON.parse(sessionStorage.getItem('souscriptionData')) || {};
        let data = souscription.benefData || [];

        data = data.filter(item => item.id !== id);
        updateBenefDataInSouscription(data);
        removeBeneficiaireRow(id);

        // Décocher/désélectionner les éléments liés
        if (id === 'conjoint') conjointCheckbox.checked = false;
        if (id === 'enfants') enfantsCheckbox.checked = false;
        
        // Désélectionner les radios pour le terme
        if (id === 'terme_adherent') {
            const radio = document.getElementById('benef_terme_adherent');
            if (radio) radio.checked = false;
        }
        if (id === 'terme_conjoint') {
            const radio = document.getElementById('benef_terme_conjoint');
            if (radio) radio.checked = false;
        }
        if (id === 'terme_enfants') {
            const radio = document.getElementById('benef_terme_enfants');
            if (radio) radio.checked = false;
        }
        if (id === 'terme_autre') {
            const radio = document.getElementById('benef_terme_autre');
            if (radio) radio.checked = false;
        }
    }

    // Gère l'ajout ou la suppression d'un bénéficiaire automatique (décès)
    function toggleBeneficiaire(checkbox, id) {
        checkbox.addEventListener('change', function () {
            let souscription = JSON.parse(sessionStorage.getItem('souscriptionData')) || {};
            let data = souscription.benefData || [];

            if (this.checked) {
                const exists = data.some(item => item.id === id);
                if (!exists) {
                    let benef = {
                        id: id,
                        nom: '',
                        prenom: '',
                        datenaissance: '',
                        lieunaissance: '',
                        lieuresidence: '',
                        lien: '',
                        mobile: '',
                        email: '',
                        part: '',
                        type: 'deces'
                    };

                    if (id === 'conjoint') {
                        benef.nom = 'Conjoint';
                        benef.prenom = 'Non divorcé, ni séparé de corps';
                        benef.lien = 'Conjoint';
                    }
                    if (id === 'enfants') {
                        benef.nom = 'Enfants';
                        benef.prenom = 'nés et à naître';
                        benef.lien = 'Enfant';
                    }

                    data.push(benef);
                    updateBenefDataInSouscription(data);
                    addBeneficiaireRow(benef.nom, benef.prenom, benef.lien, id, 'deces');
                }
            } else {
                data = data.filter(item => item.id !== id);
                updateBenefDataInSouscription(data);
                removeBeneficiaireRow(id);
            }
        });
    }

    // Gère la sélection des radios pour le terme du contrat
    function handleTermeRadio(radio, id, label, lien) {
        radio.addEventListener('change', function () {
            if (this.checked) {
                let souscription = JSON.parse(sessionStorage.getItem('souscriptionData')) || {};
                let data = souscription.benefData || [];

                // Supprimer tous les bénéficiaires de type 'terme' (un seul à la fois)
                data = data.filter(item => item.type !== 'terme');
                
                // Supprimer les lignes existantes de type 'terme'
                const termeRows = beneficiariesTable.querySelectorAll('tr[data-type="terme"]');
                termeRows.forEach(row => row.remove());

                let benef = {
                    id: id,
                    nom: label,
                    prenom: '',
                    datenaissance: '',
                    lieunaissance: '',
                    lieuresidence: '',
                    lien: lien || label,
                    mobile: '',
                    email: '',
                    part: '',
                    type: 'terme'
                };

                // Si c'est l'adhérent, récupérer ses informations depuis adherentData
                if (id === 'terme_adherent') {
                    const adherentData = getAdherentData();
                    benef.nom = adherentData.nom || label;
                    benef.prenom = adherentData.prenom || '';
                    benef.datenaissance = adherentData.datenaissance || '';
                    benef.lieunaissance = adherentData.lieunaissance || '';
                    benef.lieuresidence = adherentData.lieuresidence || '';
                    benef.mobile = adherentData.mobile || '';
                    benef.email = adherentData.email || '';
                    benef.lien = 'Adhérent';
                }

                data.push(benef);
                updateBenefDataInSouscription(data);
                addBeneficiaireRow(
                    benef.nom, 
                    benef.prenom, 
                    benef.lien, 
                    id, 
                    'terme',
                    benef.datenaissance,
                    benef.lieunaissance,
                    benef.lieuresidence,
                    benef.mobile,
                    benef.email
                );
            }
        });
    }

    // Appliquer les gestionnaires sur les checkboxes décès
    toggleBeneficiaire(conjointCheckbox, 'conjoint');
    toggleBeneficiaire(enfantsCheckbox, 'enfants');

    // Appliquer les gestionnaires sur les radios terme
    if (benefTermeRadios.length > 0) {
        const termeOptions = [
            { id: 'benef_terme_adherent', label: 'Adhérent', lien: 'Adhérent' },
            { id: 'benef_terme_conjoint', label: 'Conjoint', lien: 'Conjoint' },
            { id: 'benef_terme_enfants', label: 'Enfants', lien: 'Enfant' },
            { id: 'benef_terme_autre', label: 'Autre', lien: 'Autre' }
        ];

        termeOptions.forEach(option => {
            const radio = document.getElementById(option.id);
            if (radio) {
                handleTermeRadio(radio, 'terme_' + option.id.replace('benef_terme_', ''), option.label, option.lien);
            }
        });
    }

    // Recharge les bénéficiaires depuis la session
    function reloadBeneficiairesTable() {
        const souscription = JSON.parse(sessionStorage.getItem('souscriptionData')) || {};
        const benefs = souscription.benefData || [];

        beneficiariesTable.innerHTML = '';

        benefs.forEach(item => {
            // Restaurer l'état des checkboxes décès
            if (item.type === 'deces') {
                const checkbox = document.getElementById(item.id + 'Checkbox');
                if (checkbox) checkbox.checked = true;
            }
            
            // Restaurer l'état des radios terme
            if (item.type === 'terme') {
                let radioId = '';
                if (item.id === 'terme_adherent') {
                    radioId = 'benef_terme_adherent';
                } else if (item.id === 'terme_conjoint') {
                    radioId = 'benef_terme_conjoint';
                } else if (item.id === 'terme_enfants') {
                    radioId = 'benef_terme_enfants';
                } else if (item.id === 'terme_autre') {
                    radioId = 'benef_terme_autre';
                }
                const radio = document.getElementById(radioId);
                if (radio) radio.checked = true;
            }
            
            addBeneficiaireRow(
                item.nom, 
                item.prenom, 
                item.lien, 
                item.id, 
                item.type,
                item.datenaissance,
                item.lieunaissance,
                item.lieuresidence,
                item.mobile,
                item.email
            );
        });
    }

    // Initialiser tableau à l'ouverture
    reloadBeneficiairesTable();

    // Ajouter bénéficiaire via modal
    window.addBeneficiary = function () {
        const nom = document.getElementById('nomBenef').value.trim();
        const prenom = document.getElementById('prenomBenef').value.trim();
        const datenaissance = document.getElementById('datenaissanceBenef').value;
        const lieunaissance = document.getElementById('lieunaissance').value;
        const lieuresidence = document.getElementById('lieuresidence').value;
        const lien = document.getElementById('lienParente').value;
        const mobile = document.getElementById('mobileBenef').value.trim();
        const email = document.getElementById('emailBenef').value.trim();
        // Récupérer le type sélectionné (terme ou décès)
        const typeSelect = document.getElementById('typeBenef');
        const type = typeSelect ? typeSelect.value : 'deces';

        if (!nom || !prenom || !mobile) {
            alert('Veuillez renseigner au moins le nom, prénom et téléphone.');
            return;
        }

        const newBenef = {
            id: Date.now().toString(), // id unique
            nom,
            prenom,
            datenaissance: datenaissance || '',
            lieunaissance: lieunaissance || '',
            lieuresidence: lieuresidence || '',
            lien: lien || '',
            mobile,
            email: email || '',
            type: type
        };

        // Récupérer la session et la mettre à jour
        let souscription = JSON.parse(sessionStorage.getItem('souscriptionData')) || {};
        let benefs = souscription.benefData || [];
        
        // Si c'est un bénéficiaire de type 'terme', supprimer l'ancien
        if (type === 'terme') {
            benefs = benefs.filter(item => item.type !== 'terme');
            // Supprimer les lignes existantes de type 'terme'
            const termeRows = beneficiariesTable.querySelectorAll('tr[data-type="terme"]');
            termeRows.forEach(row => row.remove());
            
            // Désélectionner les radios
            benefTermeRadios.forEach(radio => radio.checked = false);
        }
        
        benefs.push(newBenef);
        souscription.benefData = benefs;
        sessionStorage.setItem('souscriptionData', JSON.stringify(souscription));

        // Mise à jour du tableau
        addBeneficiaireRow(
            newBenef.nom, 
            newBenef.prenom, 
            newBenef.lien, 
            newBenef.id, 
            newBenef.type,
            newBenef.datenaissance,
            newBenef.lieunaissance,
            newBenef.lieuresidence,
            newBenef.mobile,
            newBenef.email
        );

        // Réinitialise le formulaire
        document.getElementById('beneficiaryForm').reset();

        // Fermer le modal
        const modalElement = document.getElementById('addBenefModal');
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
            modal.hide();
        }
    };
});
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {

    const step3 = document.querySelector('.step[data-step="3"]');

    if (!step3) {
        console.warn("⚠️ Étape 3 introuvable");
        return;
    }

    const observer = new MutationObserver(function () {

        if (step3.classList.contains('active')) {

            const s = getSouscriptionData();
            console.log("📌 Données de la souscription depuis etape 3:", s);

            console.log("🚀🚀🚀 ÉTAPE 3 ACTIVÉE 🚀🚀🚀");

        }

    });

    observer.observe(step3, {
        attributes: true,
        attributeFilter: ['class']
    });

});
</script>