<?php
//equire_once('_sys/init.php');
include("inc/config.php");
 $id = param('id');
    if(!$id){ header("Location:index.php"); }
    $data = Noticias::get("noticia_slugit = '{$id}'");
     if(!haveRows($data)){
        header("Location:index.php");
        exit();
    }
    $data = $data[0];

?>
<!DOCTYPE html>
<html  >
<head>
<?php  include("inc/head.php")?> 
  <!-- Site made with Mobirise Website Builder v5.1.4, https://mobirise.com -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v5.1.4, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="assets/images/logo-farmacia-catedral-6-164x63.jpg" type="image/x-icon">
  <meta name="description" content="Alimentación Saludable">
  <base href="http://<?php echo $_SERVER['SERVER_NAME'].str_replace("index","",substr($_SERVER['SCRIPT_NAME'],0,-4));?>" />

  
  <title><?php echo $noticia['noticia_titulo']; ?></title>
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
  <link rel="stylesheet" href="assets/tether/tether.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="assets/animatecss/animate.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/socicon/css/styles.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css"><link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
  <link rel="stylesheet" href="css/prog.css">
</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 

<section class="content6 cid-scEFz69Nxc" id="content6-3n" style="">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12">
                <hr class="line">
                <p class="align-center mbr-fonts-style mt-4 mb-0 display-5"><strong><?php echo $data['noticia_titulo'];?>
                    <br><?php echo $data['noticia_descripcionbreve']; ?></strong><br></p>
                <hr class="line">
            </div>
        </div>
    </div>
</section>

<section class="content5" id="content5-3o">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12 ">
                <?php
                    $contenido = str_replace('<p>', '<p class="mbr-fonts-style display-7">', $data['noticia_descripcion']);
                    $contenido = str_replace('<h1>', '<h1 class="mbr-section-subtitle mbr-fonts-style mb-4 display-5">', $contenido);
                    $contenido = str_replace('<h2>', '<h2 class="mbr-section-subtitle mbr-fonts-style mb-4 display-5">', $contenido);
                    $contenido = str_replace('<h3>', '<h3 class="mbr-section-subtitle mbr-fonts-style mb-4 display-5">', $contenido);
                    $contenido = str_replace('<ul>','<ul class="mbr-fonts-style display-7">', $contenido);

                    echo $contenido;
                ?>

            </div>
        </div>
    </div>
</section>

<section class="footer1 cid-sczDlgHYFm" once="footers" id="footer1-3m">

    
    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(35, 35, 35);"></div>
    <div class="container">
        <div class="row mbr-white">
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="mbr-section-subtitle mbr-fonts-style mb-2 display-7"><strong>INSTITUCIONAL
</strong></h5>
                <ul class="list mbr-fonts-style display-4">
                    <li class="mbr-text item-wrap"><strong><a href="nuestra_empresa" class="text-white">Nuestra empresa</a> 
</strong></li><li class="mbr-text item-wrap"><strong><a href="mision_y_vision" class="text-white">Misión y Visión</a>
</strong></li><li class="mbr-text item-wrap"><strong><a href="politica_de_calidad" class="text-white">Política de calidad</a>
</strong></li><li class="mbr-text item-wrap"><strong><a href="trabaja_con_nosotro" class="text-white">Trabaja con nosotros</a> 
</strong></li><li class="mbr-text item-wrap"><strong><a href="certificadoISO" class="text-white">Certificado Iso</a>
</strong></li><li class="mbr-text item-wrap"><br></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="mbr-section-subtitle mbr-fonts-style mb-2 display-7"><strong>SERVICIOS 
</strong></h5>
                <ul class="list mbr-fonts-style display-4">

                    <li class="mbr-text item-wrap"><strong><a href="preparados_magistrales" class="text-white">Preparados Magistrales</a>
</strong></li><li class="mbr-text item-wrap"><strong>Beneficios.
</strong></li><li class="mbr-text item-wrap"><strong>Buscador de medicamentos.
</strong></li><li class="mbr-text item-wrap"><strong>Medio de pago.
</strong></li><li class="mbr-text item-wrap"><br></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="mbr-section-subtitle mbr-fonts-style mb-2 display-7"><strong>COMPRAS ONLINE
</strong></h5>
                <ul class="list mbr-fonts-style display-4">
                    <li class="mbr-text item-wrap"><strong><a href="sesion" class="text-white">Mi cuenta</a>
</strong></li><li class="mbr-text item-wrap"><strong><a href="page4" class="text-white"></a><a href="carrito" class="text-white">Mi </a><b><a href="carrito" class="text-white">carrito</a></b>
</strong></li><li class="mbr-text item-wrap"><strong><a href="comosecompra" class="text-white text-primary">Como se compra</a>
</strong></li><li class="mbr-text item-wrap"><strong><a href="repetirpedido" class="text-white text-primary">Repetir pedido.</a>
</strong></li><li class="mbr-text item-wrap"><br></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="mbr-section-subtitle mbr-fonts-style mb-2 display-7"><strong>ATENCION AL CLIENTE
</strong></h5>
                <p class="mbr-text mbr-fonts-style mb-4 display-4"><strong><a href="contacto" class="text-white text-primary">Contacto</a>
<br>términos y condiciones&nbsp;&nbsp;</strong><br></p>
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
</section><section style="background-color: #fff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif; color:#aaa; font-size:12px; padding: 0; align-items: center; display: flex;"><a href="https://mobirise.site/o" style="flex: 1 1; height: 3rem; padding-left: 1rem;"></a><p style="flex: 0 0 auto; margin:0; padding-right:1rem;">Mobirise page maker - <a href="https://mobirise.site/n" style="color:#aaa;">Visit site</a></p></section><script src="assets/web/assets/jquery/jquery.min.js"></script>  <script src="assets/popper/popper.min.js"></script>  <script src="assets/tether/tether.min.js"></script>  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/viewportchecker/jquery.viewportchecker.js"></script>  <script src="assets/dropdown/js/nav-dropdown.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>  <script src="assets/theme/js/script.js"></script>  
  
  
 <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i class="mbr-arrow-up-icon mbr-arrow-up-icon-cm cm-icon cm-icon-smallarrow-up"></i></a></div>
    <input name="animation" type="hidden">
  </body>
</html>