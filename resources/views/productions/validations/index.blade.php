@extends('layouts.main')

@section('content')

<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3"><a href="/shared/home"><i class="bx bx-home-alt"></i></a></div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item active" aria-current="page">Productions</li>
                <li class="breadcrumb-item active" aria-current="page">Validation</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->

<div class="row">
    @if(count($PartBNIContrat['contrats']) > 0)
        <div class="col-12 col-md-6 col-lg-3"> 
            <a href="{{ route('prod.validation.prodByPartner', $PartBNIContrat['partner']->designation) }}">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="mx-auto mb-3">
                                
                                @if ($PartBNIContrat['partner']->logo == null)
                                    <img src="{{ asset('root/images/logo_yako.jpg') }}"
                                    style="min-height: 90%; min-width: 90%; background-color: #fff; height: 90%; width: 90%;" 
                                    class="logo-icon img-fluid img-thumbnail"
                                    alt="logo default">
                                @else
                                    <img src="{{ asset('logos/'. $PartBNIContrat['partner']->logo) }}"
                                    style="min-height: 90%; min-width: 90%; background-color: #fff; height: 90%; width: 90%;" 
                                    class="logo-icon img-fluid img-thumbnail"
                                alt="logo default">
                                @endif
                                <h4 class="my-1">{{ $PartBNIContrat['partner']->designation }}</h4>
                            </div>
                            <hr>
                            <h4 class="my-1">{{ count($PartBNIContrat['contrats']) }}</h4>
                            <p class="mb-0 text-secondary">Souscriptions en attente</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endif
    @foreach ($PartContrat as $item)
        @if(count($item['contrats']) > 0)
            <div class="col-12 col-md-6 col-lg-3">
                <a href="{{ route('prod.validation.prodByPartner', $item['partner']->code) }}">
                    <div class="card radius-10" style="min-height: 95%; min-width: 95%; height: 95%; width: 95%;">
                        <div class="card-header text-center">
                            <h4 class="my-1">{{ $item['partner']->designation }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <div class="mx-auto mb-3">
                                    @if ($item['partner']->logo == null)
                                        <img src="{{ asset('root/images/logo_yako.jpg') }}"
                                        style="min-height: 100%; min-width: 100%; background-color: #fff; height: 100%; width: 100%;" 
                                        class="logo-icon img-fluid img-thumbnail" alt="logo default">
                                    @else
                                        <img src="{{ asset('logos/'. $item['partner']->logo) }}"
                                        style="min-height: 100%; min-width: 100%; background-color: #fff; height: 100%; width: 100%;" 
                                        class="logo-icon img-fluid img-thumbnail"
                                        alt="logo default">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center bg-white">
                            <h4 class="my-1">{{ count($item['contrats']) }}</h4>
                            <p class="mb-0 text-secondary">Souscriptions en attente</p>
                        </div>
                    </div>
                </a>
            </div>
        @endif 
    @endforeach
</div>


@endsection