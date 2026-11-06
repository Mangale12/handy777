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
    <style>
  .hidden{
      display: none;
  }
</style>
<div class="wrapper">
  <div class="">
      <div class="fixed-plugin">
                <div class="dropdown pad"> 
                    <a href="javascript:void(0);" class="export-file">
                      {{-- &nbsp;Export --}}
                        <i class="fa fa-file-export fa-2x color-white"> </i>
                    </a>
                </div>
            </div>
      <!-- End Navbar -->
      <div class="content">
          <div class="container-fluid">
            <div class="row justify-content-center">
              <div class="col-md-12 card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 display-inline-flex">
                      <div class="card col-sm-12 col-md-12 col-lg-2">
                        <div class="card-body">
                        Total Tip : <span class="total-tip">{{$totals['tip']}}</span> 
                        </div>     
                      </div>
                      <div class="card col-sm-12 col-md-12 col-lg-2">
                        <div class="card-body">
                        Total Balance : <span class="total-balance">{{$totals['load']}}</span> 
                        </div>     
                      </div>
                      <div class="card col-sm-12 col-md-12 col-lg-2">
                        <div class="card-body">
                        Total Redeem : <span class="total-redeem">{{$totals['redeem']}}</span> 
                        </div>     
                      </div>
                      <div class="card col-sm-12 col-md-12 col-lg-2">
                        <div class="card-body">
                        Total Refer : <span class="total-refer">{{$totals['refer']}}</span> 
                        </div>     
                      </div>
                      
                      <div class="card col-sm-12 col-md-12 col-lg-2">
                        <div class="card-body">
                        Total Amount : <span class="total-amount">{{$totals['cashAppLoad']}}</span> 
                        </div>     
                      </div>
                      <div class="card col-sm-12 col-md-12 col-lg-2">
                        <div class="card-body">
                        Total Profit : <span class="total-profit">{{$totals['load'] - $totals['redeem']}}</span> 
                        </div>     
                      </div>
                    </div>
                    <div class="col-12 display-inline-flex"  style="margin-bottom: 40px;">
                      <div class="form-control">  
                        <label for="filter-type12">Select Type</label>                   
                       <select id="filter-type12" name="type" id="" class="filter-type12">
                           <option value="all">All</option>
                           <option value="load">Load</option>
                           <option value="redeem">Redeem</option>
                           <option value="refer">Bonus</option>
                           <option value="tip">Tip</option>
                           <option value="cashAppLoad">Cash App</option>
                       </select>
                      </div>
                      <div class="form-control">     
                        <label for="filter-game12">Select Game</label>              
                       <select id="filter-game12" name="game" id="filter-game12" class="filter-game12">
                        <option value="all">All</option>
                         @if (isset($games) && !empty($games))                             
                          @foreach ($games as $key => $item)    
                          <option value="{{$item['id']}}">{{$item['name']}}</option>
                          @endforeach
                         @endif
                       </select>
                      </div>
                      <div class="form-control">     
                        <label for="filter-user12">Select User</label>              
                       <select id="filter-user12" name="user" id="filter-user12" class="filter-user12">
                        <option value="all">All</option>
                         @if (isset($forms) && !empty($forms))                             
                          @foreach ($forms as $key => $item)      
                          <option value="{{$item['id']}}">{{$item['facebook_name']}}</option>
                          @endforeach
                         @endif
                       </select>
                      </div>
                      <div class="form-control"> 
                        <label for="filter-start12">Select Start Date</label>    
                       <input id="filter-start12" type="date" name="start" class="filter-start12">
                      </div>
                      <div class="form-control">   
                        <label for="filter-end12">Select End Date</label>  
                       <input id="filter-end12" type="date" name="end" class="filter-end12">
                      </div>
                      <div class="form-control">   
                       <button class="filter-all-history user-all" data-userId="" data-game="">Go</button>
                      </div>
                  </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <table class="datatable" style="margin-top: 20px;">
                        <thead>
                          <tr>
                            <th class="text-center" style="width:10%;">SN</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">FB Name</th>
                            <th class="text-center">Game</th>
                            <th class="text-center">Game Id</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Type</th>
                            {{-- <th class="text-center">Prev</th>
                            <th class="text-center">Amount</th> --}}
                            <th class="text-center">Created By</th>
                          </tr>
                        </thead>
                        <tbody style="text-align: center!important;" class="user-history-body">                          
                          @php
                            $count = 1;
                          @endphp
                          @foreach ($final as $key => $item)                                
                            <tr>
                              <td class="count-row">{{$count++}}</th>
                              <td class="text-center">{{date('d M,Y H:i:s', strtotime($item['created_at']))}}</td>
                              <td class="text-center">{{$item['form']['facebook_name']}}</td>
                              <td class="text-center">{{$item['account']['name']}}</td>
                              <td class="text-center">{{$item['form_game']['game_id']}}</td>
                              <td class="text-center">{{$item['amount_loaded']}}</td>
                              <td class="text-center">{{(($item['type'] == 'refer')?'bonus':$item['type'])}}</td>
                              <td class="text-center">{{$item['created_by']['name']}}</td>
                            </tr>
                          @endforeach
              
                        </tbody>
                      </table>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
  </div>
</div>
    
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>

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
</html>
