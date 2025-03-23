@extends('layouts.main')

@section('content')

<style>
    fieldset {
    border: 1px solid #ddd; /* Bordure grise */
    padding: 1rem; /* Espacement interne */
    margin-bottom: 1rem; /* Espacement externe */
    border-radius: 5px; /* Coins arrondis */
    }

    legend {
        font-size: 1rem;
        padding: 0 10px; /* Espacement autour du texte de la légende */
        color: #333; /* Couleur du texte */
    }

    .input-group-text select {
        width: 100px; /* Largeur ajustée pour le sélecteur */
    }
    .is-valid {
  border: 2px solid green;
  }

</style>

<div class="productions">
    <div id="stepper1{{ $product->CodeProduit }}" class="bs-stepper">
        <div class="card">
            <div class="card-header">
                <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between" role="tablist">
                    <div class="step" data-target="#test-l-1">
                        <div class="step-trigger etape" role="tab" id="stepper1trigger1" aria-controls="test-l-1"> 
                            <div class="bs-stepper-circle">1</div>
                            <div class="text-center">
                                <p class="mb-0 steper-sub-title">Adhérent</p>
                            </div> 
                        </div> 
                    </div>
                    <div class="bs-stepper-line align-self-center"></div>
                    <div class="step" data-target="#test-l-2">
                        <div class="step-trigger etape" role="tab" id="stepper1trigger2" aria-controls="test-l-2">
                            <div class="bs-stepper-circle">2</div>
                            <div class="text-center">
                                <p class="mb-0 steper-sub-title">Assuré(e)s</p>
                            </div>
                        </div>
                    </div>
                    <div class="bs-stepper-line align-self-center"></div>
                    <div class="step" data-target="#test-l-3">
                        <div class="step-trigger etape" role="tab" id="stepper1trigger3" aria-controls="test-l-3">
                            <div class="bs-stepper-circle">3</div>
                            <div class="text-center">
                                <p class="mb-0 steper-sub-title">Bénéficiaires</p>
                            </div>
                        </div>
                    </div>
                    <div class="bs-stepper-line align-self-center"></div>
                    <div class="step" data-target="#test-l-4">
                        <div class="step-trigger etape" role="tab" id="stepper1trigger4" aria-controls="test-l-4">
                            <div class="bs-stepper-circle">4</div>
                            <div class="text-center">
                                <p class="mb-0 steper-sub-title">Paiement & Prériodicité</p>
                            </div>
                        </div>
                    </div>
    
                    <div class="bs-stepper-line align-self-center"></div>
                    <div class="step" data-target="#test-l-5">
                        <div class="step-trigger etape" role="tab" id="stepper1trigger5" aria-controls="test-l-5">
                            <div class="bs-stepper-circle">5</div>
                            <div class="text-center">
                                <p class="mb-0 steper-sub-title">Etat de santé</p>
                            </div>
                        </div>
                    </div>
                    <div class="bs-stepper-line align-self-center"></div>
                    <div class="step" data-target="#test-l-6">
                        <div class="step-trigger etape" role="tab" id="stepper1trigger6" aria-controls="test-l-6">
                            <div class="bs-stepper-circle">6</div>
                            <div class="text-center">
                                <p class="mb-0 steper-sub-title">Résumé</p>
                            </div>
                        </div>
                    </div>

                    <div class="bs-stepper-line align-self-center"></div>
                    <div class="step" data-target="#test-l-7">
                        <div class="step-trigger etape" role="tab" id="stepper1trigger7" aria-controls="test-l-7">
                            <div class="bs-stepper-circle">7</div>
                            <div class="text-center">
                                <p class="mb-0 steper-sub-title">Documents</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    
            <div class="card-body productions">
                <div class="bs-stepper-content">
                    {{-- <form method="POST" action="{{ route('prod.store')}}" enctype="multipart/form-data" class="submitForm form"> --}}
                        <form id="productionForm" enctype="multipart/form-data" class="submitForm form">
                            @csrf
                        
                            @include('productions.create.steps.stepAdherent', ['CodeProduit' => $product->CodeProduit])
    
                            @include('productions.create.steps.stepAssurer', ['CodeProduit' => $product->CodeProduit])
    
                            @include('productions.create.steps.stepBeneficiaire', ['CodeProduit' => $product->CodeProduit])
                        
                            <input type="hidden" id="assuresInput" name="assures">
                            <input type="hidden" id="beneficiariesInput" name="beneficiaires">
    
                            <input type="hidden" id="codeproduitvalue" name="codeproduit" value="{{ $product->CodeProduit }}">
                        
                            @include('productions.create.steps.stepPaiementPrime', ['CodeProduit' => $product->CodeProduit])
    
                            @include('productions.create.steps.stepSante', ['CodeProduit' => $product->CodeProduit])
                            @include('productions.create.steps.stepResume', ['CodeProduit' => $product->CodeProduit])
    
                        </form>
                        
                        @include('productions.create.steps.stepDocument', ['CodeProduit' => $product->CodeProduit])
                        
                        
                        
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    let garantiesData = sessionStorage.getItem("garantiesData");
    let tbody = document.getElementById("garantiesTableBody");
    let primeTotalFooter = document.getElementById("primeTotalFooter");

    if (garantiesData) {
        garantiesData = JSON.parse(garantiesData);
        let totalPrime = 0;
        let tableContent = "";

        garantiesData.forEach(garantie => {
            tableContent += `
                <tr>
                    <td>${garantie.codeGarantie}</td>
                    <td>${garantie.codeGarantie}</td>
                    <td>${parseInt(garantie.prime).toLocaleString()}</td>
                </tr>
            `;
            totalPrime += parseInt(garantie.prime) || 0;
        });

        tbody.innerHTML = tableContent;
        primeTotalFooter.textContent = totalPrime.toLocaleString();
    } else {
        tbody.innerHTML = `<tr><td colspan="3" class="text-center">Aucune donnée disponible</td></tr>`;
    }
});

