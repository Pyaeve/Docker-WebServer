<?php
    require_once('inc/config.php');
    $producto_id = param('id');
    if(strlen($producto_id) > 0){
        $producto = Productos::get("producto_slugit = '{$producto_id}' AND producto_status = 1 AND producto_precio > 0 AND producto_stock > 0");

        if(!haveRows($producto)){
            header("Location:../productos");
            exit();
        }
    }else{
        header("Location:../productos");
        exit();
    }
    $producto = $producto[0];
    
    $parents = Categorias::tree($producto['categoria_id'] );
    
    //$ws = Ws_edicion($producto['producto_codigo'], $listProducto_url);
    //$wstock = ws_stock($producto['producto_codigo'], $disponibilidad);
    
    $cantidad = count($parents);
    $i= 1;
    foreach($parents as $category):
        $barra = $cantidad == $i ? "" : "<span> > </span>";
        $tree .= '<li><a href="productos/'.$category['categoria_slugit'].'"><p><b>'.$category['categoria_nombre'].'</b>'.$barra.'</p></a></li>';
        $i++;
    endforeach;
    $tree = substr($tree,0,-5);
    
    $ivahora = $producto['producto_precioIVA'] > 0 ? $producto['producto_precioIVA'] : 0;
    $ivates = $producto['producto_precioantesIVA'] > 0 ? $producto['producto_precioantesIVA'] : 0;
    $precioIVA = $producto['producto_precio'] + $ivahora;
    $precioantesIVA = $producto['producto_precioantes'] + $ivates;
    
    $antes = number_format($precioantesIVA,0,"",".");
    $actual = number_format($precioIVA,0,"","."); 

    $promoClass = "";
    if($producto['producto_descuento'] > 0 AND $producto['producto_mostrar'] == "S"){
         $promoClass = promo($producto['producto_descuento']);
    }
    
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es-ES"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="es-ES"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="es-ES"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es-ES"> <!--<![endif]-->
<head>
  <? include("inc/head.php")?>   
  <title>Catedral</title>

 
  <script src="js/thumbnail-slider.js" type="text/javascript"></script>
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">

  <!-- SLIDER -->
  <link href="css/ninja-slider.css" rel="stylesheet" />
  <script src="js/ninja-slider.js"></script>
  <link href="css/thumbnail-slider.css" rel="stylesheet" type="text/css" />
  <script src="js/thumbnail-slider.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css">
  
  <link rel="stylesheet" type="text/css" href="js/splidejs/splide.min.css">
  <style type="text/css">
        .item{border: 1px solid #d3d3d3; border-radius: 5px;padding: 0; margin-left: 20px;}
        .nj{
            float:left; margin-left: 50px !important;
        }
        .navi{
            padding: 15px 0 0 0;
        }
        ul.slides{
            padding-top:100% !important;
        }
        .cid-scEieb16NW{
            padding-top:0;
        }

        @media screen and (max-width: 768px) {
            .nj{
               margin-left: 0px !important;
            }
            .mainpr{
                left: -21px;
            }
            #ninja-slider {
                width: 100%
            }
        }
        
        .cid-scEieb16NW{ padding-top: 0; }

        .splide__arrow--prev, .splide__arrow--next{
            display: none;
        }
        
        .icono-promo { right: 12px }
         
        .alert-danger{
            font-size: 12px;
            background: #ff0000;
            padding: 5px !important;
        }
  </style>
</head>
<body>
<? 
   require_once('inc/header.php'); 
   require_once('inc/nav.php'); 
