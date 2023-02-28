<?php
clearBuffer();
$modulename	= "Carrito";
$carrito_id	= numParam('id');
$title		= $carrito_id > 0 ? "Modificar" : "Nuevo";
$data		= Carrito::select($carrito_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Carrito::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['carrito_status'] = $_POST['carrito_status'] == NULL ? 1 : $_POST['carrito_status'];
endif;
$callback	= array(
	"success"	=> "carrito.view.php",
	"error"		=> "carrito.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('carrito&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('carrito&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('carrito&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="carrito_form" name="carrito_form" method="post" autocomplete="off" onsubmit="savedata('carrito');return!1;">
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

				<div class="control-group<?php echo isset($error['carrito_status']) ? " error" : "";?>">
					<label class="control-label" for="carrito_status">carrito_status</label>
					<div class="controls">
						<input class="" id="carrito_status" name="carrito_status" value="<?php echo htmlspecialchars($_POST['carrito_status']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['carrito_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['carrito_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $carrito_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Carrito::save(".$carrito_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('carrito&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
