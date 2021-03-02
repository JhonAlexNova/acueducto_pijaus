
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Acueducto Pijaos </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="keywords"
        content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('template/assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">

     <link rel="stylesheet" href="{{asset('lib/toastr/toastr.min.css')}}">

    <!-- feather Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{asset('css/libs/buttons.dataTables.min.css')}}" class="">
    <link rel="stylesheet" href="{{asset('css/libs/jquery.dataTables.min.css')}}" class="">
   
   

    <script type="text/javascript" src="{{ asset('template/bower_components/jquery/dist/jquery.min.js')}}"></script>
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">

                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="#">
                            <img class="img-fluid" src="{{ url('img/logo-horizontal.png')}}" alt="Theme-Logo" />
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container">
                        
                        <ul class="nav-right">
                            
                            
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="{{ url('img/avatar.png')}}" class="img-radius"
                                            alt="img">
                                        <span>Alejandra</span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu"
                                        data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        
                                        <li>
                                            <a href="#">
                                                <i class="feather icon-user"></i> Mi Perfil
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <!-- <a href="{{ url('./default/auth-normal-sign-in.html')}}">
                                                <i class="feather icon-log-out"></i> Logout
                                            </a> -->
                                            <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                               <i class="feather icon-log-out"></i> {{ __('Salir') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

  
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                          <div class="sidebar-menu">
                                <ul class="pcoded-item pcoded-left-item">
                                    
                                     <li class="">
                                        <a href="{{ url('app/clientes') }}">
                                            <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                            <span class="pcoded-mtext">Usuarios</span>
                                        </a>
                                    </li>
                                     <li class="">
                                        <a href="{{url('app/medicion/create')}}">
                                            <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                            <span class="pcoded-mtext">Crear Factura</span>
                                        </a>
                                    </li>
                                     <li class="">
                                        <a href="{{url('app/medicion')}}">
                                            <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                            <span class="pcoded-mtext">Ver facturas</span>
                                        </a>
                                    </li>
                                     <li class="">
                                        <a href="{{url('app/pago/create')}}">
                                            <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                            <span class="pcoded-mtext">Agregar Pagos</span>
                                        </a>
                                    </li>
                                     <li class="">
                                        <a href="{{url('app/pago')}}">
                                            <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                            <span class="pcoded-mtext">Ver Pagos</span>
                                        </a>
                                    </li>
                                     <li class="">
                                        <a href="{{ url('app/credito') }}">
                                            <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                            <span class="pcoded-mtext">Otros Cobros</span>
                                        </a>
                                    </li>
                                     <li class="">
                                        <a href="{{url('app/reportes')}}">
                                            <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                                            <span class="pcoded-mtext">Reportes</span>
                                        </a>
                                    </li>
                                                                      
                                </ul>
                          </div>
                           
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                  <div class="page-body">
                                    
                                      @yield('content');
                                  </div>
                                </div>

                                <!-- <div id="styleSelector"> -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <style>
     .pcoded .pcoded-navbar[navbar-theme="theme1"] .main-menu {
            background-image: url('{{ url('img/sidebar.png') }}');
            background-attachment: fixed;
            background-size: contain;
            height: 100% !important;
            background-position: inherit;
            background-repeat: no-repeat;
         }



        .pcoded .pcoded-header .navbar-logo[logo-theme="theme1"] {
            background-color: #00bcd4;
            
        }
       
        .pcoded .pcoded-navbar .pcoded-item {
            display: block !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
            position: relative !important;
            background: #169ddbb8 !important;
            height: 100% !important;
            position: absolute !important;
            width: 100% !important;
            height: 5074px !important;
            top: 0 !important;
            padding: 88px 0 0 0 !important;
          

        }
        ul.pcoded-item.pcoded-left-item li{
            margin-top: 25px !important;
            border-radius: 45px;
            border-bottom: 1px #fea3ad solid;
            border-right: 1px #fea3ad solid;
        }
        .pcoded[nav-type="st6"] .pcoded-item.pcoded-left-item>li>a>.pcoded-micon i {
            color: black !important;
        }
        ul.pcoded-item.pcoded-left-item li a:hover {
           background: #00bcd4 !important;
        }
        ul.pcoded-item.pcoded-left-item li a {
           color:black !important;
           
        }
    </style>

    <script src="{{ asset('lib/toastr/toastr.min.js') }}"></script>
    
    <!-- Required Jquery -->
    <!-- script datatable buttons -->
    <script type="text/javascript" src="{{asset('js/libs/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/libs/dataTables.buttons.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/libs/buttons.print.min.js')}}"></script>
   

    <script type="text/javascript" src="{{ asset('template/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('template/bower_components/popper.js/dist/umd/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('template/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('template/bower_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset('template/bower_components/modernizr/modernizr.js')}}"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{ asset('template/bower_components/chart.js/dist/Chart.js')}}"></script>
    <!-- amchart js -->
    <script src="{{ asset('template/assets/pages/widget/amchart/amcharts.js')}}"></script>
    <script src="{{ asset('template/assets/pages/widget/amchart/serial.js')}}"></script>
    <script src="{{ asset('template/assets/pages/widget/amchart/light.js')}}"></script>
    <script src="{{ asset('template/assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('template/assets/js/SmoothScroll.js')}}"></script>
    <script src="{{ asset('template/assets/js/pcoded.min.js')}}"></script> 
    <!-- custom js -->
    <script src="{{ asset('template/assets/js/vartical-layout.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('template/assets/pages/dashboard/custom-dashboard.js')}}"></script>
    <script type="text/javascript" src="{{ asset('template/assets/js/script.js')}}"></script>
</body>

</html>