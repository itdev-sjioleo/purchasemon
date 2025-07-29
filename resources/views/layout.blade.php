<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Laporan Purchase Monitoring</title>
    <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ url('public/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/adminlte/css/adminlte.min.css?v=3.2.0') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css">
    <style>
        .datatable-overflow-scroll {
            width: 100%;
            overflow-x: scroll;
        }
    </style>
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="margin-left: 0 !important">

            <ul class="navbar-nav">
                <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li> -->
                <li class="nav-item ml-2 mr-5">
                    <div style="display: flex; align-items: center;">
                        <img src="{{ url('public/Logo_SJIO_Small.png') }}" style="width: 40px">
                        <h4 class="ml-2 fw-bold mb-0">Purchase Monitoring</h4>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/view2">Summary View</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/view1">Detail View</a>
                </li>
            </ul>
        </nav>

        {{--<aside class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed">

            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ url('public/Logo_SJIO_Small.png') }}" alt="SJIO Logo"
                    class="brand-image img-circle" style="opacity: .8">
                <span class="brand-text font-weight-light">Purchase Monitoring</span>
            </a>

            <div class="sidebar d-flex flex-column" style="height: calc(100vh - 77px)">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ url('public/adminlte/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>

                <nav>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Purchase Monitoring<br>Report Master
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/summary') }}" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Purchase Monitoring<br>Report Summary
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="flex-grow-1"></div>

                <nav>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <form id="form-logout" method="post" action="{{ route('logout') }}">
                                @csrf
                            </form>
                            <a onclick="$('#form-logout').submit()" class="nav-link">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>

        </aside>--}}

        <div class="content-wrapper" style="margin-left: 0 !important">

            {{--<section class="content-header">
                <div class="container-fluid">
                    <div class="mb-2">
                        <div class="">
                            <h1>@yield('title')</h1>
                        </div>
                        <!-- <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">User Profile</li>
                            </ol>
                        </div> -->
                    </div>
                </div>
            </section>--}}

            <section class="content">
                <div class="container-fluid pt-3 pb-2">
                    @yield('content')
                </div>
            </section>

        </div>
    </div>

    <script src="{{ url('public/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- <script src="{{ url('public/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script> -->
    <!-- <script src="{{ url('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script> -->
    <!-- <script src="{{ url('public/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script> -->
    <!-- <script src="{{ url('public/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script> -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script> -->
    <script src="{{ url('public/adminlte/js/adminlte.min.js?v=3.2.0') }}"></script>
    <script src="{{ url('public/plugins/moment/moment.min.js') }}"></script>
    <!-- <script src="{{ url('public/plugins/jquery.doubleScroll.js') }}"></script> -->
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
    <script>
        const baseURL = "{{ url('/') }}";

        /**
         * Localization
         */
        const Rupiah = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
        });
    </script>
    @yield('scripts')
</body>

</html>