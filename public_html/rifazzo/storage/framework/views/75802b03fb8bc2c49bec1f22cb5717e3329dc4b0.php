
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
               <?php echo Breadcrumbs::render('AgenciasResumen');; ?>

            </div<!-- /.col -->
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
                                <h3 class="card-title">Resumen de Zonas</h3>
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
                                            <th scope="col">ID</th>
                                            <th scope="col">Agencia</th>
                                            <th scope="col">RUC</th>
                                            <th scope="col">Contacto</th>
                                            <th scope="col">Agente</th>
                                            <th scope="col">Zona</th>
                                            <th scope="col">Ciudad</th>
                                            <th scope="col">Domicilio</th>

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                        
                                            <td>
                                                <a href="<?php echo route('backend.agencias.editar',['id'=>$node->ID ]); ?>" class="btn btn-tool"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-tool"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td><?php echo $node->ID; ?></td>
                                            <td><?php echo $node->AGENCIA; ?></td>
                                            <td><?php echo $node->RUC; ?></td> 
                                            <td><?php echo $node->CONTACTO; ?></td> 
                                            <td><?php echo $node->AGENTE; ?></td>
                                            <td><?php echo $node->ZONA; ?></td>
                                            <td><?php echo $node->CIUDAD; ?></td>
                                            <td><?php echo $node->DIRECCION; ?></td>
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
<?php echo $__env->make('layouts.bs3.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/public_html/rifazzo/resources/views/admin/agencias/resumen.blade.php ENDPATH**/ ?>