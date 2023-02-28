<?php
clearBuffer();
$modulename	= "Fichas";
$ficha_id	= numParam('id');

$producto_id = numParam('producto_id');
$productos = Productos::select($producto_id);
$producto = $productos['0'];
$producto_title = " > ".$producto['producto_nombre'];
$pagina = numParam('pagina');


$title		= $ficha_id > 0 ? "Modificar" : "Nuevo";
$data		= Productos_fichas::select($ficha_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Productos_fichas::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['ficha_status'] = $_POST['ficha_status'] == NULL ? 1 : $_POST['ficha_status'];
endif;
$callback	= array(
	"success"	=> "productos_fichas.view.php",
	"error"		=> "productos_fichas.form.php"
);
?>
<style>
	.ck-editor__editable {
	    min-height: 400px;
	}
	input, select{ width: 100%;  }
</style>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('productos_fichas&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('productos_fichas&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('productos_fichas&page=<?php echo pageNumber();?>&producto_id=<?php echo $producto_id; ?>&pagina=<?=$pagina?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="productos_fichas_form" name="productos_fichas_form" method="post" autocomplete="off" onsubmit="savedata('productos_fichas');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span8">
				<div class="control-group<?php echo isset($error['ficha_nombre']) ? " error" : "";?>">
					<label class="control-label" for="ficha_nombre">Nombre</label>
					<div class="controls">
						<input class="" id="ficha_nombre" name="ficha_nombre" value="<?php echo htmlspecialchars($_POST['ficha_nombre']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['ficha_nombre'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['ficha_nombre'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['ficha_contenido']) ? " error" : "";?>">
					<label class="control-label" for="ficha_contenido">Contenido</label>
					<div class="controls">
						<textarea class="" id="ficha_contenido" name="ficha_contenido" style="color:#000; width:100%; height:360px;"><?php echo htmlspecialchars($_POST['ficha_contenido']);?></textarea>
						
						<?php
						if(isset($error['ficha_contenido'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['ficha_contenido'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['ficha_status']) ? " error" : "";?>">
					<label class="control-label" for="ficha_status">Activo</label>
					<div class="controls">
						<input class="" id="ficha_status" name="ficha_status" value="1" type="checkbox"<?php if($_POST['ficha_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['ficha_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['ficha_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $ficha_id;?>" />
			<input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>" />
			
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Productos_fichas::save(".$ficha_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" id="btn_aceptar"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('productos_fichas&page=<?php echo pageNumber();?>&producto_id=<?php echo $producto_id; ?>&pagina=<?=$pagina?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  //$("#ficha_contenido").wysihtml5();
	  $('#btn_aceptar').click(function(){
			$('#ficha_contenido').val(editor.getData());
	  });
	});
	
	var editor = CKEDITOR.replace( 'ficha_contenido' );
    CKEDITOR.config.height = '300px';
</script>
