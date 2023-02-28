<?php
require_once('inc/config.php');
//require_once('../_sys/init.php');
// Muestra toda la información, por defecto INFO_ALL
//phpinfo();
 
  		  /*$dataWs = '{
            "usuario" :"TEST",
            "pass" :"TEST",
            "pedidos" : {
            "ArticulosItem" :[
            {
            "Cantidad" : "1",
            "Cod_articulo" : "81",
            "Precio" : "18866"
            },
            {
            "Cantidad" : "3",
            "Cod_articulo" : "3",
            "Precio" : "15000"
            }
            ],
            "Pedido":{
            "CI" : "3631719",
            "IdPedido": "255",
            "Primer_Apellido": "Francisco",
            "Primer_Nombre": "Bareiro",
            "Ruc": "3631719-5",
            "Segundo_Apellido" : "",
            "Segundo_Nombre" : "",
            "Tipo" : "J",
            "Metodo_Pago" : "CONT",
            "Estado_Pago" : "PEND",
            "Deposito" : "7",
            "Fecha_Entrega" : "02/05/15 07:00",
            "Direccion" : "Choferes del chaco c/ Enfermeras 185",
            "Tipo_Entrega" : "DELI",
            "Telefono" : "0981241217",
           "forma_pago" : "03"
            }
            }
           }';
        
           $e = "http://appcatedral.farmaciacatedral.com.py:8181/charliJavaEnvironment/rest/ECOMERCE";
          	$session = curl_init($e);
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
            echo "<h3>$salida</h3>";*/
            /*$PASS = md5("Dioses01" . "_" . strtoupper(strrev("francisco.britez@farmaciacatedral.com.py")));
            echo "<h3>$PASS</h3>";*/
            /*if (!filter_var("danielgaleano884@gmail.com", FILTER_VALIDATE_EMAIL)) {
              echo "<h1>Esta dirección IP (ip_a) es válida.</h1>";
              
            }else{
              echo "<h1>Esta dirección IP (ip_a) no es válida.</h1>";
            }*/

/*function getDistanceBetweenPointsin($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Mi') {

  $theta = $longitude1 - $longitude2;
  $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
  $distance = acos($distance);
  $distance = rad2deg($distance);
  $distance = $distance * 60 * 1.1515; switch($unit) {
      case 'Mi': break; case 'Km' : $distance = $distance * 1.609344;
  }
  return (round($distance,2));

}  */
/*$sucursales = Direcciones_sucursales::getjoin(6110);
if(haveRows($sucursales)){
  foreach ($sucursales as $sucursal) {

    echo "<h3>sucursal_id: ".$sucursal["sucursal_id"]."  distancia_km: ".$sucursal["distancia_km"]." </h3>";
    break;
  }// print_r($sucursales);
  
}*/
          /*$sucursales = Sucursales::get("sucursal_delivery IN (1,0)","sucursal_nombre ASC");
          if(haveRows($sucursales)){
              $sucursal_inicial = Sucursales::get("sucursal_delivery IN (1) AND sucursal_id = 1","sucursal_nombre ASC");
              //echo "<h3>S: ".$sucursal_inicial[0]["sucursal_nombre"]."</h3>";
              $ltlni = explode(",", $sucursal_inicial[0]["sucursal_ubicacion"]);
              $latitudi = $ltlni[0];
              $longitudi = $ltlni[1];
              $distancia_inicial = getDistanceBetweenPointsin(-25.477304854296, -57.658531532175644, $latitudi, $longitudi, 'km');
              $sucursal_cercana = $sucursal_inicial[0]["sucursal_nombre"];
              foreach ($sucursales as $sucursal) {
          
                  $ltln = explode(",", $sucursal["sucursal_ubicacion"]);
                  $latitud = $ltln[0];
                  $longitud = $ltln[1];
                  $distancia = getDistanceBetweenPointsin(-25.477304854296, -57.658531532175644, $latitud, $longitud, 'km');
                  if($distancia < $distancia_inicial){

                    $distancia_inicial = $distancia;
                    $sucursal_cercana = $sucursal["sucursal_nombre"];

                  }
                  echo '<option value="'.$sucursal["sucursal_id"].'">'.$sucursal["sucursal_nombre"].' lt: '.$latitud.' lg:'.$longitud.'</option>';

              }
          }

          
          echo "<h3>distancia: $distancia_inicial suc cercana: $sucursal_cercana </h3>";*/
