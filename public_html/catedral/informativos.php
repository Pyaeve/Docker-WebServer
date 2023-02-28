<?php
    include("inc/config.php");
?>
<!DOCTYPE html>
<html  >
<head>
  <? include("inc/head.php")?>  
  <title>Catedral</title>
    <!-- Owl Stylesheets -->
   <link rel="stylesheet" href="assets/owlcarousel/assets/owl.carousel.min.css">
   <link rel="stylesheet" href="assets/owlcarousel/assets/owl.theme.default.min.css">
    
    <link href="js/lightbox/lightbox.min.css" rel="stylesheet" />
    <style>
        .cid-scEavRZm1L{ padding:0;}
        .owl-dots button:focus {
            outline:0px auto -webkit-focus-ring-color;
        }
    </style>
</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 

<section class="features3 cid-scK97Y6blY" id="features4-4u">    
    <div class="container">
        <div class="mbr-section-head">
            <h4 class="mbr-fonts-style align-center mb-0 display-5"><strong>Informate con nuestra de guía de cuidados</strong></h4>
        </div>
        <div class="row mt-4">
            <?

                $noticias = Noticias::listing(9,pageNumber());
                foreach ($noticias['list'] as $noticia) {
                    ?>
            <div class="item features-image сol-12 col-md-6 col-lg-3">
                <div class="item-wrapper">
                    <div class="item-img">
                        <img src="<?=$noticia['noticia_image_big_url']?>" alt="" title="" data-slide-to="0">
                    </div>
                    <div class="item-content">
                        <p class="item-title mbr-fonts-style"><strong><?=$noticia['noticia_titulo']?></strong></p>
                    </div>
                    <div class="mbr-section-btn item-footer mt-2">
                        <a href="informativo/<?=$noticia['noticia_slugit']?>" class="btn item-btn btn-primary">Leer Más</a>
                    </div>
                </div>
            </div>
                    <?
                }
            ?>
            <div class="сol-12 col-md-12 col-lg-12">
                        <div class="pagination"><?=$noticias["navigation"]?></div>
            </div>
            
        </div>
    </div>
</section>


<?php
   include("inc/footer.php");
?>

 <div id="scrollToTop" class="scrollToTop mbr-arrow-up">
    <a style="text-align: center;"><i class="mbr-arrow-up-icon mbr-arrow-up-icon-cm cm-icon cm-icon-smallarrow-up"></i></a>
</div>

  </body>
</html>