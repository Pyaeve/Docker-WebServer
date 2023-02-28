<!DOCTYPE html>
<html lang="es-ES" >
<head>
    <title>Farmacia y Perfumeria Catedral, #amamoscuidarte</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="http://localhost/catedral/productos" />
  <link rel="icon" href="assets/images/favorico.webp" type="image/x-icon"/>
  <link rel="shortcut icon" href="assets/images/favicon/1.png" type="image/x-icon"/>
  <meta name="description" content="Descuentos Exclusivos en Medicamentos nacionales e internacionales, variedad de articulos para el cuidado personal y la salud"/>
  <meta name="keywords" content="farmacia, farmacia catedral, farmacia y perfumeria catedral, medicamentos nacionaloes e importados, descuentos Exclusivos"/>
  <meta property="og:site_name" content="Farmacia y Perfumeria Catedral, #amamoscuidarte"/>
  <meta property="og:locale" content="es_PY"/>
  <meta property="og:title" content="Farmacia y Perfumeria Catedral, #amamoscuidarte"/>
  <meta property="og:description" content="Descuentos Exclusivos en Medicamentos nacionales e internacionales, variedad de articulos para el cuidadod personal y la saludad"/>
  <meta property="og:type" content="Article"/>                                                           
  <meta property="og:url" content="https://www.farmaciacatedral.com.py"/>
  <meta name="twitter:title" content="Farmacia y Perfumeria Catedral, #amamoscuidarte" />
  <meta name="twitter:description" content="Descuentos Exclusivos en Medicamentos nacionales e internacionales, variedad de articulos para el cuidado personal y la salud" />
  <meta name="twitter:site" content="Farmacia y Perfumeria Catedral, #amamoscuidarte" />
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/assets/css/fontawesome.css">
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/assets/css/animate.css">
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/assets/css/slick.css">
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/assets/css/slick-theme.css">
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/assets/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" id="color" href="<?php echo get_template_directory_uri();?>/assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" id="color" href="<?php echo get_template_directory_uri();?>/assets/css/ws.css">
  <link rel="stylesheet" type="text/css" id="color" href="<?php echo get_template_directory_uri();?>/assets/css/toastify.css">
  <link rel="stylesheet" type="text/css" id="color" href="<?php echo get_template_directory_uri();?>/assets/css/catedral.css">
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZHL120EZEP"></script>
  <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-ZHL120EZEP');
  </script>
  <script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "WebSite",
  "name": "Farmacia y Perfumeria Catedral",
  "url": "https://www.farmaciacatedral.com.py",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://www.farmaciacatedral.com.py/productos?busca={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
    <?php wp_head(); ?>
</head>
<body class="bg-white">

 <header class="header-1 fixed-top" style="background: #f1f1f1;">
        <div class="mobile-fix-header">
        </div>
         <div class="container">
             <div class="row header-content ">
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
                                                          <li class="onhover-div user-icon" onclick="OpenLoginModal()">
                                <img src="./assets/images/user.webp" alt="Farmacia y Perfumeria Catedral" class="user-img">
                                <i class="ti-user mobile-icon"></i>
                                <div class="wishlist icon-detail">
                                    <h6><a href="ingresar">Iniciar</a></h6>
                                </div>
                            </li>
                                                    </li>
                            <li class="onhover-div cart-icon" "><a href="mi-carrito">
                                <img src="./assets/images/shopping-cart.webp" alt="Farmaicia y Perfumeria Catedral" class="cart-image">
                                <i class="ti-shopping-cart mobile-icon"></i></a>
                                <div class="cart icon-detail">
                                    <h6 class="up-cls"><span class="cart-item-count itemCartTotal">0</span></h6>
                                   
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
                             
                          
                            
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /menu principal -->
</header><!-- header part end -->
<!-- home slider section start-->
<section class="full-slider">
  
    <div class="slide-1 home-slider slider-catedral">
         
            <div>
                <img src="https://www.farmaciacatedral.com.py/upload/banners/00877989_00093989_626BFBBDAF324_B.jpg" class="img img-responsive img-fluid d-lg-block center-cropped" alt="">
            </div>
             
            <div>
                <img src="https://www.farmaciacatedral.com.py/upload/banners/63519558_07746001_6192B991970D3_B.jpg" class="img img-responsive img-fluid d-lg-block center-cropped" alt="">
            </div>
             
            <div>
                <img src="https://farmaciacatedral.com.py/upload/banners/00728864_56593890_609C4640EA5F0_B.jpg" class="img img-responsive img-fluid d-lg-block center-cropped" alt="">
            </div>
             
            <div>
                <img src="https://www.farmaciacatedral.com.py/upload/banners/00488012_09401285_61A516E140879_B.jpg" class="img img-responsive img-fluid d-lg-block center-cropped" alt="">
            </div>
                    
    </div>
</section>