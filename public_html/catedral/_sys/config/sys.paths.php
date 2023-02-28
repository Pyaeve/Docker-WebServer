<?php
define( "baseAppFolder",	"");
define( "baseAdminFolder",	baseAppFolder . "backend/" );
define( "baseSiteFolder", 	baseAppFolder . "");

define( "pathToRoot",   	realpath(dirname( __FILE__ ) ) . '/../..' );
define( "pathToLib",   		realpath(pathToRoot) . '/_sys/lib/' );
define( "rootUpload",   	realpath(pathToRoot) . '/upload/' );
define( "pathToView",		realpath(pathToRoot) . '/_sys/lib/view/' );
define( "pathToController",	realpath(pathToRoot) . '/_sys/lib/controller/' );
define( "pathToTemplate", 	realpath(pathToRoot) . '/_sys/templates/' );
define( "pathToLog",		realpath(pathToRoot) . '/_sys/dblog/' );

define( "baseURL",     		"https://" . $_SERVER['SERVER_NAME'] . "/" . baseAppFolder );
define( "baseAdminURL",		"https://" . $_SERVER['SERVER_NAME'] . "/" . baseAdminFolder );
define( "baseSiteURL",		"https://" . $_SERVER['SERVER_NAME'] . "/" . baseSiteFolder );
define( "uploadURL",		baseURL . "upload/");
?>