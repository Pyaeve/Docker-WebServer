<?php
clearBuffer();
$modulename	= "Suscripcion";
$suscripcion_id	= numParam('id');
$title		= $suscripcion_id > 0 ? "Modificar" : "Nuevo";
$data		= Suscripciones::select($suscripcion_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Suscripciones::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['suscripcion_status'] = $_POST['suscripcion_status'] == NULL ? 1 : $_POST['suscripcion_status'];
endif;
$callback	= array(
	"success"	=> "suscripciones.view.php",
	"error"		=> "suscripciones.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('suscripciones&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons e-mail" style="width:50% !important;"><i></i><a href="" onclick="module('suscripciones&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('suscripciones&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="suscripciones_form" name="suscripciones_form" method="post" autocomplete="off" onsubmit="savedata('suscripciones');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['suscripcion_email']) ? " error" : "";?>">
					<label class="control-label" for="suscripcion_email">Email</label>
					<div class="controls">
						<input class="" id="suscripcion_email" name="suscripcion_email" value="<?php echo htmlspecialchars($_POST['suscripcion_email']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['suscripcion_email'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['suscripcion_email'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['suscripcion_status']) ? " error" : "";?>">
					<label class="control-label" for="suscripcion_status">Activo</label>
					<div class="controls">
						<input class="" id="suscripcion_status" name="suscripcion_status" value="1" type="checkbox"<?php if($_POST['suscripcion_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['suscripcion_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['suscripcion_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $suscripcion_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Suscripciones::save(".$suscripcion_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('suscripciones&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
