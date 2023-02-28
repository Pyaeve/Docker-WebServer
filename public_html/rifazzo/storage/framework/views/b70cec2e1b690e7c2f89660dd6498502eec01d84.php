<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
         
            <div class="col-md-12">
               <?php echo Breadcrumbs::render('Jugadas');; ?>

            </div><!-- /.col -->
        </div><!-- /.row -->
        </div> <!-- /.container-fluid -->
         </div> <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Ver Resumen de Caja</h3>
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
                                <?php $now = date('Y-m-d'); ?>
                               <?php echo BootForm::open()->get()->action(route('backend.caja.resumen.agencia')); ?>

                               <?php echo BootForm::hidden('a')->value($agencia); ?>

                               <?php echo BootForm::date('Desde','f1')->value($now)->required(); ?>

                               <?php echo BootForm::date('Hasta','f2')->value($now)->required(); ?>

                               <?php echo BootForm::submit('Filtrar')->addClass('btn btn-success'); ?>

                               <?php echo BootForm::close(); ?>

                            </div>
                        </div>     
                    </div>
            </div>
        </div> 
    </section>
<!-- /.Main content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.bs3.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\rifazzo\resources\views/admin/caja/agencia.blade.php ENDPATH**/ ?>