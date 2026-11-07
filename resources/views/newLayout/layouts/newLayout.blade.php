       <!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/abgaming.jpeg') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - AB Gaming </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('public/newAdmin/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/newAdmin/css/nucleo-svg.css') }}" rel="stylesheet" />
    
    <!-- switch cherry -->
    @unless (request()->routeIs('dashboard'))
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    @endunless
    
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('public/newAdmin/css/argon-dashboard.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    @unless (request()->routeIs('dashboard'))
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.jqueryui.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.jqueryui.css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/digital-7-mono" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('public/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    @endunless

    <link href="{{ asset('public/css/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        .dashboard-header-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-left: auto;
        }

        .dashboard-chat-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 12px;
            color: #fff !important;
            background: linear-gradient(135deg, #246bfe, #7448f5);
            box-shadow: 0 8px 18px rgba(36, 107, 254, .24);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none !important;
            transition: transform .2s, box-shadow .2s, filter .2s;
        }

        .dashboard-chat-link:hover {
            color: #fff !important;
            filter: brightness(1.08);
            box-shadow: 0 11px 24px rgba(36, 107, 254, .35);
            transform: translateY(-1px);
        }

        .dashboard-chat-link i {
            font-size: 15px;
        }

        .dashboard-menu-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 575px) {
            .dashboard-chat-link span {
                display: none;
            }

            .dashboard-chat-link {
                width: 40px;
                height: 40px;
                padding: 0;
                justify-content: center;
            }
        }

        /* start side nav bar */
        .nav-side-menu {
  overflow: auto;
  font-family: verdana;
  font-size: 12px;
  font-weight: 200;
  /* background-color: #2e353d; */
  /* position: fixed; */
  top: 0px;
  width: 230px;
  height: 100%;
  color: black!important;
}
.nav-side-menu .brand {
  background-color: #23282e;
  line-height: 50px;
  display: block;
  text-align: center;
  font-size: 14px;
}
.nav-side-menu .toggle-btn {
  display: none;
}
.nav-side-menu ul,
.nav-side-menu li {
  list-style: none;
  padding: 0px;
  margin: 0px;
  line-height: 35px;
  cursor: pointer;
  color: black !important;
  /*
    .collapsed{
       .arrow:before{
                 font-family: FontAwesome;
                 content: "\f053";
                 display: inline-block;
                 padding-left:10px;
                 padding-right: 10px;
                 vertical-align: middle;
                 float:right;
            }
     }
*/
}
.nav-side-menu ul :not(collapsed) .arrow:before,
.nav-side-menu li :not(collapsed) .arrow:before {
  font-family: FontAwesome;
  content: "\f078";
  display: inline-block;
  padding-left: 10px;
  padding-right: 10px;
  vertical-align: middle;
  float: right;
}
.nav-side-menu ul .active,
.nav-side-menu li .active {
  border-left: 3px solid #d19b3d;
  background-color: #ede9df;
}
.nav-side-menu ul .sub-menu li.active,
.nav-side-menu li .sub-menu li.active {
  color: #d19b3d;
}
.nav-side-menu ul .sub-menu li.active a,
.nav-side-menu li .sub-menu li.active a {
  color: #d19b3d;
}
.nav-side-menu ul .sub-menu li,
.nav-side-menu li .sub-menu li {
  /* background-color: #181c20; */
  border: none;
  line-height: 28px;
  border-bottom: 1px solid #23282e;
  margin-left: 0px;
}
.nav-side-menu ul .sub-menu li:hover,
.nav-side-menu li .sub-menu li:hover {
  background-color: #ede9df;
}
.nav-side-menu ul .sub-menu li:before,
.nav-side-menu li .sub-menu li:before {
  /* font-family: FontAwesome;
  content: "\f105"; */
  display: inline-block;
  padding-left: 10px;
  padding-right: 10px;
  vertical-align: middle;
}
.sub-menu{
    padding-left: 45px !important;
}
.nav-side-menu li {
  padding-left: 0px;
  /* border-left: 3px solid #2e353d;
  border-bottom: 1px solid #23282e; */
  color: black;
  margin: 23px 0;
}
.nav-side-menu li a {
  text-decoration: none;
  color: black;
}
.nav-side-menu li a i {
  padding-left: 10px;
  width: 20px;
  padding-right: 20px;
}
.nav-side-menu li:hover {
  border-left: 3px solid #d19b3d;
  background-color: #ede9df;
  -webkit-transition: all 1s ease;
  -moz-transition: all 1s ease;
  -o-transition: all 1s ease;
  -ms-transition: all 1s ease;
  transition: all 1s ease;
}
@media (max-width: 767px) {
  .nav-side-menu {
    position: relative;
    width: 100%;
    margin-bottom: 10px;
  }
  .nav-side-menu .toggle-btn {
    display: block;
    cursor: pointer;
    position: absolute;
    right: 10px;
    top: 10px;
    z-index: 10 !important;
    padding: 3px;
    background-color: #ffffff;
    color: #000;
    width: 40px;
    text-align: center;
  }
  .brand {
    text-align: left !important;
    font-size: 22px;

    padding-left: 20px;
    line-height: 50px !important;
  }
}
@media (min-width: 767px) {
  .nav-side-menu .menu-list .menu-content {
    display: block;
  }
}
body {
  margin: 0px;
  padding: 0px;
}
.nav-link{
    display: flex;
}
.sub-menu .nav-item{
    border: none!important;
}
.user-panel .image img{
    border-radius: 50%;
    width: 61px;
    height: auto;
}

