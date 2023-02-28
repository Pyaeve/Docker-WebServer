<?php
	require_once('../_sys/init.php');
	$busca = trim(param('busca'));

	$busca2 = slugit( addslashes($_POST['busca']) );
	$especial = str_replace(" ", "%", $busca);
	
	$html = "";
	if(strlen($busca) > 0){
		$buscador = Productos::get("( producto_nombre LIKE '%{$busca}%' OR producto_slugit LIKE '%{$busca2}%' OR marca_nombre LIKE '%{$busca}%' 
			OR producto_droga LIKE '%{$busca}%' OR CONCAT_WS(' ',marca_nombre, producto_nombre, producto_droga) LIKE '%{$busca}%' 
			OR CONCAT_WS(' ',producto_nombre, marca_nombre, producto_droga, producto_descripcion) LIKE '%{$especial}%' 
			OR CONCAT_WS(' ',marca_nombre, producto_nombre, producto_droga, producto_codigo) LIKE '%{$busca}%') AND producto_precio > 0 AND producto_stock > 0"
			,"FIELD(producto_nombre, '{$busca}') ASC LIMIT 20");//ASC LIMIT 5 producto_codigo = LIKE '%{$busca}%'
			
		if(haveRows($buscador)){
			$html.= '<i id="closeSearch" onclick="cerrar()" class="fa fa-times-circle" aria-hidden="true"></i>';

			$html.='<ul id="resultados" style="clear:both;">';

			$sugeridos = Productos::get("( producto_nombre LIKE '%{$busca}%' AND marca_nombre LIKE '%CATEDRAL%' AND producto_precio > 0 AND producto_stock > 0)", "producto_nombre ASC LIMIT 10");

			if(haveRows($sugeridos)){

				foreach ($sugeridos as $suge){

					$nombre = $suge['marca_nombre']." - ".$suge['producto_nombre'];
					$slugit = $suge['producto_slugit'];
					//$droga = " - ".$result['producto_droga'];
					$droga = strlen($suge['producto_droga']) > 0 ? " - ".$suge['producto_droga'] : "";
					$img = Imagenes_productos::get("producto_id =".$suge['producto_id'],"imagen_id DESC LIMIT 1");
					$img = strlen($img[0]['imagen_image_big_url']) > 0 ? $img[0]['imagen_image_big_url'] : "images/sin-img.jpg";
					$html.= '<li class="busqueda"><table>
								<p style="color:#0f3b84;font-weight: bold;">SUGERIDO</p>
								<tbody>
									<tr>
										<td><img src='.$img.' style="width: 80px;margin-right: 10px;margin-left: 10px;" alt="'.$suge["producto_nombre"].'" title="'.$suge["producto_nombre"].'"></td>
										<td style="width: 100%;"><a href="producto/'.$slugit.'">'.$nombre.' '.$droga.' </a><br><a href="producto/'.$slugit.'">Gs: '.number_format( $suge['producto_precio']+$suge['producto_precioIVA'],0,"",".").'</a></td>
										<td><a href="producto/'.$slugit.'"><input id="btn_link" type="button" style="width: 0px;height:0px;border: none;" value="producto/'.$slugit.'" /></a></td>
									</tr>
								</tbody>
							</table>
							</li>';

				}

			}

			foreach ($buscador as $result) {
				//$nombre =$result['producto_descripcion'];
				$nombre = $result['marca_nombre']." - ".$result['producto_nombre'];
				$slugit = $result['producto_slugit'];
				//$droga = " - ".$result['producto_droga'];
				$droga = strlen($result['producto_droga']) > 0 ? " - ".$result['producto_droga'] : "";
				$img = Imagenes_productos::get("producto_id =".$result['producto_id'],"imagen_id DESC LIMIT 1");
                $img = strlen($img[0]['imagen_image_big_url']) > 0 ? $img[0]['imagen_image_big_url'] : "images/sin-img.jpg";
				$html.= '<li class="busqueda"><table>
				<tbody>
					<tr>
						<td><img src='.$img.' style="width: 80px;margin-right: 10px;margin-left: 10px;" alt="'.$result["producto_nombre"].'" title="'.$result["producto_nombre"].'"></td>
						<td style="width: 100%;"><a href="producto/'.$slugit.'">'.$nombre.' '.$droga.' </a><br><a href="producto/'.$slugit.'">Gs: '.number_format( $result['producto_precio']+$result['producto_precioIVA'],0,"",".").'</a></td>
						<td><a href="producto/'.$slugit.'"><input id="btn_link" type="button" style="width: 0px;height:0px;border: none;" value="producto/'.$slugit.'" /></a></td>
					</tr>
				</tbody>
			</table>
			</li>';
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