<section class="menu menu2 cid-scF3d8JkSQ" once="menu" id="menu2-4f">
    <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
        <div class="container-fluid">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <a href="index">
                        <img src="assets/images/logo.jpg" alt="LOGO" style="height: 3.8rem;">
                    </a>
                </span>
                
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <div class="flexsearch d-none d-sm-none d-md-block">
                        <div class="flexsearch--wrapper">
                            <form class="flexsearch--form" action="productos" method="get">
                                <div class="flexsearch--input-wrapper">
                                    <? $b_result = strlen(param('busca')) > 0 ? param('busca'): ""; ?>
                                    <input class="flexsearch--input" autocomplete="off" name="busca" id="busca" value="<?=$b_result?>" list="articulos" type="search" placeholder="Buscar">
                                </div>
                                 
                                <input class="flexsearch--submit" type="submit" value="&#10140;"/>
                            </form>

                        </div>
                </div>
               

                <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                    <li class="nav-item dropdown">
                    	
                        <?  
                            if(!isset($_SESSION['cli_reg'])){ 
                        ?>
                        <a class="nav-link link dropdown-toggle text-black display-7" href="#" data-toggle="dropdown-submenu" aria-expanded="false">
                            <span class="mobi-mbri mobi-mbri-user mbr-iconfont mbr-iconfont-btn"></span>Ingresar
                        </a>
                		<div class="dropdown-menu">
                            <div class="d-none d-sm-none d-md-block">
                                <a class="dropdown-item text-black text-primary display-7" href="javascript:;" data-toggle="modal" data-target="#loginSession" aria-expanded="false">Iniciar  Sesión</a>
                            </div>
                            <div class="d-block d-sm-block d-md-none">
                                <a class="dropdown-item text-black text-primary display-7" href="ingresar">Iniciar  Sesión</a>
                            </div>
                            <a class="dropdown-item text-black text-primary display-7" href="registro" >Registrarse</a>
                			
                			<a class="text-black dropdown-item text-primary display-7" href="comosecompra" aria-expanded="false">Como se compra</a>
                		</div>
                        <?  
                            }else{
                                ?>
                        <a class="nav-link link dropdown-toggle text-black display-7" href="#" data-toggle="dropdown-submenu" aria-expanded="false">
                            <span class="mobi-mbri mobi-mbri-user mbr-iconfont mbr-iconfont-btn"></span>Mi Cuenta
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-black text-primary display-7" href="mi-cuenta/editar">
                                <?php $nombre_cliente = Clientes::select($cliente_id); echo "Hola ".$nombre_cliente[0]['cliente_nombre'] ?>
                            </a>
                            <a class="dropdown-item text-black text-primary display-7" href="repite-pedidos">Repetir Pedidos</a>
                            <a class="dropdown-item text-black text-primary display-7" href="mis-pedidos">Historial Pedidos</a>
                            <a class="text-black dropdown-item text-primary display-7" href="comosecompra" aria-expanded="false">Como se compra</a>
                            <a class="dropdown-item text-black text-primary display-7" href="logout">Salir</a>
                            
                        </div>
                                <?
                            } 
                        ?>
                    </li>
                    <li class="nav-item">
                    	<a class="nav-link link text-black text-primary display-7" href="locales">
                    		<span class="mobi-mbri mobi-mbri-map-pin mbr-iconfont mbr-iconfont-btn"></span>Locales</a>
                    </li>
                </ul>
                
                <!-- MODAL-->
                <div class="modal fade" id="loginSession" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <div style="width: 100%; text-align: center;">
                             <h3 class="modal-title" style="color: #0f3b84; font-weight: bold;" id="exampleModalLabel">INICIAR SESIÓN</h3>
                        </div>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                            <form method="post" id="loginForm" accept-charset="utf-8">
                                <div class="md-form mb-5">
                                    <input type="text" id="email" name="email" autocomplete="off" class="form-control validate" placeholder="E-mail" required>
                                    <!-- <label for="defaultForm-email">E-mail</label> -->
                                </div>

                                <div class="md-form mb-4">
                                    <input type="password" id="clave" name="clave" autocomplete="off" class="form-control validate" placeholder="Clave" required>
                                    <!-- <label  for="defaultForm-pass">Clave</label> -->
                                </div>
                                <input type="hidden" name="tokenlogin" id="tokenlogin" value="<?=token('iniciosession')?>">
                                <span id="msm" ></span>
                            </form>  
                            <p>
                            <a href="javascript:;" data-dismiss="modal" data-toggle="modal" data-target="#restablecer" aria-expanded="false">¿Has olvidado tu contraseña?</a></p> 
                            <a class="btn btn-primary" id="btn_login">Ingresar</a>
                      </div>
                      <div class="modal-footer" style="margin:auto;">
                        <p class="w-100 text-center"><a href="registro" >Si aún no está registrado click aquí</a></p>
                      </div>
                      
                    </div>
                  </div>
                </div>

                <!-- RESET CONTRASEÑA -->
                <div class="modal fade" id="restablecer" tabindex="-1" role="dialog" aria-labelledby="PassModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content restablecer">
                      <div class="modal-header">
                        <div style="width: 100%; text-align: center;">
                             <h3 class="modal-title" style="color: #0f3b84; font-weight: bold;" id="PassModalLabel">RECUPERAR CONTRASEÑA</h3>
                        </div>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                            <form method="post" id="recuperar" accept-charset="utf-8">
                                <div class="md-form">
                                    <input type="text" id="email_reset" name="email_reset" class="form-control validate mb-3" placeholder="E-mail" required>
                                    <!-- <label for="defaultForm-email">E-mail</label> -->
                                   <!--  <p class="display-4 mt-3"><b class="modal-title">¿Olvidaste tu contraseña?</b><br>
                                        Por favor, escribe el email con el que estás registrado y te enviaremos tu contraseña a tu correo.</p>       -->
                                </div>
                                <input type="hidden" name="token" id="token" value="<?=token('reset_password')?>">
                                <input type="hidden" name="accion" id="accion" value="recuperar">
                                <p id="msm" class="respuesta">
                                    <b style="color: #0f3b84; font-weight: bold;">¿Olvidaste tu contraseña?</b><br>
                                        Por favor, escribe el email con el que estás registrado y te enviaremos tu contraseña a tu correo.
                                </p>
                            </form>  
                              
                      </div>
                      <div class="modal-footer mf2" style="margin:auto;">
                            <a class="btn btn-primary"  id="btn_recuperar">Restablecer</a>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="navbar-buttons mbr-section-btn">
                	<a class="btn btn-info-outline display-4" href="mi-carrito">
                        <span class="mobi-mbri mobi-mbri-cart-add mbr-iconfont mbr-iconfont-btn"></span>
                        Carrito <span class="itemCartTotal" style="font-weight:bold;">&nbsp;&nbsp;
                            <?php echo "(".$items_carrito.")"; ?>
                        </span>
                        <br>
                    </a>
                </div>
                
            </div>
        </div>
    </nav>
