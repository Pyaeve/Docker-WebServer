<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" sizes="192x192"  href="{!! asset('images/android-icon-192x192.png') !!}">
<link rel="icon" type="image/png" sizes="32x32" href="{!! asset('images/favicon-32x32.png') !!}">
<link rel="icon" type="image/png" sizes="96x96" href="{!! asset('images/favicon-96x96.png') !!}">
<link rel="icon" type="image/png" sizes="16x16" href="{!! asset('images/favicon-16x16.png') !!}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>binguito</title>

    <!-- Scripts -->
    <script src="http://localhrifachon/public/js/app.js" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="http://localhost/rifachon/public/css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
      
        <main class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <?php include("bingo.php");?>
                    </div>
                     
                </div>
            </div>
          
        </main>
    </div>
</body>
</html>
