<div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
    <h5 class="mb-1">Informations de l'assuré(e)</h5>
    <p class="mb-4">Veuillez entrer les informations relatives à l'assuré(e) en tenant compte des champs obligatoires.
    </p>
    @php
        $GarantiesOptionnelles = $productGarantie->where('estobligatoire', 0)->all();
    @endphp
    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-6">
            <label for="" class="form-label">Le souscripteur est-il l'assuré ? <span
                    class="text-danger">*</span></label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estAssure" id="Oui" value="Oui" required>
                <label class="form-check-label" for="Oui">Oui</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estAssure" id="Non" value="Non">
                <label class="form-check-label" for="Non">Non</label>
            </div>
        </div>

        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">
            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#createPropositionModal">
                <i class="fadeIn animated bx bx-plus"></i>Ajouter un(e) autre assuré(e)
            </button>
        </div>
    </div>
    
    <div class="overflow-auto">
        <table class="table mb-0 table-striped table-bordered table-hover table-responsive">
            <thead>
                <tr>
                    <th scope="col">Assuré(e)</th>
                    <th scope="col">Garanties</th>
                    <th scope="col">Garanties complementaires</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="assures-tbody">
                <!-- Contenu dynamique -->
            </tbody>
            <tfoot>
                <tr id="conditional-tr" style="display: none;">
                    <td id="display-nom-prenom"></td>
                    <td>
                        <ul>
                            @foreach ($productGarantie->where('estobligatoire', 1) as $item)
                                <li>{{ $item->libelle }}</li>
                            @endforeach
                        </ul>
                    </td>
                    @if (!empty($GarantiesOptionnelles))
                        <td>
                            <ul>
                                @foreach ($GarantiesOptionnelles as $item)
                                    <li>
                                        <label class="form-label">
                                            Souhaitez-vous souscrire à la garantie {{ $item->libelle }} ?
                                        </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input garantie-optionnelle" type="radio"
                                                name="GarantiesOptionnelles[{{ $item->id }}]"
                                                id="OuiGarantiesOptionnelles{{ $item->id }}"
                                                data-gar-value="{{ $item->codeproduitgarantie }}"
                                                @if ($product->CodeProduit == 'CADENCE') checked readonly @endif
                                                value="Oui">
                                            <label class="form-check-label"
                                                for="OuiGarantiesOptionnelles{{ $item->id }}">Oui</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input garantie-optionnelle" type="radio"
                                                name="GarantiesOptionnelles[{{ $item->id }}]"
                                                id="NonGarantiesOptionnelles{{ $item->id }}"
                                                data-gar-value="{{ $item->codeproduitgarantie }}"
                                                value="Non">
                                            <label class="form-check-label"
                                                for="NonGarantiesOptionnelles{{ $item->id }}">Non</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    @else
                        <td>Pas de garantie complementaire</td>
                    @endif
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row g-3">
        <div class="d-flex align-items-center justify-content-between gap-3">
            <button onclick="event.preventDefault(); stepper1.previous()" class="btn border-btn btn-previous-form">
                <i class='bx bx-left-arrow-alt'></i>Précédent
            </button>
            <button onclick="event.preventDefault(); stepper1.next()" class="btn btn-two btn-next-form">
                Suivant<i class='bx bx-right-arrow-alt'></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal d'ajout/modification -->
