@extends('prospects.layouts.main')
@section('content')
    
    <div class="container">
        <div class="header">
            <h1>📋 Formulaire de Souscription</h1>
            <p>Assurance - Collecte d'informations</p>
        </div>

        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-ba row">
                <div class="progress-bar-fill" id="progressFill"></div>
                <div class="step active col" data-step="1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Produits</div>
                </div>
                <div class="step col" data-step="2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Informations Personnelles</div>
                </div>
                <div class="step col" data-step="3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Assurés</div>
                </div>
                <div class="step col" data-step="4">
                    <div class="step-circle">4</div>
                    <div class="step-label">Bénéficiaires</div>
                </div>
                <div class="step col" data-step="5">
                    <div class="step-circle">5</div>
                    <div class="step-label">Infos Assurance</div>
                </div>
                <div class="step col" data-step="6">
                    <div class="step-circle">6</div>
                    <div class="step-label">Documents</div>
                </div>
            </div>
        </div>

        <form id="insuranceForm">

            <input type="hidden" name="commerciale_code" value="{{$commerciale->idmembre}}">
            <!-- Step 1: Produits -->
            <div class="form-step active" data-step="1">
                <h2 class="section-title">Produits d'Assurance</h2>
                
                <div class="info-box">
                    <p>🛡️ Sélectionnez les produits d'assurance qui vous intéressent.</p>
                </div>
                

                @include('prospects.components.steps.stepProduct')
            </div>

            <!-- Step 2: Informations Personnelles et Contacts -->
            <div class="form-step" data-step="2">
                <h2 class="section-title">Informations du Prospect/Adhérent</h2>
                
                @include('prospects.components.steps.stepAdherent')
            </div>

            <!-- Step 3: Partenaires -->
            <div class="form-step" data-step="3">
                <h2 class="section-title">Assurés</h2>
                
                <div class="form-group">
                    <label>Etre-vous vous même assuré (e)?</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="assurerAuTerme" value="oui"> Oui
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="assurerAuTerme" value="non"> Non
                        </label>
                    </div>
                </div>

                <div class="info-box">
                    <p>👨‍👩‍👧‍👦 Ajoutez les personnes que vous comptez assurer : conjoint, enfants ou autres membres liés au prospect.</p>
                </div>

                <div class="form-group">
                    <label class="required">Type d'acteur</label>
                    <div class="cards-container row">
                        <label class="partner-card col" id="card-ass" data-type="ASS" data-bs-toggle="modal" data-bs-target="#openPartnerModal">
                            Ajouter un Assuré
                        </label>
                    </div>
                </div>

                <div id="partnersList" class="added-list"></div>
            </div>
            <!-- Step 3: Partenaires -->
            <div class="form-step" data-step="4">
                <h2 class="section-title">Bénéficiaires</h2>
                

                <div class="info-box">
                    <p>👨‍👩‍👧‍👦 Ajoutez les beneficiaires au contrat: conjoint, enfants ou autres membres liés au prospect.</p>
                </div>

                <div class="form-group">
                    <label class="required">Type d'acteur</label>
                    <div class="cards-container row">
                        
                        <label class="partner-card col" id="card-ben" data-type="BEN" data-bs-toggle="modal" data-bs-target="#openPartnerModal">
                            Bénéficiaire
                        </label>
                    </div>
                </div>

                <div id="partnersList" class="added-list"></div>
            </div>

            <!-- Step 4: Informations Assurance -->
            <div class="form-step" data-step="5">
                <h2 class="section-title">Informations sur l'Assurance</h2>
                
                @include('prospects.components.steps.stepAssurance')
            </div>

            <!-- Step 5: Documents -->
            <div class="form-step" data-step="6">
                <h2 class="section-title">Documents</h2>
                
                @include('prospects.components.steps.stepDoc')
            </div>

            <!-- Navigation Buttons -->
            <div class="form-navigation">
                <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)" style="display: none;">
                    ← Précédent
                </button>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">
                    Suivant →
                </button>
                <button type="submit" class="btn btn-warning" id="submitBtn" style="display: none;">
                    ✓ Soumettre la Demande
                </button>
            </div>


        </form>

        


        <script>
            document.getElementById('insuranceForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const btnSubmit = document.getElementById('submitBtn');
                btnSubmit.textContent = 'Envoi en cours...';
                btnSubmit.disabled = true;

                // Prépare les données
                const formData = new FormData(this);
                formData.append('contacts', JSON.stringify(contacts));
                formData.append('partners', JSON.stringify(partners));

                uploadedFiles.forEach((item, index) => {
                    formData.append(`documents[${index}][file]`, item.file);
                    formData.append(`documents[${index}][nature]`, item.nature);
                });

                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
                    const response = await fetch('/prospect/store', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        btnSubmit.textContent = 'Un instant ... !';

                        setTimeout(() => {
                            window.location.href = '/prospect/finish/' + data.uuid;
                        }, 2000);

                    } else {
                        btnSubmit.disabled = false;
                        Swal.fire({
                            icon: 'error',
                            title: '❌ Erreur !' ,
                            text: 'Erreur : ' + data.message,
                            showConfirmButton: true,
                        });
                        // alert('❌ Erreur : ' + data.message);
                    }

                } catch (error) {
                    btnSubmit.disabled = false;
                    console.error('Erreur de soumission:', error);
                    alert('Une erreur est survenue lors de l’envoi du formulaire.');
                }
            });
        </script>
    </div>
    @include('prospects.components.modals.partnerModal')
@endsection