<?php
	require_once('inc/config.php');
    
	$where = $_POST['where'];
	$marcas = $_POST['marcas'];
	$categoria = $_POST['categoria'];
    $params = $_POST['params'];
    $pagenum = $_POST['pagenum'];
	//echo '<h3>'."producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 ".$where.'</h3>';
	if(isset($marcas)){
		$brand_filter = implode("','", $marcas);
		//$brand_filter = addslashes($brand_filter);
        $mpar = implode(",", $marcas);
		$where .= " AND marca_nombre IN('".$brand_filter."') ";
        $params .= "&marcas=".$mpar;
		$productos = Productos::listing2(50,$pagenum,NULL,"producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 ".$where, $params);
        if(!haveRows($productos['list'])){
            $productos = Productos::listing2(50,1,NULL,"producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 ".$where, $params);
        }
		//echo '<h3>'."producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 ".$where.'</h3>'; 
		?>
        
		<!-- Productos Galeria -->
            <div class="col-md-12 col-lg-12" >
                 <div class="mbr-section-head">
                    <h5 class="mbr-section-subtitle mbr-fonts-style align-center mb-0 mt-2 display-7 ">
                        <strong><?php

                                if(isset($categoria)){
                                    $catParent = Categorias::catpag( $categoria);
                                    $listproduct = "";
                                    foreach ($catParent as $cp) {
                                       $listproduct.= $cp['categoria_id'].',';
                                    }
                                    $listproduct = substr($listproduct,0,-1);
                                }
                        ?></strong>
                    </h5>
                </div>
            </div>    
            <div class="col-10 col-lg-12 col-sm-12">
                <div class="row items" >

                       
                    <?php
                     if(haveRows($productos['list'])){
                            $cont = 0;
                            foreach ($productos['list'] as $productoRs):
                                $cont = $cont + 1; 
                            if($productoRs['producto_status'] == 1){    
                                $img = Imagenes_productos::get("producto_id =".$productoRs['producto_id'],"imagen_id DESC LIMIT 1");
                                $img = isset($img[0]['imagen_image_big_url']) ? $img[0]['imagen_image_big_url'] : "images/sin-img.webp";
                                
                                $promoClassrel = "";
                                if($productoRs['producto_descuento'] > 0 && $productoRs['producto_mostrar'] == "S"){
                                     $promoClassrel = promo($productoRs['producto_descuento']);
                                }
                                
                                $ivahora = $productoRs['producto_precioIVA'] > 0 ? $productoRs['producto_precioIVA'] : 0;
                                $ivates = $productoRs['producto_precioantesIVA'] > 0 ? $productoRs['producto_precioantesIVA'] : 0;
                                $precioIVA = $productoRs['producto_precio'] + $ivahora;
                                $precioantesIVA = $productoRs['producto_precioantes'] + $ivates;
                                
                                $antes = number_format($precioantesIVA,0,"",".");
                                $actual = number_format($precioIVA,0,"","."); 
                                if($productoRs['producto_precio'] > 0 AND $productoRs['producto_stock'] > 0){
                                     
                               ?>
                                            

                        <!-- loop de productos -->
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="product-box bg-white ">
                                <a href="producto/<?=$productoRs['producto_slugit']?>"  title="<?=$productoRs['producto_nombre']?>">
                                    <div class="ribbon ribbon-top-right">  
                                        <span class="desc-promo<?=$productoRs['producto_descuento']?>"><?=$productoRs['producto_descuento']?>% OFF</span>
                                    </div>
                                    <div class="img-block">
                                        <img src="<?=$img?>" class="img img-responsive img-fluid " alt="<?=$productoRs['producto_nombre']?>" title="<?=$productoRs['producto_nombre']?>" />                         
                                    </div>
                                </a>
                                <div class="product-info">
                                    <a href="producto/<?=$productoRs['producto_slugit']?>"  title="<?=$productoRs['producto_nombre']?>"><h6><?=substr($productoRs['producto_nombre'],0,40)."..."?></h6></a>
                                    <span><b><?=$productoRs['marca_nombre']?></b></span>
                                        <h5>Gs. <s><?=$antes?> </s></h5>
                                        <h5 class="text-success">Gs.  <?=$actual?></h5>
                                      
                                        <a href="javascript:;" class="btn btn-solid btn-success btnAddCart item_add" rel="<?php echo $productoRs['producto_id'] ?>">
                                            <i class="fa fa-shopping-cart" >agregar</i>
                                        </a>
                                    
                                </div>
                            </div>
                          </div>  
                            <!-- /loop de productos -->
                               <?php
                                    
                                }//ValPrecio
                            }//Status
                            endforeach;
                            
                        }else{
                            echo "No se han encontrado Productos";
                        }
                    ?>
                   
                    <div class="сol-12 col-md-12 col-lg-12">
                        <div class="pagination pagination-lg"><?php echo $productos["navigation"]?>
                            
                        </div>
                    </div>
                </div> 
            </div>
                <script>
                 //Carrito
  $('.item_add').click(function(){
          var producto_id = $(this).attr('rel');
          var cantidad = '1';
       
          //$.blockUI({ message: '<h2 class="blockUI" style="padding:20px 20px 20px 20px;"> Aguarde un momento por favor...</h2>' });
          $.ajax({
            url:'ajax/carrito',
            dataType:'json',
            type:'post',
            data:"accion=agregar&producto_id="+producto_id+"&cantidad="+cantidad,
            success: function(response){
              if(response.status=="success"){
                 var bgColors = [
                    "background-color(#51a351)",
                 ], 
                 i = 0;
                 Toastify({
                    text: "Producto agregado al carrito",
                    duration: 3000,
                    close: i % 3 ? true : false,
                    backgroundColor: bgColors[i % 2],
                  }).showToast();
                 i++;

                $('.itemCartTotal').html(response.items);
                //$('.itemCartTotal').html("a");

              }else{
                swal("¡Atención!", response.description , "warning");
              }
            }
          });
  });
   $('.items').flyto({
            item      : '.product-box',
            target    : '.cart-image',
            button    : '.item_add'
        });

  //Carrito
  function add(producto_id){
                //var producto_id = $(this).attr('rel');
                var cantidad = '1';
                //$.blockUI({ message: '<h2 class="blockUI" style="padding:20px 20px 20px 20px;"> Aguarde un momento por favor...</h2>' });
                $.ajax({
                    url:'../ajax/carrito',
                    dataType:'json',
                    type:'post',
                    data:"accion=agregar&producto_id="+producto_id+"&cantidad="+cantidad,
                    success: function(response){
                    if(response.status=="success"){
                        var bgColors = [
                            "background-color(#51a351)",
                        ], 
                        i = 0;
                        Toastify({
                            text: "Producto agregado al carrito",
                            duration: 3000,
                            close: i % 3 ? true : false,
                            backgroundColor: bgColors[i % 2],
                        }).showToast();
                        i++;
                        
                        $('.itemCartTotal').html(response.items);

                    }else{
                        swal("¡Atención!", response.description , "warning");
                    }
                    }
                });
        }; 
            </script>  
            <?php

	}else{
		
		$productos = Productos::listing2(50,$pagenum,NULL,"producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 ".$where, $params);
		//echo '<h3>'.$where.'</h3>';  
		//echo $productos["navigation"];  
		?>
		<!-- Productos Galeria -->
            <div class="col-md-6 col-lg-10" >
                 <div class="mbr-section-head">
                    <h5 class="mbr-section-subtitle mbr-fonts-style align-center mb-0 mt-2 display-7 ">
                        <strong><?php
                                if(isset($categoria)){
                                    $catParent = Categorias::catpag( $categoria);
                                    $listproduct = "";
                                    foreach ($catParent as $cp) {
                                       $listproduct.= $cp['categoria_id'].',';
                                    }
                                    $listproduct = substr($listproduct,0,-1);
                                }
                        ?></strong>
                    </h5>
                </div>
                <div class="row mt-4 items" style="width: 130%;">
                    <?php
                        if(haveRows($productos['list'])){
                            $cont = 0;
                            foreach ($productos['list'] as $productoRs):
                                $cont = $cont + 1; 
                            if($productoRs['producto_status'] == 1){    
                                $img = Imagenes_productos::get("producto_id =".$productoRs['producto_id'],"imagen_id DESC LIMIT 1");
                                $img = isset($img[0]['imagen_image_big_url']) ? $img[0]['imagen_image_big_url'] : "images/sin-img.webp";
                                
                                $promoClassrel = "";
                                if($productoRs['producto_descuento'] > 0 && $productoRs['producto_mostrar'] == "S"){
                                     $promoClassrel = promo($productoRs['producto_descuento']);
                                }
                                
                                $ivahora = $productoRs['producto_precioIVA'] > 0 ? $productoRs['producto_precioIVA'] : 0;
                                $ivates = $productoRs['producto_precioantesIVA'] > 0 ? $productoRs['producto_precioantesIVA'] : 0;
                                $precioIVA = $productoRs['producto_precio'] + $ivahora;
                                $precioantesIVA = $productoRs['producto_precioantes'] + $ivates;
                                
                                $antes = number_format($precioantesIVA,0,"",".");
                                $actual = number_format($precioIVA,0,"","."); 
                                if($productoRs['producto_precio'] > 0 AND $productoRs['producto_stock'] > 0){
                                     
                               ?>
                    <!-- loop de productos -->
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="product-box bg-white ">
                                <a href="producto/<?=$productoRs['producto_slugit']?>" title="<?=$productoRs['producto_descuento']?>">
                                    <div class="ribbon ribbon-top-right desc-<?=$productoRs['[producto_descuento']?>">
                                       <span class="desc-promo<?=$productoRs['producto_descuento']?>"><?=$productoRs['producto_descuento']?>% OFF</span>
                                    </div>
                                    <div class="img-block">
                                        <img src="<?=$img?>" class="product-img-<?=$productoRs['producto_id']?> img img-responsive img-fluid " alt="<?=$productoRs['producto_nombre']?>" title="<?=$productoRs['producto_nombre']?>" />                             
                                    </div>
                                </a>
                                <div class="product-info">
                                    <a href="producto/<?=$productoRs['producto_slugit']?>"><h6><?=substr($productoRs['producto_nombre'],0,40)."..."?></h6></a>
                                    <span><b><?=$productoRs['marca_nombre']?></b></span>
                                        <h5>Gs. <s><?=$antes?> </s></h5>
                                        <h5 class="text-success">Gs.  <?=$actual?></h5>
                                        <span class="row text-center">
                                        <a href="javascript:;" class="btn btn-solid btn-success btnAddCart item_add" rel="<?php echo $productoRs['producto_id'] ?>">
                                            <i class="fa fa-shopping-cart" >agregar</i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                          </div>  
                            <!-- /loop de productos -->
                                                    
                               <?php
                                    
                                }//ValPrecio
                            }//Status
                            endforeach;
                            
                        }else{
                            echo "No se han encontrado Productos";
                        }
                    ?>
					<?php 
                    
                    //$nav = Productos::listing2(9,$pagenum,NULL,"producto_status = 1 AND producto_precio > 0 AND producto_stock > 0 ".$where, $params);?> 
                    <div class="сol-12 col-md-12 col-lg-12">
                        <div class="pagination"><?php echo $productos["navigation"];?></div>
                    </div>
                </div>   
            </div> 
            <script>
                 //Carrito
  $('.item_add').click(function(){
          var producto_id = $(this).attr('rel');
          var cantidad = '1';
         
          //$.blockUI({ message: '<h2 class="blockUI" style="padding:20px 20px 20px 20px;"> Aguarde un momento por favor...</h2>' });
          $.ajax({
            url:'ajax/carrito',
            dataType:'json',
            type:'post',
            data:"accion=agregar&producto_id="+producto_id+"&cantidad="+cantidad,
            success: function(response){
              if(response.status=="success"){
                 var bgColors = [
                    "background-color(#51a351)",
                 ], 
                 i = 0;
                 Toastify({
                    text: "Producto agregado al carrito",
                    duration: 3000,
                    close: i % 3 ? true : false,
                    backgroundColor: bgColors[i % 2],
                  }).showToast();
                 i++;

                $('.itemCartTotal').html(response.items);
                //$('.itemCartTotal').html("a");

              }else{
                swal("¡Atención!", response.description , "warning");
              }
            }
          });
  });
     $('.items').flyto({
            item      : '.product-box',
            target    : '.cart-image',
            button    : '.item_add'
        });


  //Carrito
  function add(producto_id){
                //var producto_id = $(this).attr('rel');
                var cantidad = '1';
                //$.blockUI({ message: '<h2 class="blockUI" style="padding:20px 20px 20px 20px;"> Aguarde un momento por favor...</h2>' });
                $.ajax({
                    url:'../ajax/carrito',
                    dataType:'json',
                    type:'post',
                    data:"accion=agregar&producto_id="+producto_id+"&cantidad="+cantidad,
                    success: function(response){
                    if(response.status=="success"){
                        var bgColors = [
                            "background-color(#51a351)",
                        ], 
                        i = 0;
                        Toastify({
                            text: "Producto agregado al carrito",
                            duration: 3000,
                            close: i % 3 ? true : false,
                            backgroundColor: bgColors[i % 2],
                        }).showToast();
                        i++;
                        
                        $('.itemCartTotal').html(response.items);

                    }else{
                        swal("¡Atención!", response.description , "warning");
                    }
                    }
                });
        }; 
            </script><?php
	}

	

    
?>
