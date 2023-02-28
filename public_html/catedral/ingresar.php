<?php
    require_once('inc/config.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php  include('inc/head.php'); ?>
</head>
<body class="bg-white">
<?php include_once('inc/header-v2.php'); ?>
  <!-- breadcrumb start -->
<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space breadcrumb-catedral">
    <div class="container">
        <div class="row">
              <div class="col-md-6 col-lg-12 display-6 navi text-center">
                <ul class="subBotonera history"><li><a href="productos/hogar239"><p><b>Iniciar Sesi&oacute;n</b></p></a></ul>             
            </div>
        </div>
    </div>
</section>
<!-- FOOTER -->

    
    
    <div class="container">
        <div class="row justify-content-center mt-4 col-lg-12">
            <div class="offset-md-4 col-lg-6 mx-auto mbr-form" data-form-type="formoid">
                <form method="post" id="loginForm2" accept-charset="utf-8">
                   <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="name">
                            <!--  -->
                       
                            <div class="dragArea row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="name">
                                    <label style="font-size:13px;">E-mail</label>
                                    <input type="text" id="email" name="email" autocomplete="off" class="form-control validate" required>
                                </div>   
                            </div>
                            <div data-for="phone" class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <label style="font-size:13px;">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" id="clave1" name="clave1" autocomplete="off" class="form-control validate" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                                    <span class="input-group-btn">
                                        <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarContrasena()"> 
                                            <span id="span_eye" class="fa fa-eye  "></span>
                                        </button>
                                    </span>
                                    <input type="hidden" id="clave" name="clave" autocomplete="off" class="form-control validate" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                                </div>
                            </div>
                            <input type="hidden" name="tokenlogin" id="tokenlogin" value="<?=token('iniciosession')?>">
                            <!--  -->
                        </div>
                    </div>
                    <div class="row">
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
                         <div class="col-lg-4 col-md-4">
                            
                            <a class="btn btn-primary btn-solid" id="btn_ingresar2">Ingresar</a>
                         
                        </div>
                        <div class="col-lg-3 col-md-4">
                             <div class="fb-login-button " data-height="60" data-width="180" data-size="large" data-button-type="login_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true" scope="public_profile,email" onlogin="checkLoginState();"></div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                              <div id="bgoogle" class="g-signin2" data-onsuccess="<?php echo $func_google;?>" data-width="1800" data-height="50" data-longtitle="true" data-theme="dark" data-scope="profile email"></div>
                        </div>
                        
                    </div>
                        
                        
                        </div>
                        <div class="row">
                            <div class="offset-lg-3 col-md-6">
                            
                            <hr>
                            </div></div>
                         <div class="row">
                               <div class="col-lg-12 col-md-12 col-sm-12">
                            <p class="w-100 text-center"> <a href="restablecer_clave">¿Has olvidado tu contraseña?</a></p>
                            </div>
                             <div class="col-lg-12 col-md-12 col-sm-12 " style="margin:auto;">
                            <p class="w-100 text-center"><a href="registro" >Si aún no está registrado click aquí</a></p>
                              </div>

                         </div>
                        
                        
                                  
                    
                        <div id="result"></div>
                            
                         </div>
                       
                     
   
                </form>

            </div>
        </div>
    </div>


<?php
   include_once ("inc/footer-v2.php");
?>