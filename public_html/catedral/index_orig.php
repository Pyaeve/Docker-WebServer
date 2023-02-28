<?php
    include("inc/config.php");
?>
<!DOCTYPE html>
<html  >
<head>
  <? include("inc/head.php")?>  
  <title>Catedral</title>
    <!-- Owl Stylesheets -->
   <link rel="stylesheet" href="assets/owlcarousel/assets/owl.carousel.min.css">
   <link rel="stylesheet" href="assets/owlcarousel/assets/owl.theme.default.min.css">
    
    <link href="js/lightbox/lightbox.min.css" rel="stylesheet" />
    <style>
        .cid-scEavRZm1L{ padding:0;}
        .owl-dots button:focus {
            outline:0px auto -webkit-focus-ring-color;
        }
        .ico-pr { right: 12px }
    </style>
</head>
<body>
  <? require_once('inc/header.php'); ?>
  <? require_once('inc/nav.php'); ?>
<!--BANNERS MAIN-->
    <section class="slider2 cid-scEavRZm1L" id="slider2-2s">
    <?	
    	$banners = Banners::get();
    	$cant = count($banners);
    ?>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-12">
                <div class="carousel slide carousel-slide" id="scK9SxnGif" data-ride="carousel" data-interval="5000">
                    
                    <ol class="carousel-indicators">
                    	<?
                    		for ($i=0; $i < $cant; $i++) {
                    			$active1 = $i == 0 ? 'class="active"' : '';
                    			echo '<li data-slide-to="'.$i.'" '.$active1.' data-target="#scK9SxnGif"></li>';
                    		}
                    	?>
                    </ol>
                    <div class="carousel-inner">
                    	<?
                    		$banners = Banners::get();
                    		$activeb = 1;
                    		foreach ($banners as $banner) {
                    			$active = $activeb == 1 ? "active" : " ";
                    			echo '<div class="carousel-item slider-image item '.$active.'">
			                            <div class="item-wrapper">
			                                <img class="d-block w-100" src="'.$banner["banner_image_big_url"].'" alt="">
			                            </div>
			                        </div>';
                    			$activeb++;
                    		}
                    	?>
                    </div>
                </div>
            </div>
        </div>
</section>


<!--DESCUENTOS-->
<section class="clients1 cid-scK991gVCa" id="clients1-4v">
    
    <div class="images-container container-fluid">
        <div class="mbr-section-head">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-5 mt-4 text-center"><strong>Descuentos</strong></h3>
        </div>
        <div id="store" class="marcas owl-carousel owl-theme row justify-content-center mt-4" >
            <div class="col-md-10"><a href="productos/descuento/10"><img src="images/10.png" alt=""></a></div>
            <div class="col-md-10"><a href="productos/descuento/15"><img src="images/15.png" alt=""></a></div>
            <div class="col-md-10"><a href="productos/descuento/20"><img src="images/20.png" alt=""></a></div>
            <div class="col-md-10"><a href="productos/descuento/24"><img src="images/24.png" alt=""></a></div>
            <div class="col-md-10"><a href="productos/descuento/25"><img src="images/25.png" alt=""></a></div>
            <div class="col-md-10"><a href="productos/descuento/30"><img src="images/30.png" alt=""></a></div>
            <div class="col-md-10"><a href="productos/descuento/35"><img src="images/35.png" alt=""></a></div>
            <div class="col-md-10"><a href="productos/descuento/40"><img src="images/40.png" alt=""></a></div>
            
            <div class="col-md-10"><a href="productos/descuento/45"><img src="images/45.png" alt=""></a></div>
            <div class="col-md-10"><a href="productos/descuento/50"><img src="images/50.png" alt=""></a></div>


        </div>
    </div>
