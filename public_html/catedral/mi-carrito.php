<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    require_once('inc/config.php');
    $recargar = 0;
    #Si inicia session
    if($cliente_id > 0){
        //actualización de precios de carrito
        $productos_actualizar = Carrito::getProductosActualizar($cliente_id);
        foreach ($productos_actualizar as $pr_ac){
            if(haveRows($pr_ac)){
                Carrito_detalle::set('producto_precio', $pr_ac["nuevo_precio"], 'detalle_id = '.$pr_ac["detalle_id"]);
                $recargar = 1;
            }
        }
        if($recargar == 1){
            header("Refresh:0");
        }
        

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
    if( strlen($datos_cliente[0]['cliente_apellido']) == NULL && $datos_cliente[0]['cliente_tipo'] == 1 ){
        $ok = false;
    }
    if( strlen($datos_cliente[0]['cliente_email']) == NULL){
        $ok = false;
    }
    if( strlen($datos_cliente[0]['cliente_telefono']) == NULL){
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
  <?php include("inc/head.php")?>  

</head>
<body class="bg-white">

    <!-- header part start -->
    <header class="header-1 fixed-top" style="background: #f1f1f1;">
        <div class="mobile-fix-header">
        </div>
         <div class="container">
             <div class="row header-content ">
             <!--<div class="col-lg-3 col-6">
                <div class="left-part">
                    <p>free shipping on order over $99</p>
                </div>
            </div>
            <div class="col-lg-9 col-6">
                <div class="right-part">
                    <ul>
                        <li><a href="#">today's deal</a></li>
                        <li><a href="#">gift cards</a></li>
                        <li><a href="#">track order</a></li>
                        <li><a href="#">free shipping</a></li>
                        <li><a href="#">free & easy return</a></li>
                        <li>
                            <div class="dropdown language">
                                <div class="select">
                                    <span>English</span>
                                </div>
                                <input type="hidden" name="language">
                                <ul class="dropdown-menu">
                                    <li id="English">English</li>
                                    <li id="French">French</li>
                                    <li id="Spanish">Spanish</li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown currency">
                                <div class="select">
                                    <span>USD</span>
                                </div>
                                <input type="hidden" name="currency">
                                <ul class="dropdown-menu">
                                    <li id="USD">USD</li>
                                    <li id="EUR">EUR</li>
                                    <li id="INR">INR</li>
                                    <li id="AUD">AUD</li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
           
            </div>
            -->
            </div>
            <div class="row header-content">
            <div class="col-12">
                <div class="header-section  ">
                    <!--   stiky menu    ---> 
                    <div class="brand-logo">
                        <a href="./"> <img src="./assets/images/catedral.webp" height="50px" class="" alt=""></a>
                    </div>
                    <div class="search-bar">
                        <form action="./productos">
                           
                            <input name="busca" class="search__input" type="text" placeholder="Ej Mentolina">    
                          

                            <button type="submit"  class="btn search-icon"  >
                        </form>
                    </div>
                    <div class="nav-icon">
                        <ul>
                           
                            <li class="onhover-div search-3">
                                <div onclick="openSearch()">
                                    <i class="ti-search mobile-icon-search" ></i>
                                    <img src="./assets/images/search.webp" class=" img-fluid search-img" alt="">
                                </div>
                                <div id="search-overlay" class="search-overlay">
                                    <div>
                                        <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                                        <div class="overlay-content">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <form action="./productos">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Search a Product">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                           
                            <li class="onhover-div user-icon" onclick="OpenLoginModal()">
                                <img src="./assets/images/user.webp" alt="" class="user-img">
                                <i class="ti-user mobile-icon"></i>
                                <div class="wishlist icon-detail">
                                    <h6 class="up-cls"><span>Mi Cuenta</span></h6>
                                    <h6><a href="#">Inicio/Registro</a></h6>
                                </div>
                            </li>
                            <li class="onhover-div cart-icon" onclick="openCart()">
                                <img src="./assets/images/shopping-cart.webp" alt="" class="cart-image">
                                <i class="ti-shopping-cart mobile-icon"></i>
                                <div class="cart icon-detail">
                                    <h6 class="up-cls"><span class="cart-item-count itemCartTotal"><?php echo $items_carrito; ?></span></h6>
                                    <h6><a href="#">Mi Carrito</a></h6>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
       </div>
        <!-- menuu principal -->
        <div class=" navbar-catedral">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav id="main-nav">
                        <div class="toggle-nav">
                            <i class="ti-menu-alt"></i>
                        </div>
                        <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                              <li>
                                <div class="mobile-back text-end">
                                    Cerrar<i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                                </div>
                            </li>
                            <li class="icon-cls">
                                <a href="./"><i class="fa fa-home home-icon" aria-hidden="true"></i>
                                </a>
                            </li>
                             <?php require_once('inc/navtop.php'); ?>
                          
                            
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        </div>
    <!-- /menu principal -->
    </header>
<? //pr($_SESSION['cliente']['cliente_id']); ?>
<!-- PRODUCTOS GALERIA -->
<br><br><Br><br>
<section >

<div class="container">
    <div class="row">
<!--             <div class="col-md-6 col-lg-3 mbr-text mbr-fonts-style mtb-3 display-7">
                <?php //require_once('inc/menu.php'); ?>
            </div> -->
<!--  -->

                <div class="col-md-6 col-lg-12">
                        <div class="row">
           
                            <div class="col-md-6 col-lg-6">
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
                        <div class="row">

                            
                                <table class="col-sm-12 table table-bordered table-striped table-condensed ">
                                    <thead class="">
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
                                                    $url = Productos::get('producto_id ='.$item["producto_id"],'');
                                                    $imagen = strlen($imagen[0]['imagen_image_big_url']) > 0 ? $imagen[0]['imagen_image_big_url'] : 'images/sin-img.jpg';
                                                    $subtotal = $item['producto_precio']*$item['detalle_cantidad'];
                                                    $productos = Productos::select($item['producto_id']);
                                                ?>
                                                <tr>
                                                    <td data-title="Producto"><a href="producto/<?php echo $url[0]["producto_slugit"]; ?>"><img src="<?php echo $imagen; ?>" style="width:100px" alt="Producto"></a></td>
                                                    <td>
                                                    <?php
                                                        if($_SESSION['producto_alert'][$key] > 0){
                                                            $producto = Productos::get("producto_codigo = ".$_SESSION['producto_alert'][$key]);
                                                            if(haveRows($producto)){
                                                                echo '<a href="producto/'.$url[0]["producto_slugit"].'"><del>'.$item["producto_nombre"].'</del></a><br><b class="alertpro">Stock insuficiente</b>';
                                                            }

                                                        }else{
                                                            echo '<a href="producto/'.$url[0]["producto_slugit"].'">'.$item["producto_nombre"].'</a>';
                                                        }
                                                        if( $productos[0]['producto_nivel'] != "VENTA LIBRE" ){
                                                            echo '<p class="receta alert-danger" role="alert"> Venta bajo receta</p>';
                                                        }
                                                    ?>
                                                    </td>
                                                    <!--<td><a href="#"><?php //echo $item['producto_nombre']; ?></a></td>-->
                                                    
                                                    <td class="col-md-1 col-lg-1" data-title="Cantidad">
                                                        <input type="number" value="<?php echo $item['detalle_cantidad']; ?>" onchange="update('<?php echo htmlspecialchars($item['detalle_id']); ?>');" id="cantidadproducto_<?php echo htmlspecialchars($item['detalle_id']); ?>" class="form-control count">
                                                    </td>
                                                    <td data-title="Precio Unit">
                                                        <?php 
                                                            //$iva = Productos::select($item["producto_id"]);
                                                            //$iva = $iva[0]['producto_precioIVA'];
                                                        echo number_format($item['producto_precio'],0,'','.'); ?></td>
                   
                                                    <td data-title="Total" ><?php echo number_format($subtotal,0,'','.'); ?></td>
                                                    <td class="center">
                                                        <a href="javascript:;" rel="<?php echo token("deleteitem_" . $item['detalle_id']);?>" class="btn btn-block btn-danger eliminar">
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
                                <div class="col-md-12 col-lg-12">
                                <div class="pull-left">
                                    <a href="productos" class="btn btn-solid btn-primary"><i class="fa fa-chevron-left"></i> Continuar comprando</a>
                                </div>
                                <div class="pull-right">
                                    <button class="btn btn-solid btn-primary" id="refresh"><i class="fa fa-refresh"></i> Actualizar carrito</button>
                                      
                                    <?php
                                    
                                    if($cliente_id > 0){
                                        if($ok){ ?>
                                            <a href="javascript:;"  id="checkout" class="btn btn-solid btn-primary">Finalizar compra <i class="fa fa-chevron-right ml-2"></i></a>
<?php
                                          }else{
                                            echo '<a href="mi-cuenta/editar">
                                            <div class="alert alert-danger" role="alert">
                                              Para continuar la compra debe actualizar sus datos
                                            </div></a>';
                                               

                                        }   
                                    }else{
                                        echo '<a href="javascript:;" data-toggle="modal" data-target="#loginSession" class="btn-finalizar-compra btn btn-solid btn-primary">Finalizar compra <i class="fa fa-chevron-right ml-2"></i></a>';
                                    }

                                    ?>
                                    <br><br>
                                </div>
                           
                            </div>
</div>
                </div>

    </div>
</div>
 
</section>

<!-- FOOTER -->
<?php require_once('inc/footer.php'); ?>


