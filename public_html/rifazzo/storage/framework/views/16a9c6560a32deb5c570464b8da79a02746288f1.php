<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
         
            <div class="col-md-12">
               <?php echo Breadcrumbs::render('CajaAgenciaResumen');; ?>

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
                                <h3 class="card-title">Resumen de Caja</h3>
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
)->get()->action(route('backend.caja.resumen.agencia')); ?>

                                  
  <?php echo BootForm::hidden('a')->value($agencia); ?>

                               <?php echo BootForm::date('Desde','f1')->value($desde)->value($now)->required(); ?>

                               <?php echo BootForm::submit('Filtrar')->addClass('btn btn-success'); ?>

                           </div><div class="col-md-6">
                                  
                                    <?php echo BootForm::date('Hasta','f2')->value($hasta)->value($now)->required(); ?>

                               <a href="<?php echo route('home'); ?>" class="btn btn-primary">Cancelar</a>
  <?php echo BootForm::close(); ?>

                                
                                  </div>
                                    </div>
                                
                                <div class="row">
                                    <div class="col-md-12">

                                        <table class="table table-responsive table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Jugada Nro</th>
                                            <th scope="col">Rifas Vendidas</th>
                                            <th scope="col">Importe Total</th>
                                            <th scope="col">Recaudaci&oacute;n Total</th>
                                            <th scope="col">Comision Total</th>
                                           
                                            
    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $caja; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                           
                                            <td><?php echo $node->FECHA; ?></td>
                                            <td><?php echo $node->JUGADA_ID; ?></td>
                                          <!--  <td></td> -->
                                           <td align="right"><?php echo number_format($node->RIFAS_TOTAL, 0,',', '.');; ?></td>
                                           
                                            <td align="right"><?php echo number_format($node->IMPORTE_TOTAL, 0,',', '.');; ?></td>
                                         <td align="right"><?php echo number_format($node->RECAUDACION_TOTAL, 0,',', '.'); ?></td>
                                           <td align="right"><?php echo number_format($node->COMISION_TOTAL, 0,',', '.'); ?></td>
                                        </tr>
                                       
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                    </div>
                                
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="gpx-caja-agencia"></div>
                                    <script type="text/javascript">
                                        function LoadReady(event, chart){
    $('#gpx-caja-agencia').innerHTML ='<img src="' + chart.getImageURI() + '">'
   } 
                                    </script>
                                     <?=$chart->render('ColumnChart', 'CajaAgencia', 'gpx-caja-agencia'); ?>
                                      <table class="table tb-dt table-responsive table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">
                                                Fecha Venta
                                            </th>
                                            <th scope="col">
                                                Hora Venta
                                            </th>
                                            <th scope="col">Rifas Nro</th>
                                            <th scope="col">Rifas Token</th>
                                            <th scope="col">Nro Jugada</th>
                                            <th scope="col">Fecha Jugada</th>
                                            <th scope="col">Vendedor</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Comision</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="table-hover">
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                           <td><?php echo $node->VENTA_FECHA; ?></td>
                                            
                                            <td><?php echo $node->VENTA_HORA; ?></td>
                                             <td><?php echo $node->RIFA_NRO; ?></td>
                                            <td><?php echo $node->RIFA_TOKEN; ?></td>
                                            <td><?php echo $node->JUGADA_ID; ?></td>
                                            <td><?php echo $node->JUGADA_FECHA; ?></td>
                                            <td><?php echo $node->VENDEDOR; ?></td>
                                           
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
            </div>
        </div> 
    </section>
    
<!-- /.Main content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
 $('.tb-dt').DataTable( {
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "pageLength": 50,
        "order": [[ 0, "desc" ]]
    } );


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.bs3.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\rifazzo\resources\views/admin/caja/resumen_agencia.blade.php ENDPATH**/ ?>