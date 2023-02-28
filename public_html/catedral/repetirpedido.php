<?php
    require_once('inc/config.php');
?>
<!DOCTYPE html>
<html  >
<head>
  <? include("inc/head.php")?>
  <title>Repetir Pedidos</title>
  <style>
      .cid-scEyjqCodG{
        background: #fff;
         padding-top: 2rem;
      }
      ul li{color: #000; line-height:3;}

    .cid-scEyjqCodG .counter-container ul li::before {
        background-color: #0f3b84;
    }
  </style>
</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
<section class="content8 cid-scEyjqCodG" id="content8-3g" style="">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12">
                <h2 class="mbr-section-title mbr-fonts-style"><strong>Repetir pedidos</strong></h2>
                <span class="linea"></span>
            </div>
            <div class="counter-container col-md-12 col-lg-12">
                  
                    <p class="m-3">Para que tu compra sea más ágil y rápida tendrás la posibilidad de "Repetir pedidos".</p>

                    <p class="m-3">¿Como se realiza?</p>
                    <p class="m-3">¡Muy fácil!</p>

                    <ul>
                        <li>Seleccióná la opción de "Repetir pedidos"&nbsp;&nbsp;</li>
                        <li>Ingresa tu usuario y contraseña (si es que no te encuentras en línea).</li>
                        <li>Te aparecerán todas las compras que nombraste en la sección “Recordar mi compra”.</li>
                        <li>Selecciona la opción que quieras repetir.</li>
                        <li>Podes modificar o agregar más productos a tu carrito.</li>
                        <li>Confirma tu pedido, selecciona medio de pago y lugar de envío o bien la opción de retirar de tu sucursal favorita.</li>
                    </ul>
              
            </div>
        </div>
    </div>
</section>


<? require_once('inc/footer.php'); ?>

    <input name="animation" type="hidden">
  </body>
</html>