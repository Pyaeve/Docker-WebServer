<?php
    require_once('inc/config.php');
?>
<!DOCTYPE html>
<html  >
<head>
    <? include("inc/head.php")?>
  <title>Misión y Vision</title>
  <style type="text/css">
      .cid-scEU5DahDi{
        background: #fff;
      }
      .cid-scEU5DahDi .mbr-section-title, .cid-scEU5DahDi .mbr-text{
        color: #000;
      }
      .cid-scEU5DahDi ul,.cid-scEU5DahDi ul li{ list-style-type: none; text-decoration:none; float: left; }
      .cid-scEU5DahDi ul li{
        margin: 0 20px;
      }
  </style>
  
  
</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 

<section class="image1 cid-scEU5DahDi" id="image1-40" style="">
    
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-12">
                <h2 class="mbr-section-title mbr-fonts-style"><strong>Medios de pago</strong></h2>
                <span class="linea"></span>
            </div>
            <div class="col-12 col-lg-12">
                <div class="text-wrapper">
                    <p class="mbr-text mbr-fonts-style">Te mostramos los medios de pago que tenemos para ti,</p>
                </div>
            </div>   
            <ul>
              <li><img src="images/master.jpg"></li>
              <li><img src="images/american.jpg"></li>
              <li><img src="images/visa.jpg"></li>

            </ul>


        </div>
    </div>
</section>


<!-- PRODUCTOS FOOTER -->
<? require_once('inc/footer.php'); ?>
    <input name="animation" type="hidden">
  </body>
</html>