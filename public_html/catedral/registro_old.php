<?php
    require_once('inc/config.php');
    $nombre = "";
    $apellido = "";
    $email = "";
    $direccion = "";
    $tel = "";
    $ciudad = "";
    $barrio = "";
    $accion = "register";
    $ci = "";
    $ruc = "";
    $tipo = "1";
    
    $mainTitle = "¡Registrese AQUÍ!";
    $subTitle = "Te invitamos a disfrutar de la experiencia de compra online en www.farmaciacatedral.com.py regístrate aquí de forma rápida y segura:";
    //"Llene sus datos para el REGISTRO";
    $btn_Registrarse = "Registrarse";

    if($cliente_id > 0){
        $cliente_id = $_SESSION['cliente']['cliente_id'];
        $clientes = Clientes::select($cliente_id);

        $nombre = $clientes[0]['cliente_nombre'];
        $apellido = $clientes[0]['cliente_apellido'];
        $email = $clientes[0]['cliente_email'];
        $direccion = $clientes[0]['cliente_direccion'];
        $tel = $clientes[0]['cliente_telefono'];
        $ciudad = $clientes[0]['cliente_ciudad'];
        $barrio = $clientes[0]['cliente_barrio'];
        $ci = $clientes[0]['cliente_cedula'];
        $ruc = $clientes[0]['cliente_ruc'];
        $tipo = $clientes[0]['cliente_tipo'];


        $mainTitle = "Mis Datos";
        $subTitle = "Actualizar mis datos";
        $accion = "update";
        $btn_Registrarse = "Actualizar";
    }
?>
<!DOCTYPE html>
<html  >
<head>
  <? include("inc/head.php")?>   
  <title>Registro</title>
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
    #btn_reg{
        border-radius: 12px;
    }

    .btn-secondary {
        background-color: #6c757d !important;
        border-color: #6c757d !important;;
    }

    .btn-secondary:hover, .btn-secondary:focus, .btn-secondary.focus, .btn-secondary.active {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 20%);
    }
    .error{ color: red; font-size: 13px; }
  </style>

</head>
<body>
 <? require_once('inc/header.php'); ?>
  <? require_once('inc/nav.php'); ?>
  
