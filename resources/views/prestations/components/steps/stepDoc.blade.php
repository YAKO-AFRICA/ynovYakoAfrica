{{-- <div class="card">
    <div class="card-header text-center">
        <h5 class="mb-1">Documents requis (en PDF, PNG ou JPEG)</h5>
        <p class="mb-4">Vueillez joindre les documents demander ci-dessous pour finaliser votre demande </p>
    </div>
    
    <div class="card-body">
        <div class="card mb-3">
            <div class="card-header"> 
               <h5 class="mb-0">Documents relatifs aux contrats</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Quel type de document avez-vous en votre possession ?</label>
                        <select name="typeFile" class="form-select" id="typeFile" required>
                            <option value="Police">Police du contrat</option>
                            <option value="bulletin">Bulletin de souscription</option>
                            <option value="AttestationPerteContrat">Attestation de perte du contrat</option>
                        </select>
                       
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Joindre le document ici !</label>
                        <input id="Police-file-uploa" type="file" class="form-control" name="libelle[]" accept=".jpg, .png, image/jpeg, image/png, .pdf" required>
                        <input type="hidden" name="type[]" value="" id="DocName">
                        <input type="hidden" name="filename[]" value="Contrat d'assurance">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header"> 
                <h5 class="mb-0">Pièces d'identité du demandeur</h5>
            </div>

            <div class="card-body">
                <div class="row">

                    <!-- CNI Recto -->
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">
                            Joindre votre CNI <strong><small>(Recto)</small></strong>
                        </label>
                        <input
                            id="CNIrecto-file-uploa"
                            class="form-control"
                            type="file"
                            name="libelle[]"
                            accept="image/*"
                            capture="environment"
                            required
                        >
                        <input type="hidden" name="filename[]" value="CNI recto">
                        <input type="hidden" name="type[]" value="CNIrecto">
                        
                    </div>

                    <!-- CNI Verso -->
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">
                            Joindre votre CNI <strong><small>(Verso)</small></strong>
                        </label>
                        <input
                            id="CNIverso-file-uploa"
                            class="form-control"
                            type="file"
                            name="libelle[]"
                            accept="image/*"
                            capture="environment"
                            required
                        >
                        <input type="hidden" name="filename[]" value="CNI verso">
                        <input type="hidden" name="type[]" value="CNIverso">
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"> 
               <h5 class="mb-0">Documents relatifs au compte pour le paiement</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3" id="FicheIDNum">
                        <label class="form-label">Fiche d'identification du n° de telephone avec le caché de l'opérateur téléphonique<small> <strong>(Ou la capture d'écran de la vérification par la syntaxe)</strong></small> </label>
                        <input id="FicheID-file-uploa" class="form-control" type="file" name="libelle[]" accept="image/*, .pdf">
                        <input type="hidden" name="filename[]" value="Fiche d'identification du n° de telephone">
                        <input type="hidden" name="type[]" value="FicheIDNum">
                    </div>
                    <div class="col-12 mb-3" id="RIB-file">
                        <label class="form-label">Joindre le RIB <strong>(Compte courant)</strong></label>
                        <input id="RIB-file-uploa" class="form-control" type="file" name="libelle[]" accept="image/*, .pdf">
                        <input type="hidden" name="filename[]" value="RIB">
                        <input type="hidden" name="type[]" value="RIB">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="card">
    <div class="card-header text-center">
        <h5 class="mb-1">Documents requis (en PDF, PNG ou JPEG)</h5>
        <p class="mb-4">Veuillez joindre les documents demandés ci-dessous pour finaliser votre demande</p>
    </div>
    
    <div class="card-body">
        <div class="card mb-3">
            <div class="card-header"> 
               <h5 class="mb-0">Documents relatifs aux contrats</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Quel type de document avez-vous en votre possession ?</label>
                        <select name="typeFile" class="form-select" id="typeFile" required>
                            <option value="Police">Police du contrat</option>
                            <option value="bulletin">Bulletin de souscription</option>
                            <option value="AttestationPerteContrat">Attestation de perte du contrat</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 mb-3 document-upload-container" data-doc-name="Contrat d'assurance">
                        <label class="form-label">Joindre le document ici !</label>
                        <input id="Police-file-uploa" type="file" class="form-control document-file-input" name="libelle[]" accept=".jpg, .png, image/jpeg, image/png, .pdf" required>
                        <input type="hidden" name="type[]" value="" id="DocName">
                        <input type="hidden" name="filename[]" value="Contrat d'assurance">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header"> 
                <h5 class="mb-0">Pièces d'identité du demandeur</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- CNI Recto -->
                    <div class="col-12 col-md-6 mb-3 document-upload-container" data-doc-name="CNI recto">
                        <label class="form-label">
                            Joindre votre CNI <strong><small>(Recto)</small></strong>
                        </label>
                        <input id="CNIrecto-file-uploa" class="form-control document-file-input" type="file" name="libelle[]" accept="image/*" capture="environment" required>
                        <input type="hidden" name="filename[]" value="CNI recto">
                        <input type="hidden" name="type[]" value="CNIrecto">
                    </div>

                    <!-- CNI Verso -->
                    <div class="col-12 col-md-6 mb-3 document-upload-container" data-doc-name="CNI verso">
                        <label class="form-label">
                            Joindre votre CNI <strong><small>(Verso)</small></strong>
                        </label>
                        <input id="CNIverso-file-uploa" class="form-control document-file-input" type="file" name="libelle[]" accept="image/*" capture="environment" required>
                        <input type="hidden" name="filename[]" value="CNI verso">
                        <input type="hidden" name="type[]" value="CNIverso">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"> 
               <h5 class="mb-0">Documents relatifs au compte pour le paiement</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3 document-upload-container" data-doc-name="Fiche d'identification" id="FicheIDNum">
                        <label class="form-label">Fiche d'identification du n° de telephone avec le cachet de l'opérateur téléphonique<small> <strong>(Ou la capture d'écran de la vérification par la syntaxe)</strong></small></label>
                        <input id="FicheID-file-uploa" class="form-control document-file-input" type="file" name="libelle[]" accept="image/*, .pdf">
                        <input type="hidden" name="filename[]" value="Fiche d'identification du n° de telephone">
                        <input type="hidden" name="type[]" value="FicheIDNum">
                    </div>
                    <div class="col-12 mb-3 document-upload-container" data-doc-name="RIB" id="RIB-file">
                        <label class="form-label">Joindre le RIB <strong>(Compte courant)</strong></label>
                        <input id="RIB-file-uploa" class="form-control document-file-input" type="file" name="libelle[]" accept="image/*, .pdf">
                        <input type="hidden" name="filename[]" value="RIB">
                        <input type="hidden" name="type[]" value="RIB">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overlay universel pour le délimiteur -->
<div class="camera-guide-overlay" id="cameraGuideOverlay" style="display: none;">
    <div class="guide-content">
        <div class="guide-header">
            <h5 id="guideDocumentTitle">Prendre une photo</h5>
            <button type="button" class="btn-close close-guide-btn" onclick="hideCameraGuide()" aria-label="Fermer"></button>
        </div>
        
        <!-- Conteneur pour la vidéo -->
        <div class="video-container" id="videoContainer">
            <video id="cameraVideo" autoplay playsinline></video>
            
            <!-- Délimiteur adaptable selon le type de document -->
            <div class="guide-overlay-frame" id="guideOverlayFrame">
                <div class="guide-corner top-left"></div>
                <div class="guide-corner top-right"></div>
                <div class="guide-corner bottom-left"></div>
                <div class="guide-corner bottom-right"></div>
                <div class="guide-label" id="guideLabel">Document</div>
                <div class="guide-instruction" id="guideInstruction">Placez le document dans le cadre</div>
            </div>
        </div>

        <!-- Zone de prévisualisation (cachée par défaut) -->
        <div class="preview-container" id="previewContainer" style="display: none;">
            <div class="preview-header">
                <h5>Aperçu de la photo</h5>
            </div>
            <div class="preview-image-container">
                <img id="previewImage" src="" alt="Aperçu">
            </div>
            <div class="preview-actions">
                <button type="button" class="btn btn-secondary" onclick="retakePhoto()">
                    <i class="bi bi-arrow-repeat"></i> Reprendre
                </button>
                <button type="button" class="btn btn-success" onclick="confirmPhoto()">
                    <i class="bi bi-check-lg"></i> Valider
                </button>
            </div>
        </div>
        
        <div class="guide-actions" id="cameraActions">
            <button type="button" class="btn btn-secondary" onclick="switchCamera()">
                <i class="bi bi-arrow-repeat"></i> Changer caméra
            </button>
            <button type="button" class="btn btn-primary capture-btn" onclick="capturePhoto()">
                <i class="bi bi-camera"></i> Prendre la photo
            </button>
        </div>
        
        <!-- Options supplémentaires -->
        <div class="guide-footer" id="galleryOption">
            <button type="button" class="btn btn-link" onclick="uploadFromGallery()">
                <i class="bi bi-images"></i> Choisir depuis la galerie
            </button>
        </div>
    </div>
</div>

<!-- Input file caché pour la galerie -->
<input type="file" id="hiddenGalleryInput" accept="image/*, .pdf" style="display: none;">

<!-- Styles pour le délimiteur universel -->
<style>
    /* Overlay principal */
    .camera-guide-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #000;
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .guide-content {
        width: 100%;
        height: 100%;
        max-width: 600px;
        max-height: 800px;
        background: #000;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    /* En-tête */
    .guide-header {
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 10;
    }

    .guide-header h5 {
        margin: 0;
        color: white;
        font-size: 18px;
    }

    .btn-close {
        filter: brightness(0) invert(1);
        opacity: 1;
    }

    /* Conteneur vidéo */
    .video-container {
        flex: 1;
        position: relative;
        overflow: hidden;
        background: #000;
    }

    #cameraVideo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Guide overlay frame */
    .guide-overlay-frame {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        max-width: 400px;
        height: auto;
        aspect-ratio: 1.586 / 1; /* Ratio carte d'identité (85.6mm x 54mm) */
        border: 2px dashed rgba(255, 255, 255, 0.5);
        border-radius: 10px;
        box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5);
        pointer-events: none;
    }

    /* Coins du cadre */
    .guide-corner {
        position: absolute;
        width: 30px;
        height: 30px;
        border: 3px solid #00ff00;
        filter: drop-shadow(0 0 5px rgba(0, 255, 0, 0.5));
    }

    .guide-corner.top-left {
        top: -2px;
        left: -2px;
        border-right: none;
        border-bottom: none;
    }

    .guide-corner.top-right {
        top: -2px;
        right: -2px;
        border-left: none;
        border-bottom: none;
    }

    .guide-corner.bottom-left {
        bottom: -2px;
        left: -2px;
        border-right: none;
        border-top: none;
    }

    .guide-corner.bottom-right {
        bottom: -2px;
        right: -2px;
        border-left: none;
        border-top: none;
    }

    /* Étiquettes */
    .guide-label {
        position: absolute;
        top: -40px;
        left: 0;
        right: 0;
        text-align: center;
        color: white;
        font-size: 18px;
        font-weight: bold;
        text-shadow: 1px 1px 3px black;
        background: rgba(0, 150, 0, 0.7);
        padding: 5px;
        border-radius: 5px;
        width: fit-content;
        margin: 0 auto;
    }

    .guide-instruction {
        position: absolute;
        bottom: -40px;
        left: 0;
        right: 0;
        text-align: center;
        color: white;
        font-size: 14px;
        text-shadow: 1px 1px 2px black;
        background: rgba(0, 0, 0, 0.7);
        padding: 5px;
        border-radius: 5px;
    }

    /* Boutons d'action */
    .guide-actions {
        padding: 15px;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .guide-actions .btn {
        flex: 1;
        padding: 12px;
        font-size: 16px;
        border-radius: 25px;
    }

    .guide-footer {
        padding: 10px 15px 20px;
        background: rgba(0, 0, 0, 0.9);
        text-align: center;
    }

    .guide-footer .btn-link {
        color: white;
        text-decoration: none;
        font-size: 16px;
    }

    .guide-footer .btn-link:hover {
        text-decoration: underline;
    }

    .capture-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        font-weight: bold;
    }

    .capture-btn:active {
        transform: scale(0.98);
    }

    /* Animation flash */
    @keyframes flash {
        0% { opacity: 1; }
        50% { opacity: 0.3; }
        100% { opacity: 1; }
    }

    .flash-animation {
        animation: flash 0.3s;
    }

    /* Types de cadres spécifiques */
    .guide-overlay-frame.id-card {
        aspect-ratio: 1.586 / 1; /* CNI */
    }

    .guide-overlay-frame.a4-document {
        aspect-ratio: 1 / 1.414; /* A4 */
    }

    .guide-overlay-frame.receipt {
        aspect-ratio: 1 / 1.5; /* Ticket de caisse */
    }

    .guide-overlay-frame.square {
        aspect-ratio: 1 / 1; /* Carré */
    }

    /* Responsive */
    @media (max-width: 768px) {
        .guide-overlay-frame {
            width: 90%;
        }
        
        .guide-label {
            font-size: 16px;
            top: -35px;
        }
        
        .guide-instruction {
            font-size: 12px;
            bottom: -35px;
        }
    }
</style>






<script>
    let currentFileInput = null;
    let currentStream = null;
    let currentVideoElement = null;
    let currentFacingMode = 'environment';
    let documentType = 'id-card';
    let capturedBlob = null;

    // Vérifier si l'API MediaDevices est disponible
    function isMediaDevicesSupported() {
        return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
    }

    // Vérifier si on est sur un appareil mobile
    function isMobileDevice() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    // Initialisation : intercepter les clics sur tous les inputs file
    document.addEventListener('DOMContentLoaded', function() {
        const fileInputs = document.querySelectorAll('input[type="file"]');
        
        fileInputs.forEach(input => {
            input.addEventListener('click', function(e) {
                // Sur ordinateur ou si l'API caméra n'est pas disponible, on laisse le comportement par défaut
                if (!isMobileDevice() || !isMediaDevicesSupported()) {
                    console.log('Mode ordinateur : comportement par défaut');
                    return true;
                }
                
                // Sur mobile avec API caméra disponible, on utilise notre interface
                e.preventDefault();
                
                currentFileInput = this;
                
                const container = this.closest('.document-upload-container');
                let docName = '';
                
                if (container) {
                    docName = container.getAttribute('data-doc-name') || 'Document';
                } else {
                    const hiddenFilename = this.parentNode.querySelector('input[name="filename[]"]');
                    docName = hiddenFilename ? hiddenFilename.value : 'Document';
                }
                
                adaptGuideForDocument(docName);
                openCameraGuide();
            });
            
            input.addEventListener('change', function(e) {
                if (this.files && this.files.length > 0) {
                    console.log('Fichier sélectionné:', this.files[0].name);
                }
            });
        });

        // Gestionnaire pour l'input caché de la galerie
        const hiddenInput = document.getElementById('hiddenGalleryInput');
        if (hiddenInput) {
            hiddenInput.addEventListener('change', function(e) {
                if (this.files && this.files.length > 0 && currentFileInput) {
                    // Transférer le fichier sélectionné vers l'input original
                    const file = this.files[0];
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    currentFileInput.files = dataTransfer.files;
                    
                    // Déclencher l'événement change
                    currentFileInput.dispatchEvent(new Event('change', { bubbles: true }));
                    
                    // Fermer le guide
                    hideCameraGuide();
                    
                    showNotification('Fichier sélectionné avec succès!', 'success');
                }
            });
        }
    });

    function adaptGuideForDocument(docName) {
        const guideFrame = document.getElementById('guideOverlayFrame');
        const guideLabel = document.getElementById('guideLabel');
        const guideInstruction = document.getElementById('guideInstruction');
        const guideTitle = document.getElementById('guideDocumentTitle');
        
        if (!guideFrame || !guideLabel || !guideInstruction) return;
        
        guideFrame.className = 'guide-overlay-frame';
        guideLabel.textContent = docName;
        if (guideTitle) guideTitle.textContent = `Prendre une photo - ${docName}`;
        
        const docNameLower = docName.toLowerCase();
        
        if (docNameLower.includes('cni') || docNameLower.includes('identité') || docNameLower.includes('recto') || docNameLower.includes('verso')) {
            guideFrame.classList.add('id-card');
            guideInstruction.textContent = 'Placez votre pièce d\'identité dans le cadre';
        } else if (docNameLower.includes('rib') || docNameLower.includes('attestation') || docNameLower.includes('contrat')) {
            guideFrame.classList.add('a4-document');
            guideInstruction.textContent = 'Cadrez le document et prenez la photo';
        } else if (docNameLower.includes('fiche') || docNameLower.includes('téléphone')) {
            guideFrame.classList.add('receipt');
            guideInstruction.textContent = 'Placez la fiche dans le cadre';
        } else {
            guideFrame.classList.add('square');
            guideInstruction.textContent = 'Placez le document dans le cadre';
        }
    }

    function openCameraGuide() {
        // Vérifier à nouveau la disponibilité de la caméra
        if (!isMediaDevicesSupported()) {
            showNotification('La caméra n\'est pas disponible sur cet appareil', 'error');
            if (currentFileInput) {
                currentFileInput.click();
            }
            return;
        }
        
        // Réinitialiser l'interface
        document.getElementById('videoContainer').style.display = 'block';
        document.getElementById('previewContainer').style.display = 'none';
        document.getElementById('cameraActions').style.display = 'flex';
        document.getElementById('galleryOption').style.display = 'block';
        
        document.getElementById('cameraGuideOverlay').style.display = 'flex';
        startCamera().catch(error => {
            console.error('Erreur détaillée:', error);
            handleCameraError(error);
        });
    }

    async function startCamera() {
        const video = document.getElementById('cameraVideo');
        if (!video) {
            throw new Error('Élément vidéo non trouvé');
        }
        
        currentVideoElement = video;
        
        try {
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
            }
            
            if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) {
                throw new Error('MediaDevices API non supportée');
            }
            
            const isMobile = isMobileDevice();
            const facingMode = isMobile ? currentFacingMode : 'user';
            
            // Optimisation pour une meilleure qualité
            const constraints = {
                video: {
                    facingMode: facingMode,
                    width: { min: 1280, ideal: 1920, max: 3840 },
                    height: { min: 720, ideal: 1080, max: 2160 },
                    aspectRatio: { ideal: 1.7777777778 }
                },
                audio: false
            };
            
            console.log('Tentative d\'accès à la caméra avec constraints:', constraints);
            
            currentStream = await navigator.mediaDevices.getUserMedia(constraints);
            video.srcObject = currentStream;
            
            // Attendre que la vidéo soit prête
            await new Promise((resolve) => {
                video.onloadedmetadata = () => {
                    video.play()
                        .then(() => {
                            // Activer la mise au point automatique si disponible
                            if (currentStream.getVideoTracks) {
                                const track = currentStream.getVideoTracks()[0];
                                if (track && track.getCapabilities) {
                                    const capabilities = track.getCapabilities();
                                    if (capabilities.focusMode && capabilities.focusMode.includes('continuous')) {
                                        track.applyConstraints({ 
                                            advanced: [{ focusMode: 'continuous' }] 
                                        }).catch(e => console.log('Focus auto non supporté'));
                                    }
                                }
                            }
                            resolve();
                        })
                        .catch(error => {
                            console.error('Erreur lors de la lecture vidéo:', error);
                            resolve();
                        });
                };
            });
            
            console.log('Caméra démarrée avec succès');
            
        } catch (error) {
            console.error('Erreur détaillée dans startCamera:', error);
            throw error;
        }
    }

    function handleCameraError(error) {
        let message = 'Impossible d\'accéder à la caméra. ';
        
        if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
            message += 'Veuillez autoriser l\'accès à la caméra dans les paramètres de votre navigateur.';
        } else if (error.name === 'NotFoundError' || error.name === 'DevicesNotFoundError') {
            message += 'Aucune caméra n\'a été trouvée sur cet appareil.';
        } else if (error.name === 'NotReadableError' || error.name === 'TrackStartError') {
            message += 'La caméra est déjà utilisée par une autre application.';
        } else if (error.name === 'OverconstrainedError') {
            message += 'La caméra ne supporte pas les paramètres demandés.';
        } else if (error.message.includes('MediaDevices API non supportée')) {
            message += 'Votre navigateur ne supporte pas l\'accès à la caméra.';
            if (currentFileInput) {
                hideCameraGuide();
                currentFileInput.click();
                return;
            }
        } else {
            message += 'Erreur inconnue: ' + (error.message || 'Vérifiez votre matériel.');
        }
        
        showNotification(message, 'error');
        
        if (confirm('Souhaitez-vous plutôt sélectionner un fichier depuis votre appareil ?')) {
            hideCameraGuide();
            if (currentFileInput) {
                currentFileInput.click();
            }
        } else {
            hideCameraGuide();
        }
    }

    function switchCamera() {
        if (!isMobileDevice()) {
            showNotification('Le changement de caméra n\'est disponible que sur mobile', 'info');
            return;
        }
        
        currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
        startCamera().catch(handleCameraError);
    }

    function capturePhoto() {
        const video = document.getElementById('cameraVideo');
        
        if (!video || !video.videoWidth) {
            showNotification('La caméra n\'est pas prête', 'error');
            return;
        }
        
        // Effet flash
        const guideContent = document.querySelector('.guide-content');
        if (guideContent) {
            guideContent.classList.add('flash-animation');
            setTimeout(() => {
                guideContent.classList.remove('flash-animation');
            }, 300);
        }
        
        const canvas = document.createElement('canvas');
        const frame = document.getElementById('guideOverlayFrame');
        
        if (!frame) {
            showNotification('Erreur: cadre non trouvé', 'error');
            return;
        }
        
        const frameRect = frame.getBoundingClientRect();
        const videoRect = video.getBoundingClientRect();
        
        // Calculer les dimensions optimales pour une meilleure netteté
        const scaleX = video.videoWidth / videoRect.width;
        const scaleY = video.videoHeight / videoRect.height;
        
        // Calculer la zone de recadrage avec une marge pour s'assurer que tout le document est capturé
        const marginPercent = 0.03; // 2% de marge
        const frameWidth = frameRect.width * (1 + marginPercent * 2);
        const frameHeight = frameRect.height * (1 + marginPercent * 2);
        const frameLeft = frameRect.left - (frameRect.width * marginPercent);
        const frameTop = frameRect.top - (frameRect.height * marginPercent);
        
        const sx = Math.max(0, (frameLeft - videoRect.left) * scaleX);
        const sy = Math.max(0, (frameTop - videoRect.top) * scaleY);
        const sWidth = Math.min(video.videoWidth - sx, frameWidth * scaleX);
        const sHeight = Math.min(video.videoHeight - sy, frameHeight * scaleY);
        
        canvas.width = sWidth;
        canvas.height = sHeight;
        
        try {
            const context = canvas.getContext('2d');
            
            // Amélioration de la qualité de l'image
            context.imageSmoothingEnabled = true;
            context.imageSmoothingQuality = 'high';
            
            context.drawImage(video, sx, sy, sWidth, sHeight, 0, 0, sWidth, sHeight);
            
            // Appliquer un léger filtre de netteté
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            // Ici vous pourriez ajouter des algorithmes de traitement d'image si nécessaire
            
            canvas.toBlob(function(blob) {
                if (!blob) {
                    showNotification('Erreur lors de la création de l\'image', 'error');
                    return;
                }
                
                // Sauvegarder le blob pour validation
                capturedBlob = blob;
                
                // Afficher l'aperçu
                showPreview(canvas.toDataURL('image/jpeg', 0.95));
                
            }, 'image/jpeg', 0.95);
        } catch (error) {
            console.error('Erreur lors de la capture:', error);
            showNotification('Erreur lors de la capture de la photo', 'error');
        }
    }

    function showPreview(imageDataUrl) {
        // Cacher l'interface de capture
        document.getElementById('videoContainer').style.display = 'none';
        document.getElementById('cameraActions').style.display = 'none';
        document.getElementById('galleryOption').style.display = 'none';
        
        // Afficher l'aperçu
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        previewImage.src = imageDataUrl;
        previewContainer.style.display = 'block';
    }

    function retakePhoto() {
        // Réafficher l'interface de capture
        document.getElementById('videoContainer').style.display = 'block';
        document.getElementById('previewContainer').style.display = 'none';
        document.getElementById('cameraActions').style.display = 'flex';
        document.getElementById('galleryOption').style.display = 'block';
        
        // Réinitialiser
        capturedBlob = null;
    }

    function confirmPhoto() {
        if (!capturedBlob || !currentFileInput) {
            showNotification('Erreur: photo non disponible', 'error');
            return;
        }
        
        const fileName = `document_${Date.now()}.jpg`;
        const file = new File([capturedBlob], fileName, { type: 'image/jpeg' });
        
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        currentFileInput.files = dataTransfer.files;
        
        currentFileInput.dispatchEvent(new Event('change', { bubbles: true }));
        
        showNotification('Photo prise avec succès!', 'success');
        
        hideCameraGuide();
    }

    function uploadFromGallery() {
        // Arrêter la caméra
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
            currentStream = null;
        }
        
        // Cacher le guide
        document.getElementById('cameraGuideOverlay').style.display = 'none';
        
        // Ouvrir le gestionnaire de fichiers
        const hiddenInput = document.getElementById('hiddenGalleryInput');
        hiddenInput.click();
    }

    function hideCameraGuide() {
        const overlay = document.getElementById('cameraGuideOverlay');
        if (overlay) {
            overlay.style.display = 'none';
        }
        
        if (currentStream) {
            currentStream.getTracks().forEach(track => {
                track.stop();
                track.enabled = false;
            });
            currentStream = null;
        }
        
        if (currentVideoElement) {
            currentVideoElement.srcObject = null;
        }
        
        // Réinitialiser l'aperçu
        document.getElementById('previewContainer').style.display = 'none';
        document.getElementById('videoContainer').style.display = 'block';
        document.getElementById('cameraActions').style.display = 'flex';
        document.getElementById('galleryOption').style.display = 'block';
        
        capturedBlob = null;
        currentFileInput = null;
    }

    function showNotification(message, type = 'info') {
        const oldNotifications = document.querySelectorAll('.custom-notification');
        oldNotifications.forEach(n => n.remove());
        
        const notification = document.createElement('div');
        notification.className = 'custom-notification';
        
        const colors = {
            success: '#4CAF50',
            error: '#f44336',
            info: '#2196F3',
            warning: '#ff9800'
        };
        
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: ${colors[type] || colors.info};
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            z-index: 20000;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            animation: slideDown 0.3s ease;
            max-width: 90%;
            text-align: center;
            word-wrap: break-word;
        `;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideUp 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }

    // Ajouter les animations de notification si elles n'existent pas
    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            @keyframes slideDown {
                from { transform: translate(-50%, -100%); opacity: 0; }
                to { transform: translate(-50%, 0); opacity: 1; }
            }
            
            @keyframes slideUp {
                from { transform: translate(-50%, 0); opacity: 1; }
                to { transform: translate(-50%, -100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }

    // Ajouter les styles pour l'aperçu
    const previewStyles = document.createElement('style');
    previewStyles.textContent = `
        .preview-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #000;
        }
        
        .preview-header {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 15px;
            text-align: center;
        }
        
        .preview-header h5 {
            margin: 0;
            color: white;
        }
        
        .preview-image-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #111;
        }
        
        .preview-image-container img {
            max-width: 100%;
            max-height: 60vh;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }
        
        .preview-actions {
            padding: 20px;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        
        .preview-actions .btn {
            flex: 1;
            max-width: 200px;
            padding: 12px;
            font-size: 16px;
            border-radius: 25px;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            border: none;
            color: white;
        }
        
        .btn-success:active {
            transform: scale(0.98);
        }
    `;
    document.head.appendChild(previewStyles);

    // Nettoyage à la fermeture
    window.addEventListener('beforeunload', function() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
        }
    });

    // Gestionnaire d'erreur global pour les promesses non gérées
    window.addEventListener('unhandledrejection', function(event) {
        console.error('Promesse non gérée:', event.reason);
        if (event.reason && event.reason.name && event.reason.name.includes('Camera')) {
            handleCameraError(event.reason);
        }
    });
</script>