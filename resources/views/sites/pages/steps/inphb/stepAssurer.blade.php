<div class="row g-3 align-items-end mb-3">
    <div class="col-12 col-lg-6">
        <label class="form-label">Le souscripteur est-il l'assuré ?</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estAssure" id="estAssureOui" value="Oui">
            <label class="form-check-label" for="estAssureOui">Oui</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estAssure" id="estAssureNon" value="Non">
            <label class="form-check-label" for="estAssureNon">Non</label>
        </div>
        <small class="text-muted d-block mt-1">
            Le souscripteur est obligatoirement assuré, quelle que soit la formule.
        </small>
    </div>
    <div class="col-12 col-lg-6 text-end" id="modalAssurerOpen">
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createAssurerModal">
            <i class="fadeIn animated bx bx-plus"></i> Ajouter un(e) autre assuré(e)
        </button>
    </div>
</div>
@include('sites.pages.steps.inphb.addAssureModal')

<div class="alert alert-info py-2 px-3" id="reglesFormule"></div>

<div class="alert alert-secondary py-2 px-3" id="recapPrimeBox">
    <div class="row text-center g-2">
        <div class="col-6 col-md-3">
            <strong>Prime de base</strong><br>
            <span id="primeBase">0</span> FCFA
        </div>
        <div class="col-6 col-md-3">
            <strong>Surprime enfants</strong><br>
            <span id="surprimeEnfants">0</span> FCFA
        </div>
        <div class="col-6 col-md-3">
            <strong>Capital total assurés</strong><br>
            <span id="capitalTotal">0</span> FCFA
        </div>
        <div class="col-6 col-md-3">
            <strong>Prime totale</strong><br>
            <span id="primeTotal" class="fw-bold text-success">0</span> FCFA
        </div>
    </div>
</div>

