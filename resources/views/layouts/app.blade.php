<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Aplikasi penawaran</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{url('public/favicon_io/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('public/favicon_io/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('public/favicon_io/favicon-16x16.png')}}">
    <link rel="manifest" href="{{url('public/favicon_io/site.webmanifest')}}">

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ url('public/timepicker/jquery.datetimepicker.min.css') }}" />

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{url('public/bsadmin4/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
    <link rel="stylesheet" href="{{url('public/icpc/css/bootstrap-iconpicker.min.css')}}" />
    <link href="{{url('public/amsify/css/amsify.suggestags.css')}}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/sniperwolf/taggingJS/example/tag-basic-style.css" rel="stylesheet"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css" />
   <!--  <link href="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/skins/ui/oxide/content.min.css" rel="stylesheet"> -->

<!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
   

     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <script src="{{url('public/moment/moment.js')}}"></script>
     <script src="{{url('public/moment/moment-with-locales.js')}}"></script>
     <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

   


    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="{{url('public/vendor/laraberg/css/laraberg.css')}}">
    <link rel="stylesheet" href="{{ url('public/vendor/file-manager/css/file-manager.css') }}">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @media (min-width: 768px){
            .modal-xl{
                width: 90%;
                max-width: 1200px;
            }
        }

        .no-borders{
            border: 0;
            box-shadow: none;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-tree"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Aplikasi Penawaran</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?=(strpos(url()->current(), 'dashboard') !== false ? 'active' : '')?>">
                <a class="nav-link" href="{{url('dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{ __('navbar.dashboard') }}</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            @if (Auth::user()->hasRole('client') or Auth::user()->hasRole('perusahaan'))
            <div class="sidebar-heading">{{ __('navbar.profil') }}</div>
            @endif
            <li class="nav-item <?=(strpos(url()->current(), 'ref_client') !== false || strpos(url()->current(), 'ref_perusahaan') !== false ? 'active' : '')?>">
                
                @if (Auth::user()->hasRole('admin'))
               
                @elseif(Auth::user()->hasRole('client'))
                <?php 
                    $uid = 'ref_client/'.Auth::id();
                ?>
                <a class="nav-link" href="{{url($uid)}}">
                    <i class="fa fa-outdent" aria-hidden="true"></i>
                    {{ __('navbar.profil_anda') }}
                </a>
                @elseif(Auth::user()->hasRole('perusahaan'))
                <?php 
                    $uid = 'ref_perusahaan/'.Auth::id();
                ?>
                <a class="nav-link" href="{{url($uid)}}">
                    <i class="fa fa-outdent" aria-hidden="true"></i>
                    {{ __('navbar.profil_anda') }}
                </a>
                @endif
            </li>

            @if (Auth::user()->hasRole('admin'))
            <div class="sidebar-heading">{{ __('navbar.master_data') }}</div>
            <li class="nav-item <?=(strpos(url()->current(), 'ref_user') !== false ? 'active' : '')?>">
                <a class="nav-link" href="{{url('ref_user')}}">
                    <i class="fas fa-user-alt" aria-hidden="true"></i>
                    {{ __('navbar.user') }}
                </a>
            </li>


            

            <li class="nav-item <?=(strpos(url()->current(), 'ref_pekerjaan') !== false ? 'active' : '')?>">
                <a class="nav-link" href="{{url('ref_pekerjaan')}}">
                    <i class="fas fa-user-tag" aria-hidden="true"></i>
                    {{ __('navbar.tipe_job') }}
                </a>
            </li>


            <hr class="sidebar-divider">
             @endif

            <div class="sidebar-heading">{{ __('navbar.penawaran_jasa') }}</div>

            @if (Auth::user()->hasRole('client') or Auth::user()->hasRole('admin'))
            <li class="nav-item <?=(stripos(url()->current(), 'penawaran_jasa') !== false && stripos(url()->current(), 'approve_penawaran_jasa') === false  ? 'active' : '')?>">
                <a class="nav-link" href="{{url('penawaran_jasa')}}">
                    <i class="fas fa-briefcase" aria-hidden="true"></i>
                    {{ __('navbar.penawaran_jasa') }}
                </a>
            </li>
            @endif


            @if (Auth::user()->hasRole('perusahaan') or Auth::user()->hasRole('admin'))
            <li class="nav-item <?=(stripos(url()->current(), 'approve_penawaran_jasa') !== false ? 'active' : '')?>">
                <a class="nav-link" href="{{url('approve_penawaran_jasa')}}">
                    <i class="fas fa-business-time" aria-hidden="true"></i>
                    {{ __('navbar.approve_penawaran') }}
                </a>
            </li>
            @endif


            <hr class="sidebar-divider">

            @if (Auth::user()->hasRole('client') or Auth::user()->hasRole('admin'))
            <div class="sidebar-heading">{{ __('navbar.permintaan_jasa') }}</div>

            <li class="nav-item <?=(stripos(url()->current(), 'permintaan_jasa') !== false && stripos(url()->current(), 'approve_permintaan_jasa') === false  ? 'active' : '')?>">
                <a class="nav-link" href="{{url('permintaan_jasa')}}">
                    <i class="fas fa-hand-holding" aria-hidden="true"></i>
                    {{ __('navbar.permintaan_jasa') }}
                </a>
            </li>
            @endif

            @if (Auth::user()->hasRole('perusahaan') or Auth::user()->hasRole('admin'))

            <li class="nav-item <?=(stripos(url()->current(), 'approve_permintaan_jasa') !== false  ? 'active' : '')?>">
                <a class="nav-link" href="{{url('approve_permintaan_jasa')}}">
                    <i class="fas fa-hand-holding-usd" aria-hidden="true"></i>
                    {{ __('navbar.approve_permintaan') }}
                </a>
            </li>
            @endif

            <hr class="sidebar-divider">
            <div class="sidebar-heading">{{ __('navbar.pembelian') }}</div>


            @if (Auth::user()->hasRole('perusahaan') or Auth::user()->hasRole('admin'))
            <li class="nav-item <?=(stripos(url()->current(), 'pesanan_pembelian') !== false ? 'active' : '')?>">
                <a class="nav-link" href="{{url('pesanan_pembelian')}}">
                    <i class="fas fa-file-invoice" aria-hidden="true"></i>
                    {{ __('navbar.pesanan_pembelian') }}
                </a>
            </li>
            @endif



            <li class="nav-item <?=(stripos(url()->current(), 'pembayaran_pembelian') !== false ? 'active' : '')?>">
                <a class="nav-link" href="{{url('pembayaran_pembelian')}}">
                    <i class="fas fa-file-invoice-dollar" aria-hidden="true"></i>
                    {{ __('navbar.pembayaran_pembelian') }}
                </a>
            </li>

            <!-- Sidebar Message -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <ul class="navbar-nav">
                        <li class="nav-item"><p class="nav-link" style="color:black;">{{__('global.bahasa')}}: </p></li>
                       <li class="nav-item dropdown no-arrow"> 
                           <a style="color:#706f6f;" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ App::currentLocale() }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('locale', 'en') }}">
                                        English
                                    </a>
                                <li>
                                    <a class="dropdown-item" href="{{ route('locale', 'id') }}">
                                        Indonesia
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Topbar Search -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                         

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        

                        <!-- Nav Item - Messages -->
                

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                       

                        <li class="nav-item dropdown no-arrow">

                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->name}}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{url('public/bsadmin4/img/bird.png')}}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('konten')    
                </div>

                        <!-- Pending Requests Card Example -->
                <!-- /.container-fluid -->
                <!-- <div id="fm" style="height: 600px;"></div> -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <b>Aplikasi Penawaran</b> <?=date('Y')?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

              
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script type="text/javascript" src="{{ url('public/timepicker/jquery.datetimepicker.full.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.9/dayjs.min.js"></script>
    <script type="text/javascript" src="{{ url('public/timepicker/timepickers.js') }}"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{{url('public/icpc/js/bootstrap-iconpicker.bundle.min.js')}}"></script>            
    <!-- Core plugin JavaScript-->
    <script src="{{url('public/bsadmin4/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{url('public/bsadmin4/js/sb-admin-2.min.js')}}"></script>

    <!-- <script src="{{url('public/bsadmin4/js/datatables-demo.js')}}"></script>
 -->
</body>

</html>