<?php
clearBuffer();
$modulename	= "Ciudad";
$ciudad_id	= numParam('id');
$departamento_id = numParam('departamento_id');
$title		= $ciudad_id > 0 ? "Modificar" : "Nuevo";
$data		= Ciudad::select($ciudad_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Ciudad::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['ciudad_status'] = $_POST['ciudad_status'] == NULL ? 1 : $_POST['ciudad_status'];
endif;
$callback	= array(
	"success"	=> "ciudad.view.php",
	"error"		=> "ciudad.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('ciudad&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('ciudad&page=<?php echo pageNumber();?>&departamento_id=<?php echo $departamento_id; ?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('ciudad&page=<?php echo pageNumber();?>&departamento_id=<?php echo $departamento_id; ?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="ciudad_form" name="ciudad_form" method="post" autocomplete="off" onsubmit="savedata('ciudad');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['ciudad_nombre']) ? " error" : "";?>">
					<label class="control-label" for="ciudad_nombre">Nombre</label>
					<div class="controls">
						<input class="" id="ciudad_nombre" name="ciudad_nombre" value="<?php echo htmlspecialchars($_POST['ciudad_nombre']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['ciudad_nombre'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['ciudad_nombre'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['costo_envio']) ? " error" : "";?>">
					<label class="control-label" for="costo_envio">Costo de envio</label>
					<div class="controls">
						<input class="" id="costo_envio" name="costo_envio" value="<?php echo htmlspecialchars($_POST['costo_envio']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['costo_envio'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['costo_envio'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>
				
				<div class="control-group<?php echo isset($error['ciudad_status']) ? " error" : "";?>">
					<label class="control-label" for="ciudad_status">Activo</label>
					<div class="controls">
						<input class="" id="ciudad_status" name="ciudad_status" value="1" type="checkbox"<?php if($_POST['ciudad_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['ciudad_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['ciudad_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $ciudad_id;?>" />
			<input type="hidden" name="departamento_id" value="<?php echo $departamento_id;?>" />
			
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Ciudad::save(".$ciudad_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('ciudad&page=<?php echo pageNumber();?>&departamento_id=<?php echo $departamento_id; ?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