?>
<!-- PRODUCTOS GALERIA -->
<section class="content1 cid-scEieb16NW" id="content1-2y">
    <div class="row">
        <div class="" style=" width: 100%; background: #f3f3f3; padding-top: 0px;">
            <div class="col-md-6 col-lg-12 display-4 navi">
                <? 
                    echo strlen($tree) > 0 ? '<ul class="subBotonera history">'.$tree.'</ul>' : '';
                ?>
             
            </div>
        </div>

        <div class="" style=" width: 100%; padding: 0 60px;">
            <div class="row mt-4">
                <span class="promobig <?=$promoClass?> "></span>
                <div class="col-md-6 col-lg-6 text-white">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 d-none d-sm-none d-md-block">
                            <div id="thumbnail-slider" style="float:left; ">
                                <div class="inner">
                                    <ul>
                                        <? 
                                            $imagenes = Imagenes_productos::get("producto_id = ".$producto['producto_id']);
                                            #thumbs
                                            foreach ($imagenes as $imagen) {
                                                echo $thumb = $imagen['imagen_image_big_url'];
                                                echo '<li><a class="thumb" href="'.$thumb .'"></a></li>';
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-10 col-lg-10 mainpr">
                            <div id="ninja-slider" class="nj">
                                <div class="slider-inner">
                                    <ul class="slides">
                                        <?  #Big
                                            foreach ($imagenes as $imagen) {

                                                $big = $imagen['imagen_image_big_url'];
                                                echo '<li class="li-img">
                                                    <a href="'.$big.'" data-fancybox="images">
                                                        <img class="ns-img" src="'.$big.'">
                                                    </a>
                                                </li>';
                                            }
                                        ?>
                                    </ul>
                                    <!-- <div class="fs-icon" title="Expand/Close"></div> -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 col-lg-6 display-4">
                    <h4><?=$producto['producto_nombre']?></h4>
                    <h4><?=$producto['marca_nombre']?></h4>
                    
                    <p>Codigo: <?=$producto['producto_codigo']?></p>
                    <p><?=$producto['producto_descripcion']?></p>
                    <!-- <a href="javascript:;" class="item_add comprar" rel="5"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Comprar</a> -->
                    <!--<p>Cantidad: <?//=$producto['producto_stock']?></p>-->
                    <div class="pl-0 pr-0 row">
                         <? if( $producto['producto_nivel'] != "VENTA LIBRE" ){ ?>
                        <div class="col-lg-6 alert alert-danger" role="alert"> Venta bajo receta</div>
                        <div class="col-lg-6"></div>
                        <?  }?>
                        <div class="col-lg-6">
                            <? if($antes > 0){ ?>
                            <del class="prodPrecio right pt10">
                                Gs: <span style="font-size: 13px;"><?=$antes?></span>
                            </del>
                            <? } ?>
                            <p class="prodPrecio left pt10">
                                Gs: <span style="font-size: 23px;"><b><?=$actual?></b></span>
                            </p>
                        </div>
        
                        <div class="col-lg-6 text-center">
                            <?php
                            /*if($producto['producto_stock']>0):
                            ?>
                            <a href="javascript:;" class="btnAddCart item_add" rel="<?php echo $producto['producto_id']; ?>">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar
                            </a>
                            <?
                            else:
                                echo '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Sin Stock';
                            endif;*/
                            ?>
                        </div>
                        
                        <div class="col-lg-12 mt-3">
                                                      <?php
                            if($producto['producto_stock']>0):
                            ?>
                            <a href="javascript:;" class="btnAddCart item_add" rel="<?php echo $producto['producto_id']; ?>">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar
                            </a>
                            <?
                            endif;
                            ?>  
                        </div>
                    </div>
                </div>
            </div>
            <? $fichas = Productos_fichas::get("producto_id = ".$producto['producto_id']);
                if(haveRows($fichas)):  ?>
            <div class="col-md-12 col-lg-12 pt-5 display-4">
                <div class="bs-example">
                    <div class="accordion" id="accordion">
                        <? 
                            $f1 = 1;
                            foreach ($fichas as $list) {
                        ?>
                        <div class="card">
                            <div class="card-header mainficha" id="heading<?=$list['ficha_id']?>">
                                <h2 class="mb-0">
                                    <button type="button" class="btn btn-link ficha" data-toggle="collapse" data-target="#collapse<?=$list['ficha_id']?>">
                                        <?=strtoupper($list['ficha_nombre']);?>
                                    </button>                                  
                                </h2>
                            </div>
                            <div id="collapse<?=$list['ficha_id']?>" class="collapse show" aria-labelledby="heading<?=$list['ficha_id']?>" data-parent="#accordion">
                                <div class="card-body border-top-0">
                                    <p><?=utf8_encode($list["ficha_contenido"])?></p>
                                </div>
                            </div>
                        </div>
                        <?
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?
                endif;
            ?>
</section>
<?
if($producto['categoria_id'] > 0){
    $relacionados = Productos::get("categoria_id = ".$producto['categoria_id']." AND producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 ","producto_id DESC LIMIT 16");
    if(haveRows($relacionados)){
?>
        <div class="mbr-section-head mt-4">
            <h4 class="mbr-section-title mbr-fonts-style align-center mb-0 display-5"><strong>Producto relacionados</strong></h4>
        </div>
<div id="splide" class="splide d-none d-sm-none d-md-block" data-splide='{"type":"loop","perPage":4,"autoplay":"true"}'>
    <div class="splide__track">
        <ul class="splide__list">
            <?
                  
                  foreach ($relacionados as $relacion) {
                    $img = Imagenes_productos::get("producto_id =".$relacion['producto_id'],"imagen_id DESC LIMIT 1");
                    $img = strlen($img[0]['imagen_image_big_url']) > 0 ? $img[0]['imagen_image_big_url'] : "images/sin-img.jpg";
                    
                    $ivahora_r = $relacion['producto_precioIVA'] > 0 ? $relacion['producto_precioIVA'] : 0;
                    $ivates_r = $relacion['producto_precioantesIVA'] > 0 ? $relacion['producto_precioantesIVA'] : 0;
                    $precioIVA_r = $relacion['producto_precio'] + $ivahora_r;
                    $precioantesIVA_r = $relacion['producto_precioantes'] + $ivates_r;
                    
                    $antes_r = number_format($precioantesIVA_r,0,"",".");
                    $actual_r = number_format($precioIVA_r,0,"","."); 
                    
                    $promoClassrel = "";
                    if($relacion['producto_descuento'] > 0 AND $relacion['producto_mostrar'] == "S"){
                         $promoClassrel = promo($relacion['producto_descuento']);
                    }
            ?>
            <li class="splide__slide">
                <div style="padding: 10px 50px;">
                    <div class="item features-image сol-12 col-md-6 col-lg-12">
                        <div class="item-wrapper">
                            <div class="item-img">
                                <a href="producto/<?=$relacion['producto_slugit']?>">
                                    <span class="icono-promo <?=$promoClassrel?> ico-pr"></span>
                                    <img src="<?=$img?>" alt="<?=$relacion['producto_nombre']?>" title="<?=$relacion['producto_nombre']?>">
                                </a>
                            </div>
                            <div class="item-content title_product" style="padding: 0 15px;">

                                 <p class="mbr-text text-center mb-1 mbr-fonts-style title_producto maxmin">
                                    <a href="producto/<?=$relacion['producto_slugit']?>" style="color: #000;">
                                        <?=$relacion['producto_nombre']?>  
                                    </a>
                                </p>
                                
                                <div class="row" style="width: 100%; margin:0; ">
                                    <? 
                                        $col = $antes_r > 0 ? '6' : '12';
                                        if($antes_r > 0){
                                    ?>
                                    <div class="features-image сol-12 col-lg-6 p-0">

                                        <p class="w-100 text-left mbr-text mb-1 mbr-fonts-style title_producto">Antes</p>
                                        <del class="mbr-text text-center mb-1 mbr-fonts-style title_producto" style="font-size: 12px">Gs. <?=$antes_r?></del>
                                    </div>
                                    <?  }   ?>
                                    <div class="features-image сol-12 col-lg-<?=$col?> p-0">
                                        <p class="text-center mbr-text mb-1 mbr-fonts-style title_producto"><b>Ahora</b></p>

                                        <p class="mbr-text text-center mb-1 mbr-fonts-style title_producto" style="font-size: 17px;"><b>Gs: <?=$actual_r?></b></p>
                                    </div>
                                </div>

                                <p class="mbr-text text-center mt-3 mbr-fonts-style title_producto">
                                    <a href="javascript:;" class="btnAddCart item_add" rel="<?php echo $relacion['producto_id']; ?>">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar
                                    </a>
                                </p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </li>
            <?
                }
            ?>
        </ul>
    </div>
</div>

<div id="splide2" class="splide d-block d-sm-block d-md-none" data-splide='{"type":"loop","perPage":1,"autoplay":"true"}'>
    <div class="splide__track">
        <ul class="splide__list">
            <?
                  
                  foreach ($relacionados as $relacion) {
                    $img = Imagenes_productos::get("producto_id =".$relacion['producto_id'],"imagen_id DESC LIMIT 1");
                    $img = strlen($img[0]['imagen_image_big_url']) > 0 ? $img[0]['imagen_image_big_url'] : "images/sin-img.jpg";
                    
                    $ivahora_r = $relacion['producto_precioIVA'] > 0 ? $relacion['producto_precioIVA'] : 0;
                    $ivates_r = $relacion['producto_precioantesIVA'] > 0 ? $relacion['producto_precioantesIVA'] : 0;
                    $precioIVA_r = $relacion['producto_precio'] + $ivahora_r;
                    $precioantesIVA_r = $relacion['producto_precioantes'] + $ivates_r;
                    
                    $antes_r = number_format($precioantesIVA_r,0,"",".");
                    $actual_r = number_format($precioIVA_r,0,"","."); 
            ?>
            <li class="splide__slide">
                <div style="padding: 10px 50px;">
                    <div class="item features-image сol-12 col-md-6 col-lg-12">
                        <div class="item-wrapper">
                            <div class="item-img">
                                <a href="producto/<?=$relacion['producto_slugit']?>"><img src="<?=$img?>" alt="<?=$relacion['producto_nombre']?>" title="<?=$relacion['producto_nombre']?>"></a>
                            </div>
                            <div class="item-content title_product" style="padding: 0 15px;">

                                <p class="mbr-text text-center mb-1 mbr-fonts-style title_producto maxmin">
                                    <a href="producto/<?=$relacion['producto_slugit']?>" style="color: #000;">
                                        <?=$relacion['producto_nombre']?>  
                                    </a>
                                </p>
                                
                                <div class="row" style="width: 100%; margin:0; ">
                                    <div class="features-image сol-12 col-lg-6 p-0">
                                        <p class="w-100 text-left mbr-text mb-1 mbr-fonts-style title_producto">Antes</p>
                                        <del class="mbr-text text-center mb-1 mbr-fonts-style title_producto" style="font-size: 12px">Gs. <?=$antes_r?></del>
                                    </div>
                                    <div class="features-image сol-12 col-lg-6 p-0">
                                        <p class="text-center mbr-text mb-1 mbr-fonts-style title_producto"><b>Ahora</b></p>

                                        <p class="mbr-text text-center mb-1 mbr-fonts-style title_producto" style="font-size: 17px;"><b>Gs: <?=$actual_r?></b></p>
                                    </div>
                                </div>

                                <p class="mbr-text text-center mt-3 mbr-fonts-style title_producto">
                                    <a href="javascript:;" class="btnAddCart item_add" rel="<?php echo $relacion['producto_id']; ?>">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar
                                    </a>
                                </p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </li>
            <?
                }
            ?>
        </ul>
    </div>
</div>
<?
    }
}//categoria_id
?>
<!-- PRODUCTOS GALERIA END -->
<? require_once('inc/footer.php'); ?>
<script type="text/javascript" src="js/jquery.zoom.min.js"></script>
<script src="js/jquery.fancybox.js"></script>
<script src="js/splidejs/splide.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('ul.slides li').zoom();
    });
    
    new Splide( '#splide' ).mount();
    new Splide( '#splide2' ).mount();
</script>
  </body>


</html>