<div class="modal fade" id="createPropositionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Ajouter un assuré</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assureForm">
                    <div class="row g-3">
                        <!-- Civilité -->
                        <div class="col-md-6">
                            <label class="form-label">Civilité <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input civiliteAssur" type="radio" name="civiliteAssur" value="M.">
                                <label class="form-check-label">M.</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input civiliteAssur" type="radio" name="civiliteAssur" value="Mme">
                                <label class="form-check-label">Mme</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input civiliteAssur" type="radio" name="civiliteAssur" value="Mlle">
                                <label class="form-check-label">Mlle</label>
                            </div>
                        </div>

                        <!-- Nom -->
                        <div class="col-md-6">
                            <label for="nomAssur" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nomAssur" placeholder="Entrez le nom">
                        </div>

                        <!-- Prénom -->
                        <div class="col-md-6">
                            <label for="prenomAssur" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prenomAssur" placeholder="Entrez le prénom">
                        </div>

                        <!-- Date de naissance -->
                        <div class="col-md-6">
                            <label for="datenaissanceAssur" class="form-label">Date de naissance <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="datenaissanceAssur">
                        </div>

                        <!-- Lieu de naissance -->
                        <div class="col-md-6">
                            <label for="lieunaissanceAssur" class="form-label">Lieu de naissance</label>
                            <input type="text" class="form-control" id="lieunaissanceAssur" placeholder="Entrez le lieu de naissance">
                        </div>

                        <!-- Nature de pièce -->
                        <div class="col-md-6">
                            <label class="form-label">Nature de pièce</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input naturepieceAssur" type="radio" name="naturepieceAssur" value="CNI">
                                <label class="form-check-label">CNI</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input naturepieceAssur" type="radio" name="naturepieceAssur" value="PASSEPORT">
                                <label class="form-check-label">Passeport</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input naturepieceAssur" type="radio" name="naturepieceAssur" value="PERMIS">
                                <label class="form-check-label">Permis</label>
                            </div>
                        </div>

                        <!-- Numéro de pièce -->
                        <div class="col-md-6">
                            <label for="numeropieceAssur" class="form-label">Numéro de pièce</label>
                            <input type="text" class="form-control" id="numeropieceAssur" placeholder="Entrez le numéro">
                        </div>

                        <!-- Lieu de résidence -->
                        <div class="col-md-6">
                            <label for="lieuresidenceAssur" class="form-label">Lieu de résidence</label>
                            <input type="text" class="form-control" id="lieuresidenceAssur" placeholder="Entrez le lieu de résidence">
                        </div>

                        <!-- Lien de parenté -->
                        <div class="col-md-6">
                            <label for="lienParente" class="form-label">Lien de parenté</label>
                            <select class="form-select" id="lienParente">
                                <option value="">Sélectionnez...</option>
                                <option value="CONJOINT">Conjoint</option>
                                <option value="ENFANT">Enfant</option>
                                <option value="PERE">Père</option>
                                <option value="MERE">Mère</option>
                                <option value="FRERE">Frère</option>
                                <option value="SOEUR">Sœur</option>
                                <option value="AUTRE">Autre</option>
                            </select>
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-6">
                            <label for="mobileAssur" class="form-label">Mobile</label>
                            <input type="tel" class="form-control" id="mobileAssur" placeholder="Entrez le numéro mobile">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="emailAssur" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailAssur" placeholder="Entrez l'email">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="btn-ajouter">Ajouter l'assuré</button>
            </div>
        </div>
    </div>
</div>

