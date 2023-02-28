<?php
clearBuffer();
$modulename	= "Pedidos";
$contraentrega_id	= numParam('id');
$title		= $contraentrega_id > 0 ? "Datos del cliente" : "";
if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Contraentrega::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['contraentrega_status'] = $_POST['contraentrega_status'] == NULL ? 1 : $_POST['contraentrega_status'];
endif;
$callback	= array(
	"success"	=> "contraentrega.view.php",
	"error"		=> "contraentrega.form.php"
);
if(!isset($_POST['cliente_id'])){
	
	$contraentrega = Contraentrega::getList("contraentrega_id = ".$contraentrega_id,"");
	if(haveRows($contraentrega)){
		
		foreach ($contraentrega as $pedido) {
			
			$clientes = Clientes::select($pedido["cliente_id"]);
			$cliente = $clientes[0];
			$direccion_id = strlen($_POST['direccion_id']) > 0 ? $_POST['direccion_id'] : $pedido["direccion_id"];
			if($pedido["contraentrega_formapago"]==2){
				$payment_response = Payment_response::get("pedido_id = ".$contraentrega_id,"");
				$response_json = json_encode($payment_response[0]['response_text'], true);
				$response_text = $payment_response[0]['response_text'];
			}
			$_POST['contraentrega_delivery'] = empty($_POST['contraentrega_delivery']) ? $pedido["contraentrega_delivery"] : $_POST['contraentrega_delivery'];
			$_POST['sucursal_id'] = empty($_POST['sucursal_id']) ? $pedido["sucursal_id"] : $_POST['sucursal_id'];
		}
	}
}else{
	
	$clientes = Clientes::select($_POST['cliente_id']);
	$cliente = $clientes[0];
	$direccion_id = $_POST['direccion_id'];
}

$direcciones = Direcciones::select($direccion_id);
//echo "<script>console.log('cliente ".$cliente."')</script>";

?>
<style type="text/css">
	input{width: 100%; }
