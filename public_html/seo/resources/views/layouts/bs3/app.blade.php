<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{!! env('APP_NAME') !!}</title>
    <!-- favorion -->
   
<link rel="icon" type="image/png" sizes="192x192"  href="{!! asset('images/android-icon-192x192.png') !!}">
<link rel="icon" type="image/png" sizes="32x32" href="{!! asset('images/favicon-32x32.png') !!}">
<link rel="icon" type="image/png" sizes="96x96" href="{!! asset('images/favicon-96x96.png') !!}">
<link rel="icon" type="image/png" sizes="16x16" href="{!! asset('images/favicon-16x16.png') !!}">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{!! asset('themes/bs3/plugins/fontawesome-free/css/all.min.css') !!}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{!! asset('css/ionicons.min.css') !!}">
   
    <!-- iCheck -->
    <link rel="stylesheet" href="{!! asset('themes/bs3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{!! asset('themes/bs3/plugins/jqvmap/jqvmap.min.css') !!}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{!! asset('themes/bs3/css/adminlte.min.css') !!}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{!! asset('themes/bs3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') !!}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{!! asset('themes/bs3/plugins/daterangepicker/daterangepicker.css') !!}">
    <!-- summernote -->
    <link rel="stylesheet" href="{!! asset('themes/bs3/plugins/summernote/summernote-bs4.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('themes/bs3/css/loader.css') !!}">
    <link rel="stylesheet" href="{!! asset('themes/bs3/css/rifa.css') !!}">
    <!-- DataTables -->
     <link rel="stylesheet" href="{!! asset('themes/bs3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}">
     <link rel="stylesheet" href="{!! asset('themes/bs3/css/print.css')  !!} " media="print">
      <link rel="stylesheet" href="{!! asset('themes/bs3/plugins/slotmachine/css/slotmachine.css')  !!} " media="screen">
       <link rel="stylesheet" href="{!! asset('css/chat.css') !!}">
       <link rel="stylesheet" href="{!! asset('css/casino.css') !!}">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed ">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column  justify-content-center align-items-center">
            <img class="animation__shake" src="{!! asset('images/rifachon.png') !!}" alt="AdminLTELogo" height="190px" width="200px">
        </div>
        <!-- /.Preloader -->
        <!-- Navbar -->
       
       @if (Route::has('login'))
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>
            <!-- Right navbar links 
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search 
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- Messages Dropdown Menu 
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start 
                            <div class="media">
                                <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End 
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start 
                            <div class="media">
                                <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End 
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start 
                            <div class="media">
                                <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End 
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul> -->
              <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
        </nav>
        <!-- /.navbar -->

      <?php // @include('layouts.bs3.leftbar') ?>
        <!-- Content Wrapper. Contains page content -->
        @endif
        <div class="content-wrapper">
          
            @yield('content')
           
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>Copyright &copy; <?=date('Y'); ?> <a href="http://localhost/rifazzo/public/">Rifachon</a>.</strong>
            Todos los Derechos Reservados.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.1
     <!-- /.control-sidebar -->
            </div>
        </footer>
        <!-- Control Sidebar 
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here
        </aside>
       <!-- chat 
         <div class="container">
                <div class="row">
                    <div class="chatbox chatbox22 chatbox--tray">
                        <div class="chatbox__title">
                            <h5><a href="javascript:void()">Leave a message</a></h5>
                            <button class="chatbox__title__tray">
                                <span></span>
                            </button>
                            <button class="chatbox__title__close">
                                <span>
                                    <svg viewBox="0 0 12 12" width="12px" height="12px">
                                        <line stroke="#FFFFFF" x1="11.75" y1="0.25" x2="0.25" y2="11.75"></line>
                                        <line stroke="#FFFFFF" x1="11.75" y1="11.75" x2="0.25" y2="0.25"></line>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <div class="chatbox__body">
                            <div class="chatbox__body__message chatbox__body__message--left">
                                <div class="chatbox_timing">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-calendar"></i> 22/11/2018</a></li>
                                        <li><a href="#"><i class="fa fa-clock-o"></i> 7:00 PM</a></a></li>
                                    </ul>
                                </div>
                                <img src="https://www.gstatic.com/webp/gallery/2.jpg" alt="Picture">
                                <div class="clearfix"></div>
                                <div class="ul_section_full">
                                    <ul class="ul_msg">
                                        <li><strong>Person Name</strong></li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                    <ul class="ul_msg2">
                                        <li><a href="#"><i class="fa fa-pencil"></i> </a></li>
                                        <li><a href="#"><i class="fa fa-trash chat-trash"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chatbox__body__message chatbox__body__message--right">
                                <div class="chatbox_timing">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-calendar"></i> 22/11/2018</a></li>
                                        <li><a href="#"><i class="fa fa-clock-o"></i> 7:00 PM</a></a></li>
                                    </ul>
                                </div>
                                <img src="https://www.gstatic.com/webp/gallery/2.jpg" alt="Picture">
                                <div class="clearfix"></div>
                                <div class="ul_section_full">
                                    <ul class="ul_msg">
                                        <li><strong>Person Name</strong></li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                    <ul class="ul_msg2">
                                        <li><a href="#"><i class="fa fa-pencil"></i> </a></li>
                                        <li><a href="#"><i class="fa fa-trash chat-trash"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chatbox__body__message chatbox__body__message--left">
                                <div class="chatbox_timing">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-calendar"></i> 22/11/2018</a></li>
                                        <li><a href="#"><i class="fa fa-clock-o"></i> 7:00 PM</a></a></li>
                                    </ul>
                                </div>
                                <img src="https://www.gstatic.com/webp/gallery/2.jpg" alt="Picture">
                                <div class="clearfix"></div>
                                <div class="ul_section_full">
                                    <ul class="ul_msg">
                                        <li><strong>Person Name</strong></li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                    <ul class="ul_msg2">
                                        <li><a href="#"><i class="fa fa-pencil"></i> </a></li>
                                        <li><a href="#"><i class="fa fa-trash chat-trash"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chatbox__body__message chatbox__body__message--right">
                                <div class="chatbox_timing">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-calendar"></i> 22/11/2018</a></li>
                                        <li><a href="#"><i class="fa fa-clock-o"></i> 7:00 PM</a></a></li>
                                    </ul>
                                </div>
                                <img src="https://www.gstatic.com/webp/gallery/2.jpg" alt="Picture">
                                <div class="clearfix"></div>
                                <div class="ul_section_full">
                                    <ul class="ul_msg">
                                        <li><strong>Person Name</strong></li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                    <ul class="ul_msg2">
                                        <li><a href="#"><i class="fa fa-pencil"></i> </a></li>
                                        <li><a href="#"><i class="fa fa-trash chat-trash"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chatbox__body__message chatbox__body__message--left">
                                <div class="chatbox_timing">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-calendar"></i> 22/11/2018</a></li>
                                        <li><a href="#"><i class="fa fa-clock-o"></i> 7:00 PM</a></a></li>
                                    </ul>
                                </div>
                                <img src="https://www.gstatic.com/webp/gallery/2.jpg" alt="Picture">
                                <div class="clearfix"></div>
                                <div class="ul_section_full">
                                    <ul class="ul_msg">
                                        <li><strong>Person Name</strong></li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                    <ul class="ul_msg2">
                                        <li><a href="#"><i class="fa fa-pencil"></i> </a></li>
                                        <li><a href="#"><i class="fa fa-trash chat-trash"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="input-group">
                                <input id="btn-input" type="text" class="form-control input-sm chat_set_height" placeholder="Escriba un Mensaje..." tabindex="0" dir="ltr" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off" contenteditable="true" />
                                <span class="input-group-btn">
                                    <button class="btn bt_bg btn-sm" id="btn-chat">
                                        Send</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        /chat -->
      </div>
    
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{!! asset('themes/bs3/plugins/jquery/jquery.min.js') !!}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{!! asset('themes/bs3/plugins/jquery-ui/jquery-ui.min.js') !!}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

    <!-- Bootstrap 4 -->
    <script src="{!! asset('themes/bs3/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>


   <script src="{!! asset('themes/bs3/plugins/moment/moment.min.js') !!}"></script>
    <script src="{!! asset('themes/bs3/plugins/daterangepicker/daterangepicker.js') !!}"></script>
    
    <!-- Summernote -->
    <script src="{!! asset('themes/bs3/plugins/summernote/summernote-bs4.min.js') !!}"></script>
    <!-- overlayScrollbars -->
    <script src="{!! asset('themes/bs3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}"></script>
    <!-- AdminLTE App  -->
    <script src="{!! asset('themes/bs3/js/adminlte.js') !!}"></script>
   
   <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="{!! asset('themes/bs3/plugins/slotmachine/js/slotmachine.js') !!}"></script>
    <script src="{!! asset('themes/bs3/plugins/slotmachine/js/jquery.slotmachine.js') !!}"></script>
   
      <script type="text/javascript">
        $(document).ready(function(){
             @yield('scripts')

      
    
    });


          </script>
</body>

</html>
