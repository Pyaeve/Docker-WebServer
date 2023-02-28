<?php
$title = "Direcciones";
$page	 = pageNumber();
$search	 = addslashes(param('query'));
$search_num	 = number($search);
$search	 = strlen(trim($search)) > 0 ? " AND (direccion_id = '{$search_num}') OR (cliente_id = '{$search_num}') OR (cliente_id IN (SELECT cliente_id FROM clientes WHERE cliente_cedula = '{$search_num}'))" : "";
$listing = new Listing();
$listing->pgclick("module('direcciones&page=%s');return!1;");
$listing = $listing->get("direcciones", 10, NULL, $page, "WHERE direccion_hidden = 0 {$search} ORDER BY direccion_id DESC");

$permissionInsert = permissionInsert('direcciones');
$permissionUpdate = permissionUpdate('direcciones');
$permissionDelete = permissionDelete('direcciones');
//print_r($listing);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title;?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons" style="overflow:hidden;">
	<h3 class="glyphicons road" style="display:inline-block !important; float:left !important;"><i></i> <?php echo $title;?></h3>
	<?php if($permissionInsert):?>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_plus" onclick="create('direcciones','0&page=<?php echo $page;?>');return!1;"><i></i>Nuevo</a>
	</div>
	<?php endif;?>
	
</div>
<div class="separator"></div>
<div class="innerLR">
<form name="searchform" id="searchform" method="get" onsubmit="module('direcciones&query='+$('#squery').val());return!1;">
<div class="input-append">
	<input class="span6" id="squery" name="query" type="text" value="<?php echo htmlspecialchars(param('query'));?>" placeholder="Buscar..." />
	<button class="btn" type="submit"><i class="icon-search"></i></button>
</div>
</form>
<?php
if(is_array($listing['list']) && count($listing['list']) > 0):
?>
	<div class="pagination pull-right" style="margin: 0;">
			<?php echo $listing['navigation'];?>
	</div>
	<table class="table table-bordered table-condensed table-striped table-vertical-center checkboxs js-table-sortable">
		<thead>
			<tr>
				<th style="width: 1%;" class="uniformjs"><input type="checkbox" name="checkall_direcciones" id="checkall_direcciones" value="1" /></th>
				<th style="width: 1%;" class="center">ID</th>
				<th style="width: 5%;" class="center">Cliente </th>
				<th style="width: 1%;" class="center">Denominaci&oacuten</th>

				<th class="right" colspan="3">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($listing['list'] as $list):
		?>
			<tr class="selectable">
				<td class="center uniformjs"><input type="checkbox" name="check_direcciones_<?php echo $list['direccion_id'];?>" value="<?php echo $list['direccion_id'];?>" /></td>
				<td class="center"><?php echo $list['direccion_id'];?></td>
				<?php 
					 $cliente = Clientes::get("cliente_id = ".$list['cliente_id'],"");
					 if(haveRows($cliente)){
					   $cliente_campo = $list['cliente_id']." - ".$cliente[0]["cliente_nombre"]." - CI: ".$cliente[0]["cliente_cedula"];
					 }
				?>
				<td class="center"><?php echo $cliente_campo;?></td>
				<td class="center"><?php echo $list['direccion_denominacion'];?></td>
				<td class="center" style="width: 150px;"><?php echo date('d/m/Y H:i', strtotime($list['direccion_timestamp']));?></td>
				<td class="center" style="width: 80px;"><span class="label label-block label-<?php echo $list['direccion_status'] == 1 ? "important" : "inverse";?>"><?php echo $list['direccion_status'] == 1 ? "Activo" : "Inactivo";?></span></td>
				<td class="center" style="width: 120px;">
					<a href="" class="btn-action glyphicons folder_open btn-primary" onclick="viewModal('direcciones','<?php echo $list['direccion_id'];?>');return!1;"><i></i></a>
					<?php if($permissionUpdate): ?>
					<a href="" class="btn-action glyphicons pencil btn-success" onclick="create('direcciones','<?php echo $list['direccion_id'];?>&page=<?php echo $page;?>');return!1;"><i></i></a>
					<?php endif;?>
					<?php if($permissionDelete): ?>
					<a href="" class="btn-action glyphicons remove_2 btn-danger" onclick="removeit({'option':'direcciones','id':'<?php echo $list['direccion_id'];?>','callback':'view'});return!1;"><i></i></a>
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
				<select style="color:#000;" onchange="checkedAction('direcciones',this);">
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