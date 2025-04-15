
<div class="modal fade" id="RechercherClientModal" tabindex="-1" aria-labelledby="RechercherClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="RechercherClientModalLabel">Rechercher le client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('prod.search.adherent') }}" method="post" class="submitForm"> 
                    @csrf
                    <div class="card m-auto" style="width: 100%"> 
                        <div class="card-body">
                            <div class="row g-3 justify-content-center align-items-center">
                                <div class="col-12">
                                    <label for="methodeRecherche" class="form-label">Je souhaite rechercher le client par:</label>
                                    <select name="methodeRecherche" class="form-select" id="methodeRecherche" required>
                                        <option value="">Veuillez choisir</option>
                                        <option value="CodeProspect">Code Prospect</option>
                                        <option value="NumPiece">Numéro de pièce d'identité</option>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <input type="text" class="form-control" name="query" id="query"
                                    placeholder="Code Prospect ou Numéro de pièce d'identité" required>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn border-btn">Rechercher</button>
                                </div>
                            </div><!--end row-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>