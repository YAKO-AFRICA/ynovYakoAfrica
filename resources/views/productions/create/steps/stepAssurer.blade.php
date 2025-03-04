<div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
    <h5 class="mb-1">Informations de l'assuré(e)</h5>
    <p class="mb-4">Veuillez entrer les informations relatives à l'assuré(e) en tenant compte des champs obligatoire.
    </p>
    @php
        $GarantiesOptionnelles = $productGarantie->where('estobligatoire', 0)->all();
        // dd($GarantiesOptionnelles);
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



        {{-- @if ($CodeProduit != 'ASSCPTBNI' && Auth::user()->codepartenaire == 'DIFIN') --}}
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">
            <!-- Button trigger modal -->
            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#createPropositionModal"><i
                    class="fadeIn animated bx bx-plus"></i>Ajouter un(e) autre
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
                @if (!empty($GarantiesOptionnelles))
                    <td>
                        <ul>
                            @foreach ($GarantiesOptionnelles as $item)
                                <li>
                                    <label class="form-label">
                                        Souhaitez-vous souscrire à la garantie {{ $item->libelle }} ?
                                    </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            name="GarantiesOptionnelles[{{ $item->id }}]"
                                            id="OuiGarantiesOptionnelles{{ $item->id }}" value="Oui">
                                        <label class="form-check-label"
                                            for="OuiGarantiesOptionnelles{{ $item->id }}">Oui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            name="GarantiesOptionnelles[{{ $item->id }}]"
                                            id="NonGarantiesOptionnelles{{ $item->id }}" value="Non">
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

{{-- <script>
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
        });



    function ajouterAssureTemporaire() {
        console.log("La fonction ajouterAssureTemporaire a été appelée.");
        
        const nomElement = document.getElementById('nomAssur');
        const prenomElement = document.getElementById('prenomAssur');
        const civiliteElement = document.querySelector('input[name="civiliteAssur"]:checked');
        const civiliteElementAll = document.querySelector('input[name="civiliteAssur"]');
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


        if (nom && prenom && civilite && datenaissance) {
            assures.push({ nom, prenom, civilite,datenaissance, lieuNaissance, naturepieceAssur, lieuresidenceAssur, lienParente, mobileAssur, emailAssur });
            console.log("Assuré ajouté :", assures);
            nomElement.classList.add('is-valid');
            nomElement.classList.remove('is-invalid');
            prenomElement.classList.add('is-valid'); 
            prenomElement.classList.remove('is-invalid');
            civiliteElementAll.classList.add('is-valid'); 
            civiliteElementAll.classList.remove('is-invalid');
            dateElement.classList.add('is-valid');
            dateElement.classList.remove('is-invalid');

            lieuNaissanceElement.classList.add('is-valid'); 
            lieuNaissanceElement.classList.remove('is-invalid'); 
            naturepieceAssurElement.classList.add('is-valid'); 
            naturepieceAssurElement.classList.remove('is-invalid'); 
            lieuresidenceAssurElement.classList.add('is-valid'); 
            lieuresidenceAssurElement.classList.remove('is-invalid'); 
            lienParenteElement.classList.add('is-valid'); 
            lienParenteElement.classList.remove('is-invalid'); 
            mobileAssurElement.classList.add('is-valid'); 
            mobileAssurElement.classList.remove('is-invalid'); 
            emailAssurElement.classList.add('is-valid'); 
            emailAssurElement.classList.remove('is-invalid'); 
            
            nomElement.value = '';
            prenomElement.value = '';
            civiliteElement.checked = false;
            dateElement.value = '';
            lieuNaissanceElement.value = '';
            naturepieceAssurElement.value = '';
            lieuresidenceAssurElement.value = '';
            lienParenteElement.value = '';
            mobileAssurElement.value = '';
            emailAssurElement.value = '';
            afficherAssures();
            
            $('#createPropositionModal').modal('hide');
            
        }else{
            // alert("Veuillez remplir tous les champs obligatoires.");
            // Ajouter une bordure rouge à chaque champ obligatoire non rempli
                nomElement.classList.add('is-invalid');
                nomElement.classList.remove('is-valid');
                prenomElement.classList.add('is-invalid');
                prenomElement.classList.remove('is-valid');
                civiliteElementAll.classList.add('is-invalid');
                civiliteElementAll.classList.remove('is-valid');
                dateElement.classList.add('is-invalid');
                dateElement.classList.remove('is-valid');
                lieuNaissanceElement.classList.add('is-valid');
                lieuNaissanceElement.classList.remove('is-invalid'); 
                naturepieceAssurElement.classList.add('is-valid'); 
                naturepieceAssurElement.classList.remove('is-invalid'); 
                lieuresidenceAssurElement.classList.add('is-valid'); 
                lieuresidenceAssurElement.classList.remove('is-invalid'); 
                lienParenteElement.classList.add('is-valid'); 
                lienParenteElement.classList.remove('is-invalid'); 
                mobileAssurElement.classList.add('is-valid'); 
                mobileAssurElement.classList.remove('is-invalid'); 
                emailAssurElement.classList.add('is-valid');
                emailAssurElement.classList.remove('is-invalid');
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
</script> --}}

