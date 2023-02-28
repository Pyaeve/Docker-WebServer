

<?php if(isset($producto) && is_array($producto)): ?>
 <title><?=strtolower($producto['producto_nombre'])?></title>
<meta charset="UTF-8">
  <<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="assets/images/logo-farmacia-catedral-6-164x63.jpg" type="image/x-icon">
  <base href="https://<?php  echo $_SERVER['SERVER_NAME'].str_replace("index","",substr($_SERVER['SCRIPT_NAME'],0,-4));?>" />
  <meta name="description" content="<?=strtolower($producto['producto_descripcion'])?>"/>
  <meta name="keywords" content="<?=strtolower($producto['producto_nombre'])?>, <?=strtolower($producto['producto_tags'])?> "/>
  <meta property="og:site_name" content="Farmacia y Perfumeria Catedrale"/>
  <meta property="og:locale" content="es_PY"/>
  <meta property="og:title" content="<?=strtolower($producto['producto_nombre'])?>"/>
  <meta property="og:description" content="<?=strtolower($producto['producto_descripcion'])?>"/>
  <meta property="og:type" content="Article"/>                                                           
  <meta property="og:url" content="https://farmaciacatedral.com.py/producto/<?=strtolower($producto['producto_slugit'])?>"/>
  <meta name="twitter:title" content="<?=strtolower($producto['producto_nombre'])?>" />
  <meta name="twitter:description" content="<?=strtolower($producto['producto_descripcion'])?>" />
  <meta name="twitter:site" content="Farmacia y Perfumeria Catedral, #amamoscuidarte" />
 <meta property="article:publisher" content="https://facebook.com/FarmaciaCatedralPy/">
  <!-- Google+ / Schema.org -->
  <meta itemprop="name" content="<?=strtolower($producto['producto_nombre'])?>">
  <meta itemprop="headline" content="<?=strtolower($producto['producto_nombre'])?>">
  <meta itemprop="description" content="<?=strtolower($producto['producto_descripcion'])?>">
  <meta itemprop="image" content="<?php URL?>/assets/images/logo.jpg">
  <!-- Meta -->
   <meta name="author" content="Farmacia y perfumeria catedral">
  <meta name="google-signin-client_id" content="937983505293-ppv6ot4r3taacbqfn52d2tj5k0m8ofs2.apps.googleusercontent.com">
   <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
 
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="assets/animatecss/animate.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/socicon/css/styles.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css">
  <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
  <link rel="stylesheet" href="js/sweetalert/sweet-alert.css">
  <link rel="stylesheet" href="css/prog.css">
  <link rel="stylesheet" href="css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/floating-wpp.min.css">
  <link rel="stylesheet" href="css/toastify.css">
  <link rel="stylesheet" href="assets/css/select2.min.css">
 <!-- SLIDER -->
  <link href="css/ninja-slider.css" rel="stylesheet" />
  <script src="js/ninja-slider.js"></script>
  <link href="css/thumbnail-slider.css" rel="stylesheet" type="text/css" />
  <script src="js/thumbnail-slider.js" type="text/javascript"></script>

    <style type="text/css">
    .search-result{
      display: none;
    }
    #results {
      background-color: #fff/*#d7e6ff*//*#2b2b2b*/;
      color: #fff;
      position: fixed;
      max-height: 200px;
      min-height: 60px;
      overflow: scroll;
      width: 46%;
      z-index: 1000;
      padding: 9px 20px;
      font-size: 13px;
      right: 15%;
      border-radius: 10px;
    }
    #closeSearch {
        float: right;
        font-size: 14px;
        color: #0f3b84;
        z-index: 10001;
        top: -4px;
    }
    #closeSearch:hover {
      cursor: pointer;
      color: #E6E7E8;
    }
    #results>ul {
        list-style-type: none;
        padding: 0;
        margin:none; 
    }

    #resultados{ margin: 0; }

    #results>ul>li {
        color: /*#fff*/#0f3b84;
        /*border-top: 1px solid*/ /*#FFF*//*#0f3b84;*/
        padding: 5px 0;
    }
    
    #results>ul>li:hover {
        color: #000;
        border-top: 1px solid #d7e6ff;
        background: #d7e6ff;/*mouse*/
        padding: 5px 0;
    }
    .activesearch {
        color: #000;
        border-top: 1px solid #d7e6ff;
        background: #d7e6ff;
        padding: 5px 0;
    }
    #results>ul>li a {
        text-decoration: none;
        color: inherit;
        font-weight: 400;
    }
    .close{
      width: 10px; height: 10px;
    }

  @media screen and (max-width: 768px) {
    #results {
      width: 100%;
      right: 0%;
      top: 3%;
    }
