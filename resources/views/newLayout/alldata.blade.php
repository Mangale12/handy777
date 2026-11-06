@extends('newLayout.layouts.newLayout')

@section('title')
     Monthly Data 
@endsection
@section('content')
<style>
  .dataTables_wrapper{
    padding: 25px;
  }
  .dataTables_wrapper .row{
    padding: 10px;
  }
  tbody tr td{
    border-bottom: none;
  }
  .active-game-btn{
   background: #feb343;
  }
</style>
<style>
    
table {
  margin: 1em 0;
  border-collapse: collapse;
  border: 0.1em solid #d6d6d6;
}

caption {
  text-align: left;
  font-style: italic;
  padding: 0.25em 0.5em 0.5em 0.5em;
}

th,
td {
  padding: 0.25em 0.5em 0.25em 1em;
  vertical-align: text-top;
  text-align: left;
  text-indent: -0.5em;
}

th {
  vertical-align: bottom;
  background-color: #666;
  color: #fff;
}

tr:nth-child(even) th[scope=row] {
  background-color: #f2f2f2;
}

tr:nth-child(odd) th[scope=row] {
  background-color: #fff;
}

tr:nth-child(even) {
  background-color: rgba(0, 0, 0, 0.05);
}

tr:nth-child(odd) {
  background-color: rgba(255, 255, 255, 0.05);
}



.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.7);
  transition: opacity 500ms;
  visibility: hidden;
  opacity: 0;
  z-index: 9999;
}
.overlay:target {
  visibility: visible;
  opacity: 1;
}


.popup {
  margin: 70px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 50% ;
  position: relative;
  transition: all 5s ease-in-out;
 
  

}

.popup h2 {
  margin-top: 0;
  color: #333;
  font-family: Tahoma, Arial, sans-serif;

}
.popup .close {
  position: absolute;
  top: 20px;
  right: 30px;
  transition: all 200ms;
  font-size: 30px;
  font-weight: bold;
  text-decoration: none;
  color: #333;

}
.popup .close:hover {
  color: #FF9800;
}
.popup .content {
  max-height: calc(100vh - 210px);
    overflow-y: auto;
}

@media screen and (max-width: 700px){
  .box{
    width: 70%;
  }
  .popup{
    width: 70%;
  }
}


#timedate {
  font: small-caps lighter auto/150% "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
  text-align:left;
 
  margin: 40px auto;
  color:#fff;
  padding: 20px ;
}




.dropdown {
  position: relative;
  display: inline-block;
}



.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
 
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
  display: block;
  left: 0px;
  top: 0px;
  position: absolute;
  margin: 0rem 0rem -4rem  -4rem;
  
}


   .hidden{
   display: none;
   }
   .game-head-btn-div a:hover{
       background: #fdb244;
   }
   .active-game-btn .card{
       background: #fdb244;
   }

   .breadcrumb-div{
      background: #5e5050cc;
    padding: 5px;
   }

   .game-popup.game-categories-wrapper {
      border: 2px solid #e0e0e0;
      padding: 5px;
      margin: 5px;
   }
   .active-game-btn {
       background: #feb343 !important;
   }
</style>
@if (Auth::user()->role == 'admin')
<div class="row">
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
     <div class="card">
        <div class="card-body p-3">
           <div class="row">
              <div class="col-8">
                 <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Balance</p>
                    <h5 class="font-weight-bolder total-balance">
                      ${{$total['load']}}
                    </h5>
                 </div>
              </div>
              <div class="col-4 text-end">
                 <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
     <div class="card">
        <div class="card-body p-3">
           <div class="row">
              <div class="col-8">
                 <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Tip</p>
                    <h5 class="font-weight-bolder total-tip">
                      ${{$total['tip']}}
                    </h5>
                 </div>
              </div>
              <div class="col-4 text-end">
                 <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
     <div class="card">
        <div class="card-body p-3">
           <div class="row">
              <div class="col-8">
                 <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Redeem</p>
                    <h5 class="font-weight-bolder total-redeem">
                      +{{$total['redeem']}}
                    </h5>
                 </div>
              </div>
              <div class="col-4 text-end">
                 <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
           <div class="row">
              <div class="col-8">
                 <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Refer </p>
                    <h5 class="font-weight-bolder total-refer">
                      ${{$total['refer']}}
                    </h5>
                 </div>
              </div>
              <div class="col-4 text-end">
                 <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                 </div>
              </div>
           </div>
        </div>
        </div>
  </div>
