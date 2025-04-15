@extends('layouts.main')

@section('content')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"><a href="/shared/home"><i class="bx bx-home-alt"></i></a></div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Prospect</li>
                    <li class="breadcrumb-item active" aria-current="page">Liste</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Reglages</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                    <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#columnsModalPart">Personnaliser les colonnes</a>
                </div>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->


    <div class="container-fluid">
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background-color: #1e4520">
                        <h5 class="m-0 font-weight-bold text-white">Détails du Prospect</h5>
                        <div>
                            <span class="badge bg-{{ $prospect->status === 'nouveau' ? 'info' : ($prospect->status === 'en_cours' ? 'warning' : 'success') }}">
                                {{ ucfirst($prospect->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Informations Personnelles</h5>
                                <p><strong>Nom complet:</strong> {{ $prospect->first_name }} {{ $prospect->last_name }}</p>
                                <p><strong>Téléphone:</strong> {{ $prospect->mobile }}</p>
                                <p><strong>Email:</strong> {{ $prospect->email ?? 'Non renseigné' }}</p>
                                <p><strong>Ville:</strong> {{ $prospect->ville->libelleVillle ?? 'Non renseigné' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Informations Professionnelles</h5>
                                <p><strong>Profession:</strong> {{ $prospect->profession->MonLibelle ?? 'Non renseigné' }}</p>
                                <p><strong>Secteur d'activité:</strong> {{ $prospect->secteurActivity->MonLibelle ?? 'Non renseigné' }}</p>
                                <p><strong>Nature:</strong> {{ $prospect->natureProspect }}</p>
                                <p>
                                    <p><strong>Produits intéressants:</strong></p>
                                    @if($prospect->products->count() > 0)
                                        <div class="d-flex flex-wrap gap-2" id="products-container">
                                            @foreach($prospect->products as $product)
                                                <span class="badge bg-primary d-flex align-items-center product-badge" 
                                                      id="product-{{ $product->IdProduit }}">
                                                    {{ $product->itemProduct->MonLibelle }}

                                                    
                                                    <button class="btn btn-sm btn-link p-0 ms-2 text-white delete-product" 
                                                            data-product-id="{{ $product->itemProduct->IdProduit }}"
                                                            data-prospect-id="{{ $prospect->id }}"
                                                            title="Supprimer ce produit">
                                                        <i class="bx bxs-trash fs-6"></i>
                                                    </button>
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">Aucun produit sélectionné</p>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Dernières Notes</h5>
                                <div class="bg-light p-3 rounded">
                                    {!! nl2br(e($prospect->note)) ?? 'Aucune note' !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Statut et Suivi</h5>
                                <p><strong>Dernier contact:</strong> 
                                    @if($prospect->followups->count() > 0)
                                        {{ $prospect->followups->first()->followup_date->format('d/m/Y H:i') }}
                                    @else
                                        Jamais contacté
                                    @endif
                                </p>
                                <p><strong>Prochain suivi:</strong> 
                                    @if($prospect->followups->count() > 0 && $prospect->followups->first()->next_followup_date)
                                        {{ $prospect->followups->first()->next_followup_date->format('d/m/Y H:i') }}
                                    @else
                                        Non planifié
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Historique des suivis -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: #1e4520">
                        <h5 class="m-0 font-weight-bold text-white">Historique des Relances</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @forelse($prospect->followups as $followup)
                            <div class="timeline-item">
                                <div class="timeline-item-marker">
                                    <div class="timeline-item-marker-indicator bg-{{ $followup->status === 'completed' ? 'success' : ($followup->status === 'canceled' ? 'danger' : 'warning') }}"></div>
                                </div>
                                <div class="timeline-item-content">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">
                                            {{ $followup->user->name }} - 
                                            <span class="text-capitalize">{{ $followup->type }}</span>
                                        </h6>
                                        <small class="text-muted">{{ $followup->followup_date->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-1">{!! nl2br(e($followup->notes)) !!}</p>
                                    @if($followup->next_followup_date)
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt"></i> Prochain suivi: {{ $followup->next_followup_date->format('d/m/Y H:i') }}
                                    </small>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucun suivi enregistré pour ce prospect</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Colonne secondaire - Formulaire de suivi -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: #1e4520">
                        <h5 class="m-0 font-weight-bold text-white">Nouvelle Relance</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('prospect.followup.store', $prospect->uuid) }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Type de contact</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="type" id="type_call" value="call" checked>
                                    <label class="btn btn-outline-primary" for="type_call"><i class="fas fa-phone"></i> Appel</label>
                                    
                                    <input type="radio" class="btn-check" name="type" id="type_email" value="email">
                                    <label class="btn btn-outline-primary" for="type_email"><i class="fas fa-envelope"></i> Email</label>
                                    
                                    <input type="radio" class="btn-check" name="type" id="type_meeting" value="meeting">
                                    <label class="btn btn-outline-primary" for="type_meeting"><i class="fas fa-calendar-alt"></i> RDV</label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="notes" name="notes" rows="5" required placeholder="Détails de l'échange..."></textarea>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="followup_date" class="form-label">Date du contact <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="followup_date" name="followup_date" required 
                                        value="{{ now()->format('Y-m-d\TH:i') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="next_followup_date" class="form-label">Prochain suivi</label>
                                    <input type="datetime-local" class="form-control" id="next_followup_date" name="next_followup_date">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Statut</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="completed">Terminé</option>
                                    <option value="pending">À suivre</option>
                                    <option value="canceled">Annulé</option>
                                </select>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Enregistrer le suivi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Actions rapides -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: #1e4520">
                        <h5 class="m-0 font-weight-bold text-white">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('prospect.edit', $prospect->uuid) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i> Modifier le prospect
                            </a>
                            
                            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#convertToClientModal">
                                <i class="fas fa-user-check me-2"></i> Convertir en client
                            </button>
                            
                            <a href="tel:{{ $prospect->mobile }}" class="btn btn-outline-info">
                                <i class="fas fa-phone me-2"></i> Appeler le prospect
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de conversion en client -->
    <div class="modal fade" id="convertToClientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #1e4520">
                    <h5 class="modal-title text-white">Convertir en client</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir convertir ce prospect en client ?</p>
                        <div class="mb-3">
                            <label for="client_code" class="form-label">Code client</label>
                            <input type="text" class="form-control" id="client_code" name="client_code" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Style pour la timeline */
        .timeline {
            position: relative;
            padding-left: 1rem;
            margin: 0 0 0 1rem;
            border-left: 2px solid #dee2e6;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }
        
        .timeline-item-marker {
            position: absolute;
            left: -1.5rem;
            width: 1rem;
            height: 1rem;
            margin-top: 0.25rem;
        }
        
        .timeline-item-marker-indicator {
            width: 12px;
            height: 12px;
            border-radius: 100%;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #dee2e6;
        }
        
        .timeline-item-content {
            padding: 0.5rem 1rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        
        /* Style pour les boutons radio */
        .btn-group .btn {
            flex: 1;
        }
        
        .btn-check:checked + .btn {
            background-color: #1e4520;
            color: white;
            border-color: #1e4520;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la suppression des produits
            document.querySelectorAll('.delete-product').forEach(button => {
                button.addEventListener('click', async function() {
                    const productId = this.getAttribute('data-product-id');

                    console.log("le code es",productId)

                    const prospectId = this.getAttribute('data-prospect-id');
                    const badgeElement = this.closest('.product-badge');
                    
                    if (!confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
                        return;
                    }

                    // Afficher un indicateur de chargement
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="bx bx-loader-alt bx-spin fs-6"></i>';
                    this.disabled = true;

                    try {
                        const response = await fetch(`/prospect/${prospectId}/products/${productId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (!response.ok) throw new Error(data.message || 'Erreur lors de la suppression');

                        // Supprimer le badge avec animation
                        badgeElement.style.transition = 'all 0.3s ease';
                        badgeElement.style.opacity = '0';
                        badgeElement.style.transform = 'scale(0.8)';
                        
                        setTimeout(() => {
                            badgeElement.remove();
                            
                            // Si plus de produits, afficher le message "Aucun produit"
                            const container = document.getElementById('products-container');
                            if (container && container.children.length === 0) {
                                container.insertAdjacentHTML('afterend', 
                                    '<p class="text-muted">Aucun produit sélectionné</p>');
                            }
                        }, 300);

                    } catch (error) {
                        console.error('Error:', error);
                        alert(error.message || 'Une erreur est survenue');
                        this.innerHTML = originalHTML;
                        this.disabled = false;
                    }
                });
            });
        });
    </script>

</div>
@endsection