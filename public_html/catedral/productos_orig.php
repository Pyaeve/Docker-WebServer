<?php
    require_once('inc/config.php');
    $where = "";
    $tree = "";
    $categoria_url = param('id');
    $descuento = numParam('d') > 0 ? ' AND producto_mostrar = "S" AND producto_descuento = '.numParam("d") : '';
    
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
            $cantidad = count($parents);
            $i= 1;
            foreach($parents as $category):
                $barra = $cantidad == $i ? "" : "<span> > </span>";
                $tree .= '<li><a href="productos/'.$category['categoria_slugit'].'"><p><b>'.$category['categoria_nombre'].'</b>'.$barra.'</p></a></li>';
                $newparent = $category['categoria_id'];
                $i++;
            endforeach;
            $tree = substr($tree,0,-5);
        }
    }
    if(strlen(param('busca'))>0 ){
        $busca = trim(param('busca'));
        $slugit = slugit( addslashes($_GET['busca']) );
        $especial = str_replace(" ", "%", $busca);
        
        $where.= " AND ( producto_nombre LIKE '%{$busca}%' OR producto_droga LIKE '%{$busca}%' OR marca_nombre LIKE '%{$busca}%' OR producto_slugit LIKE '%{$slugit}%' 
        OR CONCAT_WS(' ',marca_nombre, producto_nombre, producto_droga, producto_descripcion) LIKE '%{$busca}%' 
        OR CONCAT_WS(' ',producto_nombre, marca_nombre, producto_droga, producto_descripcion) LIKE '%{$especial}%' ) 
        ORDER BY FIELD(marca_nombre,'colgate','protex') DESC "; 
    }
    if(strlen(param('buscaM'))>0 ){
        $busca = trim(param('buscaM'));
        $slugit = slugit( addslashes($_GET['buscaM']) );
        $especial = str_replace(" ", "%", $busca);
        
        $where.= " AND ( producto_nombre LIKE '%{$busca}%' OR producto_droga LIKE '%{$busca}%' OR marca_nombre LIKE '%{$busca}%' OR producto_slugit LIKE '%{$slugit}%' 
        OR CONCAT_WS(' ',marca_nombre, producto_nombre, producto_droga, producto_descripcion) LIKE '%{$busca}%' 
        OR CONCAT_WS(' ',producto_nombre, marca_nombre, producto_droga, producto_descripcion) LIKE '%{$especial}%' ) 
        ORDER BY FIELD(marca_nombre,'colgate','protex') DESC "; 
    }

    $productos = Productos::listing(9,pageNumber(),NULL,"producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 ".$descuento.$where);

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es-ES"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="es-ES"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="es-ES"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es-ES"> <!--<![endif]-->
<head>
  <? include("inc/head.php")?>
  <title>Catedral</title>

  <link rel="stylesheet" href="css/menu.css">

  <style type="text/css">
        .item{border: 1px solid #d3d3d3; border-radius: 5px;padding: 0; margin-left: 20px;}
        .navi{
            padding: 15px 0 0 0;
        }
        .cid-scEieb16NW{ padding-top: 0; }
        .mp{
            color: #0f3b84;
            /* background: #0f3b84; */
            padding: 7px 10px;
            font-size: 17px;
            font-weight: bold;
        }
        .minimenu{
            font-size: 14px;
            padding-left: 20px; 
        }

        .subs{
            background: #444 !important;
        }
  </style>
</head>
<body>
 <? 
    require_once('inc/header.php'); 
    require_once('inc/nav.php'); 

?>
<!-- BANNERS -->
<!-- PRODUCTOS GALERIA -->
<section class="content1 cid-scEieb16NW" id="content1-2y">
        <div class="row">
            <div class="" style=" width: 100%; background: #f3f3f3; padding-top: 0px;">
                <div class="col-md-6 col-lg-12 display-4 navi">
                    <? echo isset($tree) ? '<ul class="subBotonera history">'.$tree.'</ul>' : ''; ?>
                </div>
            </div>
        </div>
<div class="container">
    <div class="row">
            <div class="col-md-6 col-lg-3 mbr-text mbr-fonts-style mtb-3 display-7 mt-4">
                <?php  
                    if(strlen(param('busca'))>0 ){
                        $datamenu = trim(param('busca'));
                    }
                    if(isset($datamenu)){
                        
                        $databusca = str_replace(" ", "|", $datamenu);
                        $complemento = Categorias::catdata($databusca);
                        $ids = array();

                        foreach ($complemento as $key => $m1) {
                          $main = Categorias::padre($m1['categoria_id']);
                          foreach ($main as $llave => $m2) {
                            $ids[$key][$llave] = $m2['categoria_id'];
                          }
                        }
                        if(haveRows($ids)){
                            echo '<ul class="menu">';
                            $b = call_user_func_array('array_merge', $ids);
                            $c = array_unique($b);
             
                            foreach ($c as $valor) {
                                $Catname = Categorias::select($valor);
                                if($Catname[0]["categoria_parent"] == 1){
                                      echo '<li class="list">
                                              <a href="productos/'.$Catname[0]["categoria_slugit"].'">'.$Catname[0]["categoria_nombre"].'</a>';
                                      echo '</li>';
                                }else{
                                      echo '<li class="list subs">
                                              <a href="productos/'.$Catname[0]["categoria_slugit"].'">'.$Catname[0]["categoria_nombre"].'</a>';
                                      echo '</li>';
                                }
                            }
                            echo '</ul>';
                        }else{
                            require_once('inc/menu.php'); 
                        }
                        
                    }else{
                        require_once('inc/menu.php'); 
                    }
                    ?>
            </div>
            <!-- Productos Galeria -->
            <div class="col-md-6 col-lg-9">
                 <div class="mbr-section-head">
                    <h5 class="mbr-section-subtitle mbr-fonts-style align-center mb-0 mt-2 display-7 ">
                        <strong><? 
                                if(isset($categoria_id)){
                                    $catParent = Categorias::catpag( $categoria_id);
                                    $listproduct = "";
                                    foreach ($catParent as $cp) {
                                       $listproduct.= $cp['categoria_id'].',';
                                    }
                                    $listproduct = substr($listproduct,0,-1);
                                }
                        ?></strong>
                    </h5>
                </div>
                <div class="row mt-4">
                    <?php
                        if(haveRows($productos['list'])){
                            foreach ($productos['list'] as $productoRs):
                            if($productoRs['producto_status'] == 1){    
                                $img = Imagenes_productos::get("producto_id =".$productoRs['producto_id'],"imagen_id DESC LIMIT 1");
                                $img = isset($img[0]['imagen_image_small_url']) ? $img[0]['imagen_image_small_url'] : "images/sin-img.jpg";
                                
                                $promoClassrel = "";
                                if($productoRs['producto_descuento'] > 0 && $productoRs['producto_mostrar'] == "S"){
                                     $promoClassrel = promo($productoRs['producto_descuento']);
                                }
                                
                                $ivahora = $productoRs['producto_precioIVA'] > 0 ? $productoRs['producto_precioIVA'] : 0;
                                $ivates = $productoRs['producto_precioantesIVA'] > 0 ? $productoRs['producto_precioantesIVA'] : 0;
                                $precioIVA = $productoRs['producto_precio'] + $ivahora;
                                $precioantesIVA = $productoRs['producto_precioantes'] + $ivates;
                                
                                $antes = number_format($precioantesIVA,0,"",".");
                                $actual = number_format($precioIVA,0,"","."); 
                                
                                if($productoRs['producto_precio'] > 0 AND $productoRs['producto_stock'] > 0){
                               ?>
                    <div class="item itemgal features-image сol-12 col-md-6 col-lg-3">
                        <div class="item-wrapper">
                            <div class="item-img">
                                <a href="producto/<?=$productoRs['producto_slugit']?>">
                                    <span class="icono-promo <?=$promoClassrel?> ico-pr"></span>
                                    <img src="<?=$img?>" alt="<?=$productoRs['producto_nombre']?>" title="<?=$productoRs['producto_nombre']?>">
                                </a>
                            </div>
                            <div class="item-content title_product">
                                <p class="mbr-text mb-0 text-left mbr-fonts-style title_producto">
                                    <a href="producto/<?=$productoRs['producto_slugit']?>" style="color: #000;"><b><?=$productoRs['marca_nombre']?></b></a>
                                </p>
                                <p class="mbr-text text-center mb-1 mbr-fonts-style title_producto maxmin">
                                    <a href="producto/<?=$productoRs['producto_slugit']?>" style="color: #000;"><?=$productoRs['producto_nombre']?></a>
                                </p>

                                <div class="row" style="width: 100%; margin:0; ">
                                    <? 
                                        $col = $antes > 0 ? '6' : '12';
                                        if($antes > 0){
                                    ?>
                                    <div class="features-image prodprice сol-12 col-lg-6 p-0">
                                        <p class="w-100 text-left mbr-text mb-1 mbr-fonts-style title_producto">Antes</p>
                                        <del class="mbr-text text-center mb-1 mbr-fonts-style title_producto" style="font-size: 12px">Gs. <?=$antes?></del>
                                    </div>
                                    <? }   ?>
                                    <div class="features-image prodprice сol-12 col-lg-<?=$col?> p-0">
                                        <p class="text-center mbr-text mb-1 mbr-fonts-style title_producto"><b>Ahora</b></p>

                                        <p class="mbr-text text-center mb-1 mbr-fonts-style title_producto" style="font-size: 17px;"><b>Gs: <?=$actual?></b></p>
                                    </div>
                                </div>
                                <p class="mbr-text text-center mt-3 mbr-fonts-style title_producto">
                                    <a href="javascript:;" class="btnAddCart item_add" rel="<?php echo $productoRs['producto_id']; ?>">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar
                                    </a>
                                </p>
                            </div>
                            
                        </div>
                    </div>

                               <?
                                }//ValPrecio
                            }//Status
                            endforeach;
                            
                        }else{
                            echo "No se han encontrado Productos";
                        }
                    ?>
                    <div class="сol-12 col-md-12 col-lg-12">
                        <div class="pagination"><?=$productos["navigation"]?></div>
                    </div>
                </div>   
            </div>
        </div><!-- row --->
    </div>
</div>
 
</section>

<!-- PRODUCTOS FOOTER -->
<? require_once('inc/footer.php'); ?>

<input name="animation" type="hidden">


  </body>


</html>