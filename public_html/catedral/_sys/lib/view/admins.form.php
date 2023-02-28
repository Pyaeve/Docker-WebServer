<?php
$modulename	= "Administradores";
$admin_id	= numParam('id');
$title		= $admin_id > 0 ? "Modificar Administrador" : "Nuevo Administrador";
$data		= Admins::select($admin_id);
if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
	$_POST['admin_password'] = NULL;
else:
	$fields = Admins::getfields();
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
	"success"	=> "admins.view.php",
	"error"		=> "admins.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('admins&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons parents" style="width:400px !important;"><i></i> <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('admins&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="admins_form" name="admins_form" method="post" autocomplete="off" onsubmit="savedata('admins');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Información del Administrador</h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['admin_names']) ? " error" : "";?>">
					<label class="control-label" for="admin_names">Nombres</label>
					<div class="controls">
						<input class="" id="admin_names" name="admin_names" value="<?php echo htmlspecialchars($_POST['admin_names']);?>" type="text" style="color:#000;" />

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
					<label class="control-label" for="admin_email">E-mail</label>
					<div class="controls">
						<input class="" id="admin_email" name="admin_email" value="<?php echo htmlspecialchars($_POST['admin_email']);?>" type="text" style="color:#000;" />

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
					<label class="control-label" for="admin_password">Clave</label>
					<div class="controls">
						<input class="" id="admin_password" name="admin_password" value="<?php echo htmlspecialchars($_POST['admin_password']);?>" type="password" style="color:#000;" />

						<?php
						if(isset($error['admin_password'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['admin_password'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>
				<?php
				if(Login::get("admin_isroot")==1):

					$tables = array(
						"banners" => "Banners",
						"carrito" => "Carrito",
						"carrito_detalle" => "Carrito_detalle",
						"categorias" => "Categorias",
						"ciudad" => "Ciudad",
						"clientes" => "Clientes",
						"compra_recurrente" => "Compra_recurrente",
						"compra_recurrente_detalle" => "Compra_recurrente_detalle",
						"contactos" => "Contactos",
						"contraentrega" => "Contraentrega",
						"contraentrega_detalle" => "Contraentrega_detalle",
						"coordenadas" => "Coordenadas",
						"departamentos" => "Departamentos",
						"direcciones" => "Direcciones",
						"familias" => "Familias",
						"imagenes_categorias" => "Imagen",
						"imagenes_productos" => "Imagenes",
						"marcas" => "Marcas",
						"noticias" => "Noticias",
						"ofertalaborales" => "Curriculum Vitae",
						"ofertas_imagenes" => "Ofertas",
						"payment_response" => "Payment_response",
						"productos" => "Productos",
						"productos_fichas" => "Productos_fichas",
						"productos_ofertas" => "Productos_ofertas",
						"promociones_tipos" => "Tipo",
						"recomendados" => "Recomendado De La Semana",
						"secciones" => "Secciones",
						"sucursales" => "Sucursales",
						"suscripciones" => "Suscripcion",
						"zona_ecommerce" => "Zona_ecommerce",
					);


					$permission = @json_decode(stripslashes($_POST['admin_permission']));
					$option_disabled = $_POST['admin_isroot'] == 1 ? true : false;

				?>
				<div class="control-group<?php echo isset($error['admin_permission']) ? " error" : "";?>">
					<label class="control-label" for="admin_permission">Permisos</label>
					<div class="controls" style="width:400px; border:1px solid #ccc; background-color:#fff;">

						<table width="400" border="0" cellspacing="0" cellpadding="5">
						<tr>
							<th style="border-bottom:1px solid #ccc;" width="202" scope="col">&nbsp;</th>
							<th style="border-bottom:1px solid #ccc;" width="66" scope="col">Crear</th>
							<th style="border-bottom:1px solid #ccc;" width="66" scope="col">Modificar</th>
							<th style="border-bottom:1px solid #ccc;" width="66" scope="col">Eliminar</th>
						</tr>
						<?php
						$t=0;
						foreach($tables as $tk => $tv):
							$t++;
							$insert_checked = false;
							$update_checked = false;
							$delete_checked = false;

							if($_POST['admin_isroot'] == 1):
								$insert_checked = true;
								$update_checked = true;
								$delete_checked = true;
							else:
								if($permission instanceof stdClass):
									eval('$insert_checked = $permission->' . $tk . '->insert == 1 ? true : false;');
									eval('$update_checked = $permission->' . $tk . '->update == 1 ? true : false;');
									eval('$delete_checked = $permission->' . $tk . '->delete == 1 ? true : false;');
								endif;
							endif;

							$border = $t < count($tables) ? 'border-bottom:1px solid #ccc;' : '';
						?>
						<tr>
							<th scope="row" style="<?php echo $border;?> text-align:left;"><?php echo htmlspecialchars($tv);?></th>
							<td style="<?php echo $border;?>" align="center"><input type="checkbox" name="<?php echo $tk;?>_permission_insert" id="<?php echo $tk;?>_permission_insert" value="1"<?php if($option_disabled){?> disabled="disabled"<?php } ?><?php if($insert_checked){?> checked="checked"<?php } ?> /></td>
							<td style="<?php echo $border;?>" align="center"><input type="checkbox" name="<?php echo $tk;?>_permission_update" id="<?php echo $tk;?>_permission_update" value="1"<?php if($option_disabled){?> disabled="disabled"<?php } ?><?php if($update_checked){?> checked="checked"<?php } ?> /></td>
							<td style="<?php echo $border;?>" align="center"><input type="checkbox" name="<?php echo $tk;?>_permission_delete" id="<?php echo $tk;?>_permission_delete" value="1"<?php if($option_disabled){?> disabled="disabled"<?php } ?><?php if($delete_checked){?> checked="checked"<?php } ?> /></td>
						</tr>
						<?php
						endforeach;
						?>
					</table>

						<?php
						if(isset($error['admin_permission'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['admin_permission'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>
				<?php
				endif;
				?>
				<?php if(Login::get("admin_isroot") == 1){?>
				<div class="control-group<?php echo isset($error['admin_isroot']) ? " error" : "";?>">
					<label class="control-label" for="admin_isroot">Super Administrador</label>
					<div class="controls">
						<input class="" id="admin_isroot" name="admin_isroot" value="1" type="checkbox" style="color:#000;"<?php if($_POST['admin_isroot'] == 1){?> checked="checked"<?php } ?> />

						<?php
						if(isset($error['admin_isroot'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['admin_isroot'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>
				<?php }?>
				<div class="control-group<?php echo isset($error['admin_status']) ? " error" : "";?>">
					<label class="control-label" for="admin_status">Activo</label>
					<div class="controls">
						<input class="" id="admin_status" name="admin_status" value="1" type="checkbox" style="color:#000;"<?php if($_POST['admin_status'] == 1){?> checked="checked"<?php } ?> />

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
			<input type="hidden" name="id" value="<?php echo $admin_id;?>" />
			<input type="hidden" name="token" value="<?php echo token("Admins::save(".$admin_id.")");?>" />
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('admins&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>