<div class="overflow-auto">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Assuré(e)</th>
                <th>Date de naissance</th>
                <th>Lien de parenté</th>
                <th>Lieu de résidence</th>
                <th>n° de telephone</th>
                <th>n° de piece</th>
                <th>Capital</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tableAssuresBody">
            <!-- Contenu dynamique injecté ici par JavaScript -->
        </tbody>
    </table>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const radioOui = document.getElementById('estAssureOui');
    const radioNon = document.getElementById('estAssureNon');
    const storeAssurerBtn = document.getElementById('storeAssurerBtn');
    const assurerForm = document.getElementById('assurerFormInphb');
    const modalAssurerOpen = document.getElementById('modalAssurerOpen');

    // ============================================================
    //                     RÈGLES MÉTIER
    // ============================================================

    const FILIATION_CONJOINT  = 'CONJT';
    const FILIATION_ENFANT    = 'ENFT';
    const FILIATION_SOUSCRIPT = 'LUIMM';
    const FILIATION_MERE      = 'MERE';
    const FILIATION_PERE      = 'PERE';
    const FILIATION_ASCENDANTS = [FILIATION_MERE, FILIATION_PERE];

    const NB_ENFANTS_INCLUS   = 4;
    const SURPRIME_PAR_ENFANT = 680;

    const FORMULE_COMPLETE = 'complete';
    const FORMULE_PREMIUM  = 'premium';

    const REGLES_FORMULES = {
        [FORMULE_COMPLETE]: {
            label: 'Formule Complète (Option 1)',
            maxAscendants: 2,
            capitalAssurePrincipal: 2000000,
            capitalConjoint: 2000000,
            capitalEnfant: 1000000,
            capitalAscendant: 1000000
        },
        [FORMULE_PREMIUM]: {
            label: 'Formule Premium (Option 2)',
            maxAscendants: 1,
            capitalAssurePrincipal: 2000000,
            capitalConjoint: 2000000,
            capitalEnfant: 1000000,
            capitalAscendant: 1000000
        }
    };

    const LIBELLES_FILIATION = {
        CONJT: 'Conjoint(e)', ENFT: 'Enfant', AUTRE: 'Autre parent',
        LUIMM: 'Lui-même (souscripteur)', MERE: 'Mère', PERE: 'Père',
        AMI: 'Ami(e)', ONCLE: 'Oncle', TANTE: 'Tante', BOPERE: 'Beau père',
        BELMERE: 'Belle mère', FRERE: 'Frère', SOEUR: 'Soeur',
        COUZO: 'Cousin', COUZN: 'Cousine'
    };

    // ============================================================
    //                     SESSION HELPERS
    // ============================================================

    function getSouscriptionData() {
        return JSON.parse(sessionStorage.getItem('souscriptionData')) || {};
    }
    function saveSouscriptionData(data) {
        sessionStorage.setItem('souscriptionData', JSON.stringify(data));
    }
    function isContratIndividuel() {
        return getSouscriptionData().simulationData?.type === "Individuel";
    }

    function getFormuleCode() {
        const s = getSouscriptionData();
        const formule = (s.simulationData?.formule || '').toString().toLowerCase().trim();
        if (formule === FORMULE_PREMIUM) return FORMULE_PREMIUM;
        if (formule === FORMULE_COMPLETE) return FORMULE_COMPLETE;
        return FORMULE_COMPLETE;
    }

    function getReglesFormule() {
        return REGLES_FORMULES[getFormuleCode()];
    }

    function isAscendant(code) {
        return FILIATION_ASCENDANTS.includes((code || '').toUpperCase());
    }
    function compterEnfants(list)    { return list.filter(a => a.filiation === FILIATION_ENFANT).length; }
    function compterConjoints(list)  { return list.filter(a => a.filiation === FILIATION_CONJOINT).length; }
    function compterAscendants(list) { return list.filter(a => isAscendant(a.filiation)).length; }

    function capitalPour(filiation, estSouscripteur) {
        const regles = getReglesFormule();
        if (estSouscripteur || filiation === FILIATION_SOUSCRIPT) return regles.capitalAssurePrincipal;
        if (filiation === FILIATION_CONJOINT) return regles.capitalConjoint;
        if (filiation === FILIATION_ENFANT) return regles.capitalEnfant;
        if (isAscendant(filiation)) return regles.capitalAscendant;
        return 0;
    }

    function calculerSurprimeEnfants(list) {
        const nbEnfants = compterEnfants(list);
        const nbEnfantsSupplementaires = Math.max(0, nbEnfants - NB_ENFANTS_INCLUS);
        return nbEnfantsSupplementaires * SURPRIME_PAR_ENFANT;
    }

    function calculerCapitalTotal(list) {
        return list.reduce((total, a) => total + Number(a.capital || 0), 0);
    }

    function recalculerPrime() {
        const s = getSouscriptionData();
        const list = s.assureData || [];

        const surprime = calculerSurprimeEnfants(list);
        const capitalTotal = calculerCapitalTotal(list);
        const primeBase = Number(s.simulationData?.prime || s.contratData?.primepricipale || 0);
        const primeOptionelle = Number(s.simulationData?.optionPrime || 0);
        const primeTotal = primeBase + surprime + primeOptionelle;

        s.contratData = s.contratData || {};
        s.contratData.nbEnfants = compterEnfants(list);
        s.contratData.surprimeEnfants = surprime;
        s.contratData.capitalTotal = capitalTotal;
        s.contratData.primeTotal = primeTotal;
        saveSouscriptionData(s);

        const primeBaseEl = document.getElementById('primeBase');
        const surprimeEl = document.getElementById('surprimeEnfants');
        const capitalEl = document.getElementById('capitalTotal');
        const primeTotalEl = document.getElementById('primeTotal');

        if (primeBaseEl) primeBaseEl.textContent = primeBase.toLocaleString('fr-FR');
        if (surprimeEl) surprimeEl.textContent = surprime.toLocaleString('fr-FR');
        if (capitalEl) capitalEl.textContent = capitalTotal.toLocaleString('fr-FR');
        if (primeTotalEl) primeTotalEl.textContent = primeTotal.toLocaleString('fr-FR');
    }

    function afficherReglesFormule() {
        const regles = getReglesFormule();
        const el = document.getElementById('reglesFormule');
        if (el) {
            el.innerHTML = `
                <strong>${regles.label}</strong><br>
                Assuré principal obligatoire : ${regles.capitalAssurePrincipal.toLocaleString('fr-FR')} FCFA &nbsp;|&nbsp;
                1 conjoint(e) max : ${regles.capitalConjoint.toLocaleString('fr-FR')} FCFA &nbsp;|&nbsp;
                4 enfants inclus puis ${SURPRIME_PAR_ENFANT} FCFA/enfant supplémentaire (${regles.capitalEnfant.toLocaleString('fr-FR')} FCFA/enfant) &nbsp;|&nbsp;
                ${regles.maxAscendants} ascendant(s) maximum (${regles.capitalAscendant.toLocaleString('fr-FR')} FCFA/ascendant)
            `;
        }
    }

    function updateButtonState() {
        const s = getSouscriptionData();
        if (s.simulationData?.type === "Individuel") {
            const bloque = (s.assureData || []).length >= 1;
            if (modalAssurerOpen) {
                modalAssurerOpen.classList.toggle("disabled", bloque);
                modalAssurerOpen.style.pointerEvents = bloque ? "none" : "auto";
                modalAssurerOpen.style.opacity = bloque ? "0.5" : "1";
            }
        }
    }

    // ============================================================
    //                  AJOUT D'UN ASSURÉ
    // ============================================================

    function finaliserAjout(assure, list, s) {
        list.push(assure);
        saveSouscriptionData(s);
        updateButtonState();
        ajouterAssureDansTableau(assure);
        recalculerPrime();
    }

    // Fonction pour réinitialiser complètement le formulaire du modal
    function resetModalForm() {
        if (!assurerForm) return;

        // Réinitialiser tous les champs du formulaire
        assurerForm.reset();

        // Réinitialiser les champs radio
        document.querySelectorAll('input[name="assurerCivilite"]').forEach(el => el.checked = false);

        // Réinitialiser les selects à leur valeur par défaut
        const filiationSelect = document.getElementById('assurerFiliation');
        if (filiationSelect) filiationSelect.value = '';

        const sexeSelect = document.getElementById('assurerSexe');
        if (sexeSelect) sexeSelect.value = '';

        const naturepieceSelect = document.getElementById('assurerNaturepiece');
        if (naturepieceSelect) naturepieceSelect.value = '';

        const professionSelect = document.getElementById('assurerProfession');
        if (professionSelect) professionSelect.value = '';

        const employeurSelect = document.getElementById('assurerEmployeur');
        if (employeurSelect) employeurSelect.value = '';

        // Vider le champ file
        const fileInput = document.getElementById('justifResidence');
        if (fileInput) fileInput.value = '';

        // Réinitialiser l'index
        const indexInput = document.getElementById('assurerIndex');
        if (indexInput) indexInput.value = '-1';

        // Supprimer les classes d'erreur
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.text-danger').forEach(el => {
            if (el.classList.contains('date-error')) el.remove();
        });
    }

    // Fonction pour fermer et réinitialiser le modal
    function fermerEtReinitialiserModal() {
        // Réinitialiser le formulaire
        resetModalForm();

        // Fermer le modal
        const modalElement = document.getElementById('createAssurerModal');
        if (modalElement) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        }
    }

    function ajouterAssure(assure, estSouscripteur = false) {
        const s = getSouscriptionData();
        s.assureData = s.assureData || [];
        const list = s.assureData;

        if (isContratIndividuel() && list.length >= 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Désolé',
                text: 'Un seul assuré est autorisé pour un contrat individuel.',
                confirmButtonText: 'Fermer'
            });
            return false;
        }

        if (list.some(a => a.numeropiece === assure.numeropiece)) {
            Swal.fire({
                icon: 'warning',
                title: 'Désolé',
                text: 'Cet assuré est déjà présent dans la liste.',
                confirmButtonText: 'Fermer'
            });
            return false;
        }

        const filiation = (assure.filiation || '').toUpperCase();

        if (!estSouscripteur && filiation === FILIATION_SOUSCRIPT) {
            Swal.fire({
                icon: 'warning',
                title: 'Désolé',
                text: 'Ce lien est réservé au souscripteur.',
                confirmButtonText: 'Fermer'
            });
            return false;
        }

        if (filiation === FILIATION_CONJOINT && compterConjoints(list) >= 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Désolé',
                text: 'Un seul conjoint(e) peut être ajouté.',
                confirmButtonText: 'Fermer'
            });
            return false;
        }

        if (isAscendant(filiation)) {
            const regles = getReglesFormule();
            if (compterAscendants(list) >= regles.maxAscendants) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Désolé',
                    text: `Votre formule (${regles.label}) autorise au maximum ${regles.maxAscendants} ascendant(s) (Mère/Père).`,
                    confirmButtonText: 'Fermer'
                });
                return false;
            }
        }

        assure.filiation = filiation;
        assure.capital = capitalPour(filiation, estSouscripteur);

        if (filiation === FILIATION_ENFANT && (compterEnfants(list) + 1) > NB_ENFANTS_INCLUS) {
            Swal.fire({
                icon: 'warning',
                title: 'Surprime applicable',
                html: `Cet enfant est le <strong>${compterEnfants(list) + 1}e</strong> enfant déclaré.<br>
                       Une surprime de <strong>${SURPRIME_PAR_ENFANT} FCFA</strong> sera ajoutée à votre prime.<br>
                       Voulez-vous confirmer l'ajout ?`,
                showCancelButton: true,
                confirmButtonText: 'Confirmer et enregistrer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    finaliserAjout(assure, list, s);
                    fermerEtReinitialiserModal();
                }
            });
            return 'pending';
        }

        finaliserAjout(assure, list, s);
        return true;
    }

    // ============================================================
    //                  RENDU TABLEAU
    // ============================================================

    function ajouterAssureDansTableau(assure) {
        const tbody = document.getElementById('tableAssuresBody');
        if (!tbody) return;

        if (isContratIndividuel()) tbody.innerHTML = '';

        const tr = document.createElement('tr');
        tr.setAttribute('data-id', assure.numeropiece);
        const libelle = LIBELLES_FILIATION[assure.filiation] || assure.filiation;
        const estObligatoire = assure.filiation === FILIATION_SOUSCRIPT;

        tr.innerHTML = `
            <td>${assure.civilite || ''} ${assure.nom} ${assure.prenom}</td>
            <td>${assure.datenaissance}</td>
            <td>${libelle}</td>
            <td>${assure.lieuresidence}</td>
            <td>${assure.mobile || assure.telephone || ''}</td>
            <td>${assure.numeropiece}</td>
            <td><span class="badge bg-primary">${Number(assure.capital || 0).toLocaleString('fr-FR')} FCFA</span></td>
            <td>${estObligatoire
                ? '<span class="badge bg-secondary">Obligatoire</span>'
                : '<button type="button" class="btn btn-danger btn-sm" onclick="supprimerLigne(this)">Supprimer</button>'}</td>
        `;
        tbody.appendChild(tr);
    }

    // ============================================================
    //                  INITIALISATION
    // ============================================================

    // Le souscripteur est toujours ajouté automatiquement comme assuré
    function assurerPresenceSouscripteur() {
        const s = getSouscriptionData();
        const adherent = s.adherentData;

        if (!adherent) return;

        s.assureData = s.assureData || [];
        const dejaPresent = s.assureData.some(a => a.numeropiece === adherent.numeropiece);

        if (!dejaPresent) {
            const assureSouscripteur = {
                ...adherent,
                filiation: FILIATION_SOUSCRIPT,
                capital: capitalPour(FILIATION_SOUSCRIPT, true)
            };
            s.assureData.push(assureSouscripteur);
            saveSouscriptionData(s);
        }
    }

    function initialiserTableauAssures() {
        const tbody = document.getElementById('tableAssuresBody');
        if (tbody) tbody.innerHTML = '';

        // Appeler assurerPresenceSouscripteur qui va ajouter le souscripteur
        assurerPresenceSouscripteur();

        const s = getSouscriptionData();
        (s.assureData || []).forEach(a => ajouterAssureDansTableau(a));

        if (radioOui) {
            radioOui.checked = true;
            radioOui.disabled = true;
        }
        if (radioNon) {
            radioNon.disabled = true;
        }

        afficherReglesFormule();
        updateButtonState();
        recalculerPrime();
    }

    // ============================================================
    //                  ÉVÉNEMENTS
    // ============================================================

    if (storeAssurerBtn) {
        storeAssurerBtn.addEventListener('click', function () {
            const formData = {
                civilite: document.querySelector('input[name="assurerCivilite"]:checked')?.value || '',
                nom: document.getElementById('assurerNom')?.value || '',
                prenom: document.getElementById('assurerPrenom')?.value || '',
                datenaissance: document.getElementById('assurerDatenaissance')?.value || '',
                lieunaissance: document.getElementById('assurerLieunaissance')?.value || '',
                filiation: document.getElementById('assurerFiliation')?.value || '',
                sexe: document.getElementById('assurerSexe')?.value || '',
                naturepiece: document.getElementById('assurerNaturepiece')?.value || '',
                numeropiece: document.getElementById('assurerNumeropiece')?.value || '',
                lieuresidence: document.getElementById('assurerLieuresidence')?.value || '',
                profession: document.getElementById('assurerProfession')?.value || '',
                employeur: document.getElementById('assurerEmployeur')?.value || '',
                email: document.getElementById('assurerEmail')?.value || '',
                telephone: document.getElementById('assurerTelephone')?.value || '',
                telephone1: document.getElementById('assurerTelephone1')?.value || '',
                mobile: document.getElementById('assurerMobile')?.value || '',
                justifResidence: document.getElementById('justifResidence')?.files || []
            };

            // Vérifier que le formulaire est valide
            if (!assurerForm || !assurerForm.checkValidity()) {
                if (assurerForm) assurerForm.reportValidity();
                return;
            }

            const resultat = ajouterAssure(formData);

            if (resultat === true) {
                fermerEtReinitialiserModal();
            }
        });
    }

    // Écouter l'événement de fermeture du modal pour réinitialiser le formulaire
    document.addEventListener('hidden.bs.modal', function (event) {
        if (event.target.id === 'createAssurerModal') {
            resetModalForm();
        }
    });

    // Initialiser le tableau au chargement
    initialiserTableauAssures();
});

