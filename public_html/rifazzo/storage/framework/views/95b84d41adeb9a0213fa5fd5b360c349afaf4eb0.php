<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
         <div class="row mb-2">
           <div class="col-md-12">
               <?php echo Breadcrumbs::render('SorteosCargar');; ?>

            </div<!-- /.col -->
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
                                <h3 class="card-title">Cargar Sorteos </h3>
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
                                <div class="col-md-10 offset-md-1">
                                     <?php echo BootForm::open()->action(route('backend.sorteos.guardar')); ?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><b>Jugada Nro:</b> <?php echo $jugada_id; ?></p>

                                        </div>
                                        <div class="col-md-6">
                                            <p><b>Fecha Sorteo:</b> <?php echo $jugada_fecha; ?></p> 
                                        </div>
                                    </div>
                                    <div class="row">   
                                   <?php echo BootForm::hidden('jugada_id')->value($jugada_id); ?>

                                   <?php echo BootForm::hidden('jugada_fecha')->value($jugada_fecha); ?>

                                        <?php echo BootForm::hidden('agencia_id')->value($agencia_id); ?>

                                        <div class="col-md-4">
                                           
                                                <?php echo BootForm::text('Sorteo 1', 'sorteo_1')->attr('required')->maxlength(4)->minlength(4)->addClass('sorteo_1'); ?>

                                            
                                        </div> 
                                        <div class="col-md-4">
                                           
                                                <?php echo BootForm::text('Sorteo 2', 'sorteo_2')->attr('required')->maxlength(4)->minlength(4)->required()->addClass('sorteo_2'); ?>

                                           
                                        </div>  
                                        <div class="col-md-4">
                                            
                                                <?php echo BootForm::text('Sorteo 3', 'sorteo_3')->attr('required')->maxlength(4)->minlength(4)->required()->addClass('sorteo_3'); ?>

                                            
                                        </div>   
                                      
                                    </div>
                                    <?php echo BootForm::submit('Cargar')->addClass('btn btn-primary'); ?>

                                      <a class="btn btn-default" href="<?php echo route('backend.jugadas.resumen'); ?>">Cancelar
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.bs3.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\rifazzo\resources\views/admin/sorteos/cargar.blade.php ENDPATH**/ ?>