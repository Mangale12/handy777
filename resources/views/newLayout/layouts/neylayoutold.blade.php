<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="https://noorgames.net/images/logochangecolor.gif">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Noor Games </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('public/newAdmin/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/newAdmin/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('public/newAdmin/css/argon-dashboard.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.jqueryui.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.jqueryui.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/digital-7-mono" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link href="{{ asset('public/css/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <style>
        .hidden {
            display: none !important;
        }

        .mCSB_container_wrapper>.mCSB_container {
            padding: 0 !important;
        }

        .mCustomScrollBox.mCSB_vertical_horizontal.mCSB_inside>.mCSB_container_wrapper.mCS_no_scrollbar_x.mCS_x_hidden {
            margin: 0 !important;
        }

        .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
        .mCSB_scrollTools .mCSB_draggerRail {
            display: none;
        }

        .swal2-container {
            z-index: 9999 !important;
        }
    </style>


</head>

<body class="g-sidenav-show  bg-gray-100">
    @php
        if (!(request()->segment(1) == 'table')) {
            session()->forget('tableDate');
        } else {
            if (!isset($_GET['date'])) {
                session()->forget('tableDate');
            }
        }
    @endphp
    <div class="min-height-300  position-absolute w-100 back-image-game"></div>
    {{-- <div class="min-height-300  position-absolute w-100" style="background-color:#ffb342;"></div> --}}
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 d-block opac"
        aria-labelledby="sidenav-mainfilterlabel" aria-hidden="true">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="# " target="_blank">

                <span class="ms-1 font-weight-bold">Noor Game </br> {{ auth()->user()->name }}</span>
            </a>
        </div>
        <div class="count-div p-3 text-center">
            <p class="date-div"></p>
            <p class="date-countdown"></p>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'dashboard' && request()->segment(2) != 'colab' ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'table' ? 'active' : '' }}"
                        href="{{ route('table') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Tables</span>
                    </a>
                </li>
                @if (Auth::user()->role != 'data-expert')
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'todays-history' ? 'active' : '' }}"
                        href="{{ route('todays-history') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-history text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Todays History</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'redeem-history' ? 'active' : '' }}"
                        href="{{ route('redeemHistory') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-history text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Redeems</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'monthly-history' ? 'active' : '' }}"
                        href="{{ route('monthlyHistory') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-history text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Monthly History</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'games' ? 'active' : '' }}"
                        href="{{ route('games') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-chess-rook text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Games</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'gamers' ? 'active' : '' }}"
                        href="{{ route('gamers') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-gamepad text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Players</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'inactive-players' ? 'active' : '' }}"
                        href="{{ route('inactive-players', ['id' => 7]) }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Inactive Players</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'gamers-games' ? 'active' : '' }}"
                        href="{{ route('gamerGames', ['id' => 'all']) }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Gamers & Players</span>
                    </a>
                </li>
                @if (Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(1) == 'unsubmails' ? 'active' : '' }}"
                            href="{{ route('unsubMails') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-history text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Unsub Mails</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(1) == 'activity-status' ? 'active' : '' }}"
                            href="{{ route('activity.status.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-gamepad text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Activity Status</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(2) == 'colab' ? 'active' : '' }}"
                            href="{{ route('dashboard.colab') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Colab</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(1) == 'all-history' ? 'active' : '' }}"
                            href="{{ route('all-history') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-history text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">All History</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(1) == 'login-logs' ? 'active' : '' }}"
                            href="{{ route('loginLogs') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Login Logs</span>
                        </a>
                    </li>
                    <!--<li class="nav-item">-->
                    <!--  <a class="nav-link {{ request()->segment(1) == 'game-data' ? 'active' : '' }}" href="{{ route('gameData') }}">-->
                    <!--    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">-->
                    <!--      <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>-->
                    <!--    </div>-->
                    <!--    <span class="nav-link-text ms-1">Game Data</span>-->
                    <!--  </a>-->
                    <!--</li>-->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(1) == 'clear' ? 'active' : '' }}"
                            href="{{ route('clear.go') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Clear</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(2) == 'settings' ? 'active' : '' }}"
                            href="{{ route('settings') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Settings</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(2) == 'spinner' ? 'active' : '' }}"
                        href="{{ route('spinner') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Spinner</span>
                    </a>
                </li>
                @if (Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(2) == 'spinner-winner' ? 'active' : '' }}"
                            href="{{ route('spinner-winner') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Spinner Winner</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(1) == 'logs' ? 'active' : '' }}"
                            href="{{ route('logs') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Log Viewer</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->segment(1) == 'profile' ? 'active' : '' }}"
                        href="{{ route('profile') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-power-off text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </div>
        <style>
            .date-countdown {
                background: white;
                font-family: 'Digital-7', sans-serif;
                font-size: 30px;
                background: black;
                color: white;
                border: 5px solid #ffb342;
            }

            .count-div {
                background: #ffd9a2;
            }
        </style>
        <div class="count-div p-3 text-center di">
            <p>Logged in Since : {{ session()->get('log_in_time') ? session()->get('log_in_time') : '' }}</p>
            <a class="nav-link d-flex justify-content-center" href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <div class="border-radius-md d-flex">
                    <i class="fa fa-power-off text-dark text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        


    </aside>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
            data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb" class="breadcrumb-div">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                                href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">@yield('title')
                        </li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">@yield('title')</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
                        </div>
                    </div>
                    <ul class="navbar-nav justify-content-end mr-4 position-absolute">
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @yield('content')
            <footer class="footer pt-3  ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                © Noor Games
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>
                                made with by Noor Games
                                <a class="font-weight-bold" href="https://noorgames.net/">Noor Games</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </main>
