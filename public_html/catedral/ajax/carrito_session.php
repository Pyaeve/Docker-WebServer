<?php 
	require_once('../_sys/init.php');
	#Al iniciar session verificar si el cliente cuenta con un carrito activo anterior
	if(Clientes::login()):
		$cliente_id = $_SESSION['cliente']['cliente_id'];
		$carrito = Carrito::get("cliente_id = ".$cliente_id);

		if(haveRows($carrito)){
			#Ya existe un carrito activo
			#Obtener el carrito_id activo
			$carrito_id = $carrito[0]['carrito_id']; 
			#Proceso para guardar los pedidos en el carrito
			if($_SESSION['carrito']){
    			foreach ($_SESSION['carrito'] as $session) {
    				$cantidad_select = $session['detalle_cantidad'] > 1 ? $session['detalle_cantidad'] : 1;
    				$_POST['carrito_id']			= $carrito_id;
    				$_POST['producto_id']			= $session['producto_id'];
    				$_POST['producto_nombre']		= $session['producto_nombre'];
    				$_POST['producto_precio']		= $session['producto_precio'];
    				$_POST['detalle_monto']			= 0;
    				$_POST['detalle_cantidad']		= $session['detalle_cantidad'];
    				$_POST['detalle_status']		= 1;
    				$detalle_id = Carrito_detalle::save(0);
    			}
			
			    unset($_SESSION['carrito']);#Borramos la session carrito
			}
		}else{
			#No existe carrito activo generamos uno nuevo
			$_POST['cliente_id'] = $cliente_id;
			$_POST['carrito_status'] = 1;
			$carrito_id = Carrito::save(0);
			if(is_array($carrito_id)):
				$result = array('status'=>'error','description'=>'Error al crear el carrito #1','type'=>'error');
				print json_encode($result);
				exit;
			endif;

			#Proceso para guardar el carrito detalle
			foreach ($_SESSION['carrito'] as $session) {
				$cantidad_select = $session['detalle_cantidad'] > 1 ? $session['detalle_cantidad'] : 1;
				$_POST['carrito_id']			= $carrito_id;
				$_POST['producto_id']			= $session['producto_id'];
				$_POST['producto_nombre']		= $session['producto_nombre'];
				$_POST['producto_precio']		= $session['producto_precio'];
				$_POST['detalle_monto']			= 0;
				$_POST['detalle_cantidad']		= $session['detalle_cantidad'];
				$_POST['detalle_status']		= 1;
				$detalle_id = Carrito_detalle::save(0);
			}
			unset($_SESSION['carrito']);#Borramos la session carrito
		}
	endif;
	unset($_SESSION['carrito']);#Borramos la session carrito
	header("Location:../index.php");
?>