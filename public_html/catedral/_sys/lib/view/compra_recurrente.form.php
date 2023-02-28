<?php
clearBuffer();
$modulename	= "Compra_recurrente";
$compra_id	= numParam('id');
$title		= $compra_id > 0 ? "Modificar" : "Nuevo";
$data		= Compra_recurrente::select($compra_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Compra_recurrente::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['compra_status'] = $_POST['compra_status'] == NULL ? 1 : $_POST['compra_status'];
endif;
$callback	= array(
	"success"	=> "compra_recurrente.view.php",
	"error"		=> "compra_recurrente.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('compra_recurrente&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('compra_recurrente&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('compra_recurrente&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="compra_recurrente_form" name="compra_recurrente_form" method="post" autocomplete="off" onsubmit="savedata('compra_recurrente');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['cliente_id']) ? " error" : "";?>">
					<label class="control-label" for="cliente_id">cliente_id</label>
					<div class="controls">
						<input class="" id="cliente_id" name="cliente_id" value="<?php echo htmlspecialchars($_POST['cliente_id']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['cliente_id'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['cliente_id'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['compra_nombre']) ? " error" : "";?>">
					<label class="control-label" for="compra_nombre">compra_nombre</label>
					<div class="controls">
						<input class="" id="compra_nombre" name="compra_nombre" value="<?php echo htmlspecialchars($_POST['compra_nombre']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['compra_nombre'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['compra_nombre'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['contraentrega_status']) ? " error" : "";?>">
					<label class="control-label" for="contraentrega_status">contraentrega_status</label>
					<div class="controls">
						<input class="" id="contraentrega_status" name="contraentrega_status" value="<?php echo htmlspecialchars($_POST['contraentrega_status']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['contraentrega_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['contraentrega_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['contraentrega_timestamp']) ? " error" : "";?>">
					<label class="control-label" for="contraentrega_timestamp">contraentrega_timestamp</label>
					<div class="controls">
						<input class="" id="contraentrega_timestamp" name="contraentrega_timestamp" value="<?php echo htmlspecialchars($_POST['contraentrega_timestamp']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['contraentrega_timestamp'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['contraentrega_timestamp'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $compra_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Compra_recurrente::save(".$compra_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('compra_recurrente&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
