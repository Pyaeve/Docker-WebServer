<?php
    require_once('inc/config.php');
    $where = "";
    $tree = "";
    
    //$categoria_url = param('id');
    //$descuento = numParam('d') > 0 ? ' AND producto_mostrar = "S" AND producto_descuento = '.numParam("d") : '';
    $descuento = $_GET['d'] > 0 ? ' AND producto_mostrar = \'S\' AND producto_descuento = '.$_GET['d'] : '';
    $par_marca = $_GET['marcas'];
    //$val_marca = strlen($par_marca);
    $par_categoria = $_GET['id'];
    

    
   
    if(strlen($par_categoria) > 0){
        
        $categorias = Categorias::get("categoria_slugit = '{$par_categoria}'");
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
    /*if(strlen(param('busca'))>0 ){
        $busca = trim(param('busca'));
        $slugit = slugit( addslashes($_GET['busca']) );
        $especial = str_replace(" ", "%", $busca);
        
        $where.= " AND ( producto_nombre LIKE '%{$busca}%' OR producto_droga LIKE '%{$busca}%' OR marca_nombre LIKE '%{$busca}%' OR producto_slugit LIKE '%{$slugit}%' 
        OR CONCAT_WS(' ',marca_nombre, producto_nombre, producto_droga, producto_descripcion) LIKE '%{$busca}%' 
        OR CONCAT_WS(' ',producto_nombre, marca_nombre, producto_droga, producto_descripcion) LIKE '%{$especial}%' ) 
        ORDER BY FIELD(marca_nombre,'colgate','protex') DESC "; 
    }*/
    if(strlen($_GET['busca'])>0 ){
        $busca = trim($_GET['busca']);
        $slugit = slugit( addslashes($_GET['busca']) );
        $especial = str_replace(" ", "%", $busca);
        $where2 = $where."AND ( producto_nombre LIKE '%{$busca}%' OR producto_droga LIKE '%{$busca}%' OR marca_nombre LIKE '%{$busca}%' OR producto_slugit LIKE '%{$slugit}%' 
        OR CONCAT_WS(' ',marca_nombre, producto_nombre, producto_droga, producto_descripcion) LIKE '%{$busca}%' 
        OR CONCAT_WS(' ',producto_nombre, marca_nombre, producto_droga, producto_descripcion) LIKE '%{$especial}%' )";

        $where.= " AND ( producto_nombre LIKE '%{$busca}%' OR producto_droga LIKE '%{$busca}%' OR marca_nombre LIKE '%{$busca}%' OR producto_slugit LIKE '%{$slugit}%' 
        OR CONCAT_WS(' ',marca_nombre, producto_nombre, producto_droga, producto_descripcion) LIKE '%{$busca}%' 
        OR CONCAT_WS(' ',producto_nombre, marca_nombre, producto_droga, producto_descripcion) LIKE '%{$especial}%' ) 
        "; 

        $marcas = Productos::get2("DISTINCT(`marca_nombre`)","producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 AND marca_nombre NOT LIKE '%CATEDRAL%' ".$descuento.$where2,"FIELD(marca_nombre,'colgate','protex') DESC");//marca_nombre LIMIT 5
        $sugeridos = Productos::get2("DISTINCT(`marca_nombre`)","producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 AND marca_nombre LIKE '%CATEDRAL%' ".$descuento.$where2,"FIELD(marca_nombre,'colgate','protex') DESC");//marca_nombre LIMIT 5
    }else{
        $marcas = Productos::get2("DISTINCT(`marca_nombre`)","producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 AND marca_nombre NOT LIKE '%CATEDRAL%' ".$descuento.$where,"");//marca_nombre LIMIT 5
        $sugeridos = Productos::get2("DISTINCT(`marca_nombre`)","producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 AND marca_nombre LIKE '%CATEDRAL%' ".$descuento.$where,"");//marca_nombre LIMIT 5
    }
    if(strlen($_GET['buscaM'])>0 ){
        $busca = trim($_GET['buscaM']);
        $slugit = slugit( addslashes($_GET['buscaM']) );
        $especial = str_replace(" ", "%", $busca);
        $where2 = $where."AND ( producto_nombre LIKE '%{$busca}%' OR producto_droga LIKE '%{$busca}%' OR marca_nombre LIKE '%{$busca}%' OR producto_slugit LIKE '%{$slugit}%' 
        OR CONCAT_WS(' ',marca_nombre, producto_nombre, producto_droga, producto_descripcion) LIKE '%{$busca}%' 
        OR CONCAT_WS(' ',producto_nombre, marca_nombre, producto_droga, producto_descripcion) LIKE '%{$especial}%' )";

        $where.= " AND ( producto_nombre LIKE '%{$busca}%' OR producto_droga LIKE '%{$busca}%' OR marca_nombre LIKE '%{$busca}%' OR producto_slugit LIKE '%{$slugit}%' 
        OR CONCAT_WS(' ',marca_nombre, producto_nombre, producto_droga, producto_descripcion) LIKE '%{$busca}%' 
        OR CONCAT_WS(' ',producto_nombre, marca_nombre, producto_droga, producto_descripcion) LIKE '%{$especial}%' ) 
        "; 
        $marcas = Productos::get2("DISTINCT(`marca_nombre`)","producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 AND marca_nombre NOT LIKE '%CATEDRAL%' ".$descuento.$where2,"FIELD(marca_nombre,'colgate','protex') DESC");//marca_nombre LIMIT 5
        $sugeridos = Productos::get2("DISTINCT(`marca_nombre`)","producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 AND marca_nombre LIKE '%CATEDRAL%' ".$descuento.$where2,"FIELD(marca_nombre,'colgate','protex') DESC");//marca_nombre LIMIT 5
    }/*else{
        //$marcas = Productos::get2("DISTINCT(`marca_nombre`)","producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 ".$descuento.$where,"");//marca_nombre LIMIT 5
    }*/

    $params = "";
    foreach($_GET as $key => $value):
        if($key != "page"):
            $params .= '&' . urlencode(strip_tags($key)) . '=' . urlencode($value);
        endif;
    endforeach;
    

