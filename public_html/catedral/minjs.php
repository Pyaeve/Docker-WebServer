<?php 
include('inc/jsmin.php');
$files = glob("assets/js2/*.js");
$js = "";
foreach($files as $file) {
    $js .= JSMin::minify(file_get_contents($file));
}

//var_dump($files);
file_put_contents("assets/js/catedral.js", $js);

?>