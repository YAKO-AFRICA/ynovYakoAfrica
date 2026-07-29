<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement réussi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow border-0 text-center p-5" style="max-width: 500px;">
            
            <div class="mb-4">
                <div class="rounded-circle bg-success text-white d-inline-flex justify-content-center align-items-center"
                     style="width: 90px; height: 90px; font-size: 40px;">
                    ✓
                </div>
            </div>

            <h2 class="text-success fw-bold">Paiement réussi</h2>

            <p class="text-muted mt-3">
                Votre paiement a été effectué avec succès.
            </p>

            <a href="{{ url('/') }}" class="btn btn-success mt-4 px-4">
                Retour à l'accueil
            </a>

        </div>
    </div>

</body>
</html>