?>
<!DOCTYPE html>
 <html  lang="es-ES"> <!--<![endif]-->
<head>
  <?php include("inc/head.php")?>
 
</head>  
<body class="bg-white">

   <?php include_once('inc/header-v2.php') ?>

<input type="hidden" name="where" id="where" value="<?php  echo $descuento.$where; ?>">
<input type="hidden" name="categoria" id="categoria" value="<?php  echo $categoria_id; ?>">
<input type="hidden" name="pagenum" id="pagenum" value="<?php  echo pageNumber(); ?>">
<input type="hidden" name="marcas" id="marcas" value="null">
<input type="hidden" name="params" id="params" value="<?php  echo $params; ?>">
<input name="animation" type="hidden">
<!-- BANNERS -->

<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space breadcrumb-catedral">
    <div class="container">
        <div class="row">
              <div class="col-md-6 col-lg-12 display-6 navi">
                <?php 
                    echo strlen($tree) > 0 ? '<ul class="subBotonera history" > '.$tree.'</ul>' : '';
                ?>
             
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->
<section class="container" >
    <div class="row">
            <div class="filtro-catedral col-md-12 col-lg-12 col-sm-12 col-xs-12" style="background-color: #f1f1f1;">
                <b style="font-size: 15px;">Filtrar por:</b>    
                <a class="btn btn-light" style="background-image: linear-gradient(to bottom, #ffffff, #faf9fa, #f7f4f4, #f2efec, #eaeae6);}
" data-toggle="collapse" href="#marcas_filter" role="button" aria-expanded="false"aria-controls="collapse">
                    
                    <span class="fa fa-2x fa-caret-down" id="text_h"></span> 
                    <span class="fa fa-2x fa-caret-up" id="text_b"style="display:none;"></span>
                    
                </a> 
            </div> 
        </div>    
        <div class="row">
           <div class="col-md-3 col-lg-2 col-sm-12 col-xs-12 left-nav" id="marcas_filter" style="background-image: linear-gradient(to bottom, #ffffff, #faf9fa, #f7f4f4, #f2efec, #eaeae6)
;display:none;">
                 <?php   
                   if(haveRows($marcas)){

                        /**/

                        if(haveRows($sugeridos)){
                            echo '<div class="row justify-content-center" data-mdb-items=".basic-example-item" data-mdb-auto-filter="true" style="margin-left: 0px;">
                                        <div data-mdb-filter="marcas" style="margin-top: 0%;">
                                            <span class="fa-lg mb-5" style="font-weight: bold;color: #0f3b84;">Marcas Sugeridas</span>';
                            foreach ($sugeridos as $key=>$m) {
                                $checked = strpos($par_marca, trim($m["marca_nombre"]));
                                $page = pageNumber();
                                if($page > 1){
                                    $true = '';
                                    $checked = strpos($par_marca, trim($m["marca_nombre"]));
                            
                                    $true = (trim($checked)<>'') ? 'checked' : '';
                                }else{
                                    $true = 'checked';
                                }
                                //$true = 'checked';
                                //$true = (trim($checked)<>'') ? 'checked' : '';
                                //echo "<script>console.log('t:".$checked.trim($m["marca_nombre"])."');</script>";
                                echo '<div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="'.$m["marca_nombre"].'" value="'.addslashes($m["marca_nombre"]).'" '.$true.' />
                                        <label class="form-check-label" for="'.$m["marca_nombre"].'">'.$m["marca_nombre"].'</label>
                                      </div>';
                            
                            }
                            echo '</div>
                                </div>
                            ';
                            
                        }
                        /**/


                        echo '<div class="row justify-content-center" data-mdb-items=".basic-example-item2" data-mdb-auto-filter="true" style="margin-left: 6px;">
                                    <div data-mdb-filter="marcas" style="margin-top: 5%;">
                                        <span class="fa-lg mb-5" style="font-weight: bold;">Marcas</span>';
                        foreach ($marcas as $key=>$m) {
                            $checked = strpos($par_marca, trim($m["marca_nombre"]));
                            
                            $true = (trim($checked)<>'') ? 'checked' : '';
                            //echo "<script>console.log('t:".$checked.trim($m["marca_nombre"])."');</script>";
                            echo '<div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="'.$m["marca_nombre"].'" value="'.addslashes($m["marca_nombre"]).'" '.$true.' />
                                    <label class="form-check-label" for="'.$m["marca_nombre"].'">'.$m["marca_nombre"].'</label>
                                  </div>';
                        
                        }
                        echo '</div>
                            </div>
                        ';
                        
                    }    
                ?>
                
            </div>
            <div class="col-md-9 col-lg-10 col-sm-12 col-xs-12 filter_data center">
                
                    
                        
                   
              
            </div>
        </div>

</section>


<!-- PRODUCTOS FOOTER -->
<?php require_once('inc/footer-v2.php'); ?>


