<?php
clearBuffer();
$modulename	= "Payment_Response";
$response_id	= numParam('id');
$title		= $response_id > 0 ? "Modificar" : "Nuevo";
$data		= Payment_response::select($response_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Payment_response::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['response_status'] = $_POST['response_status'] == NULL ? 1 : $_POST['response_status'];
endif;
$callback	= array(
	"success"	=> "payment_response.view.php",
	"error"		=> "payment_response.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('payment_response&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons usd" style="width:50% !important;"><i></i><a href="" onclick="module('payment_response&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('payment_response&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="payment_response_form" name="payment_response_form" method="post" autocomplete="off" onsubmit="savedata('payment_response');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['pedido_id']) ? " error" : "";?>">
					<label class="control-label" for="pedido_id">pedido_id</label>
					<div class="controls">
						<input class="" id="pedido_id" name="pedido_id" value="<?php echo htmlspecialchars($_POST['pedido_id']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['pedido_id'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['pedido_id'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['response_text']) ? " error" : "";?>">
					<label class="control-label" for="response_text">response_text</label>
					<div class="controls">
						<input class="" id="response_text" name="response_text" value="<?php echo htmlspecialchars($_POST['response_text']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['response_text'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['response_text'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['response_status']) ? " error" : "";?>">
					<label class="control-label" for="response_status">response_status</label>
					<div class="controls">
						<input class="" id="response_status" name="response_status" value="<?php echo htmlspecialchars($_POST['response_status']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['response_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['response_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $response_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Payment_response::save(".$response_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('payment_response&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	
	
	});

</script>
