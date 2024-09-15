<!DOCTYPE html>
<html lang="fr">
<head>
    <title>@yield('title', 'Projet gestion financière')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">

    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link id="theme-style" rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
</head>

<body id="page-top">
    <div id="wrapper">
        <div class="container-fluid">
            <div class="text-center">
                @yield('content')
                <a class="btn btn-primary mt-3" href="{{ route('index') }}">Retourner à la page d'accueil</a>
            </div>
        </div>
    </div>
</body>
</html>

