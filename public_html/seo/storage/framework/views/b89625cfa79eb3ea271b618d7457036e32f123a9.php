
<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <li <?php $lm_attrs = $item->attr(); ob_start(); ?>  class="nav-item"  <?php echo \Lavary\Menu\Builder::mergeStatic(ob_get_clean(), $lm_attrs); ?>>
    <?php if($item->link): ?> <a class="nav-link <?php if($item->url()==url()->current()): ?> active <?php endif; ?>" <?php $lm_attrs = $item->link->attr(); ob_start(); ?> <?php echo \Lavary\Menu\Builder::mergeStatic(ob_get_clean(), $lm_attrs); ?> href="<?php echo $item->url(); ?>">
     <p> <?php echo $item->title; ?>

     <?php if($item->hasChildren()): ?>
     <i class="fas fa-angle-left right"></i>
     <?php endif; ?>   
      </p>
    </a>
    <?php else: ?>
      <p ><?php echo $item->title; ?></p>
    <?php endif; ?>
    <?php if($item->hasChildren()): ?>
      <ul class="nav nav-treeview">
        <?php echo $__env->make(config('laravel-menu.views.leftnav-items'),
array('items' => $item->children()), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </ul>
    <?php endif; ?>
  </li>
  <?php if($item->divider): ?>
  	<li<?php echo Lavary\Menu\Builder::attributes($item->divider); ?>></li>
  <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\Docker\Images\webserver\public_html\seo\resources\views\vendor\laravel-menu\admin-leftnav-items.blade.php ENDPATH**/ ?>