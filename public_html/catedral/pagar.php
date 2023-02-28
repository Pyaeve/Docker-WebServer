<?php
    require_once('inc/config.php');
    if(!isset($_SESSION['cli_reg'])){
        #Si no existe session redirecciona
        header("Location:productos");
        exit();
    }
    
    $process_id = addslashes($_GET['process_id']);
    if(empty($process_id)){
        header("Location:productos");
        exit();
    }
    $delivery = $_GET['deli'];

    $tarjeta = $_GET['tarj'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include("inc/head.php")?>  
 
  <script src="https://vpos.infonet.com.py/checkout/javascript/dist/bancard-checkout-2.0.0.js"></script>
  <style>
      iframe{ height:500px;}
  </style>
<script type="text/javascript">
    window.onload = function () {
      Bancard.Checkout.createForm('iframe-container', '<?php echo $process_id;?>');
    };
  </script>
</head>

<body>
    <?php require_once('inc/header-v2.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>

<!-- PRODUCTOS GALERIA -->
<section class="content1 cid-scEieb16NW" id="content1-2y" style="">


<div class="container">
    <div class="row">
            <div class="col-lg-5 pull-lg-3 col-md-6 pull-md-6">
            <!-- -->
            
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-2 display-7 text-center border-bottom"><strong>SU PEDIDO</strong></h3>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 text-left"><strong>PRODUCTO</strong></div>
                        <div class="col-md-6 col-lg-6 text-right"><strong>TOTAL</strong></div>
                        <?php
                            $totalPrecio = 0;
                            foreach ($items as $item):
                                if(haveRows($item)){
                                    $subtotal = $item['producto_precio']*$item['detalle_cantidad'];
                                    
                                    $producto_code = Productos::select($item['producto_id']);
                                    if($tarjeta == '039'){
                                      $subtotal = ($producto_code[0]['producto_precioantes']+$producto_code[0]['producto_precioantesIVA'])*$item['detalle_cantidad'];  
                                    }else{
                                      $subtotal = ($producto_code[0]['producto_precio']+$producto_code[0]['producto_precioIVA'])*$item['detalle_cantidad'];
                                    }
                                    
                                    $totalPrecio += $subtotal;
                        ?>
                            <div class="col-md-6 col-lg-7 listP text-left mt-3">
                                <?php echo $item['producto_nombre']; ?>
                            </div>
                            <div class="col-md-6 col-lg-1 listP text-right mt-3"><?php echo $item['detalle_cantidad'];?></div>
                            <div class="col-md-6 col-lg-4 listP text-right mt-3" name="precio_descuento" style="display:block;">Gs. <?php echo number_format($subtotal,0,'','.'); ?></div>
                        <?php 
                                }
                            endforeach;
                            //agregado por Daniel Galeano. 13/08/2021
                            //id de producto delivery 9736
                            $producto = Productos::select(9736);
                            $precio_del = $producto[0]['producto_precio'];
                            $iva_del = $producto[0]['producto_precioIVA'];
                            $precio_del_iva = $precio_del + $iva_del;
                            if($delivery <> 1){
                              $precio_del_iva = 0;
                            }
                            //mínimo de compra
                            $parametro = Parametros::select(1);
                            $compra_minima = $parametro[0]['para_valor_numerico'];
                                                    
                            //$totalPrecio_mostrador_deli = $totalPrecio_mostrador + $precio_del_iva;

                        ?>
                       
                                                              
                        
                        <div class="col-md-6 col-lg-6 listP text-left mt-3"><strong>SUB TOTAL</strong></div>
                        <div class="col-md-6 col-lg-6 listP text-right mt-3" name="sub_total" style="display:block"><strong>Gs. <?php echo ($totalPrecio>0) ?number_format($totalPrecio,0,'','.') : 0; ?></strong></div>
                        
                        <div class="col-md-6 col-lg-6 listP text-left mt-3"><strong>COSTO DE ENVIO</strong></div>
                        <div class="col-md-6 col-lg-6 listP text-right mt-3 " id="envios"><strong id="compra_del" name="compra_del" style="display: block;"> <?php echo ($totalPrecio>$compra_minima) ? number_format($precio_del_iva,0,'','.') : 0; ?></strong></div>

                        <div class="col-md-6 col-lg-6 text-left mt-4"><strong>TOTAL</strong></div>

                        <div class="col-md-6 col-lg-6 text-right mt-4" id="montos">
                            <strong id="total_con_del" name="total_con_del" style="display: block;">Gs. <?php echo ($totalPrecio>$compra_minima) ?number_format($totalPrecio+$precio_del_iva,0,'','.') : number_format($totalPrecio,0,'','.'); ?></strong>
                        </div>
                    </div>

            <!-- -->
            </div>
            <div class="col-lg-7 pull-lg-3 col-md-6 pull-md-6">
                  <h2 class="mbr-section-title mbr-fonts-style mb-0 text-center display-7"><strong>REALIZAR PAGO</strong></h2>
                  <div style="height: 500px; width: 100%; margin: auto" id="iframe-container"/>
                                                
            </div>
             <div class="col-auto mbr-section-btn align-center">
                    <a href="checkout_result.php?action=cancel&order=<?php echo $process_id;?>" class="btn btn-primary display-4">Cancelar</a>
            </div>

    </div>
</div>
 
</section>

<!-- FOOTER -->
<?php require_once('inc/footer-v2.php'); ?>


