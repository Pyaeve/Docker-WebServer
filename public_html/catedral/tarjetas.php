<?php
    require_once('inc/config.php');
    
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

    //echo "<script>console.log('hola ".$cliente_id."');</script>";


 
?>
<!DOCTYPE html>
<html  >
<head>
  <?php include("inc/head.php"); ?> 
    
  <title>Tarjetas</title>
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
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
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
  
<section class="form7 cid-scEm75XVYS" id="form7-34" style="">  
    <div class="container">
    <?php
        $user_id = $cliente_id;
        $token = md5($private_key . $user_id . "request_user_cards");
        $data = array(
            "public_key" => $public_key,
            "operation"	 => array(
                "token"	 => $token
            ),
        );
        $session = curl_init($usercard_url.$user_id."/cards");
        #--------------------------------------------------------------
        curl_setopt($session, CURLOPT_POST, 1);
        curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($session, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $session_response = curl_exec($session);
        
        curl_close($session);
        $response = json_decode($session_response);
        #--------------------------------------------------------------
        if($response->status == "success"){
            //print_r($response->cards[0]->card_brand);//[0]
            if($response->cards){
                ?> 
                <div class="container">
                    <h3 class="mbr-section-title mbr-fonts-style align-center mb-2 display-7 text-center border-bottom"><strong>TARJETAS</strong></h3>
                    
                    <?php foreach ($response->cards as $cards) { 

                        $alias_token        = $cards->alias_token;
                        $card_masked_number = $cards->card_masked_number;
                        $expiration_date    = $cards->expiration_date;
                        $card_brand         = $cards->card_brand;
                        $card_id            = $cards->card_id;
                        $card_type          = $cards->card_type;
                        $cartName           = $cards->card_type == "credit" ? "CR&EacuteDITO" : "D&EacuteBITO";
                        $whr                .= $cards->card_id.",";
                    ?>
                    
                        <div class="row">
                            <div class="col-lg-1">
                                <span class="fa-solid fa-credit-card" style="color: #0f3b84;font-size: xxx-large;"></span>
                                <!--<span class="mobi-mbri-credit-card" style="color: #0f3b84;font-size: xxx-large;"></span>-->
                            </div>
                            <div class="col-lg-4">
                                <p style="color: #0f3b84;"><strong><?php echo $cartName; ?></strong></p>
                                <p><?php echo $card_brand; ?></p>
                                <p><?php echo $card_masked_number." "."-"." ".$expiration_date; ?></p> 
                            </div>
                            <div class="col-lg-1" style="padding-top:2%;"> 
                                <!--<a class="mobi-mbri-trash" style="color: #0f3b84;font-size: xx-large;" onClick="DeleteCard()"></a>-->
                                <a class="fa-solid fa-trash-can" style="color: #0f3b84;font-size: xx-large;" onClick="DeleteCard(<?php echo $user_id; ?>,<?php echo $card_id; ?>, '<?php echo $card_brand; ?>','<?php echo $alias_token; ?>')"></a>
                            </div>
                        </div>
                    <?php 
                        }
                        $whr = substr($whr, 0, -1); 
                        $upd = Mysql::exec("UPDATE clientes_tarjetas SET cliente_tarjeta_hidden = 1, cliente_tarjeta_status = 0 WHERE cliente_id = $user_id AND tarjeta_id NOT IN ($whr)");
                        //echo "<script>console.log('t: $whr')</script>";
                    
                    ?>
                        <div class="row">
                            <div class="col-auto mbr-section-btn align-initial">
                                <a class="btn btn-primary display-4" onClick="AddCard(<?php echo $user_id; ?>,'<?php echo $email; ?>','<?php echo $tel; ?>')">Agregar</a>
                            </div>
                        </div>

                </div>
                <?php
            }else{
                ?>
                
                <div class="col-auto mbr-section-btn align-center">
                    <h4>Sin tarjetas catastradas.</h4>
                </div>
                <div class="col-auto mbr-section-btn align-initial">
                    <a class="btn btn-primary display-4" onClick="AddCard(<?php echo $user_id; ?>,'<?php echo $email; ?>','<?php echo $tel; ?>')">Agregar</a>
                </div>

                <?php
            }

        }else{
            ?>
            
            <div class="col-auto mbr-section-btn align-center">
                <h4 style="color:red;">Error al obtener tarjetas.</h4>
            </div>
            
            <?php
        }
        
    ?>

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
    
    window.onload = function () {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const status = urlParams.get('status');
        console.log("status "+status);
        if(status == "add_new_card_fail"){
            //window.location.replace = "tarjetas/";
            //alert("Bancard rechazó el registro de la tarjeta.");
            swal("Atencion", "Bancard rechazó el registro de la tarjeta.", "warning");
            //window.location.href = "tarjetas";
        }
    };
    
    function DeleteCard(user,card,card_brand,token) {
        /*console.log('card:'+card);
        console.log('user:'+user);
        console.log('token:'+token);*/
        console.clear(); 
        //var result = confirm("¿Desea eliminar la tarjeta "+card_brand+"?");
        swal({
            title: 'Eliminar tarjeta',
            text: '¿Desea eliminar la tarjeta '+card_brand+'?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff7f24',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url:"tarjetas_acciones.php", //the page containing php script
                type: "post", //request type,
                dataType: 'json',
                data: {tarjeta_id: card, user_id: user, card_token: token, accion: 'delete', email: 0, telefono: 0},
                success:function(result){
                        if(result.status == "success"){
                            swal({
                                position: 'warning',
                                icon: 'success',
                                title: 'Tarjeta eliminada.',
                                showConfirmButton: false,
                                timer: 1800
                            });
                            location.reload();
                            setTimeout(function(){ location.reload(); }, 2000);
                            /*$("#result").html('<div class="alert alert-success">Su solicitud de registro se ha realizado correctamente</div>');*/
                        }
                    }
                })
            }
        });
        /*if (result == true) {
            $.ajax({
                url:"tarjetas_acciones.php", //the page containing php script
                type: "post", //request type,
                dataType: 'json',
                data: {tarjeta_id: card, user_id: user, card_token: token, accion: 'delete', email: 0, telefono: 0},
                success:function(result){
                    //$('#cliente_apellido').val($.trim(result.apellidos));
                    //$('#cliente_nombre').val($.trim(result.nombres));
                    console.log("status:"+result.status);
                    if(result.status == "success"){
                        
                        location.reload();*/
                        /*setTimeout(function(){ location.reload(); }, 2000);
                        $("#result").html('<div class="alert alert-success">Su solicitud de registro se ha realizado correctamente</div>');*/
                   /* }
                }
            });
        } else {
            return false;
        }*/
        
    }
    function AddCard(user,email,telefono) {
        console.clear(); 
        
        
            $.ajax({
                url:"tarjetas_acciones.php", //the page containing php script
                type: "post", //request type,
                dataType: 'json',
                data: {tarjeta_id: 0, user_id: user, card_token: 0, accion: 'insert', email: email, telefono: telefono},
                success:function(result){
                    //$('#cliente_apellido').val($.trim(result.apellidos));
                    //$('#cliente_nombre').val($.trim(result.nombres));
                    
                    if(result.status == "success"){
                       
                        console.log("status:"+result.status);
                        console.log("process_id:"+result.process_id);
                        window.location.href = 'catastro?process_id='+result.process_id;
                        //location.reload();
                        //setTimeout(function(){ location.reload(); }, 2000);
                        //$("#result").html('<div class="alert alert-success">Su solicitud de registro se ha realizado correctamente</div>');
                    }else{
                        console.log("status:"+result.status);
                        console.log("mensaje:"+result.mensaje);
                    }
                }
            });
        
    }
    
</script>
  </body>
</html>