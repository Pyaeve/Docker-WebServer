<?php
    require_once('inc/config.php');
    if(!isset($_SESSION['cli_reg'])){
        #Si no existe session redirecciona
        header("Location:productos");
        exit();
    }
    
    $process_id = addslashes($_GET['process_id']);
    if(empty($process_id)){
        header("Location:productos");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <? include("inc/head.php")?>  
  <title>Catedral</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <script crossorigin="anonymous" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://vpos.infonet.com.py/checkout/javascript/dist/bancard-checkout-3.0.0.js"></script>

  <style>
      iframe{ height:500px;}
  </style>
  <script type="text/javascript">
    window.onload = function () {
      Bancard.Zimple.createForm('iframe-container', '<?=$process_id?>');
    };
  </script>
</head>
<body>
 <? 
    require_once('inc/header.php'); 
    require_once('inc/nav.php'); 

?>
<!-- PRODUCTOS GALERIA -->
<section class="content1 cid-scEieb16NW" id="content1-2y">


<div class="container">
    <div class="row">
            <div class="col-md-12 col-lg-12 mb-1 mt-3 ">
                <h2 class="mbr-section-title mbr-fonts-style mb-0 text-center display-7"><strong>REALIZAR PAGO</strong></h2>
            </div>
            <div class="col-md-12 col-lg-12 mb-4">
                  <div style="height: 500px; width: 100%; margin: auto" id="iframe-container"/>
                              
            </div>

    </div>
</div>
 
</section>

<!-- FOOTER -->
<? require_once('inc/footer.php'); ?>


  </body>


</html>