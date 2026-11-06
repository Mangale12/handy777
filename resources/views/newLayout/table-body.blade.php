@extends('newLayout.layouts.newLayout')

@section('content')
<style>
   .hidden{
   display: none;
   }
   body{
      background-image: url('{{asset('public/uploads/'.$activeGame['image'])}}');
      background-size: cover;
   }
</style>
<div class="wrapper">
   <div class="main-panel1">
      <!-- End Navbar -->
      <div class="content">
         <div class="container-fluid">
            <div class="row justify-content-center">
               <div class="col-md-12 card upCard">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-4" style="text-align: center">
                           <!-- <img src="{{asset('images/logochangecolor.gif')}}" alt="" class="thumbnail"> -->
                           <p  class="text-white">Welcome<br>{{ucwords(Auth::user()->name)}}</p>
                           @if ($activeGame['image'] != '')
                           <img style="max-width: 50%" src="{{asset('/public/uploads/'.$activeGame['image'])}}" alt="{{($activeGame['name'])}}">

                           @endif

                           <p  class="glow">Noor Games</p>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-8">
                           <div class="col-12 header-div">
                              <div class="row">
                                 <div class="col-sm-12 col-md-12 col-lg-5">
                                    <h2 class="margin-0 header-games glow">Games</h2>
                                    <a href="{{route('all-history1')}}" class="btn btn-success">All history</a>
                                    {{-- <button class="btn btn-warning all-history" type="button" style="float: left">
                                    All History
                                    </button> --}}
                                 </div>
                                 <div class="col-sm-12 col-md-12 col-lg-7" style="text-align: right;">
                                    <div class="dropdown">
                                       <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       History
                                       </button>
                                       <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                          <a class="dropdown-item history-btn" href="javascript:void(0);"><span class="ml-2"><i class="fa fa-scroll"></i></span>&nbspBalance Load</a>
                                          <a class="dropdown-item redeem-history" href="javascript:void(0);"><i class="fa fa-scroll"></i></span>&nbspRedeems</a>
                                          <a class="dropdown-item refer-history" href="javascript:void(0);"><i class="fa fa-scroll"></i></span>&nbspBonus</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12 game-head-btn-div">  
                              @if (isset($games) && !empty($games))
                                 @foreach($games as $game)    
                                    @php
                                    $query = $_GET;
                                    $query['game'] = $game['title'];
                                    $query_result = http_build_query($query);
                                    @endphp    
                                    <a class="btn btn-success mb-1 game-btn {{(str_replace(' ','-',$game['title']))}}-{{($game['id'])}} {{(isset($activeGame) && $activeGame['id'] == $game['id'])?'active-game-btn':''}}" 
                                       href="{{url('/table?').$query_result}}"
                                       data-title="{{($game['title'])}}" 
                                       data-balance="{{($game['balance'])}}"
                                       >
                                    {{$game['title']}} : {{($game['balance'])}}
                                    </a>
                                 @endforeach                                
                              @else
                                 No games available
                              @endif 
                           </div>
                           <div class="col-12 game-head-search-div" style="display: flex;">
                              <div class="col-sm-12 col-md-12 col-lg-6 hidden">
                                 <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle cash-app-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"                                
                                       data-id="{{($activeCashApp['id'])}}" 
                                       data-title="{{($activeCashApp['title'])}}" 
                                       data-balance="{{($activeCashApp['balance'])}}"
                                       >
                                    Cash App Account : {{(isset($activeCashApp) && !empty($activeCashApp))?$activeCashApp['title']:''}} : <span class="cash-app-blnc">{{(isset($activeCashApp) && !empty($activeCashApp))?('$ '.$activeCashApp['balance']):''}}</span> 
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                       @if (isset($cashApp) && !empty($cashApp))
                                       @foreach ($cashApp as $item)
                                       @php
                                       $query = $_GET;
                                       $query['cash_app'] = $item['title'];
                                       $query_result = http_build_query($query);
                                       @endphp
                                       <a class="dropdown-item" href="{{url('/table?').$query_result}}">{{$item['title']}} : $ {{$item['balance']}}</a>                                          
                                       @endforeach                                    
                                       @endif
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-12 col-md-12 col-lg-6">
                                 <p class="date-countdown" style="background: white;"></p>
                              </div> 
                              <div class="col-sm-12 col-md-12 col-lg-6">
                                 <button class="btn btn-primary add-user" data-toggle="modal" data-target="#exampleModalCenter2">Add User</button> 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-12">
                  <div class="col-6">
                     <button type="button" class="btn btn-success">Total Players : {{count($activeGame['form_games'])}}</button>
                     <button type="button" class="btn btn-primary undo-transaction" style="background:#3a3131">Undo Transaction</button>
                     {{-- <button type="button" class="btn btn-primary undo-player">Undo Player</button> --}}
                  </div>
                  <div class="col-6 float-right" style="margin-bottom: 10px;text-align:right;">
                     <label for="search-user">Search User : </label>
                     <input type="text" style="float: right" class="search-user" id="search-user" placeholder="Search User">
                  </div>
               </div>
               <div class="col-md-12 card">
                  <div class="row justify-content-between">
                     <div class="" style="overflow-x:auto;">
                        <table  class="">
                           <thead>
                              <tr>
                                 <th width="10">SN</th>
                                 <th>Game Id</th>
                                 <th class="text-center">FB Name</th>
                                 {{-- <th class="text-center">Amount</th> --}}
                                 <th class="text-center">Balance</th>
                                 <th class="text-center">Bonus</th>
                                 <th class="text-center">Redeem</th>
                                 <th class="text-center">Tips</th>
                                 <th class="text-center">Action</th>
                                 <th class="text-center">History</th>
                              </tr>
                           </thead>
                           <tbody style="text-align: center!important;">
                              @if (isset($activeGame))
                                 @if (!empty($activeGame) && !empty($activeGame['form_games']))
                                    @php
                                       $count = 1;
                                    @endphp
                                    @foreach($activeGame['form_games'] as $a => $num)
                                    <tr id="form-games-div-{{$a+1}}">
                                       {{-- Game Id --}}
                                       <th class="count-row">
                                          {{$count++}}
                                       </th>
                                       <th>
                                          {{($num['game_id'])}}
                                          <a class="user-full-history" href="javascript:void(0);" data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}">
                                          <span class="ml-2"><i class="fa fa-scroll"></i></span>
                                          </a>
                                       </th>
                                       {{-- Amount --}}
                                       <td>
                                          <a class="form-full-history" href="javascript:void(0);" data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}">
                                          {{(isset($num['form']['facebook_name']) && !empty($num['form']['facebook_name']))?$num['form']['facebook_name']:'Empty'}}
                                          </a>
                                       </td>
                                       {{-- Amount --}}
                                       <td class="text-center hidden">
                                          <button class="btn btn-primary amountBtn user-cashapp-{{($num['game_id'])}} resetThis" type="button" data-toggle="collapse" data-target="#collapseExampleCashApp-{{$a+1}}" aria-expanded="false" aria-controls="collapseExampleCashApp-{{$a+1}}"
                                             data-id="{{($num['form']['id'])}}" 
                                             data-parent="{{'#form-games-div-'.($a+1)}}" 
                                             data-user="{{($num['game_id'])}}" 
                                             data-balance="{{(isset($num['cash_app']) && !empty($num['cash_app']))?$num['cash_app']:'0'}}">
                                          $ {{(isset($num['cash_app']) && !empty($num['cash_app']))?$num['cash_app']:'0'}}
                                          </button>
                                          <div class="collapse-{{$a+1}} collapse" id="collapseExampleCashApp-{{$a+1}}">
                                             <div class="card card-body">
                                                <input required type="hidden" class="form-control cashApp-from" name="cashApp-from"
                                                   value="{{$activeGame['id']}}" data-title="{{str_replace(' ','-',$activeGame['title'])}}">
                                                <input required type="text" class="form-control amount" name="amount"
                                                   data-user="{{$num['game_id']}}"  
                                                   data-cashApp="{{$activeCashApp['id']}}"
                                                   data-userId="{{$num['form']['id']}}"
                                                   value="" placeholder="Amount">
                                                <button type="button" class="btn btn-success text-center cashApp-btn" 
                                                   data-user="{{$num['game_id']}}"  
                                                   data-cashApp="{{$activeCashApp['id']}}"
                                                   data-userId="{{$num['form']['id']}}">
                                                Load
                                                </button>
                                             </div>
                                          </div>
                                       </td>
                                       {{-- Balance --}}
                                       <td class="text-center">
                                          <button class="btn btn-primary user-{{($num['game_id'])}} resetThis" type="button" data-toggle="collapse" data-target="#collapseExample-{{$a+1}}" aria-expanded="false" aria-controls="collapseExample-{{$a+1}}"
                                             data-id="{{($num['form']['id'])}}" 
                                             data-parent="{{'#form-games-div-'.($a+1)}}" 
                                             data-user="{{$num['game_id']}}" 
                                             data-userId="{{$num['form']['id']}}"
                                             data-gameId="{{$activeGame['id']}}"
                                             data-balance="{{($num['balance'])}}"
                                             data-type="load">
                                          $ {{($num['balance'])}}
                                          </button>
                                          <div class="collapse-{{$a+1}} collapse" data-userId="{{$num['form']['id']}}" id="collapseExample-{{$a+1}}">
                                             <div class="card card-body">
                                                <input required type="hidden" class="form-control load-from loadFrom{{$num['form']['id']}}" name="load-from"
                                                   value="{{$activeGame['id']}}" data-title="{{str_replace(' ','-',$activeGame['title'])}}">
                                                <input required type="text" class="form-control loadInput loadInput{{$num['form']['id']}}" name="amount"
                                                   data-user="{{$num['game_id']}}" 
                                                   data-userId="{{$num['form']['id']}}"
                                                   value="" placeholder="Amount">
                                                <button type="button" class="btn btn-success text-center hidden load-btn" 
                                                   data-user="{{$num['game_id']}}" 
                                                   data-userId="{{$num['form']['id']}}">Load</button>
                                             </div>
                                          </div>
                                       </td>
                                       {{-- Refer --}}
                                       <td class="text-center">
                                          {{-- @php                                              
                                          $total = 0;
                                          @endphp
                                          @if (!empty($num['form']['tips']))
                                          @foreach ($num['form']['tips'] as $item)
                                          @php
                                          $total = $total + $item['amount'];                                                    
                                          @endphp
                                          @endforeach                                             
                                          @endif --}}
                                          <button class="btn btn-primary user-refer-{{($num['game_id'])}} resetThis" type="button" data-toggle="collapse" data-target="#collapseExampleRefer-{{$a+1}}" aria-expanded="false" aria-controls="collapseExampleRefer-{{$a+1}}"
                                             data-id="{{($num['form']['id'])}}" 
                                             data-parent="{{'#form-games-div-'.($a+1)}}" 
                                             data-user="{{($num['game_id'])}}" 
                                             data-userId="{{$num['form']['id']}}"
                                             data-gameId="{{$activeGame['id']}}"
                                             data-balance="{{($num['refer'])}}"
                                             data-type="refer">
                                          $ {{$num['refer']}}   
                                          </button>
                                          <div class="collapse-{{$a+1}} collapse" id="collapseExampleRefer-{{$a+1}}">
                                             <div class="card card-body">
                                                <input required type="hidden" class="form-control refer-from" name="refer-from"
                                                   value="{{$activeGame['id']}}" data-title="{{str_replace(' ','-',$activeGame['title'])}}">
                                                <input required type="text" class="form-control referInput referInput{{$num['form']['id']}}" name="amount"
                                                   data-user="{{$num['game_id']}}" 
                                                   data-userId="{{$num['form']['id']}}"
                                                   value="" placeholder="Amount">
                                                <button type="button" class="btn btn-success text-center refer-btn hidden" 
                                                   data-user="{{$num['game_id']}}" 
                                                   data-userId="{{$num['form']['id']}}">Load</button>
                                             </div>
                                          </div>
                                       </td>
                                       {{-- Redeem --}}                                         
                                       <td class="text-center">
                                          <button class="btn btn-primary user-redeem-{{($num['game_id'])}} resetThis" type="button" data-toggle="collapse" data-target="#collapseExampleRedeem-{{$a+1}}" aria-expanded="false" aria-controls="collapseExampleRedeem-{{$a+1}}"
                                             data-id="{{($num['form']['id'])}}" 
                                             data-parent="{{'#form-games-div-'.($a+1)}}" 
                                             data-user="{{$num['game_id']}}" 
                                             data-userId="{{$num['form']['id']}}"
                                             data-gameId="{{$activeGame['id']}}"
                                             data-balance="{{($num['redeem'])}}"
                                             data-type="redeem">
                                          $ {{($num['redeem'])}}
                                          </button>
                                          <div class="collapse-{{$a+1}} collapse" id="collapseExampleRedeem-{{$a+1}}">
                                             <div class="card card-body">
                                                <input required type="hidden" class="form-control redeem-from redeemFrom{{$num['form']['id']}}" name="redeem-from"
                                                   value="{{$activeGame['id']}}" data-title="{{str_replace(' ','-',$activeGame['title'])}}">
                                                <input required type="text" class="form-control redeemInput redeemInput{{$num['form']['id']}}" name="amount"
                                                   data-user="{{$num['game_id']}}" 
                                                   data-userId="{{$num['form']['id']}}"
                                                   value="" placeholder="Amount">
                                                <button type="button" class="btn btn-success text-center redeem-btn hidden" 
                                                   data-user="{{$num['game_id']}}" 
                                                   data-userId="{{$num['form']['id']}}">Redeem</button>
                                             </div>
                                          </div>
                                       </td>
                                       {{-- Tips --}} 
                                       <td class="text-center">
                                          <button class="btn btn-primary user-tip-{{($num['game_id'])}} resetThis" type="button" data-toggle="collapse" data-target="#collapseExampleTip-{{$a+1}}" aria-expanded="false" aria-controls="collapseExampleTip-{{$a+1}}"
                                             data-id="{{($num['form']['id'])}}" 
                                             data-parent="{{'#form-games-div-'.($a+1)}}" 
                                             data-user="{{$num['game_id']}}" 
                                             data-userId="{{$num['form']['id']}}"
                                             data-gameId="{{$activeGame['id']}}"
                                             data-balance="{{($num['tip'])}}"
                                             data-type="tip">
                                          $ {{$num['tip']}}
                                          </button>
                                          <div class="collapse-{{$a+1}} collapse" id="collapseExampleTip-{{$a+1}}">
                                             <div class="card card-body">
                                                <input required type="hidden" class="form-control tip-from" name="tip-from"
                                                   value="{{$activeGame['id']}}" data-title="{{str_replace(' ','-',$activeGame['title'])}}">
                                                <input required type="text" class="form-control tipInput tipInput{{$num['form']['id']}}" name="amount"
                                                   data-user="{{$num['game_id']}}" 
                                                   data-userId="{{$num['form']['id']}}"
                                                   value="" placeholder="Amount">
                                                <button type="button" class="btn btn-success text-center tip-btn hidden" 
                                                   data-user="{{$num['game_id']}}" 
                                                   data-userId="{{$num['form']['id']}}">Tip</button>
                                             </div>
                                          </div>
                                       </td>
                                       <td class="text-center">
                                       
                                          <button type="button" class="btn btn-success text-center thisBtn load-btn-{{$num['form']['id']}}" 
                                                   data-user="{{$num['game_id']}}" 
                                                   data-userId="{{$num['form']['id']}}"
                                                   data-cashApp="{{$activeCashApp['id']}}">Load</button>
                                       </td>
                                       {{-- History --}}                                          
                                       <td class="text-center">
                                          <div class="dropdown">
                                             <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             View
                                             </button>
                                             <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="left: -75px!important;">
                                                {{-- <a class="dropdown-item user-history" href="javascript:void(0);" data-type="cash" data-userId="{{$num['form']['id']}}" data-game="{{$num['form']['id']}}">Cash App</a> --}}
                                                <a class="dropdown-item remove-form-game" href="javascript:void(0);" data-tr="{{$a+1}}" data-type="load" data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}"><i class="fa fa-trash" style="color: red"></i> Remove</a>
                                                <a class="dropdown-item user-history" href="javascript:void(0);" data-type="load" data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}">Balance Load</a>
                                                <a class="dropdown-item user-history" href="javascript:void(0);" data-type="redeem" data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}">Redeems</a>
                                             </div>
                                          </div>
                                       </td>
                                    </tr>
                                    @endforeach
                                 @else
                                    <tr>
                                       <td> No Users in this game.</td>
                                    </tr>
                                 @endif
                              @else
                                 <tr>
                                    <td>Please choose a game first.</td>
                                 </tr>
                              @endif
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
{{-- Redeem History Modal --}}
<div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title color-white" id="exampleModalLongTitle"><i class="fa fa-scroll" style="width: 50px;"></i>Redeem</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <table>
                  <thead>
                     <tr>
                        <th class="text-center">Date</th>
                        <th>To</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Users Name</th>
                     </tr>
                  </thead>
                  <tbody style="text-align: center!important;">
                     @if (isset($history) && !empty($history))
                     @foreach($history as $a => $num)
                     @if ($num['type'] == 'redeem')
                     <tr>
                        <td>{{date('D, M-d, Y H:i:a', strtotime($num['created_at']))}}</td>
                        <td>{{ (!empty($num['form_games']))?$num['form_games']['game_id']:'Deleted Player'}}</td>
                        <td class="text-center">{{$num['amount_loaded']}}</td>
                        <td>{{(isset($num['form']['full_name']) && !empty($num['form']['full_name'])?$num['form']['full_name']:'empty')}}</td>
                     </tr>
                     @endif
                     @endforeach
                     @else
                     <tr>
                        <td>History Empty</td>
                     </tr>
                     @endif
                  </tbody>
               </table>
            </div>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="button" class="btn btn-success text-center load-btn" data-user="" data-userId="">Load</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- Load History Modal --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title color-white" id="exampleModalLongTitle"><i class="fa fa-scroll" style="width: 50px;"></i>History</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <table>
                  <thead>
                     <tr>
                        <th class="text-center">Date</th>
                        <th>To</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Users Name</th>
                     </tr>
                  </thead>
                  <tbody style="text-align: center!important;">
                     @if (isset($history) && !empty($history))
                     @foreach($history as $a => $num)
                     @if ($num['type'] == 'load')
                     <tr>
                        <td>{{date('D, M-d, Y H:i:a', strtotime($num['created_at']))}}</td>
                        <td>{{ (!empty($num['form_games']))?$num['form_games']['game_id']:'Deleted Player'}}</td>
                        <td class="text-center">{{$num['amount_loaded']}}</td>
                        <td>{{(isset($num['form']['full_name']) && !empty($num['form']['full_name'])?$num['form']['full_name']:'empty')}}</td>
                     </tr>
                     @endif
                     @endforeach
                     @else
                     <tr>
                        <td>History Empty</td>
                     </tr>
                     @endif
                  </tbody>
               </table>
            </div>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="button" class="btn btn-success text-center load-btn" data-user="" data-userId="">Load</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- Add User Modal --}}
