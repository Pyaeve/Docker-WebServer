<?php
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
    
	require_once('_sys/init.php');
    define("SITENAME", "Catedral S.A.");
    define("GRALKEYS", "");
    define("URL", substr_replace("https://" . $_SERVER['SERVER_NAME'] . str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']) ,"",-1) );

    define("FILENAME", basename($_SERVER['SCRIPT_NAME']));
 
    if(Clientes::login()):
        $cliente_id = $_SESSION['cliente']['cliente_id'];
        $items = Carrito_detalle::getItems($cliente_id);
    endif;

$totalPrecio  = Carrito_detalle::totalCosto($cliente_id);
#Si tiene la session iniciada devuelve los articulos del carrito activo
$totalItems   = Carrito_detalle::totalItems($cliente_id);


if(!haveRows($_SESSION['carrito'])){
    $items_carrito = $totalItems > '0' ? $totalItems  : "0";
}else{
    $items_carrito = $_SESSION['carrito']['articulos_total'] > '0' ? $_SESSION['carrito']['articulos_total']  : $totalItems;
}

?>