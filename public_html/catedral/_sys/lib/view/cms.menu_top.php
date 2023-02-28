<a href="<?php echo baseAdminURL;?>" class="appbrand"><span><?php echo sysName;?><span><?php echo sysVersion;?> by <?php echo By;?></span></span></a>
<button type="button" class="btn btn-navbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
<ul class="topnav pull-right">
	<li class="account"><a data-toggle="dropdown" href="" class="glyphicons logout lock"><span class="hidden-phone text"><?php echo Login::get("admin_email");?></span><i></i></a>
		<ul class="dropdown-menu pull-right">
			<li><a href="" class="glyphicons cogwheel"><?php echo Login::get("admin_names");?><i></i></a></li>
			<li> <span> <a class="btn btn-default btn-small pull-right" style="padding: 2px 10px; background: #fff;" href="session?action=logout">Salir</a> </span> </li>
		</ul>
	</li>
</ul>