<style>
   @media (min-width: 992px){
      .modal-lg {
         max-width: 1025px;
      }
   }
   @media (min-width: 576px){
      .modal-dialog {
         max-width: 628px;
         margin: 30px auto;
      }
   }
   .add-user-modal label{
      width: 70px;
   }
</style>
<div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form action="{{route('addUser')}}" method="post">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-user-plus" style="width: 50px;"></i>Add User</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body add-user-modal">
               @csrf
               <input type="hidden" name="account_id" value="{{$activeGame['id']}}">
               <div class="form-control col-12">
                  <label for="id">User</label>
                  <select name="id" id="id" class="select2" required>
                     @if (isset($forms) && !empty($forms))
                     @foreach($forms as $a => $num)
                     <option value="{{$num['id']}}">{{$num['full_name']}}  [{{(!empty($num['facebook_name'])?$num['facebook_name']:'empty')}}]</option>
                     @endforeach
                     @else
                     <option disabled>No Users</option>
                     @endif
                  </select>
                  Full Name [ Facebook Name ]
               </div>
               <div class="form-control col-12">
                  <label for="game_id">Game Id</label>
                  <input type="text" name="game_id" id="game_id" required>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Add</button>
            </div>
         </form>
      </div>
   </div>
</div>
{{-- User History All Modal --}}
<div class="modal fade" id="exampleModalCenter5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         {{-- 
         <form action="{{route('addUser')}}" method="post">
         --}}
         <div class="modal-header">
            <h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-user-plus" style="width: 50px;"></i><span class="user-history-heading">User History</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="col-12 display-inline-flex">
               <div class="form-control">
                  <select name="type" id="" class="filter-type">
                     <option value="all">All</option>
                     <option value="load">Load</option>
                     <option value="redeem">Redeem</option>
                     <option value="refer">Bonus</option>
                     <option value="tip">Tip</option>
                     {{-- <option value="cashAppLoad">Cash App</option> --}}
                  </select>
               </div>
               <div class="form-control">   
                  <input type="date" name="start" class="filter-start">
               </div>
               <div class="form-control">   
                  <input type="date" name="end" class="filter-end">
               </div>
               <div class="form-control">   
                  <button class="filter-history" data-userId="" data-game="">Go</button>
               </div>
            </div>
            <div class="col-12">
               <table>
                  <thead>
                     <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center form-history-related hidden">Game</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Type</th>
                        {{-- 
                        <th class="text-center">Prev</th>
                        <th class="text-center">Amount</th>
                        --}}
                        <th class="text-center">Created By</th>
                     </tr>
                  </thead>
                  <tbody style="text-align: center!important;" class="user-history-body">
                  </tbody>
               </table>
            </div>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- User History Modal --}}