// ============================================================
//                  SUPPRESSION D'UN ASSURÉ
// ============================================================
function supprimerLigne(btn) {
    const row = btn.closest('tr');
    if (!row) return;

    const id = row.getAttribute('data-id');
    const s = JSON.parse(sessionStorage.getItem('souscriptionData')) || {};
    const assure = (s.assureData || []).find(a => a.numeropiece === id);

    if (assure && assure.filiation === 'LUIMM') {
        Swal.fire({
            icon: 'warning',
            title: 'Désolé',
            text: 'Le souscripteur doit rester assuré, suppression impossible.',
            confirmButtonText: 'Fermer'
        });
        return;
    }

    // Confirmation avant suppression
    Swal.fire({
        icon: 'warning',
        title: 'Supprimer cet assuré ?',
        html: `Voulez-vous supprimer <strong>${assure?.nom || ''} ${assure?.prenom || ''}</strong> ?`,
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if (!result.isConfirmed) return;

        row.remove();
        s.assureData = (s.assureData || []).filter(a => a.numeropiece !== id);
        sessionStorage.setItem('souscriptionData', JSON.stringify(s));

        const modalAssurerOpen = document.getElementById('modalAssurerOpen');
        if (s.simulationData?.type === "Individuel") {
            const bloque = s.assureData.length >= 1;
            if (modalAssurerOpen) {
                modalAssurerOpen.classList.toggle("disabled", bloque);
                modalAssurerOpen.style.pointerEvents = bloque ? "none" : "auto";
                modalAssurerOpen.style.opacity = bloque ? "0.5" : "1";
            }
        }

        // Recalcul après suppression
        const nbEnfants = s.assureData.filter(a => a.filiation === 'ENFT').length;
        const surprime = Math.max(0, nbEnfants - 4) * 680;
        const capitalTotal = s.assureData.reduce((total, a) => total + Number(a.capital || 0), 0);
        const primeBase = Number(s.simulationData?.prime || s.contratData?.primepricipale || 0);
        const primeTotal = primeBase + surprime;

        s.contratData = s.contratData || {};
        s.contratData.nbEnfants = nbEnfants;
        s.contratData.surprimeEnfants = surprime;
        s.contratData.capitalTotal = capitalTotal;
        s.contratData.primeTotal = primeTotal;
        sessionStorage.setItem('souscriptionData', JSON.stringify(s));

        const primeBaseEl = document.getElementById('primeBase');
        const surprimeEl = document.getElementById('surprimeEnfants');
        const capitalEl = document.getElementById('capitalTotal');
        const primeTotalEl = document.getElementById('primeTotal');

        if (primeBaseEl) primeBaseEl.textContent = primeBase.toLocaleString('fr-FR');
        if (surprimeEl) surprimeEl.textContent = surprime.toLocaleString('fr-FR');
        if (capitalEl) capitalEl.textContent = capitalTotal.toLocaleString('fr-FR');
        if (primeTotalEl) primeTotalEl.textContent = primeTotal.toLocaleString('fr-FR');

        Swal.fire({
            icon: 'success',
            title: 'Assuré supprimé',
            text: 'La personne a été retirée des bénéficiaires.',
            timer: 1500,
            showConfirmButton: false
        });
    });
}
</script>
