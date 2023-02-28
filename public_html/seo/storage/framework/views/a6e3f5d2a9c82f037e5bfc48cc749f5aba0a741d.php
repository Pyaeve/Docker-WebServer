<?php $__env->startSection('content'); ?>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Analiysis de SEO</div>

                <div class="card-body">
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
                              <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <h3 >SEO B&acutel;sico</h3>
                        </div>
                    </div>
                             <?php if(isset($title)): ?>
                            <div class="row">

                                 <?php if(!is_null($title)): ?>
                                
                                 
                                <div class="col-md-3"><b>Title</b></div>
                                <div class="col-md-9">
                                   <?php echo $title; ?>

                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <?php if(isset($metas)): ?>
                            <?php $__currentLoopData = $metas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row">
                                <?php if(!is_null($meta['name'])): ?>
                               
                                 
                                          <div class="col-md-3" class=""><b><?php echo $meta['name']; ?></b></div>
                                         <div class="col-md-9"><?php echo $meta['content']; ?></div>
                                   
                          
                                <?php else: ?>
                                   
                                    <div class="col-md-3"><b><?php echo $meta['property']; ?></b></div>
                                <div class="col-md-9"><?php echo $meta['content']; ?></div>
                                    
                                <?php endif; ?>

                                
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <h3 >GZIP</h3>
                        </div>
                    </div>
                            <?php endif; ?>
                            <?php if(isset($gzip)): ?>
                            <div class="row">

                                 <?php if(!is_null($gzip)): ?>
                                
                                 
                                <div class="col-md-3"><b>GZip</b></div>
                                <div class="col-md-9">
                                    <?php if($gzip==1): ?>
                                       Excelente usas una Coneccion Comprimida 
                                    <?php else: ?>
                                        Lamentable, becesitas comprimir la respuesta
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                              <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <h3 >ROBOTS</h3>
                        </div>
                    </div>
                             <?php if(isset($robots)): ?>
                            <div class="row">
                                 <?php if(!is_null($robots)): ?>
                                  
                                <div class="col-md-3"><b>Robots</b></div>
                                <div class="col-md-9">
                                    <?php if($robots==1): ?>
                                       Excelente usas Robots.txt para rastreo 
                                    <?php else: ?>
                                       Lamentable, necesitas tener Robots.txt para rastreo
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                             <?php if(isset($sitemap)): ?>
                            <div class="row">
                                 <?php if(!is_null($sitemap)): ?>
                                  
                                <div class="col-md-3"><b>Sitemap</b></div>
                                <div class="col-md-9">

                                    <?php if($sitemap==1): ?>
                                       Excelente usas Sitemap.xml  para rastreo 
                                    <?php else: ?>
                                       Grave necesitas tener Sitemap.xml para rastreo
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <?php if(isset($jsonLd)): ?>
                            <div class="row">
                                 <?php if(!is_null($jsonLd)): ?>
                                 
                                <div class="col-md-3"><b>Ld+Json</b></div>
                                <div class="col-md-9">
                                    <?php if(count($jsonLd)>0): ?>
                                        
                                        <?php $__currentLoopData = $jsonLd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $n['content']; ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        Datos Estructurados son las ultimas tendencia que google toma para ejercvetr influencia en el 
                                        SERP                                            
                                    <?php endif; ?>
                                    
                                </div>
                                <?php else: ?>
                                 
                                <div class="col-md-3">Ld+Json</div>
                                <div class="col-md-9">
                                    dedad
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                          

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <h3 >SERP</h3>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bs5.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Docker\Images\webserver\public_html\seo\resources\views\app\app_seo_scrapp.blade.php ENDPATH**/ ?>