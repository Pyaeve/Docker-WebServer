<?php
    require_once('inc/config.php');
?>
<!DOCTYPE html>
<html  >
<head>
<? include("inc/head.php")?>
  <title>Trabaja con Nosotos</title>
  <style type="text/css">
      #form-job .row div{
        text-align: initial;
        font-size: 14px;
      }
      #form-job .row div b{ color: red;}
      .error{ color: red; }
  </style>
  
</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
<section class="content1 cid-scEieb16NW" id="content1-2y" style="">
    <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-12 text-center mt-3">
           <h3>Forma parte de la familia Catedral, ¡Unite al equipo!</h3>
          </div>
          <div class="col-md-12 col-lg-12 text-center">
            <form method="post" class="mt-4" id="form-job" accept-charset="utf-8">
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
                <div class="md-form mb-5 col-md-12 col-lg-4">
                  <label for="defaultForm-edad">Edad</label>
                  <input type="text" id="edad" name="edad" autocomplete="off" class="form-control validate" required>

                </div>
                <div class="md-form mb-5 col-md-12 col-lg-4">
                  <label for="defaultForm-sexo">Sexo</label>
                  <select name="sexo" id="sexo" class="form-control">
                    <option>Femenino</option>
                    <option>Masculino</option>
                  </select>
                </div>
                <div class="md-form mb-5 col-md-12 col-lg-4">
                  <label for="defaultForm-fecha_nac">Fecha de Nacimiento<b>*</b></label>
                  <input type="date" class="form-control validate" name="fecha_nac" id="fecha_nac" autocomplete="off" required>

                </div>
                <!--  -->
                <div class="md-form mb-5 col-md-12 col-lg-4">
                  <label for="defaultForm-direccion">Direccion<b>*</b></label>
                  <input type="text" id="direccion" name="direccion" autocomplete="off" class="form-control validate" required>
                </div>
                <div class="md-form mb-5 col-md-12 col-lg-4">
                  <label for="defaultForm-barrio">Barrio</label>
                  <input type="text" id="barrio" name="barrio" autocomplete="off" class="form-control validate" required>
                </div>
                <div class="md-form mb-5 col-md-12 col-lg-4">
                  <label for="defaultForm-ciudad">Ciudad<b>*</b></label>
                  <input type="text" id="ciudad" name="ciudad" autocomplete="off" class="form-control validate" required>
                </div>
                <!--  -->
                <div class="md-form mb-5 col-md-12 col-lg-8">
                  <label for="defaultForm-lugar_nac">Lugar de Nacimiento</label>
                  <input type="text" id="lugar_nac" name="lugar_nac" autocomplete="off" class="form-control validate" required>
                </div>
                <div class="md-form mb-5 col-md-12 col-lg-4">
                  <label for="defaultForm-nacionalidad">Nacionalidad</label>
                  <input type="text" id="nacionalidad" name="nacionalidad" autocomplete="off" class="form-control validate" required>
                </div>
                <!--  -->
                 <div class="md-form mb-5 col-md-12 col-lg-12">
                  <label for="defaultForm-profesion">Profesión</label>
                  <input type="text" id="profesion" name="profesion" autocomplete="off" class="form-control validate" required>
                </div>
                
                <div class="col-12 col-lg-12 mt-5">
                  <label class="mbr-section-title mbr-fonts-style"><strong>Adjuntar Curriculum Vitae (.PDF)</strong></label>
                </div>

                <div class="md-form mb-5 col-md-12 col-lg-2">
                    <input type="file" name="laboral_file_name" id="laboral_file_name" />
                </div>
                <div class="md-form mb-5 col-md-12 col-lg-10">
                </div>

                <div class="md-form mb-5 col-md-12 col-lg-4">
                   <a class="btn btn-primary"  id="btn_sendCv">Enviar Curriculum Vitae</a>
                </div>
                <div class="md-form mb-5 col-md-12 col-lg-6">
                  <input type="hidden" name="token_cv" id="token_cv" value="<?=token('trabajeconnosotros')?>">
                </div>
              </div><!--- row -->

            <div class="md-form mb-4">
          
            <!-- <label  for="defaultForm-pass">Clave</label> -->
            </div>
          
            <span id="msm" ></span>
            </form>
          </div>
          <!--  <div class="col-md-12 col-lg-6">
             <label>Nombre y Apellido</label>
             <input type="" name="">
           </div>
           <div class="col-md-12 col-lg-6">
              <label>C.I.</label>
             <input type="" name="">

           </div> -->

        </div>
    </div>
</section>
<!-- PRODUCTOS FOOTER -->
<? require_once('inc/footer.php'); ?>
    <input name="animation" type="hidden">
  </body>
</html>