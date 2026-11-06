@extends('newLayout.layouts.newLayout')

@section('title')
     Game Data
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
</style>
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
                  @if($month < 10)
                     @php
                        $z = str_replace('0','',$month);
                     @endphp
                  @endif
                  @if($z == $m)
                     @php
                        $current_month = $i;
                     @endphp
                  @endif
                        <a href="{{'/game-data?year='.$year.'&month='.$m}}" class="btn btn-success w-100 mb-1 {{($z == $m)?'active-game-btn':''}}"
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
             @foreach($grouped as $m => $i) 
               <div class="col-2 game-head-btn-div">
                  @if($month == $m)
                      @if($month < 10)
                        @php
                           // $z = str_replace('0','',$month);
                        @endphp
                     @endif
                     @php
                        $current_month = $all_months[$z];
                     @endphp
                  @endif
                        <a href="{{'/game-data?year='.$year.'&month='.$month.'&day='.$m}}" class="btn btn-success w-100 mb-1 {{($day == $m)?'active-game-btn':''}}"
                           >
                           {{$current_month.' '.$m}}
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
           <div class="table-responsive p-0">
              
            <table class="table align-items-center mb-0 datatable">
               <thead class="sticky" >
                  <tr  >
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">SN</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Histories</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Game Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Game Title</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Game Balance</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Tip</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Load</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Redeem</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Bonus</th>
                  </tr>
               </thead>
               <tbody>                          
                @php
                  $count = 1;
                @endphp
                @if (isset($grouped[$day]) && !empty($grouped[$day]))
                  @foreach ($grouped[$day] as $key => $item)   
                     <tr >
                        <td class="align-middle text-center" style="text-align: center">
                           {{$count++}}
                        </td>
                        
                        <td class="align-middle text-center">
                           <a href="#popup1" class="this-day-game-history btn btn-primary" data-year="{{$year}}" data-month="{{$month}}" data-day="{{$day}}" data-game="{{$item['game_id']}}" href="javascript:void(0);">
                              View
                           </a>
                              <div id="popup1" class="overlay">
                                 <div class="popup">
                                    <h2>{{$item['game_name']}} History</h2>
                                    <a class="close" href="#">&times;</a>
                                    <div class="content ">
                                       <div class="row" style="padding-top:20px;">
                                          <div class="col-12">
                                             <div class="card mb-4">
                                                {{-- <div class="card-header pb-0">
                                                   <div class="row w-100" style="justify-content: space-around;">
                                                      <div class="col-2">
                                                         <button class="btn btn-success history-type-change-btn-allDate" data-year="{{$year}}" data-month="{{$month}}" data-day="" data-type="all">All</button>
                                                      </div>
                                                      <div class="col-2">
                                                         <button class="btn btn-success history-type-change-btn-allDate" data-year="{{$year}}" data-month="{{$month}}" data-day="" data-type="load">Load</button>
                                                      </div>
                                                      <div class="col-2">
                                                         <button class="btn btn-success history-type-change-btn-allDate" data-year="{{$year}}" data-month="{{$month}}" data-day="" data-type="redeem">Redeem</button>
                                                      </div>
                                                      <div class="col-2">
                                                         <button class="btn btn-success history-type-change-btn-allDate" data-year="{{$year}}" data-month="{{$month}}" data-day="" data-type="refer">Bonus</button>
                                                      </div>
                                                      <div class="col-2">
                                                         <button class="btn btn-success history-type-change-btn-allDate" data-year="{{$year}}" data-month="{{$month}}" data-day="" data-type="tip">Tip</button>
                                                      </div>
                                                   </div>
                                                   <input type="hidden" name="type" class="user-current-game-history-input">
                                                </div>  --}}
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
                                                               <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                                               <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amoount</th>
                                                               <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                                                               <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created by</th>
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
                        <td class="align-middle text-center" style="text-align: center">
                           {{$item['game_name']}}
                        </td>
                        <td class="align-middle text-center" style="text-align: center">
                           {{$item['game_title']}}
                        </td>
                        <td class="align-middle text-center" style="text-align: center">
                           {{$item['game_balance']}}
                        </td>
                        <td class="align-middle text-center">
                           <span class="badge  bg-gradient-success">{{$item['totals']['tip']}}</span>
                        </td>
                        <td class="align-middle text-center">
                           <span class="badge  bg-gradient-success">{{$item['totals']['load']}}</span>
                        </td>
                        <td class="align-middle text-center">
                           <span class="badge  bg-gradient-success">{{$item['totals']['redeem']}}</span>
                        </td>
                        <td class="align-middle text-center">
                           <span class="badge  bg-gradient-success">{{$item['totals']['refer']}}</span>
                        </td>
                     </tr>
                  @endforeach
                @else
                   {{-- No data --}}
                @endif
               </tbody>
            </table>
           </div>
        </div>
     </div>
  </div>
</div>
@endsection

