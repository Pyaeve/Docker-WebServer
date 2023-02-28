<?php 
	require_once('../../_sys/init.php');

			$i = numParam('cantidad')+1;
			$html = "
				<input class='datotel' id='dato_infotel".$i."' name='dato_infotel[]' type='text' style='color:#000;' />
				<p class='r".$i."'></p>";


			$result = array("status" => "success", "content" => $html);
			echo json_encode($result);
			exit();
			
?>