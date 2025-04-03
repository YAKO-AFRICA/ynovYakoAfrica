{{-- <div class="modal fade" id="addPrestationProduct{{ $item->CodeProduit }}" tabindex="-1" aria-labelledby="addPrestationModalLabel{{ $item->CodeProduit }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPrestationModalLabel{{ $item->CodeProduit }}">Attribuer une prestation a un produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('setting.prestation_product.store') }}" method="POST" class="submitFor">
                @csrf
                <div class="modal-body">
                    <fieldset class="border p-3">
                        <legend class="float-none w-auto px-2">
                            <small><h5 class="mb-4">Produits commercialisés</h5></small>
                        </legend>
            
                        <input type="hidden" name="codeproduit" id="codeproduit" value="{{ $item->CodeProduit }}">
            
                        <div class="mb-4">
                            <label class="form-label" for="product_type">Type de Produit:</label>
                            <select name="product_type" class="form-select" id="product_type" required>
                                <option value="" selected>-- Choisir une option --</option>
                                <option value="Epargne">Epargne</option>
                                <option value="Obsèque">Obsèque</option>
                            </select>
                        </div>
            
                        <div class="mb-3">
                            <div class="row mb-3">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-primary btn-add-prestation">Ajouter une prestation</button>
                                </div>
                            </div>
            
                            <div id="prestationsContainer">
                                <div class="row mb-3 prestation-item">
                                    <div class="input-group">
                                        <select name="prestations[]" class="form-select" required>
                                            <option value="" selected>Choisir une prestation associée</option>
                                            @foreach ($typeprestations as $type)
                                                <option value="{{ $type->id }}">{{ $type->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-success">Sauvegarder</button>
                </div>
            </form>
            
        </div>
    </div>

</div> --}}

<div class="modal fade" id="addPrestationProduct{{ $item->CodeProduit }}" tabindex="-1" aria-labelledby="addPrestationModalLabel{{ $item->CodeProduit }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPrestationModalLabel{{ $item->CodeProduit }}">Attribuer une prestation a un produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('setting.prestation_product.store') }}" method="POST" class="submitFor">
                @csrf
                <div class="modal-body">
                    <fieldset class="border p-3">
                        <legend class="float-none w-auto px-2">
                            <small><h5 class="mb-4">Produits commercialisés</h5></small>
                        </legend>
            
                        <input type="hidden" name="codeproduit" id="codeproduit" value="{{ $item->CodeProduit }}">
            
                        <div class="mb-4">
                            <label class="form-label" for="product_type">Type de Produit:</label>
                            <select name="product_type" class="form-select" id="product_type" required>
                                <option value="" selected>-- Choisir une option --</option>
                                <option value="Epargne">Epargne</option>
                                <option value="Obsèque">Obsèque</option>
                            </select>
                        </div>
            
                        <div class="mb-3">
                            <div class="row mb-3">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-primary" id="addPrestationButton{{ $item->CodeProduit }}">Ajouter une prestation</button>
                                </div>
                            </div>
            
                            <div id="prestationsContainer{{ $item->CodeProduit }}">
                                <div class="row mb-3 prestation-item">
                                    <div class="input-group">
                                        <select name="prestations[]" class="form-select" required>
                                            <option value="" selected>Choisir une prestation associée</option>
                                            @foreach ($typeprestations as $prest)
                                                <option value="{{ $prest->id }}">{{ $prest->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-success">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="table-responsive">
    <table class="table mb-0" id="example2">
        <thead class="table-light">
            <tr>
                <th>#ID</th>
                <th>Code Produit</th>
                <th>Libelle</th>
                <th>Prestations possibles</th>
                <th>Date création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $item)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ $item->CodeProduit ?? '' }}</td>
                    <td>{{ $item->MonLibelle ?? '' }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div>
                                {{ $item->typePrestations->count() ?? 0 }}
                            </div>
                            <div class="ms-2">
                                <h6 class="mb-0 font-18 text-success" data-bs-toggle="modal"
                                    data-bs-target="#showPrestationModal{{ $item->CodeProduit }}"
                                    style="cursor: pointer"><i class="bx bx-show"></i></h6>
                            </div>
                        </div>
                    </td>
                    <td>{{ $item->DateProduit ?? '' }}</td>
                    <td>
                        <div class="d-flex order-actions">
                            <a href="{{ route('setting.prestation_product.form', $item->CodeProduit) }}" class="ms-3" >
                                <i class="bx bx-dots-horizontal-rounded"></i>
                            </a>

                        </div>
                    </td>
                </tr>
                {{-- @include('settings.prestationByproduct.addModal', ['CodeProduit' => $item->CodeProduit]) --}}
                @include('settings.prestationByproduct.showPrestationModal', [
                    'CodeProduit' => $item->CodeProduit,
                ])
            @empty
                <div class="collapse col-8">Aucun produit</div>
            @endforelse
        </tbody>
    </table>
</div>