<div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         {{-- 
         <form action="{{route('addUser')}}" method="post">
         --}}
         <div class="modal-header">
            <h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-user-plus" style="width: 50px;"></i><span class="user-history-heading">User History</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <table>
               <thead>
                  <tr>
                     <th class="text-center">Date</th>
                     <th class="text-center">Amount</th>
                     {{-- 
                     <th class="text-center">Prev</th>
                     <th class="text-center">Amount</th>
                     --}}
                     <th class="text-center">Created By</th>
                  </tr>
               </thead>
               <tbody style="text-align: center!important;" class="user-history-body">
               </tbody>
            </table>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- Redeem History Modal --}}
<div class="modal fade" id="exampleModalCenter4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title color-white" id="exampleModalLongTitle"><i class="fa fa-scroll" style="width: 50px;"></i>Redeem</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <table>
                  <thead>
                     <tr>
                        <th class="text-center">Date</th>
                        <th>To</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Users Name</th>
                     </tr>
                  </thead>
                  <tbody style="text-align: center!important;">
                     @if (isset($history) && !empty($history))
                     @foreach($history as $a => $num)
                     @if ($num['type'] == 'refer')
                     <tr>
                        <td>{{date('D, M-d, Y H:i:a', strtotime($num['created_at']))}}</td>
                        <td>{{ (!empty($num['form_games']))?$num['form_games']['game_id']:'Deleted Player'}}</td>
                        <td class="text-center">{{$num['amount_loaded']}}</td>
                        <td>{{(isset($num['form']['full_name']) && !empty($num['form']['full_name'])?$num['form']['full_name']:'empty')}}</td>
                     </tr>
                     @endif
                     @endforeach
                     @else
                     <tr>
                        <td>History Empty</td>
                     </tr>
                     @endif
                  </tbody>
               </table>
            </div>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="button" class="btn btn-success text-center load-btn" data-user="" data-userId="">Load</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- Form History Modal --}}
