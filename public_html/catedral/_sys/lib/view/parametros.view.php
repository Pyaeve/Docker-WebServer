<?php
$_GET['query'] = isset($_GET['query']) ? $_GET['query'] : "";
$page	 = pageNumber();
$search	 = addslashes($_GET['query']);
$search	 = strlen(trim($search)) > 0 ? " AND admin_id = '{$search}' OR admin_names LIKE '%{$search}%' OR admin_email LIKE '%{$search}%'" : "";
$isroot = login::get("admin_isroot");
$filter = $isroot == 1 ? "" : "admin_id = " . login::get("admin_id") . " AND ";
$listing = new Listing();
$listing->pgclick("module('parametros&page=%s');return!1;");
$listing = $listing->get("parametros", 20, NULL, $page, "WHERE {$filter}  parametro_hidden = 0 {$search} ORDER BY parametro_id DESC");
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li>Parametros</li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons cogwheels" style="width:200px !important;"><i></i> Parametros </h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_plus" onclick="create('parametros',0);return!1;"><i></i>Nuevo</a>
	</div>
</div>
<div class="separator"></div>
<div class="innerLR">
<form name="searchform" id="searchform" method="get" onsubmit="module('parametros&query='+$('#squery').val());return!1;">
<div class="input-append">
	<input class="span6" id="squery" name="query" type="text" value="<?php echo htmlspecialchars($_GET['query']);?>" placeholder="Buscar..." />
	<button class="btn" type="button"><i class="icon-search"></i></button>
</div>
</form>
<?php
if(is_array($listing['list']) && count($listing['list']) > 0):
?>
	<table class="table table-bordered table-condensed table-striped table-vertical-center checkboxs js-table-sortable">
		<thead>
			<tr>
				<th style="width: 1%;" class="uniformjs"><input type="checkbox" id="checkall_admins" name="checkall_admins" value="1" /></th>
				<th style="width: 1%;" class="center">ID</th>
				<th>Para Parametro</th>
				<th>Para Valor</th>
				<th>Para Valor N°</th>
				<th>Fecha</th>
				<th class="right" colspan="3">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($listing['list'] as $list):
		?>
			<tr class="selectable">
				<td class="center uniformjs"><input type="checkbox" name="check_admins_<?php echo $list['parametro_id'];?>" value="<?php echo $list['parametro_id'];?>" /></td>
				<td class="center"><?php echo $list['parametro_id'];?></td>
				<td><strong><?php echo $list['para_parametro'];?></strong></td>
				<td><?php echo $list['para_valor'];?></td>
				<td><?php echo $list['para_valor_numerico'];?></td>
				<td class="center" style="width: 150px;"><?php echo $list['parametro_timestamp'];?></td>
				<td class="center" style="width: 80px;"><span class="label label-block label-<?php echo $list['parametro_status'] == 1 ? "important" : "inverse";?>"><?php echo $list['parametro_status'] == 1 ? "Activo" : "Inactivo";?></span></td>
				<td class="center" style="width: 60px;"><a href="" class="btn-action glyphicons pencil btn-success" onclick="create('parametros',<?php echo $list['parametro_id'];?>);return!1;"><i></i></a> <a href="" class="btn-action glyphicons remove_2 btn-danger" onclick="removedata('parametros',<?php echo $list['parametro_id'];?>,'view');return!1;"><i></i></a></td>
			</tr>
		<?php
		endforeach;
		?>
		</tbody>
	</table>
	<div class="separator top form-inline small">
		<div class="pull-left checkboxs_actions hide">
			<div class="row-fluid">
				<select style="color:#000;" onchange="bulkAction('admins',this);">
					<option value="0">Seleccionados</option>
					<option value="1">Activar</option>
					<option value="2">Desactivar</option>
					<option value="3">Eliminar</option>
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