</body>

<!--   Core JS Files   -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('public/js/jquery-input-mask-phone-number.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap-tagsinput.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>









<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.jqueryui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.jqueryui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.js"></script>


<script src="{{ asset('public/js/core/popper.min.js') }}"></script>
<script src="{{ asset('public/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/newAdmin/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('public/newAdmin/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('public/newAdmin/js/plugins/chartjs.min.js') }}"></script>
<script src="{{ asset('public/js/core/bootstrap.min.js') }}"></script>
<!--<script src="{{ asset('public/newAdmin/js/argon-dashboard.min.js') }}"></script>-->

<script src="{{ asset('public/js/editable.js') }}"></script>


{{-- <script src="../../public/js/core/popper.min.js" type="text/javascript"></script>
<script src="../../public/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="../../public/js/plugins/bootstrap-notify.js"></script>
<script src="../../public/js/light-bootstrap-dashboard790f.js" type="text/javascript"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script src="{{ asset('public/js/demo.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('public/js/table.js') }}"></script>

<script src="{{ asset('public/js/jquery.mCustomScrollbar.js') }}"></script>

@if (isset($activeGame) && $activeGame['image'] != '')
    <script>
        $('.back-image-game').css('background-image', "url('public/uploads/{{ $activeGame['image'] }}')");
        $('body').css('background-image', "url('public/uploads/{{ $activeGame['image'] }}')");
        $('body').css('object-fit', "fill");
    </script>
@else
    <script>
        $('.back-image-game').css('background-color', '#ffb342');
    </script>
@endif
<script>
    $(function() {
        $(".emails").tagsinput('items');
        $('#phone-number').usPhoneFormat({
            format: 'xxx-xxx-xxxx'
        });
        $('#summernote').summernote();
        $('.select2').select2({
            dropdownParent: $('#popup33')
        });
    });
</script>
@if (session('success'))
    <script>
        toastr.success('{{ session('success') }}');
    </script>
@endif
@if (session('error'))
    @if (is_array(session('error')))
        @foreach (session('error') as $error)
            <script>
                toastr.error(' {{ $error }}');
            </script>
        @endforeach
    @else
        <script>
            toastr.error(' {{ session('error') }}');
        </script>
    @endif
@endif
<script>
    // $(document).ready( function () {
    //     $('.datatable').DataTable({
    //         pageLength: 100,
    //         dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
    //         buttons: [
    //         {
    //            extend: 'copy',
    //            className: 'btn-sm btn-info',
    //            title: 'Gamers',
    //            header: false,
    //            footer: true,
    //            exportOptions: {
    //               // columns: ':visible'
    //            }
    //         },
    //         {
    //            extend: 'csv',
    //            className: 'btn-sm btn-success',
    //            title: 'Gamers',
    //            header: false,
    //            footer: true,
    //            exportOptions: {
    //               // columns: ':visible'
    //            }
    //         },
    //         {
    //            extend: 'excel',
    //            className: 'btn-sm btn-warning',
    //            title: 'Gamers',
    //            header: false,
    //            footer: true,
    //            exportOptions: {
    //               // columns: ':visible',
    //            }
    //         },
    //         {
    //            extend: 'pdf',
    //            className: 'btn-sm btn-primary',
    //            title: 'Gamers',
    //            pageSize: 'A2',
    //            header: false,
    //            footer: true,
    //            exportOptions: {
    //               // columns: ':visible'
    //            }
    //         },
    //         {
    //            extend: 'print',
    //            className: 'btn-sm btn-success',
    //            title: 'Gamers',
    //            // orientation:'landscape',
    //            pageSize: 'A2',
    //            header: true,
    //            footer: false,
    //            orientation: 'landscape',
    //            exportOptions: {
    //               // columns: ':visible',
    //               stripHtml: false
    //            }
    //         }
    //      ],
    //     });
    // } );
</script>
<script>
    $("#iconNavbarSidenav").click(function() {

        $('.sidenav').toggleClass("opac");
    });
</script>
<script>
    jQuery(document).ready(function() {

        $(".jquery-width").css("width", "100%");

        var link = $('.delete-form').attr("href");
        // var link = $('.delete-form');
        $('.datatable tbody').on('click', '.delete-form', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delete this?',
                showDenyButton: true,
                showCancelButton: true,
                showConfirmButton: false,
                // confirmButtonText: 'Save',
                denyButtonText: `Delete`,
            }).then((result) => {
                if (result.isConfirmed) {} else if (result.isDenied) {
                    var cid = $(this).data('id');
                    $.ajax({
                        type: 'get',
                        url: "/gamers/destroy/" + cid,
                        data: {
                            "cid": $(this).data('id'),
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            $('.tr-' + cid).remove();
                            $(".count-row").each(function(index) {
                                $(this).text((index + 1));
                                // console.log( index + ": " + $( this ).text() );
                            })
                            toastr.success('Success', "Deleted");

                        },
                        error: function(data) {
                            console.log(data);
                            toastr.error('Error', data.responseText);
                        }
                    });
                    // window.location = link;
                }
            });
        });

        $('.datatable tbody').on('click', '.edit-form', function() {
            $('.editFormModal').modal('show');
            var cid = $(this).data('id');
            $.ajax({
                type: 'get',
                url: "/gamers/edit/" + cid,
                data: {
                    "cid": $(this).data('id'),
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('.appendHere').remove();
                    $('.editFormModalBody').append('<div class="appendHere"></div>');
                    $('.appendHere').append(data);
                    // $('#summernote').summernote();
                    // $( ".count-row" ).each(function( index ) {
                    // $(this).text((index+1));
                    // console.log( index + ": " + $( this ).text() );
                    // })
                    // toastr.success('Success',"Deleted");

                },
                error: function(data) {
                    console.log(data);
                    toastr.error('Error', data.responseText);
                }
            });
        });

        // Scrollbar
        $("#sidenav-main, #sidenav-collapse-main").mCustomScrollbar({
            axis: "yx",
            // theme:"dark"
        });


    });
