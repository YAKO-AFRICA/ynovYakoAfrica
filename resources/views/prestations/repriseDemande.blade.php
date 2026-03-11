@extends('layouts.main')

@section('content')
    <!--start stepper one-->
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Prestations</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Poursuivre ma demande</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Poursuivre ma demande de prestation</h5>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @if (Session::get('fail'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ Session::get('fail') }}
                            </div>
                        @endif
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                            <form action="{{ route('prestation.verifCodeDemande') }}" method="post" class="submitForm">
                                @csrf
                                <label class="form-label">Veuillez saisir le code du rendez-vous que vous avez reçu</label>
                                <input type="text" name="code"required placeholder="Code du Rdv que vous avez réçu"
                                    class="form-control" id="code" />
                                <div class="mt-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Continuer</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
