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
          #Datos requeridos
        #Apellido, email ,ci / o ruc esta vacio obligo a completar 
        $ok = true;
        
        if( strlen($clientes[0]['cliente_apellido']) == NULL){
            $ok = false;
            $require_apellido = '<span id="cliente_apellido-error" class="error">Completa el campo apellido</span>';
        }
        if( strlen($clientes[0]['cliente_email']) == NULL){
            $ok = false;
            $require_email = '<span id="cliente_apellido-error" class="error">Completa el campo Email</span>';
        }
        if($clientes[0]['cliente_tipo'] == 1 ){
            if( strlen($clientes[0]['cliente_cedula']) == NULL){
                $ok = false;
                $require_ci = '<span id="cliente_apellido-error" class="error">Completa el campo C.I</span>';
            }
        }
        if($clientes[0]['cliente_tipo'] == 2 ){
            if( strlen($clientes[0]['cliente_ruc']) == NULL){
                $ok = false;
                 $require_ruv = '<span id="cliente_apellido-error" class="error">Completa el campo R.U.C</span>';
            }
        }
    }
    //$_POST['contraentrega_formapago'] = numParam('google');
    $google = numParam('google');
    if($google == 1){
       
        $email 		= Param('email');
	    $nombre 	= Param('nombre');
	    $apellido	= Param('apellido');

    }
?>
<!DOCTYPE html>
<html  >
<head>
  <?php include("inc/head.php"); ?> 
    
 
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
<body class="bg-white">
<?php include_once('inc/header-v2.php');?>
<section class="breadcrumb-section breadcrumb-catedral">
    <div class="container">
        <div class="row">
              <div class="col-md-6 col-lg-12 display-6 navi">
              
             
            </div>
        </div>
    </div>