</script>
<script>
    x = '<?php echo Carbon\Carbon::now() . '   (' . config('app.timezone') . ')'; ?>';
    console.log(x);
    //   var dateTime = new Date();
    var weekday = new Array(7);
    weekday[0] = "Sunday";
    weekday[1] = "Monday";
    weekday[2] = "Tuesday";
    weekday[3] = "Wednesday";
    weekday[4] = "Thursday";
    weekday[5] = "Friday";
    weekday[6] = "Saturday";


    var monthNames = new Array(7);
    monthNames[0] = "January";
    monthNames[1] = "February";
    monthNames[2] = "March";
    monthNames[3] = "April";
    monthNames[4] = "May";
    monthNames[5] = "June";
    monthNames[6] = "July";
    monthNames[7] = "August";
    monthNames[8] = "September";
    monthNames[9] = "October";
    monthNames[10] = "November";
    monthNames[11] = "December";

    var dateTime = new Date(x);
    var dayName = weekday[dateTime.getDay()];
    var monthName2 = monthNames[dateTime.getMonth()];
    //   console.log(dateTime.getFullYear());
    //   console.log(monthNames[dateTime.getMonth()]);
    var hour, hourTemp, minute, minuteTemp, second, secondTemp, monthnumber, monthnumberTemp, monthday, monthdayTemp,
        year, ap;

    function timefunction() {
        dateTime.setSeconds(dateTime.getSeconds() + 1, 0);
        hourTemp = hour = dateTime.getHours();

        minuteTemp = minute = dateTime.getMinutes();
        if (minute.toString().length == 1)
            minuteTemp = "0" + minute.toString();

        secondTemp = second = dateTime.getSeconds();
        if (second.toString().length == 1)
            secondTemp = "0" + second.toString();

        monthnumberTemp = monthnumber = dateTime.getMonth();
        if ((monthnumber + 1).toString().length == 1)
            monthnumberTemp = "0" + (monthnumber + 1).toString();

        monthdayTemp = monthday = dateTime.getDate();
        if (monthday.toString().length == 1)
            monthdayTemp = "0" + monthday.toString();
        year = dateTime.getFullYear();
        // console.log(dateTime.getYear());
        ap = "AM";
        if (hour > 11) {
            ap = "PM";
        }
        if (hour > 12) {
            hour = hour - 12;
        }
        if (hour == 0) {
            hour = 12;
        }
        if (hour.toString().length == 1)
            hourTemp = "0" + hour.toString();
        $('.date-div').text(dayName + ", " + monthdayTemp + " " + monthName2 + "," + year);


        $('.date-countdown').text(hourTemp + " : " + minuteTemp + " : " + secondTemp + " " + ap);
        // document.getElementById('time').innerHTML = monthnumberTemp + "/" + monthdayTemp + "/" + year + " " + hourTemp + ":" + minuteTemp + ":" + secondTemp + " " + ap;
    }
    timefunction();
    setInterval("timefunction()", 1000);


    function initSelect2() {
        console.log('initSelect2');
        $(".select2").select2();
    }
</script>
@yield('script');

</html>
