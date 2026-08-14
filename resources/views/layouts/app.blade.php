<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#076633">

    <!-- iOS support -->
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'YNOV') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(135deg, #076603, #076604);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .auth-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .auth-title {
            font-weight: 600;
        }

    </style>

</head>

<body>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if(session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: "{{ session('status') }}",
                timer: 2500,
                showConfirmButton: false
            })

        </script>
    @endif

    @if(session('success'))
    <script>
    Swal.fire({
        toast:true,
        position:'top-end',
        icon:'success',
        title:"{{ session('success') }}",
        showConfirmButton:false,
        timer:3000
    })
    </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: "{{ session('error') }}"
            })

        </script>
    @endif

</body>

</html>
