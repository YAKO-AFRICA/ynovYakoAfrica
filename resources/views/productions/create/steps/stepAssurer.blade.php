<div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
    <h5 class="mb-1">Informations de l'assuré(e)</h5>
    <p class="mb-4">Veuillez entrer les informations relatives à l'assuré(e) en tenant compte des champs obligatoire.</p>

    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-6">
            <label for="" class="form-label">Le souscripteur est-il l'assuré ? <span class="text-danger">*</span></label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estAssure" id="Oui" value="Oui" required>
                <label class="form-check-label" for="Oui">Oui</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estAssure" id="Non" value="Non">
                <label class="form-check-label" for="Non">Non</label>
            </div>
        </div>
        
        

        {{-- @if ($CodeProduit != "ASSCPTBNI" && Auth::user()->codepartenaire == "DIFIN") --}}
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">
            <!-- Button trigger modal -->
            <button type="button" class="btn" data-bs-toggle="modal"
                data-bs-target="#createPropositionModal"><i class="fadeIn animated bx bx-plus"></i>Ajouter un(e) autre
                assuré(e)</button>
            <!-- Modal -->
        </div>
        {{-- @endif --}}
        
        
    </div>
    
    <table class="table mb-0 table-striped">
        <thead>
            <tr>
                <th scope="col">Assuré(e)</th>
                <th scope="col">Garanties</th>
                <th scope="col">Garanties complementaires</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        
        <tbody>
            {{-- coàntenue dynamique --}}
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
                @if($product->CodeProduit == "PFA_IND")
                <td>
                    <label for="" class="form-label">Souhaitez-vous souscrire à la garantie SURETE ?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="garantieSurete" id="OuiGarantieSurete" value="Oui">
                        <label class="form-check-label" for="OuiGarantieSurete">Oui</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="garantieSurete" id="NonGarantieSurete" value="Non">
                        <label class="form-check-label" for="NonGarantieSurete">Non</label>
                    </div>
                </td>
                
                @else
                    <td>Pas de garantie</td> 
                @endif
                <td></td>
            </tr>
        </tfoot>
        
    </table>
    
    
    <div class="row g-3">
        {{-- <div class="col-12"> --}}
            <div class="d-flex align-items-center justify-content-between gap-3">
                <button onclick="event.preventDefault(); stepper1.previous()" class="btn border-btn btn-previous-form"><i
                        class='bx bx-left-arrow-alt'></i>Precedent</button>
                <button onclick="event.preventDefault(); stepper1.next()" class="btn btn-two btn-next-form">Suivant<i
                        class='bx bx-right-arrow-alt'></i></button>
            </div>
        {{-- </div> --}}
    </div>
    <!---end row-->

</div>

