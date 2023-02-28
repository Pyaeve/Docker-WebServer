<?php
clearBuffer();
$modulename	= "Contraentrega_detalle";
$detalle_id	= numParam('id');
echo $contraentrega_id = numParam('contraentrega_id');
$title		= $detalle_id > 0 ? "Modificar" : "Nuevo";
$data		= Contraentrega_detalle::select($detalle_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Contraentrega_detalle::getfields();
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
	"success"	=> "contraentrega_detalle.view.php",
	"error"		=> "contraentrega_detalle.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('contraentrega_detalle&page=<?php echo pageNumber();?>&contraentrega_id=<?php echo $contraentrega_id; ?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('contraentrega_detalle&page=<?php echo pageNumber();?>&contraentrega_id=<?=$contraentrega_id?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('contraentrega_detalle&page=<?php echo pageNumber();?>&contraentrega_id=<?=$contraentrega_id?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="contraentrega_detalle_form" name="contraentrega_detalle_form" method="post" autocomplete="off" onsubmit="savedata('contraentrega_detalle');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">


				<div class="control-group<?php echo isset($error['producto_nombre']) ? " error" : "";?>">
					<label class="control-label" for="producto_nombre">Producto</label>
					<div class="controls">
						<input class="" value="<?php echo htmlspecialchars($_POST['producto_nombre']);?>" type="text" style="color:#000;" disabled />
						
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
					<label class="control-label" for="producto_precio">Precio</label>
					<div class="controls">
						<input disabled  value="<?php echo htmlspecialchars($_POST['producto_precio']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['producto_precio'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['producto_precio'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['detalle_cantidad']) ? " error" : "";?>">
					<label class="control-label" for="detalle_cantidad">Cantidad</label>
					<div class="controls">
						<input disabled value="<?php echo htmlspecialchars($_POST['detalle_cantidad']);?>" type="text" style="color:#000;"/>
						
						<?php
						if(isset($error['detalle_cantidad'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['detalle_cantidad'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['detalle_pago']) ? " error" : "";?>">
					<label class="control-label" for="detalle_pago">Estado </label>
					<div class="controls">
						<select name="detalle_pago" id="detalle_pago" style="color:#000;">
							<?php 
								$opciones = array(0 => "Pendiente" , 1 => "Pagado", 2 => "Anulado");
								foreach ($opciones as $key => $value) {
									if($_POST['detalle_pago'] == $key){ $select = "selected"; }else{ $select = ""; }
									echo "<option value='".$key."' ".$select.">".$value."</option>";
								}
							?>

						</select>
						<?php
						if(isset($error['detalle_pago'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['detalle_pago'];?></span></p>
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
			<input type="hidden" name="contraentrega_id" value="<?php echo $contraentrega_id;?>" />
			<input type="hidden" name="producto_nombre" value="<?php echo $_POST['producto_nombre'];?>" />

			<input type="hidden" name="producto_precio" value="<?php echo $_POST['producto_precio'];?>" />
			<input type="hidden" name="detalle_cantidad" value="<?php echo $_POST['detalle_cantidad'];?>" />


			<input type="hidden" name="producto_id" value="<?php echo $_POST['producto_id'];?>" />
			<input type="hidden" name="detalle_monto" value="<?php echo htmlspecialchars($_POST['producto_precio']);?>" />
			<input type="hidden" name="detalle_status" value="<?php echo htmlspecialchars($_POST['detalle_status']);?>" />

			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Contraentrega_detalle::save(".$detalle_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('contraentrega_detalle&page=<?php echo pageNumber();?>&contraentrega_id=<?=$contraentrega_id?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