</div>
   

    <div class="row" style="padding-top:40px;">
  <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
     <div class="card">
        <div class="card-body p-3">
           <div class="row">
              <div class="col-8">
                 <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Profit</p>
                    <h5 class="font-weight-bolder total-profit">
                      ${{$total['load'] - $total['redeem']}}
                    </h5>
                 </div>
              </div>
              <div class="col-4 text-end">
                 <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                 </div>
              </div>
           </div>
        </div>
     </div>
     
  </div>
</div>
    @endif
<div class="row justify-content-center mt-5">
   <div class="col-md-12 card upCard">
      <div class="card-body">
         <div class="row">
            {{-- @php
            echo $month;
                           @endphp --}}
                     @foreach($all_months as $m => $i) 
               <div class="col-2 game-head-btn-div">  
                  {{-- @if (isset($games) && !empty($games)) --}}
                  @if($month < 13)
                     @php
                        $z = str_replace('0','',$month);
                     @endphp
                  @endif
                  @if($z == $m)
                     @php
                        $current_month = $i;
                     @endphp
                  @endif
                        <a href="{{'/monthly-history?year='.$year.'&month='.$m.($sel_cat ? '&category='.$sel_cat : '')}}" class="btn btn-success w-100 mb-1 {{($z == $m)?'active-game-btn':''}}"
                           >
                        {{$i}}
                        </a>
            </div>
                     @endforeach
         </div>
      </div>
   </div>
</div>
<div class="row justify-content-center mt-5">
   <div class="col-md-12 card upCard">
      <div class="card-body">
         <div class="row">
            <div class="col-2 game-head-btn-div">  
               <a href="{{ route('monthlyHistory').'?year='.$year.'&month='.$z}}" class="btn btn-success w-100 mb-1 {{($sel_cat == '')?'active-game-btn':''}}" class="btn btn-success w-100 mb-1">
                  All
               </a>
            </div>
            @foreach($game_categories as $gc => $c) 
            <div class="col-2 game-head-btn-div">  
               <a href="{{ route('monthlyHistory').'?year='.$year.'&month='.$z.'&category='.$c->name}}" class="btn btn-success w-100 mb-1 {{($c->name == $sel_cat)?'active-game-btn':''}}" class="btn btn-success w-100 mb-1">
                  {{$c->name}}
               </a>
            </div>
            @endforeach
         </div>
      </div>
   </div>
