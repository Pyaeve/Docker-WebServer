<?php
/*zona horaria*/
date_default_timezone_set('America/Asuncion');

/**/
define( "isLocal",     	true ); 		/*si se trabaja de manera local*/
define( "sysName",      "Catedral" );    	/*nombre del cms*/
define( "sysVersion",   "Release 3.0.5");
define( "domainName",	"catedral.com.py");
define( "logEnabled", 	true);	    	/*habilita log de consultas sql*/
define( "By", 			"Puntopy");

/**/
define( "encryptionKey", md5("Catedral2021") );

/**/
$domainName = explode('.', domainName);
$domainName = $domainName[0];
$sessionSub = strtolower(metaphone($domainName));

define( "authToken",		strrev(md5(sha1(session_id()))));
define( "adminLogin",		"_adl_" . $sessionSub );
define( "userLogin",		"_usl_" . $sessionSub );
define( "messageVar", 		"_msgflash_" . $sessionSub );

/**/
define( "MESSAGE_ERROR",		"ERROR" );
define( "MESSAGE_SUCCESS",		"SUCCESS" );
define( "MESSAGE_WARNING",		"WARNING" );
define( "MESSAGE_INFORMATION",	"INFORMATION" );
define( "MESSAGE_QUESTION",		"QUESTION" );

/*CUENTAS (agregar en esta parte todas las cuentas de correo)*/
define( "SENDER",		"no_responder@".domainName );
define( "CONTACT_EMAIL",	"diego.amarilla@puntopy.com" );


require_once( 'sys.paths.php' );
require_once( 'sys.db.php' );
require_once( 'sys.smtp.php' );

/*BANCARD*/
$private_key	        = 'GRhVTPcYF.kkb.(xNxbfOtJtcntZIu5m(gA8lZ9n';
$public_key		        = 'rra93UtE8y6DF5Yiok3pH6dtUP4VBAHc';
$private_key_staging	= 'wvQm5jnZlrvFRY6ou$WNR8NozNDHq(CdE3iyw7(N';
$public_key_staging		= 'zAYrMpYi7jGndJosJE7SQoQ7hzPfC0Qi';

$service_url	    = 'https://vpos.infonet.com.py/vpos/api/0.3/single_buy';
$paytoken_url	    = 'https://vpos.infonet.com.py/vpos/api/0.3/charge';
$paytoken_urls	    = 'https://vpos.infonet.com.py:8888/vpos/api/0.3/charge';
$redirect_url	    = 'https://vpos.infonet.com.py/payment/single_buy';
$newcard_url	    = 'https://vpos.infonet.com.py/vpos/api/0.3/cards/new';
$newcard_urls	    = 'https://vpos.infonet.com.py:8888/vpos/api/0.3/cards/new';
$usercard_url	    = 'https://vpos.infonet.com.py/vpos/api/0.3/users/';
$usercard_urls	    = 'https://vpos.infonet.com.py:8888/vpos/api/0.3/users/';

$confirmations_url           = 'https://vpos.infonet.com.py/vpos/api/0.3/single_buy/confirmations';
$confirmations_urls          = 'https://vpos.infonet.com.py:8888/vpos/api/0.3/single_buy/confirmations';
$rollback                    = 'https://vpos.infonet.com.py/vpos/api/0.3/single_buy/rollback';
$rollbacks                   = 'https://vpos.infonet.com.py:8888/vpos/api/0.3/single_buy/rollback';

$cancel_url		= baseURL.'cancel_payment.php';
$return_url		= baseURL.'checkout_result.php';
$return_urlT	= baseURL.'checkout_result_token.php';
$return_urlC	= baseURL.'tarjetas.php';

$cancel_urlZ	= baseURL.'cancel_payment_zimple.php';
$return_urlZ	= baseURL.'checkout_result_zimple.php';

#CATEDRAL
$consulta_url = "http://appcatedral.farmaciacatedral.com.py:8181/charliJavaEnvironment/rest/consulta";
#Para realizar consultas de Stock (disponibilidad) o listar productos No es necesario usuario y clave

# E-COMMERCE #
$ecommerce_url = "http://appcatedral.farmaciacatedral.com.py:8181/charliJavaEnvironment/rest/ECOMERCE";

# E-COMMERCEv2 #
$ecommerce_url_cate = "http://appcatedral.farmaciacatedral.com.py:8181/charliJavaEnvironment/rest/ECOMERCE_CATE";

#Listar productos
$listProducto_url = "http://appcatedral.farmaciacatedral.com.py:8181/charliJavaEnvironment/rest/ListarEcomerce";

#Disponible Obtiene el precio y el Stock
$disponibilidad = "http://appcatedral.farmaciacatedral.com.py:8181/charliJavaEnvironment/rest/disponibilidad";

$listarpromociones = "http://appcatedral.farmaciacatedral.com.py:8181/charliJavaEnvironment/rest/ListarPromociones";

#Listar métodos de pago crédito y linea de crédito del cliente
$credito_clientes = "http://appcatedral.farmaciacatedral.com.py:8181/charliJavaEnvironment/rest/credito_clientes";

#Listar depósitos
$listardepositos = "http://appcatedral.farmaciacatedral.com.py:8181/charliJavaEnvironment/rest/ListarDepositos";

?>