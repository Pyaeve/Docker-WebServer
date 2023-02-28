<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Analisis de SEO</div>

                <div class="card-body">
                    
                
        <div class="row">

             <?php echo BootForm::open()->get()->inline(); ?>

                 <?php if(isset($_GET['q'])): ?>
                     <?php echo BootForm::text('termino de busqueda','q')->value($_GET['q']); ?>

                 <?php else: ?>
                      <?php echo BootForm::text('termino de busqueda','q'); ?>

                  <?php endif; ?>
                  <?php if(isset($_GET['o'])): ?>
                     <?php echo BootForm::select('Opciones', 'o')->options(['' => 'Ninguna', 'intext:' => 'que Contenga algun Texto','allintext:'=>
                              'Todo lo que contenga '])->select($_GET['o']); ?>

                  <?php else: ?>
                    <?php echo BootForm::select('Opciones', 'o')->options(['' => 'Ninguna', 'intext:' => 'que Contenga algun Texto','allintext:'=>
                              'Todo lo que contenga '])->select('Ninguna'); ?>

                  <?php endif; ?>
                  <?php echo BootForm::select('Pais', 'c')->options(['ar'=>'Argentina', 'py'=>
                              'Paraguay'])->select('py'); ?>

                   <?php echo BootForm::submit('Consultar')->addClass('btn btn-success'); ?>

                   <?php echo BootForm::close(); ?>

        </div>
        <div class="flex-center position-ref full-height">
            <?php $i=1; ?>
              <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <!--RESULT # -->
    <div class="result">
      <!--RESULT TITLE -->
      <h3 class="result-title">
        <a href="<?php echo $res->link; ?>"><?php echo $res->title; ?></a>
      </h3>
      <!-- RESULT WEB ADDRESS (META) -->
      <div> 
        <cite class="meta-web-address"><?php echo $res->displayLink; ?></cite>
        <div class="action-menu-web-address">
          <a href="<?php echo $res->link; ?>">
            <i class="fa fa-caret-down" aria-hidden="true"></i>
          </a>
        </div>
      </div>
      <!-- META DATE + DESCRIPTION -->
      <div class="meta-description">x
        <span class="date-result"><?php echo date('d D \de M Y`x'); ?></span>
        <?php echo $res->htmlSnippet; ?>

      </div>
    </div>
    <!---->
    <?php $i++; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
alert('hola');
<?php $__env->stopSection(); ?>
 

<?php echo $__env->make('layouts.bs3.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Docker\Images\webserver\public_html\seo\resources\views\app_cse.blade.php ENDPATH**/ ?>