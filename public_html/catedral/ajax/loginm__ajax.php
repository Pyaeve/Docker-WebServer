<?php
require_once("../_sys/init.php");

if(isset($_POST) && param("tokenlogin") == token("iniciosession")):

  if (!isValidEmail(trim(param("email")) )) {
    $result = array("status"=>"error","description"=>"Email o Clave incorrecto","type"=>"email");
  }else{

    $email = trim(param('email'));
    $clave = trim(param('clave1'));
    
    if(Login::setLogin($email,$clave)){

         $result = array("status"=>"success",'url' => baseURL, 'session' => "redireccion" );
    }else{
        $result = array("status"=>"error","description"=>"Email o Clave incorrecto","type"=>"email");
    }

  }

else:
  $result = array("status"=>"error","description"=>"Error de autenticaci��n","type"=>"email");
endif;
echo json_encode($result);
?>
