<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
                <?php echo Breadcrumbs::render('Home'); ?>

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div> <!-- /.container-fluid -->
</div> <!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline">
                    <div class="card-header ">
                        <h4 class="card-title">Ventas</h4>
                    </div>
                    <div class="card-body">
                        <!-- /.d-flex -->
                        <div class="col-md-12">
                            <div id="gpx-ventas7dias-agencia"></div>
                        </div>
                        <script type="text/javascript">
                        function LoadReady(event, chart) {
                            $('#gpx-ventas7dias-agencia').innerHTML = '<img src="' + chart.getImageURI() + '">'
                        }

                        </script>
                        <?=$Ventas7DiasAgencia->render('ColumnChart', 'Ventas7DiasAgencia', 'gpx-ventas7dias-agencia'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <?php if(auth()->check() && auth()->user()->hasRole('Developer')): ?>
                    <div class="col-md-3">
                        <!-- info-box -->
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-house-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Agencias</span>
                                <span class="info-box-number"><?php echo $agencias; ?></span>
                                <a href="<?php echo route('backend.agencias.resumen'); ?>" class="info-box-footer">Ver Resumen</a>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-3">
                        <!-- info-box -->
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Vendedores</span>
                                <span class="info-box-number"><?php echo $vendedores; ?></span>
                                <a href="<?php echo route('backend.vendedores.resumen'); ?>" class="info-box-footer">Ver Resumen</a>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <?php else: ?>
                    <?php if(auth()->check() && auth()->user()->hasRole('Agente')): ?>
                    <div class="col-md-3">
                        <!-- info-box -->
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Vendedores</span>
                                <span class="info-box-number"><?php echo $vendedores; ?></span>
                                <a href="<?php echo route('backend.vendedores.resumen'); ?>" class="info-box-footer">Ver Resumen</a>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-3">
                        <!-- info-box -->
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Rifas</span>
                                <span class="info-box-number"><?php echo $rifas; ?></span>
                                <a href="<?php echo route('backend.vendedores.resumen'); ?>" class="info-box-footer">Ver Resumen</a>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-3">
                        <!-- info-box -->
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Jugadas</span>
                                <span class="info-box-number"><?php echo $jugadas; ?></span>
                                <a href="<?php echo route('backend.jugadas.resumen'); ?>" class="info-box-footer">Ver Resumen</a>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-3">
                        <!-- info-box -->
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">POS</span>
                                <span class="info-box-number"><?php echo $pos; ?></span>
                                <a href="<?php echo route('backend.pos.resumen'); ?>" class="info-box-footer">Ver Resumen</a>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <?php else: ?>
                      <?php if(auth()->check() && auth()->user()->hasRole('Supervisor')): ?>
                        <div class="col-md-3">
                        <!-- info-box -->
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Vendedores</span>
                                <span class="info-box-number"><?php echo $vendedores; ?></span>
                                <a href="<?php echo route('backend.vendedores.resumen'); ?>" class="info-box-footer">Ver Resumen</a>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-3">
                        <!-- info-box -->
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Rifas</span>
                                <span class="info-box-number"><?php echo $rifas; ?></span>
                                <a href="<?php echo route('backend.vendedores.resumen'); ?>" class="info-box-footer">Ver Resumen</a>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-3">
                        <!-- info-box -->
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Jugadas</span>
                                <span class="info-box-number"><?php echo $jugadas; ?></span>
                                <a href="<?php echo route('backend.jugadas.resumen'); ?>" class="info-box-footer">Ver Resumen</a>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-3">
                        <!-- info-box -->
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">POS</span>
                                <span class="info-box-number"><?php echo $pos; ?></span>
                                <a href="<?php echo route('backend.pos.resumen'); ?>" class="info-box-footer">Ver Resumen</a>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                      <?php endif; ?>

                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
</section>
<!-- /.Main content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bs3.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\rifazzo\resources\views/admin/panel/index.blade.php ENDPATH**/ ?>