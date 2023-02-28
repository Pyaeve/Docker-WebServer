<?php
clearBuffer();
$modulename	= "Zona ecommerce";
$zona_id	= numParam('id');
$title		= $zona_id > 0 ? "Modificar" : "Nuevo";
$data		= Zona_ecommerce::select($zona_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Zona_ecommerce::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['zona_status'] = $_POST['zona_status'] == NULL ? 1 : $_POST['zona_status'];
endif;
$callback	= array(
	"success"	=> "zona_ecommerce.view.php",
	"error"		=> "zona_ecommerce.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('zona_ecommerce&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('zona_ecommerce&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('zona_ecommerce&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="zona_ecommerce_form" name="zona_ecommerce_form" method="post" autocomplete="off" onsubmit="savedata('zona_ecommerce');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['zona_nombre']) ? " error" : "";?>">
					<label class="control-label" for="zona_nombre">Zona Ecommerce</label>
					<div class="controls">
						<input class="" id="zona_nombre" name="zona_nombre" value="<?php echo htmlspecialchars($_POST['zona_nombre']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['zona_nombre'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['zona_nombre'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['sucursal_id']) ? " error" : "";?>">
					<label class="control-label" for="sucursal_id">Sucursal</label>
					<div class="controls">
						<?	
							Sucursales::comboboxDelivery($_POST['sucursal_id']);	
						?>	
					</div>
				</div>
				<div class="control-group<?php echo isset($error['zona_mapa']) ? " error" : "";?>">
					<label class="control-label" for="zona_mapa">Mapa</label>
					<div class="controls">
						<div style="margin-bottom:5px;">
								                        <a class="btn-action glyphicons pin btn-primary" onclick="placeMarker();" title="Marcar ubicación"><i></i></a>
								                        <a class="divider"></a>
								                        <a class="btn-action glyphicons move btn-primary" onclick="" title="Mover"><i></i></a>
									                </div>
									                <div id="mapcanvas" style="width: 800px; height: 450px; margin-left:0; border:1px solid #ccc;"></div><br><br>
									                <input class="LatLng" id="zona_mapa" name="zona_mapa" value="<?php echo htmlspecialchars($_POST['zona_mapa']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['zona_mapa'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['zona_mapa'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['zona_status']) ? " error" : "";?>">
					<label class="control-label" for="zona_status">Activo</label>
					<div class="controls">
						<input class="" id="zona_status" name="zona_status" value="1" type="checkbox"<?php if($_POST['zona_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['zona_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['zona_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $zona_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Zona_ecommerce::save(".$zona_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('zona_ecommerce&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
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
