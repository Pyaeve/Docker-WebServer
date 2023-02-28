<?php
require_once('../_sys/init.php');

/*$id = $_GET['id'];
//$where = 
$datos = Contraentrega::get("contraentrega_id =".$id);
//print_r($datos);
//echo "<h3>".$datos[0]['body_raw']."</h3>";
$dataWs = $datos[0]['body_raw'];
#llamada a web service
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
echo "<h3> Resultado: ".$salida."</h3>";
echo '<a href="../backend/" class="btn-action glyphicons chevron-left btn-success"> ◀ Volver<i></i></a>';*/
//codigo nuevo
$pedido_id = numParam('id');
#Obtenemos los datos del cliente
$pedido_cabecera = Contraentrega::select($pedido_id);
$cliente_id = $pedido_cabecera[0]['cliente_id'];
$delivery = $pedido_cabecera[0]['contraentrega_delivery'];
#Si seleccino Contraentrega: opcion de pago Efectivo: 1 / POS: 2
//$Metodo_Pago = $pedido_cabecera['contraentrega_opcion'] == 2 ? "TARJ" : "CONT";
$direccion_id = $pedido_cabecera[0]['direccion_id'];
//echo "<h1>direccion_id: $pedido_cabecera</h1>";
//print_r($pedido_cabecera['direccion_id']);
#Si selecciono Contraentrega: opcion de pago Efectivo: 1 / POS: 2 / Cred: >=3

switch ($pedido_cabecera[0]['contraentrega_status']) { 
  case '2':
    $Estado_Pago = "PAG";
    $Metodo_Pago = $pedido_cabecera[0]['contraentrega_formapago'] == 2 ? "TARJ" : "CONT";
    //echo '<a href="" class="btn btn-primary"><i></i>Pendiente</a>';
  break;
  case '1':
      //echo '<a href="" class="btn btn-success"><i></i>Pagado</a>';
      $Estado_Pago = "PEND";  
      $Metodo_Pago = $pedido_cabecera[0]['contraentrega_formapago'] == 2 ? "TARJ" : "CONT";
  break;
}
/*if($pedido_cabecera[0]['contraentrega_opcion'] >= 3){
  $Metodo_Pago = "CRED"; 
  $Estado_Pago = "PAG";
  $Forma_Pago = $pedido_cabecera[0]['contraentrega_opcion'];
}else{
  $Metodo_Pago = $pedido_cabecera[0]['contraentrega_opcion'] == 2 ? "TARJ" : "CONT";
  $Estado_Pago = "PEND";
  $Forma_Pago = 0;
}*/

$items = Contraentrega_detalle::getItemsReenvio($pedido_id);
$html=" ";
$ws_articulos = "";
if(haveRows($items)){
    foreach ($items as $item):
        //print_r($item); //cd.detalle_cantidad ,pr.producto_codigo, pr.producto_precio
        $ws_articulos.='{
          "Cantidad" : "'.$item["detalle_cantidad"].'",
         "Cod_articulo" : "'.$item["producto_codigo"].'",
          "Precio" : "'.$item["producto_precio"].'"
        },'; 
            
    endforeach;
    
    #------DATOS DE ENVIO FARMACIA CATEDRAL------#
    #Obtenemos los datos del cliente
    $cliente = Clientes::select($cliente_id);

    $nombre =  explode(" ", $cliente[0]['cliente_nombre']);
    $apellido = explode(" ", $cliente[0]['cliente_apellido']);
    $ruc = $cliente[0]['cliente_ruc'];
    $ci = $cliente[0]['cliente_cedula'];
    //F = personaa fisica J = empresa
    $cliente_tipo = $cliente[0]['cliente_tipo'] == 1 ? "F" : "J";
    
    $ws_articulos = substr($ws_articulos, 0, -1);
           
    $tipo_entrega = $delivery == 1 ? "DELI" : "SUC" ; 

    if($direccion_id > 0){
        $direcciones = Direcciones::select($direccion_id);
        $denominacion =  $direcciones[0]['direccion_denominacion'];
        $direccion_ciudad = $direcciones[0]['direccion_ciudad'];
        $nrocasa = strlen($direcciones[0]['direccion_nrocasa']) > 0 ? " nro".$direcciones[0]['direccion_nrocasa'] : "";
        $direccion = $direcciones[0]['direccion_direccion'].$nrocasa;
        $celular = $direcciones[0]['direccion_tel'];
        $sucursal_id = $direcciones[0]['sucursal_id'];
        $mapa = explode(",", $direcciones[0]['direccion_mapa']);
        $latitud = $mapa[0];
        $longitud = $mapa[1];
        $localizacion = $direcciones[0]['direccion_mapa'].", ".$direccion_ciudad;
    }
    //////////////////////////////////
    if($sucursal_id > 0){
      $sucursal = Sucursales::select($sucursal_id);
      //$_POST['sucursal_id'] = $sucursal[0]['sucursal_id'];
      $sucursal_codigo = $sucursal[0]['sucursal_codigo'];
      
      $ciudad = Ciudad::select($sucursal[0]['ciudad_id']);
      if(haveRows($ciudad)){
          $costoenvio = 0;//$ciudad[0]['costo_envio'];
      }else{
          $costoenvio = 0;//'6000';
      }
      
    }
    $hora_entrega = date('d/m/Y H:i');
    $deposito = $sucursal_codigo > 0 ? $sucursal_codigo : 7;
    /////////////////////////////////
    if($delivery == 1){
      $porcentajes = $costoenvio * 10 / 100;
      $deliveryWs = 0;//$costoenvio - $porcentajes;
      $ws_articulos.=',{
        "Cantidad" : "1",
        "Cod_articulo" : "42593",
        "Precio" : "'.$deliveryWs.'"
      }';
    }
        $dataWs = '{
           "usuario" :"ECO",
           "pass" :"@DMIN",
               "pedidos" : {
                   "ArticulosItem" :['.$ws_articulos.'],
                   "Pedido":{
                      "CI" : "'.$ci.'",
                      "IdPedido": "'.$pedido_id.'",
                      "Primer_Apellido": "'.$apellido[0].'",
                      "Primer_Nombre": "'.$nombre[0].'",
                      "Ruc": "'.$ruc.'",
                      "Segundo_Apellido" : "'.$apellido[1].'",
                      "Segundo_Nombre" : "'.$nombre[1].'",
                      "Tipo" : "'.$cliente_tipo.'",
                      "Metodo_Pago" : "'.$Metodo_Pago.'",
                      "Estado_Pago" : "'.$Estado_Pago.'",
            "Deposito" : "'.$deposito.'",
            "Fecha_Entrega" : "'.$hora_entrega.'",
            "Direccion" : "'.$direccion.'",
            "Tipo_Entrega" : "'.$tipo_entrega.'",
            "Telefono" : "'.$celular.'",
            "Nombre_Direccion" : "'.$denominacion.'",
            "Localizacion" : "'.$localizacion.'",
            "latitud" : "'.$latitud.'",
            "longitud" : "'.$longitud.'",            
            "ciudad"    :   "'.$direccion_ciudad.'",
            "forma_pago" : "'.$Forma_Pago.'",
            "comentario" : "",
            "regalo"    :   "N"
                   }
              }
      }';
    
    //if($cliente[0]['cliente_id'] != 5){
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
    //}
    echo "<h3> Resultado: ".$salida."</h3>";
    echo '<a href="../backend/" class="btn-action glyphicons chevron-left btn-success"> ◀ Volver<i></i></a>';

      
}
?>
