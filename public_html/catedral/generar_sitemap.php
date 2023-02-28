<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('inc/config.php');
$productos =db::execute("CALL PRO_PRODUCTOS_LISTAR_TODOS();");


$dominio = "https://farmaciacatedral.com.py";


$xml = '<?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
        <url>
          <loc>'.$dominio.'</loc>
          <lastmod>'.date("Y-m-d").'</lastmod>
          <changefreq>daily</changefreq>
       </url>';

    foreach ($productos as $p) {
        
        $xml .= '<url>
          <loc>'.$dominio.'/producto/'.$p['LINK'].'</loc>
          <lastmod>'.date("Y-m-d").'</lastmod>
          <changefreq>weekly</changefreq>
        </url> ';
       

    }
       
      
        $xml .='</urlset>';

// Opcion 2
header('Content-type:text/xml;charset:utf8');
echo $xml;

?>