 <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="<?php echo asset('images/rifachon-100.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?php echo env('APP_NAME', 'Laravel'); ?></span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <?php $user=Auth::user(); ?> 
                        <img src="<?php echo asset('images/default-profile.png'); ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?php echo route('backend.usuarios.perfil'); ?>" class="d-block"><?php echo $user->name; ?> <?php echo $user->sername; ?></a>
                        <p><?php /*
                            $agencia_id = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".$user->id."') AS AGENCIA_ID;");
                            $agencia_id = $agencia_id[0]->AGENCIA_ID;
                            $agencia_nombre = DB::select("SELECT FNC_DAME_AGENCIA_NOMBRE('".$agencia_id."') AS AGENCIA_NOMBRE;");
                            $agencia_nombre = $agencia_nombre[0]->AGENCIA_NOMBRE;
                            echo $agencia_nombre; */
                    ?></p>
                    </div>
                </div>
                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                       <?php/* @role('Developer')
                            <?php echo $__env->make(config('laravel-menu.views.leftnav-items'), ['items' => $DevMenuBar->roots()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
                        <?php else: ?>
                            @role('Supervisor')
                                 <?php echo $__env->make(config('laravel-menu.views.leftnav-items'), ['items' => $SupervisorMenuBar->roots()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php else: ?>
                                @role('Agente')
                                    <?php echo $__env->make(config('laravel-menu.views.leftnav-items'), ['items' => $AgenteMenuBar->roots()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
                            
                                <?php else: ?>
                                    @role('Vendedor')
                                        <?php echo $__env->make(config('laravel-menu.views.leftnav-items'), ['items' => $VendedorMenuBar->roots()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
                                    @endrole
                                @endrole
                            @endrole
                       @endrole    */?>          
                    </ul> 
                    
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- /. Main  Sidebar Container --><?php /**PATH C:\Docker\Images\webserver\public_html\seo\resources\views\layouts\bs3\leftbar.blade.php ENDPATH**/ ?>