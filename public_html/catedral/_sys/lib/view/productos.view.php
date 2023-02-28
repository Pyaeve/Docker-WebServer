<?php
$title = "Productos";
$page	 = pageNumber();
$search	 = addslashes(param('query'));
$query	 = addslashes(param('query'));
$search_num	 = number($search);

$search	 = strlen(trim($search)) > 0 ? " AND producto_id = '{$search_num}' OR producto_nombre LIKE '%{$search}%' OR producto_codigo LIKE '%{$search}%'" : "";

$listing = new Listing();
$listing->pgclick("module('productos&page=%s&query={$query}');return!1;");
$listing = $listing->get("productos", 10, NULL, $page, "WHERE producto_hidden = 0 {$search} ORDER BY producto_id DESC");

$permissionInsert = permissionInsert('productos');
$permissionUpdate = permissionUpdate('productos');
$permissionDelete = permissionDelete('productos');
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title;?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons" style="overflow:hidden;">
	<h3 class="glyphicons barcode" style="display:inline-block !important; float:left !important;"><i></i> <?php echo $title;?></h3>
	<?php if($permissionInsert):?>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_plus" onclick="create('productos','0&page=<?php echo $page;?>');return!1;"><i></i>Nuevo</a>
	</div>
	<?php endif;?>
	
</div>
<div class="separator"></div>
<div class="innerLR" style="overflow-y: scroll;height: 450px;">
<form name="searchform" id="searchform" method="get" onsubmit="module('productos&query='+$('#squery').val());return!1;">
<div class="input-append">
	<input class="span6" id="squery" name="query" type="text" value="<?php echo htmlspecialchars(param('query'));?>" placeholder="Buscar..." />
	<button class="btn" type="submit"><i class="icon-search"></i></button>
</div>
</form>
<?php
if(is_array($listing['list']) && count($listing['list']) > 0):
?>
	<table class="table table-bordered table-condensed table-striped table-vertical-center checkboxs js-table-sortable">
		<thead>
			<tr>
				<th style="width: 1%;" class="uniformjs"><input type="checkbox" name="checkall_productos" id="checkall_productos" value="1" /></th>
				<!--<th style="width: 1%;" class="center">ID</th>-->

				<th class="center">Codigo Producto</th>
				<th class="center">Nombre</th>
				<th class="center">Imagenes</th>
				<th class="center">Ficha</th>




				<th class="right" colspan="3">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($listing['list'] as $list):
		?>
			<tr class="selectable">
				<td class="center uniformjs"><input type="checkbox" name="check_productos_<?php echo $list['producto_id'];?>" value="<?php echo $list['producto_id'];?>" /></td>
				<!--<td class="center"><?php// echo $list['producto_id'];?></td>-->
				<td class="center"><?php echo $list['producto_codigo'];?></td>
				<td class="center"><?php echo $list['producto_nombre'];?></td>
				<td class="center">
					<a href="" class="btn btn-warning" onclick="module('imagenes_productos&producto_id=<?=$list['producto_id']?>&pagina=<?=$page?>');return!1;"><i></i><span>Imagenes</span></a>
				</td>
				<td class="center">
					<a href="" class="btn btn-warning" onclick="module('productos_fichas&producto_id=<?=$list['producto_id']?>&pagina=<?=$page?>');return!1;"><i></i><span>Fichas</span></a>
				</td>



				<td class="center" style="width: 150px; font-size:11px;">
				    <? 
				        $nodes = Categorias::tree($list['categoria_id']);
				        foreach($nodes as $node):
							$view.= $node['categoria_nombre']." =>";
						endforeach;
						$view = trim($view,"=>");
						echo $view."<br>";
				    ?>
				</td>
				<td class="center" style="width: 80px;"><span class="label label-block label-<?php echo $list['producto_status'] == 1 ? "important" : "inverse";?>"><?php echo $list['producto_status'] == 1 ? "Activo" : "Inactivo";?></span></td>
				<td class="center" style="width: 120px;">
					
					<?php if($permissionUpdate): ?>
					<a href="" class="btn-action glyphicons pencil btn-success" onclick="create('productos','<?php echo $list['producto_id'];?>&page=<?php echo $page;?>');return!1;"><i></i></a>
					<?php endif;?>
					<?php if($permissionDelete): ?>
					<a href="" class="btn-action glyphicons remove_2 btn-danger" onclick="removeit({'option':'productos','id':'<?php echo $list['producto_id'];?>','callback':'view'});return!1;"><i></i></a>
					<?php endif;?>
				</td>
			</tr>
		<?php
		endforeach;
		?>
		</tbody>
	</table>
	<div class="separator top form-inline small">
		<div class="pull-left checkboxs_actions hide">
			<div class="row-fluid">
				<select style="color:#000;" onchange="checkedAction('productos',this);">
					<option value="0">Seleccionados</option>
					<?php if($permissionUpdate): ?>
					<option value="1">Activar</option>
					<option value="2">Desactivar</option>
					<?php endif;?>
					<?php if($permissionDelete): ?>
					<option value="3">Eliminar</option>
					<?php endif;?>
				</select>
			</div>
		</div>
		<div class="pagination pull-right" style="margin: 0;">
			<?php echo $listing['navigation'];?>
		</div>
		<div class="clearfix"></div>
	</div>
<?php
else:
?>
<div class="alert alert-info">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Sin datos</strong> No se encontraron registros</div>
<?php
endif;
?>
</div>
<br/>
<!-- End Content --> 