#Si esta completo el campo pass actualizara la contraseña

  #Actualizar solo contraseña
  //$pass = md5("123456" . "_" . strtoupper(strrev("Monycabre05@gmail.com")));
  //echo "<h3>p:$pass</h3>";
  
  //$update = "UPDATE clientes SET cliente_clave = '{$pass}' WHERE cliente_id = {$cliente_id}";
  //db::execute($update);
  //$result = array('status'=>'success','description'=>'Los cambios se han guardado');


  //métodos de pago y línea de crédito
  /*$ws = listar_depositos(7, $listardepositos);
  #print_r($ws[0]->SDT_Listar_Depo->ATENCION_DELI);
  #$cant_pagos = count($ws[0]->SDT_Listar_Depo->ATENCION_DELI,1); 
  #$disponible = $ws[0]->clie_cred->DISPONIBLE;
  $a=$ws[0]->SDT_Listar_Depo[0]->ATENCION_DELI;
  $b=$ws[0]->SDT_Listar_Depo[0]->HORARIOS_DELI;
  #$b=$ws[0]->SDT_Listar_Depo->ATENCION_DELI;
  echo "<h1>".$a."</h1><br>";
  echo "<h1>".$b."</h1><br>"; */
  //print_r($ws);
 /* $result	= $obj->find("admins", "admin_email", "danielgaleano884@gmail.com", "admin_status = 1 AND admin_hidden = 0");
  print_r($result);*/

  /*$cliente = Clientes::get("cliente_id = 1702","");
  if(haveRows($cliente)){
    $_POST['cliente_id'] 		= $cliente[0]["cliente_id"];
    $_POST['cliente_cedula'] 	= $cliente[0]["cliente_cedula"];
    $_POST['cliente_ruc'] 		= $cliente[0]["cliente_ruc"];
    $_POST['cliente_nombre']	= $cliente[0]["cliente_nombre"];
    $_POST['cliente_apellido']  = $cliente[0]["cliente_apellido"];
    $_POST['sucursal_codigo']   = $sucursal_code;
    $_POST['producto_codigo']   = $producto_code;
    $_POST['cantidad'] 			= $cantidad;
    //guardado en tabla
    //$save = demandas_insatisfechas::save($demandas_insatisfechas_id);
    $demandas_insatisfechas = demandas_insatisfechas::save(0);
    print_r($demandas_insatisfechas);
    //echo "<h4>".$cliente[0]["cliente_cedula"]." ".$cliente[0]["cliente_nombre"]."</h4>";
  }*/

  /*$data = array(
		"mysql_id" => 900, 
    "cliente_cedula" => 4333650,
    "cliente_ruc" => "4333650",
    "cliente_nombre" => "Daniel",
    "cliente_apellido" => "Galeano",
    "depo_codigo" => 182,
    "prod_codigo" => 8906,
    "cantidad" => 1
    );*/
    $data = array( 
      "cliente_cedula" => 4333650,
      "cliente_ruc" => "4333650",
      "cliente_nombre" => "Daniel",
      "cliente_apellido" => "Galeano",
      "depo_codigo" => 182,
      "prod_codigo" => 8906,
      "cantidad" => 1
      //"DEPO_CODIGO" => "140"
      );
	//$session = curl_init("http://201.217.36.19:8584/ords/catedral/rest/demandas_insatisfechas/");
	//$session = curl_init("http://10.116.1.48:8080/ords/catedral/rest/demandas_insatisfechas/");
	//$session = curl_init("http://appcatedral.farmaciacatedral.com.py:8181/charliJavaEnvironment/rest/ListarDepositos");
	/*curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($session, CURLOPT_POST,	true); // usar HTTP POST
	curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($session, CURLOPT_HEADER, false); 
	curl_setopt($session, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	$session_response = curl_exec($session);
	curl_close($session);
  $response = json_decode($session_response);
  print_r($response);*/
  /*$dataWs = '{
		"mysql_id" => 900, 
    "cliente_cedula" => 4333650,
    "cliente_ruc" => "4333650",
    "cliente_nombre" => "Daniel",
    "cliente_apellido" => "Galeano",
    "depo_codigo" => 182,
    "prod_codigo" => 8906,
    "cantidad" => 1
  }';
  
  $session = curl_init("http://201.217.36.19:8584/ords/catedral/rest/demandas_insatisfechas/");
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
  print_r($response);

  echo "<h4>AAAAAA $response</h4>";*/

  //$verificar = Productos::val("*","producto_codigo = 13558","");
  //$sucursal_inicial = Sucursales::get("sucursal_delivery IN (1)","sucursal_nombre ASC");
  //echo "<h4>".$verificar[0]['producto_id']."</h4><br>";
  //print_r($sucursal_inicial);
  //pr($sucursal_inicial);
  //echo
  #Actualizar solo contraseña
  /*$pass = md5("123456" . "_" . strtoupper(strrev("Monycabre05@gmail.com")));
  echo "<h3>p:$pass</h3>";
  
  $update = "UPDATE clientes SET cliente_clave = '{$pass}' WHERE cliente_id = {$cliente_id}";
  db::execute($update);*/
  //$result = array('status'=>'success','description'=>'Los cambios se han guardado');
  //$totalPrecio  = Carrito_detalle::totalCosto(1702);
  //echo "<h4>$totalPrecio</h4>";
