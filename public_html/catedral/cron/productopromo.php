<?php
require_once("/home/catedralpy/public_html/_sys/init.php");
#Productos en promocion activos que deben quitarse
$producto_activos = Productos::productopromo();
if(haveRows($producto_activos)){
    foreach ($producto_activos as $rs) {
        $status = Productos::set("producto_promostatus","0","producto_id = ".$rs['producto_id']);
        
    }
}
?>