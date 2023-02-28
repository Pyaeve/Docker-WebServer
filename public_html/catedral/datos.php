<?php 
  include('inc/config.php');

  $order_id   = 165;

  #Si ya existe que no vuelva a refrescar y enviar los datos
  $pedidos_data = Contraentrega::select($order_id);
  if(haveRows($pedidos_data)){
    $detalles_data = Contraentrega_detalle::get("contraentrega_id = {$pedidos_data[0]['contraentrega_id']}");
    $cliente = Clientes::select(268);
                                        
                                        if(haveRows($detalles_data)):
                							$listado = '';
                							$total = 0;
                							$envio = 0;
                							$ws_articulos = "";
                							
                							foreach($detalles_data as $rs){
                								$detalle_precio   = number_format($rs['producto_precio'],0,'','.');
                								$precioXcantidad  = $rs['producto_precio']*$rs['detalle_cantidad'];
                								$detalle_subtotal = number_format($precioXcantidad,0,'','.');
                								$producto = Productos::select($rs['producto_id']);
                		
                                                $total += $precioXcantidad;
                								$listado.='<tr>
                		                          <td align="left">'.$producto[0]["producto_nombre"].'</td>
                		                          <td align="center">'.$producto[0]["producto_codigo"].'</td>
                		                          <td align="center">'.number_format($producto[0]['producto_precio'],0,"",".").'</td>
                		                          <td align="center">'.$rs['detalle_cantidad'].'</td>
                		                          <td align="right">Gs. '.number_format($precioXcantidad,0,"",".").'</td>
                		                      	</tr>';
                		                      	
                		                      	$ws_articulos.='{
                            	 					"Cantidad" : "'.$rs["detalle_cantidad"].'",
                            						"Cod_articulo" : "'.$producto[0]["producto_codigo"].'",
                            	 					"Precio" : "'.$producto[0]["producto_precio"].'"
                            	 				},'; 
                							}
                							#------ENVIO---FC------#
                                            $nombre =  explode(" ", $cliente[0]['cliente_nombre']);
                                            $apellido = explode(" ", $cliente[0]['cliente_apellido']);
                                            $ruc = $cliente[0]['cliente_ruc'];
                                            $ci = $cliente[0]['cliente_cedula'];
                                            $ws_articulos = substr($ws_articulos, 0, -1);
                                            //F = personaa fisica J = empresa
                                            $cliente_tipo = $cliente[0]['cliente_tipo'] == 1 ? "F" : "J";

                                            $tipo_entrega = $pedidos_data[0]['contraentrega_delivery'] == 1 ? "DELI" : "SUC" ;
                                            $fecha_entrega = $pedidos_data[0]['contraentrega_horario'];

                                            $sucursal_cod = 0;
                                            if($sucursal_id > 0){
                                                $sucursal_cod = Sucursales::select($pedidos_data[0]['sucursal_id']);
                                                $sucursal_cod = $sucursal_cod[0]['sucursal_codigo'];
                                            }

                                            $deposito = $sucursal_cod > 0 ? $sucursal_cod : 7;

                                            $direccion = $detalles_data[0]['cliente_direccion'];
                                            $celular = $detalles_data[0]['cliente_telefono'];

                							$dataWs = '{
                                        	 	"usuario" :"ECO",
                                        	 	"pass" :"@DMIN",
                                        	 		"pedidos" : {
                                        	 			"ArticulosItem" :['.$ws_articulos.'],
                                        	 			"Pedido":{
                                        					"CI" : "'.$ci.'",
                                        					"IdPedido": "'.$order_id.'",
                                        					"Primer_Apellido": "'.$apellido[0].'",
                                        					"Primer_Nombre": "'.$nombre[0].'",
                                        					"Ruc": "'.$ruc.'",
                                        					"Segundo_Apellido" : "'.$apellido[1].'",
                                        					"Segundo_Nombre" : "'.$nombre[1].'",
                                        					"Tipo" : "'.$cliente_tipo.'",
                                        					"Metodo_Pago" : "TARJ",
                                        					"Estado_Pago" : "PAG",
                                                            "Deposito" : "'.$deposito.'",
                                                            "Fecha_Entrega" : "'.$fecha_entrega.'",
                                                            "Direccion" : "'.$direccion.'",
                                                            "Tipo_Entrega" : "'.$tipo_entrega.'",
                                                            "Telefono" : "'.$celular.'"
                                        	 			}
                                        			}
                                        	}';
                                        	
                                            pr($dataWs);
/*
                                        
                                        	$session = curl_init($ecommerce_url);
                                        	curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
                                        	curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
                                        	curl_setopt($session, CURLOPT_POST,	true); 
                                        	curl_setopt($session, CURLOPT_POSTFIELDS, $dataWs); 
                                        	curl_setopt($session, CURLOPT_HEADER, false); 
                                        	curl_setopt($session, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
                                        	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                                        	$session_response = curl_exec($session);
                                        	curl_close($session);
                                            #Ver respuesta del sistema de Catedral
                                        	$response = json_decode($session_response);
                                        	
                */					
      


                					
        						        endif;
}

                          
                            ?>


