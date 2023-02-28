<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Analiysis de SEO</div>

                <div class="card-body">\
                    <div class="row">
                        
                    
                        <div class="col-md-12">
                             <?php echo BootForm::open()->get()->inline(); ?>

                 <?php if(isset($_GET['url'])): ?>
                     <?php echo BootForm::text('URL del Sitio Web','url')->value($_GET['url']); ?>

                 <?php else: ?>
                      <?php echo BootForm::text('URL del Sitio Web','url'); ?>

                  <?php endif; ?>
                
               
                   <?php echo BootForm::submit('Consultar')->addClass('btn btn-success'); ?>

                   <?php echo BootForm::close(); ?>

                        </div>
                    </div>
                    
                     <div class="row">
                        <div class="col-md-12">
                            
                           <?php $__currentLoopData = $seo_tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if(isset($serp)): ?>
                                <div class="flex-center position-ref full-height">
              <?php $__currentLoopData = $serp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
      <div class="meta-description">
        
        <?php echo $res->htmlSnippet; ?>

      </div>
    </div>
    <!---->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
                        </div>
                        <?php endif; ?>
                     </div>

                   		
                   				
                   		
                   		
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.bs5started.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Docker\Images\webserver\public_html\seo\resources\views\app\app_seo_scrapp_new.blade.php ENDPATH**/ ?>