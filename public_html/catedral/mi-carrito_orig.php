<?php
    require_once('inc/config.php');
    #Si inicia session
    if($cliente_id > 0){
        #Obtiene el nombre del carrito
        $carritoNombre = Carrito::get("cliente_id = ".$cliente_id);
        
        $cartName = strlen($_SESSION['carrito']['nombre_carrito']) > 0 ? $_SESSION['carrito']['nombre_carrito'] : strlen($carritoNombre[0]['carrito_nombre']) > 0 ? $carritoNombre[0]['carrito_nombre'] : "";

        if($totalItems == 0){
            header("Location:productos");
            exit();
        }

    }elseif ($_SESSION['carrito']) {
        $items = $_SESSION['carrito'];
        $totalPrecio  = $items['precio_total'];
        $totalItems   = $items['articulos_total'];
    }else{
        header("Location:productos");
        exit();
    }
    
    $datos_cliente = Clientes::select($cliente_id);
    #Apellido, email ,ci / o ruc esta vacio obligo a completar 
    $ok = true;
    if( strlen($datos_cliente[0]['cliente_apellido']) == NULL){
        $ok = false;
    }
    if( strlen($datos_cliente[0]['cliente_email']) == NULL){
        $ok = false;
    }
    if($datos_cliente[0]['cliente_tipo'] == 1 ){
        if( strlen($datos_cliente[0]['cliente_cedula']) == NULL){
            $ok = false;
        }
    }
    if($datos_cliente[0]['cliente_tipo'] == 2 ){
        if( strlen($datos_cliente[0]['cliente_ruc']) == NULL){
            $ok = false;
        }
    }
