@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Profile utilisateur</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i
                                class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Mon profile</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">

        </div>
    </div>

    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center position-relative">
                                <!-- Image avec position relative -->
                                <div style="position: relative; display: inline-block;">
                                    <!-- Image de profil -->
                                    @if(Auth::user()->membre->photo != null)
                                        <img src="{{ asset('images/userProfile/' . Auth::user()->membre->photo) }}" alt="Admin" class="rounded-circle p-1" style="
                                            background-color: #F7A400;
                                            min-width: 185px;
                                            min-height: 185px;
                                            max-width: 185px;
                                            max-height: 185px;
                                                ">
                                    @else
                                        <img src="{{ asset('root/images/login-images/default.png')}}" alt="Admin" class="rounded-circle p-1" style="
                                        background-color: #F7A400;
                                        min-width: 185px;
                                        min-height: 185px;
                                        max-width: 185px;
                                        max-height: 185px;
                                            ">
                                    @endif


                                    <!-- Icône pour modifier l'image -->
                                    <div
                                        style="
                                            position: absolute;
                                            bottom: 5px; /* Ajuste la position verticale */
                                            right: 5px; /* Ajuste la position horizontale */
                                            display: inline-flex;
                                            justify-content: center;
                                            align-items: center;
                                            width: 40px;
                                            height: 40px;
                                            background-color: rgba(0, 0, 0, 0.527);
                                            border-radius: 50%;
                                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                                            cursor: pointer;
                                        "
                                        onclick="document.getElementById('imageUpload').click()">
                                        <i class="fadeIn animated bx bx-edit" style="font-size: 25px; color: #fff;"></i>
                                    </div>
                                </div>

                                <!-- Champ d'upload caché -->
                                <input type="file" id="imageUpload" style="display: none;" onchange="previewImage(event)">

                                <!-- Informations utilisateur -->
                                <div class="mt-3">
                                    <h4>{{ Auth::user()->membre->nom ?? ''}} - {{ Auth::user()->membre->prenom ?? ''}}</h4>
                                    <p class="text-secondary mb-1">{{ Auth::user()->membre->role ?? ''}}</p>
                                    <p class="text-muted font-size-sm"><strong>Code :</strong> <span>{{ Auth::user()->membre->codeagent ?? ''}}</span></p>
                                    <p class="text-secondary mb-1">{{ Auth::user()->membre->email ?? '' }}</p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        {{-- @dd(Auth::user()->idmembre) --}}
                        <div class="card-body">
                            <form action="{{ route('setting.user.profile.update', Auth::user()->idmembre)}}" method="post" class="submitForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Photo de profile</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" name="photo" class="form-control" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Nom</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="nom" class="form-control" value="{{ Auth::user()->membre->nom ?? ''}}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Prenoms</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="prenom" class="form-control" value="{{ Auth::user()->membre->prenom ?? ''}}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Branche</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" value="{{ Auth::user()->membre->branche ?? ''}}" disabled />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Code Partenaire</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" value="{{ Auth::user()->membre->codepartenaire ?? ''}}" disabled />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Telephone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="cel" class="form-control" value="{{ Auth::user()->membre->cel ?? ''}}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <button type="submit" class="btn btn-two px-4">Modifier</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Modifier votre mot de passe</h5>
                                </div>
                                <div class="card-body">

                                    <form id="passwordForm" action="{{ route('setting.user.profile.updatePwd') }}" method="post">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col-sm-5">
                                                <h6 class="mb-0">Nouveau mot de passe</h6>
                                            </div>
                                            <div class="col-sm-7 text-secondary">
                                                <input type="password" name="password" class="form-control"/>
                                                <small class="text-danger" id="passwordError"></small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-5">
                                                <h6 class="mb-0">Confirmer le nouveau mot de passe</h6>
                                            </div>
                                            <div class="col-sm-7 text-secondary">
                                                <input type="password" name="password_confirmation" class="form-control"/>
                                                <small class="text-danger" id="confirmError"></small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5"></div>
                                            <div class="col-sm-7 text-secondary">
                                                <button type="submit" class="btn btn-two px-4">Modifier</button>
                                            </div>
                                        </div>
                                    </form>

                                    <script>
                                    document.getElementById('passwordForm').addEventListener('submit', function(e) {
                                        e.preventDefault();
                                        const form = e.target;
                                        const data = new FormData(form);

                                        // Réinitialiser les messages
                                        document.getElementById('passwordError').innerText = '';
                                        document.getElementById('confirmError').innerText = '';

                                        fetch(form.action, {
                                            method: 'POST',
                                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                            body: data
                                        })
                                        .then(res => res.json())
                                        .then(res => {
                                            if(res.type === 'success'){
                                                alert(res.message);
                                                window.location.href = res.urlback; // Redirection
                                            } else if(res.type === 'error' && res.errors){
                                                if(res.errors.password) {
                                                    document.getElementById('passwordError').innerText = res.errors.password[0];
                                                }
                                            } else {
                                                alert(res.message);
                                            }
                                        })
                                        .catch(err => console.error(err));
                                    });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();
    reader.onload = function() {
        const img = document.querySelector('.rounded-circle'); // Sélectionne l'image existante
        img.src = reader.result; // Met à jour la source de l'image
    };
    reader.readAsDataURL(input.files[0]); // Lit le fichier sélectionné
}
    </script>
@endsection
