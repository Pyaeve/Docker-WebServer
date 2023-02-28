<?php
$modulename	= "Parametros";
$parametro_id	= numParam('id');
$title		= $parametro_id > 0 ? "Modificar Parametro" : "Nuevo Parametro";
$data		= Parametros::select($parametro_id);
if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
	$_POST['admin_password'] = NULL;
else:
	$fields = Parametros::getfields();
	foreach($fields as $k => $v):

		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;

		$_POST[$k] = $value;
	endforeach;
	$_POST['admin_status'] = $_POST['admin_status'] ==  NULL ? 1 : $_POST['admin_status'];
endif;
$callback	= array(
	"success"	=> "parametros.view.php",
	"error"		=> "parametros.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('parametros&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons cogwheels" style="width:400px !important;"><i></i> <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('parametros&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="parametros_form" name="parametros_form" method="post" autocomplete="off" onsubmit="savedata('parametros');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Información del Parametro</h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['admin_names']) ? " error" : "";?>">
					<label class="control-label" for="para_parametro">Para Parametro</label>
					<div class="controls">
						<input class="" id="para_parametro" name="para_parametro" value="<?php echo htmlspecialchars($_POST['para_parametro']);?>" type="text" style="color:#000;" />

						<?php
						if(isset($error['admin_names'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['admin_names'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['admin_email']) ? " error" : "";?>">
					<label class="control-label" for="para_valor">Para Valor</label>
					<div class="controls">
						<input class="" id="para_valor" name="para_valor" value="<?php echo htmlspecialchars($_POST['para_valor']);?>" type="text" style="color:#000;" />

						<?php
						if(isset($error['admin_email'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['admin_email'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['admin_password']) ? " error" : "";?>">
					<label class="control-label" for="para_valor_numerico">Para Valor N°</label>
					<div class="controls">
						<input class="" id="para_valor_numerico" name="para_valor_numerico" value="<?php echo htmlspecialchars($_POST['para_valor_numerico']);?>" type="text" style="color:#000;" />

						<?php
						if(isset($error['admin_password'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['admin_password'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>
		
				<div class="control-group<?php echo isset($error['admin_status']) ? " error" : "";?>">
					<label class="control-label" for="parametro_status">Activo</label>
					<div class="controls">
						<input class="" id="parametro_status" name="parametro_status" value="1" type="checkbox" style="color:#000;"<?php if($_POST['parametro_status'] == 1){?> checked="checked"<?php } ?> />

						<?php
						if(isset($error['admin_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['admin_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>


						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $parametro_id;?>" />
			<input type="hidden" name="token" value="<?php echo token("Parametros::save(".$parametro_id.")");?>" />
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('parametros&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>