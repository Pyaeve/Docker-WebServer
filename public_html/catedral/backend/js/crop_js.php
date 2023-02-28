<?php
require_once('../../_sys/init.php');

$crop = new Crop;
$result = $crop->cropping(param('image_src'),numParam('x'),numParam('y'),numParam('width'),numParam('height'),numParam('scaleX'),numParam('scaleY'));
print $result;
?>