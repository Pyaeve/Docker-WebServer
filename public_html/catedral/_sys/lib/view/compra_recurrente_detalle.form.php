<?php
clearBuffer();
$modulename	= "Compra_recurrente_detalle";
$detalle_id	= numParam('id');
$title		= $detalle_id > 0 ? "Modificar" : "Nuevo";
$data		= Compra_recurrente_detalle::select($detalle_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Compra_recurrente_detalle::getfields();
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
	"success"	=> "compra_recurrente_detalle.view.php",
	"error"		=> "compra_recurrente_detalle.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('compra_recurrente_detalle&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('compra_recurrente_detalle&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('compra_recurrente_detalle&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="compra_recurrente_detalle_form" name="compra_recurrente_detalle_form" method="post" autocomplete="off" onsubmit="savedata('compra_recurrente_detalle');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['compra_id']) ? " error" : "";?>">
					<label class="control-label" for="compra_id">compra_id</label>
					<div class="controls">
						<input class="" id="compra_id" name="compra_id" value="<?php echo htmlspecialchars($_POST['compra_id']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['compra_id'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['compra_id'];?></span></p>
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

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $detalle_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Compra_recurrente_detalle::save(".$detalle_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('compra_recurrente_detalle&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
