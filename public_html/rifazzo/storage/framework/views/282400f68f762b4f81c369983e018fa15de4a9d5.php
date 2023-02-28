<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <!--  <div class="col-sm-3">
                <h1 class="m-0">Rifachon</h1>
            </div> /.col -->
           <!--- <div class="col-sm-9">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Zonas</a></li>
                    <li class="breadcrumb-item active">Resumen</li>
                </ol>
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
                                <h4 class="card-title">Lo Sentimos no ha Ganado!!</h4>
                                
                            </div>
                            <div class="card-body">
                                <p>
                                    <?php echo $msg; ?>

                                </p>

                            </div>
                        </div>   
                          
                    </div>
            </div>
        </div> 
    </section>
<!-- /.Main content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\rifazzo\resources\views/frontend/premios/sinpremio.blade.php ENDPATH**/ ?>