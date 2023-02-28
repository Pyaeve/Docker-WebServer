<?php
    require_once('inc/config.php');
    $direccion = param('id');
    $direccion_id = 0;
    if(!isset($_SESSION['cli_reg'])){
        #Si no existe session redirecciona
        header("Location:../productos");
        exit();
    }
    
    if(strlen($direccion)){
        $direcciones = Direcciones::get("direccion_slugit LIKE '%{$direccion}%'");
        $direccion_id = $direcciones[0]["direccion_id"];
        #--------------
        $cliente_id = $_SESSION['cliente']['cliente_id'];
        $clientes = Clientes::select($cliente_id);

        $direccion_denominacion = $direcciones[0]['direccion_denominacion'];
        $direccion_ciudad       = $direcciones[0]['direccion_ciudad'];
        $direccion_barrio       = $direcciones[0]['direccion_barrio'];
        $direccion_tel          = $direcciones[0]['direccion_tel'];
        $direccion_direccion    = $direcciones[0]['direccion_direccion'];
        $direccion_mapa         = $direcciones[0]['direccion_mapa'];
        $predeterminado         = $direcciones[0]['direccion_predeterminado'] > 0 ? 'checked="checked"' : '';   
        $sucursal_id            = $direcciones[0]['sucursal_id'];
        $numero_casa            = $direcciones[0]['direccion_nrocasa'];
    } 

    $mainTitle = "Direcciones";
    $subTitle = "Insertar registro";
    //"Llene sus datos para el REGISTRO";
    $btn_Registrarse = "Registrarse";

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
        .error{ color:#F00; font-size:13px; margin-top:5px;}
  </style>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyDckW-N1NSxLfBWeOQ874Sfu5w3zNtuoOs&sensor=false&libraries=drawing"></script>

</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
  
<section class="form7 cid-scEm75XVYS" id="form7-34" style="">
    
    
    <div class="container">
        <div class="mbr-section-head">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0"><strong><?=$mainTitle?></strong></h3>
            <p class="mbr-text mbr-fonts-style align-center mt-0 mb-0"><?=$subTitle?></p>
            <div class="col-auto mbr-section-btn align-right">
                    <a href="checkout" class="btn btn-primary display-4">Volver</a>
            </div>
            
        </div>

        <form method="POST" class="form-with-styler mx-auto" id="direccionform">
            <div class="row justify-content-center mt-4 col-lg-12">
                <div class="form-group col-md-6 col-lg-6 col-sm-12 mt-3">
                    <label>Denominación</label>
                    <input type="text" name="denominacion" id="denominacion" class="form-control" value="<?=$direccion_denominacion?>">
                    <p id="denominacion-error" class="error"></p>
                </div>
                <div class="col-md-6 col-lg-6 mt-3">
                    <label>
                        <input type="checkbox" name="predeterminada" id="predeterminada" value="1" <?=$predeterminado?>>&nbsp;&nbsp;Predeterminada&nbsp;<br>
                        <small>Indica que la dirección sera seleccionada por defecto.</small>
                    </label>
                </div>
                <div class="form-group col-md-6 col-lg-6 col-sm-12">
                    <label>Ciudad</label>
                    <input type="text" name="ciudad" id="ciudad" value="<?=$direccion_ciudad?>" class="form-control">
                    <p id="ciudad-error" class="error"></p>
                </div>
                <div class="form-group col-md-6 col-lg-6 col-sm-12">
                    <label>Barrio</label>
                    <input type="text" name="barrio" id="barrio" value="<?=$direccion_barrio?>" class="form-control">
                    <p id="barrio-error" class="error"></p>
                </div>
                <div class="form-group col-md-6 col-lg-6 col-sm-12">
                    <label>Tel&eacute;fono</label>
                    <input type="text" name="tel" id="tel" class="form-control" value="<?=$direccion_tel?>">
                    <p id="tel-error" class="error"></p>
                </div>
                  <div class="form-group col-md-6 col-lg-6 col-sm-12" style ="display:none;">
                    <label>Sucursal</label>
                     <select name="sucursal" class="form-control" id="sucursal" style="color:#000;">
                        
                        <?  
                            if($sucursal_id > 0){
                                $suc = Sucursales::select($sucursal_id);
                                if(haveRows($suc)){
                                    echo '<option value="'.$suc[0]["sucursal_id"].'">'.$suc[0]["sucursal_nombre"].'</option>';
                                }
                            }else{
                                echo '<option value="">Seleccionar Sucursal m&aacute;s cercana</option>';
                            }
                            
                            $sucursales = Sucursales::get("sucursal_delivery = 1");
                            foreach ($sucursales as $sucursal) {
                                echo '<option value="'.$sucursal["sucursal_id"].'">'.$sucursal["sucursal_nombre"].': '.$sucursal["sucursal_direccion"].'</option>';

                            }
                        ?>
                    </select>
                    <p id="sucursal-error" class="error"></p>
                </div>

                <div class="form-group col-md-9 col-sm-12 ">
                    <label>Direcci&oacute;n</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value="<?=$direccion_direccion?>">
                    <p id="direccion-error" class="error"></p>
                </div>
                <div class="form-group col-md-3 col-sm-12 ">
                    <label>Nro Casa</label>
                    <input type="text" name="numero_casa" id="numero_casa" class="form-control" value="<?=$numero_casa?>">
                    <p id="nrocasa-error" class="error"></p>
                </div>
              
                 <div class="form-group col-md-12 col-sm-12 ">
                    <label>Ubicación</label>
                    <a class="" onclick="placeMarker();" title="Marcar ubicación"><i class="fa fa-map-pin"></i></a>
                    <a class="divider"></a>
                    <a class="" onclick="" title="Mover"><i class="fa fa-arrows"></i></a>
                    <div id="mapcanvas" style="width: 100%; height: 450px; margin-left:0; border:1px solid #ccc;"></div><br><br>
                    <input class="LatLng" id="cliente_mapa" name="cliente_mapa" value="<?=$direccion_mapa?>" type="hidden" style="color:#000;" />
                    <p id="mapa-error" class="error"></p>
                </div>
                <div class="col-auto mbr-section-btn align-center">
                    <a href="javascript:;" class="btn btn-primary display-4" id="btn_directions">Guardar</a>
                </div>
                <input type="hidden" name="direccion_id" id="direccion_id" value="<?=$direccion_id;?>" >
                <input type="hidden" name="cliente_id" id="cliente_id" value="<?=$cliente_id;?>" >


            </div>
        </form>


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
<script src="js/mapcore.js"></script>

<script src="js/blockUI.js"></script>
<script type="text/javascript">
  /*$.blockUI.defaults.message = "<h2>Aguarde un momento por favor...</h2>";
  $.blockUI.defaults.overlayCSS.opacity = 0.0;
  $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);*/
</script>
<script src="js/sweetalert/sweet-alert.min.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<input name="animation" type="hidden">
<script type="text/javascript">
    $(function(){
        initmap();
        <? if($direccion_id == 0){ ?>
        placeMarker();
        <?  }   ?>
    });
</script>

  </body>
</html>