?>
<!DOCTYPE html>
<html  >
<head>
  <? include("inc/head.php")?>  
  <title>Catedral</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">

  <style type="text/css">
        .item{border: 1px solid #d3d3d3; border-radius: 5px;padding: 0; margin-left: 20px;}
        .cid-scEieb16NW{ padding-top: 0; }

        .btn-default {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .btn-primary {
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }
        .pull-left {
            float: left!important;
        }
        .pull-right {
            float: right!important;
        }
        .fa-trash-o{
            color: red;
            font-size: 22px;
        }
        a{
            color: #000
        }
        .count{width: 50%}

        .cid-scEieb16NW img, .cid-scEieb16NW .item-img {
            height: 120px;
        }
        .btn-primary, .btn-primary:active {
            background-color: #0f3b84 !important;
            border-color: #0f3b84 !important;
        }
        #nombraCarrito input{ width: 50% }
        #btn_Nc{ width: 50%; font-size: 13px;}
        /**/
        @media only screen and (max-width: 800px) {
        /* Force table to not be like tables anymore */
        #no-more-tables table,
        #no-more-tables thead,
        #no-more-tables tbody,
        #no-more-tables th,
        #no-more-tables td,
        #no-more-tables tr {
        display: block;
        }
         
        /* Hide table headers (but not display: none;, for accessibility) */
        #no-more-tables thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
        }
         
        #no-more-tables tr { border: 1px solid #ccc; }
          
        #no-more-tables td {
        /* Behave like a "row" */
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
        white-space: normal;
        text-align:left;
        }
         
        #no-more-tables td:before {
        /* Now like a table header */
        position: absolute;
        /* Top/left values mimic padding */
        top: 6px;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        text-align:left;
        font-weight: bold;
        }
         
        /*
        Label the data
        */
        #no-more-tables td:before { content: attr(data-title); }
        }
         .alertpro{color: #f00; }
         .alert-danger{background-color: #ff3939;}
         .receta{ color: #fff; padding:3px 10px; }
  </style>
</head>
<body>
 <? 
    require_once('inc/header.php'); 
    require_once('inc/nav.php'); 

?>
<? //pr($_SESSION['cliente']['cliente_id']); ?>
<!-- PRODUCTOS GALERIA -->
<section class="content1 cid-scEieb16NW" id="content1-2y">


<div class="container">
    <div class="row">
<!--             <div class="col-md-6 col-lg-3 mbr-text mbr-fonts-style mtb-3 display-7">
                <?php //require_once('inc/menu.php'); ?>
            </div> -->
<!--  -->

                <div class="col-md-6 col-lg-12 mt-3">
                        <div class="row">
           
                            <div class="col-md-6 col-lg-6 mt-3">
                                <h2>Carrito de compras</h2>
                                 <p class="text-muted">Actualmente tiene (<?=$totalItems?>) objetos en su carrito.</p>
                            </div>
                            <div class="col-md-6 col-lg-6 mt-3">
                                <form id="nombraCarrito" method="POST">
                                    <input type="text" name="nombre_carrito" id="nombre_carrito" placeholder="Nombrar carrito recurrente" class="form-control float-left">
                                    <a href="javascript:;" id="btn_Nc" class="btn btn-primary float-left">Nombrar carrito<i class="fa fa-chevron-right ml-2"></i>
                                    </a>
                                    <input type="hidden" name="accion" id="accion" value="nombreCarrito">
                                </form>
                            </div>
                        </div>


                            <div class="table-responsive" id="no-more-tables">
                                <!-- <table class="table"> -->
                                <table class="col-sm-12 table-bordered table-striped table-condensed cf">
                                    <thead class="cf">
                                        <tr>
                                            <th colspan="2" class="center">Producto</th>
                                            <th class="nro">Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Total</th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach ($items as $item):
                                                if(haveRows($item)){
                                                    //$totalPrecio    = $items['precio_total'];
                                                    $imagen = Imagenes_productos::get('producto_id ='.$item["producto_id"],'imagen_id DESC LIMIT 1');
                                                    $imagen = strlen($imagen[0]['imagen_image_big_url']) > 0 ? $imagen[0]['imagen_image_big_url'] : 'images/sin-img.jpg';
                                                    $subtotal = $item['producto_precio']*$item['detalle_cantidad'];
                                                    $productos = Productos::select($item['producto_id']);
                                                ?>
                                                <tr>
                                                    <td data-title="Producto"><img src="<?php echo $imagen; ?>" style="width:100px" alt="Producto"></td>
                                                    <td>
                                                    <?
                                                        if($_SESSION['producto_alert'][$key] > 0){
                                                            $producto = Productos::get("producto_codigo = ".$_SESSION['producto_alert'][$key]);
                                                            if(haveRows($producto)){
                                                                echo '<a href="#"><del>'.$item["producto_nombre"].'</del></a><br><b class="alertpro">Stock insuficiente</b>';
                                                            }

                                                        }else{
                                                            echo '<a href="#">'.$item["producto_nombre"].'</a>';
                                                        }
                                                        if( $productos[0]['producto_nivel'] != "VENTA LIBRE" ){
                                                            echo '<p class="receta alert-danger" role="alert"> Venta bajo receta</p>';
                                                        }
                                                    ?>
                                                    </td>
                                                    <!--<td><a href="#"><?php //echo $item['producto_nombre']; ?></a></td>-->
                                                    
                                                    <td data-title="Cantidad">
                                                        <input type="number" value="<?php echo $item['detalle_cantidad']; ?>" onchange="update('<?php echo htmlspecialchars($item['detalle_id']); ?>');" id="cantidadproducto_<?php echo htmlspecialchars($item['detalle_id']); ?>" class="form-control count">
                                                    </td>
                                                    <td data-title="Precio Unit">
                                                        <?php 
                                                            //$iva = Productos::select($item["producto_id"]);
                                                            //$iva = $iva[0]['producto_precioIVA'];
                                                        echo number_format($item['producto_precio'],0,'','.'); ?></td>
                   
                                                    <td data-title="Total" ><?php echo number_format($subtotal,0,'','.'); ?></td>
                                                    <td class="center">
                                                        <a href="javascript:;" rel="<?php echo token("deleteitem_" . $item['detalle_id']);?>" class="eliminar">
                                                            <i class="fa fa-trash-o"></i>Borrar</a>
                                                    </td>
                                                </tr>
                                                <?php 
                                                }
                                            endforeach;
                                            unset($_SESSION['producto_alert']);#Borramos la session product
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5">Total</th>
                                            <th colspan="2"><?php echo ($totalPrecio>0) ?number_format($totalPrecio,0,'','.') : 0; ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="box-footer">
                                <div class="pull-left">
                                    <a href="productos" class="btn btn-default"><i class="fa fa-chevron-left"></i> Continuar comprando</a>
                                </div>
                                <div class="pull-right">
                                    <button class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Actualizar carrito</button>
                                                                        <!-- <a href="javascript:;" id="btn_final" class="btn btn-primary">Finalizar compra <i class="fa fa-chevron-right ml-2"></i> -->
                                    <? 
                                    if($cliente_id > 0){
                                        if($ok){ ?>
                                            <a href="javascript:;"  id="checkout" class="btn btn-primary">Finalizar compra <i class="fa fa-chevron-right ml-2"></i></a>

                                        <?  }else{
                                            echo '<a href="mi-cuenta/editar">
                                            <div class="alert alert-danger" role="alert">
                                              Para continuar la compra debe actualizar sus datos
                                            </div></a>';
                                               

                                        }   
                                    }else{
                                        echo '<a href="javascript:;"  id="checkout" class="btn btn-primary">Finalizar compra <i class="fa fa-chevron-right ml-2"></i></a>';
                                    }

                                    ?>
                                    
                                </div>
                            </div>
                            </div>

                </div>

    </div>
</div>
 
</section>

<!-- FOOTER -->
<? require_once('inc/footer.php'); ?>


  </body>


</html>