/* end side nav bar  */
    </style>

    <style>
        :root {
            --admin-ink: #17233d;
            --admin-muted: #8b96ad;
            --admin-sidebar: #101a34;
            --admin-sidebar-light: #192850;
            --admin-accent: #6c63ff;
            --admin-accent-blue: #2f7bff;
            --admin-page: #f3f6fb;
        }

        html,
        body {
            min-height: 100%;
        }

        body.admin-shell {
            overflow-x: hidden;
            background: var(--admin-page);
            color: var(--admin-ink);
            font-family: 'Open Sans', sans-serif;
        }

        body.admin-shell::before {
            position: fixed;
            z-index: 0;
            inset: 0;
            background:
                radial-gradient(circle at 78% 0%, rgba(110, 99, 255, .13), transparent 32%),
                radial-gradient(circle at 16% 15%, rgba(47, 123, 255, .09), transparent 28%),
                var(--admin-page);
            content: '';
            pointer-events: none;
        }

        body.admin-shell .back-image-game {
            z-index: 0;
            top: 0;
            left: 0;
            height: 330px;
            min-height: 0 !important;
            opacity: .96;
            background:
                linear-gradient(120deg, rgba(15, 26, 58, .98), rgba(39, 67, 145, .9) 58%, rgba(108, 99, 255, .78)),
                radial-gradient(circle at 75% 20%, rgba(255, 255, 255, .13), transparent 26%);
            pointer-events: none;
        }

        body.admin-shell .back-image-game::after {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(255, 255, 255, .04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .04) 1px, transparent 1px);
            background-size: 32px 32px;
            content: '';
            opacity: .35;
        }

        .admin-sidebar {
            position: fixed !important;
            z-index: 1040 !important;
            top: 16px !important;
            bottom: 16px !important;
            left: 16px !important;
            display: flex !important;
            flex-direction: column;
            width: 264px !important;
            height: auto !important;
            min-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .08) !important;
            border-radius: 22px !important;
            background: linear-gradient(180deg, var(--admin-sidebar-light), var(--admin-sidebar)) !important;
            box-shadow: 0 22px 55px rgba(12, 25, 57, .25);
            color: #fff !important;
        }

        .admin-sidebar-brand {
            flex: 0 0 auto;
            padding: 20px 18px 14px;
            border-bottom: 1px solid rgba(255, 255, 255, .09);
        }

        .admin-brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff !important;
            text-decoration: none !important;
        }

        .admin-brand-mark {
            display: inline-flex;
            flex: 0 0 48px;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 15px;
            background: rgba(255, 255, 255, .08);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .18);
        }

        .admin-brand-mark img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .admin-brand-copy {
            display: flex;
            flex-direction: column;
            min-width: 0;
            line-height: 1.25;
        }

        .admin-brand-copy strong {
            color: #fff;
            font-size: 16px;
            letter-spacing: .01em;
        }

        .admin-brand-copy small {
            margin-top: 4px;
            color: rgba(255, 255, 255, .58);
            font-size: 10px;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .admin-profile-toggle {
            display: flex;
            align-items: center;
            width: 100%;
            gap: 10px;
            margin-top: 18px;
            padding: 10px;
            border: 1px solid transparent;
            border-radius: 13px;
            background: rgba(255, 255, 255, .06);
            color: #fff;
            text-align: left;
            transition: border-color .2s ease, background .2s ease;
        }

        .admin-profile-toggle:hover,
        .admin-profile-toggle[aria-expanded="true"] {
            border-color: rgba(255, 255, 255, .14);
            background: rgba(255, 255, 255, .11);
        }

        .admin-user-avatar {
            display: inline-flex;
            flex: 0 0 34px;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 11px;
            background: linear-gradient(135deg, #6c63ff, #2f7bff);
            color: #fff;
            font-size: 13px;
        }

        .admin-user-copy {
            display: flex;
            flex: 1;
            flex-direction: column;
            min-width: 0;
            line-height: 1.25;
        }

        .admin-user-copy strong {
            overflow: hidden;
            color: #fff;
            font-size: 12px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-user-copy small {
            margin-top: 3px;
            color: rgba(255, 255, 255, .58);
            font-size: 10px;
            text-transform: capitalize;
        }

        .admin-profile-chevron {
            color: rgba(255, 255, 255, .6);
            font-size: 10px;
            transition: transform .2s ease;
        }

        .admin-profile-toggle[aria-expanded="true"] .admin-profile-chevron {
            transform: rotate(180deg);
        }

        .admin-profile-menu {
            margin: 8px 0 0 !important;
            padding: 6px !important;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 13px;
            background: rgba(5, 12, 31, .34);
        }

        .admin-profile-menu .nav-item {
            margin: 2px 0 !important;
        }

        .admin-profile-menu .nav-link {
            min-height: 36px;
            padding: 8px 10px !important;
            border-radius: 9px;
            color: rgba(255, 255, 255, .76) !important;
            font-size: 12px;
        }

        .admin-profile-menu .nav-link:hover {
            background: rgba(255, 255, 255, .08);
            color: #fff !important;
        }

        .admin-profile-menu .icon {
            width: 22px !important;
            min-width: 22px;
            margin-right: 5px !important;
            background: transparent !important;
        }

        .admin-profile-menu .nav-link i {
            padding: 0 !important;
            color: rgba(255, 255, 255, .68) !important;
        }

        .admin-sidebar > #sidenav-collapse-main {
            display: block !important;
            flex: 1 1 auto;
            width: 100% !important;
            min-height: 0;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .admin-sidebar #sidenav-collapse-main > .nav-side-menu {
            width: 100%;
            height: auto !important;
            min-height: 0;
            overflow: hidden;
            color: #fff !important;
        }

        .admin-menu-heading {
            margin: 18px 18px 8px;
            color: rgba(255, 255, 255, .42);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .admin-sidebar .menu-list {
            padding: 0 10px 12px;
        }

        .admin-sidebar .menu-content {
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .admin-sidebar .menu-content > .nav-item,
        .admin-sidebar .menu-content > li[data-toggle="collapse"] {
            margin: 3px 0 !important;
            border: 0 !important;
        }

        .admin-sidebar .nav-link {
            display: flex;
            align-items: center;
            min-height: 44px;
            padding: 9px 12px !important;
            border: 1px solid transparent;
            border-radius: 12px;
            color: rgba(255, 255, 255, .7) !important;
            font-size: 12px;
            font-weight: 600;
            transition: color .2s ease, background .2s ease, border-color .2s ease, transform .2s ease;
        }

        .admin-sidebar .nav-link:hover {
            transform: translateX(2px);
            border-color: rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .08);
            color: #fff !important;
        }

        .admin-sidebar .nav-link.active {
            border-color: rgba(255, 255, 255, .14);
            background: linear-gradient(135deg, rgba(108, 99, 255, .95), rgba(47, 123, 255, .9));
            box-shadow: 0 9px 18px rgba(24, 47, 126, .28);
            color: #fff !important;
        }

        .admin-sidebar .nav-link .icon {
            display: inline-flex;
            flex: 0 0 30px;
            align-items: center;
            justify-content: center;
            width: 30px !important;
            height: 30px;
            margin-right: 7px !important;
            border-radius: 9px;
            background: rgba(255, 255, 255, .08) !important;
        }

        .admin-sidebar .nav-link i {
            padding: 0 !important;
            color: rgba(203, 216, 255, .74) !important;
            font-size: 13px;
        }

        .admin-sidebar .nav-link.active i,
        .admin-sidebar .nav-link:hover i {
            color: #fff !important;
        }

        .admin-sidebar .nav-link-text {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-sidebar li[data-toggle="collapse"] > .nav-link {
            cursor: pointer;
        }

        .admin-sidebar li[data-toggle="collapse"] > .nav-link .arrow {
            width: 7px;
            height: 7px;
            margin-left: auto;
            padding: 0;
            border-top: 1px solid currentColor;
            border-right: 1px solid currentColor;
            transform: rotate(45deg);
            transition: transform .2s ease;
        }

        .admin-sidebar li[data-toggle="collapse"] > .nav-link .arrow::before {
            display: none !important;
            content: none !important;
        }

        .admin-sidebar li[data-toggle="collapse"]:not(.collapsed) > .nav-link .arrow {
            transform: rotate(135deg) translate(-2px, 2px);
        }

        .admin-sidebar .sub-menu {
            margin: 2px 0 7px !important;
            padding: 4px 0 4px 14px !important;
            border-left: 1px solid rgba(255, 255, 255, .12);
            background: transparent;
        }

        .admin-sidebar .sub-menu .nav-item {
            margin: 2px 0 !important;
            border: 0 !important;
        }

        .admin-sidebar .sub-menu .nav-link {
            min-height: 37px;
            padding: 7px 10px !important;
            border-radius: 9px;
            color: rgba(255, 255, 255, .58) !important;
            font-size: 11px;
            font-weight: 500;
        }

        .admin-sidebar .sub-menu .nav-link .icon {
            flex-basis: 23px;
            width: 23px !important;
            height: 23px;
            margin-right: 5px !important;
            background: transparent !important;
        }

        .admin-sidebar .sub-menu .nav-link.active,
        .admin-sidebar .sub-menu .nav-link:hover {
            background: rgba(108, 99, 255, .22);
            color: #fff !important;
        }

        .admin-sidebar #sidenav-collapse-main > .nav-side-menu,
        .admin-sidebar #sidenav-collapse-main > .nav-side-menu .menu-list {
            overflow: visible !important;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, .2) transparent;
        }

        .admin-sidebar #sidenav-collapse-main > .navbar-nav {
            display: block;
            margin: 0 !important;
            padding: 0 10px 14px;
        }

        .admin-sidebar #sidenav-collapse-main > .navbar-nav .nav-item {
            margin: 3px 0 !important;
        }

        .admin-sidebar #sidenav-collapse-main > .nav-side-menu::-webkit-scrollbar {
            width: 5px;
        }

        .admin-sidebar #sidenav-collapse-main > .nav-side-menu::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background: rgba(255, 255, 255, .2);
        }

        .admin-sidebar .count-div {
            flex: 0 0 auto;
            height: auto !important;
            margin: 12px 16px;
            padding: 13px 12px !important;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 14px;
            background: rgba(255, 255, 255, .06) !important;
        }

        .admin-sidebar .count-div p {
            margin: 0;
            color: rgba(255, 255, 255, .58);
            font-size: 10px;
            line-height: 1.6;
        }

        .admin-sidebar .date-div {
            color: rgba(255, 255, 255, .8) !important;
            font-size: 11px !important;
            font-weight: 600;
        }

        .admin-sidebar .date-countdown {
            margin-top: 5px !important;
            border: 0 !important;
            background: transparent !important;
            color: #fff !important;
            font-family: 'Open Sans', sans-serif !important;
            font-size: 15px !important;
            font-weight: 700;
            letter-spacing: .05em;
        }

        .admin-sidebar .count-div-bottum {
            margin-top: auto;
            margin-bottom: 14px;
            background: rgba(5, 12, 31, .3) !important;
        }

        .admin-main {
            z-index: 1;
            min-height: 100vh;
            margin-left: 280px !important;
            background: transparent !important;
        }

        .admin-main > #navbarBlur {
            min-height: 76px;
            margin: 16px 22px 0 !important;
            border: 1px solid rgba(255, 255, 255, .14) !important;
            border-radius: 18px !important;
            background: rgba(20, 37, 79, .72) !important;
            box-shadow: 0 14px 35px rgba(13, 29, 69, .16) !important;
            -webkit-backdrop-filter: blur(16px);
            backdrop-filter: blur(16px);
        }

        .admin-main > #navbarBlur .breadcrumb-div h6,
        .admin-main > #navbarBlur .breadcrumb-div .breadcrumb-item,
        .admin-main > #navbarBlur .breadcrumb-div .breadcrumb-item a {
            color: rgba(255, 255, 255, .9) !important;
        }

        .admin-main > .container-fluid {
            position: relative;
            z-index: 1;
            padding: 24px 22px 18px !important;
        }

        .admin-main .footer {
            color: var(--admin-muted);
        }

        .admin-sidebar-backdrop {
            display: none;
        }

        @media (max-width: 1199px) {
            .admin-sidebar {
                transform: translateX(-112%);
                visibility: hidden;
                opacity: 0;
                transition: transform .25s ease, opacity .25s ease, visibility .25s ease;
            }

            .admin-sidebar:not(.opac) {
                transform: translateX(0);
                visibility: visible;
                opacity: 1;
                content-visibility: visible;
            }

            .admin-sidebar-backdrop {
                position: fixed;
                z-index: 1030;
                inset: 0;
                display: block;
                visibility: hidden;
                background: rgba(8, 15, 35, .5);
                opacity: 0;
                transition: opacity .25s ease, visibility .25s ease;
            }

            .admin-sidebar:not(.opac) + .admin-sidebar-backdrop {
                visibility: visible;
                opacity: 1;
            }

            .admin-main {
                margin-left: 0 !important;
            }

            .admin-main > #navbarBlur {
                margin: 12px 16px 0 !important;
            }

            .admin-main > .container-fluid {
                padding: 20px 16px 16px !important;
            }
        }

        @media (max-width: 575px) {
            .admin-sidebar {
                top: 10px !important;
                bottom: 10px !important;
                left: 10px !important;
                width: min(264px, calc(100vw - 20px)) !important;
            }

            .admin-main > #navbarBlur {
                min-height: 64px;
                margin: 10px 10px 0 !important;
                border-radius: 15px !important;
            }

            .admin-main > #navbarBlur .container-fluid {
                padding: 8px 12px !important;
            }

            .admin-main > #navbarBlur .breadcrumb {
                display: none;
            }

            .admin-main > .container-fluid {
                padding: 16px 10px !important;
            }
        }
    </style>


