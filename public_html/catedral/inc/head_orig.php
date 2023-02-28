  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="assets/images/logo-farmacia-catedral-6-164x63.jpg" type="image/x-icon">
  <meta name="description" content="farmacia catedral, farmaceutico, farmacos, remedios, perfumes, perfumeria, compras ">
  <base href="https://<?php echo $_SERVER['SERVER_NAME'].str_replace("index","",substr($_SERVER['SCRIPT_NAME'],0,-4));?>" />

  <meta property="og:locale" content="es_ES">
  <meta property="og:site_name" content="Farmacia y perfumeria catedral">
  <meta property="og:title" content="Farmacia y perfumeria catedral">
  <meta property="og:url" content="<?=URL?>/assets/images/logo.jpg" >
  <meta property="og:type" content="article">
  <meta property="og:description" content="farmacia catedral, farmaceutico, farmacos, remedios, perfumes, perfumeria, compras">
  <meta property="og:image" content="<?=URL?>/assets/images/logo.jpg">
  <meta property="og:image:url" content="<?=URL?>/assets/images/logo.jpg">
  <meta property="og:image:width" content="1277">
  <meta property="og:image:height" content="721">
  <meta property="article:publisher" content="https://facebook.com/FarmaciaCatedralPy/">
  <!-- Google+ / Schema.org -->
  <meta itemprop="name" content="Farmacia Catedral">
  <meta itemprop="headline" content="Farmacia y perfumeria catedral">
  <meta itemprop="description" content="farmacia catedral, farmaceutico, farmacos, remedios, perfumes, perfumeria, compras">
  <meta itemprop="image" content="<?=URL?>/assets/images/logo.jpg">
  <!-- Twitter Cards -->
  <meta name="twitter:title" content="Farmacia y perfumeria catedral">
  <meta name="twitter:url" content="<?=URL.'/'.$seo_url?>">
  <meta name="twitter:description" content="<?=$seo_descripcion?>">
  <meta name="twitter:image" content="<?=URL?>/assets/images/logo.jpg">
  <meta name="twitter:card" content="summary_large_image">
  <!-- Meta -->
  <meta name="description" content="Farmacia y perfumeria catedral">
  <meta name="keywords" content="farmacia catedral, farmaceutico, farmacos, remedios, perfumes, perfumeria, compras">
  <meta name="author" content="Farmacia y perfumeria catedral">

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
  <link rel="stylesheet" href="css/font-awesome.min.css">

  <link rel="stylesheet" href="css/toastify.css">
    <style type="text/css">
    .search-result{
      display: none;
    }
    #results {
      background-color: #2b2b2b;
      color: #fff;
      position: fixed;
      max-height: 300px;
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
        color: #fff;
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
        color: #fff;
        border-top: 1px solid #FFF;
        padding: 5px 0;
    }
    
    #results>ul>li:hover {
        color: #000;
        border-top: 1px solid #FFF;
        background: #fff;
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
  </style>
  <script type="text/javascript">
    function cerrar(){
      $('.search-result').css("display", "none");
    }
  </script>