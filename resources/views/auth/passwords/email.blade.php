@extends('layouts.app')

@section('content')
<div class="row justify-content-center w-100">
    <div class="col-md-5">
        <div class="card auth-card">
            <div class="card-body p-4">

                <h4 class="text-center mb-3 auth-title">
                    🔑 Mot de passe oublié
                </h4>

                <p class="text-center text-muted small">
                    Entrez votre email pour recevoir le lien de réinitialisation
                </p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Adresse email</label>
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            placeholder="exemple@email.com"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button class="btn btn-success btn-lg">
                            📧 Envoyer le lien
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

        <div class="text-center mt-3 text-white small">
            © {{ date('Y') }} {{ config('app.name') }}
        </div>

    </div>
</div>
@endsection