</head>

<body class="admin-shell g-sidenav-show bg-gray-100">
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
    <aside class="sidenav admin-sidebar navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl fixed-start d-block opac"
        aria-labelledby="sidenav-mainfilterlabel" aria-hidden="false">
        <div class="admin-sidebar-brand">
            <a class="admin-brand-link" href="{{ route('dashboard') }}" aria-label="AB Gaming dashboard">
                <span class="admin-brand-mark">
                    <img src="{{ asset('images/abgaming.jpeg') }}" alt="AB Gaming logo">
                </span>
                <span class="admin-brand-copy">
                    <strong>AB Gaming</strong>
                    <small>Admin console</small>
                </span>
            </a>
            <button type="button" class="admin-profile-toggle collapsed" data-toggle="collapse" data-target="#user-details"
                aria-controls="user-details" aria-expanded="false">
                <span class="admin-user-avatar"><i class="fa fa-user" aria-hidden="true"></i></span>
                <span class="admin-user-copy">
                    <strong>{{ auth()->user()->name ?? 'User' }}</strong>
                    <small>{{ ucfirst(auth()->user()->role ?? 'user') }}</small>
                </span>
                <i class="fa fa-chevron-down admin-profile-chevron" aria-hidden="true"></i>
            </button>
        </div>
        <ul id="user-details" class="collapse list-unstyled admin-profile-menu">
            {{-- <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
            </li> --}}
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

            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
        {{-- <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="# " target="_blank">

                <span class="ms-1 font-weight-bold">AB Gaming </br> {{ auth()->user()->name }}</span>
            </a>
        </div> --}}
        <div class="count-div p-3 text-center">
            <p class="date-div"></p>
            <p class="date-countdown"></p>
        </div>
        <hr class="horizontal dark mt-0">

        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <div class=" nav-side-menu">
                <div class="admin-menu-heading">Workspace</div>
                <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

                    <div class="menu-list">

                        <ul id="menu-content" class="menu-content collapse out">
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
                                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                        {{-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i> --}}
                                        <i class="fa fa-table text-warning text-sm opacity-10"  aria-hidden="true"></i>

                                    </div>
                                    <span class="nav-link-text ms-1">Tables</span>
                                </a>
                            </li>

                            <li  data-toggle="collapse" data-target="#products" class="collapsed  nav-item">
                              <a href="#" class="nav-link {{Route::is('todays-history','monthlyHistory','all-history','redeemHistory') ? 'active' : ' '}}" >
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-history text-warning text-sm opacity-10"></i>

                            </div>
                            <span class="nav-link-text ms-1">History</span> <span class="arrow"></span></a>
                            </li>
                            <ul class="sub-menu collapse" id="products">
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
                                    <a class="nav-link {{ request()->segment(1) == 'monthly-history' ? 'active' : '' }}"
                                        href="{{ route('monthlyHistory') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-history text-warning text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Monthly History</span>
                                    </a>
                                </li>
                                @endif
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
                                    <a class="nav-link {{ request()->segment(1) == 'players-load-details' ? 'active' : '' }}"
                                        href="{{ route('players-load-details') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-history text-warning text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Players Load Details</span>
                                    </a>
                                </li>
                                @if (Auth::user()->role == 'admin')
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
                                @endif
                                {{-- <li><a href="#">General</a></li>
                                <li><a href="#">Buttons</a></li>
                                <li><a href="#">Tabs & Accordions</a></li>
                                <li><a href="#">Typography</a></li>
                                <li><a href="#">FontAwesome</a></li>
                                <li><a href="#">Slider</a></li>
                                <li><a href="#">Panels</a></li>
                                <li><a href="#">Widgets</a></li>
                                <li><a href="#">Bootstrap Model</a></li> --}}
                            </ul>



                            {{-- <li data-toggle="collapse" data-target="#service" class="collapsed">
                              <a href="#"><i class="fa fa-globe fa-lg"></i> Players <span class="arrow"></span></a>
                            </li>   --}}
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'cashier')
                            <li  data-toggle="collapse" data-target="#service" class="collapsed  nav-item">
                                <a href="#" class="nav-link {{Route::is('gamers','inactive-players','unsubMails') ? 'active' : ''}}">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                  <i class="fa fa-gamepad text-warning text-sm opacity-10"></i>
                              </div>
                              <span class="nav-link-text ms-1">Players</span> <span class="arrow"></span></a>
                            </li>
                            <ul class="sub-menu collapse" id="service">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->segment(1) == 'gamers' ? 'active' : '' }}"
                                        href="{{ route('gamers') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-gamepad text-warning text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">All Players</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->segment(1) == 'inactive-players' ? 'active' : '' }}"
                                        href="{{ route('inactive-players', ['id' => 7]) }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-gamepad text-muted text-sm opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Inactive Players</span>
                                    </a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->segment(1) == 'inactive-players' ? 'active' : '' }}"
                                        href="{{ route('admin.add_players') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-gamepad text-muted text-sm opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Add New Player</span>
                                    </a>
                                </li>
                        </button>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->segment(1) == 'user-details' ? 'active' : '' }}"
                                        href="{{ route('user_details.store') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-gamepad text-muted text-sm opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Upload Sheet</span>
                                    </a>
                                </li>
                              {{-- <li>New Service 2</li>
                              <li>New Service 3</li> --}}
                            </ul>
                            @endif
                        @if (Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->segment(1) == 'unsubmails' ? 'active' : '' }}"
                                    href="{{ route('unsubMails') }}">
                                    <div
                                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa fa-history text-warning text-sm opacity-10"></i>
                                    </div>
                                    <span class="nav-link-text ms-1">Unsuscribe Mails</span>
                                </a>
                            </li>
                            
                            <li  data-toggle="collapse" data-target="#new" class="collapsed  nav-item">
                                <a href="#" class="nav-link {{Route::is('dashboard.colab','loginLogs') ? 'active' : ''}}"> <div
                                  class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                  <i class="fa fa-circle-thin text-warning text-sm opacity-10"></i>
                              </div>
                              <span class="nav-link-text ms-1">Colab</span> <span class="arrow"></span></a>
                            </li>
                            <ul class="sub-menu collapse" id="new">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->segment(2) == 'colab' ? 'active' : '' }}"
                                        href="{{ route('dashboard.colab') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-circle-thin text-warning text-sm opacity-10"></i>

                                        </div>
                                        <span class="nav-link-text ms-1">Colab</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->segment(1) == 'login-logs' ? 'active' : '' }}"
                                        href="{{ route('loginLogs') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-sign-in text-warning text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Login Logs</span>
                                    </a>
                                </li>
                            </ul>
                            <li  data-toggle="collapse" data-target="#settings" class="collapsed  nav-item">
                                <a href="#" class="nav-link {{ Route::is('games','activity.status.index','settings') ? 'active' : '' }}"> <div
                                  class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                  <i class="fa fa-cogs text-warning text-sm opacity-10"></i>
                              </div>
                              <span class="nav-link-text ms-1">Settings</span> <span class="arrow"></span></a>
                            </li>
                            <ul class="sub-menu collapse" id="settings">
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
                                    <a class="nav-link {{ request()->segment(1) == 'activity-status' ? 'active' : '' }}"
                                        href="{{ route('activity.status.index') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-tasks text-warning text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Activity Status</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->segment(2) == 'settings' ? 'active' : '' }}"
                                        href="{{ route('settings') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-cog text-warning text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Settings</span>
                                    </a>
                                </li>
                              {{-- <li>New New 3</li> --}}
                            </ul>
                            @endif
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'cashier')
                            <li  data-toggle="collapse" data-target="#spiner" class="collapsed  nav-item">
                                <a href="#" class="nav-link {{ Route::is('spinner','spinner-winner','gamerGames') ? 'active' : '' }}"> <div
                                  class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                  <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                              </div>
                              <span class="nav-link-text ms-1">Spiner</span> <span class="arrow"></span></a>
                            </li>
                           
                            <ul class="sub-menu collapse" id="spiner">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->segment(2) == 'spinner' ? 'active' : '' }}"
                                        href="{{ route('spinner') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Admin Spinner</span>
                                    </a>
                                </li>
                                 @endif
                            @if (Auth::user()->role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->segment(2) == 'spinner-winner' ? 'active' : '' }}"
                                        href="{{ route('spinner-winner') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Spinner Winner</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->segment(1) == 'gamers-games' ? 'active' : '' }}"
                                        href="{{ route('gamerGames', ['id' => 'all']) }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-trophy text-warning text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Gamers & Players</span>
                                    </a>
                                </li>
                              {{-- <li>New New 3</li> --}}
                            </ul>
                            @endif
                            <li  data-toggle="collapse" data-target="#extra" class="collapsed  nav-item">
                                <a href="#" class="nav-link {{Route::is('logs','clear.go')}}"> <div
                                  class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                  <i class="fa fa-external-link-square text-warning text-sm opacity-10"></i>
                              </div>
                              <span class="nav-link-text ms-1">Extra</span> <span class="arrow"></span></a>
                            </li>
                            <ul class="sub-menu collapse" id="extra">
                                @if (Auth::user()->role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->segment(1) == 'logs' ? 'active' : '' }}"
                                        href="{{ route('logs') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-eye text-warning text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Log Viewer</span>
                                    </a>
                                </li>
                                @endif

                                <li class="nav-item">
                                    <a class="nav-link {{ request()->segment(1) == 'clear' ? 'active' : '' }}"
                                        href="{{ route('clear.go') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="fa fa-graduation-cap text-dark text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Clear</span>
                                    </a>
                                </li>
                                

                            </ul>

                            <!--<li  data-toggle="collapse" class="collapsed  nav-item">-->
                            <!--    <a href="#" class="nav-link {{ Route::is('user.create','user.index') ? 'active' : '' }}"> <div-->
                            <!--      class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">-->
                            <!--      <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>-->
                            <!--  </div>-->
                            <!--  <span class="nav-link-text ms-1">User</span> <span class="arrow"></span></a>-->
                            <!--</li>-->
                        @if(Auth::user()->role == 'admin')
                                <li  data-toggle="collapse" data-target="#user" class="collapsed  nav-item">
                                    <a href="#" class="nav-link {{ Route::is('user.create','user.index') ? 'active' : '' }}"> <div
                                      class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                      <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                  </div>
                                  <span class="nav-link-text ms-1">User</span> <span class="arrow"></span></a>
                                </li>

                                <ul class="sub-menu collapse" id="user">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->segment(2) == 'user.index' ? 'active' : '' }}"
                                            href="{{ route('user.index') }}">
                                            <div
                                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">View Users</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->segment(2) == 'user.create' ? 'active' : '' }}"
                                            href="{{ route('user.create') }}">
                                            <div
                                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">Add New User</span>
                                        </a>
                                    </li>

                                  {{-- <li>New New 3</li> --}}
                                </ul>

                                <li  data-toggle="collapse" data-target="#role" class="collapsed  nav-item">
                                    <a href="#" class="nav-link {{ Route::is('user.create','user.edit','user.index') ? 'active' : '' }}"> <div
                                      class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                      <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                  </div>
                                  <span class="nav-link-text ms-1">Role</span> <span class="arrow"></span></a>
                                </li>

                                <ul class="sub-menu collapse" id="role">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->segment(2) == 'roles.index' ? 'active' : '' }}"
                                            href="{{ route('roles.index') }}">
                                            <div
                                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">View Roles</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->segment(2) == 'roles.create' ? 'active' : '' }}"
                                            href="{{ route('roles.create') }}">
                                            <div
                                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">Add New Role</span>
                                        </a>
                                    </li>

                                  {{-- <li>New New 3</li> --}}
                                </ul>
                                <li  data-toggle="collapse" data-target="#permission" class="collapsed  nav-item">
                                    <a href="#" class="nav-link {{ Route::is('user.create','user.edit','user.index') ? 'active' : '' }}"> <div
                                      class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                      <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                  </div>
                                  <span class="nav-link-text ms-1">Permission</span> <span class="arrow"></span></a>
                                </li>

                                <ul class="sub-menu collapse" id="permission">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->segment(2) == 'permissions.index' ? 'active' : '' }}"
                                            href="{{ route('permissions.index') }}">
                                            <div
                                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">View Roles</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->segment(2) == 'permissions.create' ? 'active' : '' }}"
                                            href="{{ route('permissions.create') }}">
                                            <div
                                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">Add New Role</span>
                                        </a>
                                    </li>

                                  {{-- <li>New New 3</li> --}}
                                </ul>
                                @endif
                                <liclass="nav-item">
                                    <a href="{{ route('missingUser') }}" class="nav-link"> <div
                                      class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                      <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                  </div>
                                  <span class="nav-link-text ms-1">Missing User</span></a>
                                </li>
                                
                                <liclass="nav-item">
                                    <a href="{{ route('admin.coin-address.index') }}" class="nav-link"> <div
                                      class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                      <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                  </div>
                                  <span class="nav-link-text ms-1">Coin Addresses</span></a>
                                </li>
                               <li class="nav-item">
    <a href="{{ route('participants.index') }}" class="nav-link">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-circle text-warning text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Participants</span>
    </a>