</section>
<section class="form7 cid-scEm75XVYS" id="form7-34" style="">  
    <div class="container">
        <div class="mbr-section-head">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0"><strong><?php echo $mainTitle ?></strong></h3>
            <p class="mbr-text mbr-fonts-style align-center mt-3"><?php echo $subTitle ?></p>
        </div>
        <!--  -->
        <form method="POST" class="form-with-styler mx-auto" id="registroform">
            <div class="row justify-content-center mt-4 col-lg-12">
                <div class="form-group col-md-6 col-lg-6 col-sm-12">
                    <a href="javascript:;" class="btn btn-primary display-4 w-100" id="persona">Persona</a>
                </div>
                <div class="form-group col-md-6 col-lg-6 col-sm-12">
                    <a href="javascript:;" class="btn btn-secondary display-4 w-100" id="empresa">Empresa</a>
                </div>
                <!-- DOCUMENTOS a-->
                <div class="form-group col-md-6 col-lg-6 col-sm-12 mt-3" id="div_ci">
                    <label>C.I</label>
                    <input type="number" name="cliente_cedula" id="cliente_cedula" class="form-control" value="<?php echo $ci ?>" required>
                    <?php echo $require_ci ?>
                </div>
                <div class="form-group col-md-6 col-lg-6 col-sm-12 mt-3">
                    <label>R.U.C</label>
                    <input type="text" name="cliente_ruc" id="cliente_ruc" class="form-control" placeholder="9999999-9" value="<?php echo $ruc ?>" required>
                    <span id="cliente_ruc-error" class="error"></span>
                    <?php echo $require_ruc ?>
                </div>
                <!-- NOMBRES -->
                <div class="form-group col-md-6 col-lg-6 col-sm-12 mt-3">
                    <label id="lbl_nombre">Nombre</label>
                    <input type="text" name="cliente_nombre" id="cliente_nombre" class="form-control" value="<?php echo $nombre ?>" required>
                </div>
                <div class="form-group col-md-6 col-lg-6 col-sm-12 mt-3" id="div_apellido">
                    <label>Apellido</label>
                    <input type="text" name="cliente_apellido" id="cliente_apellido" class="form-control" value="<?php echo $apellido ?>" required>
                    <?php echo $require_apellido ?>
                </div>
                <!-- EMAIL/TEL -->
                <div class="form-group col-md-6 col-lg-6 col-sm-12 mt-3">
                    <label>E-mail</label>
                    <input type="text" name="cliente_email" id="cliente_email" class="form-control" placeholder="name@example.com" value="<?php echo $email ?>" required>
                    <?php echo $require_email ?>
                </div>
                
                <div class="form-group col-md-6 col-lg-6 col-sm-12 mt-3">
                    <label>Tel / Celular</label>
                    <input type="text" name="cliente_telefono" id="cliente_telefono" class="form-control" value="<?php echo $tel ?>" required>
                </div>
                <!-- PASS -->
                <div class="form-group col-md-6 col-lg-6 col-sm-12 mt-3">
                    <label>Contraseña</label>
                    <input type="password" name="cliente_clave" class="form-control" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="" <?php echo $accion == "update" ? "" : "required" ?>>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 mt-3">
                <h3 class="mbr-section-title mbr-fonts-style align-center mb-0"><strong>Dirección de envio</strong></h3>
                </div>
                <div class="form-group col-md-12 col-sm-12 ">
                    <label>Ubicación</label>
                    <a class="" onclick="placeMarker();" title="Marcar ubicación"><i class="fa fa-map-pin"></i></a>
                    <a class="divider"></a>
                    <a class="" onclick="" title="Mover"><i class="fa fa-arrows"></i></a>
                    <div id="mapcanvas" style="width: 100%; height: 450px; margin-left:0; border:1px solid #ccc;"></div><br><br>
                    <input class="LatLng" id="cliente_mapa" name="cliente_mapa" value="<?php echo $direccion_mapa ?>" type="hidden" style="color:#000;" />
                    <span id="direccion_mapa-error" class="error"></span>
                </div>


                <div class="form-group col-md-9 col-sm-12 ">
                    <label>Direcci&oacute;n de envio</label>
                    <input type="text" name="direccion" id="direccion" class="direccion form-control" value="<?php echo $direccion_direccion ?>" required>
                </div>
                <div class="form-group col-md-3 col-sm-12 ">
                    <label>Nro Casa</label>
                    <input type="text" name="numero_casa" id="numero_casa" class="form-control" value="<?php echo $numero_casa ?>">
                </div>
                <div class="form-group col-md-6 col-lg-6 col-sm-12 mt-3">
                    <label>Denominación</label>
                    <input type="text" name="denominacion" id="denominacion" class="form-control" value="<?php echo $direccion_denominacion ?>" required>
                </div>

                <div class="form-group col-md-6 col-lg-6 col-sm-12 mt-3">
                    <label>Ciudad</label>
                    <input type="text" name="ciudad" id="ciudad" value="<?php echo $direccion_ciudad ?>" class="ciudad form-control">
                </div>
                <div class="form-group col-md-6 col-lg-6 col-sm-12 mt-3">
                    <label>Barrio</label>
                    <input type="text" name="barrio" id="barrio" value="<?php echo $direccion_barrio ?>" class="barrio form-control">
                </div>

                <div class="form-group col-md-6 col-lg-6 col-sm-12" style="display:none;">
                    <label>Sucursal</label>
                     <select name="sucursal" class="form-control mt-3" id="sucursal" style="color:#000;">
                        <?php  
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
                                echo '<option value="'.$sucursal["sucursal_id"].'">'.$sucursal["sucursal_nombre"].'</option>';
                            }
                        ?>
                    </select>
                    <span id="sucursal-error" class="error"></span>
                </div>

                <div class="form-group col-md-12 col-sm-12 ">
                    
                </div>
                <div class="col-auto mbr-section-btn align-center">
                    <button class="btn btn-primary display-4" type="submit" id="btn_reg">Guarda</button>
                </div>
                <div id="result"></div>
            </div>
            <input type="hidden" value="1" name="cliente_tipo" id="cliente_tipo">
            <input type="hidden" value="<?php echo token("registro"); ?>" name="token_registro" id="token_registro">
            <input type="hidden" value="<?php echo $accion ?>" name="accion" id="accion">
        </form>
        <!--  -->
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
                    <?php if(isset($_SESSION['cli_reg'])){  ?>
                    <li class="mbr-text item-wrap"><strong><a href="repite-pedidos" class="text-white text-primary">Repetir pedido.</a></strong></li>
                    <?php  } ?>
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
    window.onload = function exampleFunction() {
            //console.log('The Script will load now.');
        var tipo = $('#cliente_tipo').val();

    }
    $(document).ready(function(){
        
        var invalidChars = [
        "+",
        "e",
        ".",
        ",",
        "-"
        ];
        var validkeys = [
        96,97,98,99,100,101,102,103,104,105,109,8   ];
        var input_ci = document.getElementById("cliente_cedula");
        var input_ruc = document.getElementById("cliente_ruc");
        var direccion = document.getElementById("direccion");
        
        /*if(direccion){
            direccion.disabled = true;
        }else{
            direccion.disabled = false;
        }*/
        
        
        input_ci.addEventListener("keydown", function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });

        /*input_ruc.addEventListener("keydown", function(e) {
            if (!validkeys.includes(e.keyCode)) {
            //if (invalidChars.includes(e.key)) {
                e.preventDefault();
                //console.log(e.keyCode);
            }
        });*/

        $('#cliente_cedula').change(function (){
                   
             $.ajax({
                url:"../clientes.php", //the page containing php script
                type: "post", //request type,
                dataType: 'json',
                data: {cedula: $('#cliente_cedula').val(), enlace: "http://appcatedral.farmaciacatedral.com.py:8080/charliJavaEnvironment_test/rest/ListarClientes", ruc:""},
                success:function(result){
                    $('#cliente_apellido').val($.trim(result.apellidos));
                    $('#cliente_nombre').val($.trim(result.nombres));
                }
            });
            
            /*$.ajax({
                url:"http://appcatedral.farmaciacatedral.com.py:8181/charliJavaEnvironment/rest/ListarClientes", //the page containing php script
                type: "post", //request type,
                dataType: 'json',
                contentType: "application/json",
                data: JSON.stringify({"cedula": "952800","ruc": ""}),
                success:function(data){
                    //$('#cliente_apellido').val(result.apellidos);
                    //$('#cliente_nombre').val(result.nombres);
                    console.log(data);
                },
                    error: function (data, errorThrown) {
                    alert("Fail");
                    alert(errorThrown);
                }
            });*/

         });

         $('#cliente_ruc').change(function (){
             console.clear();             
             $.ajax({
                url:"../clientes.php", //the page containing php script
                type: "post", //request type,
                dataType: 'json',
                data: {cedula: "", enlace: "http://appcatedral.farmaciacatedral.com.py:8080/charliJavaEnvironment_test/rest/ListarClientes", ruc: $('#cliente_ruc').val()},
                success:function(result){
                    $('#cliente_apellido').val($.trim(result.apellidos));
                    $('#cliente_nombre').val($.trim(result.nombres));
                }
            });

         });

        <?php if($tipo == 2){
            ?>
            var tipo = $('#cliente_tipo').val('2');
            $('#empresa').removeClass('btn-secondary').addClass('btn-primary');
            $('#persona').removeClass('btn-primary').addClass('btn-secondary');
            $("#cliente_ruc").prop('required',true);
            $("#cliente_cedula").prop('required',false);
            $("#cliente_apellido").prop('required',false);
            document.getElementById('lbl_nombre').innerHTML = 'Raz&oacuten social';
            $('#div_apellido').css({'display':'none'});
            $('#div_ci').css({'display':'none'});
            <?php
           }else{
            ?>
            var tipo = $('#cliente_tipo').val('1');
            $('#persona').removeClass('btn-secondary').addClass('btn-primary');
            $('#empresa').removeClass('btn-primary').addClass('btn-secondary');
            $("#cliente_ruc").prop('required',false);
            $("#cliente_cedula").prop('required',true);
            document.getElementById('lbl_nombre').innerHTML = 'Nombre';
            $('#div_apellido').css({'display':'block'});
            $('#div_ci').css({'display':'block'});
            <?php
           }
        ?>
        $('#empresa').click(function(){
             var tipo = $('#cliente_tipo').val('2');
            $('#empresa').removeClass('btn-secondary').addClass('btn-primary');
            $('#persona').removeClass('btn-primary').addClass('btn-secondary');
            $("#cliente_ruc").prop('required',true);
            $("#cliente_cedula").prop('required',false);
            $("#cliente_apellido").prop('required',false);
            document.getElementById('lbl_nombre').innerHTML = 'Raz&oacuten social';
            $('#div_apellido').css({'display':'none'});
            $('#div_ci').css({'display':'none'});
        });
        $('#persona').click(function(){
             var tipo = $('#cliente_tipo').val('1');
            $('#persona').removeClass('btn-secondary').addClass('btn-primary');
            $('#empresa').removeClass('btn-primary').addClass('btn-secondary');
            $("#cliente_ruc").prop('required',false);
            $("#cliente_cedula").prop('required',true);
            document.getElementById('lbl_nombre').innerHTML = 'Nombre';
            $('#div_apellido').css({'display':'block'});
            $('#div_ci').css({'display':'block'});
        });
        ////////////////////////////////////////////
        $('#btn_reg').click(function(event) {
            $('#registroform').validate({
                lang: 'es',
                messages: {
                    cliente_nombre: "Debe completar el campo nombre.",
                    cliente_apellido: "Debe completar el campo apellido.",
                    cliente_cedula: "Debe completar el campo C.I.",
                    cliente_telefono: "Debe completar el campo Telefono.",
                    cliente_email: "Debe completar el campo E-mail.",
                    cliente_clave: "Debe completar el campo Contraseña",
                    cliente_ruc: "Debe completar el campo R.U.C",
                    cliente_mapa:  "Marca el mapa",
                    sucursal:  "Seleccionar una opcion",
                    denominacion: "Debe completar el campo Denominacion",
                    direccion: "Debe completar el campo Direccion",
                },
                submitHandler: function(form){
                  $.blockUI({ message: '<h2 class="blockUI" style="padding:20px 20px 20px 20px;"> Aguarde un momento por favor...</h2>' });   
                  $('.error').html('');
                  $.ajax({
                    url : 'ajax/registro',
                    data: $('#registroform').serialize(),
                    type : 'post',
                    dataType : 'json',
                    success : function(data){
                        console.log(data);
                        if(data.status=="success"){
                          if(data.type != "update"){
                              $("input").not(":submit").val("");
                              $("textarea").val("");
                              
                              setTimeout(function(){ location.reload(); }, 2000);
                              $("#result").html('<div class="alert alert-success">Su solicitud de registro se ha realizado correctamente</div>');
                          }else{
                           // swal("Registro exitoso!", "Se ha registrado correctamente", "success");
                            $("#result").html('<div class="alert alert-success">Actualización correcta de sus datos</div>');
                          }
                         
                        }else{
                          if(data.description === 'autenticacion'){
                            //swal("¡Error!", data.description, "warning");
                            $("#result").html('<div class="alert alert-danger">'+data.description+'</div>');
                          }else{
                            $("#"+data.type).focus();
                            $("#"+data.type+"-error").html(data.description);

                            //swal("¡Error!", data.description, "warning"); 
                            $("#result").html('<div class="alert alert-danger">'+data.description+'</div>');
                          }
                        }
                        $.unblockUI();
                    }
                  });
                  return false;
                }
            });
        });


    });
$(function(){
        initmap();
        <?php if($direccion_id == 0){ ?>
        placeMarker();
        <?php  }   ?>
    });
</script>
  </body>
</html>