<?php
clearBuffer();
$modulename	= "Carrito_detalle";
$detalle_id	= numParam('id');
$title		= $detalle_id > 0 ? "Modificar" : "Nuevo";
$data		= Carrito_detalle::select($detalle_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Carrito_detalle::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['detalle_status'] = $_POST['detalle_status'] == NULL ? 1 : $_POST['detalle_status'];
endif;
$callback	= array(
	"success"	=> "carrito_detalle.view.php",
	"error"		=> "carrito_detalle.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('carrito_detalle&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('carrito_detalle&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('carrito_detalle&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="carrito_detalle_form" name="carrito_detalle_form" method="post" autocomplete="off" onsubmit="savedata('carrito_detalle');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['carrito_id']) ? " error" : "";?>">
					<label class="control-label" for="carrito_id">carrito_id</label>
					<div class="controls">
						<input class="" id="carrito_id" name="carrito_id" value="<?php echo htmlspecialchars($_POST['carrito_id']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['carrito_id'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['carrito_id'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['producto_id']) ? " error" : "";?>">
					<label class="control-label" for="producto_id">producto_id</label>
					<div class="controls">
						<input class="" id="producto_id" name="producto_id" value="<?php echo htmlspecialchars($_POST['producto_id']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['producto_id'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['producto_id'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['producto_nombre']) ? " error" : "";?>">
					<label class="control-label" for="producto_nombre">producto_nombre</label>
					<div class="controls">
						<input class="" id="producto_nombre" name="producto_nombre" value="<?php echo htmlspecialchars($_POST['producto_nombre']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['producto_nombre'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['producto_nombre'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['producto_precio']) ? " error" : "";?>">
					<label class="control-label" for="producto_precio">producto_precio</label>
					<div class="controls">
						<input class="" id="producto_precio" name="producto_precio" value="<?php echo htmlspecialchars($_POST['producto_precio']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['producto_precio'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['producto_precio'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['detalle_monto']) ? " error" : "";?>">
					<label class="control-label" for="detalle_monto">detalle_monto</label>
					<div class="controls">
						<input class="" id="detalle_monto" name="detalle_monto" value="<?php echo htmlspecialchars($_POST['detalle_monto']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['detalle_monto'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['detalle_monto'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['detalle_cantidad']) ? " error" : "";?>">
					<label class="control-label" for="detalle_cantidad">detalle_cantidad</label>
					<div class="controls">
						<input class="" id="detalle_cantidad" name="detalle_cantidad" value="<?php echo htmlspecialchars($_POST['detalle_cantidad']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['detalle_cantidad'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['detalle_cantidad'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['detalle_status']) ? " error" : "";?>">
					<label class="control-label" for="detalle_status">detalle_status</label>
					<div class="controls">
						<input class="" id="detalle_status" name="detalle_status" value="<?php echo htmlspecialchars($_POST['detalle_status']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['detalle_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['detalle_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['carrito_timestamp']) ? " error" : "";?>">
					<label class="control-label" for="carrito_timestamp">carrito_timestamp</label>
					<div class="controls">
						<input class="" id="carrito_timestamp" name="carrito_timestamp" value="<?php echo htmlspecialchars($_POST['carrito_timestamp']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['carrito_timestamp'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['carrito_timestamp'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $detalle_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Carrito_detalle::save(".$detalle_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('carrito_detalle&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
