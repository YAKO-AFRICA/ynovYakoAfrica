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
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
            data-bs-target="#createAssurerModal">
            <i class="fadeIn animated bx bx-plus"></i> Ajouter un(e) autre assuré(e)
        </button>
    </div>
</div>


<div class="alert alert-info py-2 px-3" id="reglesFormule"></div>

<div class="alert alert-secondary py-2 px-2" id="recapPrimeBox">
    <div class="row text-center g-1">
        <div class="col-6 col-md-2">
            <strong>Prime de base</strong><br>
            <span id="primeBase">0</span> FCFA
        </div>
        <div class="col-6 col-md-3">
            <strong>Garantie complementaire</strong><br>
            <span id="primecomplementaire">0</span> FCFA
        </div>
        <div class="col-6 col-md-2">
            <strong>Surprime enfants</strong><br>
            <span id="surprimeEnfants">0</span> FCFA
        </div>
        <div class="col-6 col-md-3">
            <strong>Capital total assurés</strong><br>
            <span id="capitalTotal">0</span> FCFA
        </div>
        <div class="col-6 col-md-2">
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

<style>
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }

    #tableAssuresBody tr {
        transition: all 0.3s ease;
    }

    #tableAssuresBody tr:hover {
        background-color: #f8f9fa;
    }
</style>

