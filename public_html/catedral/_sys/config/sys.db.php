<?php
# Parametros de conexion MySQL 
######################################################
#--------------SERVER TIGO----------------------------
######################################################
define('DBUser',    isLocal ? 'root' : 	'root'	);
define('DBPass',    isLocal ? 'rootpassword'	: 'rootpassword'		);
define('DBHost',    isLocal ? '172.19.0.2'           : '172.19.0.2');
define('DBName',    isLocal ? 'farmacia_db'	        : 'farmacia_db');
?>
