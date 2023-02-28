<?php
clearBuffer();
$modulename	= "Productos";
$producto_id	= numParam('id');
$title		= $producto_id > 0 ? "Modificar" : "Nuevo";
$data		= Productos::select($producto_id);

if(isset($_GET['error'])):
	$error = array();
	$_POST = $_GET;
	foreach($_GET as $gk => $gv):
		if(strpos($gk,"error_") !== false):
			$error[str_replace("error_","", $gk)] = $gv;
		endif;
	endforeach;
endif;

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Productos::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['producto_status'] = $_POST['producto_status'] == NULL ? 1 : $_POST['producto_status'];
endif;
$callback	= array(
	"success"	=> "upload.success.php",
	"error"		=> "upload.error.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('productos&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons barcode" style="width:50% !important;"><i></i><a href="" onclick="module('productos&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('productos&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="productos_form" name="productos_form" method="post" autocomplete="off" action="js/save" target="upload_frame" enctype="multipart/form-data">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['categoria_id']) ? " error" : "";?>">
					<label class="control-label" for="categoria_id">Categoria</label>
					<div class="controls" id="categories_list">
						<?php

						if(number($_POST['categoria_id']) == 0):
							Categorias::combobox($_POST['categoria_id'],"loadsubcategories(this,0);");
						else:
							$nodes = Categorias::tree($_POST['categoria_id']);
							$node_number = 0;
							echo "Categoria Actual<br>";
							foreach($nodes as $node):

								$view.= $node['categoria_nombre']." =>";

							endforeach;
								$view = trim($view,"=>");
								echo $view."<br>";

								Categorias::combobox($_POST['categoria_id'],"loadsubcategories(this,0);");

						endif;
						?>
						<?php
						if(isset($error['categoria_id'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['categoria_id'];?></span></p>
						<?php
						endif;
						?>
					<input type="hidden" name="categoria_id" id="categoria_id" value="<?php echo $_POST['categoria_id'];?>" />
					<input type="hidden" name="categoria_subs" id="categoria_subs" value="0" />
					</div>
				</div>


				<div class="control-group<?php echo isset($error['marca_id']) ? " error" : "";?>">
					<label class="control-label" for="marca_id">Marcas</label>
					<div class="controls">
						<?php Marcas::combobox($_POST['marca_id']);?>

						
						<?php
						if(isset($error['marca_id'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['marca_id'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['producto_codigo']) ? " error" : "";?>">
					<label class="control-label" for="producto_codigo">Codigo</label>
					<div class="controls">
						<input class="" id="producto_codigo" name="producto_codigo" value="<?php echo htmlspecialchars($_POST['producto_codigo']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['producto_codigo'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['producto_codigo'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['producto_nombre']) ? " error" : "";?>">
					<label class="control-label" for="producto_nombre">Nombre</label>
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

				<div class="control-group<?php echo isset($error['producto_descripcion']) ? " error" : "";?>">
					<label class="control-label" for="producto_descripcion">Descripcion</label>
					<div class="controls">
						<textarea class="" id="producto_descripcion" name="producto_descripcion" style="color:#000; width:500px; height:160px;"><?php echo htmlspecialchars($_POST['producto_descripcion']);?></textarea>
						
						<?php
						if(isset($error['producto_descripcion'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['producto_descripcion'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['producto_stock']) ? " error" : "";?>">
					<label class="control-label" for="producto_stock">Stock</label>
					<div class="controls">
						<input class="" id="producto_stock" name="producto_stock" value="<?php echo htmlspecialchars($_POST['producto_stock']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['producto_stock'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['producto_stock'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['producto_status']) ? " error" : "";?>">
					<label class="control-label" for="producto_status">Activo</label>
					<div class="controls">
						<input class="" id="producto_status" name="producto_status" value="1" type="checkbox"<?php if($_POST['producto_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['producto_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['producto_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['producto_destacado']) ? " error" : "";?>">
					<label class="control-label" for="producto_destacado">Destacado</label>
					<div class="controls">
						<input class="" id="producto_destacado" name="producto_destacado" value="1" type="checkbox"<?php if($_POST['producto_destacado'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['producto_destacado'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['producto_destacado'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $producto_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Productos::save(".$producto_id.")");?>" />
			<input type="hidden" name="option" value="productos" id="option" />
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('productos&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>
<iframe name="upload_frame" id="upload_frame" style="border:none;width:10px; height:10px;"></iframe>

<script type="text/javascript">
	$(document).ready(function () {
	  
	});

	function loadsubcategories(e,sub){

		var id = e.options[e.selectedIndex].value;
		$.ajax({
		  type: "POST",
		  url: 'js/categorias',
		  data: {"categoria_id":id,"sub":sub},
		  error: function(){
			alert('Error al ingresar al módulo.');
		  },
		  success: function(res, status, xhr){
			  var type = xhr.getResponseHeader("Content-type");
			  if(type != 'application/x-javascript'){
				$('#content').html(res);
				$('.focus').focus();
			  }
		  }
		}).done(function(){
			//loaduniforms();
		});
	};
</script>
