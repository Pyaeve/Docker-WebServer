<?php
require_once('../../_sys/init.php');
if(login()):
	$parent_id = number(param('categoria_id'));
	$sub = number(param('sub'));
	$sql = "SELECT * FROM categorias WHERE categoria_parent > 1 AND categoria_parent = {$parent_id} AND categoria_status = 1 AND categoria_hidden = 0 ORDER BY categoria_nombre";
	$res = db::execute($sql);
	setApplicationJavascript();
	print '
	var parent_id = '.$parent_id.';
	var cat_list = '.json_encode($res).';
	var subs = $(\'#categoria_subs\').val();

	if(subs > 0){
		for(var i='.($sub).'; i<=subs; i++){
			$(\'#sub_\'+i+\'\').remove();
		}
	}

	if(!$(\'#sub_'.$sub.'\').length){
		if(Object.keys(cat_list).length > 0){
			$(\'#categories_list\').append(\'<select id="sub_'.$sub.'" onchange="loadsubcategories(this,'.($sub+1).');" style="margin-top:5px; clear:both; color:#000 !important;"><option value="0">Seleccionar</option></select>\');
			var $subType = $("#sub_'.$sub.'");
			$.each(cat_list, function () {
				$subType.append($(\'<option></option>\').attr("value", this.categoria_id).text(this.categoria_nombre));
			 });
		}
	}
	if(parent_id > 0){
		$(\'#categoria_id\').val(parent_id);
	}else{
		$(\'#categoria_id\').val($(\'#sub_'.($sub-2).'\').val());
	}
	$(\'#categoria_subs\').val('.($sub+1).');
	';
else:
	setApplicationJavascript();
	print "alert('LA SESIÓN A EXPIRADO ".'\n'."Por favor, ingrese nuevamente su E-mail y Contraseña para acceder al sistema.');window.location.href='".baseAdminURL."'";
endif;
?>
