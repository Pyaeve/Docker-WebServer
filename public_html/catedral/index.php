<?php 
    include("inc/config.php");
?>
<!DOCTYPE html>
<html lang="es-ES" >
<head>
  <?php  include("inc/head.php")?>  
</head>
<body class="bg-white">

<?php include_once('inc/header-v2.php'); ?>
<!-- header part end -->
<!-- home slider section start-->
<section class="full-slider">
  
    <div class="slide-1 home-slider slider-catedral">
        <?php 
                    $banners = Banners::get("","banner_orden ASC");
                    $activeb = 1;
            foreach($banners as $banner): 
           $active = $activeb == 1 ? "active" : " ";
            $url = strlen($banner["banner_href"]) > 1 ? $banner["banner_href"] : "";
            ?> 
            <div>
                <img src="<?=$banner['banner_image_big_url']?>" class="img img-responsive img-fluid d-lg-block center-cropped" alt="">
            </div>
            <?php 
            $activeb++;
            endforeach; 
            ?>
        
    </div>
</section>
<!-- home slider section end-->


<!--MODAL-->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
         <div class="modal-content" style="margin-top:20%;background-image: url(images/popup_index.jpeg);background-size: contain;background-repeat: no-repeat;height: 100%;width: 100%;background-color: inherit;">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
    </div>
</div>
<a class="btn" id="openmodal" data-toggle="modal" href="#myModal" style="display:none;">Launch Modal</a>



<!-- descuento section start -->
<section class="category">
    <div class="container" align="center">
       <div class="titulo-catedral" align="center">
         <h2 class="text-center">Descuentos Exclusivos!</h2>
       </div>
    </div>
    <div class="container">
        <div class="slider-7 no-arrow">
            <?php   $descuentos = Productos::get2("DISTINCT(`producto_descuento`)","producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 AND producto_mostrar = 'S' AND producto_descuento <= 50 AND producto_descuento > 0","producto_descuento DESC");

            if(haveRows($descuentos)): 
                foreach($descuentos as $descuento): ?>
        
            <div class="col-md-3 col-sm-6 col-xm-6 ">
               
             
                    <a href="./productos/descuento/<?= $descuento['producto_descuento']?> " title="Descuentos reales del <?=$descuento['producto_descuento']?>% off en farmacia y perfumeria catedral">
                    
                        <img src="./images/<?=  $descuento["producto_descuento"]?>.webp" alt="Descuentos reales del <?= $descuento['producto_descuento']?> % off en farmacia y perfumeria catedral" class="img-fluid">
                    
                </a>
               
            </div>
           
            <?php endforeach; ?>

        <?php endif; ?>
        </div>
    </div>