.flexsearch--input{
  margin-top: 0px
}


  }


  /* width */
  ::-webkit-scrollbar {
      width: 10px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px grey;
      border-radius: 10px;
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
      background: #0e3b84;
      border-radius: 10px;
  }
 
        .cid-scEavRZm1L{ padding:0;}
        .owl-dots button:focus {
            outline:0px auto -webkit-focus-ring-color;
        }
        .ico-pr { right: 12px }
        .item.itemgal:hover {
            box-shadow:  0px 0px 15px 7px #8aa6dc;/*5px 5px 5px gray*/;
        }
        
          .navi{
            padding: 15px 0 0 0;
        }
        ul.slides{
            padding-top:100% !important;
        }
        .cid-scEieb16NW{
            padding-top:0;
        }

        @media screen and (max-width: 768px) {
            .nj{
               margin-left: 0px !important;
            }
            .mainpr{
                left: -21px;
            }
            #ninja-slider {
                width: 100%
            }
        }
        
        .cid-scEieb16NW{ padding-top: 0; }

        .splide__arrow--prev, .splide__arrow--next{
            display: none;
        }
        
        .icono-promo { right: 12px }
         
        .alert-danger{
            font-size: 12px;
            background: #ff0000;
            padding: 5px !important;
        }
.dropbtn {
  background-color: #3498DB;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #2980B9;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}


@media screen and (max-width: 680px) {
    #results {
      width: 100%;
      right: 0%;
      margin-top: 10px;
    }
.flexsearch--input{
  margin-top: -60px;
}


  }
.cid-scEavRZm1L{
margin-top:30px;
}

  </style>
  <script type="text/javascript">
    function cerrar(){
      $('.search-result').css("display", "none");
    }

  </script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZHL120EZEP"></script> -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-E5X1E3HJ31"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    //gtag('config', 'G-ZHL120EZEP');
    gtag('config', 'G-E5X1E3HJ31');
  </script>

