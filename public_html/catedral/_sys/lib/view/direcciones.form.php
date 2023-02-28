<?php
clearBuffer();
$modulename	= "Direcciones";
$direccion_id	= numParam('id');
$title		= $direccion_id > 0 ? "Modificar" : "Nuevo";
$data		= Direcciones::select($direccion_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Direcciones::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['direccion_status'] = $_POST['direccion_status'] == NULL ? 1 : $_POST['direccion_status'];
endif;
$callback	= array(
	"success"	=> "direcciones.view.php",
	"error"		=> "direcciones.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('direcciones&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons road" style="width:50% !important;"><i></i><a href="" onclick="module('direcciones&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('direcciones&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="direcciones_form" name="direcciones_form" method="post" autocomplete="off" onsubmit="savedata('direcciones');return!1;">
	<div class="well" style="padding-bottom: 20px;margin: 0;overflow-y: scroll;height: 700px;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $direccion_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Direcciones::save(".$direccion_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<!--<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('direcciones&page=<?php //echo pageNumber();?>');return!1;"><i></i>Cancelar</button>-->
		</div>	
				<?php 
					$cliente = Clientes::get("cliente_id = ".$_POST['cliente_id'],"");
					if(haveRows($cliente)){
						$cliente_campo = $list['cliente_id']." - ".$cliente[0]["cliente_nombre"].", ".$cliente[0]["cliente_apellido"]." - CI: ".$cliente[0]["cliente_cedula"];
					}
				?>
				<span style="margin-left: 35px;">Cliente <?php echo $cliente_campo; ?></span>	

				<div class="control-group<?php echo isset($error['sucursal_id']) ? " error" : "";?> " style="margin-top:10px;">
				
					<label class="control-label" for="sucursal_id">Sucursal</label>
					<div class="controls">
						<?php Sucursales::combobox($_POST['sucursal_id']);?>

						
						<?php
						if(isset($error['sucursal_id'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['sucursal_id'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['direccion_denominacion']) ? " error" : "";?>">
					<label class="control-label" for="direccion_denominacion">Denominacion</label>
					<div class="controls">
						<input class="" id="direccion_denominacion" name="direccion_denominacion" value="<?php echo utf8_encode($_POST['direccion_denominacion']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['direccion_denominacion'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['direccion_denominacion'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['direccion_ciudad']) ? " error" : "";?>">
					<label class="control-label" for="direccion_ciudad">Ciudad</label>
					<div class="controls">
						<input class="" id="direccion_ciudad" name="direccion_ciudad" value="<?php echo htmlspecialchars($_POST['direccion_ciudad']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['direccion_ciudad'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['direccion_ciudad'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['direccion_barrio']) ? " error" : "";?>">
					<label class="control-label" for="direccion_barrio">Barrio</label>
					<div class="controls">
						<input class="" id="direccion_barrio" name="direccion_barrio" value="<?php echo htmlspecialchars($_POST['direccion_barrio']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['direccion_barrio'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['direccion_barrio'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['direccion_tel']) ? " error" : "";?>">
					<label class="control-label" for="direccion_tel">Telefono</label>
					<div class="controls">
						<input class="" id="direccion_tel" name="direccion_tel" value="<?php echo htmlspecialchars($_POST['direccion_tel']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['direccion_tel'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['direccion_tel'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['direccion_direccion']) ? " error" : "";?>">
					<label class="control-label" for="direccion_direccion">Direccion</label>
					<div class="controls">
						<input class="" id="direccion_direccion" name="direccion_direccion" value="<?php echo htmlspecialchars($_POST['direccion_direccion']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['direccion_direccion'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['direccion_direccion'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['direccion_mapa']) ? " error" : "";?>">
					<label class="control-label" for="direccion_mapa">Mapa</label>
					<div class="controls">
						<div style="margin-bottom:5px;">
								                        <a class="btn-action glyphicons pin btn-primary" onclick="placeMarker();" title="Marcar ubicación"><i></i></a>
								                        <a class="divider"></a>
								                        <a class="btn-action glyphicons move btn-primary" onclick="" title="Mover"><i></i></a>
									                </div>
									                <div id="mapcanvas" style="width: 800px; height: 450px; margin-left:0; border:1px solid #ccc;"></div><br><br>
									                <input class="LatLng" id="direccion_mapa" name="direccion_mapa" value="<?php echo htmlspecialchars($_POST['direccion_mapa']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['direccion_mapa'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['direccion_mapa'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['direccion_status']) ? " error" : "";?>">
					<label class="control-label" for="direccion_status">Activo</label>
					<div class="controls">
						<input class="" id="direccion_status" name="direccion_status" value="1" type="checkbox"<?php if($_POST['direccion_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['direccion_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['direccion_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['direccion_predeterminado']) ? " error" : "";?>">
					<label class="control-label" for="direccion_predeterminado">Predeterminado</label>
					<div class="controls">
						<input class="" id="direccion_predeterminado" name="direccion_predeterminado" value="1" type="checkbox"<?php if($_POST['direccion_predeterminado'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['direccion_predeterminado'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['direccion_predeterminado'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<!--<div class="form-actions">
			<input type="hidden" name="id" value="<?php //echo $direccion_id;?>" />
			<input type="hidden" name="page" value="<?php //echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php //echo token("Direcciones::save(".$direccion_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php //echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('direcciones&page=<?php //echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>-->
	</div>
</form>

<script src="js/mapcore.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
	  
	});

	$(function(){
	    initmap();
	});
</script>
