<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- Boostrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://use.fontawesome.com/1e3ce1a999.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->






    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
    .navbar{
        padding:0!important;
    }
        .nav-item{
            padding: 5px;
            transition: 0.5s;
        }
        .nav-item:hover{
                background: #007bfff0;
        }
        .nav-item a:hover {
                color: white!important;
            
        }
        .power-off{
            color: white;
            background: #088d25;
            padding: 6px;
            border-radius: 5px;
            transition: 0.3s;
            cursor: pointer;
          outline: none;
          color: #fff;
  box-shadow: 0 3px #999;
        }
        .power-off:hover{
            background: red;
            color: white;
            padding: 6px;
            border-radius: 5px;
        }
        .power-off:active {
            background: red;
            box-shadow: 0 1px #666;
            transform: translateY(4px);
        }
        .menu-active{
            background: #007bfff0;
        }
        .menu-active a{
            color: white!important;
        }
    </style>
</head>
<body>
    
    @php
    @endphp
    <div id="app" style="overflow-x:hidden">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @guest
                    @else
                        
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {{ (request()->segment(2) == 'colab') ? 'menu-active' : '' }}">
                            <a class="nav-link" href="/home/colab">Show Colab</a>
                        </li>
                        <li class="nav-item {{ (request()->segment(2) == 'yesterday') ? 'menu-active' : '' }}">
                        <a class="nav-link" href="{{ route('yesterday') }}">Show yesterday</a>
                        </li>
                        <li class="nav-item {{ (request()->segment(2) == 'days') ? 'menu-active' : '' }}">
                            <a class="nav-link" href="{{ route('day') }}">Show today</a>
                        </li>
                        <li class="nav-item {{ (request()->segment(2) == 'tommorow') ? 'menu-active' : '' }}">
                            <a class="nav-link" href="{{ route('tommorow') }}">Show Tommorow</a>
                        </li>
                        <li class="nav-item {{ (request()->segment(2) == 'image-upload') ? 'menu-active' : '' }}">
                            <a class="nav-link" href="{{ route('image-upload') }}">Image Upload</a>
                        </li>
                          <li class="nav-item {{ (request()->segment(2) == 'show-image') ? 'menu-active' : '' }}">
                            <a class="nav-link" href="{{ route('show.images') }}">Show Gallery</a>
                        </li>
                         <li class="nav-item {{ (request()->segment(2) == 'show-image') ? 'menu-active' : '' }}">
                            <a class="nav-link" href="{{ route('deleted.players') }}">Deleted Players</a>
                        </li>
                    </ul>
                    @endguest

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else

                        <a  href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                         <i class="fa fa-power-off power-off"></i>
                         <!--{{ __('Logout') }}-->
                     </a>

                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                         @csrf
                     </form>





                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
<script src="../../js/editable.js"></script>
</body>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready( function () {
    $('.datatable').DataTable({
        "pageLength": 100
    });
//      var hash = window.location.hash;
//   var link = $('.delete-form');
//  $('.delete-form').on('click',function(e) {
//      console.log($(this).parent())
//     e.preventDefault();
//      ans = confirm('Are you sure you want to delete this?');
//       if (ans == true) {
//           console.log($(this).parent())
//       } else {
//           return false;
//       }
//     hash = link.attr("href");
//     window.location = hash;
//   });
    
} );
</script>
</html>
