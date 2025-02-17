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
                    <li class="breadcrumb-item active" aria-current="page">Demande de prestation | {{ $typePrestation->libelle ?? '' }} : <span id="motifAutre1" class="text-warning"></span> </li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div id="stepper1" class="bs-stepper">
      <div class="card" style="background-color: #E7F0EB">
            <div class="card-header text-center">
                <h5 class="mb-1">Demande de prestation | {{ $typePrestation->libelle ?? '' }} : <span id="motifAutre2" class="text-success"></span></h5>
                <p class="mb-4">Veuillez remplir les informations ci-dessous</p>
            </div>
          {{-- @include('users.espace_client.services.prestations.modals.infosMontantModal') --}}
          <div class="card-body"> 
            <div class="bs-stepper-content">
              <form action="{{ route('prestation.storePrestAutre')}}" id="PrestationAutre" method="POST" enctype="multipart/form-data" class="submitForm">
                @csrf
                  <input type="hidden" class="form-control" id="nom" name="nom" 
                          value="{{ $contractDetails['nomSous'] ?? '' }}" 
                          placeholder="Votre Nom">
                          
                  <input type="hidden" name="type" value="{{ $typePrestation->libelle ?? '' }}">
                  <input type="hidden" name="idclient" value="{{ $membreDetails->idmembre ?? '' }}">

                  <input type="hidden" class="form-control" id="prenom" name="prenom" 
                          value="{{ $contractDetails['PrenomSous'] ?? '' }}" 
                          placeholder="Votre Prénom">
                  <div class="row g-3 mb-3">
                    
                  </div>
                  <div class="row g-3 mb-3"> 
                    <div class="col-12 col-lg-6">
                      <label for="single-select-fiel" class="form-label">Pour quel Contrat demandez-vous la prestation ?</label>
                      <select class="form-select" name="idcontrat" id="single-select-fiel" data-placeholder="Veuillez sélectionner l'ID du contrat" required readonly>
                        <option></option>
                        <option value="{{ $contractDetails['IdProposition'] ?? '' }}" selected>
                            {{ $contractDetails['IdProposition'] ?? '' }}</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-6">
                      <label for="single-select-field" class="form-label">Pour quel motif demandez-vous la prestation ? <span class="star">*</span></label>
                      <select class="form-select" name="typeprestation" id="single-select-fie" data-placeholder="" required>
                          <option selected value="">Veuillez sélectionne le motif de votre demande</option>
                          @foreach($typeOperation as $operation)
                              <option value="{{$operation['MonLibelle']}}">{{$operation['MonLibelle']}}</option>
                          @endforeach
                      </select>
                    </div>
                      <input type="hidden" class="form-control" id="lieunaissance" name="lieunaissance" 
                               value="{{ $contractDetails['LieuNaissance'] ?? '' }}" 
                               placeholder="">
                  </div>
                  <div class="row g-3 mb-3">
                    <div class="col-12 col-lg-6">
                        <label for="cel" class="form-label">Sur quelle N° de téléphone pouvons vous contacter ? <span class="star">*</span></label>
                        <input type="number" class="form-control" id="cel" name="cel" 
                              value="{{$membreDetails->cel ?? ''}}" 
                              placeholder="Téléphone principal" required> 
                    </div>
                    <div class="col-12 col-lg-6">
                      <label for="email" class="form-label">Quelle est votre adresse email ? <span class="star">*</span></label>
                      <input type="email" class="form-control" id="email" name="email" 
                              value="{{$membreDetails->email ?? ''}}" 
                              placeholder="Votre adresse email" required>
                    </div>
                  </div>

                  <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="AutresInfos" class="form-label">Décrivez-vous le besoin (<span class="text-danger">Soyez plus clair et precis </span>)</label>
                        <textarea class="form-control" name="msgClient" id="AutresInfos" rows="5" placeholder="Veuillez décrire votre besoin en quelques lignes ici" autocomplete="off"></textarea>
                    </div>
                  </div>
                  <div class="card mb-3">
                    <div class="card-header"> 
                       <h5 class="mb-0">Pièces d'identité (En image : PNG, JPEG ou JPG)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <label class="form-label">Joindre votre CNI <strong><small>(Recto)</small></strong> </label>
                                        </div>
                                        <div class="card-body">
                                            <input id="CNIrecto-file-uploa" class="form-control" type="file" name="libelle[]" accept=".jpg, .png, image/jpeg, image/png" required>
                                            <input type="hidden" name="type[]" value="CNIrecto">
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <label class="form-label">Joindre le CNI <strong><small>(Verso)</small></strong> </label>
                                        </div>
                                        <div class="card-body">
                                            <input id="CNIverso-file-uploa" class="form-control" type="file" name="libelle[]" accept=".jpg, .png, image/jpeg, image/png" required>
                                            <input type="hidden" name="type[]" value="CNIverso">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                  <div class="row">
                    <div class="col-12 d-flex justify-content-end gap-3">
                        {{-- <button class="btn2 border-btn2 px-4" type="button" onclick="stepper1.previous()"><i class='bx bx-left-arrow-alt me-2 fs-4'></i>étape prédédente</button> --}}
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </div>
                </div>
                    
              </form>
            </div>
             
          </div>
         </div>
       </div>
      <!--end stepper one-->

      <script>
        // document.querySelector('.submitForm').addEventListener('submit', function (event) {
        //     event.preventDefault(); // Empêche le rechargement par défaut du formulaire
    
        //     const form = this;
        //     const submitButton = form.querySelector('button[type="submit"]');
        //     if (submitButton.disabled) return; // Empêche une soumission multiple
    
        //     submitButton.disabled = true; // Désactive le bouton pour éviter les soumissions multiples
    
        //     const formData = new FormData(form);
    
        //     // Crée un nouvel onglet immédiatement pour éviter le blocage
        //     const newTab = window.open('about:blank', '_blank');
    
        //     fetch(form.action, {
        //         method: form.method,
        //         headers: {
        //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        //         },
        //         body: formData,
        //     })
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.type === 'success' && data.pdf_url) {
        //                 // Redirige le nouvel onglet à l'URL du PDF
        //                 newTab.location.href = data.pdf_url;
        //             } else {
        //                 // Ferme le nouvel onglet en cas d'erreur
        //                 newTab.close();
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Erreur :', error);
        //             // Ferme le nouvel onglet en cas d'erreur
        //             newTab.close();
        //         })
        //         .finally(() => {
        //             submitButton.disabled = false; // Réactive le bouton après le traitement
        //         });
        // });
        document.addEventListener('DOMContentLoaded', function () {
    const formulaire = document.getElementById('PrestationAutre');
    if (!formulaire) {
        console.error("Le formulaire avec l'ID 'PrestationAutre' est introuvable !");
        return;
    }

    // Cibler l'élément avec le name "typeprestation"
    const typePrestation = formulaire.querySelector('[name="typeprestation"]');
    const motifAutre1 = document.getElementById('motifAutre1'); // ID spécifique pour le span
    const motifAutre2 = document.getElementById('motifAutre2'); // ID spécifique pour le span

    // Vérifiez si les éléments existent
    if (!typePrestation || !motifAutre1 || !motifAutre2) {
        console.error("Un ou plusieurs éléments HTML sont introuvables !");
        return;
    }

    // Fonction pour mettre à jour le texte du span
    function updateMotif() {
        const selectedValue = typePrestation.value; // Récupère la valeur sélectionnée
        console.log("Valeur sélectionnée :", selectedValue); // Log pour déboguer
        motifAutre1.textContent = selectedValue || "Aucun motif sélectionné"; // Met à jour le span
        motifAutre2.textContent = selectedValue || "Aucun motif sélectionné"; // Met à jour le span
    }

    // Ajouter un événement 'change' sur le select
    typePrestation.addEventListener('change', updateMotif);

    // Initialiser la valeur au chargement de la page
    updateMotif();
});


    </script>
    
    
@endsection
