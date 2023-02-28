<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//phpinfo();
//Carpeta donde se guarda la marca de agua y las imagenes
$directorio=__DIR__.'/';

//Escanear todas las imagenes
$imagenes = preg_grep('~\.(jpeg|jpg|png|webp)$~', scandir($directorio,1));

//Cargar la marca de agua
$estampa = imagecreatefrompng($directorio.'watermark.png');

//Recorrer el directorio
for ($i=0; $i < count($imagenes); $i++) {
	//Excluir marca de agua llamada "logo.png"
	if($imagenes[$i]!='watermark.png'){
		//Tipoo de fichero
		//$tipo=mime_content_type($directorio.$imagenes[$i]);
		//Cargar ima imagen recien guardada (jpg y png)
		//if($tipo=='image/jpg' or $tipo=='image/jpeg'){
			//$im = imagecreatefromjpeg($directorio.$imagenes[$i]);
		//} else if($tipo=='image/png'){
		//	$im = imagecreatefrompng($directorio.$imagenes[$i]);
		//} else if($tipo == 'image/webp'){
			$im = imagecreatefromwebp($directorio.$imagenes[$i]);
		//}
			echo " <pre>";
			print_r($im);
			die("</pre>");
		//Establecer los márgenes para la estampa
		$margen_dcho = 10;
		$margen_inf = 10;
		$sx = imagesx($estampa);
		$sy = imagesy($estampa);
		// Copiar la imagen de la estampa sobre nuestra foto usando los índices de márgen y el 
		imagecopy($im, $estampa, (imagesx($im) - $sx - $margen_dcho), (imagesy($im) - $sy - $margen_inf), 0, 0, imagesx($estampa), imagesy($estampa));
		//Remplazar la imagen con la marca de agua
		//if($tipo=='image/jpg' or $tipo=='image/jpeg'){
		//	imagejpeg($im,$directorio.$imagenes[$i]);
		//} else if($tipo=='image/png'){
		//	imagepng($im,$directorio.$imagenes[$i]);

		//} else if($tipo=='image/webp'){
			imagewebp($im,$directorio.$imagenes[$i]);

		//}

	}

}

?>