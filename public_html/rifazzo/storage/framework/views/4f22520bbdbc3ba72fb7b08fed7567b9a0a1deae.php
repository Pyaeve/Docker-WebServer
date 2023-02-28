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
                        <!-- card  -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Informes de Ventas por Vendedor</h3>
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
                                    
                                         <?php echo BootForm::open(
)->get()->action(route('backend.informes.vendedores')); ?>

                                  
  <?php echo BootForm::hidden('a')->value($agencia); ?>

                               <?php echo BootForm::date('Desde','f1')->value($desde); ?>

                               <?php echo BootForm::submit('Filtrar')->addClass('btn btn-success'); ?>

                           </div><div class="col-md-6">
                                  
                                    <?php echo BootForm::date('Hasta','f2')->value($hasta); ?>

                               <a href="<?php echo route('home'); ?>" class="btn btn-primary">Cancelar</a>
  <?php echo BootForm::close(); ?>

                                
                                  </div>
                                    </div>

                               <div class="row">
                                    <div id="gpx-informes-vendedor" class="col-md-12">
                                           <script type="text/javascript">
                                        function LoadReady(event, chart){
    $('#gpx-informes-vendedor').innerHTML ='<img src="' + chart.getImageURI() + '">'
   } 
                                    </script>
                                     <?=$chart->render('BarChart', 'InformeVendedores', 'gpx-informes-vendedor'); ?>
                                
                                    </div>
                               </div>  
                            </div>
                        </div>
                        <!-- /card -->  <!-- card  -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Informes de Ventas por Vendedor</h3>
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
                                    <div class="col-md-12">
                                         <table class="table table-responsive table-striped table-dt">
                                    <thead class="table-dark">
                                        <tr>
                                           <th scope="col">Vendedor</th>
                                            <th scope="col">Venta Fecha</th>
                                            <th scope="col">Venta Hora</th>
                                            <th scope="col">Jugada Nro</th>
                                            <th scope="col">Rifas Vendidas</th>
                                            <th scope="col">Recaudacion</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Comision</th>

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo $node->VENDEDOR; ?></td>
                                            <td><?php echo $node->VENTA_FECHA; ?></td>
                                            <td><?php echo $node->VENTA_HORA; ?></td>
                                            <td><?php echo $node->JUGADA_ID; ?></td> 
                                            <td><?php echo $node->RIFAS_TOTAL; ?></td>
                                            <td><?php echo number_format($node->RECAUDACION_TOTAL, 0,',', '.'); ?></td>
                                            <td><?php echo number_format($node->IMPORTE_TOTAL, 0,',', '.');; ?></td>
                                            <td><?php echo number_format($node->COMISION_TOTAL, 0,',', '.'); ?></td>
                                      </tr>
                                       
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                    </div>    
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
<?php echo $__env->make('layouts.bs3.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\rifazzo\resources\views/admin/informes/vendedores.blade.php ENDPATH**/ ?>