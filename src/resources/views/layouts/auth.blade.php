<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Application de gestion financière</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Application de Gestion Financière">

    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="{{ asset("vendor/fontawesome-free/css/all.min.css") }}">
    <link id="theme-style" rel="stylesheet" href="{{ asset("css/sb-admin-2.min.css") }}">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset("vendor/jquery/jquery.min.js") }}"></script>
    <script src="{{ asset("vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset("vendor/jquery-easing/jquery.easing.min.js") }}"></script>
    <script src="{{ asset("js/sb-admin-2.min.js") }}"></script>
</body>
</html>



