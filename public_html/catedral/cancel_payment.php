<?php
require_once("_sys/init.php");
header("Location: checkout_result.php?action=cancel&order={$_GET['order']}");
exit;
?>
