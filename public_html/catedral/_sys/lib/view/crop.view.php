<?php
clearBuffer();
$modulename	= "Crop de imagenes";
$title 		= "Recortar";
$module 	= ucfirst(param('module'));
$go_module 	= param('module');
$image_id 	= numParam('image_id');
$image_big_url = param('image_big_url');
$options	= param('options');
$param		= "";
if(!empty($options) && strlen($options)>0):
	$params = str_replace("-", "=", $options);
    $params = str_replace(":", "&", $params);
endif;
$instance	= new $module;
$data		= $instance::select($image_id);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('<?php echo $go_module;?>&page=<?php echo pageNumber();?>&<?php echo $params;?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('<?php echo $go_module;?>&page=<?php echo pageNumber();?>&<?php echo $params;?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('<?php echo $go_module;?>&page=<?php echo pageNumber();?>&<?php echo $params;?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="<?php echo $go_module;?>_form" name="<?php echo $go_module;?>_form" method="post" autocomplete="off" action="js/save" target="upload_frame" enctype="multipart/form-data">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4><?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
			<div class="span12">
				<div class="control-group">
					<div id="cropper">
						<img src="<?php echo $image_big_url.'?'.rand();?>" class="img-responsive" />
					</div>
					<br>
					<div class="span4">
						<?php
						$size = getimagesize($image_big_url);
		      			$width = $size[0];
		      			$height = $size[1];
						?>
						<ul class="">
							<li><strong>Dimensi&oacute;n de la imagen</strong></li>
							<li>Largo: <span><?php echo $width;?></span></li>
							<li>Alto: <span><?php echo $height;?></span></li>
							<li><strong>Escalado de la imagen</strong></li>
							<li>Largo: <span id="width"></span></li>
							<li>Alto: <span id="height"></span></li>
						</ul>
					</div>
					<div class="span4">
						<a href="javascript:;" id="btn-cut" class="btn btn-primary btn-icon glyphicons scissors pull-right"><i></i> Recortar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
	var $image = $('#cropper > img');
	var x,y,width,height,scaleX,scaleY,rotate;
	var image_src = $('#cropper > img').attr('src');
	$image.cropper({
		responsive:true,
    	autoCropArea: 0.5,
    	movable: false,
		zoomable: false,
		rotatable: false,
    	crop: function(e) {
		    x = e.x;
		    y = e.y;
		    width 	= Math.round(e.width);
		    height 	= Math.round(e.height);
		    $("#width").html(width);
		    $("#height").html(height);
		}
  	});
	$('#btn-cut').on('click',function(){
		$.ajax({
			url:'js/crop',
			type: 'POST',
			dataType: 'json',
			data: 'x='+x+'&y='+y+'&width='+width+'&height='+height+'&image_src='+image_src,
			success: function(r){
				if(r.status=="success"){
					module('crop&module=<?php echo $go_module;?>&image_id=<?php echo $image_id;?>&image_big_url='+r.sourse+'?'+Math.random());
				}else{
					alert(r.description);
				}
			}
		});
	});
</script>
