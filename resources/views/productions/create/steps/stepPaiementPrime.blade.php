<div id="test-l-4" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger4">
    <h5 class="mb-1">Informations relatives aux modes de paiement et la periodicité</h5>
    <p class="mb-4">Veuillez entrer les informations relatives aux modes de paiement et la periodicité en tenant compte
        des champs obligatoire.</p>

    <div class="row g-3">
        <div class="col-12 col-lg-6">
            <div class="card" style="width: 90%">
                <div class="card-body">
                    <label for="" class="form-label">Je souhaite payer mes primes par :</label>
                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="modepaiement" type="radio" value="Virement_bancaire" id="Virement_bancaire">
                            <label class="form-check-label" for="Virement_bancaire">
                                Virement bancaire
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="modepaiement" type="radio" value="Espece" id="Espece">
                            <label class="form-check-label" for="Espece">
                                Espèce
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="modepaiement" type="radio" value="Cheque" id="Cheque">
                            <label class="form-check-label" for="Cheque">
                                Chèque
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="modepaiement" type="radio" value="Mobile_money" id="Mobile_money">
                            <label class="form-check-label" for="Mobile_money">
                                Mobile money
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="modepaiement" type="radio" value="Prelevement_source" id="Prelevement_source">
                            <label class="form-check-label" for="Prelevement_source">
                                Prélèvement à la source
                            </label>
                        </div>
                    </div>

                    <div class="row mb-3" id="mode_bancaire" style="display: none;">
                        <div class="col-12 mb-3">
                            <label for="banque" class="form-label">Ma banque ou organisme de prélèvement</label>
                            <select class="form-select" id="banque" name="organisme">
                                <option>Selectionnez la banque</option>
                                @foreach ($societes as $item)
                                    <option value="{{ $item->MonLibelle }}">{{ $item->MonLibelle ?? ""}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="Agence" class="form-label">Agence</label>
                            <select class="form-select" id="Agence" name="agence">
                                <option>Selectionnez l'agence</option>
                                @foreach ($agences as $item)
                                    <option value="{{ $item->NOM_LONG }}">{{ $item->NOM_LONG ?? ""}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="Matricule" class="form-label">Mon N° de compte (Matricule)</label>
                            <input type="text" class="form-control" id="Matricule" name="numerocompte">
                        </div>
                    </div>

                    <div class="mb-3" id="mode_mobile" style="display: none;">
                        <div class="col-12 mb-3">
                            <label for="numMobile" class="form-label">Mon N° Mobile</label>
                            <input type="text" class="form-control" id="numMobile" name="numMobile">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-8 col-lg-8">
                            <label for="Conseiller" class="form-label">Votre conseiller client</label>
                            <input type="text" class="form-control" id="Conseiller" name="Conseiller" disabled value="{{ Auth::user()->membre->nom ?? ""}} {{ Auth::user()->membre->prenom ?? ""}}">
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <label for="CodeConseiller" class="form-label">Code</label>
                            <input type="text" class="form-control" id="CodeConseiller" name="codeConseiller" disabled value="{{ Auth::user()->membre->codeagent ?? ""}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">

            <div class="card mx-0">
                <div class="card-body">
                    <label for="" class="form-label">Je souhaite payer mes primes chaque :</label>
                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="periodicite" type="radio" value="M"
                                id="Mois">
                            <label class="form-check-label" for="Mois">
                                Mois
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="periodicite" type="radio" value="T"
                                id="Trimestre">
                            <label class="form-check-label" for="Trimestre">
                                Trimestre
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="periodicite" type="radio" value="S"
                                id="Semestre">
                            <label class="form-check-label" for="Semestre">
                                Semestre
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="periodicite" type="radio" value="A"
                                id="Annee">
                            <label class="form-check-label" for="Annee">
                                Année
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="periodicite" type="radio" value="U"
                                id="Versement_unique">
                            <label class="form-check-label" for="Versement_unique">
                                Versement unique
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="DateEffet" class="form-label">Mon contrat prendra effet le :</label>
                            <input type="date" class="form-control" id="DateEffet" name="dateEffet">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="primepricipale" class="form-label">Je souhaite payer une prime de :</label>
                            <input type="number" class="form-control" id="primepricipale" name="primepricipale" min="0">
                        </div>

                        <div class="col-12 mb-3">
                            <label for="capital" class="form-label">Capital souscrit :</label>
                            <input type="number" class="form-control" id="capital" name="capital" min="0" >
                        </div>

                        <div class="col-12 mb-3">
                            <label for="fraisadhesion" class="form-label">Fraie d'adhesion :</label>
                            <input type="number" class="form-control" id="fraisadhesion" name="fraisadhesion">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        

        <div class="col-12">
            <div class="d-flex align-items-center gap-3">
                <button onclick="event.preventDefault(); stepper1.previous()"
                    class="btn border-btn px-4 btn-previous-form"><i
                        class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                <button onclick="event.preventDefault(); stepper1.next()"
                    class="btn btn-two px-4 btn-next-form">Suivant<i
                        class='bx bx-right-arrow-alt ms-2'></i></button>
            </div>
        </div>
    </div><!---end row-->

    {{-- <script>
        document.getElementById("primepricipale").addEventListener("input", function() {
            const primeInput = document.getElementById("primepricipale");
            const primeError = document.getElementById("primepricipale-error");
    
            // Vérifiez si la valeur est inférieure au minimum autorisé
            if (parseInt(primeInput.value) < parseInt(primeInput.min)) {
                primeError.style.display = "block";
            } else {
                primeError.style.display = "none";
            }
        });
    </script> --}}

</div>
