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
                        <a href="./"> <img src="./assets/images/farmacia-catedral-logo-2.png" height="50px" class="" alt=""></a>
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
                                    <img src="./assets/images/search.png" class=" img-fluid search-img" alt="">
                                </div>
                                <div id="search-overlay" class="search-overlay">
                                    <div>
                                        <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                                        <div class="overlay-content">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <form>
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
                                <img src="./assets/images/user.png" alt="" class="user-img">
                                <i class="ti-user mobile-icon"></i>
                                <div class="wishlist icon-detail">
                                    <h6 class="up-cls"><span>Mi Cuenta</span></h6>
                                    <h6><a href="#">Inicio/Registro</a></h6>
                                </div>
                            </li>
                            <li class="onhover-div cart-icon" onclick="openCart()">
                                <img src="./assets/images/shopping-cart.png" alt="" class="cart-image">
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
<div class="clearfix">
    <div class="row"></div><br><br><br><br><br><br><br>
</div>
<section class="cart-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table class="table cart-table table-responsive-xs striped-table">
                    <thead>
                    <tr class="table-head">
                        <th scope="col">image</th>
                        <th scope="col">product name</th>
                        <th scope="col">price</th>
                        <th scope="col">quantity</th>
                        <th scope="col">action</th>
                        <th scope="col">total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <a href="#"><img src="../assets/images/product/1.jpg" alt=""></a>
                        </td>
                        <td><a href="#">cotton shirt</a>
                            <div class="mobile-cart-content row">
                                <div class="col-xs-3">
                                    <div class="qty-box">
                                        <div class="input-group">
                                            <input type="text" name="quantity" class="form-control input-number" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <h2 class="td-color">$63.00</h2></div>
                                <div class="col-xs-3">
                                    <h2 class="td-color"><a href="#" class="icon"><i class="ti-close"></i></a></h2></div>
                            </div>
                        </td>
                        <td>
                            <h2>$63.00</h2></td>
                        <td>
                            <div class="qty-box">
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control input-number" value="1">
                                </div>
                            </div>
                        </td>
                        <td><a href="#" class="icon"><i class="ti-close"></i></a></td>
                        <td>
                            <h2 class="td-color">$4539.00</h2></td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr>
                        <td>
                            <a href="#"><img src="../assets/images/product/2.jpg" alt=""></a>
                        </td>
                        <td><a href="#">cotton shirt</a>
                            <div class="mobile-cart-content row">
                                <div class="col-xs-3">
                                    <div class="qty-box">
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control input-number" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <h2 class="td-color">$63.00</h2></div>
                                <div class="col-xs-3">
                                    <h2 class="td-color"><a href="#" class="icon"><i class="ti-close"></i></a></h2></div>
                            </div>
                        </td>
                        <td>
                            <h2>$63.00</h2></td>
                        <td>
                            <div class="qty-box">
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control input-number" value="1">
                                </div>
                            </div>
                        </td>
                        <td><a href="#" class="icon"><i class="ti-close"></i></a></td>
                        <td>
                            <h2 class="td-color">$4539.00</h2></td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr>
                        <td>
                            <a href="#"><img src="../assets/images/product/3.jpg" alt=""></a>
                        </td>
                        <td><a href="#">cotton shirt</a>
                            <div class="mobile-cart-content row">
                                <div class="col-xs-3">
                                    <div class="qty-box">
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control input-number" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <h2 class="td-color">$63.00</h2></div>
                                <div class="col-xs-3">
                                    <h2 class="td-color"><a href="#" class="icon"><i class="ti-close"></i></a></h2></div>
                            </div>
                        </td>
                        <td>
                            <h2>$63.00</h2></td>
                        <td>
                            <div class="qty-box">
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control input-number" value="1">
                                </div>
                            </div>
                        </td>
                        <td><a href="#" class="icon"><i class="ti-close"></i></a></td>
                        <td>
                            <h2 class="td-color">$4539.00</h2></td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr>
                        <td>
                            <a href="#"><img src="../assets/images/product/4.jpg" alt=""></a>
                        </td>
                        <td><a href="#">cotton shirt</a>
                            <div class="mobile-cart-content row">
                                <div class="col-xs-3">
                                    <div class="qty-box">
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control input-number" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <h2 class="td-color">$63.00</h2></div>
                                <div class="col-xs-3">
                                    <h2 class="td-color"><a href="#" class="icon"><i class="ti-close"></i></a></h2></div>
                            </div>
                        </td>
                        <td>
                            <h2>$63.00</h2></td>
                        <td>
                            <div class="qty-box">
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control input-number" value="1">
                                </div>
                            </div>
                        </td>
                        <td><a href="#" class="icon"><i class="ti-close"></i></a></td>
                        <td>
                            <h2 class="td-color">$4539.00</h2></td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr>
                        <td>
                            <a href="#"><img src="../assets/images/product/5.jpg" alt=""></a>
                        </td>
                        <td><a href="#">cotton shirt</a>
                            <div class="mobile-cart-content row">
                                <div class="col-xs-3">
                                    <div class="qty-box">
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control input-number" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <h2 class="td-color">$63.00</h2></div>
                                <div class="col-xs-3">
                                    <h2 class="td-color"><a href="#" class="icon"><i class="ti-close"></i></a></h2></div>
                            </div>
                        </td>
                        <td>
                            <h2>$63.00</h2></td>
                        <td>
                            <div class="qty-box">
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control input-number" value="1">
                                </div>
                            </div>
                        </td>
                        <td><a href="#" class="icon"><i class="ti-close"></i></a></td>
                        <td>
                            <h2 class="td-color">$4539.00</h2></td>
                    </tr>
                    </tbody>
                </table>
                <table class="table cart-table table-responsive-md">
                    <tfoot>
                    <tr>
                        <td>total price :</td>
                        <td>
                            <h2>$6935.00</h2></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row cart-buttons">
            <div class="col-6"><a href="#" class="btn btn-solid">continue shopping</a></div>
            <div class="col-6"><a href="#" class="btn btn-solid">check out</a></div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<? require_once('inc/footer.php'); ?>


