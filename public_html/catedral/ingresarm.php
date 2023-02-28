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
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0"><strong>INICIAR SESIÓN</strong></h3>
           
        </div>
        <div class="row justify-content-center mt-4 col-lg-12">
            <div class="col-lg-12 mx-auto mbr-form" data-form-type="formoid">
                <form method="post" id="loginForm2" accept-charset="utf-8">
                   <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="name">
                            <!--  -->
                       
                            <div class="dragArea row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group" data-for="name">
                                    <label style="font-size:13px;">E-mail</label>
                                    <input type="text" id="email" name="email" autocomplete="off" class="form-control validate" required>
                                </div>   
                            </div>
                            <div data-for="phone" class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <label style="font-size:13px;">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" id="clave1" name="clave1" autocomplete="off" class="form-control validate" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                                    <span class="input-group-btn">
                                        <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarContrasena()"> 
                                            <span id="span_eye" class="fa fa-eye icon"></span>
                                        </button>
                                    </span>
                                    <input type="hidden" id="clave" name="clave" autocomplete="off" class="form-control validate" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                                </div>
                            </div>
                            <input type="hidden" name="tokenlogin" id="tokenlogin" value="<?=token('iniciosession')?>">
                            <!--  -->
                        </div>


                        <div class="col-auto mbr-section-btn align-center">
                            
                            <a class="btn btn-primary" id="btn_ingresar2">Ingresar</a>
                         
                        </div>
                         
                         <div class="col-lg-12 col-md-12 col-sm-12 mt-4" style="margin:auto;">
                            <a href="restablecer_clave">¿Has olvidado tu contraseña?</a></p> 
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 modal-footer" style="margin:auto;">
                            <p class="w-100 text-center"><a href="registro" >Si aún no está registrado click aquí</a></p>
                        </div>

                    
                        <div id="result"></div>
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
        
        $('#btn_ingresar2').click(function(){

              document.getElementById("clave").value = document.getElementById("clave1").value;

              $.ajax({
                  url : 'ajax/loginm',
                  data: $('#loginForm2').serialize(),
                  type : 'post',
                  dataType : 'json',
                  success : function(data){
                    if(data.status=="success"){
                       window.location.href = "ajax/carrito_session.php";
                    }else{
                      $("#"+data.type).focus();
                       swal("¡Error!", data.description, "warning");
                    }
                  }
              });
              return false;
        });
    });

    function mostrarContrasena(){
      var tipo = document.getElementById("clave1");
      if(tipo.type == "password"){
          tipo.type = "text";
          document.getElementById("span_eye").className = "fa fa-eye-slash icon";
      }else{
          tipo.type = "password";
          document.getElementById("span_eye").className = "fa fa-eye icon";
      }
    }

</script>
  </body>
</html>