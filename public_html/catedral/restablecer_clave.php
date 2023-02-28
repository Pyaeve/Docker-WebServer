<?php
    require_once('inc/config.php');
?>
<!DOCTYPE html>
<html  >
<head>
  <? include("inc/head.php")?>   
  <title>Registro</title>
  <style>
    #result{width: 100%; margin-top: 10px;}
    .alert-danger{
        color: #b94a48;
        background-color: #f2dede;
        border-color: #ebccd1;
        width: 100%;
        margin: 21px 0;
    }
    .alert-success {
        color: #468847;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }
    #btn_reg{
        border-radius: 12px;
    }

    .btn-secondary {
        background-color: #6c757d !important;
        border-color: #6c757d !important;;
    }

    .btn-secondary:hover, .btn-secondary:focus, .btn-secondary.focus, .btn-secondary.active {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 20%);
    }
  </style>

</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
  
<section class="form7 cid-scEm75XVYS" id="form7-34">
    
    
    <div class="container">
        <div class="mbr-section-head">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0"><strong>RECUPERAR CONTRASEÑA</strong></h3>
           
        </div>
        <div class="row justify-content-center mt-4 col-lg-12">
            <div class="col-lg-12 mx-auto mbr-form" data-form-type="formoid">
                 <form method="post" id="recuperar2" accept-charset="utf-8">
                    <div class="md-form">
                        <input type="text" id="email_reset" name="email_reset" class="form-control validate mb-3" placeholder="E-mail" required>
                    </div>
                    <input type="hidden" name="token" id="token" value="<?=token('reset_password')?>">
                    <input type="hidden" name="accion" id="accion" value="recuperar">
                    <p id="msm" class="respuesta">
                        <b style="color: #0f3b84; font-weight: bold;">¿Olvidaste tu contraseña?</b><br>
                            Por favor, escribe el email con el que estás registrado y te enviaremos tu contraseña a tu correo.
                    </p>
                   <div style="margin:auto;">
                            <a href="javascript:;" class="btn btn-primary" id="btn_restar">Restablecer</a>
                   </div>
                </form>  


            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<?php
   include("inc/footer.php");
?>

<input name="animation" type="hidden">
<script type="text/javascript">
    $(document).ready(function(){
         $('#btn_restar').click(function(){
              $.ajax({
                  url : 'ajax/registro',
                  data: $('#recuperar2').serialize(),
                  type : 'post',
                  dataType : 'json',
                  success : function(data){
                    if(data.status == "success"){
                      $('input[name="email"]').val('');
                      swal("Restablecer contraseña", data.description , "success");
                      $(".respuesta").html(data.description);
                    }else{
                      swal("¡Atención!", data.description , "warning");
                    }
                  }
              });
              return false;
          });
    });

</script>
  </body>
</html>