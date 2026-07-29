<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement échoué</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow border-0 text-center p-5" style="max-width: 500px;">

            <div class="mb-4">
                <div class="rounded-circle bg-danger text-white d-inline-flex justify-content-center align-items-center"
                     style="width: 90px; height: 90px; font-size: 40px;">
                    ✕
                </div>
            </div>

            <h2 class="text-danger fw-bold">Paiement échoué</h2>

            <p class="text-muted mt-3">
                Une erreur est survenue lors du paiement.
                Veuillez réessayer plus tard.
            </p>

            <a href="{{ url('/') }}" class="btn btn-danger mt-4 px-4">
                Retour à l'accueil
            </a>

        </div>
    </div>

</body>
</html>