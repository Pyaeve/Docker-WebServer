<?php
$a="2023-01-30";
$b="2023-01-01";

$a=strtotime($a);
$b=strtotime($b);

if($a > $b){
   echo date('Y-m-d',$a)." es MAYOR que $b";
} elseif($a == $b) {
   echo "IGUALES";
}else{ 
   echo "$a es MENOR quie $b";
}

?>