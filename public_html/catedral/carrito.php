<?php
    require_once('inc/config.php');
    if(!isset($_SESSION['cli_reg'])){
        #Si no existe session redirecciona
        header("Location:productos");
        exit();
    }

    $where = "";

    $categoria_url = param('id');
    if(strlen($categoria_url) > 0){
        $categorias = Categorias::get("categoria_slugit = '{$categoria_url}'");
        $categoria_id = $categorias[0]['categoria_id'];

        if($categoria_id > 0){
                $catParent = Categorias::catpag( $categoria_id);
                $listproduct = "";
                foreach ($catParent as $cp) {
                   $listproduct.= $cp['categoria_id'].',';
                }
                $listproduct = substr($listproduct,0,-1);

            $where.= " AND categoria_id IN (".$listproduct.")";

            $parents = Categorias::tree($categoria_id );
            foreach($parents as $category):
                $tree .= '<a href="productos/'.$category['categoria_slugit'].'">'.$category['categoria_nombre'].'</a> &gt; ';
                $newparent = $category['categoria_id'];
            endforeach;
            $tree = substr($tree,0,-5);
        }
    }
    /* En caso de utilizar buscador*/
    /*if(strlen(param('busca'))>0 ){
        $busca = param('busca');
        $where.= " AND producto_nombre LIKE '%{$busca}%'"; 
    }*/

    $productos = Productos::listing(9,pageNumber(),NULL,"producto_status = 1 ".$where);
?>
<!DOCTYPE html>
<html  >
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v5.1.4, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="assets/images/logo-farmacia-catedral-6-164x63.jpg" type="image/x-icon">
  <meta name="description" content="sesion">
  <base href="http://<?php echo $_SERVER['SERVER_NAME'].str_replace("index","",substr($_SERVER['SCRIPT_NAME'],0,-4));?>" />

  
  <title>Catedral</title>
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
  <link rel="stylesheet" href="assets/tether/tether.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <!-- <link rel="stylesheet" href="assets/animatecss/animate.css"> -->
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/socicon/css/styles.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css">
  <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
  <link rel="stylesheet" href="css/prog.css">
  <link rel="stylesheet" href="css/menu.css">

  <style type="text/css">
        .item{border: 1px solid #d3d3d3; border-radius: 5px;padding: 0; margin-left: 20px;}
        .cid-scEieb16NW{ padding-top: 0; }
  </style>
</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
<!-- PRODUCTOS GALERIA -->
<section class="content1 cid-scEieb16NW" id="content1-2y">


<div class="container">
    <div class="row">
            <div class="col-md-6 col-lg-3 mbr-text mbr-fonts-style mtb-3 display-7">
                <?php require_once('inc/menu.php'); ?>
            </div>

            <!-- Productos Galeria -->
            <div class="col-md-6 col-lg-9">
                 <div class="mbr-section-head">
                  <!--   <p class="mbr-section-title mbr-fonts-style align-center mb-0 display-5"><strong><strong><?=$tree?></strong></strong></p> -->
                    <h5 class="mbr-section-subtitle mbr-fonts-style align-center mb-0 mt-2 display-7 ">
                        <strong><? 
                                    $catParent = Categorias::catpag( $categoria_id);
                                    $listproduct = "";
                                    foreach ($catParent as $cp) {
                                       $listproduct.= $cp['categoria_id'].',';
                                    }
                                    $listproduct = substr($listproduct,0,-1);


                        ?></strong>
                    </h5>
                </div>
                <div class="row mt-4">
                    <?php
                        if(haveRows($productos['list'])){
                            foreach ($productos['list'] as $productoRs) {
                                $img = Imagenes_productos::get("producto_id =".$productoRs['producto_id'],"imagen_id DESC LIMIT 1");
   
                                $img = strlen($img[0]['imagen_image_big_url']) > 0 ? $img[0]['imagen_image_big_url'] : "images/sin-img.jpg";
                               ?>
                    <div class="item features-image сol-12 col-md-12 col-lg-12">
                        <div class="row">
                          <div class="item-img col-lg-3">
                              <div class="item-img">
                                <a href="producto/<?=$productoRs['producto_slugit']?>">
                                  <img src="<?=$img?>" style="width: 150px;" alt="<?=$productoRs['producto_nombre']?>" title="<?=$productoRs['producto_nombre']?>">
                                </a>
                              </div>
                          </div>
                          <div class="item-img col-lg-9">
                            <div class="item-content title_product">
                                <h5 class="item-title mbr-fonts-style display-7 text-center ">
                                    <strong><a href="producto/<?=$productoRs['producto_slugit']?>"><?=$productoRs['producto_nombre']?></strong></a>
                                </h5>
                                
                                <p class="mbr-text  mb-1 mbr-fonts-style title_producto">
                                    <a href="producto/<?=$productoRs['producto_slugit']?>" style="color: #000;"><?=$productoRs['producto_subtitulo']?></a>
                                </p>
                                <?
                                    echo $productoRs['producto_precio'] > 0 ? '<p class="mbr-text  mb-1 mbr-fonts-style title_producto"> Gs: '.number_format( $productoRs['producto_precio'],0,"",".").'</p>' : '';

                                ?>
                               
                            </div></div>
                        </div>
                     
                    </div>
                               <?
                            }
                        }else{
                            echo "No se han encontrado Productos";
                        }
                    ?>
                </div>   
            </div>
        </div><!-- row --->
    </div>
</div>
 
</section>

<!-- PRODUCTOS GALERIA END -->

<section class="footer1 cid-sczDlgHYFm" once="footers" id="footer1-2h">

    
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
                        <a href="https://www.facebook.com/FarmaciaCatedralPy/" target="_blank">
                            <span class="mbr-iconfont socicon socicon-facebook"></span>
                        </a>
                    </div>
                    <div class="soc-item">
                        <a href="https://www.facebook.com/FarmaciaCatedralPy/" target="_blank">
                            <span class="mbr-iconfont socicon socicon-twitter"></span>
                        </a>
                    </div>
                    <div class="soc-item">
                        <a href="https://www.facebook.com/FarmaciaCatedralPy/" target="_blank">
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
</section><section style="background-color: #fff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif; color:#aaa; font-size:12px; padding: 0; align-items: center; display: flex;"><a href="" style="flex: 1 1; height: 3rem; padding-left: 1rem;"></a><p style="flex: 0 0 auto; margin:0; padding-right:1rem;"><a href="" style="color:#aaa;"></a></p></section><script src="assets/web/assets/jquery/jquery.min.js"></script>  <script src="assets/popper/popper.min.js"></script>  <script src="assets/tether/tether.min.js"></script>  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/viewportchecker/jquery.viewportchecker.js"></script>  <script src="assets/playervimeo/vimeo_player.js"></script>  <script src="assets/dropdown/js/nav-dropdown.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>  <script src="assets/theme/js/script.js"></script>  
  
  
 <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i class="mbr-arrow-up-icon mbr-arrow-up-icon-cm cm-icon cm-icon-smallarrow-up"></i></a></div>
    <input name="animation" type="hidden">


  </body>


</html>