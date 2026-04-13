@extends('layouts.main')

@section('content')
<style>
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
                                <p class="mb-0 steper-sub-title">Informations liées à la prestation</p>
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
                        <input type="hidden" id="OTP_API" name="OTP_API" value="{{ config('services.otp_api') }}">
                        @php
                            $keyUuid = $token['key_uuid'];
                            $operationType = $token['operation_type'];
                        @endphp
                        @include('prestations.components.steps.stepInfosPrest')
                        <input type="hidden" name="actionOperation" id="actionOperation" value="{{ $action ?? '' }}">

                        @include('prestations.components.steps.resumer')
                    </form>
                </div>

            </div>
        </div>
    </div>

    @include('prestations.components.modals.detailContratModal')
    @include('productions.create.steps.signModal')
    @include('prestations.components.modals.otpModal')
    <!--end stepper one-->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("PrestationForm");
            const btn = document.getElementById("submit-btnPrest");

            btn.addEventListener("click", function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Traitement en cours...',
                    text: 'Veuillez patienter...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                const formData = new FormData(form);

                axios.post('{{ route('prestation.store') }}', formData)
                    .then(function(response) {
                        if (response.data.type === "success") {
                            // alert(response.data.message);

                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                showConfirmButton: true,
                                confirmButtonText: 'OK',
                                text: response.data.message,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    if (response.data.url) {
                                        window.open(response.data.url, '_blank');
                                    }

                                    if (response.data.urlback) {
                                        window.location.href = response.data.urlback;
                                    }
                                }
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur...',
                                showConfirmButton: true,
                                confirmButtonText: 'Reessayer',
                                text: response.data.message,
                            });
                        }
                    })
                    .catch(function(error) {
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur...',
                            showConfirmButton: true,
                            confirmButtonText: 'Reessayer',
                            text: response?.data?.message || "Une erreur est survenue.",
                        });
                    });
            });
        });
    </script>

    <script>
        // Activer la géolocalisation de l'utilisateur uniquement si le site est sécurisé (HTTPS)
        if (location.protocol === 'https:') {
            map.locate({
                setView: true,
                maxZoom: 16
            });

            function onLocationFound(e) {
                var radius = e.accuracy / 2;

                L.marker(e.latlng).addTo(map)
                // .bindPopup("Vous êtes ici").openPopup();
                // .bindPopup("Vous êtes ici, à " + radius + " mètres près.").openPopup();

                L.circle(e.latlng, radius).addTo(map);
            }

            map.on('locationfound', onLocationFound);

            function onLocationError(e) {
                alert(e.message);
            }

            map.on('locationerror', onLocationError);
        } else {
            console.log("Géolocalisation désactivée en raison d'une origine non sécurisée (HTTP).");
        }
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
            const changePhoneButton = document.getElementById('changePhoneButton');
            const changePhoneButtonForMobileMoney = document.getElementById('changePhoneButtonForMobileMoney');
            
            
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
                    
                    const modalOtp_1 = document.querySelector('#modalOtp_1')?.value || '';
                    const modalOtp_2 = document.querySelector('#modalOtp_2')?.value || '';
                    const modalOtp_3 = document.querySelector('#modalOtp_3')?.value || '';
                    const modalOtp_4 = document.querySelector('#modalOtp_4')?.value || '';
                    const modalOtp_5 = document.querySelector('#modalOtp_5')?.value || '';
                    const modalOtp_6 = document.querySelector('#modalOtp_6')?.value || '';

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
                    {{-- const phoneInput = document.getElementById('phoneInput'); --}}
                    // Mise à jour du résumé
                    document.getElementById('TelOtp').value = cel;
                    document.getElementById('Prestation').textContent = typePrestation;
                    document.getElementById('Contrat').textContent = idContrat;
                    document.getElementById('montant').textContent = montantSouhaite + ' FCFA';

                    phoneInput.value = cel;

                    changePhoneButtonForMobileMoney.classList.add('d-none');

                    const moyenPaiementText = moyenPaiement === 'Virement_Bancaire' ? 'Virement Bancaire' :
                        'Mobile Money';
                    document.getElementById('moyenPmt').textContent = moyenPaiementText;

                    console.log('modalOtp_1 :', modalOtp_1);
                    console.log('modalOtp_2 :', modalOtp_2);
                    console.log('modalOtp_3 :', modalOtp_3);
                    console.log('modalOtp_4 :', modalOtp_4);
                    console.log('modalOtp_5 :', modalOtp_5);
                    console.log('modalOtp_6 :', modalOtp_6);

                    formulaire.querySelector('[name="otp_1"]').value = modalOtp_1;
                    formulaire.querySelector('[name="otp_2"]').value = modalOtp_2;
                    formulaire.querySelector('[name="otp_3"]').value = modalOtp_3;
                    formulaire.querySelector('[name="otp_4"]').value = modalOtp_4;
                    formulaire.querySelector('[name="otp_5"]').value = modalOtp_5;
                    formulaire.querySelector('[name="otp_6"]').value = modalOtp_6;

                    console.log('otp_1 :', formulaire.querySelector('[name="otp_1"]').value);
                    console.log('otp_2 :', formulaire.querySelector('[name="otp_2"]').value);
                    console.log('otp_3 :', formulaire.querySelector('[name="otp_3"]').value);
                    console.log('otp_4 :', formulaire.querySelector('[name="otp_4"]').value);
                    console.log('otp_5 :', formulaire.querySelector('[name="otp_5"]').value);
                    console.log('otp_6 :', formulaire.querySelector('[name="otp_6"]').value);


                    // Mise à jour du résumé pour le moyen de paiement Mobile Money
                    const telPaiementSection = document.getElementById('TelephonePaiement');
                    const ibanPaiementSection = document.getElementById('IBANPaiement');

                    if (ibanPaiementSection.classList.contains('d-none') && moyenPaiement === 'Mobile_Money') {
                        changePhoneButton.classList.add('d-none');
                        changePhoneButtonForMobileMoney.classList.remove('d-none');
                        const operateurText = operateur === 'Orange_money' ? 'Orange Money' :
                            operateur === 'MTN_money' ? 'MTN Money' :
                            operateur === 'Moov_money' ? 'Moov Money' : '';
                        document.getElementById('Opera').textContent = operateurText;
                        document.getElementById('TelPmt').textContent = telPaiement;
                        document.getElementById('NIBAN').textContent = '';
                        phoneInput.value = telPaiement;
                        phoneInput.readOnly = true;
                    } else if (telPaiementSection.classList.contains('d-none') && moyenPaiement ===
                        'Virement_Bancaire') {
                        changePhoneButton.classList.remove('d-none');
                        changePhoneButtonForMobileMoney.classList.add('d-none');
                        document.getElementById('NIBAN').textContent = iban;
                        document.getElementById('Opera').textContent = '';
                        document.getElementById('TelPmt').textContent = '';
                        // Mise à jour du champ du Numéro de téléphone pour la confirmation via OTP du numéro de paiement
                        phoneInput.value = cel;
                        {{-- phoneInput.readOnly = true; --}}

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
    </script>

    
    <script>
        const SIGN_API = "{{ config('services.sign_api') }}";
        const OTP_API = "{{ config('services.otp_api') }}";
    </script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sendOTPForm = document.getElementById('sendOTPForm');
        const OTPSendID = document.getElementById('OTPSendID');
        const OTPVerifyID = document.getElementById('OTPVerifyID');
        const verifyOTPForm = document.getElementById('verifyOTPForm');
        const sendOTPButton = document.getElementById('sendOTPButton');
        

        const otpInputs = document.querySelectorAll('.otp-input');

        // Envoi de l’OTP
        sendOTPButton.addEventListener('click', function(e) {
            e.preventDefault();

            const indicatif = document.getElementById('countryPrefix').value;
            const telephone = document.getElementById('phoneInput').value;
            const operation_type = document.getElementById('operation_type').value;
            const csrfToken = document.querySelector('input[name="_token"]').value;

            fetch(`${OTP_API}api/send-otp`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        telIndicatif: indicatif,
                        telephone: telephone,
                        operation_type: operation_type
                    })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == 200) {
                    // Masquer sendOTPForm, afficher verifyOTPForm
                    OTPSendID.classList.add('d-none');
                    OTPVerifyID.classList.remove('d-none');

                    // Stocker les valeurs pour la vérification
                    document.getElementById('hiddenTelephone').value = telephone;
                    document.getElementById('hiddenIndicatif').value = indicatif;

                    // Afficher un message
                    const lastTwo = telephone.slice(-4);
                    const firstTwo = telephone.slice(0, 2);
                    //utilise sweetalert
                    Swal.fire({
                        icon: 'success',
                        title: 'Un code de confirmation a été envoyé par SMS au numéro +' +
                            indicatif + firstTwo + '**' + lastTwo,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        position: 'center',
                        timerProgressBar: true,
                        timer: 5000
                    });
                    //alert('Un code de confirmation a été envoyé par SMS au numéro +' + indicatif + firstTwo + '**' + lastTwo);

                    startOtpTimer();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: data.message || 'Erreur lors de l’envoi de l’OTP.',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        position: 'center',
                        timerProgressBar: true,
                        timer: 5000
                    });
                    //alert(data.message || 'Erreur lors de l’envoi de l’OTP.');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur réseau ou serveur.',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    position: 'center',
                    timerProgressBar: true,
                    timer: 5000
                });
                //alert('Erreur réseau ou serveur.');
            });
        });


        // Autofocus entre les champs OTP
        otpInputs.forEach((input, index) => {
            input.addEventListener("input", function() {
                if (this.value.length === this.maxLength) {
                    if (index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                } else if (this.value.length === 0 && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });

            input.addEventListener("keydown", function(e) {
                if (e.key === "Backspace" && input.value === "" && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        const verifyOtpButton = document.getElementById('verifyOtpButton');
        const changePhoneButton = document.getElementById('changePhoneButton');
        const changePhoneButtonForMobileMoney = document.getElementById('changePhoneButtonForMobileMoney');
        const otpContainer = document.getElementById('OTPContainer');
        const btnSignature = document.getElementById('btn-signature');
        const btnSignature1 = document.getElementById('btn-signature1');
        const btnSubmit = document.getElementById('submit-btnPrest');
        const nextStepPrestBtn = document.getElementById('next-stepPrest-btn');
        const resendOtpButton = document.querySelector(".resend-otp-btn");
        const otpTimer = document.createElement("div"); // Timer pour afficher le compte à rebours
        // initialisation pour le hide modal bootstrap
        const qrCodeModal = new bootstrap.Modal(document.getElementById('qrCodeModal'));
        const myModal = new bootstrap.Modal(document.getElementById('otpModal'));
        verifyOtpButton.addEventListener('click', function() {
            const telephone = document.getElementById('hiddenTelephone').value;
            const indicatif = document.getElementById('hiddenIndicatif').value;
            const operation_type = document.getElementById('operation_type').value;
            const phoneNumber = indicatif + telephone;
            const csrfToken = document.querySelector('input[name="_token"]').value;
            let latitude = '';
            let longitude = '';

            let otp = '';
            otpInputs.forEach(input => {
                otp += input.value;
            });

            if (otp.length !== 6) {
                Swal.fire({
                    icon: 'error',
                    title: 'Veuillez saisir les 6 chiffres du code.',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    position: 'center',
                    timerProgressBar: true,
                    timer: 5000
                });
                otpInputs.forEach(input => {
                    input.classList.remove("is-valid");
                    input.classList.add("is-invalid");
                });
                return;
            }
            // Récupération de la position GPS
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        latitude = position.coords.latitude;
                        longitude = position.coords.longitude;

                        
                        
                    },
                    (error) => {
                        alert('La géolocalisation est requise pour continuer. Veuillez autoriser l\'accès.');
                        console.error('Erreur de géolocalisation:', error);
                    }
                );
            } else {
                alert('Votre navigateur ne supporte pas la géolocalisation.');
            }

            fetch(`${OTP_API}api/verify-otp`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    telIndicatif: indicatif,
                    telephone: telephone,
                    otp: otp,
                    latitude: latitude,
                    longitude: longitude
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Votre numéro de téléphone a été vérifié avec succès.',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        position: 'center',
                        timerProgressBar: true,
                        timer: 5000
                    });
                    otpInputs.forEach(input => {
                        input.classList.remove("is-invalid");
                        input.classList.add("is-valid");
                    });

                    // Masquer btnSignature, afficher btnSubmit et ouvrir la modale qrCodeModal avec un delay de 5 secondes
                    setTimeout(() => {
                        //btnSignature.classList.add('d-none');
                        //btnSubmit.classList.remove('d-none');
                        myModal.hide();
                        qrCodeModal.show()
                    }, 5000);

                    ;
                } else if (data.status == 400) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Le code de confirmation saisi est incorrect.',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        position: 'center',
                        timerProgressBar: true,
                        timer: 5000
                    });
                    otpInputs.forEach(input => {
                        input.classList.remove("is-valid");
                        input.classList.add("is-invalid");
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Le code de confirmation a expiré.',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        position: 'center',
                        timerProgressBar: true,
                        timer: 5000
                    });
                    otpInputs.forEach(input => {
                        input.classList.remove("is-valid");
                        input.classList.add("is-invalid");
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Une erreur s’est produite lors de la vérification.',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    position: 'center',
                    timerProgressBar: true,
                    timer: 5000
                });
            });
        });

        // Fonction pour démarrer le compte à rebours pour l'expiration de l'OTP
        let otpExpirationTime = 3 * 60; // 3 minutes en secondes
        let otpInterval;

        function startOtpTimer() {
            otpTimer.classList.add("otp-expi-timer");
            otpContainer.appendChild(otpTimer); // Ajouter le timer à l'interface
            updateOtpTimer();

            otpInterval = setInterval(() => {
                otpExpirationTime--;
                updateOtpTimer();

                if (otpExpirationTime <= 0) {
                    clearInterval(otpInterval);
                    otpTimer.textContent = "Le code de confirmation a expiré.";
                    resendOtpButton.classList.remove("d-none"); // Afficher le lien pour renvoyer l'OTP
                    changePhoneButton.disabled = false; // Afficher le lien pour renvoyer l'OTP
                    changePhoneButtonForMobileMoney.disabled = false; // Afficher le lien pour renvoyer l'OTP
                }
            }, 1000); // Met à jour chaque seconde
        }

        function updateOtpTimer() {
            const minutes = Math.floor(otpExpirationTime / 60);
            const seconds = otpExpirationTime % 60;
            otpTimer.textContent = `Temps restant: ${minutes}:${
            seconds < 10 ? "0" : ""
            }${seconds}`;
        }

        // Fonction pour renvoyer l'OTP
        resendOtpButton.addEventListener("click", async function() {
            otpExpirationTime = 3 * 60; // Réinitialiser le temps d'expiration
            clearInterval(otpInterval); // Arrêter l'ancien intervalle
            resendOtpButton.classList.add("d-none"); // Cacher le lien pendant l'envoi de l'OTP
            const telephone = document.getElementById('hiddenTelephone').value;
            const indicatif = document.getElementById('hiddenIndicatif').value;
            const phoneNumber = indicatif + telephone;
            const csrfToken = document.querySelector('input[name="_token"]').value;


            try {

                const response = await fetch(`${OTP_API}api/send-otp`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({
                        {{-- telephone: phoneNumber, --}}
                        telIndicatif: indicatif,
                        telephone: telephone,
                        operation_type: operation_type
                    }),
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                if (data.status === 200) {
                    // Afficher un message
                    const lastTwo = telephone.slice(-4);
                    const firstTwo = telephone.slice(0, 2);
                    Swal.fire({
                        icon: 'success',
                        title: 'Le code de confirmation a été réenvoyé par SMS au numéro +' +
                            indicatif +
                            firstTwo + '**' + lastTwo,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        position: 'center',
                        timerProgressBar: true,
                        timer: 5000
                    });
                    startOtpTimer();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Une erreur s’est produite lors de l’envoi de l’OTP.',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        position: 'center',
                        timerProgressBar: true,
                        timer: 5000
                    });
                }
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Une erreur s’est produite lors de l’envoi de l’OTP.',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    position: 'center',
                    timerProgressBar: true,
                    timer: 5000
                });
            }
        });

        changePhoneButton.addEventListener('click', function() {
            // Masquer OTPVerifyID, afficher OTPSendID
            OTPSendID.classList.remove('d-none');
            OTPVerifyID.classList.add('d-none');
        })
        changePhoneButtonForMobileMoney.addEventListener('click', function() {
            stepper1.previous()
            OTPSendID.classList.remove('d-none');
            OTPVerifyID.classList.add('d-none');
            // Masquer le modal otp et afficher le collapse
            myModal.hide();
            const collapseTwo = document.querySelector("#collapseTwo");
            const bsCollapse = new bootstrap.Collapse(collapseTwo, {
                toggle: true
            });
        })
    });
