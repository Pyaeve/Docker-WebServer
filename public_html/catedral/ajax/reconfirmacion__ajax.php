<?php
require_once('../_sys/init.php');

$dataWs = $_POST['json'];
/*

 
        
          	$session = curl_init($ecommerce_url_cate);
          	curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
          	curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
          	curl_setopt($session, CURLOPT_POST,	true); 
          	curl_setopt($session, CURLOPT_POSTFIELDS, $dataWs); 
          	curl_setopt($session, CURLOPT_HEADER, false); 
          	curl_setopt($session, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
          	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
          	$session_response = curl_exec($session);
          	curl_close($session);
          	$response = json_decode($session_response);
            $salida   = $response->salida;
            //se vuelve a enviar al web service si web service no responde correcto
            if(trim($salida)<>"Correcto"){
              try{
                $session = curl_init($ecommerce_url_cate);
                curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($session, CURLOPT_POST,	true); 
                curl_setopt($session, CURLOPT_POSTFIELDS, $dataWs); 
                curl_setopt($session, CURLOPT_HEADER, false); 
                curl_setopt($session, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
                curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                $session_response = curl_exec($session);
                curl_close($session);
                $response = json_decode($session_response);
                $salida   = $response->salida;
                $cont= strlen($salida);
                
                if(trim($salida)<>"Correcto" || $cont < 1){
                  
                  $result = array("status"=>"error","description"=>'Error: '.$salida);
                  echo json_encode($result);
                  exit();

                }
              }catch(ParseError $p){
                
                $p->getMessage();
                $result = array("status"=>"error","description"=>'Error: '.$p);
                echo json_encode($result);
                exit();
              

              }
            }else{
              $result = array("status"=>"success","description"=>'Compra realizada!',"extra" => $response);
              echo json_encode($result);
              exit();
            }
*/
echo "<h3>hola mundo</h3>";
?>
