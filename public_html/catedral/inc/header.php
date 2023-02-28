<meta name="google-signin-client_id" content="937983505293-ppv6ot4r3taacbqfn52d2tj5k0m8ofs2.apps.googleusercontent.com">
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-social.css">
<link rel="stylesheet" href="assets/fontawesome/css/all.css">
<!--<link rel="stylesheet" href="assets/css/bootstrap.css">
<link rel="stylesheet" href="assets/css/font-awesome.css">
<link rel="stylesheet" href="assets/css/bootstrap-social.css">-->
<!-- -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
<!---->
<script src="assets/js/jquery.js"></script>
<script src="https://apis.google.com/js/platform.js?onload=onLoadCallback" async defer></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v12.0&appId=3099721333644585&autoLogAppEvents=1" nonce="y52POMPE"></script>
<section class="menu menu2 cid-scF3d8JkSQ" once="menu" id="menu2-4f">
    <nav class="navbar navbar-dropdown navbar-expand-lg justify-content-center">
        <div class="container-fluid">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <a href="index">
                        <img src="assets/images/web-01.png" alt="LOGO" style="height: 4.4rem;">
                    </a>
                </span>
                
            </div>
            <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation"> -->
            <button class="navbar-toggler" type="button" data-toggle="modal" data-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <div class="hamburger">
                    <span style="background-color:rgb(3, 104, 3);"></span>
                    <span style="background-color:rgb(3, 104, 3);"></span>
                    <span style="background-color:rgb(3, 104, 3);"></span>
                    <span style="background-color:rgb(3, 104, 3);"></span>
                </div>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <div class="flexsearch d-none d-sm-none d-md-block">
                        <div class="flexsearch--wrapper">
                            <form class="flexsearch--form" action="productos" method="get">
                                <div class="flexsearch--input-wrapper">
                                    <div style="display:none;"><?php echo $b_result = strlen(param('busca')) > 0 ? param('busca'): ""; ?></div>
                                    <input class="flexsearch--input" autocomplete="off" name="busca" id="busca" value="<?php echo $b_result?>" list="articulos" type="search" placeholder="Buscar">
                                </div>
                                 
                                <input class="flexsearch--submit" type="submit" value="&#10140;"/>
                            </form>

                        </div>
                </div>
               

                <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                    <li class="nav-item dropdown">
                    	
                        <?php  
                            if(!isset($_SESSION['cli_reg'])){ 
                        ?>
                        <!-- <a class="nav-link link dropdown-toggle text-black display-7" href="#" data-toggle="dropdown-submenu" aria-expanded="false"> -->
                        <a class="btn btn-info-outline-success dropdown-toggle display-7" href="#" data-toggle="dropdown-submenu" aria-expanded="false">
                            <!-- <span class="mobi-mbri mobi-mbri-user mbr-iconfont mbr-iconfont-btn"></span>Ingresar  -->
                            <span class="fa-solid fa-circle-user"></span>&nbsp;&nbsp;Ingresar</a>                          
                            
                		<div class="dropdown-menu">
                            <div class="d-none d-sm-none d-md-block">
                                <a class="dropdown-item text-black text-primary display-7" href="javascript:;" data-toggle="modal" data-target="#loginSession" aria-expanded="false">Iniciar  Sesión</a>
                            </div>
                            <div class="d-block d-sm-block d-md-none">
                                <a class="dropdown-item text-black text-primary display-7" href="ingresar">Iniciar  Sesión</a>
                            </div>
                            <a class="dropdown-item text-black text-primary display-7" href="registro" >Registrarse</a>
                			
                			<a class="text-black dropdown-item text-primary display-7" href="comosecompra" aria-expanded="false">Como se compra</a>
                		</div>
                        <?php  
                            }else{
                                //echo "<script>console.log('cliente_id: ".$cliente_id."');</script>" ;
                                ?>
                        <!-- <a class="nav-link link dropdown-toggle text-black display-7" href="#" data-toggle="dropdown-submenu" aria-expanded="false">
                            <span class="mobi-mbri mobi-mbri-user mbr-iconfont mbr-iconfont-btn"></span> <?php //$nombre_cliente = Clientes::select($cliente_id); echo "Hola ".$nombre_cliente[0]['cliente_nombre'] ?>
                        </a> -->
                        <a class="btn btn-info-outline-success dropdown-toggle display-7" href="#" data-toggle="dropdown-submenu" aria-expanded="false">
                            <span class="fa-solid fa-circle-user"></span>&nbsp;&nbsp; <?php $nombre_cliente = Clientes::select($cliente_id); echo "Hola ".$nombre_cliente[0]['cliente_nombre'] ?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-black text-primary display-7" href="mi-cuenta/editar">
                                Mis Datos
                            </a>
                            <a class="dropdown-item text-black text-primary display-7" href="repite-pedidos">Repetir pedidos</a>
                            <a class="dropdown-item text-black text-primary display-7" href="mis-pedidos">Historial pedidos</a>
                            <?php //if($cliente_id == 11066 || $cliente_id == 1702){ ?>
                                        <a class="dropdown-item text-black text-primary display-7" href="tarjetas">Mis tarjetas</a>
                            <?php //} ?>                            
                            <a class="text-black dropdown-item text-primary display-7" href="comosecompra" aria-expanded="false">Como se compra</a>
                            <a class="dropdown-item text-black text-primary display-7" onclick="signOut();" href="logout">Salir</a>
                            
                        </div>
                                <?php
                            } 
                        ?>
                    </li>
                    <li class="nav-item">
                    	<a class="btn btn-info-outline-success display-7" href="locales">
                    		<!-- <span class="mobi-mbri mobi-mbri-map-pin mbr-iconfont mbr-iconfont-btn"></span>Locales</a> -->
                    		<span class="fa-solid fa-location-dot"></span>&nbsp;&nbsp;Locales</a>
                    </li>
                </ul>
                
                <!-- MODAL-->
                <div class="modal fade" id="loginSession" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document" style="height: auto;">
                    <div class="modal-content">
                      <div class="modal-header">
                        <div style="width: 100%; text-align: center;">
                             <h3 class="modal-title" style="color: #0f3b84; font-weight: bold;" id="exampleModalLabel">INICIAR SESIÓN</h3>
                        </div>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                            <form method="post" id="loginForm" accept-charset="utf-8">
                                <div class="md-form mb-5">
                                    <input type="text" id="email" name="email" autocomplete="off" class="form-control validate" placeholder="E-mail" required>
                                    
                                </div>

                                <div class="md-form mb-4">
                                    <div class="input-group">
                                    <input type="password" id="clave" name="clave" autocomplete="off" class="form-control validate" placeholder="Clave" required>
                                        <span class="input-group-btn">
                                            <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarContrasena()"> 
                                                <span id="span_eye" class="fa fa-eye icon"></span>
                                            </button>
                                        </span>
                                    </div>
                                    
                              
                                </div>
                                <input type="hidden" name="tokenlogin" id="tokenlogin" value="<?php echo token('iniciosession')?>">
                                <span id="msm" ></span>
                            </form>  
                            <p>
                            <a href="javascript:;" data-dismiss="modal" data-toggle="modal" data-target="#restablecer" aria-expanded="false">¿Has olvidado tu contraseña?</a></p> 
                            <a class="btn btn-primary" id="btn_login">Ingresar</a>
                            <div id="sociales" style="display: block;margin-left: 8%;margin: 4%;">
                            <?php 
                                if(strlen($_SESSION['cli_reg']) > 0){
                                    $func_google = "";
                                }elseif(numParam('google') == 1){
                                    $func_google = "";
                                }else{
                                    $func_google = "onSignIn";
                                }
                                //echo $func_google = strlen($_SESSION['cli_reg']) > 0 ? "": "onSignIn";
                            ?>
                                <div id="bgoogle" class="g-signin2" data-onsuccess="<?php echo $func_google;?>" data-width="400" data-height="40" data-longtitle="true" data-theme="dark" data-scope="profile email"></div><br>
                                <!--<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"> </fb:login-button>-->
                                <div class="fb-login-button" data-width="600" data-size="large" data-button-type="login_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true" scope="public_profile,email" onlogin="checkLoginState();"></div>
                            </div>

                      </div>
                
                      <div class="modal-footer" style="margin:auto;">
                        <p class="w-100 text-center"><a href="registro" >Si aún no está registrado click aquí</a></p>
                      </div>
                      
                    </div>
                  </div>
                </div>

                <!-- RESET CONTRASEÑA -->
                <div class="modal fade" id="restablecer" tabindex="-1" role="dialog" aria-labelledby="PassModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content restablecer">
                      <div class="modal-header">
                        <div style="width: 100%; text-align: center;">
                             <h3 class="modal-title" style="color: #0f3b84; font-weight: bold;" id="PassModalLabel">RECUPERAR CONTRASEÑA</h3>
                        </div>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                            <form method="post" id="recuperar" accept-charset="utf-8">
                                <div class="md-form">
                                    <input type="text" id="email_reset" name="email_reset" class="form-control validate mb-3" placeholder="E-mail" required>
                                    <!-- <label for="defaultForm-email">E-mail</label> -->
                                   <!--  <p class="display-4 mt-3"><b class="modal-title">¿Olvidaste tu contraseña?</b><br>
                                        Por favor, escribe el email con el que estás registrado y te enviaremos tu contraseña a tu correo.</p>       -->
                                </div>
                                <input type="hidden" name="token" id="token" value="<?php echo token('reset_password')?>">
                                <input type="hidden" name="accion" id="accion" value="recuperar">
                                <p id="msm" class="respuesta">
                                    <b style="color: #0f3b84; font-weight: bold;">¿Olvidaste tu contraseña?</b><br>
                                        Por favor, escribe el email con el que estás registrado y te enviaremos tu contraseña a tu correo.
                                </p>
                            </form>  
                              
                      </div>
                      <div class="modal-footer mf2" style="margin:auto;">
                            <a class="btn btn-primary"  id="btn_recuperar">Restablecer</a>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="navbar-buttons mbr-section-btn">
                	<a class="btn btn-info-outline-success display-8" href="mi-carrito">
                        <span class="fa-solid fa-cart-arrow-down">
                            <span class="cant-intems">
                                <span class="itemCartTotal"><?php echo $items_carrito; ?></span>
                            </span>
                        </span>
                        <br>
                    </a>
                </div>
                <!-- <div class="navbar-buttons mbr-section-btn">
                	<a class="btn btn-info-outline display-4" href="mi-carrito">
                        <span class="mobi-mbri mobi-mbri-cart-add mbr-iconfont mbr-iconfont-btn"></span>
                        Carrito <span class="itemCartTotal" style="font-weight:bold;">&nbsp;&nbsp;
                            <?php //echo echo $items_carrito; ?>
                        </span>
                        <br>
                    </a>
                </div> -->
                
            </div>
        </div>
        <!-- <div class="justify-content-center" style="background: #0f3b84;z-index:0;" > -->
            <div id="menu">
				<label for="tm" id="toggle-menu">CATEGORIAS <span class="drop-icon">▾</span></label>
				<input type="checkbox" id="tm">
				<ul class="main-menu clearfix">
				<?php 	$categorias = Categorias::get("categoria_parent = 1","categoria_id DESC");
					$a = 1;
					$html="";

					foreach ($categorias as $categoria):
						$html.= '<li>
								<a href="productos/'.$categoria["categoria_slugit"].'">'.$categoria["categoria_nombre"];
								$subcat = Categorias::get("categoria_parent = ".$categoria['categoria_id'],"categoria_nombre ASC");
								$subclose = 0;
								if(haveRows($subcat)){
									$subclose = 1;
									$html.='<span class="drop-icon">▾</span>
									<label title="Toggle Drop-down" class="drop-icon" for="sm1">▾</label></a>
									<input type="checkbox" id="sm1">
                                        
											<ul class="sub-menu" style="font-size:small;">';
										foreach ($subcat as $sub) {
											$familias = Categorias::get("categoria_parent = ".$sub['categoria_id'],"categoria_nombre ASC");
											$fclose = 0;
											$html.='<li><a class ="sub-menu-a" href="productos/'.$sub["categoria_slugit"].'">'.$sub["categoria_nombre"];
												if(haveRows($familias)){
														$fclose = 1;
														$html.='<span class="drop-icon">▾</span>
			            								<label title="Toggle Drop-down" class="drop-icon" for="sm2">▾</label></a>
			            								<input type="checkbox" id="sm2">
			            								<ul class="sub-menu" style="font-size:small;">';
			            								foreach ($familias as $family) {
			            									$html.='<li><a class ="sub-menu-a" href="productos/'.$family["categoria_slugit"].'">'.$family["categoria_nombre"].'</a></li>';
			            								}
			            								$html.='</ul>';
												}
												$html.= $fclose == 0 ? '</a>' : '';
											$html.='</li>';											
										}
										
									$html.='</ul>';
								}
						  		$html.= $subclose == 0 ? '</a>' : '';
						$html.='</li>';
						$a++;
					endforeach;
					echo $html;
				?>

				</ul>

            </div>
        <!-- </div> -->
    </nav>
    <!-- <div class="row justify-content-center navbar-dropdown" style="background: #0f3b84;z-index:0;" > -->
			
		<!-- </div> -->
    