</section>
<div class="flexsearch d-block d-sm-block d-md-none mt-4 clearfix">
        <div class="flexsearch--wrapper">
            <form class="flexsearch--form" action="productos" method="get">
                <div class="flexsearch--input-wrapper">
                    <? $b_result = strlen(param('busca')) > 0 ? param('busca'): ""; ?>
                    <input class="flexsearch--input" autocomplete="off" name="buscaM" id="buscaM" value="<?=$b_result?>" list="articulos" type="search" placeholder="Buscar">
                </div>
                 
                <input class="flexsearch--submit" type="submit" value="&#10140;"/>
            </form>

        </div>
</div>
<div class="search-result">
    <div id="results" >

      <!--   <i id="closeSearch" class="fa fa-times-circle" aria-hidden="true"></i>
        <ul id="ubicaciones" style="clear:both;">
            <li><a href="/busqueda/en-estado_asuncion/en-municipio_tembetary-asuncion"><div><span>Tembetary,</span> Asunción</div></a></li>
        </ul>
        <ul id="oficinas"><li><div><a href="/inmobiliaria/5-century-21-real-property-tembetary-asuncion-paraguay"><div><span>CENTURY 21 Real Property</span> (Tembetary, Asunción)</div></a></div></li></ul>
        <ul id="asesores"></ul>
        <ul id="clave"></ul> -->
    </div>
</div>