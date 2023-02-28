<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
           <div class="col-md-12">
               <?php echo Breadcrumbs::render('SorteosResumen');; ?>

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
                                <h3 class="card-title">Resumen de Sorteos</h3>
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
                                  <div class="row">
                                    <div class="col-md-6">
                                    <?php $now = date('Y-m-d'); ?>
                                         <?php echo BootForm::open(
)->get()->action(route('backend.sorteos.resumen')); ?>

                                  
  <?php echo BootForm::hidden('a')->value($agencia_id); ?>

                               <?php echo BootForm::date('Desde','f1')->value($desde)->required(); ?>

                               <?php echo BootForm::submit('Filtrar')->addClass('btn btn-success'); ?>

                           </div><div class="col-md-6">
                                  
                                    <?php echo BootForm::date('Hasta','f2')->value($hasta)->required(); ?>

                               <a href="<?php echo route('home'); ?>" class="btn btn-primary">Cancelar</a>
  <?php echo BootForm::close(); ?>

                                
                                  </div>
                                    </div>
                                <table class="table tb-dt">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nro Jugada</th>
                                            <th scope="col">Fecha Sorteo</th>
                                            <th scope="col">Hora Sorteo</th>
                                            <th scope="col">Nro Sorteo</th>
                                            <th scope="col">Nro Ganador</th>
                                          <th scope="col">Nro Premio</th>
                                          <th scope="col">Premio</th>
                                        

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                          
                                            <td><?php echo $node->JUGADA_ID; ?></td>
                                            <td><?php echo $node->SORTEO_FECHA; ?></td>
                                            <td><?php echo $node->SORTEO_HORA; ?></td>
                                            <td><?php echo $node->SORTEO_ID; ?></td> 
                                            <td><?php echo $node->RIFA_NRO; ?></td>
                                            <td><?php echo $node->PREMIO_NRO; ?></td>
                                             <td align="right"><?php echo number_format($node->PREMIO, 0,',', '.'); ?></td>
                                         
                                        </tr>
                                       
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
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
<?php echo $__env->make('layouts.bs3.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\rifazzo\resources\views/admin/sorteos/resumen.blade.php ENDPATH**/ ?>