</section>

<div class="flexsearch d-block d-sm-block d-md-none clearfix" style="margin-top: 3.5rem !important;">
        <div class="flexsearch--wrapper">
            <form class="flexsearch--form" action="productos" method="get">
                <div class="flexsearch--input-wrapper">
                    <?php echo $b_result = strlen(param('busca')) > 0 ? param('busca'): ""; ?>
                    <input class="flexsearch--input" autocomplete="off" name="buscaM" id="buscaM" value="<?php echo $b_result?>" list="articulos" type="search" placeholder="Buscar">
                </div>
                 
                <input class="flexsearch--submit" type="submit" value="&#10140;"/>
            </form>

        </div>
    </div>
    <div class="search-result">
        <div id="results">

        </div>
    </div>

    

<script>
  

function mostrarContrasena(){
      var tipo = document.getElementById("clave");
      if(tipo.type == "password"){
          tipo.type = "text";
          document.getElementById("span_eye").className = "fa fa-eye-slash icon";
      }else{
          tipo.type = "password";
          document.getElementById("span_eye").className = "fa fa-eye icon";
      }
}

//función no utilizada
function onSignInGoogle(){
    
    var auth2 = gapi.auth2.init({
        // obviously replace this with your app's client id.  Also make sure you have you app setup as web app in the google console.
        client_id: '937983505293-ppv6ot4r3taacbqfn52d2tj5k0m8ofs2.apps.googleusercontent.com'
    });
    var loginButton = document.getElementById('bgoogle');
    
    auth2.attachClickHandler(loginButton, {}, onSignIn, failure);
    //clicked = true;

}

