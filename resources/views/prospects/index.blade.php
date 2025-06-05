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

    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="card">
                <div class="card-header text-center">Mon QR Code de prospection</div>
                <div class="card-body text-center">
                    {!! QrCode::size(200)->generate(route('prospection.form', auth()->user()->qr_code_token)) !!}
                    <p class="mt-2">Scanner ce code pour ajouter un prospect</p>
                    <a href="{{ route('prospect.download') }}" class="btn btn-sm btn-outline-primary">
                        Télécharger le QR Code
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="card p-4">
                <div class="row h-100">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="widgets-icons rounded-circle mx-auto bg-light-info text-info mb-3"><i class='bx bxl-dropbox'></i>
                                    </div>
                                    <h4 class="my-1">{{ count($allPropects) }}</h4>
                                    <p class="mb-0 text-secondary">Mes Propections</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="widgets-icons rounded-circle mx-auto bg-light-success text-success mb-3"><i class='bx bxl-youtube'></i>
                                    </div>
                                    <h4 class="my-1">38M</h4>
                                    <p class="mb-0 text-secondary">YouTube Subscribers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="widgets-icons rounded-circle mx-auto bg-light-warning text-warning mb-3"><i class='bx bxl-dropbox'></i>
                                    </div>
                                    <h4 class="my-1">28K</h4>
                                    <p class="mb-0 text-secondary">Dropbox Users</p>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div>
                    <form method="GET" action="{{ route('prospect.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <input type="text" name="code" class="form-control" placeholder="Code" value="{{ request('code') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="first_name" class="form-control" placeholder="Prénom" value="{{ request('first_name') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="last_name" class="form-control" placeholder="Nom" value="{{ request('last_name') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_from" class="form-control" placeholder="Date début" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_to" class="form-control" placeholder="Date fin" value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary" title="Rechercher"><i class='bx bx-search'></i></button>
                                <a href="{{ route('prospect.index') }}" class="btn btn-secondary" title="Reinitialiser"><i class="fadeIn animated bx bx-revision"></i></a>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Bouton d'impression -->
                    @if(count($allPropects) > 0)
                        <form method="GET" action="{{ route('prospect.index') }}" class="mb-4">
                            <input type="hidden" name="code" value="{{ request('code') }}">
                            <input type="hidden" name="first_name" value="{{ request('first_name') }}">
                            <input type="hidden" name="last_name" value="{{ request('last_name') }}">
                            <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                            <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                            <input type="hidden" name="print" value="1">
                            <button type="submit" class="btn btn-success" title="Imprimer"> <i class="fadeIn animated bx bx-printer"></i>
                            </button>
                        </form>
                    @endif
                </div>
                
            </div>
        </div>
    </div>

    <div class="containe mt-4">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="ms-auto">
                                @can('Demarrer une propection')
                                    <button type="button" class="btn btn-outline-secondary float-end" data-bs-target="#addnewPropect" data-bs-toggle="modal">
                                        <i class="bx bxs-plus-square"></i> Nouvelle prospection
                                    </button>
                                @endcan
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="example2">
                                    <thead>
                                        <tr>
                                            <th><span class="wd-15p">#</span></th>
                                            <th class="wd-lg-15p"><span class="wd-15p">Code</span></th>
                                            <th class="wd-lg-15p"><span class="wd-15p">Nom Complet</span></th>
                                            <th class="wd-lg-15p"><span class="wd-15p">Tel</span></th>
                                            <th class="wd-lg-15p"><span class="wd-15p">Email</span></th>
                                            <th class="wd-lg-15p"><span class="wd-15p">Produit</span></th>
                                            <th class="wd-lg-15p"><span class="wd-15p">Nature</span></th>
                                            <th class="wd-lg-15p"><span class="wd-15p">Date</span></th>
                                            <th class="wd-lg-15p"><span class="wd-15p">Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allPropects as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->code ?? "" }}</td>
                                            <td>{{ $item->first_name ?? "" }} {{ $item->last_name ?? "" }}</td>
                                            <td>{{ $item->mobile ?? "" }}</td>
                                            <td>{{ $item->email ?? "" }}</td>
                                            <td>{{ $item->product_id ?? "" }}</td>
                                            <td>
                                                <span class=" shadow-sm w-100">
                                                    @if ($item->natureProspect == "Suspect")
                                                        <span class="badge bg-warning text-white shadow-sm w-100">Suspect</span>
                                                    @elseif ($item->natureProspect == "Prospect")
                                                        <span class="badge bg-info text-white shadow-sm w-100">Prospect</span>
                                                    @elseif ($item->natureProspect == "Déjà client")
                                                        <span class="badge bg-info text-white shadow-sm w-100">Déjà client</span>
                                                    @else
                                                        <span class="badge bg-secondary text-white shadow-sm w-100">Inconnu</span>
                                                    @endif
                                                </span>
                                            </td>
                                            <td>{{ $item->created_at ?? "" }}</td>
                                            <td>
                                                <i><a href="{{ route('prospect.show', $item->id) }}" class="btn btn-sm btn-primary"><i class="bx bx-show"></i></a></i>
                                            </td>
                                            

                                        </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('prospects.addNew')

</div>
@endsection