</script>

<script>
    // document.addEventListener("DOMContentLoaded", function () {
    //     let garantiesData = sessionStorage.getItem("garantiesData");

    //     if (garantiesData) {
    //         garantiesData = JSON.parse(garantiesData);

    //         totalPrime = 0;

            

    //         console.log("Données chargées depuis la session :", garantiesData);

    //         if (garantiesData.length > 0) {
    //             let garantie = garantiesData[0]; // On prend la première garantie comme référence

    //             totalPrime += parseInt(garantie.prime) || 0;
                

    //             // Mise à jour des champs s'ils existent dans le DOM
    //             let dateEffetInput = document.getElementById("DateEffetYKE_2008");
    //             if (dateEffetInput) dateEffetInput.value = garantie.dateEffet;

    //             let DatenaissanceInput = document.getElementById("Date_naissance");
    //             if (DatenaissanceInput) DatenaissanceInput.value = garantie.dateNaisssance;

    //             let primeInput = document.getElementById("primepricipaleYKE_2008");
    //             if (primeInput) primeInput.value = totalPrime;

    //             let capitalInput = document.getElementById("capitalYKE_2008");
    //             if (capitalInput) capitalInput.value = garantie.capitalSouscrit;

    //             let dureeInput = document.getElementById("dureeYKE_2008");
    //             if (dureeInput) dureeInput.value = garantie.duree;

    //             let periodiciteInput = document.querySelector("[name='periodicite'][value='" + garantie.codePeriodicite + "']");
    //             if (periodiciteInput) {
    //                 periodiciteInput.checked = true;
    //             }
    //         }
    //     }


        
    // });

    document.addEventListener("DOMContentLoaded", function () {
    let garantiesData = sessionStorage.getItem("garantiesData");

    if (garantiesData) {
        garantiesData = JSON.parse(garantiesData);
        let totalPrime = 0; // Initialisation correcte

        console.log("Données chargées depuis la session :", garantiesData);

        garantiesData.forEach(garantie => { // Boucle sur toutes les garanties
            totalPrime += parseInt(garantie.prime) || 0;
        });

        // Mise à jour des champs s'ils existent dans le DOM
        if (garantiesData.length > 0) {
            let garantie = garantiesData[0]; // On prend la première garantie pour récupérer les autres infos

            let dateEffetInput = document.getElementById("DateEffetYKE_2008");
            if (dateEffetInput) dateEffetInput.value = garantie.dateEffet;

            let DatenaissanceInput = document.getElementById("Date_naissance");
            if (DatenaissanceInput) DatenaissanceInput.value = garantie.dateNaisssance;

            let primeInput = document.getElementById("primepricipaleYKE_2008");
            if (primeInput) primeInput.value = totalPrime; // Maintenant le total est bien cumulé

            let capitalInput = document.getElementById("capitalYKE_2008");
            if (capitalInput) capitalInput.value = garantie.capitalSouscrit;

            let dureeInput = document.getElementById("dureeYKE_2008");
            if (dureeInput) dureeInput.value = garantie.duree;

            let periodiciteInput = document.querySelector("[name='periodicite'][value='" + garantie.codePeriodicite + "']");
            if (periodiciteInput) {
                periodiciteInput.checked = true;
            }
        }
    }
});


