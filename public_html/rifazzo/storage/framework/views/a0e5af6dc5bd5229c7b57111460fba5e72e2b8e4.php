<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
         <div class="row mb-2">
           <div class="col-md-12">
               <?php echo Breadcrumbs::render('UtilCalculadora');; ?>

            </div><!-- /.col -->
        </div><!-- /.row -->
        </div> <!-- /.container-fluid -->
         </div> <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                       <!-- carrd -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Calculadora de Riesgos por Jugada</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                     <?php echo BootForm::open(); ?>

                                   
                                    <div class="row">   
                                        <div class="col-md-2">
                                           
                                                <?php echo BootForm::text('Premios ', 'premio')->attr('required')->maxlength(10)->minlength(4)->addClass('premio')->value('400000'); ?>

                                            
                                        </div> 
                                        <div class="col-md-2">
                                           
                                                <?php echo BootForm::text('Precio', 'precio')->attr('required')->maxlength(11)->minlength(4)->addClass('precio')->value('2000'); ?>

                                            
                                        </div>  
                                         <div class="col-md-2">
                                           
                                                <?php echo BootForm::text('Importe','importe')->attr('required')->maxlength(11)->minlength(4)->addClass('importe')->value('2000')->disabled(); ?>

                                            
                                        </div> 
                                        
                                        <div class="col-md-2">
                                           
                                                <?php echo BootForm::text('% Comision ', 'comision_porc')->maxlength(2)->minlength(2)->addClass('comision_porc')->value('30'); ?>

                                           
                                        </div>  
                                        <div class="col-md-2">
                                           
                                                <?php echo BootForm::text('Comision Importe', 'comision_importe')->attr('required')->maxlength(2)->minlength(2)->disabled()->addClass('comision_importe'); ?>

                                           
                                        </div>  
                                        <div class="col-md-2">
                                           
                                                <?php echo BootForm::text('Cant total de Rifas ', 'cant_total')->attr('required')->maxlength(11)->minlength(1)->disabled()->addClass('cant_total'); ?>

                                           
                                        </div>  
                                        <div class="col-md-2">
                                            
                                                <?php echo BootForm::text('Vendedores', 'vendedores')->attr('required')->maxlength(4)->minlength(1)->required()->addClass('vendedores')->value('20'); ?>

                                            
                                        </div>   
                                          <div class="col-md-2">
                                           
                                                <?php echo BootForm::text('Rifas x Vendedor ', 'cant_vendedor')->attr('required')->maxlength(11)->minlength(1)->disabled()->addClass('cant_vendedores'); ?>

                                           
                                        </div>  
                                         <div class="col-md-2">
                                            
                                                <?php echo BootForm::text('Gastos', 'gastos')->attr('required')->maxlength(11)->minlength(4)->required()->addClass('gastos')->value('200000'); ?>

                                            
                                        </div>   
                                         <div class="col-md-2">
                                            
                                                <?php echo BootForm::text('Ganancias', 'ganancias')->attr('required')->maxlength(11)->minlength(4)->required()->addClass('ganancias')->value('200000'); ?>

                                            
                                        </div>   
                                      
                                    </div>

                                      <a class="btn btn-default calcular " href="#">Calcular</a>
                                    <?php echo BootForm::close(); ?>

                                    
                                </div>   
                            </div>
    
                        </div>
                        <!-- /card -->
                    </div>
                </div>
            </div>     
        </section>
<!-- /.Main content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
  $('.calcular').click(function(){
    cal_valores();
   
  });
  $(':input').css('text-align','right');
  $(':input').change(function(){

     cal_valores();
  });

  function cal_valores(){
     var precio = parseInt($('.precio').val());
    var premio = parseInt($('.premio').val());
    var com_porc = parseInt($('.comision_porc').val());
    var com_importe = cal_comision(precio,com_porc);
    var ganancias = parseInt($('.ganancias').val());
    var importe = (precio - com_importe) ; 
    var gasto = parseInt($('.gastos').val())+premio + ganancias;
  
    var cant_total = (gasto / importe);
    var vendedores = parseInt($('.vendedores').val());
    var cant_vendedores = cant_total/vendedores;
    
    $('.importe').val(importe);
    $('.cant_total').val(cant_total);
    $('.cant_vendedores').val(cant_vendedores);
    $('.comision_importe').val(com_importe);
  }

  function cal_comision(monto, porc){
    var com= monto*porc/100;
    return com;
  }

    cal_valores();


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.bs3.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\rifazzo\resources\views/admin/utilidades/calculadora.blade.php ENDPATH**/ ?>