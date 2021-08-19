<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WAN Teknologi Internasional') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script data-search-pseudo-elements defer src="{{ asset('template/portal/cloudflare/ajax/libs/font-awesome/5.11.2/js/all.min.js') }}" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{--  <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">  --}}

    <!-- Bootstrap core CSS-->
  <link href="{{ asset('template/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
  <!--Data Tables -->
  <link href="{{ asset('template/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('template/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/bootstrap.min.js') }}"></script>
    

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Engineering Service {{ Auth::check() }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                        <ul class="navbar-nav mr-auto">
                            @if(in_array(Auth::user()->akses,['0']))
                            <li class="nav-item">
                                <a id="navbarMaster" class="nav-link" href="{{ url('Master/Pengguna/') }}">
                                    Pengguna 
                                </a>
                            </li>
                            @else
                            @endif
                            
                            @if(in_array(Auth::user()->akses,['3']))
                            <li class="nav-item">
                                <a id="navbarMaster" class="nav-link" href="{{ url('Master/Barang') }}">
                                    Barang 
                                </a>
                            </li>
                            @else
                            @endif
                            
                            @if(in_array(Auth::user()->akses,['4']))
                            <li class="nav-item">
                                <a id="navbarMaster" class="nav-link" href="{{ url('Permintaan') }}">
                                    Permintaan 
                                </a>
                            </li>
                            @else
                            @endif

                            @if(in_array(Auth::user()->akses,['1','0']))
                            <li class="nav-item">
                                <a id="navbarMaster" class="nav-link" href="{{ url('Permintaan/ListPermintaan') }}">
                                    Daftar Permintaan 
                                </a>
                            </li>
                            @else
                            @endif

                            @if(in_array(Auth::user()->akses,['2']))
                            <li class="nav-item">
                                <a id="navbarMaster" class="nav-link" href="{{ url('Pengadaan') }}">
                                    Daftar Permintaan 
                                </a>
                            </li>
                            @else
                            @endif

                        </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item">
                                
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ Auth::user()->name }} | {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<!-- simplebar js -->
<script src="{{ asset('template/assets/plugins/simplebar/js/simplebar.js') }}"></script>
<!-- sidebar-menu js -->
<script src="{{ asset('template/assets/js/sidebar-menu.js') }}"></script>
<!-- Custom scripts -->
<script src="{{ asset('template/assets/js/app-script.js') }}"></script>
<!--Data Tables js-->
<script src="{{ asset('template/assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('template/assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/assets/plugins/bootstrap-datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('template/assets/plugins/bootstrap-datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('template/assets/plugins/bootstrap-datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('template/assets/plugins/bootstrap-datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('template/assets/plugins/bootstrap-datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('template/assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js') }}"></script>

<!--Sweet Alerts -->
<script src="{{ asset('template/assets/plugins/alerts-boxes/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('template/assets/plugins/alerts-boxes/js/sweet-alert-script.js') }}"></script>

<!--Select Plugins Js-->
<script src="{{ asset('template/assets/plugins/select2/js/select2.min.js') }}"></script>

</html>
