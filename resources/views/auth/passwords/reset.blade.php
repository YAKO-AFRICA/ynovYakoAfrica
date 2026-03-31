@extends('layouts.app')

@section('content')
<div class="row justify-content-center w-100">
    <div class="col-md-5">
        <div class="card auth-card">
            <div class="card-body p-4">

                <h4 class="text-center mb-3 auth-title">
                    🔐 Réinitialiser le mot de passe
                </h4>

                <p class="text-center text-muted small">
                    Choisissez un mot de passe sécurisé
                </p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- EMAIL -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            value="{{ $email ?? old('email') }}"
                            required
                        >

                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-3">
                        <label class="form-label">Nouveau mot de passe</label>

                        <div class="input-group">
                            <input
                                type="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                required
                            >
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                👁
                            </button>
                        </div>

                        <small class="text-muted">
                            8 caractères minimum, 1 majuscule, 1 chiffre
                        </small>

                        <div class="progress mt-2" style="height:5px;">
                            <div id="password-strength" class="progress-bar"></div>
                        </div>

                        @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- CONFIRM -->
                    <div class="mb-3">
                        <label class="form-label">Confirmer mot de passe</label>

                        <div class="input-group">
                            <input
                                type="password"
                                id="password_confirmation"
                                class="form-control"
                                name="password_confirmation"
                                required
                            >
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                                👁
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button class="btn btn-success btn-lg">
                            🔐 Réinitialiser
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none text-danger">
                            ← Retour à la connexion
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(id){
    let input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}

document.getElementById('password').addEventListener('keyup', function(){
    let val = this.value;
    let strength = 0;

    if(val.length >= 8) strength += 25;
    if(/[A-Z]/.test(val)) strength += 25;
    if(/[0-9]/.test(val)) strength += 25;
    if(/[^A-Za-z0-9]/.test(val)) strength += 25;

    let bar = document.getElementById('password-strength');
    bar.style.width = strength + "%";

    if(strength <= 25){
        bar.className = "progress-bar bg-danger";
    }else if(strength <= 50){
        bar.className = "progress-bar bg-warning";
    }else if(strength <= 75){
        bar.className = "progress-bar bg-info";
    }else{
        bar.className = "progress-bar bg-success";
    }
});
</script>

@endsection
