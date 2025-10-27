<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Souscription Assurance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #086633 0%, #097439 100%);
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #086633 0%, #097439 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .form-section {
            padding: 30px;
        }

        .section-title {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #ffae25;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: "";
            width: 6px;
            height: 24px;
            background: #ffae25;
            border-radius: 3px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="tel"],
        select,
        textarea {
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #ffae25;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .radio-label input[type="radio"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #086633;
            color: white;
        }

        .btn-primary:hover {
            background: #086633;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(134, 95, 37, 0.4);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
            padding: 8px 12px;
            font-size: 12px;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .added-list {
            margin-top: 20px;
        }

        .list-item {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid #086633;
        }

        .list-item-info {
            flex: 1;
        }

        .list-item-info strong {
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .list-item-info small {
            color: #666;
            font-size: 12px;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: #086633;
            color: white;
            padding: 20px;
            border-radius: 16px 16px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            font-size: 20px;
        }

        .close-modal {
            background: transparent;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.3s;
        }

        .close-modal:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .modal-body {
            padding: 30px;
        }

        /* Produits */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .product-card {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .product-card:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }

        .product-card.selected {
            border-color: #667eea;
            background: #f0f4ff;
        }

        .product-card input[type="checkbox"] {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        /* Signature */
        .signature-pad {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: crosshair;
            background: white;
            touch-action: none;
        }

        .signature-controls {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .submit-section {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
        }

        .note-section {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 20px 30px;
            border-radius: 8px;
        }

        .note-section h3 {
            color: #92400e;
            margin-bottom: 10px;
        }

        .note-section p {
            color: #78350f;
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Formulaire de Souscription</h1>
            <p>Assurance - Collecte d'informations</p>
        </div>

        <form id="insuranceForm">
            <!-- Section Souscripteur -->
            <div class="form-section">
                <h2 class="section-title">Informations du Souscripteur</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nom">Nom <span class="text-danger">*</span></label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom <span class="text-danger">*</span></label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label>Genre <span class="text-danger">*</span></label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="genre" value="M" required> Masculin
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="genre" value="F" required> Féminin
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="situation">Situation Matrimoniale <span class="text-danger">*</span></label>
                        <select id="situation" name="situation" required>
                            <option value="">Sélectionner</option>
                            <option value="celibataire">Célibataire</option>
                            <option value="marie">Marié(e)</option>
                            <option value="divorce">Divorcé(e)</option>
                            <option value="veuf">Veuf(ve)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_naissance">Date de Naissance <span class="text-danger">*</span></label>
                        <input type="date" id="date_naissance" name="date_naissance" required>
                    </div>
                    <div class="form-group">
                        <label for="lieu_naissance">Lieu de Naissance </label>
                        <select name="lieu_naissance" id="lieu_naissance">
                            <option value="" disabled selected> Sélectionner le lieu</option>
                            @foreach ($villes as $ville)
                                <option value="{{ $ville->CodeVille }}">{{ $ville->MonLibelle ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profession">Profession <span class="text-danger">*</span></label>
                        <input type="text" id="profession" name="profession" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone <span class="text-danger">*</span></label>
                        <input type="tel" id="telephone" name="telephone" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="form-group full-width">
                        <label for="lieu_residence">Lieu de Résidence *</label>
                        <select name="lieu_residence" id="lieu_residence">
                            <option value="" disabled selected> Sélectionner le lieu</option>
                            @foreach ($villes as $ville)
                                <option value="{{ $ville->CodeVille }}">{{ $ville->MonLibelle ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                            <label for="" class="form-label">Nature de la pièce <span class="text-danger">*</span></label>
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="naturepiece" id="CNI" value="CNI" autocomplete="on" required>
                                <label class="form-check-label" for="CNI">CNI</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="naturepiece" id="Atestation" value="AT" autocomplete="on" required>
                                <label class="form-check-label" for="Atestation">Attestation </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="naturepiece" id="Passport" value="Passport" autocomplete="on" required>
                                <label class="form-check-label" for="Passport">Passeport</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="naturepiece" id="CarteConsulaire" value="CarteConsulaire" autocomplete="on" required>
                                <label class="form-check-label" for="CarteConsulaire">Carte Consulaire</label>
                            </div>

                        
                    </div>
                    <div class="form-group">
                        <label for="numeropiece" class="form-label">numéro de la pièce<span class="text-danger">*</span></label>
                        <input type="text" name="numeropiece" class="form-control" id="numeropiece"
                            placeholder="Nature de la pièce d'identité" autocomplete="on" required>
                    </div>
                    
                </div>
            </div>

            <!-- Section Assurés -->
            <div class="form-section">
                <h2 class="section-title">Assurés</h2>
                <div class="form-group">
                    <label>Le souscripteur est-il l'assuré ? *</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="souscripteur_assure" value="oui" required> Oui
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="souscripteur_assure" value="non" required> Non
                        </label>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="openModal('assure')">
                    + Ajouter un Assuré
                </button>
                <div id="assuresList" class="added-list"></div>
            </div>

            <!-- Section Bénéficiaires -->
            <div class="form-section">
                <h2 class="section-title">Bénéficiaires</h2>
                <button type="button" class="btn btn-primary" onclick="openModal('beneficiaire')">
                    + Ajouter un Bénéficiaire
                </button>
                <div id="beneficiairesList" class="added-list"></div>
            </div>

            <!-- Section Produits -->
            <div class="form-section">
                <h2 class="section-title">Produits d'Assurance</h2>
                <p style="color: #666; margin-bottom: 20px;">Sélectionnez les produits qui vous intéressent :</p>
                <div class="products-grid">
                    <div class="product-card" onclick="toggleProduct(this)">
                        <label style="cursor: pointer; display: flex; align-items: center;">
                            <input type="checkbox" name="produits[]" value="vie">
                            <div>
                                <strong>Assurance Vie</strong>
                                <p style="font-size: 12px; color: #666; margin-top: 5px;">Protection et épargne</p>
                            </div>
                        </label>
                    </div>
                    <div class="product-card" onclick="toggleProduct(this)">
                        <label style="cursor: pointer; display: flex; align-items: center;">
                            <input type="checkbox" name="produits[]" value="auto">
                            <div>
                                <strong>Assurance Auto</strong>
                                <p style="font-size: 12px; color: #666; margin-top: 5px;">Véhicules</p>
                            </div>
                        </label>
                    </div>
                    <div class="product-card" onclick="toggleProduct(this)">
                        <label style="cursor: pointer; display: flex; align-items: center;">
                            <input type="checkbox" name="produits[]" value="habitation">
                            <div>
                                <strong>Assurance Habitation</strong>
                                <p style="font-size: 12px; color: #666; margin-top: 5px;">Logement</p>
                            </div>
                        </label>
                    </div>
                    <div class="product-card" onclick="toggleProduct(this)">
                        <label style="cursor: pointer; display: flex; align-items: center;">
                            <input type="checkbox" name="produits[]" value="sante">
                            <div>
                                <strong>Assurance Santé</strong>
                                <p style="font-size: 12px; color: #666; margin-top: 5px;">Mutuelle</p>
                            </div>
                        </label>
                    </div>
                    <div class="product-card" onclick="toggleProduct(this)">
                        <label style="cursor: pointer; display: flex; align-items: center;">
                            <input type="checkbox" name="produits[]" value="deces">
                            <div>
                                <strong>Assurance Décès</strong>
                                <p style="font-size: 12px; color: #666; margin-top: 5px;">Obsèques</p>
                            </div>
                        </label>
                    </div>
                    <div class="product-card" onclick="toggleProduct(this)">
                        <label style="cursor: pointer; display: flex; align-items: center;">
                            <input type="checkbox" name="produits[]" value="voyage">
                            <div>
                                <strong>Assurance Voyage</strong>
                                <p style="font-size: 12px; color: #666; margin-top: 5px;">Déplacements</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Section Signature -->
            <div class="form-section">
                <h2 class="section-title">Signature Électronique</h2>
                <p style="color: #666; margin-bottom: 15px;">Signez dans le cadre ci-dessous :</p>
                <canvas id="signaturePad" class="signature-pad" width="800" height="200"></canvas>
                <div class="signature-controls">
                    <button type="button" class="btn btn-secondary" onclick="clearSignature()">
                        🗑️ Effacer
                    </button>
                </div>
            </div>

            <!-- Note de fin -->
            <div class="note-section">
                <h3>⚠️ Note Importante</h3>
                <p>
                    En soumettant ce formulaire, vous confirmez que toutes les informations fournies sont exactes et complètes. 
                    Ces informations seront utilisées pour établir votre contrat d'assurance. Toute fausse déclaration peut 
                    entraîner la nullité du contrat ou la réduction des prestations. Vos données personnelles seront traitées 
                    conformément à notre politique de confidentialité et aux réglementations en vigueur.
                </p>
            </div>

            <!-- Submit -->
            <div class="submit-section">
                <button type="submit" class="btn btn-primary" style="padding: 15px 40px; font-size: 16px;">
                    ✓ Soumettre la Demande
                </button>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div id="personModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle"></h2>
                <button type="button" class="close-modal" onclick="closeModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="modal_nom">Nom *</label>
                        <input type="text" id="modal_nom" required>
                    </div>
                    <div class="form-group">
                        <label for="modal_prenom">Prénom *</label>
                        <input type="text" id="modal_prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="modal_date_naissance">Date de Naissance *</label>
                        <input type="date" id="modal_date_naissance" required>
                    </div>
                    <div class="form-group">
                        <label for="modal_lieu_naissance">Lieu de Naissance *</label>
                        <input type="text" id="modal_lieu_naissance" required>
                    </div>
                    <div class="form-group">
                        <label for="modal_telephone">Numéro de Téléphone *</label>
                        <input type="tel" id="modal_telephone" required>
                    </div>
                    <div class="form-group col-12">
                        <label for="modal_autre">Autres Informations</label>
                        <textarea id="modal_autre" rows="3"></textarea>
                    </div>
                </div>
                <div style="margin-top: 20px; text-align: right;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()" style="margin-right: 10px;">
                        Annuler
                    </button>
                    <button type="button" class="btn btn-primary" onclick="addPerson()">
                        Ajouter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Variables globales
        let currentModalType = '';
        let assures = [];
        let beneficiaires = [];
        let signaturePad;
        let isDrawing = false;

        // Initialisation de la signature
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('signaturePad');
            const ctx = canvas.getContext('2d');
            
            signaturePad = { canvas, ctx };
            
            // Événements souris
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseout', stopDrawing);
            
            // Événements tactiles
            canvas.addEventListener('touchstart', handleTouch);
            canvas.addEventListener('touchmove', handleTouch);
            canvas.addEventListener('touchend', stopDrawing);
        });

        function startDrawing(e) {
            isDrawing = true;
            const rect = signaturePad.canvas.getBoundingClientRect();
            signaturePad.ctx.beginPath();
            signaturePad.ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
        }

        function draw(e) {
            if (!isDrawing) return;
            const rect = signaturePad.canvas.getBoundingClientRect();
            signaturePad.ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
            signaturePad.ctx.strokeStyle = '#000';
            signaturePad.ctx.lineWidth = 2;
            signaturePad.ctx.stroke();
        }

        function stopDrawing() {
            isDrawing = false;
        }

        function handleTouch(e) {
            e.preventDefault();
            const touch = e.touches[0];
            const mouseEvent = new MouseEvent(e.type === 'touchstart' ? 'mousedown' : e.type === 'touchmove' ? 'mousemove' : 'mouseup', {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            signaturePad.canvas.dispatchEvent(mouseEvent);
        }

        function clearSignature() {
            signaturePad.ctx.clearRect(0, 0, signaturePad.canvas.width, signaturePad.canvas.height);
        }

        // Gestion du modal
        function openModal(type) {
            currentModalType = type;
            document.getElementById('modalTitle').textContent = type === 'assure' ? 'Ajouter un Assuré' : 'Ajouter un Bénéficiaire';
            document.getElementById('personModal').classList.add('active');
            
            // Réinitialiser les champs
            document.getElementById('modal_nom').value = '';
            document.getElementById('modal_prenom').value = '';
            document.getElementById('modal_date_naissance').value = '';
            document.getElementById('modal_lieu_naissance').value = '';
            document.getElementById('modal_telephone').value = '';
            document.getElementById('modal_autre').value = '';
        }

        function closeModal() {
            document.getElementById('personModal').classList.remove('active');
        }

        function addPerson() {
            const nom = document.getElementById('modal_nom').value;
            const prenom = document.getElementById('modal_prenom').value;
            const dateNaissance = document.getElementById('modal_date_naissance').value;
            const lieuNaissance = document.getElementById('modal_lieu_naissance').value;
            const telephone = document.getElementById('modal_telephone').value;
            const autre = document.getElementById('modal_autre').value;

            if (!nom || !prenom || !dateNaissance || !lieuNaissance || !telephone) {
                alert('Veuillez remplir tous les champs obligatoires');
                return;
            }

            const person = {
                nom,
                prenom,
                dateNaissance,
                lieuNaissance,
                telephone,
                autre
            };

            if (currentModalType === 'assure') {
                assures.push(person);
                renderList('assuresList', assures, 'assure');
            } else {
                beneficiaires.push(person);
                renderList('beneficiairesList', beneficiaires, 'beneficiaire');
            }

            closeModal();
        }

        function renderList(listId, items, type) {
            const container = document.getElementById(listId);
            container.innerHTML = '';

            items.forEach((item, index) => {
                const div = document.createElement('div');
                div.className = 'list-item';
                div.innerHTML = `
                    <div class="list-item-info">
                        <strong>${item.prenom} ${item.nom}</strong>
                        <small>Né(e) le ${item.dateNaissance} à ${item.lieuNaissance} • ${item.telephone}</small>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="removePerson('${type}', ${index})">
                        Supprimer
                    </button>
                `;
                container.appendChild(div);
            });
        }

        function removePerson(type, index) {
            if (type === 'assure') {
                assures.splice(index, 1);
                renderList('assuresList', assures, 'assure');
            } else {
                beneficiaires.splice(index, 1);
                renderList('beneficiairesList', beneficiaires, 'beneficiaire');
            }
        }

        function toggleProduct(card) {
            const checkbox = card.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            card.classList.toggle('selected');
        }

        // Soumission du formulaire
        document.getElementById('insuranceForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Vérifier la signature
            const canvas = document.getElementById('signaturePad');
            const ctx = canvas.getContext('2d');
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const hasSignature = imageData.data.some(channel => channel !== 0);

            if (!hasSignature) {
                alert('Veuillez apposer votre signature avant de soumettre le formulaire');
                return;
            }

            // Vérifier qu'au moins un produit est sélectionné
            const produits = document.querySelectorAll('input[name="produits[]"]:checked');
            if (produits.length === 0) {
                alert('Veuillez sélectionner au moins un produit d\'assurance');
                return;
            }

            // Collecter toutes les données
            const formData = new FormData(this);
            formData.append('assures', JSON.stringify(assures));
            formData.append('beneficiaires', JSON.stringify(beneficiaires));
            formData.append('signature', canvas.toDataURL());

            // Afficher les données (à remplacer par l'envoi réel)
            console.log('Données du formulaire:', Object.fromEntries(formData));
            console.log('Assurés:', assures);
            console.log('Bénéficiaires:', beneficiaires);

            alert('Formulaire soumis avec succès! Consultez la console pour voir les données.');
            
            // Dans Laravel Blade, vous enverriez les données ainsi:
            // fetch('/votre-route', {
            //     method: 'POST',
            //     body: formData,
            //     headers: {
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            //     }
            // })
        });
    </script>
</body>
</html>