</section>
<!-- descuentos section end -->



    <!--MEJORES PRODUCTOS-->
    <?php 
        $destacados = Productos::get("producto_mejores = 1","rand() LIMIT 6");
        if(haveRows($destacados)){
    ?>
        <!-- section products --->
    <section class="slider-section section-productos-catedral no-border-product">
        <div class="container">
            <div class="titulo-catedral">
                <h2 align="center">Los Mejores Productos para Vos!</h2>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-xm-6 col-sm-6 p-0 ratio_asos">
                    <div class="slider-6 no-arrow items">
                    <?php  foreach ($destacados as $des){
                            //$ws = Ws_edicion($des['producto_codigo'], $listProducto_url);
                            $imgDes = Imagenes_productos::get("producto_id =".$des['producto_id'],"imagen_id DESC LIMIT 1");
                            $imgDes = strlen($imgDes[0]['imagen_image_big_url']) > 0 ? $imgDes[0]['imagen_image_big_url'] : "images/sin-img.webp";
                            $ivahora = $des['producto_precioIVA'] > 0 ? $des['producto_precioIVA'] : 0;
                            $ivates = $des['producto_precioantesIVA'] > 0 ? $des['producto_precioantesIVA'] : 0;
                            $precioIVA = $des['producto_precio'] + $ivahora;
                            $precioantesIVA = $des['producto_precioantes'] + $ivates;
                            $antes = number_format($precioantesIVA,0,"",".");
                            $actual = number_format($precioIVA,0,"",".");
                            $promoClass = "";
                            if($des['producto_descuento'] > 0 AND $des['producto_mostrar'] === "S"){
                             $promoClass = promo($des['producto_descuento']);
                            }
                            
                           ?>
                         <div class="product-box bg-white">
                            <a href="./producto/<?php echo $des['producto_slugit'] ?>" title="<?php echo $des['producto_marca'].' '.$des['producto_nombre'] ?>">
                                <div class="ribbon ribbon-top-right desc-<?=$promoClass?>">
                                    <span class="desc-<?=$promoClass?>"><?=substr($promoClass, 5)?>% OFF</span></div>
                                    <div class="img-block">
                                        <img src="<?=$imgDes?>" class="producto-img-<?=$des['producto_id']?> img-responsive img-fluid" alt="<?php echo $des['producto_marca'].' '.$des['producto_nombre']; ?>" title="<?php echo $des['producto_marca'].' '.$des['producto_nombre']; ?>">
                                                             
                                    </div>
                                </a>
                                <div class="product-info">
                                <a href="./producto/<?php echo $des['producto_slugit'];?>" title="<?php echo $des['producto_marca'].' '.$des['producto_nombre'];?>"><h6><?php echo $des['producto_nombre']?></h6></a>
                                <h5>Gs. <s><?php echo  $antes; ?>  
                                        </s></h5>
                                <h5 class="text-success">Gs. <?php echo $antes; ?></h5>

                                <div class="row text-center">

                                   <a href="javascript:;" class="btnAddCart btn btn-solid btn-success item_add" rel="<?php echo $des['producto_id']; ?>">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar
                                    </a>
                              
                                </div>
                                
                            </div>
                            
                                                        
                        </div>  
                                        
                                 <?php
                                    }
                                    
                                
                            ?>
                        </div>
                </div>  
            </div>
        </div>
    </section>
    <?php
        }
    ?>

<!-- marcas  -->
<section class="no-border no-arrow section-productos-catedral">
    <div class="container " align="center">
        <div class="titulo-catedral text-center" align="center">
            <h2 class="center" >Las Mejores Marcas!</h2>
         </div>
        
        <div class="slide-6 col-md-12" style="background:#f1f2f2; border-radius: 20px;">
                
                <div class="logo-img col-3">
                    <a href="productos?buscaM=dove">
                        <img src="assets/images/marcas/dove.png" class="img-fluid" width="180px" alt="Comprar Dove en Farmacias y Perfumeria Catedral">
                    </a>
                </div>
            
                <div class="logo-img col-3">
                      <a href="productos?buscaM=dior">
                    <img src="assets/images/marcas/dior.png" width="180px" class="flash img  img-fluid" alt="Comprar Colgate en Farmacias y Perfumeria">
                     </a>
                                     </div>
                <div class="logo-img col-3">
                     <a href="productos?buscaM=clear">
                    <img src="assets/images/marcas/clear.png" class="img-fluid" width="180px" alt="Comprar Dove en Farmacias y Perfumeria Catedral">
                </a>
                </div>
            
                <div class="logo-img col-3">
                       <a href="productos?buscaM=colgate">
                    <img src="assets/images/marcas/colgate.png" width="180px" class="flash img img-fluid" alt="Comprar Colgate en Farmacias y Perfumeria">
                </a>
                </div>
                <div class="logo-img col-3">
                       <a href="productos?buscaM=babesec">
                    <img src="assets/images/marcas/babesec.png" class="img-fluid" width="180px" alt="Comprar Dove en Farmacias y Perfumeria Catedral">
                      </a>
                </div>
            
                <div class="logo-img col-3">
                    <img src="assets/images/marcas/huggie.png" width="180px" class="img-fluid" alt="Comprar Colgate en Farmacias y Perfumeria">
                </div>
                <div class="logo-img col-3">
                    <img src="assets/images/marcas/nosotras.png" class="img-fluid" width="180px" alt="Comprar Dove en Farmacias y Perfumeria Catedral">
                </div>
            
                <div class="logo-img col-3">
                    <img src="assets/images/marcas/algabo.png" width="180px" class="img-fluid" alt="Comprar Colgate en Farmacias y Perfumeria">
                </div>
              
             
           

           
        </div>
    </div>