<section class="form7 cid-scEm75XVYS" id="form7-34">
    
    
    <div class="container">
        <div class="mbr-section-head">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0"><strong><?=$mainTitle?></strong></h3>
            <p class="mbr-text mbr-fonts-style align-center mt-3"><?=$subTitle?></p>

            
        </div>
        <div class="row justify-content-center mt-4 col-lg-12">
            <div class="col-lg-12 mx-auto mbr-form" data-form-type="formoid">
                <form method="POST" class="form-with-styler mx-auto" id="registroform">
           
                   <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 form-group" data-for="name">
                            <!--  -->
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="lastname">
                                    <a href="javascript:;" class="btn btn-primary display-4 w-100" id="persona">Persona</a>
                            </div>
                            <div class="dragArea row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="name">
                                    <label style="font-size:13px;">Nombre<b class="text-primary">*</b></label>
                                    <input type="text" name="cliente_nombre" data-form-field="cliente_nombre" class="form-control" id="cliente_nombre" value="<?=$nombre?>" required>
                                </div>   
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="email">
                                <label style="font-size:13px;">E-mail<b class="text-primary"> *</b></label>
                                <input type="email" name="cliente_email" data-form-field="cliente_email" class="form-control" id="cliente_email" value="<?=$email?>" required>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="email">
                                <label style="font-size:13px;">R.U.C<b class="text-primary"> *</b></label>
                                <input type="text" name="cliente_ruc" data-form-field="cliente_ruc" class="form-control" id="cliente_ruc" value="<?=$ruc?>">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="cliente_telefono">
                                <label style="font-size:13px;">Tel / Celular</label>
                                <input type="text" name="cliente_telefono" data-form-field="cliente_telefono" class="form-control" id="cliente_telefono" value="<?=$tel?>" >
                            </div>

                            <div data-for="phone" class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <label style="font-size:13px;">Contraseña</label>

                                <input type="password" name="cliente_clave" data-form-field="cliente_clave" class="form-control" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="" required id="phone-form7-34">
                            </div>
                            <!--  -->
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 form-group" data-for="name">
                            <!--  -->
                            <div class="dragArea row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="lastname">
                                     <a href="javascript:;" class="btn btn-secondary display-4 w-100" id="empresa">Empresa</a>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="lastname">
                                    <label style="font-size:13px;">Apellido<b class="text-primary">*</b></label>
                                    <input type="text" name="cliente_apellido" data-form-field="cliente_apellido" class="form-control" id="cliente_apellido" value="<?=$apellido?>" required>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="email">
                                    <label style="font-size:13px;">C.I.<b class="text-primary"> *</b></label>
                                    <input type="text" name="cliente_cedula" data-form-field="cliente_cedula" class="form-control" id="cliente_cedula" value="<?=$ci?>">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="cliente_direccion">
                                    <label style="font-size:13px;">Dirección</label>
                                    <input type="text" name="cliente_direccion" data-form-field="cliente_direccion" class="form-control" id="cliente_direccion" value="<?=$direccion?>" >
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="cliente_ciudad">
                                    <label style="font-size:13px;">Ciudad</label>
                                    <input type="text" name="cliente_ciudad" data-form-field="cliente_ciudad" class="form-control" id="cliente_ciudad" value="<?=$ciudad?>"  >
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="cliente_barrio">
                                     <label style="font-size:13px;">Barrio</label>
                                    <input type="text" name="cliente_barrio" data-form-field="cliente_barrio" class="form-control" id="cliente_barrio" value="<?=$barrio?>" >
                                </div>
                                    <input type="hidden" value="<?php echo token("registro");?>" name="token_registro" id="token_registro">
                                    <input type="hidden" value="<?=$accion?>" name="accion" id="accion">
                                    <input type="hidden" value="1" name="cliente_tipo" id="cliente_tipo">

                            
                            </div>
                            <!--  -->
                        </div>

                        <div class="col-auto mbr-section-btn align-center">
                            <!--<a href="javascript:;" class="btn btn-primary display-4" id="btn_reg"><?//=$btn_Registrarse?></a>-->
                            <button class="btn btn-primary display-4" id="btn_reg"><?=$btn_Registrarse?></button>
                        </div>
                        <div id="result"></div>
                    </div>
   
                </form>

            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<section class="footer1 cid-sczDlgHYFm" once="footers" id="footer1-2h">
    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(35, 35, 35);"></div>
    <div class="container">
        <div class="row mbr-white">
            <div class="col-12 col-md-6 col-lg-3">
                <h6 class="mbr-section-subtitle mbr-fonts-style mb-2"><strong>INSTITUCIONAL</strong></h6>
                <ul class="list mbr-fonts-style display-4 lf">
                    <li class="mbr-text item-wrap"><strong><a href="nuestra_empresa" class="text-white">Nuestra empresa</a> </strong></li>
                    <li class="mbr-text item-wrap"><strong><a href="mision_y_vision" class="text-white">Misión y Visión</a></strong></li>
                    <li class="mbr-text item-wrap"><strong><a href="politica_de_calidad" class="text-white">Política de calidad</a></strong></li>
                    <li class="mbr-text item-wrap"><strong><a href="trabaja_con_nosotros" class="text-white">Trabaja con nosotros</a> </strong></li>
                    <li class="mbr-text item-wrap"><strong><a href="certificadoISO" class="text-white">Certificado Iso</a></strong></li>
                    <li class="mbr-text item-wrap"><br></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <h6 class="mbr-section-subtitle mbr-fonts-style mb-2"><strong>SERVICIOS </strong></h6>
                <ul class="list mbr-fonts-style display-4 lf">
                    <li class="mbr-text item-wrap"><strong><a href="preparados_magistrales" class="text-white">Preparados Magistrales</a></strong></li>
                    <li class="mbr-text item-wrap"><strong>Beneficios.</strong></li>
                    <li class="mbr-text item-wrap"><strong>Buscador de medicamentos.</strong></li>
                    <li class="mbr-text item-wrap"><strong>Medio de pago.</strong></li>
                    <li class="mbr-text item-wrap"><br></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <h6 class="mbr-section-subtitle mbr-fonts-style mb-2"><strong>COMPRAS ONLINE</strong></h6>
                <ul class="list mbr-fonts-style display-4 lf">
                    <li class="mbr-text item-wrap">
                        <strong>
                            <a href="javascript:;" data-toggle="modal" data-target="#loginSession" aria-expanded="false" class="text-white">Mi cuenta</a>
                        </strong>
                    </li>

                    <li class="mbr-text item-wrap"><strong><a href="comosecompra.html" class="text-white text-primary">Como se compra</a></strong></li>
                    <? if(isset($_SESSION['cli_reg'])){  ?>
                    <li class="mbr-text item-wrap"><strong><a href="repite-pedidos" class="text-white text-primary">Repetir pedido.</a></strong></li>
                    <?  }?>
                    <li class="mbr-text item-wrap"><br></li>
                </ul>
                
                <h6 class="mbr-section-subtitle mbr-fonts-style mb-3"><strong>Seguimos en nuestras redes sociales</strong></h6>
                <div class="social-row display-7">
                    <div class="soc-item">
                        <a href="https://www.facebook.com/FarmaciaCatedralPy/" target="_blank">
                            <span class="mbr-iconfont socicon socicon-facebook"></span>
                        </a>
                    </div>
                    <div class="soc-item">
                        <a href="https://twitter.com/FarmaCatedral?s=08" target="_blank">
                            <span class="mbr-iconfont socicon socicon-twitter"></span>
                        </a>
                    </div>
                    <div class="soc-item">
                        <a href="https://www.instagram.com/farmaciacatedralpy/?hl=es-la" target="_blank">
                            <span class="mbr-iconfont socicon-instagram socicon"></span>
                        </a>
                    </div>
                </div>

            </div>
            <div class="col-12 col-md-6 col-lg-3 lf">
                <h6 class="mbr-section-subtitle mbr-fonts-style mb-2"><strong>ATENCION AL CLIENTE</strong></h6>
                <p class="mbr-text mbr-fonts-style mb-4 display-4">
                    <strong><a href="contactos" class="text-white text-primary">Contacto</a><br>términos y condiciones&nbsp;&nbsp;</strong><br>
                </p>
                <div class="social-row display-7">
                   <img src="images/iso9001.jpg">
                </div>

            </div>

            <div class="col-12 mt-4">
                <p class="mbr-text mb-0 mbr-fonts-style copyright align-center">© Copyright 2020 - All Rights Reserved</p>
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
<script src="js/jquery.validate.js"></script>
<script type="text/javascript">

  /*$.blockUI.defaults.message = "<h2>Aguarde un momento por favor...</h2>";
  $.blockUI.defaults.overlayCSS.opacity = 0.0;
  $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);*/
</script>
<script src="js/sweetalert/sweet-alert.min.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<input name="animation" type="hidden">
<script type="text/javascript">
    $(document).ready(function(){
        <? if($tipo == 2){
            ?>
            var tipo = $('#cliente_tipo').val('2');
            $('#empresa').removeClass('btn-secondary').addClass('btn-primary');
            $('#persona').removeClass('btn-primary').addClass('btn-secondary');
            <?
           }else{
            ?>
            var tipo = $('#cliente_tipo').val('1');
            $('#persona').removeClass('btn-secondary').addClass('btn-primary');
            $('#empresa').removeClass('btn-primary').addClass('btn-secondary');
            <?
           }
        ?>
        $('#empresa').click(function(){
             var tipo = $('#cliente_tipo').val('2');
            $('#empresa').removeClass('btn-secondary').addClass('btn-primary');
            $('#persona').removeClass('btn-primary').addClass('btn-secondary');
        });
        $('#persona').click(function(){
             var tipo = $('#cliente_tipo').val('1');

            $('#persona').removeClass('btn-secondary').addClass('btn-primary');
            $('#empresa').removeClass('btn-primary').addClass('btn-secondary');
        });
    });

</script>
  </body>
</html>