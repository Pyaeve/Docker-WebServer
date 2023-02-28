<?php
    require_once('inc/config.php');
?>
<!DOCTYPE html>
<html  >
<head>
<?php include("inc/head.php")?>
  
</head>
<body>
    <?php require_once('inc/header-v2.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>

<section class="content1 cid-scEieb16NW" id="content1-2y" style="">
    <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-12 text-center mt-3">
           <h3>Envíanos tus comentarios, dudas o sugerencias, te daremos retorno en la brevedad posible. ¡Gracias!</h3>
          </div>
          <div class="col-md-12 col-lg-12 text-center">
            <form method="post" class="mt-4" id="form-contact" accept-charset="utf-8">
              <div class="row">
                <!--  -->
                <div class="md-form mb-5 col-md-12 col-lg-6">
                  <label for="defaultForm-nombre">Nombre y Apellido <b>*</b></label>
                  <input type="text" id="nombre" name="nombre" autocomplete="off" class="form-control validate" required>
                  <span id="nombre-error" class="error"></span>
                </div>
                <div class="md-form mb-5 col-md-12 col-lg-6">
                  <label for="defaultForm-ci">C.I <b>*</b></label>
                  <input type="text" id="documento" name="documento" autocomplete="off" class="form-control validate" required>
                  <span id="documento-error" class="error"></span>
                </div>
                <!--  -->
                <div class="md-form mb-5 col-md-12 col-lg-6">
                  <label for="defaultForm-telefono">Teléfono <b>*</b></label>
                  <input type="text" id="telefono" name="telefono" autocomplete="off" class="form-control validate" required>
                  <span id="telefono-error" class="error"></span>

                </div>
                <div class="md-form mb-5 col-md-12 col-lg-6">
                  <label for="defaultForm-emailc">Correo <b>*</b></label>
                  <input type="text" id="emailc" name="emailc" autocomplete="off" class="form-control validate" required>
                  <span id="emailc-error" class="error"></span>
                </div>

                <!--  -->

                <div class="md-form mb-5 col-md-12 col-lg-12">
                  <label for="defaultForm-asunto">Asunto</label>
                  <select name="asunto" id="asunto" class="form-control">
                    <option>Consulta de productos, precios y promoción</option>
                    <option>Sugerencias</option>
                    <option>Reclamos de atención al Cliente</option>
                    <option>Felicitaciones</option>
                  </select>
                </div>

                <!--  -->
                 <div class="md-form mb-5 col-md-12 col-lg-12">
                  <label for="defaultForm-profesion">Mensaje</label>
                  <!-- <input type="text" id="profesion" name="profesion" autocomplete="off" class="form-control validate" required> -->
                  <textarea id="mensaje" name="mensaje" class="form-control validate"></textarea>
                </div>
                
                <div class="md-form mb-5 col-md-12 col-lg-4">
                   <a class="btn btn-primary"  id="btn_sendContact">Enviar</a>
                </div>
                <div class="md-form mb-5 col-md-12 col-lg-6">
                  <input type="hidden" name="token_contact" id="token_contact" value="<?=token('contactos')?>">
                </div>
              </div><!--- row -->

            <div class="md-form mb-4"></div>
          
            <span id="msm" ></span>
            </form>
          </div>

        </div>
    </div>
</section>
<!-- PRODUCTOS FOOTER -->
<?php require_once('inc/footer-v2.php'); ?>
   