</script>


<script>
    // Références aux champs de saisie et aux éléments d'affichage
    const civiliteInputs = document.querySelectorAll('input[name="civilite"]');
    const nomInput = document.querySelector('input[name="nom"]');
    const prenomInput = document.querySelector('input[name="prenom"]');
    const birthdayInput = document.querySelector('input[name="datenaissance"]');
    const lieuNaissanceSelect = document.querySelector('select[name="lieunaissance"]');
    const naturepieceInputs = document.querySelectorAll('input[name="naturepiece"]');
    const numeropieceInput = document.querySelector('input[name="numeropiece"]');
    const lieuresidenceSelect = document.querySelector('select[name="lieuresidence"]');
    const sexeInput = document.querySelector('input[name="sexe"]');

    const professionSelect = document.querySelector('select[name="profession"]');
    const employeurSelect = document.querySelector('select[name="employeur"]');
    const emailInput = document.querySelector('input[name="email"]');
    const mobileInput = document.querySelector('input[name="mobile"]');
    const mobile1Input = document.querySelector('input[name="mobile1"]');
    const telephoneInput = document.querySelector('input[name="telephone"]');

    const modePaiementRadios = document.querySelectorAll('input[name="modepaiement"]');
    const periodiciteRadios = document.querySelectorAll('input[name="periodicite"]');
    const dateEffetInput = document.querySelector('input[name="dateEffet"]');
    const primeInput = document.querySelector('input[name="primepricipale"]');
    const fraisAdhesionInput = document.querySelector('input[name="fraisadhesion"]');
    const capitalInput = document.querySelector('input[name="capital"]');
    const banqueSelect = document.querySelector('select[name="organisme"]');
    const agenceSelect = document.querySelector('select[name="agence"]');
    const numeroCompteInput = document.querySelector('input[name="numerocompte"]');
    const numMobileInput = document.querySelector('input[name="numMobile"]');



    // Références aux éléments d'affichage
    const displayCivility = document.getElementById('displayCivility');
    const displayNom = document.getElementById('displayNom');
    const displayPrenom = document.getElementById('displayPrenom');
    const displayBirthday = document.getElementById('displayBirthday');
    const displayLieuNaissance = document.getElementById('displayLieuNaissance');
    const displayNaturepiece = document.getElementById('displayNaturepiece');
    const displayNumPiece = document.getElementById('displayNumPiece');
    const displayResidence = document.getElementById('displayResidence');
    const displaySexe = document.getElementById('displaySexe');

    const displayProfession = document.getElementById('displayProfession');
    const displayEmployeur = document.getElementById('displayEmployeur');
    const displayEmail = document.getElementById('displayEmail');
    const displayMobile = document.getElementById('displayMobile');
    const displayMobile1 = document.getElementById('displayMobile1');
    const displayTelephone = document.getElementById('displayTelephone');

    const displayModePaiement = document.getElementById('displayModePaiement');
    const displayOrganisme = document.getElementById('displayOrganisme');
    const displayAgence = document.getElementById('displayAgence');
    const displayNumeroCompte = document.getElementById('displayNumeroCompte');
    const displayDateEffet = document.getElementById('displayDateEffet');
    const displayPrimePrincipale = document.getElementById('displayPrimePrincipale');
    const displayFraisAdhesion = document.getElementById('displayFraisAdhesion');
    const displayCapital = document.getElementById('displayCapital');
    const displayPeriodicite = document.getElementById('displayPeriodicite');
    const displayNumMobile = document.getElementById('displayNumMobile');

    // Mise à jour dynamique des valeurs affichées
    civiliteInputs.forEach(input => {
        input.addEventListener('change', () => {
            displayCivility.textContent = input.checked ? input.value : 'null';
        });
    });

    if (nomInput) {
        nomInput.addEventListener('input', () => {
            displayNom.textContent = nomInput.value || 'Null';
        });
    }

    if (prenomInput) {
        prenomInput.addEventListener('input', () => {
            displayPrenom.textContent = prenomInput.value || 'Null';
        });
    }

    if (birthdayInput) {
        birthdayInput.addEventListener('input', () => {
            displayBirthday.textContent = birthdayInput.value || 'Null';
        });
    }

    naturepieceInputs.forEach(input => {
        input.addEventListener('change', () => {
            displayNaturepiece.textContent = input.checked ? input.value : 'null';
        });
    });

    if (numeropieceInput) {
        numeropieceInput.addEventListener('input', () => {
            displayNumPiece.textContent = numeropieceInput.value || 'Null';
        });
    }

    if (lieuNaissanceSelect) {
        lieuNaissanceSelect.addEventListener('change', () => {
            displayLieuNaissance.textContent = lieuNaissanceSelect.value || 'Null';
        });
    }

    if (lieuresidenceSelect) {
        lieuresidenceSelect.addEventListener('change', () => {
            displayResidence.textContent = lieuresidenceSelect.value || 'Null';
        });
    }

    if (sexeInput) {
        sexeInput.addEventListener('input', () => {
            displaySexe.textContent = sexeInput.value || 'Null';
        });
    }

    if (professionSelect) {
        professionSelect.addEventListener('change', () => {
            displayProfession.textContent = professionSelect.value || 'Null';
        });
    }

    if (employeurSelect) {
        employeurSelect.addEventListener('change', () => {
            displayEmployeur.textContent = employeurSelect.value || 'Null';
        });
    }

    if (emailInput) {
        emailInput.addEventListener('input', () => {
            displayEmail.textContent = emailInput.value || 'Null';
        });
    }

    if (mobileInput) {
        mobileInput.addEventListener('input', () => {
            displayMobile.textContent = mobileInput.value || 'Null';
        });
    }

    if (mobile1Input) {
        mobile1Input.addEventListener('input', () => {
            displayMobile1.textContent = mobile1Input.value || 'Null';
        });
    }

    if (telephoneInput) {
        telephoneInput.addEventListener('input', () => {
            displayTelephone.textContent = telephoneInput.value || 'Null';
        });
    }

    modePaiementRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            displayModePaiement.textContent = radio.value || 'Null';
        });
    });

    banqueSelect.addEventListener('change', () => {
        displayOrganisme.textContent = banqueSelect.value || 'Null';
    });

    // Mise à jour de l'agence
    agenceSelect.addEventListener('change', () => {
        displayAgence.textContent = agenceSelect.value || 'Null';
    });

    // Mise à jour du numéro de compte
    numeroCompteInput.addEventListener('input', () => {
        displayNumeroCompte.textContent = numeroCompteInput.value || 'Null';
    });

    // Mise à jour de la date d'effet
    dateEffetInput.addEventListener('input', () => {
        displayDateEffet.textContent = dateEffetInput.value || 'Null';
    });

    // Mise à jour de la prime principale
    primeInput.addEventListener('input', () => {
        displayPrimePrincipale.textContent = primeInput.value || 'Null';
    });

    // Mise à jour des frais d'adhésion
    fraisAdhesionInput.addEventListener('input', () => {
        displayFraisAdhesion.textContent = fraisAdhesionInput.value || 'Null';
    });

    // Mise à jour du capital
    capitalInput.addEventListener('input', () => {
        displayCapital.textContent = capitalInput.value || 'Null';
    });

    // Mise à jour de la périodicité
    periodiciteRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            displayPeriodicite.textContent = radio.value || 'Null';
        });
    });

    numMobileInput.addEventListener('input', () => {
        displayNumMobile.textContent = numMobileInput.value || 'Null';
    });
