<div class="container my-4">
    <h3 class="text-center">FICHE DEMANDE DE COTATION</h3>

    <!-- Adhérent Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>ADHERENT</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><strong>Civilité :</strong> <span id="displayCivility">--</span></div>
                
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Nom :</strong> <span id="displayNom"></span></div>
                <div class="col-md-6"><strong>Prénoms :</strong> <span id="displayPrenom">--</span></div>
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Date de naissance :</strong> <span id="displayBirthday">--</span></div>
                <div class="col-md-6"><strong>Age :</strong> <span>{{ $simulationData['age'] ?? '-' }}</span></div>
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Lieu de naissance :</strong> <span id="displayLieuNaissance">--</span></div>
                <div class="col-md-6"><strong>Adresse postale :</strong> <span id="displayResidence">--</span></div>
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Profession :</strong> <span id="displayProfession">--</span></div>
                <div class="col-md-6"><strong>Employeur :</strong> <span id="displayEmployeur">--</span></div>
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Téléphone :</strong> <span id="displayTelephone">--</span></div>
                <div class="col-md-6"><strong>Mobile :</strong> <span id="displayMobile">--</span></div>
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Email :</strong> <span id="displayEmail">---</span></div>
                <div class="col-md-6"><strong>N° Piece d'identité :</strong> <span id="displayNumPiece">--</span></div>
            </div>
        </div>
    </div>
    
    <!-- État de Santé Section -->
    <div class="card mb-4">
        <!-- État de Santé Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>ETAT DE SANTE</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6"><strong>Taille (cm) :</strong> <span id="displayTaille">--</span></div>
                    <div class="col-md-6"><strong>Poids (Kg) :</strong> <span id="displayPoid">--</span></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><strong>Fumeur ?</strong> <span id="displayFumeur">--</span></div>
                    <div class="col-md-6"><strong>Buvez-vous l'alcool ?</strong> <span id="displayAlcool">--</span></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><strong>Vos distractions :</strong> <span id="displayDistraction">--</span></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><strong>Etes-vous atteint d'une infirmité ?</strong> <span id="displayAccident">--</span></div>
                    <div class="col-md-6"><strong>Etes-vous en arrêt de travail ?</strong> <span>--</span></div>
                </div>
                <hr>
                <h6>Questions de Santé</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Questions</th>
                            <th>Réponse</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Avez-vous déjà été victime d'un accident</td>
                            <td id="displayAccident">--</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Suivez-vous ou avez-vous suivi un traitement médical ces 6 (six) derniers mois ?</td>
                            <td id="displayMedical">--</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Avez-vous déjà subi une transfusion de sang ?</td>
                            <td id="displayTransSang">--</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Avez-vous déjà subi des interventions chirurgicales ?</td>
                            <td id="displayInterChirugiale">--</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Devez-vous subir une intervention chirurgicale ?</td>
                            <td id="displayProchaineInterChirugiale">--</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Etes-vous sous traitement médical pour, ou souffrez-vous d'une de ces maladies ?</td>
                            <td id="displayTreatment"></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Diabète</td>
                            <td id="displayDiabetes">--</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Hypertension artérielle</td>
                            <td id="displayHypertension">--</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Drépanocytose</td>
                            <td id="displaySickleCell">--</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Cirrhose de foie</td>
                            <td id="displayLiverCirrhosis">--</td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>Affections pulmonaires</td>
                            <td id="displayLungDisease">--</td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>Cancer</td>
                            <td id="displayCancer">--</td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>Anémie</td>
                            <td id="displayAnemia">--</td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>Insuffisance rénale</td>
                            <td id="displayKidneyFailure">--</td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>Avez-vous déjà été victime d’un AVC ?</td>
                            <td id="displayStroke">--</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Détails du Prêt Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>DETAILS DU PRET</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><strong>N° Compte :</strong> <span id="displayNumerocompte">--</span></div>
                <div class="col-md-6"><strong>Type :</strong> <span class="displayTypPret">--</span></div>
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Date de mise en place prévue :</strong> <span id="displayLoanDateMiseEnPlace"></span></div>
                <div class="col-md-6"><strong>Début remboursement :</strong> <span id="displayFirstDateEcheance"></span></div>
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Fin remboursement :</strong> <span id="displayLasLoanDateRembour"></span></div>
                <div class="col-md-6"><strong>Périodicité de remboursement :</strong> <span id="displayPeriodiciterRembou"></span></div>
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Option :</strong> Individuel</div>
                <div class="col-md-6"><strong>Périodicité de paiement de la prime :</strong> <span id="displayPeriodiciterPrime"></span></div>
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Durée (Mois) :</strong> <span>{{ $simulationData['duree'] ?? '-' }}</span></div>
                <div class="col-md-6"><strong>Montant du prêt (F CFA) :</strong> {{ $simulationData['montant'] ?? '-' }}</div>
            </div>
            <div class="row">
                <div class="col-md-6"><strong>Prime (XOF) :</strong> {{ number_format($simulationData['primeFinal'] ?? '0', 2) }} Fcfa</div>
            </div>
        </div>
    </div>


    @php
        $benefData = session('beneficiary');
    @endphp

    <!-- Bénéficiaire(s) Section -->
    <div class="card">
        <div class="card-header">
            <h5>BENEFICIAIRE(S)</h5>
        </div>
        <div class="card-body">
            <table class="table mb-0 table-striped" id="loanYakobeneficiariesTable">
                <thead>
                    <tr>
                        <th scope="col">Nom & Prénoms</th>
                        <th scope="col">Né(e) le</th>
                        <th scope="col">Lieu de naissance</th>
                        <th scope="col">Lieu de résidence</th>
                        <th scope="col">Capital</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $benefData['nom'] ?? ''}} {{ $benefData['prenom'] ?? '' }}</td>
                        <td>{{ $benefData['dateNaissance'] ?? ''}}</td>
                        <td>{{ $benefData['lieuNaissance'] ?? ''}}</td>
                        <td>{{ $benefData['lieuResidence'] ?? ''}}</td>
                        <td>500 000 Fcfa</td>
                        <td>{{ $benefData['numPhone'] ?? ''}}</td>
                        <td>{{ $benefData['emailBenef'] ?? ''}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const civiliteInputs = document.querySelectorAll('input[name="civilite"]');
        const nomInput = document.querySelector('input[name="nom"]');
        const prenomInput = document.querySelector('input[name="prenom"]');
        const birthdayInput = document.querySelector('input[name="datenaissance"]');
        const lieuNaissanceSelect = document.querySelector('select[name="lieunaissance"]');
        const numeropieceInput = document.querySelector('input[name="numeropiece"]');
        const lieuresidenceSelect = document.querySelector('select[name="lieuresidence"]');
        const professionSelect = document.querySelector('select[name="profession"]');
        const employeurSelect = document.querySelector('select[name="employeur"]');
        const emailInput = document.querySelector('input[name="email"]');
        const mobileInput = document.querySelector('input[name="mobile"]');
        const telephoneInput = document.querySelector('input[name="telephone"]');
        const numerocompteInput = document.querySelector('input[name="numerocompte"]');

            // etat de sante
        const tailleInput = document.querySelector('input[name="taille"]');
        const poidsInput = document.querySelector('input[name="poids"]');
        const fumeurInput = document.querySelector('input[name="smoking"]');
        const alcoholInput = document.querySelector('input[name="alcohol"]');
        const distractionSelect = document.querySelector('select[name="distractions"]');
        const accidentInput = document.querySelector('input[name="accident"]');

        const treatmentInput = document.querySelector('input[name="treatment"]');
        const transSangInput = document.querySelector('input[name="transSang"]');
        const interChirugialeInput = document.querySelector('input[name="interChirugiale"]');
        const prochaineInterChirugialeInput = document.querySelector('input[name="prochaineInterChirugiale"]');
        const diabetesInput = document.querySelector('input[name="diabetes"]');
        const hypertensionInput = document.querySelector('input[name="hypertension"]');
        const sickleCellInput = document.querySelector('input[name="sickleCell"]');
        const liverCirrhosisInput = document.querySelector('input[name="liverCirrhosis"]');
        const lungDiseaseInput = document.querySelector('input[name="lungDisease"]');
        const cancerInput = document.querySelector('input[name="cancer"]');
        const anemiaInput = document.querySelector('input[name="anemia"]');
        const kidneyFailureInput = document.querySelector('input[name="kidneyFailure"]');
        const strokeInput = document.querySelector('input[name="stroke"]');

        // detail pret
        
        const typPretInput = document.querySelector('select[name="typPret"]');


        // affichage dans le resume
        const displayCivility = document.getElementById('displayCivility');
        const displayNom = document.getElementById('displayNom');
        const displayPrenom = document.getElementById('displayPrenom');
        const displayBirthday = document.getElementById('displayBirthday');
        const displayLieuNaissance = document.getElementById('displayLieuNaissance');
        const displayNumPiece = document.getElementById('displayNumPiece');
        const displayResidence = document.getElementById('displayResidence');
        const displayProfession = document.getElementById('displayProfession');
        const displayEmployeur = document.getElementById('displayEmployeur');
        const displayEmail = document.getElementById('displayEmail');
        const displayMobile = document.getElementById('displayMobile');
        const displayTelephone = document.getElementById('displayTelephone');
        const displayNumerocompte = document.getElementById('displayNumerocompte');

        // sante
        const displayTaille = document.getElementById('displayTaille');
        const displayPoid = document.getElementById('displayPoid');
        const displayFumeur = document.getElementById('displayFumeur');
        const displayAlcool = document.getElementById('displayAlcool');
        const displayDistraction = document.getElementById('displayDistraction');
        const displayAccident = document.getElementById('displayAccident');

        const displayTreatment = document.getElementById('displayTreatment');
        const displayTransSang = document.getElementById('displayTransSang');
        const displayInterChirugiale = document.getElementById('displayInterChirugiale');
        const displayProchaineInterChirugiale = document.getElementById('displayProchaineInterChirugiale');
        const displayDiabetes = document.getElementById('displayDiabetes');
        const displayHypertension = document.getElementById('displayHypertension');
        const displaySickleCell = document.getElementById('displaySickleCell');
        const displayLiverCirrhosis = document.getElementById('displayLiverCirrhosis');
        const displayLungDisease = document.getElementById('displayLungDisease');
        const displayCancer = document.getElementById('displayCancer');
        const displayAnemia = document.getElementById('displayAnemia');
        const displayKidneyFailure = document.getElementById('displayKidneyFailure');
        const displayStroke = document.getElementById('displayStroke');

        // detail pret
        const displayTypPret = document.getElementById('displayTypPret');

        // Mise à jour dynamique des valeurs affichées
        civiliteInputs.forEach(input => {
            input.addEventListener('change', () => {
                displayCivility.textContent = input.checked ? input.value : 'null';
            });
        });

        if (numerocompteInput) {
            numerocompteInput.addEventListener('input', () => {
                displayNumerocompte.textContent = numerocompteInput.value || 'Null';
            });
        }
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

        if (telephoneInput) {
            telephoneInput.addEventListener('input', () => {
                displayTelephone.textContent = telephoneInput.value || 'Null';
            });
        }

        // sante
        if (tailleInput) {
            tailleInput.addEventListener('input', () => {
                displayTaille.textContent = tailleInput.value || 'Null';
            });
        }
        if (poidsInput) {
            poidsInput.addEventListener('input', () => {
                displayPoid.textContent = poidsInput.value || 'Null';
            });
        }
        if (fumeurInput) {
            fumeurInput.addEventListener('input', () => {
                displayFumeur.textContent = fumeurInput.value || 'Null';
            });
        }
        if (alcoholInput) {
            alcoholInput.addEventListener('input', () => {
                displayAlcool.textContent = alcoholInput.value || 'Null';
            });
        }
        if (accidentInput) {
            accidentInput.addEventListener('input', () => {
                displayAccident.textContent = accidentInput.value || 'Null';
            });
        }

        if (distractionSelect) {
            distractionSelect.addEventListener('change', () => {
                displayDistraction.textContent = distractionSelect.value || 'Null';
            });
        }

        // sante

        treatmentInput.forEach(input => {
            input.addEventListener('change', () => {
                displayTreatment.textContent = input.checked ? input.value : 'null';
            });
        });

        transSangInput.forEach(input => {
            input.addEventListener('change', () => {
                displayTransSang.textContent = input.checked ? input.value : 'null';
            });
        });
        transSangInput.forEach(input => {
            input.addEventListener('change', () => {
                displayTransSang.textContent = input.checked ? input.value : 'null';
            });
        });
        interChirugialeInput.forEach(input => {
            input.addEventListener('change', () => {
                displayInterChirugiale.textContent = input.checked ? input.value : 'null';
            });
        });
        prochaineInterChirugialeInput.forEach(input => {
            input.addEventListener('change', () => {
                displayProchaineInterChirugiale.textContent = input.checked ? input.value : 'null';
            });
        });
        diabetesInput.forEach(input => {
            input.addEventListener('change', () => {
                displayDiabetes.textContent = input.checked ? input.value : 'null';
            });
        });
        hypertensionInput.forEach(input => {
            input.addEventListener('change', () => {
                displayHypertension.textContent = input.checked ? input.value : 'null';
            });
        });
        sickleCellInput.forEach(input => {
            input.addEventListener('change', () => {
                displaySickleCell.textContent = input.checked ? input.value : 'null';
            });
        });
        liverCirrhosisInput.forEach(input => {
            input.addEventListener('change', () => {
                displayLiverCirrhosis.textContent = input.checked ? input.value : 'null';
            });
        });
        lungDiseaseInput.forEach(input => {
            input.addEventListener('change', () => {
                displayLungDisease.textContent = input.checked ? input.value : 'null';
            });
        });
        cancerInput.forEach(input => {
            input.addEventListener('change', () => {
                displayCancer.textContent = input.checked ? input.value : 'null';
            });
        });
        anemiaInput.forEach(input => {
            input.addEventListener('change', () => {
                displayAnemia.textContent = input.checked ? input.value : 'null';
            });
        });
        kidneyFailureInput.forEach(input => {
            input.addEventListener('change', () => {
                displayKidneyFailure.textContent = input.checked ? input.value : 'null';
            });
        });
        strokeInput.forEach(input => {
            input.addEventListener('change', () => {
                strokeInput.textContent = input.checked ? input.value : 'null';
            });
        });









    });
</script>

<script>
    function updateDisplay() {
        document.getElementById("displayLoanDateMiseEnPlace").textContent = document.getElementById("loanDateMiseEnPlace").value;
        document.getElementById("displayFirstDateEcheance").textContent = document.getElementById("firstDateEcheance").value;
        document.getElementById("displayLasLoanDateRembour").textContent = document.getElementById("lasLoanDateRembour").value;

        const periodiciteRembou = document.querySelector('input[name="periodiciterRembou"]:checked');
        document.getElementById("displayPeriodiciterRembou").textContent = periodiciteRembou ? periodiciteRembou.value : '';

        const periodicitePrime = document.querySelector('input[name="periodiciterPrime"]:checked');
        document.getElementById("displayPeriodiciterPrime").textContent = periodicitePrime ? periodicitePrime.value : '';
    }
</script>