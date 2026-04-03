<div class="modal fade" id="addProductReseau{{ $item->id }}" tabindex="-1" aria-labelledby="membreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="membreModalLabell">Attribuer un Produit au reseau</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('setting.store.product.by.reseau') }}" method="POST" class="submitForm">
                @csrf
                <div class="modal-body">
                    <div class="">
                        <fieldset class="border p-3">
                            <legend class="float-none w-auto px-2"><small><h5 class="mb-4">Produits commercialisé</h5></small></legend>
                            <input type="text" name="codereseau" id="codereseau" value="{{ $item->id }}" class="form-control" hidden>
                            <div class="mb-4">
                                <label class="form-label" for="codeproduit">Code Produit:</label>
                                <select name="codeproduit" class="form-select produit-select" id="codeproduitId-{{ $item->id }}" required>
                                    <option value="">-- Choisir une option --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product['CodeProduit'] }}" data-code-produit-value="{{ $product['CodeProduit'] }}">{{ $product['MonLibelle'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label" for="codeproduitformule">Code Produit Formule:</label>
                                <select name="codeproduitformule" class="form-select formule-select" id="codeproduitformule-{{ $item->id }}">
                                    <option value="">-- Choisir une option --</option>
                                </select>
                            </div>
                            <input type="hidden" name="libelleformule" id="libelleformule-{{ $item->id }}">
                        </fieldset>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-success">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('produit-select')) {
                const produitSelect = e.target;
                const reseauId = produitSelect.id.split('-')[1];
                const formuleSelect = document.getElementById('codeproduitformule-' + reseauId);
                const codeProduit = produitSelect.value;

                console.log('Produit sélectionné:', codeProduit);

                // Vide et désactiver le select
                formuleSelect.innerHTML = '<option value="">Chargement...</option>';
                formuleSelect.disabled = true;

                if (!codeProduit) {
                    formuleSelect.innerHTML = '<option value="">-- Choisir une option --</option>';
                    formuleSelect.disabled = false;
                    return;
                }

                // Ajouter un timestamp pour éviter le cache
                const params = new URLSearchParams({
                    CodeProduit: codeProduit,
                    _: Date.now()
                });

                fetch(API_BASE_URL + '/enov/get-formul-product', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded',
                        // 'Cache-Control': 'no-cache, no-store, must-revalidate',
                        // 'Pragma': 'no-cache',
                        // 'Expires': '0',
                        'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MjExODcyLCJlbWFpbCI6ImZvcm1hdGlvbi5ibmlAYm5pLmNvbSIsIm5vbSI6IkJOSSIsImNvZGVhZ2VudCI6IkIwNDAiLCJ0eXBlbWVicmUiOm51bGwsInByZW5vbSI6IkZvcm1hdGlvbiJ9.gwxwy43VeMDcfaTpgpFbuWkxjirIBqvuXq3UZOuw_nA'
                    },
                    body: params.toString()
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Réponse API pour le produit", codeProduit, ":", data);
                    
                    // Vérifier si les formules correspondent au produit sélectionné
                    if (data.getProduitByFormule && data.getProduitByFormule.length > 0) {
                        const firstFormule = data.getProduitByFormule[0];

                        if (firstFormule.CodeProduit && firstFormule.CodeProduit !== codeProduit) {
                            console.warn('Incohérence détectée: les formules ne correspondent pas au produit');
                        }
                    }

                    
                    
                    remplirSelectFormule(formuleSelect, data);
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    formuleSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    formuleSelect.disabled = false;
                });
            }
        });

        function remplirSelectFormule(formuleSelect, data) {
            formuleSelect.innerHTML = '';

            if (data.getProduitByFormule && data.getProduitByFormule.length > 0) {
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = '-- Choisir une option --';
                formuleSelect.appendChild(defaultOption);

                data.getProduitByFormule.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.CodeProduitFormule;
                    option.textContent = item.MonLibelle;
                    formuleSelect.appendChild(option);
                });
            } else {
                const noOption = document.createElement('option');
                noOption.value = '';
                noOption.textContent = 'Aucune formule disponible';
                formuleSelect.appendChild(noOption);
            }

            formuleSelect.disabled = false;
        }
    });
    </script>

    <script>
        document.addEventListener('change', function(e) {

            if (e.target && e.target.classList.contains('formule-select')) {

                const formuleSelect = e.target;
                const reseauId = formuleSelect.id.split('-')[1];
                const libelleInput = document.getElementById('libelleformule-' + reseauId);

                const selectedOption = formuleSelect.options[formuleSelect.selectedIndex];

                const libelle = selectedOption.text;

                console.log("Libellé formule:", libelle);

                libelleInput.value = libelle;

            }

        });
    </script>


</div>