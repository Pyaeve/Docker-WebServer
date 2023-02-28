<?php
    require_once('inc/config.php');
    $tipo = "1";
    
    $mainTitle = "¡Registrese AQUÍ!";
    $subTitle = "Te invitamos a disfrutar de la experiencia de compra online en www.farmaciacatedral.com.py regístrate aquí de forma rápida y segura:";
    //"Llene sus datos para el REGISTRO";
    $btn_Registrarse = "Registrarse";
    $accion = "register";
    $direccion_id = 0;
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
        $direcciones = Direcciones::get("cliente_id = ".$cliente_id." AND direccion_predeterminado = 1 ","direccion_id DESC LIMIT 1");
        $direccion_id = $direcciones[0]["direccion_id"];

        $direccion_direccion = $direcciones[0]['direccion_direccion'];

        $direccion_direccion = $direcciones[0]['direccion_direccion'];
        $numero_casa = $direcciones[0]['direccion_nrocasa'];
        $direccion_denominacion = $direcciones[0]['direccion_denominacion'];
        $direccion_ciudad = $direcciones[0]['direccion_ciudad'];
        $direccion_barrio = $direcciones[0]['direccion_barrio'];
        $direccion_mapa = $direcciones[0]['direccion_mapa'];
        $direccion_ciudad = $direcciones[0]['direccion_ciudad'];
        $sucursal_id = $direcciones[0]['sucursal_id'];

        $mainTitle = "Mis Datos";
        $subTitle = "Actualizar mis datos";
        $accion = "update";
        $btn_Registrarse = "Actualizar";
    }
    
    
    $data = Zona_ecommerce::get();
    //pr($data);
    //exit();
    //$mapa = Zona_ecommerce::get();
    if(strlen($data[0]['zona_mapa']) > 0){
        $c1 = explode(",", $data[0]['zona_mapa']);
        $cordlat1 = trim($c1[0]);
        $cordlng1 = trim($c1[1]);
    }


    if(strlen($data[0]['zona_mapa']) > 0){
        $c2 = explode(",", $data[0]['zona_mapa']);
        $cordlat2 = trim($c2[0]);
        $cordlng2 = trim($c2[1]);
    }
    $zoom = 12;

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

  <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyDckW-N1NSxLfBWeOQ874Sfu5w3zNtuoOs&sensor=false&libraries=drawing"></script>

</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
  
<section class="form7 cid-scEm75XVYS" id="form7-34">  
    <div class="container">
        <div class="mbr-section-head">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0"><strong><?=$mainTitle?></strong></h3>
            <p class="mbr-text mbr-fonts-style align-center mt-3"><?=$subTitle?></p>
        </div>
        <!--  -->

                <div class="form-group col-md-12 col-sm-12 ">
                    <label>Ubicación</label>
                    <a class="" onclick="placeMarker();" title="Marcar ubicación"><i class="fa fa-map-pin"></i></a>
                    <a class="divider"></a>
                    <a class="" onclick="" title="Mover"><i class="fa fa-arrows"></i></a>
                    <div id="mapcanvas" style="width: 100%; height: 450px; margin-left:0; border:1px solid #ccc;"></div><br><br>
                    <input class="LatLng" id="cliente_mapa" name="cliente_mapa" value="<?=$direccion_mapa?>" type="text" style="color:#000;" />
                    <span id="direccion_mapa-error" class="error"></span>
                    <input type='hidden' name='latitud' id='latitud' />
					<input type='hidden' name='longitud' id='longitud' />
                </div>
             

        <!--  -->
    </div>
</section>

<!-- FOOTER -->


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
<!--<script src="js/mapcore.js"></script>-->
<script src="js/blockUI.js"></script>
<script type="text/javascript">
  $.blockUI.defaults.message = "<h2>Aguarde un momento por favor...</h2>";
  $.blockUI.defaults.overlayCSS.opacity = 0.0;
  $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
</script>
<script src="js/sweetalert/sweet-alert.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> -->
<script src="js/jquery.validate.js"></script>

<script type="text/javascript" src="js/app.js"></script>

<input name="animation" type="hidden">
<script type="text/javascript">
        var mapa;
        var marcador;
        var searchBox;
        function initialize() {
            var mapOptions = {
              zoom: 13,
              mapTypeControl: false,
              mapTypeId: 'satellite',
              gestureHandling: 'greedy',
              center: new google.maps.LatLng(<?php echo $cordlat1; ?>, <?php echo $cordlng1; ?>)
            };
            mapa = new google.maps.Map(document.getElementById('mapcanvas'), mapOptions);
            /////////////////////////////////

            google.maps.event.addListener(mapa, 'click', function(event) {
                var enAreaCobertura = false;
                $.each(poligonos, function(i, poligono) {
                    if(google.maps.geometry.poly.containsLocation(event.latLng, poligono)){
                      enAreaCobertura = true;
                    }
                });
                
                if(marcador != null){
                     marcador.setMap(null);
                }
                marcador = new google.maps.Marker({
                    position: event.latLng,
                    map: mapa
                });
                $('#latitud').val(event.latLng.lat());
                $('#longitud').val(event.latLng.lng());

                $.ajax({
                    type: 'POST',
                    url: 'ajax/info',
                    data: { accion: 'lote_info', lat: event.latLng.lat(), lng: event.latLng.lng() },
                    dataType: 'json',
                    success: function(datos){
                      console.log(datos)
                    }
                });
            });
            
            load_cobertura();
        }//initialize


        google.maps.event.addDomListener(window, 'load', initialize);

        function load_cobertura(){

            $.each(poligonos, function(i, poligono) {
              poligono.setMap(null);
            });

            poligonos = [];

            $.ajax({
              type: 'POST',
              url: 'ajax/coordenadas',
              data: { accion: 'cobertura' },
              dataType: 'json',
              success: function(datos){
                
              }
            });
        }

</script>
  </body>
</html>