<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     console.log("DOM entièrement chargé");

    //     let assures = [];

    //     const boutonAjouter = document.getElementById('btn-ajouter');
    //     if (boutonAjouter) {
    //         boutonAjouter.addEventListener('click', ajouterAssureTemporaire);
    //     } else {
    //         console.error("Le bouton 'Ajouter' n'a pas été trouvé.");
    //     }

    //     const form = document.querySelector('form');
    //     if (form) {
    //         form.addEventListener('submit', function(event) {
    //             const assuresInput = document.createElement('input');
    //             assuresInput.type = 'hidden';
    //             assuresInput.name = 'assures';
    //             assuresInput.value = JSON.stringify(assures);
    //             form.appendChild(assuresInput);
    //         });
    //     }

    //     function ajouterAssureTemporaire() {
    //         console.log("La fonction ajouterAssureTemporaire a été appelée.");

    //         const nomElement = document.getElementById('nomAssur');
    //         const prenomElement = document.getElementById('prenomAssur');
    //         const civiliteElement = document.querySelector('input[name="civiliteAssur"]:checked');
    //         const civiliteElementAll = [...document.querySelectorAll('.civiliteAssur')];
    //         const dateElement = document.getElementById('datenaissanceAssur');
    //         const lieuNaissanceElement = document.getElementById('lieunaissanceAssur');
    //         const naturepieceAssurElement = document.getElementById('naturepieceAssur');
    //         const naturepieceAssurElementAll = [...document.querySelectorAll('.naturepieceAssur')];
    //         const lieuresidenceAssurElement = document.getElementById('lieuresidenceAssur');
    //         const lienParenteElement = document.getElementById('lienParente');
    //         const mobileAssurElement = document.getElementById('mobileAssur');
    //         const emailAssurElement = document.getElementById('emailAssur');

    //         // if (!nomElement || !prenomElement || !dateElement) {
    //         //     console.error("Un ou plusieurs éléments du formulaire sont introuvables.");
    //         //     return;
    //         // }
    //         let selectedCivilite;
    //         let selectedNaturepieceAssur;

    //         const nom = nomElement.value.trim();
    //         const prenom = prenomElement.value.trim();
    //         const civilite = civiliteElement ? civiliteElement.value : '';
    //         const datenaissance = dateElement.value.trim();
    //         const lieuNaissance = lieuNaissanceElement ? lieuNaissanceElement.value.trim() : '';
    //         const naturepieceAssur = naturepieceAssurElement ? naturepieceAssurElement.value.trim() : '';
    //         const lieuresidenceAssur = lieuresidenceAssurElement ? lieuresidenceAssurElement.value.trim() : '';
    //         const lienParente = lienParenteElement ? lienParenteElement.value.trim() : '';
    //         const mobileAssur = mobileAssurElement ? mobileAssurElement.value.trim() : '';
    //         const emailAssur = emailAssurElement ? emailAssurElement.value.trim() : '';

    //         if (civiliteElementAll) {
    //             civiliteElementAll.forEach(function(element) {
    //                 element.classList.add('is-valid');
    //                 element.classList.remove('is-invalid');
    //                 if (element.checked) {
    //                     selectedCivilite = element.value;
    //                     element.classList.add('is-valid');
    //                     element.classList.remove('is-invalid');

    //                 } else {
    //                     selectedCivilite = '';
    //                     element.classList.remove('is-valid');
    //                     element.classList.add('is-invalid');
    //                 }
    //             });
    //         } else if (nomElement) {
    //             if (!nom) {
    //                 nomElement.classList.add('is-invalid')
    //                 nomElement.classList.remove('is-valid')
    //             } else {
    //                 nomElement.classList.remove('is-invalid')
    //                 nomElement.classList.add('is-valid')
    //             }
    //         } else if (prenomElement) {
    //             if (!prenom) {
    //                 prenomElement.classList.add('is-invalid')
    //                 prenomElement.classList.remove('is-valid')
    //             } else {
    //                 prenomElement.classList.remove('is-invalid')
    //                 prenomElement.classList.add('is-valid')
    //             }
    //         } else if (dateElement) {
    //             if (!datenaissance) {
    //                 dateElement.classList.add('is-invalid')
    //                 dateElement.classList.remove('is-valid')
    //             } else {
    //                 dateElement.classList.remove('is-invalid')
    //                 dateElement.classList.add('is-valid')
    //             }
    //         } else {
    //             if (nom, prenom, civilite, datenaissance) {

    //                 assures.push({
    //                     nom,
    //                     prenom,
    //                     civilite,
    //                     datenaissance,
    //                     lieuNaissance,
    //                     naturepieceAssur,
    //                     lieuresidenceAssur,
    //                     lienParente,
    //                     mobileAssur,
    //                     emailAssur
    //                 });
    //                 console.log("Assuré ajouté :", assures);
    //                 nomElement.value = '';
    //                 prenomElement.value = '';
    //                 civiliteElement.checked = false;
    //                 dateElement.value = '';
    //                 if (lieuNaissanceElement) lieuNaissanceElement.value = '';
    //                 if (naturepieceAssurElement) naturepieceAssurElement.checked = false;
    //                 if (lieuresidenceAssurElement) lieuresidenceAssurElement.value = '';
    //                 if (lienParenteElement) lienParenteElement.value = '';
    //                 if (mobileAssurElement) mobileAssurElement.value = '';
    //                 if (emailAssurElement) emailAssurElement.value = '';
    //                 [nomElement, prenomElement, dateElement, lieuNaissanceElement, lieuresidenceAssurElement,
    //                     lienParenteElement, mobileAssurElement, emailAssurElement
    //                 ].forEach(el => {
    //                     el.classList.remove('is-valid');
    //                     el.classList.remove('is-invalid');
    //                 });
    //                 civiliteElementAll.forEach(function(element) {
    //                     if (element.checked) {
    //                         element.classList.remove('is-valid');
    //                         element.classList.remove('is-invalid');
    //                     } else {
    //                         element.classList.remove('is-valid');
    //                         element.classList.remove('is-invalid');
    //                     }
    //                 });
    //                 // naturepieceAssurElement.forEach(function(element) {
    //                 //     if (element.checked) {
    //                 //         element.classList.add('is-valid');
    //                 //     } else {
    //                 //         element.classList.add('is-valid');
    //                 //     }
    //                 // })
    //                 afficherAssures();
    //                 $('#createPropositionModal').modal('hide');
    //             }

    //         };
    //     }

    //     function afficherAssures() {
    //         const tbody = document.querySelector('#test-l-2 tbody');

    //         if (!tbody) {
    //             console.error("Le tbody pour afficher les assurés n'a pas été trouvé.");
    //             return;
    //         }

    //         tbody.innerHTML = '';

    //         assures.forEach((assure, index) => {
    //             const row = `
    //             <tr>
    //                 <td>${assure.nom} ${assure.prenom}</td>
    //                 <td>
    //                     <ul>
    //                         @foreach ($productGarantie->where('estobligatoire', 1) as $item)
    //                             <li>{{ $item->libelle }}</li>
    //                         @endforeach
    //                     </ul>
    //                 </td>
    //                 <td>Pas de garantie</td>
    //                 <td>
    //                     <a href="#" onclick="supprimerAssure(${index})" class="text-danger">
    //                         <i class="fadeIn animated bx bx-x fs-4"></i>
    //                     </a>
    //                 </td>
    //             </tr>`;
    //             tbody.innerHTML += row;
    //         });

    //         if (assures.length > 0) {
    //             const dernierAssure = assures[assures.length - 1];

    //             document.getElementById('display-nom-assure').textContent = dernierAssure.nom || '-';
    //             document.getElementById('display-prenom-assure').textContent = dernierAssure.prenom || '-';
    //             document.getElementById('display-date-naissance-assure').textContent = dernierAssure
    //                 .datenaissance || '-';
    //             document.getElementById('display-lieu-naissance-assure').textContent = dernierAssure
    //                 .lieuNaissance || '-';
    //             document.getElementById('display-lieu-residence-assure').textContent = dernierAssure
    //                 .lieuresidenceAssur || '-';
    //             document.getElementById('display-telephone-assure').textContent = dernierAssure.mobileAssur ||
    //                 '-';
    //             document.getElementById('display-email-assure').textContent = dernierAssure.emailAssur || '-';
    //             document.getElementById('display-numeropiece-assure').textContent = dernierAssure
    //                 .naturepieceAssur || '-';
    //         }
    //     }

    //     function supprimerAssure(index) {
    //         assures.splice(index, 1);
    //         afficherAssures();
    //     }

    //     window.ajouterAssureTemporaire = ajouterAssureTemporaire;
    //     window.supprimerAssure = supprimerAssure;
    //     afficherAssures();
    // });
    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOM entièrement chargé");

        let assures = [];

        const boutonAjouter = document.getElementById('btn-ajouter');
        if (boutonAjouter) {
            boutonAjouter.addEventListener('click', ajouterAssureTemporaire);
        } else {
            console.error("Le bouton 'Ajouter' n'a pas été trouvé.");
        }

        // const form = document.querySelector('form');
        // if (form) {
        //     form.addEventListener('submit', function(event) {
        //         const assuresInput = document.createElement('input');
        //         assuresInput.type = 'hidden';
        //         assuresInput.name = 'assures';
        //         assuresInput.value = JSON.stringify(assures);
        //         console.log('Input assure', assuresInput)
        //         form.appendChild(assuresInput);
        //     });
        // }

        function ajouterAssureTemporaire() {
            console.log("La fonction ajouterAssureTemporaire a été appelée.");

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

            // Validation des champs obligatoires
            if (!validateField(nomElement, nom) ||
                !validateField(prenomElement, prenom) ||
                !validateField(dateElement, datenaissance) ||
                !validateFieldRadio(civiliteElementAll, civilite)) {
                return; // Stop si un champ obligatoire est invalide
            }

            // Ajouter l'assuré temporaire
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

            const assuresInput = document.getElementById('assuresInput').value = JSON.stringify(assures);
            console.log("Assurés input :", assuresInput);

            console.log("Assuré ajouté :", assures);

            // Réinitialiser le formulaire
            resetForm(nomElement, prenomElement, dateElement, lieuNaissanceElement, lieuresidenceAssurElement,
                lienParenteElement, mobileAssurElement, emailAssurElement, numeropieceAssurElement);
            resetRadio(civiliteElementAll);
            resetRadio(naturepieceAssurElementAll);

            afficherAssures();
            $('#createPropositionModal').modal('hide');
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

        // Validation spécifique pour les boutons radio
        function validateFieldRadio(elements, value) {
            if (!value) {
                elements.forEach(el => el.classList.add('is-invalid'));
                return false;
            } else {
                elements.forEach(el => el.classList.remove('is-invalid'));
                return true;
            }
        }

        // Récupération de la valeur sélectionnée pour Civilité
        function getCiviliteSelectedValue(elements) {
            for (let element of elements) {
                if (element.checked) {
                    return element.value;
                }
            }
            return ''; // Retourne une valeur vide si aucune option n'est sélectionnée
        }

        // Récupération de la valeur sélectionnée pour Nature de pièce
        function getNaturePieceSelectedValue(elements) {
            for (let element of elements) {
                if (element.checked) {
                    return element.value;
                }
            }
            return ''; // Retourne une valeur vide si aucune option n'est sélectionnée
        }

        // Réinitialisation des champs texte
        function resetForm(...elements) {
            elements.forEach(el => {
                if (el) {
                    el.value = '';
                    el.classList.remove('is-valid', 'is-invalid');
                }
            });
        }

        // Réinitialisation des boutons radio
        function resetRadio(elements) {
            elements.forEach(el => {
                el.checked = false;
                el.classList.remove('is-valid', 'is-invalid');
            });
        }

        function afficherAssures() {
            const tbody = document.querySelector('#test-l-2 tbody');
            const tbodyResume = document.querySelector('#resume-tbody-assure');

            if (!tbody) {
                console.error("Le tbody pour afficher les assurés n'a pas été trouvé.");
                return;
            }

            tbody.innerHTML = '';
            tbodyResume.innerHTML = '';

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
                    <td>Pas de garantie complementaire</td>
                    <td>
                        <a href="#" onclick="supprimerAssure(${index})" class="text-danger">
                            <i class="fadeIn animated bx bx-x fs-4"></i>
                        </a>
                    </td>
                </tr>`;
                tbody.innerHTML += row;
            });
            assures.forEach((assure, index) => {
                // const displayNom = document.getElementById('display-nom-assure');
                // const displayPrenom = document.getElementById('display-prenom-assure');
                // const displayDateNaissance = document.getElementById('display-date-naissance-assure');
                // const displayLieuNaissance = document.getElementById('display-lieu-naissance-assure');
                // const displayLieuResidence = document.getElementById('display-lieu-residence-assure');
                // const displayTelephone = document.getElementById('display-telephone-assure');
                // const displayEmail = document.getElementById('display-email-assure');
                // const displayNumeropiece = document.getElementById('display-numeropiece-assure');
                // const displayFiliation = document.getElementById('display-filiation-assure');

                // displayNom.textContent = assure.nom;
                // displayPrenom.textContent = assure.prenom;
                // displayDateNaissance.textContent = assure.datenaissance;
                // displayLieuNaissance.textContent = assure.lieuNaissance || '-';
                // displayLieuResidence.textContent = assure.lieuresidenceAssur;
                // displayTelephone.textContent = assure.mobileAssur || '-';
                // displayEmail.textContent = assure.emailAssur;
                // displayNumeropiece.textContent = assure.naturepieceAssur || '-';
                // displayFiliation.textContent = assure.lienParente || '-';

                // console.log("aasssssssssssssssssssssssss", assure);
                const Datarow = `
                <tr>
                    <td>${assure.nom || '-'}</td>
                    <td>${assure.prenom || '-'}</td>
                    <td>${assure.datenaissance || '-'}</td>
                    <td>${assure.lieuNaissance || '-'}</td>
                    <td>${assure.lieuresidenceAssur}</td>
                    <td>${assure.lienParente || '-'}</td>
                    <td>
                        <ul>
                            @foreach ($productGarantie->where('estobligatoire', 1) as $item)
                                <li>{{ $item->libelle }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>${assure.mobileAssur || '-'}</td>
                    <td>${assure.emailAssur}</td>
                    <td>${assure.numeropieceAssur || '-'}</td>
                </tr>`;
                tbodyResume.innerHTML += Datarow;
            });
        }

        function supprimerAssure(index) {
            assures.splice(index, 1);
            const assuresInput = document.getElementById('assuresInput').value = JSON.stringify(assures);
            console.log("Assurés input :", assuresInput);
            afficherAssures();
        }

        window.ajouterAssureTemporaire = ajouterAssureTemporaire;
        window.supprimerAssure = supprimerAssure;

        // Affichez initialement les assurés
        afficherAssures();

    });
</script>


{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM entièrement chargé");

    let assures = [];

    const boutonAjouter = document.getElementById('btn-ajouter');
    const form = document.querySelector('form');

    if (boutonAjouter) {
        boutonAjouter.addEventListener('click', ajouterAssureTemporaire);
    } else {
        console.error("Le bouton 'Ajouter' n'a pas été trouvé.");
    }

    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            if (assures.length === 0) {
                alert("Veuillez ajouter au moins un assuré.");
                return;
            }

            const assuresInput = document.createElement('input');
            assuresInput.type = 'hidden';
            assuresInput.name = 'assures';
            assuresInput.value = JSON.stringify(assures);
            form.appendChild(assuresInput);

            form.submit(); // Envoi du formulaire après validation
        });
    }

    function ajouterAssureTemporaire() {
        console.log("Ajout d'un assuré...");

        const nomElement = document.getElementById('nomAssur');
        const prenomElement = document.getElementById('prenomAssur');
        const civiliteElements = document.querySelectorAll('input[name="civiliteAssur"]');
        const dateElement = document.getElementById('datenaissanceAssur');
        const lieuNaissanceElement = document.getElementById('lieunaissanceAssur');
        const naturepieceAssurElement = document.getElementById('naturepieceAssur');
        const lieuresidenceAssurElement = document.getElementById('lieuresidenceAssur');
        const lienParenteElement = document.getElementById('lienParente');
        const mobileAssurElement = document.getElementById('mobileAssur');
        const emailAssurElement = document.getElementById('emailAssur');

        const nom = nomElement?.value.trim();
        const prenom = prenomElement?.value.trim();
        const civilite = [...civiliteElements].find(el => el.checked)?.value || "";
        const datenaissance = dateElement?.value;
        const lieuNaissance = lieuNaissanceElement?.value.trim();
        const naturepieceAssur = naturepieceAssurElement?.value.trim();
        const lieuresidenceAssur = lieuresidenceAssurElement?.value.trim();
        const lienParente = lienParenteElement?.value.trim();
        const mobileAssur = mobileAssurElement?.value.trim();
        const emailAssur = emailAssurElement?.value.trim();

        // Validation des champs obligatoires
        let isValid = true;

        if (!nom) {
            isValid = false;
            afficherErreur(nomElement, "Le nom est requis.");
        } else {
            enleverErreur(nomElement);
        }

        if (!prenom) {
            isValid = false;
            afficherErreur(prenomElement, "Le prénom est requis.");
        } else {
            enleverErreur(prenomElement);
        }

        if (!civilite) {
            isValid = false;
            civiliteElements.forEach(el => el.classList.add('is-invalid'));
        } else {
            civiliteElements.forEach(el => el.classList.remove('is-invalid'));
        }

        if (!datenaissance) {
            isValid = false;
            afficherErreur(dateElement, "La date de naissance est requise.");
        } else {
            enleverErreur(dateElement);
        }

        if (!isValid) {
            console.warn("Certains champs obligatoires sont manquants.");
            return;
        }

        // Ajout à la liste des assurés
        assures.push({
            nom,
            prenom,
            civilite,
            datenaissance,
            lieuNaissance,
            naturepieceAssur,
            lieuresidenceAssur,
            lienParente,
            mobileAssur,
            emailAssur
        });

        console.log("Assuré ajouté :", assures);

        // Réinitialisation des champs après ajout
        resetForm();

        // Affichage des assurés
        afficherAssures();

        // Fermeture du modal
        $('#createPropositionModal').modal('hide');
    }

    function afficherAssures() {
        const tbody = document.querySelector('#test-l-2 tbody');

        if (!tbody) {
            console.error("Le tbody pour afficher les assurés n'a pas été trouvé.");
            return;
        }

        tbody.innerHTML = assures.map((assure, index) => `
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
        `).join('');

        if (assures.length > 0) {
            const assure = assures[assures.length - 1]; // Dernier assuré ajouté
            document.getElementById('display-nom-assure')?.textContent = assure.nom;
            document.getElementById('display-prenom-assure')?.textContent = assure.prenom;
            document.getElementById('display-date-naissance-assure')?.textContent = assure.datenaissance;
            document.getElementById('display-lieu-naissance-assure')?.textContent = assure.lieuNaissance || "-";
            document.getElementById('display-lieu-residence-assure')?.textContent = assure.lieuresidenceAssur;
            document.getElementById('display-telephone-assure')?.textContent = assure.mobileAssur || "-";
            document.getElementById('display-email-assure')?.textContent = assure.emailAssur;
            document.getElementById('display-numeropiece-assure')?.textContent = assure.naturepieceAssur || "-";
        }
    }

    function supprimerAssure(index) {
        assures.splice(index, 1);
        afficherAssures();
    }

    function resetForm() {
        document.getElementById('nomAssur').value = "";
        document.getElementById('prenomAssur').value = "";
        document.querySelectorAll('input[name="civiliteAssur"]').forEach(el => el.checked = false);
        document.getElementById('datenaissanceAssur').value = "";
        document.getElementById('lieunaissanceAssur').value = "";
        document.getElementById('naturepieceAssur').value = "";
        document.getElementById('lieuresidenceAssur').value = "";
        document.getElementById('lienParente').value = "";
        document.getElementById('mobileAssur').value = "";
        document.getElementById('emailAssur').value = "";
    }

    function afficherErreur(element, message) {
        element.classList.add('is-invalid');
        let feedback = element.nextElementSibling;
        if (!feedback || !feedback.classList.contains('invalid-feedback')) {
            feedback = document.createElement('div');
            feedback.classList.add('invalid-feedback');
            element.parentNode.appendChild(feedback);
        }
        feedback.textContent = message;
    }

    function enleverErreur(element) {
        element.classList.remove('is-invalid');
        let feedback = element.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.textContent = "";
        }
    }

    window.supprimerAssure = supprimerAssure;
    afficherAssures();
});

// [lieuNaissanceElement, lieuresidenceAssurElement,
                        //     lienParenteElement, mobileAssurElement, emailAssurElement
                        // ].forEach(el => {
                        //     el.classList.remove('is-valid');
                        // });
                        // naturepieceAssurElement.forEach(function(element) {
                        //     if (element.checked) {
                        //         selectedNaturePiece = element.value;
                        //         element.classList.add('is-valid');
                        //     } else {
                        //         selectedNaturePiece = '';
                        //         element.classList.add('is-valid');
                        //     }
                        // })

            // if (nom && prenom && civilite && datenaissance) {


            // [nomElement, prenomElement, dateElement, civiliteElementAll,lieuNaissanceElement, naturepieceAssurElement, lieuresidenceAssurElement, lienParenteElement, mobileAssurElement, emailAssurElement].forEach(el => {
            //     el.classList.add('is-valid');
            //     el.classList.remove('is-invalid');
            // });


            // } else {
            // if(!nom){
            //     nomElement.classList.add('is-invalid')
            // }else if(!prenom){
            //     prenomElement.classList.add('is-invalid')
            // }else if(!dateElement){
            //     dateElement.classList.add('is-invalid')
            // } ;
            // [nomElement, prenomElement, dateElement].forEach(el => {
            //     el.classList.add('is-invalid');
            //     el.classList.remove('is-valid');
            // });
            // civiliteElementAll.forEach(function(element) {
            //     if (element.checked) {
            //         selectedCivilite = element.value;
            //         element.classList.add('is-valid');
            //         element.classList.remove('is-invalid');
            //     }else{
            //         selectedCivilite = '';
            //         element.classList.remove('is-valid');
            //         element.classList.add('is-invalid');
            //     }
            // });
            // if(!lieuNaissance|| lieuNaissance)lieuNaissanceElement.classList.add('is-valid');
            // if(!lieuresidenceAssur|| lieuresidenceAssur)lieuresidenceAssurElement.classList.add('is-valid');
            // if(!lienParente|| lienParente)lienParenteElement.classList.add('is-valid');
            // if(!mobileAssur|| mobileAssur)mobileAssurElement.classList.add('is-valid');
            // if(!emailAssur|| emailAssur)emailAssurElement.classList.add('is-valid');

            // naturepieceAssurElement.forEach(function(element) {
            //     if (element.checked) {
            //         selectedNaturePiece = element.value;
            //         element.classList.add('is-valid');
            //     }else{
            //         selectedNaturePiece = '';
            //         element.classList.add('is-valid');
            //     }
            // })
            // [lieuNaissanceElement, lieuresidenceAssurElement, lienParenteElement, mobileAssurElement, emailAssurElement].forEach(el => {
            //     el.classList.add('is-valid');
            //     el.classList.remove('is-invalid');
            // });
            // }
</script> --}}
