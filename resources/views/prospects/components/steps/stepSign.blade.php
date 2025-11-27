<div class="info-box">
    <p>✍️ Veuillez apposer votre signature électronique pour valider votre demande.</p>
</div>

<div class="form-group container">
    <label class="required">Signature Électronique</label>
    <div id="signatureContainer" class="border rounded bg-light " style="width: 100%; height: 200px; position: relative; background: white;">
        <canvas id="signatureCanvas" class="" style="width: 100%; height: 100%; touch-action: none;"></canvas>
    </div>
    <div class="signature-controls mt-2">
        <button type="button" class="btn btn-secondary btn-sm" id="clearSignatureBtn">
            🗑️ Effacer la signature
        </button>
    </div>
    <input type="hidden" name="signature" id="signatureData">
</div>

<div style="background: #fffbeb; border-left: 4px solid #f59e0b; padding: 20px; border-radius: 8px; margin-top: 20px;">
    <h3 style="color: #92400e; margin-bottom: 10px;">⚠️ Déclaration</h3>
    <p style="color: #78350f; font-size: 14px; line-height: 1.6;">
        Je certifie que toutes les informations fournies dans ce formulaire sont exactes et complètes.
        Je comprends que toute fausse déclaration peut entraîner la nullité du contrat ou la réduction des prestations.
        J'accepte que mes données personnelles soient traitées conformément à la politique de confidentialité
        et aux réglementations en vigueur.
    </p>
    <label class="checkbox-label" style="margin-top: 15px;">
        <input type="checkbox" name="accepte_conditions" id="acceptConditions" required>
        <span>J'accepte les conditions générales *</span>
    </label>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('signatureCanvas');
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)'
    });

    document.getElementById('clearSignatureBtn').addEventListener('click', () => signaturePad.clear());

    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
        signaturePad.clear();
    }

    window.addEventListener('resize', resizeCanvas);

    // Premier resize
    resizeCanvas();


    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const acceptConditions = document.getElementById('acceptConditions');
            
            if (signaturePad.isEmpty()) {
                e.preventDefault();
                alert('Veuillez fournir votre signature');
                return;
            }
            
            if (!acceptConditions.checked) {
                e.preventDefault();
                alert('Veuillez accepter les conditions générales');
                return;
            }
            
            document.getElementById('signatureData').value = signaturePad.toDataURL();
        });
    }
});

</script>