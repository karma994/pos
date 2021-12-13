<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ngyo Tshong</title>
    <link rel="stylesheet" href="{{ asset('Dashboard/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Dashboard/vendors/base/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('Dashboard/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('Dashboard/images/favicon.png') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> -->
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
        <nav class="navbar top-navbar col-lg-12 col-12 p-0">
            <div class="container-fluid">
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                    <ul class="navbar-nav navbar-nav-left">
                        <li class="nav-item ml-0 mr-5 d-lg-flex d-none">
                            <a href="#" class="nav-link horizontal-nav-left-menu"><i
                                    class="mdi mdi-format-list-bulleted"></i></a>
                        </li>
                         <li class="nav-item nav-search d-none d-lg-block ml-3">
                        <b style="color:black; font-size:20px"><img src="{{ asset('Dashboard/images/ngotshonglogo.png') }}" alt="logo" width="100px"></b>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                               id="messageDropdown" href="#" data-toggle="dropdown">
                                <i class="mdi mdi-cart" style="color: black"></i>
                                <span class="count "><i class ="mdi mdi-fan mdi-spin" style="color: pink"></i></span>
                            </a>
                        </li>
                    </ul>
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <!-- <img src="{{ asset('Dashboard/images/logo.jpg') }}" alt="logo" height="55px"/> -->
                    </div>
                    <ul class="navbar-nav navbar-nav-right">
                        @can('View Accounts')
                        <li class="nav-item dropdown  d-lg-flex d-none">
                            <a href="{{ url('accounts') }}"><button type="button" class="btn btn-inverse-primary btn-sm" style = "{{ Request::is('accounts')? 'background-color: #5C7AEA; color:white': '' }}">Accounts</button></a>
                        </li>
                        @endcan
                        <!-- <li class="nav-item dropdown d-lg-flex d-none">
                            <button type="button" class="btn btn-inverse-primary btn-sm">Settings</button>
                        </li> -->
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                                <span class="nav-profile-name">{{ Auth::user()->name }}</span>
                                <span class="online-status"></span>
                                <i class="mdi mdi-account-circle text-primary"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                 aria-labelledby="profileDropdown">
                                <a class="dropdown-item">
                                    <i class="mdi mdi-account-star text-primary"></i>
                                    {{ Auth::user()->getRoleNames()[0] }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="mdi mdi-logout text-primary"></i>
                                        Logout
                                    </a>
                                </form>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                            data-toggle="horizontal-menu-toggle">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </div>
        </nav>
        <nav class="bottom-navbar">
            <div class="container">
                <ul class="nav page-navigation">
                        @can('View Dashboard')
                        <li class="{{ Request::is('home')? 'nav-item active': 'nav-item' }}">
                            <a class="nav-link" href="{{ url('home') }}">
                                <i class="mdi mdi-finance menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        @endcan
                    @if(auth()->user()->can('View Branch') || auth()->user()->can('View Department'))
                    <li class="{{ Request::is('master')? 'nav-item active': 'nav-item' }}">
                        <a href="#" class="nav-link">
                            <i class="mdi mdi-chart-areaspline menu-icon"></i>
                            <span class="menu-title">Master Setup</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="submenu">
                            <ul>
                                @can('View Branch')
                                <li class="nav-item"><a class="nav-link" href="/branches">Branch</a></li>
                                @endcan
                                @can('View Department')
                                <li class="nav-item"><a class="nav-link" href="/departments">Department</a></li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                    @endif
                    @if(auth()->user()->can('View User') || auth()->user()->can('View Role'))
                    <li class="{{ Request::is('user')? 'nav-item active': 'nav-item' }}">
                        <a href="#" class="nav-link">
                            <i class="mdi mdi-account-supervisor menu-icon"></i>
                            <span class="menu-title">User Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="submenu">
                            <ul>
                            @can('View Role')
                                <li class="nav-item"><a class="nav-link" href="{{ url('roles') }}">Roles</a></li>
                            @endcan
                            @can('View User')
                                <li class="nav-item"><a class="nav-link" href="{{ url('users') }}">Users</a></li>
                            @endcan
                            </ul>
                        </div>
                    </li>
                    @endif
                    @if(auth()->user()->can('View Products') || auth()->user()->can('View Category') || auth()->user()->can('View UOM'))
                    <li class="{{ Request::is('stock')? 'nav-item active': 'nav-item' }}">
                        <a href="#" class="nav-link">
                            <i class="mdi mdi-cart menu-icon"></i>
                            <span class="menu-title">Stock Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="submenu">
                            <ul>
                            @can('View Products')
                                <li class="nav-item"><a class="nav-link" href="{{ url('stocks') }}">Products</a></li>
                            @endcan
                            @can('View Category')
                                <li class="nav-item"><a class="nav-link" href="{{ url('categories') }}">Categories</a></li>
                            @endcan
                            @can('View UOM')
                                <li class="nav-item"><a class="nav-link" href="{{ url('uom') }}">Unit of Measurement</a></li>
                            @endcan
                            </ul>
                        </div>
                    </li>
                    @endif
                    @can('View Sales')
                    <li class="{{ Request::is('sale')? 'nav-item active': 'nav-item' }}">
                        <a href="{{ url('sale') }}" class="nav-link">
                            <i class="mdi mdi-point-of-sale menu-icon"></i>
                            <span class="menu-title">Sales Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                    </li>
                    @endcan
                    @can('View Customer-Management')
                    <li class="{{ Request::is('customer')? 'nav-item active': 'nav-item' }}">
                        <a href="{{ url('cs') }}" class="nav-link">
                            <i class="mdi mdi-nature-people menu-icon"></i>
                            <span class="menu-title">Customer Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </nav>
    </div>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
    <footer class="footer">
                <div class="footer-wrap">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <a href="https://webdynobhutan.com">Webdyno-Bhutan</a> | <span id="datenow"></span> </span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><strong>Bhutan, The Last Shangri-La</strong></span>
                    </div>
                </div>
            </footer>
</div>
<script>
    let date = new Date();
    date = date.getFullYear();
    $('#datenow').html(date)
</script>
<script src="{{ asset('Dashboard/vendors/base/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('Dashboard/js/template.js') }}"></script>
<script src="{{ asset('Dashboard/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('Dashboard/vendors/progressbar.js/progressbar.min.js') }}"></script>
<script src="{{ asset('Dashboard/vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js') }}"></script>
<script src="{{ asset('Dashboard/vendors/justgage/raphael-2.1.4.min.js') }}"></script>
<script src="{{ asset('Dashboard/vendors/justgage/justgage.js') }}"></script>
<script src="{{ asset('Dashboard/js/dashboard.js') }}"></script>
</body>
</html>