<div class="modal fade" id="exampleModalCenter6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         {{-- 
         <form action="{{route('addUser')}}" method="post">
         --}}
         <div class="modal-header">
            <h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-user-plus" style="width: 50px;"></i><span class="user-history-heading">User History</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="col-12 display-inline-flex">
               <div class="card col-sm-12 col-md-12 col-lg-2">
                  <div class="card-body">
                  Total Tip : <span class="total-tip">0</span> 
                  </div>     
                  </div>
                  <div class="card col-sm-12 col-md-12 col-lg-2">
                  <div class="card-body">
                  Balance In: <span class="total-balance">0</span> 
                  </div>     
                  </div>
                  <div class="card col-sm-12 col-md-12 col-lg-2">
                  <div class="card-body">
                  Total Redeem : <span class="total-redeem">0</span> 
                  </div>     
                  </div>
                  <div class="card col-sm-12 col-md-12 col-lg-2">
                  <div class="card-body">
                  Total Bonus : <span class="total-refer">0</span> 
                  </div>     
                  </div>
            
                  <div class="card col-sm-12 col-md-12 col-lg-2">
                  <!--<div class="card-body">-->
                  <!--Total Amount : <span class="total-amount">0</span> -->
                  <!--</div>     -->
                  </div>
                  <div class="card col-sm-12 col-md-12 col-lg-2">
                  <div class="card-body">
                  Total Profit : <span class="total-profit">0</span> 
                  </div>     
               </div>
           </div>
            <div class="col-12 display-inline-flex">
               <div class="form-control">
                  <select name="type" id="" class="filter-type1">
                     <option value="all">All</option>
                     <option value="load">Load</option>
                     <option value="redeem">Redeem</option>
                     <option value="refer">Bonus</option>
                     <option value="tip">Tip</option>
                     {{-- <option value="cashAppLoad">Cash App</option> --}}
                  </select>
               </div>
               <div class="form-control">   
                  <input type="date" name="start" class="filter-start1">
               </div>
               <div class="form-control">   
                  <input type="date" name="end" class="filter-end1">
               </div>
               <div class="form-control">   
                  <button class="filter-history form-all" data-userId="" data-game="">Go</button>
               </div>
            </div>
            <div class="col-12">
               <table>
                  <thead>
                     <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Game</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Type</th>
                        {{-- 
                        <th class="text-center">Prev</th>
                        <th class="text-center">Amount</th>
                        --}}
                        <th class="text-center">Created By</th>
                     </tr>
                  </thead>
                  <tbody style="text-align: center!important;" class="user-history-body">
                  </tbody>
               </table>
            </div>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- All History Modal --}}