</section>
<!--MEJORES PRODUCTOS-->
    <?
        $destacados = Productos::get("producto_mejores = 1","rand() LIMIT 5");
        if(haveRows($destacados)):
    ?>
        <section class="gallery5 mbr-gallery pdestacado" id="gallery5-4t">
        <div class="container">
            <div class="mbr-section-head">
                 <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-5 mt-4 text-center"><strong>Los Mejores Productos para vos!</strong></h3>
            </div>
    
            <div class="row mt-4 mb-4">
                            <?php
                                    foreach ($destacados as $des):
                                        $ws = Ws_edicion($des['producto_codigo'], $listProducto_url);
                                        $imgDes = Imagenes_productos::get("producto_id =".$des['producto_id'],"imagen_id DESC LIMIT 1");
                                        $imgDes = strlen($imgDes[0]['imagen_image_big_url']) > 0 ? $imgDes[0]['imagen_image_big_url'] : "images/sin-img.jpg";

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
                            <div class="item itemgal features-image сol-12 col-md-6 col-lg-2 p-0" style="border: solid 1px #183883; border-radius: 7px;">
                                <div class="item-wrapper" style="padding: 15px 5px;">
                                    <div class="item-img">
                                        <a href="producto/<?=$des['producto_slugit']?>">
                                            <span class="icono-promo <?=$promoClass?> ico-pr"></span>
                                            <img src="<?=$imgDes?>" alt="<?=$des['producto_nombre']?>" title="<?=$des['producto_nombre']?>">
                                        </a>
                                    </div>
                                    <div class="item-content title_product">
                                         <p class="mbr-text mb-0 text-left mbr-fonts-style title_producto">
                                            <a href="producto/<?=$des['producto_slugit']?>" style="color: #000;"><b><?=$des['marca_nombre']?></b></a>
                                        </p>
                                        <p class="mbr-text text-center mb-1 mbr-fonts-style title_producto maxmin">
                                            <a href="producto/<?=$des['producto_slugit']?>" style="color: #000;"><?=$des['producto_nombre']?></a>
                                        </p>
                                     
                                        <div class="row" style="width: 100%; margin:0; ">
                                            <? 
                                                $col = $antes > 0 ? '6' : '12';
                                                if($antes > 0){
                                            ?>
                                            <div class="features-image prodprice сol-6 col-lg-6 p-0">
    
                                                <p class="w-100 text-center mbr-text mb-1 mbr-fonts-style title_producto">Antes</p>
                                                <p class="w-100 text-center mbr-text mb-1 mbr-fonts-style title_producto">
                                                    <del class="mbr-text text-center mb-1 mbr-fonts-style title_producto" >Gs. <?=$antes?></del></p>
                                            </div>
                                            <? }   ?>
                                            <div class="features-image prodprice сol-6 col-lg-<?=$col?> p-0">
                                                <p class="text-center mbr-text mb-1 mbr-fonts-style title_producto"><b>Ahora</b></p>
                                                <p class="mbr-text text-center mb-1 mbr-fonts-style title_producto" style="font-size: 15px;"><b>Gs: <?=$actual?></b></p>
                                            </div>
                                        </div>
                                        <p class="mbr-text text-center mt-3 mbr-fonts-style title_producto">
                                            <a href="javascript:;" class="btnAddCart item_add" rel="<?php echo $des['producto_id']; ?>">
                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                                        
                                 <?
                                    endforeach;
                                    
                                
                            ?>
            </div>    
    
        </div>
    </section>
    <?
        endif;
    ?>

<!--BOTONERAS-->
    <section class="content12 cid-scEdoLh7ha" id="content12-2t">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="mbr-section-btn align-center">
                        <a class="btn btn-primary display-4 bxtra" href="locales"><i class="fa fa-home" aria-hidden="true"></i>Sucursales</a>
                        <a class="btn btn-primary display-4 bxtra" href="gastos_envio"><i class="fa fa-money" aria-hidden="true"></i>Gasto de envío</a>
                        <a class="btn btn-primary display-4 bxtra" href="comosecompra"><i class="fa fa-desktop" aria-hidden="true"></i>Como se Compra</a>
                        <a class="btn btn-primary display-4 bxtra" href="carga_receta"><i class="fa fa-cloud-upload" aria-hidden="true"></i>Cargar Receta</a>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="mbr-section-btn align-center">
                        <a class="btn btn-primary display-4 bxtra" href="repetirpedido"><i class="fa fa-recycle" aria-hidden="true"></i>Repetir Pedido</a>
                        <a class="btn btn-primary display-4 bxtra" href=""><i class="fa fa-eye" aria-hidden="true"></i>Seguimiento de Toma</a>
                        <a class="btn btn-primary display-4 bxtra" href=""><i class="fa fa-ambulance" aria-hidden="true"></i>Seguimiento de Pedido</a>
                        <a class="btn btn-primary display-4 bxtra" href=""><i class="fa fa-whatsapp" aria-hidden="true"></i>Chat de Farmacia</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!--CATEGORIAS-->
