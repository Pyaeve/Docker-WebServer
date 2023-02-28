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
  <?php include("inc/head.php")?>  
  <title>Catedral</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <script crossorigin="anonymous" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://vpos.infonet.com.py/checkout/javascript/dist/bancard-checkout-2.0.0.js"></script>
  
  <style>
      iframe{ height:500px;}
  </style>
 

</head>
<script type="application/javascript">
    styles = {
    "form-background-color": "#001b60",
    "button-background-color": "#4faed1",
    "button-text-color": "#fcfcfc",
    "button-border-color": "#dddddd",
    "input-background-color": "#fcfcfc",
    "input-text-color": "#111111",
    "input-placeholder-color": "#111111"
    };
    window.onload = function () {
      Bancard.Cards.createForm('iframe-container', '<?php echo $process_id;?>', styles);
    };
</script>

<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header>  
<!-- PRODUCTOS GALERIA -->
<section class="content1 cid-scEieb16NW" id="content1-2y" style="">


<div class="container">
    <div class="row">
            <div class="col-md-12 col-lg-12 mb-1 mt-3 ">
              <h1 style="text-align: center">Catastro de Tarjeta</h1>
              <p style="color:#b76500;font-size: x-small;font-weight: bold;">Estimado usuario, 
                  a continuación usted pasará por única vez por un proceso de 
                  validación con preguntas de seguridad. Para iniciar favor tener en 
                  cuenta las siguientes recomendaciones: <br>
                  1- Verifique su número de cédula de identidad <br>
                  2- Tenga a mano sus tarjetas de crédito y débito activas <br>
                  3- Verifique el monto y lugar de sus últimas compras en <br>
                  comercios o extracciones en cajeros</p>
            </div>
            <div class="col-md-12 col-lg-12 mb-4">
                  <!--<iframe src="https://vpos.infonet.com.py:8888/checkout/register_card/new?process_id=<?php //echo $process_id;?>" style="width: 100%; border-width: 0px; min-height: 328.938px;"></iframe>-->
                  <div style="height: 500px; width: 100%; margin: auto" id="iframe-container"> </div>
                  
                  
                              
            </div>
             <div class="col-auto mbr-section-btn align-center">
                    <a href="tarjetas" class="btn btn-primary display-4">Cancelar</a>
            </div>

    </div>
</div>
 
</section>

<!-- FOOTER -->
<?php require_once('inc/footer.php'); ?>


  </body>


</html>