</script>


<script>
    let pollingInterval;

    const qrCodeModal = document.getElementById('qrCodeModal');
    const btnSignature = document.getElementById('btn-signature');
    const btnSignature1 = document.getElementById('btn-signature1');
    const btnSubmit = document.getElementById('submit-btnPrest');
    const nextStepPrestBtn = document.getElementById('next-stepPrest-btn');

    qrCodeModal.addEventListener('shown.bs.modal', function () {
        const keyUuid = "{{ $keyUuid }}"; // Variable Blade pour key_uuid
        const operationType = "{{ $operationType }}"; // Variable Blade pour operation_type

        // Polling toutes les 3 secondes pour vérifier l'état de la signature
        pollingInterval = setInterval(() => {

            fetch(`${SIGN_API}api/check-signature-status/${keyUuid}/${operationType}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status == 'completed') {
                        clearInterval(pollingInterval);

                        // Masquer la modale si la signature est terminée
                        const modal = bootstrap.Modal.getInstance(qrCodeModal);
                        modal.hide();
                        
                        // Afficher le bouton de signature
                        btnSignature.classList.add('d-none');
                        btnSignature1.classList.add('d-none');
                        btnSubmit.classList.remove('d-none');
                        nextStepPrestBtn.classList.remove('d-none');

                        swal.fire({
                            icon: 'success',
                            title: 'Signature terminée avec succès !',
                            showConfirmButton: false,
                            timer: 1500
                        })
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


{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        const stepElement = document.getElementById("test-l-3");
        
        // Initialisation du modal Bootstrap
        const qrModal = new bootstrap.Modal(document.getElementById('qrCodeModal'), {
            keyboard: false,
            backdrop: 'static'
        });

        
        if (stepElement) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(mutation => {
                    if (mutation.attributeName === 'class' && 
                        stepElement.classList.contains('active')) {
                        console.log("Element actif détecté - ouverture du modal");
                        qrModal.show();
                    }
                });
            });
    
            
            observer.observe(stepElement, { 
                attributes: true 
            });
        }

    });


</script> --}}
@endsection
