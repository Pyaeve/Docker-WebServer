<?php
clearBuffer();
$modulename	= "Departamentos";
$departamento_id	= numParam('id');
$title		= $departamento_id > 0 ? "Modificar" : "Nuevo";
$data		= Departamentos::select($departamento_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Departamentos::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['departamento_status'] = $_POST['departamento_status'] == NULL ? 1 : $_POST['departamento_status'];
endif;
$callback	= array(
	"success"	=> "departamentos.view.php",
	"error"		=> "departamentos.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('departamentos&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('departamentos&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('departamentos&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="departamentos_form" name="departamentos_form" method="post" autocomplete="off" onsubmit="savedata('departamentos');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['departamento_nombre']) ? " error" : "";?>">
					<label class="control-label" for="departamento_nombre">Nombre</label>
					<div class="controls">
						<input class="" id="departamento_nombre" name="departamento_nombre" value="<?php echo htmlspecialchars($_POST['departamento_nombre']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['departamento_nombre'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['departamento_nombre'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['departamento_status']) ? " error" : "";?>">
					<label class="control-label" for="departamento_status">Activo</label>
					<div class="controls">
						<input class="" id="departamento_status" name="departamento_status" value="1" type="checkbox"<?php if($_POST['departamento_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['departamento_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['departamento_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $departamento_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Departamentos::save(".$departamento_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('departamentos&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
