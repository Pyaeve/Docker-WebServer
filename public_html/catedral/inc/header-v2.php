 <header class="header-1 fixed-top" style="background: #fff;">
     <div class="d-none d-sm-none d-md-block catedral-notification-top" id="catedral-notification-top" style="background-color: #0e3b84;">

                <ul class="nav justify-content-end">

                    <li class="menu-item">
                        <a href="locales" style="color: #fff;"><i class="fa fa-home" aria-hidden="true"></i> Sucursales </a>&nbsp;|&nbsp;
                    </li>
                    <li class="menu-item">
                        <a href="tel:0216277000" class="" style="color: #fff;"><i class="fa fa-phone" aria-hidden="true"></i> (021) 627 7000 </a>&nbsp;|&nbsp;
                    </li>
                    <li class="menu-item">
                        <a class="" href="https://api.whatsapp.com/send?phone=595982927610&amp;text=Hola%21%20quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20la%20web." style="color: #fff;" target="_blank">
                          <i class="fa fa-brands fa-whatsapp" aria-hidden="true"></i> (0982) 927 610 
                        </a>&nbsp;
                    </li>
                </ul>

        </div>
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
                        <a href="./"> <img src="assets/images/catedral.webp" height="48px" c alt="Farmacia y Perfumeria Catedral"></a>
                    </div>
                    <div class="search-bar">
                        <form action="productos">
                           
                            <input name="busca" class="search__input" type="text" placeholder="Ej Finidol plus">    
                          

                            <button type="submit"  class="btn search-icon"  >
                        </form>
                    </div>
                    <div class="nav-icon">
                        <ul align="center" style="margin-left: 20px" class="text-center   " >
                           
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
                                                        <form>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Busque un Producto">
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
                              <?php  
                            if(!isset($_SESSION['cli_reg'])){ 
                        ?>
                            <li class="onhover-div user-icon" onclick="OpenLoginModal()">
                                <img src="./assets/images/user.webp" alt="Farmacia y Perfumeria Catedral" class="user-img">
                                <i class="ti-user mobile-icon"></i>
                                <div class="wishlist icon-detail">
                                    <h6><a href="ingresar">Iniciar</a></h6>
                                </div>
                            </li>
                        <?php } else{ ?>
                        <li class="onhover-div user-icon">
                                <ul class=" nav-dropdown" data-app-modern-menu="true">
                    <li class="nav-item dropdown"><img src="./assets/images/user.webp" alt="Farmacia y Perfumeria Catedral" class="user-img">
                                <i class="ti-user mobile-icon"></i>  <a class="btn btn-info-outline-success dropdown-toggle display-7" href="#" data-toggle="dropdown-submenu" aria-expanded="false">
                            <span class="fa-solid fa-circle-user"></span>&nbsp;&nbsp; <?php $nombre_cliente = Clientes::select($cliente_id); echo "Hola ".$nombre_cliente[0]['cliente_nombre'] ?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-black text-primary display-7" href="mi-cuenta/editar">
                                Mis Datos
                            </a>
                            <a class="dropdown-item text-black text-primary display-7" href="repite-pedidos">Repetir pedidos</a>
                            <a class="dropdown-item text-black text-primary display-7" href="mis-pedidos">Historial pedidos</a>
                            <?php //if($cliente_id == 11066 || $cliente_id == 1702){ ?>
                                        <a class="dropdown-item text-black text-primary display-7" href="tarjetas">Mis tarjetas</a>
                            <?php //} ?>                            
                            <a class="text-black dropdown-item text-primary display-7" href="comosecompra" aria-expanded="false">Como se compra</a>
                            <!--<a class="dropdown-item text-black text-primary display-7" onclick="signOut();" href="logout">Salir</a>-->
                            <a class="dropdown-item text-black text-primary display-7"  href="logout">Salir</a>
                            
                        </div></li> </ul><?php 

                        }?>
                            </li>
                            <li class="onhover-div cart-icon" "><a href="mi-carrito">
                                <img src="./assets/images/shopping-cart.webp" alt="Farmaicia y Perfumeria Catedral" class="cart-image">
                                <i class="ti-shopping-cart mobile-icon"></i></a>
                                <div class="cart icon-detail">
                                    <h6 class="up-cls"><span class="cart-item-count itemCartTotal"><?php echo $items_carrito; ?></span></h6>
                                   
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- menuu principal -->
    <div class="navbar-catedral">
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