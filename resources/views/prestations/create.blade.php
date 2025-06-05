@extends('layouts.main')

@section('content')
    <style>
        /* Conteneur des champs de saisie pour placer l'icône */
        /* Applique le style aux éléments en lecture seule */
        input[readonly],
        textarea[readonly],
        select[readonly] {
            background-color: #f0f0f0;
            /* Couleur de fond gris pour les champs en readonly */
            border: 1px solid #ccc;
            /* Bordure gris clair */
            /* cursor: not-allowed;        Curseur indiquant que l'action est interdite */
            cursor: no-drop;
            pointer-events: none;
            /* Empêche toute interaction avec ces éléments */
        }

        /* Remplacer le curseur par l'emoji 🚫 lors du survol des champs readonly */
        input[readonly]:hover,
        textarea[readonly]:hover,
        select[readonly]:hover {
            cursor: no-drop;
            /* cursor: wait; */
        }
        @media (min-width: 992px) { /* lg breakpoint */
        .w-lg-20 {
            max-width: 20%;
        }
        .w-lg-15 {
            max-width: 25% !important;
        }
    }
    </style>
    <!--start stepper one-->
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Prestations</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('shared.home')}}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Demande de prestation |
                        {{ $typePrestation->libelle ?? '' }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div id="stepper1" class="bs-stepper">
        <div class="card">

            <div class="card-header">
                <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between" role="tablist">
                    <div class="step" data-target="#test-l-1">
                        <div class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1">
                            <div class="bs-stepper-circle">1</div>
                            <div class="">
                                <h5 class="mb-0 steper-title">Information personnelle</h5>
                                <p class="mb-0 steper-sub-title">Entrez vos coordonnées</p>
                            </div>
                        </div>
                    </div>
                    <div class="bs-stepper-line"></div>
                    <div class="step" data-target="#test-l-2">
                        <div class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2">
                            <div class="bs-stepper-circle">2</div>
                            <div class="">
                                <h5 class="mb-0 steper-title">Information sur prestation</h5>
                                <p class="mb-0 steper-sub-title">Entrer les Information liée à la prestation</p>
                            </div>
                        </div>
                    </div>
                    <div class="bs-stepper-line"></div>
                    <div class="step" data-target="#test-l-3">
                        <div class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3">
                            <div class="bs-stepper-circle">3</div>
                            <div class="">
                                <h5 class="mb-0 steper-title">Finalisation de la demande</h5>
                                <p class="mb-0 steper-sub-title">Finaliser votre demande</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">
                {{-- @dd($TotalEncaissement) --}}
                <div class="bs-stepper-content">
                    <form id="PrestationForm" enctype="multipart/form-data" class="submitForm">
                        @csrf
                        @include('prestations.components.steps.stepInfosPerso')
                        <input type="hidden" id="tokGenerate" name="tokGenerate" value="{{ $tok }}">
                        @php
                            $keyUuid = $token['key_uuid'];
                            $operationType = $token['operation_type'];
                        @endphp
                        @include('prestations.components.steps.stepInfosPrest')

                        @include('prestations.components.steps.resumer')
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!--end stepper one-->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("PrestationForm");
            const btn = document.getElementById("submit-btnPrest");

            btn.addEventListener("click", function(event) {
                event.preventDefault();

                const formData = new FormData(form);

                axios.post('{{ route('prestation.store') }}', formData)
                    .then(function(response) {
                        if (response.data.type === "success") {
                            // alert(response.data.message);



                            if (response.data.url) {
                                window.open(response.data.url, '_blank');
                            }

                            if (response.data.urlback) {
                                window.location.href = response.data.urlback;
                            }
                        } else {
                            throw new Error(response.data.message ||
                                "Erreur lors de l'enregistrement.");
                        }
                    })
                    .catch(function(error) {
                        console.error(error);
                        alert(error.response?.data?.message || "Une erreur est survenue.");
                    });
            });
        });
    </script>
    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer les éléments nécessaires
            const typeFileSelect = document.getElementById('typeFile');
            const docNameInput = document.getElementById('DocName');

            // Fonction pour mettre à jour la valeur du champ caché
            function updateDocName() {
                docNameInput.value = typeFileSelect.value; // Met à jour avec la valeur sélectionnée
            }

            // Ajouter un événement 'change' sur le select
            typeFileSelect.addEventListener('change', updateDocName);

            // Initialiser la valeur au chargement de la page
            updateDocName();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const formulaire = document.querySelector('#PrestationForm');
            // alert(formulaire);

            if (!formulaire) {
                console.error("Le formulaire avec l'ID 'PrestationForm' est introuvable.");
                return;
            }

            formulaire.addEventListener('input', mettreAJourResume);
            formulaire.addEventListener('change', mettreAJourResume);

            function mettreAJourResume() {
                try {
                    // Récupération des valeurs des champs
                    const typePrestation = formulaire.querySelector('[name="typeprestation"]')?.value || '';
                    const idContrat = formulaire.querySelector('[name="idcontrat"]')?.value || '';
                    const montantSouhaite = formulaire.querySelector('[name="montantSouhaite"]')?.value || '';

                    // Récupération des boutons radio sélectionnés
                    const moyenPaiement = formulaire.querySelector('[name="moyenPaiement"]:checked')?.value || '';
                    const operateur = formulaire.querySelector('[name="Operateur"]:checked')?.value || '';
                    const sexe = formulaire.querySelector('[name="sexe"]')?.value || '';

                    const telPaiement = formulaire.querySelector('[name="TelPaiement"]')?.value || '';
                    const iban = formulaire.querySelector('[name="IBAN"]')?.value || '';

                    const nom = formulaire.querySelector('[name="nom"]')?.value || '';
                    const prenom = formulaire.querySelector('[name="prenom"]')?.value || '';
                    const dateNaissance = formulaire.querySelector('[name="datenaissance"]')?.value || '';
                    const cel = formulaire.querySelector('[name="cel"]')?.value || '';
                    const email = formulaire.querySelector('[name="email"]')?.value || '';
                    const lieuResidence = formulaire.querySelector('[name="lieuresidence"]')?.value || '';

                    // Mise à jour du résumé
                    document.getElementById('TelOtp').value = cel;
                    document.getElementById('Prestation').textContent = typePrestation;
                    document.getElementById('Contrat').textContent = idContrat;
                    document.getElementById('montant').textContent = montantSouhaite + ' FCFA';

                    const moyenPaiementText = moyenPaiement === 'Virement_Bancaire' ? 'Virement Bancaire' :
                        'Mobile Money';
                    document.getElementById('moyenPmt').textContent = moyenPaiementText;

                    // Mise à jour du résumé pour le moyen de paiement Mobile Money
                    const telPaiementSection = document.getElementById('TelephonePaiement');
                    const ibanPaiementSection = document.getElementById('IBANPaiement');

                    if (ibanPaiementSection.classList.contains('d-none') && moyenPaiement === 'Mobile_Money') {
                        const operateurText = operateur === 'Orange_money' ? 'Orange Money' :
                            operateur === 'MTN_money' ? 'MTN Money' :
                            operateur === 'Moov_money' ? 'Moov Money' : '';
                        document.getElementById('Opera').textContent = operateurText;
                        document.getElementById('TelPmt').textContent = telPaiement;
                        document.getElementById('NIBAN').textContent = '';
                    } else if (telPaiementSection.classList.contains('d-none') && moyenPaiement ===
                        'Virement_Bancaire') {
                        document.getElementById('NIBAN').textContent = iban;
                        document.getElementById('Opera').textContent = '';
                        document.getElementById('TelPmt').textContent = '';


                    }

                    document.getElementById('nomSous').textContent = nom;
                    document.getElementById('prenomSous').textContent = prenom;
                    document.getElementById('datenaissanceSous').textContent = dateNaissance;
                    document.getElementById('sexeSous').textContent = sexe;
                    document.getElementById('celSous').textContent = cel;
                    document.getElementById('emailSous').textContent = email;
                    document.getElementById('lieuresidenceSous').textContent = lieuResidence;
                } catch (error) {
                    console.error("Erreur lors de la mise à jour du résumé :", error);
                }
            }
        });


        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const ribInputs = document.querySelectorAll('.rib-input');
            function handleInput(inputArray, event, index) {
                const input = event.target;
                const nextInput = inputArray[index + 1];
                const prevInput = inputArray[index - 1];

                // Empêcher les entrées multiples (ex: copier-coller)
                if (input.value.length > 1) {
                    input.value = input.value.charAt(0);
                }

                // Passage automatique au champ suivant
                if (input.value.length === 1 && nextInput) {
                    nextInput.focus();
                }
            }

            function handleKeyDown(inputArray, event, index) {
                const input = event.target;
                const prevInput = inputArray[index - 1];
                const nextInput = inputArray[index + 1];

                // Gestion du retour arrière (Backspace)
                if (event.key === 'Backspace' && input.value === '' && prevInput) {
                    prevInput.focus();
                }

                // Permettre la navigation avec les flèches gauche et droite
                if (event.key === 'ArrowLeft' && prevInput) {
                    prevInput.focus();
                } else if (event.key === 'ArrowRight' && nextInput) {
                    nextInput.focus();
                }
            }

            function handlePaste(event) {
                event.preventDefault(); // Empêcher le collage multiple
            }

            // Gestion des OTP inputs
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (event) => handleInput(otpInputs, event, index));
                input.addEventListener('keydown', (event) => handleKeyDown(otpInputs, event, index));
                input.addEventListener('paste', handlePaste);
            });

            // Gestion des RIB inputs (avec validation)
            ribInputs.forEach((input, index) => {
                input.addEventListener('input', function (event) {
                    this.value = this.value.replace(/[^a-zA-Z0-9]/g, ''); // Autoriser uniquement lettres et chiffres
                    handleInput(ribInputs, event, index);
                });

                input.addEventListener('keydown', (event) => handleKeyDown(ribInputs, event, index));
                input.addEventListener('paste', handlePaste);
            });
        });
    </script>
    <script>
        let TotalEncaissement = @json($TotalEncaissement);
        // alert(TotalEncaissement);
    </script>



@include('prestations.components.modals.detailContratModal')
@include('productions.create.steps.signModal')

<script>
    let pollingInterval;

    const qrCodeModal = document.getElementById('qrCodeModal');

    qrCodeModal.addEventListener('shown.bs.modal', function () {
        const keyUuid = "{{ $keyUuid }}"; // Variable Blade pour key_uuid
        const operationType = "{{ $operationType }}"; // Variable Blade pour operation_type

        // Polling toutes les 3 secondes pour vérifier l'état de la signature
        pollingInterval = setInterval(() => {
            fetch(`https://apisign.yakoafricassur.com/api/check-signature-status/${keyUuid}/${operationType}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status == 'completed') {
                        clearInterval(pollingInterval);

                        // Masquer la modale si la signature est terminée
                        const modal = bootstrap.Modal.getInstance(qrCodeModal);
                        modal.hide();

                        // Afficher un message indiquant que la signature est terminée
                        alert("Signature terminée avec succès !");
                    }
                })
                .catch(error => {
                    console.error("Erreur de polling :", error);
                });
        }, 3000); // toutes les 3 secondes
    });

    // Si la modale est fermée, on arrête le polling
    qrCodeModal.addEventListener('hidden.bs.modal', function () {
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }
    });
</script>
@endsection