<div class="modal fade" id="exampleModalCenter7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document" style="max-width: 95%;">
      <div class="modal-content">
         {{-- 
         <form action="{{route('addUser')}}" method="post">
         --}}
         <div class="modal-header">
            <h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-user-plus" style="width: 50px;"></i><span class="user-history-heading">User History</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="col-12 display-inline-flex">
               <div class="form-control">
                  <select name="type" id="" class="filter-type12">
                     <option value="all">All</option>
                     <option value="load">Load</option>
                     <option value="redeem">Redeem</option>
                     <option value="refer">Bonus</option>
                     <option value="tip">Tip</option>
                     {{-- <option value="cashAppLoad">Cash App</option> --}}
                  </select>
               </div>
               <div class="form-control">   
                  <input type="date" name="start" class="filter-start12">
               </div>
               <div class="form-control">   
                  <input type="date" name="end" class="filter-end12">
               </div>
               <div class="form-control">   
                  <button class="filter-all-history user-all" data-userId="" data-game="">Go</button>
               </div>
            </div>
            <div class="col-12">
               <table>
                  <thead>
                     <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">FB Name</th>
                        <th class="text-center">Game</th>
                        <th class="text-center">Game Id</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Type</th>
                        {{-- 
                        <th class="text-center">Prev</th>
                        <th class="text-center">Amount</th>
                        --}}
                        <th class="text-center">Created By</th>
                     </tr>
                  </thead>
                  <tbody style="text-align: center!important;" class="user-history-body">
                  </tbody>
               </table>
            </div>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- Undo Modal --}}