</script>

{{-- <script>
    document.getElementById('Date_naissance').addEventListener('change', function () {
        const ageMin = parseInt('{{ $product->AgeMiniAdh }}', 10); // Remplacez par les valeurs dynamiques de Laravel
        const ageMax = parseInt('{{ $product->AgeMaxiAdh }}', 10); // Remplacez par les valeurs dynamiques de Laravel

        const birthDate = new Date(this.value); // Récupérer la date saisie
        const today = new Date(); // Date actuelle

        // Calcul de l'âge
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        // Ajuster l'âge si l'anniversaire n'est pas encore passé cette année
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        // Vérifier si l'âge est hors des limites
        if (age < ageMin || age > ageMax) {
            alert(`L'âge doit être compris entre ${ageMin} et ${ageMax} ans.`);
            this.value = ''; // Réinitialiser l'entrée
        }
    });
</script> --}}

<script>
    document.getElementById('Date_naissance').addEventListener('blur', function () {
        const ageMin = parseInt('{{ $product->AgeMiniAdh }}', 10);
        const ageMax = parseInt('{{ $product->AgeMaxiAdh }}', 10);
        const errorBlock = document.querySelector('.date-error');

        const birthDate = new Date(this.value);
        const today = new Date();

        // Vérifie si une date valide est saisie
        if (isNaN(birthDate.getTime())) {
            return;
        }

        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        if (age < ageMin || age > ageMax) {
            errorBlock.innerHTML = `L'âge doit être compris entre ${ageMin} et ${ageMax} ans.`;
            this.value = '';
        }else{
            errorBlock.innerHTML = '';
        }

    });
</script>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("productionForm");
    const btn = document.getElementById("btn-next");

    btn.addEventListener("click", function (event) {
        event.preventDefault();

        const formData = new FormData(form);

        axios.post('{{ route("prod.store") }}', formData)
        .then(function (response) {
            if (response.data.type === "success") {
                // alert(response.data.message);


                
                if (response.data.url) {
                    window.open(response.data.url, '_blank');
                }

                if (response.data.urlback) {
                    window.location.href = response.data.urlback;
                }
            } else {
                throw new Error(response.data.message || "Erreur lors de l'enregistrement.");
            }
        })
        .catch(function (error) {
            console.error(error);
            alert(error.response?.data?.message || "Une erreur est survenue.");
        });
    });
});

</script>



    @include('productions.assurer.addModal', ['CodeProduit' => $product->CodeProduit])   
    {{-- @include('users.components.searchModal') --}}
    @include('productions.beneficiaires.add')

@endsection