<section class="gallery2 cid-scEhLFwhXp" id="gallery2-2v">
    <div class="container">
        <div class="mbr-section-head">
            <h4 class="mbr-section-title mbr-fonts-style align-center mb-0 display-5 mt-4 text-center"><strong>Categorias</strong></h4>
        </div>
        <div class="row mt-4">
        	<? 
        		$parents = Categorias::get("categoria_parent = 1","categoria_id DESC");
                $a = 1;
        		foreach ($parents as $parent) {
        			$imgcat = Imagenes_categorias::get("categoria_id = ".$parent['categoria_id'],"imagen_id DESC LIMIT 1" );
        			$imgcat = $imgcat[0]['imagen_image_big_url'];
        			?>
        	<div class="item itemgal features-image сol-12 col-md-6 col-lg-2">
                <div class="item-wrapper">
                    <div class="item-img">
                         <a href="productos/<?=$parent['categoria_slugit']?>"><img src="<?=$imgcat?>" class="imgRedonda"></a>
                    </div>
                    <div class="item-content">
                        <a href="productos/<?=$parent['categoria_slugit']?>">
                            <h5 class="item-title mbr-fonts-style mt-4"><?=$parent['categoria_nombre']?></h5>
                        </a>
                    </div>
                </div>
            </div>
        			<?
                    $a++;
        		}
        	?>            
        </div>
    </div>
</section>


<!-- BANNER 2 -->
<section class="gallery5 mbr-gallery cid-scK90oKEBM" id="gallery5-4t">
    <div class="container-fluid">
        <div class="row mbr-gallery mt-4">

            <div class="fadeOut owl-carousel owl-theme" >
                <?
                    $ofertaSemana = Ofertas_imagenes::get(null,"oferta_id DESC");
                    $ofertaCant = count($ofertaSemana);
                    foreach ($ofertaSemana as $oferta) {
                        ?>
               
                    <div class="col-12 col-md-12 col-lg-12 item gallery-image">
                    <div class="item-wrapper" data-toggle="modal" data-target="#scK9SBzfaK-modal">
                        <img class="w-100" src="<?=$oferta['oferta_image_big_url']?>" alt="" >
                    </div>
                    <h6 class="mbr-item-subtitle mbr-fonts-style align-center mb-2 mt-2"><?=$oferta['oferta_titulo']?></h6>
                </div>
             
                        <?
                    }
                ?>
            </div>

        </div>
        

    </div>
</section>

