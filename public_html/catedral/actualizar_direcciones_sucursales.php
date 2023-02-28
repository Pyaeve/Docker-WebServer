<?php
require_once('inc/config.php');


function getDistanceBetweenPointsin($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Mi') {

  $theta = $longitude1 - $longitude2;
  $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
  $distance = acos($distance);
  $distance = rad2deg($distance);
  $distance = $distance * 60 * 1.1515; switch($unit) {
      case 'Mi': break; case 'Km' : $distance = $distance * 1.609344;
  }
  return (round($distance,2));

}  


$direcciones = Direcciones::get("","direccion_id desc");
if(haveRows($direcciones)){
  //TRUNCATE DE TABLA
  Direcciones_sucursales::truncate();
  foreach ($direcciones as $direccion) {
  
    $sucursales = Sucursales::get("sucursal_delivery IN (1) and sucursal_codigo is not null","sucursal_nombre ASC");
    if(haveRows($sucursales)){
      $sucursal_inicial = Sucursales::get("sucursal_delivery IN (1) AND sucursal_id = 1","sucursal_nombre ASC");
      $ltlni = explode(",", $sucursal_inicial[0]["sucursal_ubicacion"]);
      $latitudi = $ltlni[0];
      $longitudi = $ltlni[1];
      $ltlnc = explode(",", $direccion["direccion_mapa"]);
      $latitudc = $ltlnc[0];
      $longitudc = $ltlnc[1];
      $distancia_inicial = getDistanceBetweenPointsin($latitudc, $longitudc, $latitudi, $longitudi, 'km');
      $sucursal_cercana = $sucursal_inicial[0]["sucursal_id"];
      foreach ($sucursales as $sucursal) {
        $ltln = explode(",", $sucursal["sucursal_ubicacion"]);
        $latitud = $ltln[0];
        $longitud = $ltln[1];
        $distancia = getDistanceBetweenPointsin($latitudc, $longitudc, $latitud, $longitud, 'km');
        //echo "<b>SUCU: ".$sucursal["sucursal_nombre"]." D:$distancia DI:$distancia_inicial</b> <br>";
        //if($distancia < $distancia_inicial){
          
          $distancia_inicial = $distancia;
          $sucursal_cercana = $sucursal["sucursal_id"];
          $_POST['direccion_id'] = $direccion["direccion_id"];
          $_POST['sucursal_id'] = $sucursal["sucursal_id"];
          $_POST['distancia_km'] = $distancia_inicial;
          if($distancia <= 4){
            $save = Direcciones_sucursales::save($direccion_sucursal_id);
            if(!is_array($save)){
              echo "<b> datos guardados! </b> <br>";
              //echo "<h4>sucursal cercana: ".$sucursal["sucursal_nombre"]." distancia: $distancia</h4>";
            }else{
              $msg = $save[key($save)];
              $type = explode("_", key($save));
              echo "<b> $msg $type</b> <br>";
            };
          }

        //}
      }
      //$save = Direcciones_sucursales::save($direccion_sucursal_id);
      if(!is_array($save)){
        echo "<b> datos guardados! </b> <br>";
      }else{
        $msg = $save[key($save)];
        $type = explode("_", key($save));
        echo "<b> $msg $type</b> <br>";
      };
    }
    /*$direcciones_sucursales = Direcciones_sucursales::get("direccion_id = ".$direccion["direccion_id"],"");
    if(!haveRows($direcciones_sucursales)){
      $sucursal_inicial = Sucursales::get("sucursal_delivery IN (1) AND sucursal_id = 1","sucursal_nombre ASC");
      $ltlni = explode(",", $sucursal_inicial[0]["sucursal_ubicacion"]);
      $latitudi = $ltlni[0];
      $longitudi = $ltlni[1];
      $ltlnc = explode(",", $direccion["direccion_mapa"]);
      $latitudc = $ltlnc[0];
      $longitudc = $ltlnc[1];
      $distancia_inicial = getDistanceBetweenPointsin($latitudc, $longitudc, $latitudi, $longitudi, 'km');
      $sucursal_cercana = $sucursal_inicial[0]["sucursal_id"];
      $_POST['direccion_id'] = $direccion["direccion_id"];
      $_POST['sucursal_id'] = $sucursal_inicial[0]["sucursal_id"];
      $_POST['distancia_km'] = $distancia_inicial;
      $save = Direcciones_sucursales::save($direccion_sucursal_id);
      if(!is_array($save)){
        echo "<b> datos guardados! </b> <br>";
        //echo "<h4>sucursal cercana: ".$sucursal_inicial[0]["sucursal_nombre"]." distancia: $distancia_inicial</h4>";
      }else{
        $msg = $save[key($save)];
        $type = explode("_", key($save));
        echo "<b> $msg $type</b> <br>";
      };
    }*/

  }
}

//borrar direcciones duplicadas
Direcciones_sucursales::borrarduplicados();
/*$sucursales = Sucursales::get("sucursal_delivery IN (1,0)","sucursal_nombre ASC");
if(haveRows($sucursales)){
    $sucursal_inicial = Sucursales::get("sucursal_delivery IN (1) AND sucursal_id = 1","sucursal_nombre ASC");
    //echo "<h3>S: ".$sucursal_inicial[0]["sucursal_nombre"]."</h3>";
    $ltlni = explode(",", $sucursal_inicial[0]["sucursal_ubicacion"]);
    $latitudi = $ltlni[0];
    $longitudi = $ltlni[1];
    $distancia_inicial = getDistanceBetweenPointsin(-25.299880117804324, -57.59995438502885, $latitudi, $longitudi, 'km');
    $sucursal_cercana = $sucursal_inicial[0]["sucursal_nombre"];
    foreach ($sucursales as $sucursal) {

      $ltln = explode(",", $sucursal["sucursal_ubicacion"]);
      $latitud = $ltln[0];
      $longitud = $ltln[1];
      $distancia = getDistanceBetweenPointsin(-25.299880117804324, -57.59995438502885, $latitud, $longitud, 'km');
      if($distancia < $distancia_inicial){

        $distancia_inicial = $distancia;
        $sucursal_cercana = $sucursal["sucursal_nombre"];

      }
        echo '<option value="'.$sucursal["sucursal_id"].'">'.$sucursal["sucursal_nombre"].' lt: '.$latitud.' lg:'.$longitud.'</option>';

    }
}*/

          //$distancia = getDistanceBetweenPoints(-25.344584201990383, -57.58783172295127, -25.4969550,-54.6789670/*-25.285709873727896, -57.57395337626013*/, 'km');
          //echo "<h3>distancia: $distancia_inicial suc cercana: $sucursal_cercana </h3>";

    



?>