?>
<!--<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
</head>
<body>
  <select id="select-state" placeholder="Pick a state...">
    <option value="">Select a state...</option>
    <option value="AL">Alabama</option>
    <option value="AK">Alaska</option>
    <option value="AZ">Arizona</option>
    <option value="AR">Arkansas</option>
    <option value="CA">California</option>
    <option value="CO">Colorado</option>
    <option value="CT">Connecticut</option>
    <option value="DE">Delaware</option>
    <option value="DC">District of Columbia</option>
    <option value="FL">Florida</option>
    <option value="GA">Georgia</option>
    <option value="HI">Hawaii</option>
    <option value="ID">Idaho</option>
    <option value="IL">Illinois</option>
    <option value="IN">Indiana</option>
  </select>
</body>
<script>
    $(document).ready(function () {
        $('select').selectize({
            sortField: 'text'
        });
    });
</script>
</html>-->

<?php
/*$Hoy = Mysql::exec("SELECT date_format(now(),'%Y-%c-%d') AS HOY");//Mysql::sql("SELECT DAYOFWEEK('2022/03/31')");
$UltimoJueves = Mysql::exec("SELECT date_format(LAST_DAY(NOW()) - ((7 + WEEKDAY(LAST_DAY(NOW())) - 3) % 7),'%Y-%c-%d') AS JUEVES");
//print_r($Parametros);
//echo "<h4>".$Parametros[0]['DIA']."</h4>";
if($Hoy[0]['HOY'] == $UltimoJueves[0]['JUEVES']){
  echo "<h4>".$UltimoJueves[0]['JUEVES']."</h4>";
}*/
//$token = md5($private_key_staging . $pedido_id . $total_final . "PYG");
//$token_card = md5($private_key_staging . 1 . 3796 . "request_new_card");

/*$token_card = md5($private_key_staging . 3796 . "request_user_cards");
echo "<h4>".$token_card."</h4>";*/
/*$payment_response = Payment_response::response(11940);
if(is_array($payment_response)){

  $response = json_decode($payment_response['response_text']);
  $shop_process_id = $response->confirmation->shop_process_id;
  $amount = $response->confirmation->amount;
  $currency = $response->confirmation->currency;
  echo "<h4>".$shop_process_id."</h4>";
  echo "<h4>".$amount."</h4>";
  echo "<h4>".$currency."</h4>";

}*/
/*$a = "(5)";
$b = str_replace("(","",$a);
echo "<h4>$b</h4>";*/
#Datos para email
//$from = array("noreply@farmaciacatedral.com.py" => "Catedral");
/*$from = array("daniel.galeano@farmaciacatedral.com.py" => "Catedral");
$to = array("danielgaleano_1996@hotmail.com" => "Catedral");
if($_POST['contraentrega_delivery'] == 1){ #Para envio via delivery
  $data['local'] = '<tr><td><p style="margin-bottom: 0; font-size: 14px;"><b>Tipo de entrega:</b> </td><td>Delivery.</p></td></tr>';
  $sucursal_nombre = "TEST";
  $data['deposito'] = "<tr><td>Sucursal</td><td>".$sucursal_nombre."</td></tr>";    
  
  $template = "pedido_template.html";
  

}

$data['imagen'] = baseURL."images/logo-farmacia-catedral-6-164x63.jpg";



$data['costoenvio'] = 1000;
$data['subtotal'] =  10000;
$data['total'] =  1000;
$data['listado'] = $html;
$data["subject"] = "Detalles de la Compra";
$data["pedido"] =  1;

$subject = "Ecommerce - test";

Mail::send($from, $to, $subject, $template, $data);*/

$busca = "ALGODON";

$busca2 = slugit( addslashes($_POST['busca']) );
$especial = str_replace(" ", "%", $busca);

$buscador = "( producto_nombre LIKE '%{$busca}%' OR producto_slugit LIKE '%{$busca2}%' OR marca_nombre LIKE '%{$busca}%' 
			OR producto_droga LIKE '%{$busca}%' OR CONCAT_WS(' ',marca_nombre, producto_nombre, producto_droga) LIKE '%{$busca}%' 
			OR CONCAT_WS(' ',producto_nombre, marca_nombre, producto_droga, producto_descripcion) LIKE '%{$especial}%' 
			OR CONCAT_WS(' ',marca_nombre, producto_nombre, producto_droga, producto_codigo) LIKE '%{$busca}%') AND producto_precio > 0 AND producto_stock > 0";
echo $buscador;      