<!-- RECOMENDADO DE LA SEMANA -->
    <?  $productos = Productos::get("producto_recomendado = 1", "producto_id DESC LIMIT 5");
        if(haveRows($productos)){
    ?>
    <section class="gallery5 mbr-gallery pdestacado" id="gallery5-4t">
        <div class="container">
            <div class="mbr-section-head">
                 <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-5 mt-4 text-center"><strong>Recomendados de la semana</strong></h3>
            </div>
    
            <div class="row mt-4 mb-4">
                            <?php
                                    foreach ($productos as $rec):
                                        $imgDes = Imagenes_productos::get("producto_id =".$rec['producto_id'],"imagen_id DESC LIMIT 1");
                                        $imgDes = strlen($imgDes[0]['imagen_image_big_url']) > 0 ? $imgDes[0]['imagen_image_big_url'] : "images/sin-img.jpg";
                                        $ws = Ws_edicion($rec['producto_codigo'], $listProducto_url);
    
                                        $ivahorarec = $rec['producto_precioIVA'] > 0 ? $rec['producto_precioIVA'] : 0;
                                        $ivatesrec = $rec['producto_precioantesIVA'] > 0 ? $rec['producto_precioantesIVA'] : 0;
                                        
                                        $precioIVArec = $rec['producto_precio'] + $ivahorarec;
                                        $precioantesIVArec = $rec['producto_precioantes'] + $ivatesrec;
                                        
                                        $antesrec = number_format($precioantesIVArec,0,"",".");
                                        $actualrec = number_format($precioIVArec,0,"",".");
                                        $promoClassrec = "";
                                        
                                        $promoClassrec = "";
                                        if($rec['producto_descuento'] > 0 AND $rec['producto_mostrar'] === "S"){
                                             $promoClassrec = promo($rec['producto_descuento']);
                                        }
                                        
                                       ?>
                            <div class="item itemgal features-image сol-12 col-md-6 col-lg-2 p-0">
                                <div class="item-wrapper" style="padding: 15px 5px;">
                                    <div class="item-img">
                                        <a href="producto/<?=$rec['producto_slugit']?>">
                                            <span class="icono-promo <?=$promoClassrec?> ico-pr"></span>
                                            <img src="<?=$imgDes?>" alt="<?=$rec['producto_nombre']?>" title="<?=$rec['producto_nombre']?>">
                                        </a>
                                    </div>
                                    <div class="item-content title_product">
                                        <p class="mbr-text mb-0 text-left mbr-fonts-style title_producto">
                                            <a href="producto/<?=$rec['producto_slugit']?>" style="color: #000;"><b><?=$rec['marca_nombre']?></b></a>
                                        </p>
                                        <p class="mbr-text text-center mb-1 mbr-fonts-style title_producto maxmin">
                                            <a href="producto/<?=$rec['producto_slugit']?>" style="color: #000;"><?=$rec['producto_nombre']?></a>
                                        </p>
                                        
                                        <div class="row" style="width: 100%; margin:0; ">
                                            <? 
                                                $colrec = $antesrec > 0 ? '6' : '12';
                                                if($antesrec > 0){
                                            ?>
                                            <div class="features-image prodprice сol-6 col-lg-6 p-0">
                                                <p class="w-100 text-center mbr-text mb-1 mbr-fonts-style title_producto">Antes</p>
                                                <p class="w-100 text-center mbr-text mb-1 mbr-fonts-style title_producto">
                                                    <del class="mbr-text text-center mb-1 mbr-fonts-style title_producto" >Gs. <?=$antesrec?></del></p>
                                            </div>
                                            <? }   ?>
                                            <div class="features-image prodprice сol-6 col-lg-<?=$colrec?> p-0">
                                                <p class="text-center mbr-text mb-1 mbr-fonts-style title_producto"><b>Ahora</b></p>
    
                                                <p class="mbr-text text-center mb-1 mbr-fonts-style title_producto" style="font-size: 17px;"><b>Gs: <?=$actualrec?></b></p>
                                            </div>
                                        </div>
                                        <p class="mbr-text text-center mt-3 mbr-fonts-style title_producto">
                                            <a href="javascript:;" class="btnAddCart item_add" rel="<?php echo $rec['producto_id']; ?>">
                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                                        
                                 <?
                                    endforeach;
                                    
                                
                            ?>
            </div>   
    
        </div>
    </section>
    <?
        }
    ?>

