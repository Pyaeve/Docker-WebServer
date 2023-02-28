
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
                                <h3 class="card-title">Resumen de Jugadas</h3>
                                &nbsp;<a href="<?php echo route('backend.jugadas.cargar'); ?>" title="Cargar Nueva Jugada"><i class="fas fa-plus"></i></a>
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
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nro Jugada</th>
                                            <th scope="col">Modalidad</th>
                                            <th scope="col">Fecha Jugada</th>
                                            <th scope="col">Estado Jugada</th>
                                          <th scope="col">Rifas Vendidas</th>
                                          <th scope="col">Rifas Meta </th>
                                          <th scope="col">% Meta</th>

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo route('backend.jugadas.editar',['id'=>$node->JUGADA_ID]); ?>" class="btn btn-tool"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-tool"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td><?php echo $node->JUGADA_ID; ?></td>
                                            <td><?php echo $node->JUGADA_MODALIDAD; ?></td>
                                            <td><?php echo $node->JUGADA_FECHA; ?></td>
                                            <td><?php echo $node->JUGADA_ESTADO; ?></td> 
                                            <td><?php echo $node->RIFAS_TOTAL; ?></td>
                                            <td><?php echo $node->JUGADA_META_RIFAS; ?></td>
                                            <td><?php echo $node->JUGADA_META_PORC; ?></td>
                                         
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
<?php echo $__env->make('layouts.bs3.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/public_html/rifazzo/resources/views/admin/jugadas/resumen.blade.php ENDPATH**/ ?>