<script>
    // step assure js code 
    document.getElementById('FisrtName').addEventListener('input', updateDisplay);
    document.getElementById('LastName').addEventListener('input', updateDisplay);

    function updateDisplay() {
        const nom = document.getElementById('FisrtName').value;
        const prenom = document.getElementById('LastName').value;
        document.getElementById('display-nom-prenom').textContent = nom && prenom ? `${nom} ${prenom}` : ' ';
    }
    
    document.getElementById('Oui').addEventListener('change', toggleRowDisplay);
    document.getElementById('Non').addEventListener('change', toggleRowDisplay);

    function toggleRowDisplay() {
        const isAssureOui = document.getElementById('Oui').checked;
        const row = document.getElementById('conditional-tr');
        row.style.display = isAssureOui ? 'table-row' : 'none';
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM entièrement chargé");

    // Tableau pour stocker temporairement les assurés
    let assures = [];

    const boutonAjouter = document.getElementById('btn-ajouter');
    if (boutonAjouter) {
        // console.log("Le bouton 'Ajouter' a été trouvé.");
        boutonAjouter.addEventListener('click', ajouterAssureTemporaire);
    } else {
        console.error("Le bouton 'Ajouter' n'a pas été trouvé.");
    }

    const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            const assuresInput = document.createElement('input');
            assuresInput.type = 'hidden';

            assuresInput.name = 'assures';
            assuresInput.value = JSON.stringify(assures); // Convertir le tableau en JSON
            
            form.appendChild(assuresInput);
            form.reset();
        });

    function ajouterAssureTemporaire() {
        console.log("La fonction ajouterAssureTemporaire a été appelée.");
        
        const nomElement = document.getElementById('nomAssur');
        const prenomElement = document.getElementById('prenomAssur');
        const civiliteElement = document.querySelector('input[name="civiliteAssur"]:checked');
        const dateElement = document.getElementById('datenaissanceAssur');
        const lieuNaissanceElement = document.getElementById('lieunaissanceAssur');
        const naturepieceAssurElement = document.getElementById('naturepieceAssur');
        const lieuresidenceAssurElement = document.getElementById('lieuresidenceAssur');
        const lienParenteElement = document.getElementById('lienParente');
        const mobileAssurElement = document.getElementById('mobileAssur');
        const emailAssurElement = document.getElementById('emailAssur');
        
        const nom = nomElement ? nomElement.value : null;
        const prenom = prenomElement ? prenomElement.value : null;
        const civilite = civiliteElement ? civiliteElement.value : null;
        const datenaissance = dateElement ? dateElement.value : null;
        const lieuNaissance = lieuNaissanceElement ? lieuNaissanceElement.value : null;
        const naturepieceAssur = naturepieceAssurElement ? naturepieceAssurElement.value : null;
        const lieuresidenceAssur = lieuresidenceAssurElement ? lieuresidenceAssurElement.value : null;
        const lienParente = lienParenteElement ? lienParenteElement.value : null;
        const mobileAssur = mobileAssurElement ? mobileAssurElement.value : null;
        const emailAssur = emailAssurElement ? emailAssurElement.value : null;


        if (nom && prenom && civilite) {
            assures.push({ nom, prenom, civilite,datenaissance, lieuNaissance, naturepieceAssur, lieuresidenceAssur, lienParente, mobileAssur, emailAssur });
            console.log("Assuré ajouté :", assures);
            afficherAssures();
            
            $('#createPropositionModal').modal('hide');
            
        }
    }

    function afficherAssures() {
        const tbody = document.querySelector('#test-l-2 tbody');

        if (!tbody) {
            console.error("Le tbody pour afficher les assurés n'a pas été trouvé.");
            return;
        }

        tbody.innerHTML = '';

        assures.forEach((assure, index) => {
            const row = `   
            <tr>
                <td>${assure.nom} ${assure.prenom}</td>
                <td>
                    <ul>
                        @foreach ($productGarantie->where('estobligatoire', 1) as $item)
                            <li>{{ $item->libelle }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>Pas de garantie</td>
                <td><a href="#" onclick="supprimerAssure(${index})" class="text-danger"><i class="fadeIn animated bx bx-x fs-4"></i></a></td>
            </tr>
            `;
            tbody.innerHTML += row;
        });

        assures.forEach((assure, index) => {
            const displayNom = document.getElementById('display-nom-assure');
            const displayPrenom = document.getElementById('display-prenom-assure');
            const displayDateNaissance = document.getElementById('display-date-naissance-assure');
            const displayLieuNaissance = document.getElementById('display-lieu-naissance-assure');
            const displayLieuResidence = document.getElementById('display-lieu-residence-assure');
            const displayTelephone = document.getElementById('display-telephone-assure');
            const displayEmail = document.getElementById('display-email-assure');
            const displayNumeropiece = document.getElementById('display-numeropiece-assure');

            displayNom.textContent = assure.nom;
            displayPrenom.textContent = assure.prenom;
            displayDateNaissance.textContent = assure.datenaissance;
            displayLieuNaissance.textContent = assure.lieuNaissance || '-';
            displayLieuResidence.textContent = assure.lieuresidenceAssur;
            displayTelephone.textContent = assure.mobileAssur || '-';
            displayEmail.textContent = assure.emailAssur;
            displayNumeropiece.textContent = assure.naturepieceAssur || '-';

            console.log("aasssssssssssssssssssssssss",assure);
        });

    }

    function supprimerAssure(index) {
        assures.splice(index, 1);
        afficherAssures();
    }

    window.ajouterAssureTemporaire = ajouterAssureTemporaire;
    window.supprimerAssure = supprimerAssure;

    // Affichez initialement les assurés
    afficherAssures();
});
</script>