<!-- PROMOCION -->
    <?
        $promociones = Productos::get("producto_promostatus = 1 AND CURDATE() <= producto_promofechafin","RAND() LIMIT 5");
        if($promociones):
    ?>
        <section class="content1 cid-scEieb16NW promociones" id="content1-2y">
        <div class="container">
            <div class="mbr-section-head">
                 <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-5 mt-4 text-center"><strong>Promociones</strong></h3>
            </div>

            <div class="row mt-4 mb-4">
                <?
                    foreach ($promociones as $promo) {
                        $ws = Ws_edicion($promo['producto_codigo'], $listProducto_url);
                        $imgRec = Imagenes_productos::get("producto_id =".$promo['producto_id'],"imagen_id DESC LIMIT 1");
                        $imgRec = strlen($imgRec[0]['imagen_image_big_url']) > 0 ? $imgRec[0]['imagen_image_big_url'] : "images/sin-img.jpg";
                        $porcentaje = $promo['producto_preciopromo'] * 100 / $promo['producto_precio'];

                            $ivahorapromo = $promo['producto_precioIVA'] > 0 ? $promo['producto_precioIVA'] : 0;
                            $ivatespromo = $promo['producto_precioantesIVA'] > 0 ? $promo['producto_precioantesIVA'] : 0;
                            
                            $precioIVApromo = $promo['producto_precio'] + $ivahorarec;
                            $precioantesIVApromo = $promo['producto_precioantes'] + $ivatesrec;
                            
                            $antespromo = number_format($precioantesIVArec,0,"",".");
                            $actualpromo = number_format($precioIVArec,0,"",".");
                            ///////////////////
                            $promoClasspromo = "";
                            if($promo['producto_descuento'] > 0 && $promo['producto_mostrar']){
                            
                                 $promoClasspromo = promo($promo['producto_descuento']);
                            }

                        
                      ?>
                            <div class="item itemgal features-image сol-12 col-md-6 col-lg-2 p-0" style="border: solid 1px #183883; border-radius: 7px;">
                                <div class="item-wrapper" style="padding: 15px 5px;">
                                    <div class="item-img">
                                        <a href="producto/<?=$promo['producto_slugit']?>">
                                            <span class="icono-promo <?=$promoClasspromo?> ico-pr"></span>
                                            <img src="<?=$imgRec?>" alt="<?=$promo['producto_nombre']?>" title="<?=$promo['producto_nombre']?>">
                                        </a>
                                    </div>
                                    <div class="item-content title_product">
                                        <p class="mbr-text mb-0 text-left mbr-fonts-style title_producto">
                                            <a href="producto/<?=$promo['producto_slugit']?>" style="color: #000;"><b><?=$promo['marca_nombre']?></b></a>
                                        </p>
                                        <p class="mbr-text text-center mb-1 mbr-fonts-style title_producto maxmin">
                                            <a href="producto/<?=$promo['producto_slugit']?>" style="color: #000;"><?=$promo['producto_nombre']?></a>
                                        </p>
                                        
                                        <div class="row" style="width: 100%; margin:0; ">
                                            <div class="features-image prodprice сol-6 col-lg-6 p-0">
    
                                                <p class="w-100 text-center mbr-text mb-1 mbr-fonts-style title_producto">Antes</p>
                                                <p class="w-100 text-center mbr-text mb-1 mbr-fonts-style title_producto">
                                                    <del class="mbr-text text-center mb-1 mbr-fonts-style title_producto" >Gs. <?=$antespromo?></del></p>
                                            </div>
                                            <div class="features-image prodprice сol-6 col-lg-6 p-0">
                                                <p class="text-center mbr-text mb-1 mbr-fonts-style title_producto"><b>Ahora</b></p>
    
                                                <p class="mbr-text text-center mb-1 mbr-fonts-style title_producto" style="font-size: 17px;"><b>Gs: <?=$actualpromo?></b></p>
                                            </div>
                                        </div>
                                        <p class="mbr-text text-center mt-3 mbr-fonts-style title_producto">
                                            <a href="javascript:;" class="btnAddCart item_add" rel="<?php echo $promo['producto_id']; ?>">
                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                      <?
                    }
                ?>
            </div>
        </div>
    </section>
    <?
        endif;
    ?>