</li>

                                
                                
                                <li  data-toggle="collapse" data-target="#bit-coin" class="collapsed  nav-item">
                                    <a href="#" class="nav-link {{ Route::is('user.create','user.edit','user.index') ? 'active' : '' }}"> <div
                                      class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                      <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                  </div>
                                  <span class="nav-link-text ms-1">Bit Coin Setup</span> <span class="arrow"></span></a>
                                </li>

                                <ul class="sub-menu collapse" id="bit-coin">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->segment(2) == 'admin.coin-address.index' ? 'active' : '' }}"
                                            href="{{ route('admin.coin-address.index') }}">
                                            <div
                                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">Wallet Setup</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->segment(2) == 'admin.networks.index' ? 'active' : '' }}"
                                            href="{{ route('admin.networks.index') }}">
                                            <div
                                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="fa fa-circle-o text-warning text-sm opacity-10"></i>
                                            </div>
                                            <span class="nav-link-text ms-1">Network Setup</span>
                                        </a>
                                    </li>
                             {{-- <li>
                              <a href="#">
                              <i class="fa fa-user fa-lg"></i> Profile
                              </a>
                              </li>

                             <li>
                              <a href="#">
                              <i class="fa fa-users fa-lg"></i> Users
                              </a>
                            </li> --}}
                        </ul>
                 </div>
            </div>
            <ul class="navbar-nav">
                 @if (Auth::user()->role == 'admin')
                 <li class="nav-item">
                    <a class="nav-link" href="{{ route('testmassMail') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            
                        </div>
                        <span class="nav-link-text ms-1">Test Bulk Mail</span>
                    </a>
                </li> 
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('noorJanActiveUsers') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            
                        </div>
                        <span class="nav-link-text ms-1">Noor Jan Active Users</span>
                    </a>
                </li> 
                @endif

            </ul>
        </div>
        <div class="count-div p-2 text-center count-div-bottum ">
            <p>Logged in Since : <br> {{ session()->get('log_in_time') ? session()->get('log_in_time') : '' }}</p>
            {{-- <a class="nav-link d-flex justify-content-center" href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <div class="border-radius-md d-flex">
                    <i class="fa fa-power-off text-dark text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Logout</span>
            </a> --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>



    </aside>
    <div class="admin-sidebar-backdrop" id="admin-sidebar-backdrop" aria-hidden="true"></div>
    <main class="main-content admin-main position-relative border-radius-lg ">
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
                <div class="dashboard-header-actions">
                    @if (in_array(strtolower((string) auth()->user()->role), ['admin', 'cashier'], true))
                        <a class="dashboard-chat-link" href="{{ route('admin.chat') }}" title="Open support chat">
                            <i class="fa fa-comments" aria-hidden="true"></i>
                            <span>Chat</span>
                        </a>
                    @endif
                    <a href="javascript:;" class="dashboard-menu-toggle nav-link text-white p-0 d-xl-none" id="iconNavbarSidenav" aria-label="Toggle navigation">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
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
                                © AB Gaming
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>
                                made with by AB Gaming
                                <a class="font-weight-bold" href="{{ url('/') }}">AB Gaming</a>
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

@unless (request()->routeIs('dashboard'))
<script src="{{ asset('public/js/jquery-input-mask-phone-number.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap-tagsinput.min.js') }}"></script>
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
@endunless

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="{{ asset('public/js/core/popper.min.js') }}"></script>
<script src="{{ asset('public/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/newAdmin/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('public/newAdmin/js/plugins/smooth-scrollbar.min.js') }}"></script>
@unless (request()->routeIs('dashboard'))
<script src="{{ asset('public/newAdmin/js/plugins/chartjs.min.js') }}"></script>
@endunless
<!--<script src="{{ asset('public/newAdmin/js/argon-dashboard.min.js') }}"></script>-->

<script src="{{ asset('public/js/editable.js') }}"></script>


{{-- <script src="../../public/js/core/popper.min.js" type="text/javascript"></script>
<script src="../../public/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="../../public/js/plugins/bootstrap-notify.js"></script>
<script src="../../public/js/light-bootstrap-dashboard790f.js" type="text/javascript"></script> --}}
@unless (request()->routeIs('dashboard'))
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endunless

<script src="{{ asset('public/js/demo.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@unless (request()->routeIs('dashboard'))
<script src="{{ asset('public/js/table.js') }}"></script>
@endunless

<script src="{{ asset('public/js/jquery.mCustomScrollbar.js') }}"></script>
@unless (request()->routeIs('dashboard'))
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endunless

@if (isset($activeGame) && $activeGame['image'] != '')
    <script>
        $('.back-image-game').css('background-image', "url('public/uploads/{{ $activeGame['image'] }}')");
        $('body').css('background-image', "url('public/uploads/{{ $activeGame['image'] }}')");
        $('body').css('object-fit', "fill");
    </script>
@else
    <script>
        $('.back-image-game').css('background-color', '#14254f');
    </script>
@endif
@unless (request()->routeIs('dashboard'))
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
@endunless
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
 $(document).ready(function() {
      // Apply Select2 to ALL select elements
      if ($.fn.select2) {
          $('select').select2();
      }

      var $sidebar = $('.admin-sidebar');
      var $backdrop = $('#admin-sidebar-backdrop');

      $('#iconNavbarSidenav').on('click', function(event) {
          event.preventDefault();
          $sidebar.toggleClass('opac');
      });

      $backdrop.on('click', function() {
          $sidebar.addClass('opac');
      });

      // Keep the dropdown arrow and Bootstrap's collapsed state synchronized.
      $sidebar.on('show.bs.collapse', '.sub-menu, #user-details', function() {
          var id = this.id;
          $('[data-target="#' + id + '"]').removeClass('collapsed').attr('aria-expanded', 'true');
      });

      $sidebar.on('hide.bs.collapse', '.sub-menu, #user-details', function() {
          var id = this.id;
          $('[data-target="#' + id + '"]').addClass('collapsed').attr('aria-expanded', 'false');
      });

      // Open the parent dropdown when the current page is inside it.
      $sidebar.find('.sub-menu').each(function() {
          if ($(this).find('.nav-link.active').length) {
              var id = this.id;
              $(this).addClass('show');
              $('[data-target="#' + id + '"]').removeClass('collapsed').attr('aria-expanded', 'true');
          }
      });

      // Prevent href="#" from jumping the page when a dropdown is clicked.
      $sidebar.find('[data-toggle="collapse"] > a[href="#"]').on('click', function(event) {
          event.preventDefault();
      });

      // Close the mobile drawer after navigating to another page.
      $sidebar.find('a:not([href="#"])').on('click', function() {
          if (window.innerWidth <= 1199) {
              $sidebar.addClass('opac');
          }
      });
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