<div class="modal fade" id="exampleModalCenter8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 95%;">
     <div class="modal-content">
        <div class="modal-header">
           <h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-user-plus" style="width: 50px;"></i><span class="user-history-heading">User History</span></h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
           </button>
        </div>
        <div class="modal-body">
           <div class="col-12">
              <table>
                 <thead>
                    <tr>
                       <th class="text-center">Date</th>
                       <th class="text-center">FB Name</th>
                       <th class="text-center">Game</th>
                       <th class="text-center">Game Id</th>
                       <th class="text-center">Amount</th>
                       <th class="text-center">Type</th>
                       <th class="text-center">Action</th>
                    </tr>
                 </thead>
                 <tbody style="text-align: center!important;" class="undo-history-body">
                 </tbody>
              </table>
           </div>
        </div>        
     </div>
  </div>
</div>
@endsection
@section('script')
@php
   $time = 1;
   $setting = App\Models\Setting::where('type','data-reset-time')->first();
   if($setting != ""){
      $time = $setting->value;
   }
@endphp
<script>
   var time = '{{$time}}';
       function resetData(){
        $(".resetThis").each(function( index ) {
           $(this).text('$ 0');
           $(this).attr("data-balance",0);
       })
      //  toastr.success("Data Reset");
      //  console.log('asdfasdf');
   }
   // resetData();
   setInterval(resetData, 1000*time);
</script>
@endsection