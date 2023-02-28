  <?php  include("inc/config.php")?>  
<!DOCTYPE html>
<html lang="es-ES" >
<head>
  <?php  include("inc/head.php")?>  
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
                        <a href="./"> <img src="./assets/images/farmacia-catedral-logo-2.webp" height="50px" class="" alt=""></a>
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
                                                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Escriba  el nombre del producto que quiera encontrar">
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
                                    <h6><a href="mi-carrito">Mi Carrito</a></h6>
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
<!-- header part end -->
<!-- breadcrumb start -->
<br><br>
<section class="breadcrumb-section section-b-space breadcrumb-catedral">
    <div class="container">
        <div class="row">
              <div class="col-md-6 col-lg-12 display-4 navi">
              <h2 class="text-center">Linea de Tiempo </h2>
             
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->
<div class="container">
<div class="main-timeline">

                        <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month">11 / Sep</span>
                                    <span class="year">1905</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                               
                                <p class="description">
                                    <br><br>
                                   El 11 de noviembre nace la “Botica y Droguería de la Catedral”, ubicada en Pte. Franco e Indep. Nacional, entre la Catedral de Asunción y el Mercado Guazú.
.
                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->

                        <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month"></span>
                                    <span class="year">1911</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                
                                <p class="description">
                                    <br><br>
                                    Se constituye la Razón Social Scavone Hnos. formada por Domingo, Miguel y Laviero Scavone.
.
                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->

                        <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            
                                    <span class="year">1917</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                               
                                <p class="description">
                                    <br><br>
                                  Comienza la expansión con la apertura de la “Droguería La Cruz Roja” en la esquina de 25 de Mayo y México.

                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->

                        <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month">2 Years</span>
                                    <span class="year">1920</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                
                                <p class="description">
                                    <br><br>Se consigue la importación de drogas, maquinarias y representación de marcas extranjeras para abastecer a todo el país adoptando un cariz de distribuidora.
                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->
                        <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month"></span>
                                    <span class="year">1928</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                
                                <p class="description">
                                    <br><br>Los incidentes que originaron la Guerra del Chaco dio inicio a la elaboración artesanal de los primeros productos de Catedral para ayudar a los soldados paraguayos. 

                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->
                        <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month">2 Years</span>
                                    <span class="year">1932</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                
                                <p class="description">
                                    <br><br>Comienza la fabricación en serie de los primeros productos como Gripasan, Diarrosan y Ferrocuprin.

                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->
                        <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month">2 Years</span>
                                    <span class="year">1934</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                
                                <p class="description">
                                    <br><br>Se inaugura la nueva Farmacia Catedral S.A. en su ubicación actual, Palma e Independencia Nacional.

                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->
                        <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month"></span>
                                    <span class="year">1959</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                
                                <p class="description">
                                    <br><br>Comienza la fabricación local de medicamentos en la esquina de Pte. Franco e independencia Nacional, detrás de la Farmacia de Centro.

                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->
                        <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month"></span>
                                    <span class="year">1965</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                
                                <p class="description">
                                    <br><br>Se inaugura la primera planta farmacéutica más importante de Paraguay, Laboratorios Catedral, en General Genes (Actualmente Av. España) y San Martín.

                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->
                        <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month"></span>
                                    <span class="year">2005</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                
                                <p class="description">
                                    <br><br>Se inaugura una Mega Sucursal en Villa Morra, pasando a convertirse en la primera farmacia y perfumería más grande del país.

                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->
                         <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month"></span>
                                    <span class="year">2009</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                
                                <p class="description">
                                    <br><br>Se da inicio a la construcción de la nueva planta industrial de Acceso Norte, principal proveedora de nuestros productos a nivel nacional e internacional.


                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->
                         <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month"></span>
                                    <span class="year">2014</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                
                                <p class="description">
                                    <br><br>Alcanzamos 33 sucursales habilitadas en toda la cadena, ubicadas en las ciudades aledañas a Asunción.


                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->
                         <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month"></span>
                                    <span class="year">2020</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                
                                <p class="description">
                                    <br><br>Seis años después, con mucho esfuerzo logramos llegar a 70 sucursales, en busca de la expansión hacia el interior del país.


                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->
                         <!-- start experience section-->
                        <div class="timeline">
                            <div class="icon"></div>
                            <div class="date-content">
                                <div class="date-outer">
                                    <span class="date">
                                            <span class="month"></span>
                                    <span class="year">2022</span>
                                    </span>
                                </div>
                            </div>
                            <div class="timeline-content">
                                
                                <p class="description">
                                    <br><br>Farmacias Catedral S.A., cuenta con más de 120 sucursales en todo el territorio nacional, y con la firme idea de seguir creciendo, aportando salud y bienestar a la población.


                                </p>
                            </div>
                        </div>
                        <!-- end experience section-->
                        

                    </div>
</div>

<?php
   include("inc/footer.php");
?>
