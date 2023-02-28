<?php
    require_once('inc/config.php');
    $token  = addslashes(trim($_GET['token']));

    $token = str_replace(" ", "+",  $token);
    $id = explode("_", $token);
    
    $code = "";
    if(strlen($token) > 0){
        $code = Encryption::Decrypt($token);
    }
    
    if(!$code){
        $code = $id[1];
    }
?>
<!DOCTYPE html>
<html  >
<head>
  <? include("inc/head.php")?>   
  <title>Cambiar Clave</title>
  <style>
    #result{width: 100%; margin-top: 10px;}
    .alert-danger{
        color: #b94a48;
        background-color: #f2dede;
        border-color: #ebccd1;
        width: 100%;
        margin: 21px 0;
    }
    .alert-success {
        color: #468847;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }
  </style>
</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
  
<section class="form7 cid-scEm75XVYS" id="form7-34">
    
    
    <div class="container">
        <div class="mbr-section-head">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0"><strong>Restablecer tu contraseña</strong></h3>
        </div>
        <div class="row justify-content-center mt-4 col-lg-12">
            <div class="col-lg-12 mx-auto mbr-form formoid" data-form-type="formoid">
               <form method="POST" class="mbr-form form-with-styler mx-auto" id="cambioform">
                   
                    <div class="dragArea row">
                        <div data-for="phone" class="col-lg-12 col-md-12 col-sm-12 form-group">
                            <input type="password" name="cliente_clave" placeholder="Contraseña" data-form-field="cliente_clave" class="form-control" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="" id="phone-form7-34">
                        </div>

                         <div data-for="phone" class="col-lg-12 col-md-12 col-sm-12 form-group">
                            <input type="password" name="cliente_clave2" placeholder="Reescribir Contraseña" data-form-field="cliente_clave2" class="form-control" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="" id="phone-form7-34">
                        </div>
                        <input type="hidden" value="cambio" name="accion" id="accion">
                        <input type="hidden" value="<?=token($code)?>" name="token" id="token">
                        <div class="col-auto mbr-section-btn align-center">
                            <a href="javascript:;" class="btn btn-primary display-4" id="btn_cambio">Cambiar Contraseña</a>
                        </div>
                        <??>
                        <div id="result"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<!-- FOOTER -->
<section class="footer1 cid-sczDlgHYFm" once="footers" id="footer1-33">
    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(35, 35, 35);"></div>
    <div class="container">
        <div class="row mbr-white">
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="mbr-section-subtitle mbr-fonts-style mb-2 display-7"><strong>INSTITUCIONAL</strong></h5>
                <ul class="list mbr-fonts-style display-4">
                    <li class="mbr-text item-wrap"><strong><a href="nuestra_empresa.html" class="text-white">Nuestra empresa</a></strong></li>
                    <li class="mbr-text item-wrap"><strong><a href="mision_y_vision.html" class="text-white">Misión y Visión</a></strong></li>
                    <li class="mbr-text item-wrap"><strong><a href="politica_de_calidad.html" class="text-white">Política de calidad</a></strong></li>
                    <li class="mbr-text item-wrap"><strong><a href="trabaja_con_nosotro.html" class="text-white">Trabaja con nosotros</a> </strong></li>
                    <li class="mbr-text item-wrap"><strong><a href="certificadoISO.html" class="text-white">Certificado Iso</a></strong></li>
                    <li class="mbr-text item-wrap"><br></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="mbr-section-subtitle mbr-fonts-style mb-2 display-7"><strong>SERVICIOS </strong></h5>
                <ul class="list mbr-fonts-style display-4">
                    <li class="mbr-text item-wrap"><strong><a href="preparados_magistrales.html" class="text-white">Preparados Magistrales</a></strong></li>
                    <li class="mbr-text item-wrap"><strong>Beneficios.</strong></li>
                    <li class="mbr-text item-wrap"><strong>Buscador de medicamentos.</strong></li>
                    <li class="mbr-text item-wrap"><strong>Medio de pago.</strong></li>
                    <li class="mbr-text item-wrap"><br></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="mbr-section-subtitle mbr-fonts-style mb-2 display-7"><strong>COMPRAS ONLINE</strong></h5>
                <ul class="list mbr-fonts-style display-4">
                    <li class="mbr-text item-wrap"><strong><a href="sesion.html" class="text-white">Mi cuenta</a></strong></li>
                    <li class="mbr-text item-wrap"><strong>
                        <a href="page4.html" class="text-white"></a><a href="carrito.html" class="text-white">Mi </a>
                        <b><a href="carrito.html" class="text-white">carrito</a></b></strong>
                    </li>
                    <li class="mbr-text item-wrap"><strong><a href="comosecompra.html" class="text-white text-primary">Como se compra</a></strong></li>
                    <li class="mbr-text item-wrap"><strong><a href="repetirpedido.html" class="text-white text-primary">Repetir pedido.</a></strong></li>
                    <li class="mbr-text item-wrap"><br></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="mbr-section-subtitle mbr-fonts-style mb-2 display-7"><strong>ATENCION AL CLIENTE</strong></h5>
                <p class="mbr-text mbr-fonts-style mb-4 display-4"><strong><a href="contacto.html" class="text-white text-primary">Contacto</a><br>términos y condiciones&nbsp;&nbsp;</strong><br></p>
                <h5 class="mbr-section-subtitle mbr-fonts-style mb-3 display-7"><strong>Seguimos en nuestras redes sociales</strong></h5>
                <div class="social-row display-7">
                    <div class="soc-item">
                        <a href="https://twitter.com/mobirise" target="_blank">
                            <span class="mbr-iconfont socicon socicon-facebook"></span>
                        </a>
                    </div>
                    <div class="soc-item">
                        <a href="https://twitter.com/mobirise" target="_blank">
                            <span class="mbr-iconfont socicon socicon-twitter"></span>
                        </a>
                    </div>
                    <div class="soc-item">
                        <a href="https://twitter.com/mobirise" target="_blank">
                            <span class="mbr-iconfont socicon-instagram socicon"></span>
                        </a>
                    </div>
                    
                </div>
            </div>
            <div class="col-12 mt-4">
                <p class="mbr-text mb-0 mbr-fonts-style copyright align-center display-7">
                    © Copyright 2020 - All Rights Reserved
                </p>
            </div>
        </div>
    </div>
</section>

<script src="assets/web/assets/jquery/jquery.min.js"></script>
<script src="assets/popper/popper.min.js"></script>
<script src="assets/tether/tether.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/smoothscroll/smooth-scroll.js"></script>
<script src="assets/viewportchecker/jquery.viewportchecker.js"></script>
<script src="assets/playervimeo/vimeo_player.js"></script>
<script src="assets/dropdown/js/nav-dropdown.js"></script>
<script src="assets/dropdown/js/navbar-dropdown.js"></script>
<script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>
<script src="assets/theme/js/script.js"></script>  

<script src="js/blockUI.js"></script>
<script type="text/javascript">
  $.blockUI.defaults.message = "<h2>Aguarde un momento por favor...</h2>";
  $.blockUI.defaults.overlayCSS.opacity = 0.0;
  $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
</script>
<script src="js/sweetalert/sweet-alert.min.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<input name="animation" type="hidden">
  </body>
</html>