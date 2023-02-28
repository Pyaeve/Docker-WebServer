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
  <?php include("inc/head.php")?>   
  
</head>
<body class="bg-white">
<!-- header -->
<?php include_once('inc/header-v2.php');?>
<!-- /header -->
<!-- Breadcrumbs -->
<!-- breadcrumb -->
<section class="breadcrumb-section breadcrumb-catedral">
    <div class="container">
        <div class="row">
              <div class="col-md-6 col-lg-12 display-6 navi">
                <?php 
                    echo strlen($tree) > 0 ? '<ul class="subBotonera history">'.$tree.'</ul>' : '';
                ?>
             
            </div>
        </div>
    </div>
</section>
<!-- /breadcrumb End -->

<!-- /Breadcrumbs -->
  <!-- section product details -->
    <section class="productos-catedral">
    <div class="collection-wrapper">
        <div class="container">
           <?php 
                $imagenes = Imagenes_productos::get("producto_id = ".$producto['producto_id']);

                                        ?>
            <div class="row">

                <div class="col-lg-4 col-md-4">

                    <div class="product-slick">
 
                        <img class="img-fluid" src="<?=$imagenes[0]['imagen_image_big_url']?>" alt="<?=$producto['producto_nombre']?>"  title="<?=$producto['producto_nombre']?>" >
                      
                    </div>
                   
                </div>
                <div class="col-lg-5 col-md-5 rtl-text">
                    <div class="product-right">
                        <h2><?=strtolower($producto['producto_nombre'])?></h2>
                        <div class="ml-lg-3">
                            <p class="st-ec">C&oacute;digo: <?php echo $producto['producto_codigo'];?></p>
                        </div>
                        <?php
                        if($producto['producto_equivalencia']){
                        ?> 
                        <div class="ml-lg-3">
                            <i class="fa fa-barcode fa-xl"></i> <?php echo trim($producto['producto_equivalencia']);?>
                        </div>      
                        <?php } ?>
                        <h4><del><?=$antes?></del><!-- <span>55% off</span>--></h4>
                        <h3>Gs. <?=$actual?></h3>
                        
                        <div class="product-description border-product">
                            
                            <h6 class="product-title">Cantidad</h6>
                            <div class="qty-box">
                                <div class="input-group"><span class="input-group-prepend"><button type="button" class="btn quantity-left-minus" data-type="minus" data-field=""><i class="ti-angle-left"></i></button> </span>
                                    <input type="text" name="quantity" class="form-control input-number" value="1"> <span class="input-group-prepend"><button type="button" class="btn quantity-right-plus" data-type="plus" data-field=""><i class="ti-angle-right"></i></button></span></div>
                            </div>
                        </div>
                        <div class="product-buttons"><a href="javascript:;" class="btn btn-solid btnAddCart item_add" rel="<?=strtolower($producto['producto_id']) ?>"><i class="fa fa-shopping-cart"></i> Agregar</a></div>
                        <div class="border-product">
                            <h6 class="product-title">Descripci&oacute;n</h6>
                            <p><?=strtolower($producto['producto_descripcion'])?></p>
                        </div>
                        <div class="border-product">
                            <h6 class="product-title">Compartelo en Redes Sociales</h6>
                            <div class="product-icon">
                                <ul class="product-social">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                </ul>
                               
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                 <div class="fb-page" data-href="https://www.facebook.com/FarmaciaCatedralPy" data-tabs="timeline" data-width="" data-height="" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/FarmaciaCatedralPy" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/FarmaciaCatedralPy">Farmacia Catedral</a></blockquote></div>
                </div>
            </div>
            
        </div>
    </div>
    </section>
    <!-- Section ends -->




<?php 
    if($producto['categoria_id'] > 0):
        $relacionados = Productos::get("categoria_id = ".$producto['categoria_id']." AND producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 ","producto_id DESC LIMIT 16");
        if(haveRows($relacionados)):

?>   
  <!-- section productos relacionados --->
    <section class="slider-section section-productos-catedral no-border-product product-related">
        <div class="container">
            <div class="title-basic">
                <h1 >Productos relacionados</h1>
                        </div>
            <div class="row">
                <div class="col-xl-12 p-0 col-md-12 col-sm-12 col-xs-12">
                    <div class="slider-6 no-arrow">
                     <?php 
                       

                        foreach($relacionados as $relacion):
                             $img = Imagenes_productos::get("producto_id =".$relacion['producto_id'],"imagen_id DESC LIMIT 1");
                        $img = strlen($img[0]['imagen_image_big_url']) > 0 ? $img[0]['imagen_image_big_url'] : "images/sin-img.webp";
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
                         <div class="product-box bg-white col-sm-6 col-md-3 col-xs-6">
                            <a href="./producto/<?php echo $relacion['producto_slugit'] ?>" title="<?php echo $relacion['producto_marca'].' '.$relacion['producto_nombre'] ?>">
                                <div class="ribbon ribbon-top-right ">
                                    <span class="desc-<?=$promoClass?>"><?=substr($promoClass, 5)?>% OFF</span></div>
                                    <div class="img-block">
                                        <img src="<?=$img?>" class="img img-responsive img-fluid" alt="<?php echo $relacion['producto_marca'].' '.$relacion['producto_nombre']; ?>" title="<?php echo $relacion['producto_marca'].' '.$des['producto_nombre']; ?>"/>
                                                             
                                    </div>
                                </a>
                                <div class="product-info">
                                <a href="./producto/<?php echo $relacion['producto_slugit'];?>" title="<?php echo $relacion['producto_marca'].' '.$relacion['producto_nombre'];?>"><h6><?php echo $relacion['producto_nombre']?></h6></a>
                                <h5>Gs. <s><?php echo  $antes; ?>  
                                        </s></h5>
                                <h5 class="text-success">Gs. <?php echo $antes; ?></h5>

                                <div class="row text-center">

                                   <a href="javascript:;" class="btnAddCart btn btn-solid item_add" rel="<?php echo $relacion['producto_id']; ?>">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar
                                    </a>
                              
                                </div>
                                
                            </div>
                            
                                                        
                        </div>  
                    <?php endforeach; ?>
                    </div>
                </div>  
            </div>
        </div>
    </section>
    <!-- /productos relacionados -->

<?php 
        endif; 
    endif;

?>


<!-- PRODUCTOS GALERIA END -->
<?php require_once('inc/footer.php'); ?>
