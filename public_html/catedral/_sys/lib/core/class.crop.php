<?php
/**
* Crop de imagenes
* By Christian Benitez
*/
class Crop {

	public function cropping($image_src,$x,$y,$dst_w,$dst_h,$scaleX,$scaleY){
		list($image_src,$nn) = explode("?", $image_src);
		$source = $image_src;
		$temp = explode("/", $image_src);
		$dst = end($temp);

		list($n,$image_src) = explode("upload/",$image_src);

		$source_image = rootUpload.$image_src;
		$what = getimagesize($source_image);
		switch(strtolower($what['mime']))
		{
		    case 'image/png':
				$src_img = imagecreatefrompng($source_image);
				$type = '.png';
		        break;
		    case 'image/jpeg':
				$src_img = imagecreatefromjpeg($source_image);
				error_log("jpg");
				$type = '.jpeg';
		        break;
		    case 'image/gif':
				$src_img = imagecreatefromgif($source_image);
				$type = '.gif';
		        break;
		    default: 
		    	$msg = "Tipo de imagen no soportado.";
      			$status = "error";
		}

		$src_x = $what->x;
      	$src_y = $what->y;
      	$src_w = $what[0];
      	$src_h = $what[1];

		$dst_img = imagecreatetruecolor((int)$dst_w, (int)$dst_h);
		imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
      	imagesavealpha($dst_img, true);
      	$ratio = $src_w / $dst_w;
      	$dst_x /= $ratio;
      	$dst_y /= $ratio;

      	$result = imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, (int)$dst_w, (int)$dst_h, $src_w, $src_h);
      	imagecopy($dst_img, $src_img, 0,0, $x, $y, $dst_w, $dst_h);
      	@chmod($dst_img,0644);
      	if ($result) {
      		$msg = $result;
      		$status = "success";
	        if (!imagepng($dst_img, $source_image)) {
	          	$msg = "Error al guardar la imagen cortada.";
      			$status = "error";
	        }
	    } else {
	        $msg = "Error al intentar cortar la imagen.";
      		$status = "error";
	    }

    	imagedestroy($src_img);
      	imagedestroy($dst_img);
	    return json_encode(array("status"=>$status,"description"=>$msg,"sourse"=>$source,"src_x"=>$x,"src_y"=>$y));
	}

}
?>