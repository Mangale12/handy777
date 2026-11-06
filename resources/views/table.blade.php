<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="https://noorgames.net/images/logochangecolor.gif">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Table - Noor Games</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <!-- CSS Files -->
    <link href="../../public/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../public/css/light-bootstrap-dashboard790f.css" rel="stylesheet" />
    <link href="../../public/css/normalize.css" rel="stylesheet" />
    <link href="../../public/css/component.css" rel="stylesheet" />
    <link href="../../public/css/demo.css" rel="stylesheet" />
    <link href="../../public/css/table.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" >
    
 
    @php
        if(isset($activeGame) && !empty($activeGame)){
          $activeGameId = $activeGame['id'];
        }
    @endphp
    </head>

    <body>
    @yield('content')
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
<script src="../../public/js/jquery.stickyheader.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>

<script src="../../public/js/editable.js"></script>

<script src="../../public/js/core/popper.min.js" type="text/javascript"></script>
<script src="../../public/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="../../public/js/plugins/bootstrap-notify.js"></script>
<script src="../../public/js/light-bootstrap-dashboard790f.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="../../public/js/demo.js"></script>
<script src="../../public/js/table.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.jqueryui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.jqueryui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.js"></script> 
@if (session('success'))
    <script>
        toastr.success('{{ session('success') }}');
    </script>
@endif
@if (session('error'))
    @if(is_array(session('error')))
        @foreach(session('error') as $error)
            <script>
            toastr.error(' {{ $error }}');
            </script>
        @endforeach
    @else    
        <script>
            toastr.error(' {{session('error') }}');
        </script>
    @endif
@endif

<script>
// var x = new Date();
//         $('.date-countdown').text(x);
    function display_c(){
        var refresh=2000; // Refresh rate in milli seconds
        mytime=setTimeout('display_ct()',refresh);
    }
    function display_ct() {
         var x = '<?php echo Carbon\Carbon::now().'   ('.config('app.timezone').')' ?>';
        $('.date-countdown').text(x);
        display_c();
    }
    display_ct();
</script>
@yield('script');
</html>