</section>
<!-- /marcas  -->


   

  <!--recomendadosa PRODUCTOS-->
    <?php 
        $recomendados = Productos::get("producto_recomendado = 1","rand() LIMIT 6");
        if(haveRows($recomendados)){
    ?>
        <!-- section products --->
    <section class="slider-section section-productos-catedral no-border-product">
        <div class="container">
            <div class="titulo-catedral">
                <h2 align="center"> Productos Recomendados de Semana!</h2>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-xm-6 col-sm-6 p-0 ratio_asos">
                    <div class="slider-6 no-arrow items">
                    <?php  foreach ($recomendados as $des){
                            //$ws = Ws_edicion($des['producto_codigo'], $listProducto_url);
                            $imgDes = Imagenes_productos::get("producto_id =".$des['producto_id'],"imagen_id DESC LIMIT 1");
                            $imgDes = strlen($imgDes[0]['imagen_image_big_url']) > 0 ? $imgDes[0]['imagen_image_big_url'] : "images/sin-img.webp";
                            $ivahora = $des['producto_precioIVA'] > 0 ? $des['producto_precioIVA'] : 0;
                            $ivates = $des['producto_precioantesIVA'] > 0 ? $des['producto_precioantesIVA'] : 0;
                            $precioIVA = $des['producto_precio'] + $ivahora;
                            $precioantesIVA = $des['producto_precioantes'] + $ivates;
                            $antes = number_format($precioantesIVA,0,"",".");
                            $actual = number_format($precioIVA,0,"",".");
                            $promoClass = "";
                            if($des['producto_descuento'] > 0 AND $des['producto_mostrar'] === "S"){
                             $promoClass = promo($des['producto_descuento']);
                            }
                            
                           ?>
                         <div class="product-box bg-white">
                            <a href="./producto/<?php echo $des['producto_slugit'] ?>" title="<?php echo $des['producto_marca'].' '.$des['producto_nombre'] ?>">
                                <div class="ribbon ribbon-top-right desc-<?=$promoClass?>">
                                    <span class="desc-<?=$promoClass?>"><?=substr($promoClass, 5)?>% OFF</span></div>
                                    <div class="img-block">
                                        <img src="<?=$imgDes?>" class="producto-img-<?=$des['producto_id']?>img-responsive img-fluid " alt="<?php echo $des['producto_marca'].' '.$des['producto_nombre']; ?>" title="<?php echo $des['producto_marca'].' '.$des['producto_nombre']; ?>">
                                                             
                                    </div>
                                </a>
                                <div class="product-info">
                                <a href="./producto/<?php echo $des['producto_slugit'];?>" title="<?php echo $des['producto_marca'].' '.$des['producto_nombre'];?>"><h6><?php echo $des['producto_nombre']?></h6></a>
                                <h5>Gs. <s><?php echo  $antes; ?>  
                                        </s></h5>
                                <h5 class="text-success">Gs. <?php echo $antes; ?></h5>

                                <div class="row text-center">

                                   <a href="javascript:;" class="btnAddCart btn btn-solid btn-success item_add" rel="<?php echo $des['producto_id']; ?>">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar
                                    </a>
                              
                                </div>
                                
                            </div>
                            
                                                        
                        </div>  
                                        
                                 <?php
                                    }
                                    
                                
                            ?>
                        </div>
                </div>  
            </div>
        </div>
    </section>
    <?php
        }
    ?>


 



<?php 
    //mínimo de compra
    $parametro = Parametros::select(4);
    $popup = $parametro[0]['para_valor_numerico'];
?>



<?php
   include("inc/footer-v2.php");
?>

  