</style>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('contraentrega&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons shopping_bag" style="width:50% !important;"><i></i><a href="" onclick="module('contraentrega&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('contraentrega&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="contraentrega_form" name="contraentrega_form" method="post" autocomplete="off" onsubmit="savedata('contraentrega');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['cliente_nombres']) ? " error" : "";?>">
					<label class="control-label" for="cliente_nombres">Nombres</label>
					<div class="controls">
						<input class="" id="cliente_nombres" name="cliente_nombres" value="<?php echo $cliente['cliente_nombre'];?>" type="text" style="color:#000;" disabled/>
				
					</div>
				</div>
	            <div class="control-group<?php echo isset($error['cliente_apellido']) ? " error" : "";?>">
					<label class="control-label" for="cliente_apellido">Apellidos</label>
					<div class="controls">
						<input class="" id="cliente_apellido" name="cliente_apellido" value="<?php echo $cliente['cliente_apellido'];?>" type="text" style="color:#000;" disabled/>

					</div>
				</div>
				<?
				    if($cliente['cliente_tipo'] == 1){
				?>
	            <div class="control-group<?php echo isset($error['cliente_cedula']) ? " error" : "";?>">
					<label class="control-label" for="cliente_cedula">C.I</label>
					<div class="controls">
						<input class="" id="cliente_cedula" name="cliente_cedula" value="<?php echo $cliente['cliente_cedula'];?>" type="text" style="color:#000;" disabled/>

					</div>
				</div>
				<?
				    }
				    if($cliente['cliente_tipo'] == 2){
				?>
				 <div class="control-group<?php echo isset($error['cliente_ruc']) ? " error" : "";?>">
					<label class="control-label" for="cliente_ruc">C.I</label>
					<div class="controls">
						<input class="" id="cliente_ruc" name="cliente_ruc" value="<?php echo $cliente['cliente_ruc'];?>" type="text" style="color:#000;" disabled/>

					</div>
				</div>
				<?
				    }
				?>
				 <div class="control-group<?php echo isset($error['cliente_telefono']) ? " error" : "";?>">
					<label class="control-label" for="cliente_telefono">Teléfono</label>
					<div class="controls">
						<input class="" id="cliente_telefono" name="cliente_telefono" value="<?php echo $direcciones[0]['direccion_tel'];?>" type="text" style="color:#000;" disabled/>

					</div>
				</div>
				<div class="control-group<?php echo isset($error['cliente_email']) ? " error" : "";?>">
					<label class="control-label" for="cliente_email">Correo</label>
					<div class="controls">
						<input class="" id="cliente_email" name="cliente_email" value="<?php echo $cliente['cliente_email'];?>" type="text" style="color:#000;" disabled/>

					</div>
				</div>
				

				<div class="control-group<?php echo isset($error['contraentrega_delivery']) ? " error" : "";?>">
					<label class="control-label" for="contraentrega_delivery">Tipo de entrega</label>
					<div class="controls">
						<!-- //Tipo 1 enviar a direccion Tipo 2 Retirar de sucursal -->
						<?php $metodo = $_POST['contraentrega_delivery'] == 1 ? "Delivery" : "Retirar de sucursal";  ?>
						<input class="" id="" name="" value="<?php echo $metodo;?>" type="text" style="color:#000;" disabled/>

					</div>
				</div>

				<?
				    
				?>
		
				<!---->
			    <?
			    if($_POST['contraentrega_delivery'] == 2){
			        $sucursal = Sucursales::select($_POST['sucursal_id']);  
			    }else{
			        $sucursal = Sucursales::select($direcciones[0]['sucursal_id']);
			    }
				?>
				<div class="control-group<?php echo isset($error['contraentrega_local']) ? " error" : "";?>">
					<label class="control-label" for="contraentrega_local">Codigo de local</label>
					<div class="controls">
						<input class="" id="" name="" value="<?php echo $sucursal[0]['sucursal_codigo'];?>" type="text" style="color:#000;" disabled/>
						
						<?php
						if(isset($error['contraentrega_local'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['contraentrega_local'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>
				<div class="control-group<?php echo isset($error['contraentrega_local']) ? " error" : "";?>">
					<label class="control-label" for="contraentrega_local">Local de entrega</label>
					<div class="controls">
						<input class="" id="" name="" value="<?php echo $sucursal[0]['sucursal_nombre'];?>" type="text" style="color:#000;" disabled/>
						
						<?php
						if(isset($error['contraentrega_local'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['contraentrega_local'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>
				<?
					
			    if($_POST['contraentrega_delivery'] == 1){
				?>
				<div class="control-group<?php echo isset($error['direccion_direccion']) ? " error" : "";?>">
					<label class="control-label" for="direccion_direccion">Dirección</label>
					<div class="controls">
						<input class="" id="direccion_direccion" name="direccion_direccion" value="<?php echo $direcciones[0]['direccion_direccion'];?>" type="text" style="color:#000;" disabled/>

					</div>
				</div>
				
			    <div class="control-group<?php echo isset($error['direccion_barrio']) ? " error" : "";?>">
					<label class="control-label" for="direccion_barrio">Barrio</label>
					<div class="controls">
						<input class="" id="direccion_barrio" name="direccion_barrio" value="<?php echo $direcciones[0]['direccion_barrio'];?>" type="text" style="color:#000;" disabled/>

					</div>
				</div>
				
				<div class="control-group<?php echo isset($error['direccion_ciudad']) ? " error" : "";?>">
					<label class="control-label" for="direccion_barrio">Ciudad</label>
					<div class="controls">
						<input class="" id="direccion_barrio" name="direccion_ciudad" value="<?php echo $direcciones[0]['direccion_ciudad'];?>" type="text" style="color:#000;" disabled/>

					</div>
				</div>
				
				<div class="control-group<?php echo isset($error['direccion_nrocasa']) ? " error" : "";?>">
					<label class="control-label" for="direccion_nrocasa">Nro Casa</label>
					<div class="controls">
						<input class="" id="direccion_nrocasa" name="direccion_nrocasa" value="<?php echo $direcciones[0]['direccion_nrocasa'];?>" type="text" style="color:#000;" disabled/>

					</div>
				</div>
				<?php } ?>
				
				<!---->
				<?php
					
			    if(isset($response_text)){
				?>
					<label class="control-label" for="response_text">Respuesta Bancard</label>
					<div class="controls">
						<textarea class="" id="response_text" name="response_text" type="text" style="color:#000;width: 105%;" rows="10" cols="30"> <?php echo $response_text;?> </textarea>

					</div>

				<?php } ?>
				
						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $contraentrega_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Contraentrega::save(".$contraentrega_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<!--<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>-->
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('contraentrega&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
