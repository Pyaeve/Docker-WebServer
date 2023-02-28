<?php 
 if(isset($producto) && is_array($producto)):
    $producto_img = Imagenes_productos::get("producto_id =".$producto['producto_id'],"imagen_id DESC LIMIT 1");
    $producto_img=$producto_img[0];
    $producto_ivahora = $producto['producto_precioIVA'] > 0 ? $producto['producto_precioIVA'] : 0;
    $producto_ivaantes = $producto['producto_precioantesIVA'] > 0 ? $producto['producto_precioantesIVA'] : 0;
    $producto_precioIVA = $producto['producto_precio'] + $producto_ivahora;
    $producto_precioantesIVA = $producto['producto_precioantes'] + $producto_ivaantes;
    $producto_precio_antes = number_format($precioantesIVA,0,"",".");
    $producto_precio_actual = number_format($precioIVA,0,"","."); 
    //pr($producto_img);
?>
  <title><?=strtolower($producto['producto_nombre'])?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="http://localhost/catedral/" />
  <link rel="icon" href="assets/images/favorico.webp" type="image/x-icon"/>
  <link rel="shortcut icon" href="assets/images/favicon/1.png" type="image/x-icon"/>
  <meta name="description" content="<?=strtolower($producto['producto_descripcion'])?>"/>
  <meta name="keywords" content="<?=strtolower($producto['producto_nombre'])?>"/>
  <meta property="og:site_name" content="Farmacia y Perfumeria Catedrale"/>
  <meta property="og:locale" content="es_PY"/>
  <meta property="og:title" content="<?=strtolower($producto['producto_nombre'])?>"/>
  <meta property="og:description" content="<?=strtolower($producto['producto_descripcion'])?>"/>
  <meta property="og:type" content="Article"/>                                                           
  <meta property="og:url" content="https://farmaciacatedral.com.py/producto/<?=strtolower($producto['producto_slugit'])?>"/>
  <meta name="twitter:title" content="<?=strtolower($producto['producto_nombre'])?>" />
  <meta name="twitter:description" content="<?=strtolower($producto['producto_descripcion'])?>" />
  <meta name="twitter:site" content="Farmacia y Perfumeria Catedral, #amamoscuidarte" />
  <link rel="stylesheet" type="text/css" href="assets/css/fontawesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
  <link rel="stylesheet" type="text/css" href="assets/css/slick.css">
  <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css">
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/css/themify-icons.css">
  <link rel="stylesheet" type="text/css"  href="assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" id="color" href="assets/css/ws.css">
  <link rel="stylesheet" type="text/css" id="color" href="assets/css/toastify.css">
  <link rel="stylesheet" type="text/css" id="color" href="assets/css/catedral.css">
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZHL120EZEP"></script>
  <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-ZHL120EZEP');
  </script>
  <script type="application/ld+json">
{
  "@context": "https://schema.org/", 
  "@type": "Product", 
  "name": "<?=$producto['producto_nombre']?>",
  "image": "<?=$producto_img['imagen_image_big_url']?>",
  "description": "<?=$producto['producto_descripcion']?>",
  "brand": {
    "@type": "Brand",
    "name": "<?=$producto['marca_nombre']?>"
  },
  "sku": "<?=$producto['producto_equivalencia']?>",
  "offers": {
    "@type": "Offer",
    "url": "<?=$producto['producto_slugit']?>",
    "priceCurrency": "PYG",
    "price": "<?=$producto_precio_actual?>"
  }
}
</script>
<?php
else:
?>
  <title>Farmacia y Perfumeria Catedral, #amamoscuidarte</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="http://localhost/catedral/productos" />
  <link rel="icon" href="assets/images/favorico.webp" type="image/x-icon"/>
  <link rel="shortcut icon" href="assets/images/favicon/1.png" type="image/x-icon"/>
  <meta name="description" content="Descuentos Exclusivos en Medicamentos nacionales e internacionales, variedad de articulos para el cuidado personal y la salud"/>
  <meta name="keywords" content="farmacia, farmacia catedral, farmacia y perfumeria catedral, medicamentos nacionaloes e importados, descuentos Exclusivos"/>
  <meta property="og:site_name" content="Farmacia y Perfumeria Catedral, #amamoscuidarte"/>
  <meta property="og:locale" content="es_PY"/>
  <meta property="og:title" content="Farmacia y Perfumeria Catedral, #amamoscuidarte"/>
  <meta property="og:description" content="Descuentos Exclusivos en Medicamentos nacionales e internacionales, variedad de articulos para el cuidadod personal y la saludad"/>
  <meta property="og:type" content="Article"/>                                                           
  <meta property="og:url" content="https://www.farmaciacatedral.com.py"/>
  <meta name="twitter:title" content="Farmacia y Perfumeria Catedral, #amamoscuidarte" />
  <meta name="twitter:description" content="Descuentos Exclusivos en Medicamentos nacionales e internacionales, variedad de articulos para el cuidado personal y la salud" />
  <meta name="twitter:site" content="Farmacia y Perfumeria Catedral, #amamoscuidarte" />
  <link rel="stylesheet" type="text/css" href="assets/css/fontawesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
  <link rel="stylesheet" type="text/css" href="assets/css/slick.css">
  <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css">
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" id="color" href="assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" id="color" href="assets/css/ws.css">
  <link rel="stylesheet" type="text/css" id="color" href="assets/css/toastify.css">
  <link rel="stylesheet" type="text/css" id="color" href="assets/css/catedral.css">
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZHL120EZEP"></script>
  <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-ZHL120EZEP');
  </script>
  <script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "WebSite",
  "name": "Farmacia y Perfumeria Catedral",
  "url": "https://www.farmaciacatedral.com.py",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://www.farmaciacatedral.com.py/productos?busca={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
  <?php 

    endif;
?>