<!-- Champ caché pour stocker les données -->
<input type="hidden" id="assuresInput" name="assures" value="[]">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // 1. VARIABLES GLOBALES
    // ============================================
    let assures = [];
    let indexModification = null;

    // ============================================
    // 2. RÉCUPÉRATION DES DONNÉES DE SIMULATION
    // ============================================
    const sessionData = sessionStorage.getItem('simulationData');
    if (sessionData) {
        const simulationData = JSON.parse(sessionData);
        console.log('Données de simulation chargées:', simulationData);
        const info = simulationData.infoSimulation || {};

        // Gestion des boutons radio Oui/Non
        const radioOui = document.getElementById('Oui');
        const radioNon = document.getElementById('Non');
        const conditionalRow = document.getElementById('conditional-tr');

        if (radioOui && radioNon) {
            if (info.isAssure === 'oui') {
                radioOui.checked = true;
                radioOui.disabled = true;
                radioNon.disabled = true;
            } else if (info.isAssure === 'non') {
                radioNon.checked = true;
                radioOui.disabled = true;
                radioNon.disabled = true;
            }

            if (conditionalRow) {
                conditionalRow.style.display = (info.isAssure === 'oui') ? 'table-row' : 'none';
            }
        }

        // Gestion des garanties optionnelles
        const hasSenior = simulationData?.garantieData?.some(item => item.codeGarantie === 'SENIOR');
        const hasSurete = simulationData?.garantieData?.some(item => item.codeGarantie === 'SUR');
        const hasDeces = simulationData?.garantieData?.some(item => item.codeGarantie === 'DECESACC');

        document.querySelectorAll('.garantie-optionnelle').forEach(radio => {
            const garValue = radio.getAttribute('data-gar-value');
            let shouldCheck = false;

            if (garValue === 'SENIOR') shouldCheck = hasSenior;
            else if (garValue === 'SUR') shouldCheck = hasSurete;
            else if (garValue === 'DECESACC') shouldCheck = hasDeces;

            if (shouldCheck) {
                if (radio.value === 'Oui') radio.checked = true;
            } else {
                if (radio.value === 'Non') radio.checked = true;
            }

            radio.disabled = true;
            radio.parentElement.style.opacity = '0.7';
        });
    }

    // ============================================
    // 3. MISE À JOUR NOM/PRÉNOM
    // ============================================
    const firstNameInput = document.getElementById('FisrtName');
    const lastNameInput = document.getElementById('LastName');
    const displayNomPrenom = document.getElementById('display-nom-prenom');

    function updateDisplay() {
        const nom = firstNameInput?.value.trim() || '';
        const prenom = lastNameInput?.value.trim() || '';
        if (displayNomPrenom) {
            displayNomPrenom.textContent = (nom || prenom) ? `${nom} ${prenom}` : '';
        }
    }

    if (firstNameInput) firstNameInput.addEventListener('input', updateDisplay);
    if (lastNameInput) lastNameInput.addEventListener('input', updateDisplay);
    updateDisplay();

    // ============================================
    // 4. FONCTIONS UTILITAIRES
    // ============================================
    function getCiviliteSelectedValue(elements) {
        for (let element of elements) {
            if (element.checked) return element.value;
        }
        return '';
    }

    function getNaturePieceSelectedValue(elements) {
        for (let element of elements) {
            if (element.checked) return element.value;
        }
        return '';
    }

    function validateField(element, value) {
        if (!value) {
            element.classList.add('is-invalid');
            element.classList.remove('is-valid');
            return false;
        } else {
            element.classList.remove('is-invalid');
            element.classList.add('is-valid');
            return true;
        }
    }

    function validateFieldRadio(elements, value) {
        if (!value) {
            elements.forEach(el => el.classList.add('is-invalid'));
            return false;
        } else {
            elements.forEach(el => el.classList.remove('is-invalid'));
            return true;
        }
    }

    function resetForm(...elements) {
        elements.forEach(el => {
            if (el) {
                el.value = '';
                el.classList.remove('is-valid', 'is-invalid');
            }
        });
    }

    function resetRadio(elements) {
        elements.forEach(el => {
            el.checked = false;
            el.classList.remove('is-valid', 'is-invalid');
        });
    }

    // ============================================
    // 5. FONCTIONS PRINCIPALES
    // ============================================
    function ajouterAssureTemporaire() {
        console.log("Ajout d'un nouvel assuré");

        const nomElement = document.getElementById('nomAssur');
        const prenomElement = document.getElementById('prenomAssur');
        const civiliteElementAll = [...document.querySelectorAll('.civiliteAssur')];
        const dateElement = document.getElementById('datenaissanceAssur');
        const lieuNaissanceElement = document.getElementById('lieunaissanceAssur');
        const numeropieceAssurElement = document.getElementById('numeropieceAssur');
        const naturepieceAssurElementAll = [...document.querySelectorAll('.naturepieceAssur')];
        const lieuresidenceAssurElement = document.getElementById('lieuresidenceAssur');
        const lienParenteElement = document.getElementById('lienParente');
        const mobileAssurElement = document.getElementById('mobileAssur');
        const emailAssurElement = document.getElementById('emailAssur');

        const nom = nomElement.value.trim();
        const prenom = prenomElement.value.trim();
        const civilite = getCiviliteSelectedValue(civiliteElementAll);
        const datenaissance = dateElement.value.trim();
        const lieuNaissance = lieuNaissanceElement ? lieuNaissanceElement.value.trim() : '';
        const numeropieceAssur = numeropieceAssurElement ? numeropieceAssurElement.value.trim() : '';
        const naturepieceAssur = getNaturePieceSelectedValue(naturepieceAssurElementAll);
        const lieuresidenceAssur = lieuresidenceAssurElement ? lieuresidenceAssurElement.value.trim() : '';
        const lienParente = lienParenteElement ? lienParenteElement.value.trim() : '';
        const mobileAssur = mobileAssurElement ? mobileAssurElement.value.trim() : '';
        const emailAssur = emailAssurElement ? emailAssurElement.value.trim() : '';

        // Validation
        if (!validateField(nomElement, nom) ||
            !validateField(prenomElement, prenom) ||
            !validateField(dateElement, datenaissance) ||
            !validateFieldRadio(civiliteElementAll, civilite)) {
            return;
        }

        // Ajout
        assures.push({
            nom,
            prenom,
            civilite,
            datenaissance,
            lieuNaissance,
            numeropieceAssur,
            naturepieceAssur,
            lieuresidenceAssur,
            lienParente,
            mobileAssur,
            emailAssur
        });

        // Mise à jour du champ caché
        document.getElementById('assuresInput').value = JSON.stringify(assures);

        // Réinitialisation
        resetForm(nomElement, prenomElement, dateElement, lieuNaissanceElement, 
            lieuresidenceAssurElement, lienParenteElement, mobileAssurElement, 
            emailAssurElement, numeropieceAssurElement);
        resetRadio(civiliteElementAll);
        resetRadio(naturepieceAssurElementAll);

        // Réinitialiser le bouton
        resetButton();

        // Mise à jour de l'affichage
        afficherAssures();
        $('#createPropositionModal').modal('hide');
    }

    // ✅ FONCTION CORRIGÉE
    function modifierAssure(index) {
        console.log("Modification de l'assuré à l'index :", index);
        
        const assure = assures[index];
        if (!assure) {
            console.error("Assuré non trouvé");
            return;
        }
        
        indexModification = index;
        
        // Remplir le formulaire
        document.getElementById('nomAssur').value = assure.nom || '';
        document.getElementById('prenomAssur').value = assure.prenom || '';
        document.getElementById('datenaissanceAssur').value = assure.datenaissance || '';
        document.getElementById('lieunaissanceAssur').value = assure.lieuNaissance || '';
        document.getElementById('lieuresidenceAssur').value = assure.lieuresidenceAssur || '';
        document.getElementById('lienParente').value = assure.lienParente || '';
        document.getElementById('mobileAssur').value = assure.mobileAssur || '';
        document.getElementById('emailAssur').value = assure.emailAssur || '';
        document.getElementById('numeropieceAssur').value = assure.numeropieceAssur || '';
        
        // Remplir les radios
        document.querySelectorAll('.civiliteAssur').forEach(radio => {
            radio.checked = (radio.value === assure.civilite);
        });
        
        document.querySelectorAll('.naturepieceAssur').forEach(radio => {
            radio.checked = (radio.value === assure.naturepieceAssur);
        });
        
        // Changer le bouton
        const btnAjouter = document.getElementById('btn-ajouter');
        btnAjouter.textContent = 'Modifier l\'assuré';
        btnAjouter.className = 'btn btn-warning';
        btnAjouter.onclick = function() {
            modifierAssureTemporaire(index);
        };
        
        // Changer le titre du modal
        document.getElementById('modalTitle').textContent = 'Modifier l\'assuré';
        
        // Afficher le modal
        $('#createPropositionModal').modal('show');
    }

    // ✅ FONCTION CORRIGÉE - REMPLACE AU LIEU D'AJOUTER
    function modifierAssureTemporaire(index) {
        console.log("Validation de la modification à l'index :", index);
        
        const nomElement = document.getElementById('nomAssur');
        const prenomElement = document.getElementById('prenomAssur');
        const civiliteElementAll = [...document.querySelectorAll('.civiliteAssur')];
        const dateElement = document.getElementById('datenaissanceAssur');
        const lieuNaissanceElement = document.getElementById('lieunaissanceAssur');
        const numeropieceAssurElement = document.getElementById('numeropieceAssur');
        const naturepieceAssurElementAll = [...document.querySelectorAll('.naturepieceAssur')];
        const lieuresidenceAssurElement = document.getElementById('lieuresidenceAssur');
        const lienParenteElement = document.getElementById('lienParente');
        const mobileAssurElement = document.getElementById('mobileAssur');
        const emailAssurElement = document.getElementById('emailAssur');

        const nom = nomElement.value.trim();
        const prenom = prenomElement.value.trim();
        const civilite = getCiviliteSelectedValue(civiliteElementAll);
        const datenaissance = dateElement.value.trim();
        const lieuNaissance = lieuNaissanceElement ? lieuNaissanceElement.value.trim() : '';
        const numeropieceAssur = numeropieceAssurElement ? numeropieceAssurElement.value.trim() : '';
        const naturepieceAssur = getNaturePieceSelectedValue(naturepieceAssurElementAll);
        const lieuresidenceAssur = lieuresidenceAssurElement ? lieuresidenceAssurElement.value.trim() : '';
        const lienParente = lienParenteElement ? lienParenteElement.value.trim() : '';
        const mobileAssur = mobileAssurElement ? mobileAssurElement.value.trim() : '';
        const emailAssur = emailAssurElement ? emailAssurElement.value.trim() : '';

        // Validation
        if (!validateField(nomElement, nom) ||
            !validateField(prenomElement, prenom) ||
            !validateField(dateElement, datenaissance) ||
            !validateFieldRadio(civiliteElementAll, civilite)) {
            return;
        }

        // ✅ CORRECTION : Remplacer l'assuré à l'index spécifié
        assures[index] = {
            nom,
            prenom,
            civilite,
            datenaissance,
            lieuNaissance,
            numeropieceAssur,
            naturepieceAssur,
            lieuresidenceAssur,
            lienParente,
            mobileAssur,
            emailAssur
        };

        // Mise à jour du champ caché
        document.getElementById('assuresInput').value = JSON.stringify(assures);

        // Réinitialisation
        resetForm(nomElement, prenomElement, dateElement, lieuNaissanceElement, 
            lieuresidenceAssurElement, lienParenteElement, mobileAssurElement, 
            emailAssurElement, numeropieceAssurElement);
        resetRadio(civiliteElementAll);
        resetRadio(naturepieceAssurElementAll);

        // Réinitialiser le bouton
        resetButton();
        indexModification = null;
        document.getElementById('modalTitle').textContent = 'Ajouter un assuré';

        // ✅ Mise à jour de l'affichage
        afficherAssures();
        $('#createPropositionModal').modal('hide');
    }

    function resetButton() {
        const btnAjouter = document.getElementById('btn-ajouter');
        btnAjouter.textContent = 'Ajouter l\'assuré';
        btnAjouter.className = 'btn btn-primary';
        btnAjouter.onclick = ajouterAssureTemporaire;
        indexModification = null;
    }

    function supprimerAssure(index) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet assuré ?')) {
            assures.splice(index, 1);
            document.getElementById('assuresInput').value = JSON.stringify(assures);
            afficherAssures();
        }
    }

    function afficherAssures() {
        const tbody = document.getElementById('assures-tbody');
        if (!tbody) {
            console.error("Le tbody n'a pas été trouvé");
            return;
        }

        tbody.innerHTML = '';

        if (assures.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted">Aucun assuré ajouté</td>
                </tr>
            `;
            return;
        }

        assures.forEach((assure, index) => {
            // Construction des garanties obligatoires
            let garantiesHtml = '';
            @foreach ($productGarantie->where('estobligatoire', 1) as $item)
                garantiesHtml += `<li>{{ $item->libelle }}</li>`;
            @endforeach

            const row = `
                <tr>
                    <td>
                        <strong>${assure.civilite || ''}</strong> ${assure.nom} ${assure.prenom}
                        <br>
                        <small class="text-muted">Né(e) le ${assure.datenaissance || 'N/A'}</small>
                    </td>
                    <td>
                        <ul class="mb-0">
                            ${garantiesHtml}
                        </ul>
                    </td>
                    <td>
                        <span class="text-muted">Aucune garantie complémentaire</span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-primary" onclick="modifierAssure(${index})" title="Modifier">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger" onclick="supprimerAssure(${index})" title="Supprimer">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    // ============================================
    // 6. GESTION DU MODAL
    // ============================================
    $('#createPropositionModal').on('hidden.bs.modal', function () {
        // Réinitialiser le formulaire
        const nomElement = document.getElementById('nomAssur');
        const prenomElement = document.getElementById('prenomAssur');
        const dateElement = document.getElementById('datenaissanceAssur');
        const lieuNaissanceElement = document.getElementById('lieunaissanceAssur');
        const lieuresidenceAssurElement = document.getElementById('lieuresidenceAssur');
        const lienParenteElement = document.getElementById('lienParente');
        const mobileAssurElement = document.getElementById('mobileAssur');
        const emailAssurElement = document.getElementById('emailAssur');
        const numeropieceAssurElement = document.getElementById('numeropieceAssur');
        const civiliteElementAll = [...document.querySelectorAll('.civiliteAssur')];
        const naturepieceAssurElementAll = [...document.querySelectorAll('.naturepieceAssur')];
        
        resetForm(nomElement, prenomElement, dateElement, lieuNaissanceElement, 
            lieuresidenceAssurElement, lienParenteElement, mobileAssurElement, 
            emailAssurElement, numeropieceAssurElement);
        resetRadio(civiliteElementAll);
        resetRadio(naturepieceAssurElementAll);
        
        // Réinitialiser le bouton
        resetButton();
        document.getElementById('modalTitle').textContent = 'Ajouter un assuré';
        
        // Supprimer les classes d'erreur
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    });

    // ============================================
    // 7. EXPOSER LES FONCTIONS GLOBALEMENT
    // ============================================
    window.ajouterAssureTemporaire = ajouterAssureTemporaire;
    window.modifierAssure = modifierAssure;
    window.modifierAssureTemporaire = modifierAssureTemporaire;
    window.supprimerAssure = supprimerAssure;
    window.afficherAssures = afficherAssures;
    window.resetButton = resetButton;

    // ============================================
    // 8. INITIALISATION
    // ============================================
    // Récupérer les données existantes depuis le champ caché
    const assuresInput = document.getElementById('assuresInput');
    if (assuresInput && assuresInput.value) {
        try {
            const data = JSON.parse(assuresInput.value);
            if (Array.isArray(data) && data.length > 0) {
                assures = data;
                afficherAssures();
            }
        } catch (e) {
            console.error('Erreur lors du parsing des données:', e);
        }
    }

    // Écouter le bouton d'ajout du modal
    document.getElementById('btn-ajouter').addEventListener('click', ajouterAssureTemporaire);

    console.log('Application initialisée avec succès');
});
</script>