<!-- Modal Ajouter/Éditer Assuré -->
<div class="modal fade" id="createAssurerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog">
        <div class="modal-content">
            <form id="assurerFormInphb">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Ajouter un(e) assuré(e)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="assurerIndex" value="-1">

                    <div class="row g-3">
                        <!-- Civilité -->
                        <div class="col-12">
                            <label class="form-label">Civilité <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="assurerCivilite"
                                    id="civiliteMadame" value="Madame" required>
                                <label class="form-check-label" for="civiliteMadame">Madame</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="assurerCivilite"
                                    id="civiliteMademoiselle" value="Mademoiselle">
                                <label class="form-check-label" for="civiliteMademoiselle">Mademoiselle</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="assurerCivilite"
                                    id="civiliteMonsieur" value="Monsieur">
                                <label class="form-check-label" for="civiliteMonsieur">Monsieur</label>
                            </div>
                        </div>

                        <!-- Nom et Prénoms -->
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="assurerNom" id="assurerNom" class="form-control" required>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Prénoms <span class="text-danger">*</span></label>
                            <input type="text" name="assurerPrenom" id="assurerPrenom" class="form-control"
                                required>
                        </div>

                        <!-- Date et lieu de naissance -->
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
                            <input type="date" name="assurerDatenaissance" id="assurerDatenaissance"
                                class="form-control" required>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Lieu de naissance <span class="text-danger">*</span></label>
                            <input type="text" name="assurerLieunaissance" id="assurerLieunaissance"
                                class="form-control" required>
                        </div>

                        <div class="col-12 col-lg-12 row">
                            <!-- Filiation et Sexe -->
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Lien de parenté <span class="text-danger">*</span></label>
                                <select id="assurerFiliation" class="form-select" name="assurerFiliation" required>
                                    <option selected value="" disabled>Sélectionner le lien de Parenté</option>
                                    @foreach ($filliations->whereIn('CodeFiliation', ['CONJT', 'ENFT', 'MERE', 'PERE']) as $filliation)
                                        <option value="{{ $filliation->CodeFiliation }}">{{ $filliation->MonLibelle }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label">Sexe <span class="text-danger">*</span></label>
                                <select class="form-select" name="assurerSexe" id="assurerSexe" required>
                                    <option value="" disabled selected>Sélectionner</option>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>
                        </div>

                        <!-- Pièce d'identité -->
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Nature de la pièce <span class="text-danger">*</span></label>
                            <select class="form-select" name="assurerNaturepiece" id="assurerNaturepiece" required>
                                <option value="" disabled selected>Sélectionner</option>
                                <option value="CNI">CNI</option>
                                <option value="AT">Attestation</option>
                                <option value="Passport">Passeport</option>
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Numéro de la pièce <span class="text-danger">*</span></label>
                            <input type="text" name="assurerNumeropiece" id="assurerNumeropiece"
                                class="form-control" required>
                        </div>

                        <!-- Lieu de résidence -->
                        <div class="row my-3 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-sm-12 col-md-6 col-lg-8">
                                <label class="form-label">Lieu de résidence <span class="text-danger">*</span></label>
                                <input type="text" name="assurerLieuresidence" id="assurerLieuresidence"
                                    class="form-control" required>
                            </div>
                            @if (in_array($codePartner, ['DIRECTENTREPRISE', 'INPHB']))
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <label for="justifResidence" class="form-label">Justificatif de résidence </label>
                                    <input type="file" name="justifResidence" class="form-control"
                                        id="justifResidence" accept="application/pdf,image/jpeg,image/jpg,image/png">
                                </div>
                            @else
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <label for="justifResidence" class="form-label">Justificatif de résidence <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="justifResidence" class="form-control"
                                        id="justifResidence" required
                                        accept="application/pdf,image/jpeg,image/jpg,image/png">
                                </div>
                            @endif
                        </div>

                        <!-- Profession et Employeur -->
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Profession</label>
                            <select class="form-select profession" name="assurerProfession" id="assurerProfession">
                                <option value="" disabled selected>Sélectionner la profession</option>
                                @foreach ($professions as $profession)
                                    <option value="{{ $profession->MonLibelle }}">{{ $profession->MonLibelle }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Secteur d'activités</label>
                            <select class="form-select" name="assurerEmployeur" id="assurerEmployeur">
                                <option value="" disabled selected>Sélectionner le secteur</option>
                                @foreach ($secteurActivites as $secteurActivite)
                                    <option value="{{ $secteurActivite->MonLibelle }}">
                                        {{ $secteurActivite->MonLibelle }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Contacts -->
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" name="assurerEmail" id="assurerEmail" class="form-control">
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" name="assurerTelephone" id="assurerTelephone" class="form-control"
                                minlength="10" maxlength="15">
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Téléphone 2</label>
                            <input type="tel" name="assurerTelephone1" id="assurerTelephone1"
                                class="form-control" minlength="10" maxlength="15">
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Mobile <span class="text-danger">*</span></label>
                            <input type="tel" name="assurerMobile" id="assurerMobile" class="form-control"
                                minlength="10" maxlength="15" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success" id="storeAssurerBtn">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!--                    JAVASCRIPT COMPLET                           -->
<!-- ============================================================ -->
<script>
    // DÉFINIR LES FONCTIONS EN DEHORS DE DOMContentLoaded POUR QU'ELLES SOIENT ACCESSIBLES
    // ============================================================
    //                     CONSTANTES ET CONFIGURATION
    // ============================================================

    const FILIATION_CONJOINT = 'CONJT';
    const FILIATION_ENFANT = 'ENFT';
    const FILIATION_SOUSCRIPT = 'LUIMM';
    const FILIATION_MERE = 'MERE';
    const FILIATION_PERE = 'PERE';
    const FILIATION_ASCENDANTS = [FILIATION_MERE, FILIATION_PERE];

    const NB_ENFANTS_INCLUS = 4;
    const SURPRIME_PAR_ENFANT = 680;

    const FORMULE_COMPLETE = 'complete';
    const FORMULE_PREMIUM = 'premium';

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
        CONJT: 'Conjoint(e)',
        ENFT: 'Enfant',
        AUTRE: 'Autre parent',
        LUIMM: 'Lui-même (souscripteur)',
        MERE: 'Mère',
        PERE: 'Père',
        BELMERE: 'Belle mère',
        AMI: 'Ami(e)',
        ONCLE: 'Oncle',
        TANTE: 'Tante',
        BOPERE: 'Beau père',
        FRERE: 'Frère',
        SOEUR: 'Soeur',
        COUZO: 'Cousin',
        COUZN: 'Cousine'
    };

    // ============================================================
    //                     SESSION HELPERS
    // ============================================================

    function getSouscriptionData() {
        try {
            const raw = sessionStorage.getItem('souscriptionData');
            const data = raw ? JSON.parse(raw) : {};
            if (!data.adherentData) data.adherentData = {};
            if (!data.assureData) data.assureData = [];
            if (!data.contratData) data.contratData = {};
            if (!data.simulationData) data.simulationData = {};
            return data;
        } catch (e) {
            console.error("Erreur de parsing JSON sessionStorage:", e);
            return {
                adherentData: {},
                assureData: [],
                contratData: {},
                simulationData: {}
            };
        }
    }

    function saveSouscriptionData(data) {
        sessionStorage.setItem('souscriptionData', JSON.stringify(data));
        console.log("✅ Données enregistrées dans la session");
    }

    function isContratIndividuel() {
        const data = getSouscriptionData();
        return data.simulationData?.type === "Individuel";
    }

    function getFormuleCode() {
        const data = getSouscriptionData();
        const formule = (data.simulationData?.formule || '').toString().toLowerCase().trim();
        if (formule === FORMULE_PREMIUM) return FORMULE_PREMIUM;
        return FORMULE_COMPLETE;
    }

    function getReglesFormule() {
        return REGLES_FORMULES[getFormuleCode()] || REGLES_FORMULES[FORMULE_COMPLETE];
    }

    function isAscendant(code) {
        return FILIATION_ASCENDANTS.includes((code || '').toUpperCase());
    }

    function compterEnfants(list) {
        return list.filter(a => a.filiation === FILIATION_ENFANT).length;
    }

    function compterConjoints(list) {
        return list.filter(a => a.filiation === FILIATION_CONJOINT).length;
    }

    function compterAscendants(list) {
        return list.filter(a => isAscendant(a.filiation)).length;
    }

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

    // ============================================================
    //                  RECALCUL DE LA PRIME
    // ============================================================

    function recalculerPrime() {
        const s = getSouscriptionData();
        const list = s.assureData || [];

        let primeBase = Number(s.simulationData?.prime || s.contratData?.primepricipale || 0);

        let optionPrime = 0;
        if (s.simulationData?.garantieOptionnelle?.active) {
            optionPrime = Number(s.simulationData.garantieOptionnelle.prime) || 0;
        }

        const nbEnfants = compterEnfants(list);
        const nbEnfantsSupplementaires = Math.max(0, nbEnfants - NB_ENFANTS_INCLUS);
        const surprime = nbEnfantsSupplementaires * SURPRIME_PAR_ENFANT;

        const capitalTotal = calculerCapitalTotal(list);
        const primeTotal = primeBase + surprime + optionPrime;

        s.contratData = s.contratData || {};
        s.contratData.nbEnfants = nbEnfants;
        s.contratData.surprimeEnfants = surprime;
        s.contratData.capitalTotal = capitalTotal;
        s.contratData.primeTotal = primeTotal;
        s.contratData.prime = primeTotal;
        s.contratData.primepricipale = primeBase;
        s.contratData.primeOptionelle = optionPrime;
        s.contratData.formuleProduit = 'LFFUN_V60';
        s.simulationData.type = s.simulationData?.formule;
        saveSouscriptionData(s);

        const primeBaseEl = document.getElementById('primeBase');
        const primecomplementaireEl = document.getElementById('primecomplementaire');
        const surprimeEl = document.getElementById('surprimeEnfants');
        const capitalEl = document.getElementById('capitalTotal');
        const primeTotalEl = document.getElementById('primeTotal');

        if (primeBaseEl) primeBaseEl.textContent = primeBase.toLocaleString('fr-FR');
        if (primecomplementaireEl) primecomplementaireEl.textContent = optionPrime.toLocaleString('fr-FR');
        if (surprimeEl) surprimeEl.textContent = surprime.toLocaleString('fr-FR');
        if (capitalEl) capitalEl.textContent = capitalTotal.toLocaleString('fr-FR');
        if (primeTotalEl) primeTotalEl.textContent = primeTotal.toLocaleString('fr-FR');
    }

    // ============================================================
    //                  AFFICHAGE DES RÈGLES
    // ============================================================

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
        const modalAssurerOpen = document.getElementById('modalAssurerOpen');
        if (modalAssurerOpen && s.simulationData?.type === "Individuel") {
            const bloque = (s.assureData || []).length >= 1;
            modalAssurerOpen.classList.toggle("disabled", bloque);
            modalAssurerOpen.style.pointerEvents = bloque ? "none" : "auto";
            modalAssurerOpen.style.opacity = bloque ? "0.5" : "1";
        }
    }

    // ============================================================
    //                  AJOUT D'UN ASSURÉ DANS LE TABLEAU
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
        <td>${assure.civilite || ''} ${assure.nom || ''} ${assure.prenom || ''}</td>
        <td>${assure.datenaissance || ''}</td>
        <td>${libelle}</td>
        <td>${assure.lieuresidence || ''}</td>
        <td>${assure.mobile || assure.telephone || ''}</td>
        <td>${assure.numeropiece || ''}</td>
        <td><span class="badge bg-primary">${Number(assure.capital || 0).toLocaleString('fr-FR')} FCFA</span></td>
        <td>${estObligatoire
            ? '<span class="badge bg-secondary">Obligatoire</span>'
            : '<button type="button" class="btn btn-danger btn-sm" onclick="window.supprimerLigne(this)">Supprimer</button>'}</td>
    `;
        tbody.appendChild(tr);
    }

    // ============================================================
    //                  CHARGEMENT DES ASSURÉS
    // ============================================================

    function chargerAssures() {
        const tbody = document.getElementById('tableAssuresBody');
        if (!tbody) return;

        console.log("🔄 Chargement des assurés...");

        const s = getSouscriptionData();
        const adherent = s.adherentData;

        if (!adherent || !adherent.numeropiece) {
            console.warn("⚠️ Aucun souscripteur trouvé dans la session");
            return;
        }

        if (!s.assureData) s.assureData = [];

        const souscripteurExiste = s.assureData.some(a => a.numeropiece === adherent.numeropiece);

        if (!souscripteurExiste) {
            console.log("➕ Ajout du souscripteur comme assuré principal");
            const assureSouscripteur = {
                ...adherent,
                filiation: FILIATION_SOUSCRIPT,
                capital: capitalPour(FILIATION_SOUSCRIPT, true)
            };
            s.assureData.unshift(assureSouscripteur);
            saveSouscriptionData(s);
        }

        tbody.innerHTML = '';
        s.assureData.forEach(a => ajouterAssureDansTableau(a));

        recalculerPrime();
        updateButtonState();
        afficherReglesFormule();

        console.log(`✅ ${s.assureData.length} assuré(s) chargé(s)`);
    }

    // ============================================================
    //                  SUPPRESSION D'UN ASSURÉ
    // ============================================================

    function supprimerLigne(btn) {
        const row = btn.closest('tr');
        if (!row) return;

        const id = row.getAttribute('data-id');
        const s = getSouscriptionData();
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
            saveSouscriptionData(s);

            updateButtonState();
            recalculerPrime();

            Swal.fire({
                icon: 'success',
                title: 'Assuré supprimé',
                text: 'La personne a été retirée de la liste.',
                timer: 1500,
                showConfirmButton: false
            });
        });
    }

    // ============================================================
    //                  AJOUT D'UN NOUVEL ASSURÉ
    // ============================================================

    function finaliserAjout(assure, list, s) {
        list.push(assure);
        saveSouscriptionData(s);
        updateButtonState();
        ajouterAssureDansTableau(assure);
        recalculerPrime();
    }

    function ajouterAssure(assure, estSouscripteur = false) {
        console.log("📌 Ajout de l'assuré", assure);

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
    //                  RÉINITIALISATION DU MODAL
    // ============================================================

    function resetModalForm() {
        console.log("resetModalForm");
        const assurerForm = document.getElementById('assurerFormInphb');
        // if (!assurerForm) return;
        console.log('after detect rsetModalForm');

        // assurerForm.reset();

        console.log('after reset');

        document.querySelectorAll('input[name="assurerCivilite"]').forEach(el => el.checked = false);

        const filiationSelect = document.getElementById('assurerFiliation');
        if (filiationSelect) filiationSelect.value = '';

        const inputName = document.getElementById('assurerNom');
        if (inputName) inputName.value = '';

        const inputPrenom = document.getElementById('assurerPrenom');
        if (inputPrenom) inputPrenom.value = '';

        const sexeSelect = document.getElementById('assurerSexe');
        if (sexeSelect) sexeSelect.value = '';

        const naturepieceSelect = document.getElementById('assurerNaturepiece');
        if (naturepieceSelect) naturepieceSelect.value = '';

        const numeropieceInput = document.getElementById('assurerNumeropiece');
        if (numeropieceInput) numeropieceInput.value = '';

        const professionSelect = document.getElementById('assurerProfession');
        if (professionSelect) professionSelect.value = '';

        const lieuNaissanceSelect = document.getElementById('assurerLieunaissance');
        if (lieuNaissanceSelect) lieuNaissanceSelect.value = '';

        const lieuResidenceSelect = document.getElementById('assurerLieuresidence');
        if (lieuResidenceSelect) lieuResidenceSelect.value = '';

        const dateNaissanceInput = document.getElementById('assurerDatenaissance');
        if (dateNaissanceInput) dateNaissanceInput.value = '';

        const employeurSelect = document.getElementById('assurerEmployeur');
        if (employeurSelect) employeurSelect.value = '';

        const fileInput = document.getElementById('justifResidence');
        if (fileInput) fileInput.value = '';

        const emailInput = document.getElementById('assurerEmail');
        if (emailInput) emailInput.value = '';

        const telephoneInput = document.getElementById('assurerTelephone');
        if (telephoneInput) telephoneInput.value = '';

        const telephone1Input = document.getElementById('assurerTelephone1');
        if (telephone1Input) telephone1Input.value = '';

        const mobileInput = document.getElementById('assurerMobile');
        if (mobileInput) mobileInput.value = '';

        const indexInput = document.getElementById('assurerIndex');
        if (indexInput) indexInput.value = '-1';

        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }

    function fermerEtReinitialiserModal() {
        console.log("fermerEtReinitialiserModal");
        resetModalForm();
        const modalElement = document.getElementById('createAssurerModal');
        if (modalElement) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        }
    }

    // ============================================================
    //                  INITIALISATION
    // ============================================================

    function initialiserTableauAssures() {
        const radioOui = document.getElementById('estAssureOui');
        const radioNon = document.getElementById('estAssureNon');

        chargerAssures();

        if (radioOui) {
            radioOui.checked = true;
            radioOui.disabled = true;
        }
        if (radioNon) {
            radioNon.disabled = true;
        }
    }

    // ============================================================
    //                  OBSERVATEUR POUR L'ÉTAPE 2
    // ============================================================

    function observerEtape2() {
        const step2 = document.querySelector('.step[data-step="2"]');
        if (!step2) {
            console.warn("⚠️ Étape 2 non trouvée dans le DOM");
            return;
        }

        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    if (step2.classList.contains('active')) {
                        console.log("📌 Étape 2 activée, chargement des assurés...");
                        chargerAssures();
                    }
                }
            });
        });

        observer.observe(step2, {
            attributes: true
        });
        console.log("👁️ Observateur de l'étape 2 mis en place");
    }

    // ============================================================
    //                  EXPOSITION DES FONCTIONS GLOBALES
    // ============================================================

    window.chargerAssures = chargerAssures;
    window.recalculerPrime = recalculerPrime;
    window.supprimerLigne = supprimerLigne;
    window.ajouterAssure = ajouterAssure;
    window.finaliserAjout = finaliserAjout;
    window.fermerEtReinitialiserModal = fermerEtReinitialiserModal;
    window.resetModalForm = resetModalForm;
    window.initialiserTableauAssures = initialiserTableauAssures;
    window.getSouscriptionData = getSouscriptionData;
    window.saveSouscriptionData = saveSouscriptionData;
    window.observerEtape2 = observerEtape2;

    // ============================================================
    //                  ÉVÉNEMENTS DOM (après exposition)
    // ============================================================

    document.addEventListener('DOMContentLoaded', function() {
        console.log("🚀 DOM chargé, initialisation des événements...");

        const storeAssurerBtn = document.getElementById('storeAssurerBtn');
        const assurerForm = document.getElementById('assurerFormInphb');

        observerEtape2();
        initialiserTableauAssures();

        document.addEventListener('hidden.bs.modal', function(event) {
            if (event.target.id === 'createAssurerModal') {
                resetModalForm();
            }
        });

        if (storeAssurerBtn) {
            // Supprimer les anciens listeners pour éviter les doublons
            storeAssurerBtn.removeEventListener('click', handleStoreAssurer);
            storeAssurerBtn.addEventListener('click', handleStoreAssurer);
        }

        function handleStoreAssurer() {
            console.log("📌 Bouton d'ajout d'assuré cliqué");

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

            console.log("📌 Données de l'assuré depuis form add:", formData);

            // if (!assurerForm || !assurerForm.checkValidity()) {
            //     if (assurerForm) assurerForm.reportValidity();
            //     return;
            // }

            console.log("📌 Ajout de l'assuré after verif ...");


            // Appeler la fonction ajouterAssure depuis le scope global
            if (typeof window.ajouterAssure === 'function') {
                console.log("✅ window.ajouterAssure est une fonction");
                const resultat = window.ajouterAssure(formData);
                console.log("📌 Résultat de l'ajout:", resultat);

                if (resultat === true) {
                    fermerEtReinitialiserModal();
                }
            } else {
                console.error("❌ window.ajouterAssure n'est pas une fonction !");
            }

            console.log("📌 Fin de l'ajout de l'assuré");
        }

        if (document.querySelector('.step[data-step="2"]')?.classList.contains('active')) {
            chargerAssures();
        }

        console.log("✅ Script stepAssurer chargé avec succès");
        console.log("✅ Fonction ajouterAssure exposée:", typeof window.ajouterAssure);
    });
</script>
