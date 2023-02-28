<?php 
require_once("_sys/init.php");
session_unset();
session_destroy();
header("location:index.php");
exit();
?>
