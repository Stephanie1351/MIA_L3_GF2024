<!DOCTYPE html>
<html lang="fr">
<head>
    <title>@yield('title', "Page d'erreur")</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/favicon/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset("assets/plugins/fontawesome/css/all.min.css") }}">
    <link id="theme-style" rel="stylesheet" href="{{ asset("assets/css/portal.css") }}">
    <link id="theme-style" rel="stylesheet" href="{{ asset("css/style.css") }}">

</head>

<body class="app app-404-page">
    <div class="container mb-5">
	    <div class="row">
		    <div class="col-12 col-md-11 col-lg-7 col-xl-6 mx-auto">
			    <div class="app-branding text-center mb-5">
		            <a class="app-logo" href="{{ route('dashboard') }}">
                        <img class="logo-icon mr-2" src="{{ asset('images/logo.png') }}" alt="logo">
                        <span class="logo-text">GEST FINANCIÈRE</span>
                    </a>
		        </div>
			    <div class="app-card p-5 text-center shadow-sm">
                    @yield('content')
				    <a class="btn btn-primary" href="{{ route('dashboard') }}">Retourner à la page d'accueil</a>
			    </div>
		    </div>
	    </div>
    </div>
</body>
</html>

