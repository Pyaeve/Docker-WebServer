    <!DOCTYPE html>
    <html lang="es-PY">
    <head>
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
         $imagenes = Imagenes_productos::get("producto_id = ".$producto['producto_id']);
        $producto_imagen=$imagenes[0]['imagen_image_big_url'];
         $producto_relacionados = Productos::get("categoria_id = ".$producto['categoria_id']." AND producto_status = 1 AND producto_precio > 0 AND producto_stock > 0  ","rand() LIMIT 16");
        
    ?>

      <?php include("inc/head.php"); ?>   

    </head>
    <body>
    <?php
       require_once('inc/header.php'); 
      // require_once('inc/nav.php'); 
    ?>
    <div class="container">
        <iframe src="http://10.16.1.10:8080/ords/catedral/r/consultas-kude-catedral/portal-de-consultas-kude-catedral" frameborder="0"></iframe>
    </div>

    <!-- PRODUCTOS GALERIA END -->
    <? require_once('inc/footer.php'); ?>



     