//función utilizada para iniciar sesion en google
function onSignIn(){
    const googleUser = gapi.auth2.getAuthInstance().currentUser.get();
    const profile = googleUser.getBasicProfile();
    const email = profile.getEmail();
    const name = profile.getGivenName();
    const lastname = profile.getFamilyName(); /*getGivenName*/
    /*console.log(name);
    console.log(lastname);*/
    if(profile){
        auth(name,lastname,email,"Login");
    }else{
        location.reload();
    }
    

}


//función no utilizada
function failure(error) {
        errors.value = JSON.stringify(error, undefined, 2);
        console.log('Error de logueo');
}

//función que compara correo de usuario logueado con base de datos.
function auth(UserName,UserLastName,UserEmail,UserAction){

    $.ajax({
            type: "POST",
            url: "ajax/users",
            data: {Nombre: UserName, Apellido: UserLastName, Email: UserEmail, Action: "Login"},
            dataType: "json",
            success: function(data){
                
                if(data.status=="success"){
                    //window.location.href = "ajax/carrito_session.php";
                    location.reload();
                }
                if(data.status=="redir"){
                    signOut();
                    window.location.href = "registro.php?google=1&nombre="+UserName+"&apellido="+UserLastName+"&email="+UserEmail;
                }
                if(data.status=="error"){
                    //$("#"+data.type).focus();
                    //swal("¡Error!", data.description,"warning");
                    console.log('error'+data.description);
                }
            }
        });
        

}
//función para asignar parámetros de login con facebook
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '3099721333644585',
      cookie     : true,
      xfbml      : true,
      version    : 'v12.0'
    });
      
    FB.AppEvents.logPageView();   
      
  };
//src script de facebook
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


//función para logueo en facebook
   function checkLoginState() {
        FB.getLoginStatus(function(response) {
            FB.login(function(response) {
                if (response.authResponse) {
                    console.log('Welcome!  Fetching your information.... ');
                    FB.api('/me?fields=email,name,first_name,last_name', function(response) {
                        auth(response.first_name,response.last_name,response.email,"Login");
                    });
                } else {
                    console.log('User cancelled login or did not fully authorize.');
                }
            });
        });
    }

//función deslogueo con google de la ecommerce.
    function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            console.log('User signed out.');
        });
    };

    




</script>