<?php else: ?>
<title>Farmacia y Perfumeria Catedral, Amamos cuidaterte</title>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="assets/images/logo-farmacia-catedral-6-164x63.jpg" type="image/x-icon">
  <base href="https://<?php  echo $_SERVER['SERVER_NAME'].str_replace("index","",substr($_SERVER['SCRIPT_NAME'],0,-4));?>" />

  <meta property="og:locale" content="es_ES">
  <meta property="og:site_name" content="Farmacia y Perfumeria catedral">
  <meta property="og:title" content="Farmacia y Perfumeria Catedral">
  <meta property="og:url" content="<?php URL?>/assets/images/logo.jpg" >
  <meta property="og:type" content="article">
  <meta property="og:description" content="farmacia catedral, farmaceutico, farmacos, remedios, perfumes, perfumeria, compras">
  <meta property="og:image" content="<?php URL?>/assets/images/logo.jpg">
  <meta property="og:image:url" content="<?php URL?>/assets/images/logo.jpg">
  <meta property="og:image:width" content="1277">
  <meta property="og:image:height" content="721">
  <meta property="article:publisher" content="https://facebook.com/FarmaciaCatedralPy/">
  <!-- Google+ / Schema.org -->
  <meta itemprop="name" content="Farmacia y Perfumeria Catedral">
  <meta itemprop="headline" content="Farmacia y perfumeria catedral">
  <meta itemprop="description" content="Farmacia y Perfumeria Catedral, desde 1095 amamos cuidarte, somos lideres en medicamentos nacionanales e internacionales, servicios de atencion personalizada en sus 122 sucursales, hoy te espera tmabien en la su tienda de ecommerce">
  <meta itemprop="image" content="<?php URL?>/assets/images/logo.jpg">
  <!-- Twitter Cards -->
  <meta name="twitter:title" content="Farmacia y perfumeria catedral">
  <meta name="twitter:url" content="<?php URL.'/'.$seo_url?>">
  <meta name="twitter:description" content="<?php $seo_descripcion?>">
  <meta name="twitter:image" content="<?php URL?>/assets/images/logo.jpg">
  <meta name="twitter:card" content="summary_large_image">
  <!-- Meta -->
  <meta name="description" content="Farmacia y perfumeria catedral">
  <meta name="keywords" content="medicamentos, farmacia, ecommerce, teienda online, farmacia online, perfumeria, catedral, medicamefarmaceutico, farmacos, remedios, perfumes, perfumeria, compras">
  <meta name="author" content="Farmacia y perfumeria catedral">
  <meta name="google-signin-client_id" content="937983505293-ppv6ot4r3taacbqfn52d2tj5k0m8ofs2.apps.googleusercontent.com">
 <!-- Owl Stylesheets -->
   <link rel="stylesheet" href="assets/owlcarousel/assets/owl.carousel.min.css">
   <link rel="stylesheet" href="assets/owlcarousel/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
  <link rel="stylesheet" href="assets/tether/tether.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="assets/animatecss/animate.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/socicon/css/styles.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css">
  <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
  <link rel="stylesheet" href="js/sweetalert/sweet-alert.css">
  <link rel="stylesheet" href="css/prog.css">
  <link rel="stylesheet" href="css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/floating-wpp.min.css">
  <link rel="stylesheet" href="css/toastify.css">
  <link rel="stylesheet" href="assets/css/select2.min.css">
    <style type="text/css">
    .search-result{
      display: none;
    }
    #results {
      background-color: #fff/*#d7e6ff*//*#2b2b2b*/;
      color: #fff;
      position: fixed;
      max-height: 500px;
      min-height: 60px;
      overflow-y: auto;
      overflow-x: hidden;
      width: 46%;
      z-index: 1000;
      padding: 9px 20px;
      font-size: 13px;
      right: 15%;
      border-radius: 10px;
    }
    #closeSearch {
        float: right;
        font-size: 14px;
        color: #0f3b84;
        z-index: 10001;
        top: -4px;
    }
    #closeSearch:hover {
      cursor: pointer;
      color: #E6E7E8;
    }
    #results>ul {
        list-style-type: none;
        padding: 0;
        margin:none; 
    }

    #resultados{ margin: 0; }

    #results>ul>li {
        color: /*#fff*/#0f3b84;
        /*border-top: 1px solid*/ /*#FFF*//*#0f3b84;*/
        padding: 5px 0;
    }
    
    #results>ul>li:hover {
        color: #000;
        border-top: 1px solid #d7e6ff;
        background: #d7e6ff;/*mouse*/
        padding: 5px 0;
    }
    .activesearch {
        color: #000;
        border-top: 1px solid #d7e6ff;
        background: #d7e6ff;
        padding: 5px 0;
    }
    #results>ul>li a {
        text-decoration: none;
        color: inherit;
        font-weight: 400;
    }
    .close{
      width: 10px; height: 10px;
    }

  @media screen and (max-width: 768px) {
    #results {
      width: 100%;
      right: 0%;
      top: 3%;
    }

  }

  /* width */
  ::-webkit-scrollbar {
      width: 10px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px grey;
      border-radius: 10px;
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
      background: #0e3b84;
      border-radius: 10px;
  }
 
        .cid-scEavRZm1L{ padding:0;}
        .owl-dots button:focus {
            outline:0px auto -webkit-focus-ring-color;
        }
        .ico-pr { right: 12px }
        .item.itemgal:hover {
            box-shadow:  0px 0px 15px 7px #8aa6dc;/*5px 5px 5px gray*/;
        }
        
    .cid-scEavRZm1L{
margin-top:15px;
}
     
  </style>
  <script type="text/javascript">
    function cerrar(){
      $('.search-result').css("display", "none");
    }
@media screen and (max-width: 768px) {
    #results {
      width: 100%;
      right: 0%;
      margin-top: 10px;
    }
.flexsearch--input{
  margin-top: -60px
}


  }

  </script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZHL120EZEP"></script> -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-E5X1E3HJ31"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    //gtag('config', 'G-ZHL120EZEP');
    gtag('config', 'G-E5X1E3HJ31');
  </script>
<?php endif; ?>
