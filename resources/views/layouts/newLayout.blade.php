<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="https://noorgames.net/images/logochangecolor.gif">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Noor Games</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <!-- CSS Files -->
    <link href="{{asset('public/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('public/css/light-bootstrap-dashboard790f.css')}}" rel="stylesheet" />
    <link href="{{asset('public/css/demo.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.jqueryui.css" /> 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.jqueryui.css" /> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <style>
       
    </style>
 

    </head>

    <body>
    <div class="wrapper">
        <div class="sidebar">
            <div class="sidebar-wrapper" style="background: {{isset($color)?$color->color:'purple'}}">
                <div class="logo">
                    <a href="/dashboard" class="simple-text">
                        Noor Games
                    </a>
                </div>
                <ul class="nav">
                    <li class="nav-item {{ (request()->segment(1) == 'dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('dashboard')}}">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item  {{ (request()->segment(1) == 'gamers') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('gamers')}}">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Gamers</p>
                        </a>
                    </li>
                    <li class="nav-item  {{ (request()->segment(1) == 'table') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('table')}}">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Table</p>
                        </a>
                    </li>
                      <li class="nav-item  {{ (request()->segment(1) == 'inactive-players') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('inactive-players',['id'=>7])}}">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Inactive Players</p>
                        </a>
                    </li>
                    
                    <li class="nav-item  {{ (request()->segment(1) == 'games') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('games')}}">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Games</p>
                        </a>
                    </li>
                    <li class="nav-item  {{ (request()->segment(1) == 'gamers-games') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('gamerGames')}}">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Gamers & Games</p>
                        </a>
                    </li>
                    
                    <li class="nav-item  {{ (request()->segment(1) == 'colab') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('dashboard.colab')}}">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Colab</p>
                        </a>
                    </li>
                    {{-- <li>
                        <a class="nav-link" href="user.html">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Colab</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="table.html">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Yesterday</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="typography.html">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Today</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="icons.html">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Tomorrow</p>
                        </a>
                    </li> --}}
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- fixed plugin  -->
            <div class="fixed-plugin">
                <div class="dropdown"> 
                    <a href="#" data-toggle="dropdown">
                        <i class="fa fa-cog fa-2x"> </i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header-title"> Sidebar Style</li>
                        <li class="adjustments-line">
                            <a href="javascript:void(0)" class="switch-trigger background-color">
                                <p>Filters</p>
                                <div class="pull-right">
                                    <span class="badge filter badge-black" data-color="black"></span>
                                    <span class="badge filter badge-azure" data-color="blue"></span>
                                    <span class="badge filter badge-green" data-color="green"></span>
                                    <span class="badge filter badge-orange" data-color="orange"></span>
                                    <span class="badge filter badge-red" data-color="red"></span>
                                    <span class="badge filter badge-purple active" data-color="purple"></span>
                                </div>
                                <div class="clearfix"></div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class=" container-fluid  ">
                    <a class="navbar-brand" href="#pablo"> @yield('title') </a>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('logout')}}">
                                    <span class="no-icon">Log out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="../../public/js/jquery-input-mask-phone-number.min.js"></script>
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


<script src="../../public/js/editable.js"></script>

<script src="../../public/js/core/popper.min.js" type="text/javascript"></script>
<script src="../../public/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="../../public/js/plugins/bootstrap-notify.js"></script>
<script src="../../public/js/light-bootstrap-dashboard790f.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script src="../../public/js/demo.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(function(){
        $('#phone-number').usPhoneFormat({
            format:'xxx-xxx-xxxx'
        });
        $('#summernote').summernote();
    });

</script>
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
    $(document).ready( function () {
        $('.datatable').DataTable({
            pageLength: 100,
            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
            buttons: [
            {
               extend: 'copy',
               className: 'btn-sm btn-info',
               title: 'Gamers',
               header: false,
               footer: true,
               exportOptions: {
                  // columns: ':visible'
               }
            },
            {
               extend: 'csv',
               className: 'btn-sm btn-success',
               title: 'Gamers',
               header: false,
               footer: true,
               exportOptions: {
                  // columns: ':visible'
               }
            },
            {
               extend: 'excel',
               className: 'btn-sm btn-warning',
               title: 'Gamers',
               header: false,
               footer: true,
               exportOptions: {
                  // columns: ':visible',
               }
            },
            {
               extend: 'pdf',
               className: 'btn-sm btn-primary',
               title: 'Gamers',
               pageSize: 'A2',
               header: false,
               footer: true,
               exportOptions: {
                  // columns: ':visible'
               }
            },
            {
               extend: 'print',
               className: 'btn-sm btn-success',
               title: 'Gamers',
               // orientation:'landscape',
               pageSize: 'A2',
               header: true,
               footer: false,
               orientation: 'landscape',
               exportOptions: {
                  // columns: ':visible',
                  stripHtml: false
               }
            }
         ],
        });
    } );
    
</script>
  
<script>
    
    jQuery(document).ready( function () {

        $(".jquery-width").css("width","100%");

        var link = $('.delete-form').attr("href");
        // var link = $('.delete-form');
                $('.datatable tbody').on('click', '.delete-form', function (e) {
            e.preventDefault();
            Swal.fire({
            title: 'Are you sure you want to delete this?',
            showDenyButton: true,
            showCancelButton: true,
            showConfirmButton: false,
            // confirmButtonText: 'Save',
              denyButtonText: `Delete`,
            }).then((result) => {
                if (result.isConfirmed) {
                } 
                else if (result.isDenied) {
                    var cid = $(this).data('id');
                    $.ajax({
                        type: 'get',
                        url: "/gamers/destroy/"+cid,
                        data: {
                            "cid": $(this).data('id'),
                        },
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            $('.tr-'+cid).remove();
                            $( ".count-row" ).each(function( index ) {
                                $(this).text((index+1));
                                // console.log( index + ": " + $( this ).text() );
                            })
                            toastr.success('Success',"Deleted");
                            
                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error('Error',data.responseText);
                        }
                    });
                    // window.location = link;
                }
            });
        });
      
        $('.datatable tbody').on('click', '.edit-form', function () {
            $('.editFormModal').modal('show');
            var cid = $(this).data('id');
                    $.ajax({
                        type: 'get',
                        url: "/accountv2/gamers/edit/"+cid,
                        data: {
                            "cid": $(this).data('id'),
                        },
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
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
                        error: function (data) {
                            console.log(data);
                            toastr.error('Error',data.responseText);
                        }
                    });
        });
       $('table').editableTableWidget();
       
       $('table td').on('change', function(evt, newValue) {
        var type = "POST";
        
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                type: type,
                url: '/saveNoteForm',
                data: {
                    "cid": $(this).data('id'),
                    "note" : newValue
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    toastr.success('Success',"Note Saved");
                    
                },
                error: function (data) {
                    console.log(data);
                    toastr.error('Error',data.responseText);
                }
            });
           });
   
   
   });
</script>
@yield('script');
</html>
