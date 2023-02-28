<?php
	require_once('../_sys/init.php');
	$busca = trim(param('busca'));

	$busca2 = slugit( addslashes($_POST['busca']) );
	$especial = str_replace(" ", "%", $busca);
	
	$html = "";
	if(strlen($busca) > 0){
		$buscador = Productos::get("producto_status = 1 AND ( producto_nombre LIKE '%{$busca}%' OR producto_slugit LIKE '%{$busca2}%' OR marca_nombre LIKE '%{$busca}%' 
			OR producto_droga LIKE '%{$busca}%' OR CONCAT_WS(' ',marca_nombre, producto_nombre, producto_droga) LIKE '%{$busca}%' 
			OR CONCAT_WS(' ',producto_nombre, marca_nombre, producto_droga, producto_descripcion) LIKE '%{$especial}%' ) AND producto_precio > 0 AND producto_stock > 0"
			,"FIELD(producto_nombre, '{$busca}') ASC LIMIT 5");
			
		if(haveRows($buscador)){
			$html.= '<i id="closeSearch" onclick="cerrar()" class="fa fa-times-circle" aria-hidden="true"></i>';

			$html.='<ul id="resultados" style="clear:both;">';
			foreach ($buscador as $result) {
				$nombre = $result['producto_descripcion'];
				$slugit = $result['producto_slugit'];
				$droga = " - ".$result['producto_droga'];
				$html.= '<li><a href="producto/'.$slugit.'">'.$nombre.' '.$droga.' </a></li>';
			}
			$html.='</ul>';

		}else{
		    $html = '<i id="closeSearch" onclick="cerrar()" class="fa fa-times-circle" aria-hidden="true"></i>';
		}
	}else{
	    $html = '<i id="closeSearch" onclick="cerrar()" class="fa fa-times-circle" aria-hidden="true"></i>';
	}

	$result = array('status'=>'success','html'=>$html);
	print json_encode($result);
	exit;
	
?>