</div>
<div class="row" id="werqwerq" style="padding-top:20px;">
   <div class="col-12">
      <div class="card mb-4">
         <div class="card-body px-0 pt-0 pb-2">
            <div class="row d-flex">
               <button  class="btn  btn-primary mb-0" style="background-color:#FF9800;"  > <a href="#popup3" style="color:white;">Add History</a></button>
               <div id="popup3" class="overlay" style="z-index: 9;">
                  <div class="popup">
                     <h2>Add History</h2>
                     <a class="close" href="#">&times;</a>
                     <div class="content ">
                        <form action="{{route('addHistory')}}" method="post">
                           @csrf
                        <div class="row">
                           <div class="form-group col-md-6">
                             <label for="cars">User: Full Name [ Game Id ]</label>
                              <select name="id" id="form-game-change" class="select2Custom form-control" required>
                                 @if (isset($form_games) && !empty($form_games))
                                    @foreach($form_games as $a => $num)
                                       <option value="{{$num['form_id']}}" data-id="{{$num['account_id']}}">{{$num['form']['full_name']}}  [{{!empty($num['game_id'])?$num['game_id']:''}}]</option>
                                    @endforeach
                                 @else
                                    <option disabled>No Users</option>
                                 @endif
                              </select>
                           </div>
                           <div class="form-group col-md-6">
                              <label for="amount_loaded">Amount</label>
                              <input type="number" name="amount_loaded" placeholder="Amount" class="form-control" required>
                           </div>
                           <div class="form-group col-md-6">
                              <label for="date">Date</label>
                              <input type="date" name="date" placeholder="Date" id="datefield" class="form-control" required>
                              <script>
                                 var today = new Date();
                                 var dd = today.getDate();
                                 var mm = today.getMonth() + 1; //January is 0!
                                 var yyyy = today.getFullYear();

                                 if (dd < 10) {
                                    dd = '0' + dd;
                                 }

                                 if (mm < 10) {
                                    mm = '0' + mm;
                                 } 
                                    
                                 today = yyyy + '-' + mm + '-' + dd;
                                 document.getElementById("datefield").setAttribute("max", today);
                              </script>
                           </div>
                           <div class="form-group col-md-6">
                              <label for="type">Select Game</label>
                              <select name="account" id="game-id-monthly" class="form-control" required>
                                 @if (isset($games) && !empty($games))
                                    @foreach($games as $a => $num)
                                       <option class="game-id-option" value="{{$num['id']}}">{{$num['name']}}</option>
                                    @endforeach
                                 @else
                                    <option disabled>No Users</option>
                                 @endif
                              </select>
                           </div>
                           <div class="form-group col-md-6">
                              <label for="type">Select Type</label>
                              <select name="type" id="type" class="form-control" required>
                                 <option value="load">Load</option>
                                 <option value="redeem">Redeem</option>
                                 <option value="refer">Bonus</option>
                                 <option value="tip">Tip</option>
                              </select>
                           </div>
                           <button type="submit"  class="btn  btn-primary mb-0" style="background-color:#FF9800;"  >ADD</button>
                     
                        </div>
                     </form>
                       </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
  <div class="col-12">
     <div class="card mb-4">
        <div class="card-body px-0 pt-0 pb-2">
           <div class="table-responsive p-0">
              <table class="table align-items-center mb-0 datatable">
                 <thead class="sticky" >
                    <tr  >
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Day</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Total</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Profit/Loss</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Tip</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Balance</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Redeem</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Bonus</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Actions</th>
                    </tr>
                 </thead>
                 <tbody>                          
                  @php
                    $count = 1;
                  @endphp
                  @foreach ($grouped as $key => $item)   
                    <tr >
                       <td class="align-middle text-center" style="text-align: center">
                           {{$current_month.' ,'.$key}}
                       </td>
                       <td class="align-middle text-center">
                           <span class="badge  bg-gradient-success">{{$item['count']}}</span>
                       </td>
                       <td class="align-middle text-center">
                           <span class="badge  bg-gradient-{{($item['load'] - $item['redeem']) >= 0 ? 'success' : 'warning'}}">{{($item['load'] - $item['redeem']) < 0 ? '-' : ''}}${{abs($item['load'] - $item['redeem'])}}</span>
                       </td>
                       <td class="align-middle text-center">
                           <span class="badge  bg-gradient-success">{{$item['tip']}}</span>
                       </td>
                       <td class="align-middle text-center">
                           <span class="badge  bg-gradient-success">{{$item['load']}}</span>
                       </td>
                       <td class="align-middle text-center">
                           <span class="badge  bg-gradient-success">{{$item['redeem']}}</span>
                       </td>
                       <td class="align-middle text-center">
                          <span class="badge  bg-gradient-success">{{$item['refer']}}</span>
                       </td>
                       <td class="align-middle text-center">
                        <a href="#popup1" class="this-day-history btn btn-primary" data-year="{{$year}}" data-month="{{$month}}" data-day="{{$key}}" data-category="{{$sel_cat ? $sel_cat : 'all'}}" href="javascript:void(0);">
                           View
                        </a>
                           <div id="popup1" class="overlay">
                              <div class="popup" style="width:95%">
                                 <h2 class="popup-title">History</h2>
                                 <a class="close" href="#">&times;</a>
                                 <div class="content ">
                                    <div class="row" style="padding-top:20px;">
                                       <div class="col-12">
                                          <div class="card mb-4">
                                             <div class="card-header pb-0">
                                                <div class="row w-100" style="justify-content: space-around;">
                                                {{-- <h6>Authors table</h6> --}}
                                                @foreach($game_categories as $gc => $c) 
                                                <div class="col-lg-2 col-md-6 game-popup game-categories-wrapper">
                                                    <button class="btn btn-success history-type-change-btn-allDate game-category {{$c->name == $sel_cat ? 'active-game-btn': ''}}" data-year="{{$year}}" data-month="{{$month}}" data-day="" data-type="all" data-category="{{$c->name}}">{{$c->name}}</button>
                                                    <div class="game-category-info reset-to-blank"></div>
                                                </div>
                                                @endforeach
                                                </div>
                                                <div class="row w-100" style="justify-content: space-around;">
                                                   <div class="col-lg-2 md-6">
                                                      <button class="btn btn-success history-type-change-btn-allDate game-type active-game-btn" data-year="{{$year}}" data-month="{{$month}}" data-day="" data-type="all" data-category="{{$sel_cat ? $sel_cat : 'all'}}">All</button>
                                                   </div>
                                                   <div class="col-2">
                                                      <button class="btn btn-success history-type-change-btn-allDate game-type" data-year="{{$year}}" data-month="{{$month}}" data-day="" data-type="load" data-category="{{$sel_cat ? $sel_cat : 'all'}}">Load</button>
                                                   </div>
                                                   <div class="col-2">
                                                      <button class="btn btn-success history-type-change-btn-allDate game-type" data-year="{{$year}}" data-month="{{$month}}" data-day="" data-type="redeem" data-category="{{$sel_cat ? $sel_cat : 'all'}}">Redeem</button>
                                                   </div>
                                                   <div class="col-2">
                                                      <button class="btn btn-success history-type-change-btn-allDate game-type" data-year="{{$year}}" data-month="{{$month}}" data-day="" data-type="refer" data-category="{{$sel_cat ? $sel_cat : 'all'}}">Bonus</button>
                                                   </div>
                                                   <div class="col-2">
                                                      <button class="btn btn-success history-type-change-btn-allDate game-type" data-year="{{$year}}" data-month="{{$month}}" data-day="" data-type="tip" data-category="{{$sel_cat ? $sel_cat : 'all'}}">Tip</button>
                                                   </div>
                                                </div>
                                                <input type="hidden" name="type" class="user-current-game-history-input">
                                             </div> 
                                             <div class="card-body px-0 pt-0 pb-2">
                                              {{-- <div class="row display-inline-flex"> --}}
                                                 {{-- <div class="col-4">   
                                                    <input type="date" name="start" class="filter-start">
                                                 </div>
                                                 <div class="col-4">   
                                                    <input type="date" name="end" class="filter-end">
                                                 </div> --}}
                                                 {{-- <div class="col-4">    --}}
                                                    <button class="filter-history btn btn-primary hidden" data-userId="" data-game="">Go</button>
                                                 {{-- </div> --}}
                                              {{-- </div> --}}
                                                <div class="table-responsive p-0">
                                                   <table class="table align-items-center mb-0">
                                                      <thead class="sticky" >
                                                         <tr  >
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time</th>
                                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FB Name</th>
                                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Profit / Loss</th>
                                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Game</th>
                                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Game ID</th>
                                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Creator</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody  class="user-history-body">
                                                         
                                                      </tbody>
                                                   </table>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div >
                             </div >
                              </div >
                          {{-- <button class="btn btn-primary">View</button> --}}
                       </td>
                    </tr>
                  @endforeach
                 </tbody>
              </table>
           </div>
        </div>
     </div>
  </div>
</div>
@endsection

@section('script')
<script>
   setTimeout(() => {
       $('.select2Custom').select2({            
           dropdownParent: $('#popup3')
       });
   }, 1000);
   
</script>
@endsection

