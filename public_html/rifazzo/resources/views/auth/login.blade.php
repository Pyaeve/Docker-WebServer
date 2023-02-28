
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="TbhjZ5SC7AymwIJWVhq3T3xp4wHerUf59aiKJ6ve">

    <title>Rifachon</title>

   
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">



 
    <!-- Styles 
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.css"> -->
       <link rel="stylesheet" type="text/css" href="http://localhost/ejapo/public/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="http://localhost/ejapo/public/css/app.css">
  <link rel="stylesheet" type="text/css" href="http://localhost/ejapo/public/css/select2.css">
  <link rel="stylesheet" type="text/css" href="http://localhost/ejapo/public/css/select2-bootstrap.css">
   
  <link href='https://unpkg.com/@fullcalendar/core@4.4.0/main.min.css' rel='stylesheet' />


  <link href='https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.css' rel='stylesheet' />

  <link href='https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.min.css' rel='stylesheet' />

  <link href='https://unpkg.com/@fullcalendar/list@4.4.0/main.min.css' rel='stylesheet' />

  <link href="http://localhost/ejapo/public/font-awesome/css/font-awesome.css" rel="stylesheet">
 
</head>
   

<body>
    <div id="app">
         
                 <main class="py-4">
            <div class="container">
    <div class="row justify-content-center">
    <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="card">
                <div class="card-header text-center"> <img  class="img-responsive" style=""  src="{!! asset('images/rifachon.png') !!}" height="140px" width="150px" align="center" /></div>

                <div class="card-body">
                  
                        <div class="col-md-12">
                           <h2 class="text-center"> Acceder</h2> 
                        </div>
                       <div class="col-md-12">
                           <form method="POST" action="{!! route('login') !!}" aria-label="Login">
                         @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-12 col-form-label text-md-center">Correo Electronico</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="" required autofocus>

                                                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label text-md-center">Contrase&ntilde;a</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>

                                                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                 {!! NoCaptcha::display() !!}



@if ($errors->has('g-recaptcha-response'))
    <span class="help-block">
        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
    </span>
@endif
                     </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                 <a class="btn btn-link" href="http://localhost/ejapo/public/password/reset">
                                    Olvidaste la contrasen&ntilde;a?                                </a>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" >

                                    <label class="form-check-label" for="remember">
                                        Recuerdame                                    </label>
                                   
                                </div>
                               
                            </div>

                        </div>

                        <div class="form-group row ">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                   Iniciar Sesi&oacute;n                                </button>
                                 
                               
                            </div>
                            
                        </div>
                    </form>
                       </div>
                    </div>
                     
                    
               
            </div>
        </div>
    </div>
</div>
        </main>
    </div>

</body>
<!-- Scripts -->
 
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"  ></script>
    <script type="text/javascript" src="http://localhost/ejapo/public/js/jquery.mask.js"></script>
       <script type="text/javascript" src="http://localhost/ejapo/public/js/popper.min.js"></script>
    <script type="text/javascript" src="http://localhost/ejapo/public/js/tooltips.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/js/bootstrap.js"></script>
<script src='https://unpkg.com/@fullcalendar/core@4.4.0/main.min.js'></script>



  <script src='https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.js'></script>

  <script src='https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.min.js'></script>

  <script src='https://unpkg.com/@fullcalendar/list@4.4.0/main.min.js'></script>

  <script src='https://unpkg.com/@fullcalendar/bootstrap@4.4.0/main.min.js'></script>


 
 
 <script type="text/javascript" src="http://localhost/ejapo/public/js/select2.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LeFRHsdAAAAAGyAXqGJLrewpsyREjP1CdXX1aDP" async defer></script>
    <script type="text/javascript">
        $(document).ready(function(){
                     });
    </script>
</html>
