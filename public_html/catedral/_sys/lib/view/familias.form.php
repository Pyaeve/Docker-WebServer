<?php
clearBuffer();
$modulename	= "Familias";
$familia_id	= numParam('id');
$title		= $familia_id > 0 ? "Modificar" : "Nuevo";
$data		= Familias::select($familia_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Familias::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['familia_status'] = $_POST['familia_status'] == NULL ? 1 : $_POST['familia_status'];
endif;
$callback	= array(
	"success"	=> "familias.view.php",
	"error"		=> "familias.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('familias&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('familias&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('familias&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="familias_form" name="familias_form" method="post" autocomplete="off" onsubmit="savedata('familias');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['familia_nombre']) ? " error" : "";?>">
					<label class="control-label" for="familia_nombre">Nombre</label>
					<div class="controls">
						<input class="" id="familia_nombre" name="familia_nombre" value="<?php echo htmlspecialchars($_POST['familia_nombre']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['familia_nombre'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['familia_nombre'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['familia_status']) ? " error" : "";?>">
					<label class="control-label" for="familia_status">Activo</label>
					<div class="controls">
						<input class="" id="familia_status" name="familia_status" value="1" type="checkbox"<?php if($_POST['familia_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['familia_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['familia_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $familia_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Familias::save(".$familia_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('familias&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