<!--INFORMATIVO-->
    <section class="features3 cid-scK97Y6blY" id="features4-4u">    
    <div class="container">
        <div class="mbr-section-head">
            <h4 class="mbr-fonts-style align-center mb-0 display-5"><strong>Informate con nuestra de guía de cuidados</strong></h4>
        </div>
        <div class="row mt-4">
        	<?
        		$noticias = Noticias::get(NULL,"noticia_id DESC LIMIT 4");
        		foreach ($noticias as $noticia) {
        			?>
        	<div class="item features-image сol-12 col-md-6 col-lg-3">
                <div class="item-wrapper">
                    <div class="item-img">
                        <img src="<?=$noticia['noticia_image_big_url']?>" alt="" title="" data-slide-to="0">
                    </div>
                    <div class="item-content">
                        <p class="item-title mbr-fonts-style"><strong><?=$noticia['noticia_titulo']?></strong></p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                    	<a href="informativo/<?=$noticia['noticia_slugit']?>" class="btn item-btn btn-primary">Leer Más</a>
                    </div>
                </div>
            </div>
        			<?
        		}
        	?>
            <div class="item features-image сol-12 col-md-6 col-lg-12">
                <div class="mbr-section-btn item-footer mt-2 text-center">
                        <a href="informativos" class="btn item-btn btn-primary">Ver Más</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--MARCAS-->
    <section class="clients1 cid-scK991gVCa" id="clients1-4v">
    
    <div class="images-container container-fluid">
        <div class="mbr-section-head">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-5"><strong>Marcas Destacadas</strong></h3>
        </div>
        <div id="store" class="marcas owl-carousel owl-theme row justify-content-center mt-4" >
        	<?
        		$marcas = Marcas::get();
        		foreach ($marcas as $marca) {
        			echo '<div class="col-md-10"><img src="'.$marca["marca_image_big_url"].'" alt=""></div>';
        		}
        	?>
        </div>
    </div>
</section>
<!--SUSCRIPCION-->
    <section class="form9 cid-scz6IhF9nD" id="form9-17">    
    <div class="container">
        <div class="mbr-section-head">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-5">
                <strong>Suscribite para recibir novedades</strong></h3>
            
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8 mx-auto mbr-form" data-form-type="formoid">
                <form method="POST" class="mbr-form form-with-styler mx-auto" id="form-suscribe" data-form-title="Form Name">
                    <div class="dragArea row">
                        <div class="col-lg-12"></div>
                        <div class="col-lg-4 col-md-12 col-sm-12 form-group" data-for="name">
                            <input type="text" name="suscripcion_name" placeholder="Nombre" data-form-field="suscripcion_name" class="form-control" id="suscripcion_name">
                        </div>
                        <div data-for="email" class="col-lg-6 col-md-12 col-sm-12 form-group">
                            <input type="email" name="suscripcion_email" placeholder="Email" data-form-field="email" class="form-control" value="" id="suscripcion_email">
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12 mbr-section-btn align-center">
                            <a href="javascript:;" class="btn btn-primary display-4" id="btn_suscribe">Enviar</a>
                            <input type="hidden" name="suscripcionesToken" id="suscripcionesToken" value="<?=token('suscripciones')?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
   include("inc/footer.php");
?>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  
<script defer src="js/lightbox/lightbox-plus-jquery.min.js"></script>
<script defer src="js/jquery.flexslider.js"></script>
 <div id="scrollToTop" class="scrollToTop mbr-arrow-up">
    <a style="text-align: center;"><i class="mbr-arrow-up-icon mbr-arrow-up-icon-cm cm-icon cm-icon-smallarrow-up"></i></a>
</div>
    <input name="animation" type="hidden">
    <script src="assets/vendors/jquery.min.js"></script>
    <script src="assets/owlcarousel/owl.carousel.js"></script>
    
    <script>
    jQuery(document).ready(function($) {
        $('.fadeOut').owlCarousel({
            animateOut: 'fadeOut',
            animateIn: 'pulse',
            loop: true,
            margin: 10,
            items:1,
            autoplay:true,
            dots:true,
        });
        
        $('.marcas').owlCarousel({
            animateOut: 'fadeOut',
            animateIn: 'pulse',
            loop: false,
            margin: 10,
            items:6,
            autoplay:true,
            dots:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },            
                960:{
                    items:3
                },
                1200:{
                    items:6
                }
            }
        });
    });
    </script>
  </body>
</html>