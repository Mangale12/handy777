<!--upload sheet start here -->
<div class="table-import-wrapper float-end mt-5 mx-3">
    <div class="table-import-input-wrapper">
        <form method="post" action="{{route('importTable')}}" enctype="multipart/form-data">
            @csrf
            <input type="date" name="date" required>
            <input type="file" name="file" required>
            <button class="btn btn-primary">Submit</button>
        </form>
        @error('file')
            <p style="font-size:12px;color:red;">{{$message}}</p>
        @enderror
    </div>
</div>
 
 <style>
 @media screen and (min-width: 720px) {
   .mobile-btn{
         display:none;
     }
}

  
 </style>

<table class="table align-items-center mb-0">
    <thead class="sticky" >
        <tr >
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{$language_texts['sn']}}</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{$language_texts['game-id']}}</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{$language_texts['fb-name']}}</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{$language_texts['balance']}}</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{$language_texts['bonus']}}</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{$language_texts['redeem']}}</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{$language_texts['tips']}}</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{$language_texts['action']}}</th>
            {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th> --}}
        </tr>
    </thead>
    <tbody>
        @isset($indicator)
        <tr>
            <td colspan="8" class="text-center"> {{ $indicator }} </td>
        </tr>
        @endisset()
        @if (isset($activeGame))
        @if (!empty($activeGame) && !empty($activeGame['form_games']))
        @php
        $count = 1;
        @endphp
        @foreach($formGames as $a => $num)
        <tr id="form-games-div-{{$a+1}}">
            <td>
                <div class="d-flex px-3">
                    <div class="d-flex  justify-content-center text-center">
                        <h6 class="mb-0 text-sm dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">{{$count++}}</h6>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="left: -75px!important;">
                            {{-- <a class="dropdown-item user-history" href="javascript:void(0);" data-type="cash" data-userId="{{$num['form']['id']}}" data-game="{{$num['form']['id']}}">Cash App</a> --}}
                            <a class="dropdown-item remove-player" href="javascript:void(0);" data-tr="{{$a+1}}" data-type="load" data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}"> Remove</a>
                            <a href="#popup4" class="dropdown-item user-history" data-type="load" data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}">{{$language_texts['balance']}}</a>
                            <a href="#popup4" class="dropdown-item user-history" data-type="redeem" data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}">{{$language_texts['redeem']}}</a>
                            <!--<a href="#popup6" class="dropdown-item user-gameids" data-userId="{{$num['form']['id']}}">View Game Ids</a>-->
                            <a href="{{route('userDetails',['id' => $num['form']['id']])}}" class="dropdown-item user-gameids">View Details</a>

                        </div>
                        <div id="popup5" class="overlay">
                            <div class="popup">
                                <h2><span class="user-name">Users</span> Load History</h2>
                                <a class="close" href="#">&times;</a>
                                <div class="content ">
                                    <div class="row" style="padding-top:20px;">
                                        <div class="col-12">
                                            <div class="card mb-4">
                                                <div class="card-header pb-0">
                                                    <h6>Upload</h6>
                                                </div>
                                                <div class="card-body px-0 pt-0 pb-2">
                                                    <div class="table-responsive p-0">
                                                        <table class="table align-items-center mb-0">
                                                            <thead class="sticky" >
                                                                <tr  >
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amoount</th>
                                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created by</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody  style="text-align: center!important;" class="user-history-body">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div >
                            </div >
                        </div>
                        <div id="popup4" class="overlay">
                            <div class="popup">
                                <h2><span class="user-name">Users</span> <span class="load-type">Load</span> History</h2>
                                <a class="close" href="#">&times;</a>
                                <div class="content ">
                                    <div class="row" style="padding-top:20px;">
                                        <div class="col-12">
                                            <div class="card mb-4">
                                                <div class="card-header pb-0">
                                                    <h6>Upload</h6>
                                                </div>
                                                <div class="card-body px-0 pt-0 pb-2">
                                                    <div class="table-responsive p-0">
                                                        <table class="table align-items-center mb-0">
                                                            <thead class="sticky" >
                                                                <tr  >
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amoount</th>
                                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created by</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody  style="text-align: center!important;" class="user-history-body">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div >
                            </div >
                        </div>
                        
                        <div id="popup6" class="overlay">
                            <div class="popup">
                                <h2><span class="user-name">Users</span> Game Ids</h2>
                                <a class="close" href="#">&times;</a>
                                <div class="content ">
                                    <div class="row" style="padding-top:20px;">
                                        <div class="col-12">
                                            <div class="card mb-4">
                                                <div class="card-body px-0 pt-0 pb-2">
                                                    <div class="table-responsive p-0">
                                                        <table class="table align-items-center mb-0">
                                                            <thead class="sticky" >
                                                                <tr  >
                                                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Game</th>
                                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Game Id</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody  style="text-align: center!important;" class="user-game-ids">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div >
                            </div >
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="d-flex px-2 py-1 " >
                    <a href="#popup1" class="user-full-history" data-gameId="{{($num['game_id'])}}" href="javascript:void(0);" data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}">
                        <div class="d-flex  justify-content-center text-center">
                            <h6 class=" mb-0 text-sm" > {{($num['game_id'])}}</h6>
                        </div>
                    </a>
                    <div id="popup1" class="overlay">
                        <div class="popup">
                            <h2><span class="user-name">Users</span> History in {{(isset($activeGame) && $activeGame['id'] != '')?$activeGame['name']:''}}</h2>
                            <a class="close" href="#">&times;</a>
                            <div class="content ">
                                <div class="row" style="padding-top:20px;">
                                    <div class="col-12">
                                        <div class="card mb-4">
                                            <div class="card-header pb-0">
                                                {{-- <h6>Authors table</h6> --}}
                                                <div class="row w-100" style="justify-content: space-around;">
                                                    <div class="col-2">
                                                        <button class="btn btn-success history-type-change-btn" data-userId="" data-game="" data-type="all">All</button>
                                                    </div>
                                                    <div class="col-2">
                                                        <button class="btn btn-success history-type-change-btn" data-userId="" data-game="" data-type="load">Load</button>
                                                    </div>
                                                    <div class="col-2">
                                                        <button class="btn btn-success history-type-change-btn" data-userId="" data-game="" data-type="redeem">Redeem</button>
                                                    </div>
                                                    <div class="col-2">
                                                        <button class="btn btn-success history-type-change-btn" data-userId="" data-game="" data-type="refer">Bonus</button>
                                                    </div>
                                                    <div class="col-2">
                                                        <button class="btn btn-success history-type-change-btn" data-userId="" data-game="" data-type="tip">Tip</button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="type" class="user-current-game-history-input">
                                                {{-- <div class="col-4">
                                                    <select name="type" id="" class="filter-type">
                                                        <option value="all">All</option>
                                                        <option value="load">Load</option>
                                                        <option value="redeem">Redeem</option>
                                                        <option value="refer">Bonus</option>
                                                        <option value="tip">Tip</option>
                                                    </select>
                                                </div> --}}
                                            </div>
                                            <div class="card-body px-0 pt-0 pb-2">
                                                <div class="row display-inline-flex">
                                                    <div class="col-4">
                                                        <input type="date" name="start" class="filter-start">
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="date" name="end" class="filter-end">
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="filter-history btn btn-primary" data-userId="" data-game="">Go</button>
                                                    </div>
                                                </div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td class="text-center hidden">
                <button class="btn btn-primary amountBtn user-cashapp-{{($num['game_id'])}} resetThis" type="button" data-toggle="collapse" data-target="#collapseExampleCashApp-{{$a+1}}" aria-expanded="false" aria-controls="collapseExampleCashApp-{{$a+1}}" data-id="{{($num['form']['id'])}}" data-parent="{{'#form-games-div-'.($a+1)}}" data-user="{{($num['game_id'])}}" data-balance="{{(isset($num['cash_app']) && !empty($num['cash_app']))?$num['cash_app']:'0'}}">
                    $ {{(isset($num['cash_app']) && !empty($num['cash_app']))?$num['cash_app']:'0'}}
                </button>
                <div class="collapse-{{$a+1}} collapse" id="collapseExampleCashApp-{{$a+1}}">
                    <div class="card card-body">
                        <input required type="hidden" class="form-control cashApp-from" name="cashApp-from" value="{{$activeGame['id']}}" data-title="{{str_replace(' ','-',$activeGame['title'])}}">
                        <input required type="text" class="form-control amount" name="amount" data-user="{{$num['game_id']}}" data-cashApp="{{$activeCashApp['id']}}" data-userId="{{$num['form']['id']}}" value="" placeholder="{{$language_texts['amount']}}">
                        <button type="button" class="btn btn-success text-center cashApp-btn" data-user="{{$num['game_id']}}" data-cashApp="{{$activeCashApp['id']}}" data-userId="{{$num['form']['id']}}">
                            Load
                        </button>
                    </div>
                </div>
            </td>
            <td>
                <a href="#popup2" class="form-full-history" data-gameId="{{($num['game_id'])}}"  data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}">
                    <div class="d-flex px-2 py-1  align-middle text-center" >
                        <div class="d-flex  justify-content-left">
                            <h6 class=" mb-0 text-sm" >
                                {{(isset($num['form']['facebook_name']) && !empty($num['form']['facebook_name']))?$num['form']['facebook_name']:'Empty'}}
                            </h6>
                        </div >
                    </div >
                </a>
                <div id="popup2" class="overlay">
                    <div class="popup">
                        <h2><span class="user-name">Users</span> All History</h2>
                        <a class="close" href="#">&times;</a>
                        <div class="content ">
                            <div class="row" style="padding-top:20px;">
                                <div class="col-12">
                                    <div class="card mb-4">
                                        {{-- <div class="card-header pb-0">
                                            <h6>Upload</h6>
                                        </div> --}}
                                        <div class="card-body px-0 pt-0 pb-2">
                                            <div class="row">
                                                <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">
                                                    <div class="card">
                                                        <div class="card-body p-3">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="d-flex flex-column">
                                                                            <h6 class="mb-1 text-dark text-sm">Total Tip : <span class="total-tip">0</span> </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">
                                                    <div class="card">
                                                        <div class="card-body p-3">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="d-flex flex-column">
                                                                            <h6 class="mb-1 text-dark text-sm">Balance In: <span class="total-balance">0</span>  </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">
                                                    <div class="card">
                                                        <div class="card-body p-3">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="d-flex flex-column">
                                                                            <h6 class="mb-1 text-dark text-sm">Redeem : <span class="total-redeem">0</span> </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">
                                                    <div class="card">
                                                        <div class="card-body p-3">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="d-flex flex-column">
                                                                            <h6 class="mb-1 text-dark text-sm">Bonus : <span class="total-refer">0</span> </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--<div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">-->
                                                <!--    <div class="card">-->
                                                <!--        <div class="card-body p-3">-->
                                                <!--            <div class="row">-->
                                                <!--                <div class="col-12">-->
                                                <!--                    <div class="d-flex align-items-center">-->
                                                <!--                        <div class="d-flex flex-column">-->
                                                <!--                            <h6 class="mb-1 text-dark text-sm">Total Amount : <span class="total-amount">0</span></h6>-->
                                                <!--                        </div>-->
                                                <!--                    </div>-->
                                                <!--                </div>-->
                                                <!--            </div>-->
                                                <!--        </div>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                                <!--<div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">-->
                                                <!--    <div class="card">-->
                                                <!--        <div class="card-body p-3">-->
                                                <!--            <div class="row">-->
                                                <!--                <div class="col-12">-->
                                                <!--                    <div class="d-flex align-items-center">-->
                                                <!--                        <div class="d-flex flex-column">-->
                                                <!--                            <h6 class="mb-1 text-dark text-sm">Total Profit : <span class="total-profit">0</span> </h6>-->
                                                <!--                        </div>-->
                                                <!--                    </div>-->
                                                <!--                </div>-->
                                                <!--            </div>-->
                                                <!--        </div>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                            </div>
                                            <div class="row w-100" style="justify-content: space-around;">
                                                <div class="col-2">
                                                    <button class="btn btn-success history-type-change-btn form-all" data-userId="" data-game="" data-type="all">All</button>
                                                </div>
                                                <div class="col-2">
                                                    <button class="btn btn-success history-type-change-btn form-all" data-userId="" data-game="" data-type="load">Load</button>
                                                </div>
                                                <div class="col-2">
                                                    <button class="btn btn-success history-type-change-btn form-all" data-userId="" data-game="" data-type="redeem">Redeem</button>
                                                </div>
                                                <div class="col-2">
                                                    <button class="btn btn-success history-type-change-btn form-all" data-userId="" data-game="" data-type="refer">Bonus</button>
                                                </div>
                                                <div class="col-2">
                                                    <button class="btn btn-success history-type-change-btn form-all" data-userId="" data-game="" data-type="tip">Tip</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <input type="hidden" name="type" class="user-current-game-history-input">
                                                {{-- <div class="col-4"> --}}
                                                    {{-- <select name="type" id="" class="filter-type1">
                                                        <option value="all">All</option>
                                                        <option value="load">Load</option>
                                                        <option value="redeem">Redeem</option>
                                                        <option value="refer">Bonus</option>
                                                        <option value="tip">Tip</option>
                                                    </select> --}}
                                                    {{-- </div> --}}
                                                    <div class="col-4">
                                                        <input type="date" name="start" class="filter-start1">
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="date" name="end" class="filter-end1">
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn-primary filter-history form-all " data-userId="" data-game="">Go</button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive p-0">
                                                    <table class="table align-items-center mb-0">
                                                        <thead class="sticky" >
                                                            <tr  >
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Game</th>
                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amoount</th>
                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created by</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody  style="text-align: center!important;" class="user-history-body">
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
                </div>
            </td>
            <td style="width:170px;text-align:center">
                <div class="col-sm-12 col-md-12 col-lg-6 hidden">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle cash-app-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-id="{{($activeCashApp['id'])}}" data-title="{{($activeCashApp['title'])}}" data-balance="{{($activeCashApp['balance'])}}">
                            Cash App Account : {{(isset($activeCashApp) && !empty($activeCashApp))?$activeCashApp['title']:''}} :
                            <span class="cash-app-blnc">{{(isset($activeCashApp) && !empty($activeCashApp))?('$ '.$activeCashApp['balance']):''}}</span>
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
                <span class="user-{{($num['game_id'])}} resetThis" data-balance="{{($num['balance']) ?? 0}}" data-type="load">$ {{($num['balance'] ?? 0)}}</span>
                <div class="card card-body">
                    <input required type="hidden" class="form-control load-from loadFrom{{$num['form']['id']}}" name="load-from" value="{{$activeGame['id']}}" data-title="{{str_replace(' ','-',$activeGame['title'])}}">
                    @if(request()->ajax())
                    <input required type="text" class="form-control loadInput loadInput{{$num['form']['id']}}" onkeydown="loadNewBalance(event,$(this));" name="amount" data-user="{{$num['game_id']}}" data-userId="{{$num['form']['id']}}" value="" data-balance="0" placeholder="{{$language_texts['amount']}}">
                    @else
                    <input required type="text" class="form-control loadInput loadInput{{$num['form']['id']}}" name="amount" data-user="{{$num['game_id']}}" data-userId="{{$num['form']['id']}}" value="" data-balance="0" placeholder="{{$language_texts['amount']}}">
                    @endif
                    <button type="button" class="btn mobile-btn btn-success text-center load-btn" data-user="{{$num['game_id']}}" data-userId="{{$num['form']['id']}}">Load</button>
                </div>
            </td>
            <td style="width:170px;text-align:center">
                <span class="user-refer-{{($num['game_id'])}} resetThis" data-balance="{{($num['refer'] ?? 0)}}" data-type="refer">$ {{$num['refer'] ?? 0}}</span>
                <div class="card card-body">
                    <input required type="hidden" class="form-control refer-from" name="refer-from" value="{{$activeGame['id']}}" data-title="{{str_replace(' ','-',$activeGame['title'])}}">
                    @if(request()->ajax())
                    <input required type="text" class="form-control referInput   referInput{{$num['form']['id']}}" onkeydown="loadNewRefer(event, $(this));" onchange="chnageButtonValue(this.value)" name="amount" data-user="{{$num['game_id']}}" data-userId="{{$num['form']['id']}}" value="" placeholder="{{$language_texts['amount']}}" data-title="{{str_replace(' ','-',$activeGame['title'])}}">
                    @else
                    <input required type="text" class="form-control referInput referInput{{$num['form']['id']}}" name="amount" data-user="{{$num['game_id']}}" data-userId="{{$num['form']['id']}}" value="" onchange="chnageButtonValue(this.value)" placeholder="{{$language_texts['amount']}}" data-title="{{str_replace(' ','-',$activeGame['title'])}}">
                    @endif
                    <button type="button" class="btn mobile-btn btn-success text-center refer-btn" data-user="{{$num['game_id']}}" data-userId="{{$num['form']['id']}}">Load</button>
                </div>
            </td>
            <td style="width:170px;text-align:center">
                <span class="user-redeem-{{($num['game_id'])}} resetThis" data-balance="{{($num['redeem'] ?? 0)}}" data-type="redeem">$ {{($num['redeem'] ?? 0)}}</span>
                <div class="card card-body">
                    <input required type="hidden" class="form-control redeem-from redeemFrom{{$num['form']['id']}}" name="redeem-from" value="{{$activeGame['id']}}" data-title="{{str_replace(' ','-',$activeGame['title'])}}">
                    @if(request()->ajax())
                    <input required type="text" class="form-control redeemInput redeemInput{{$num['form']['id']}}" onkeydown="loadNewRedeem(event, $(this));" name="amount" data-user="{{$num['game_id']}}" data-userId="{{$num['form']['id']}}" value="" placeholder="{{$language_texts['amount']}}">
                    @else
                    <input required type="text" class="form-control redeemInput redeemInput{{$num['form']['id']}}" name="amount" data-user="{{$num['game_id']}}" data-userId="{{$num['form']['id']}}" value="" placeholder="{{$language_texts['amount']}}">
                    @endif
                    <button type="button" class="btn btn-success mobile-btn text-center redeem-btn" data-user="{{$num['game_id']}}" data-userId="{{$num['form']['id']}}">Redeem</button>
                </div>
            </td>
            <td style="width:170px;text-align:center">
                <span class="user-tip-{{($num['game_id'])}} resetThis" data-balance="{{($num['tip'] ?? 0)}}" data-type="tip">$ {{$num['tip'] ?? 0}}</span>
                <div class="card card-body">
                    <input required type="hidden" class="form-control tip-from" name="tip-from" value="{{$activeGame['id']}}" data-title="{{str_replace(' ','-',$activeGame['title'])}}">
                    @if(request()->ajax())
                    <input required type="text" class="form-control tipInput tipInput{{$num['form']['id']}}" onkeydown="loadNewTip(event, $(this));" name="amount" data-user="{{$num['game_id']}}" data-userId="{{$num['form']['id']}}" value="" placeholder="{{$language_texts['amount']}}">
                    @else
                    <input required type="text" class="form-control tipInput tipInput{{$num['form']['id']}}" name="amount" data-user="{{$num['game_id']}}" data-userId="{{$num['form']['id']}}" value="" placeholder="{{$language_texts['amount']}}">
                    @endif
                    <button type="button" class="btn btn-success text-center tip-btn mobile-btn" data-user="{{$num['game_id']}}" data-userId="{{$num['form']['id']}}">Tip</button>
                </div>
            </td>
            <td style="width:170px;text-align:center" class=" text-center ">
                <button type="button" class="btn btn-success text-center thisBtn load-btn-{{$num['form']['id']}}"
                data-user="{{$num['game_id']}}"
                data-userId="{{$num['form']['id']}}"
                data-cashApp="{{$activeCashApp['id']}}"
                style="background-color:#FF9800;"><i class="fa fa-spinner"></i></button>
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
<div class="mt-3 text-center">
    {{ $formGames->render() }}
</div>
@php
   $time = 1;
   $setting = App\Models\Setting::where('type','data-reset-time')->first();
   if($setting != ""){
      $time = $setting->value;
   }
@endphp
<script>
        function chnageButtonValue(value){
            $('.refer-btn').data('input', value);
        }
        $(function() {
            $('.remove-player').on('click', function(e) {
                var gameTitle = $(".tip-from").attr("data-title");
                var gameId = $(this).attr("data-game");

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userId');

                var formtr = $("#form-games-div-" + $(this).attr('data-tr'));


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
                        console.log('asd');
                    }
                    else if (result.isDenied) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var type = "POST";
                        var ajaxurl = '/remove-form-game';
                        // var interval = null;
                        $.ajax({
                            type: type,
                            url: ajaxurl,
                            data: {
                                "gameId": gameId,
                                "userId": userId,
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                // i = 0;
                                // $(".tip-btn").addClass("disabled");
                                // interval = setInterval(function() {
                                //     i = ++i % 4;
                                //     $(".tip-btn").html("Tip" + Array(i + 1).join("."));
                                // }, 300);
                            },
                            success: function(data) {

                                formtr.remove();
                                $( ".count-row" ).each(function( index ) {
                                    $(this).text((index+1));
                                    // console.log( index + ": " + $( this ).text() );
                                });
                                toastr.success('Player Delete');
                            },
                            error: function(data) {
                                toastr.error('Error', data.responseText);
                                console.log('error in tipping balance');
                            }
                        });
                    }
                });
            });
        });
$(function() {
    $('.refer-btn').on('click', function(e) {
        // alert("im ckicl again")
        // var userCashAppBtn = $(".user-refer-" + $('.referInput'+$(this).attr('data-userId')).attr('data-user'));
        // var userCashAppCollapse = userCashAppBtn.attr('data-target');
        // Assuming you're inside an event handler function
        var dataUserId = $(this).attr('data-userId'); // Assuming 'this' refers to the element you want to target
        
        // Constructing the selector to target elements with the class '.referInput' and the appropriate 'data-userId' attribute
        var selector = '.referInput[data-userId="' + dataUserId + '"]';
        
        // Selecting the desired element using the constructed selector
        var userCashAppBtn = $(".user-refer-" + $(selector).attr('data-user'));
        
        // Accessing the 'data-target' attribute of the selected element
        var userCashAppCollapse = userCashAppBtn.attr('data-target');
        $('.referInput'+$(this).attr('data-userId')).attr('disabled','disabled');
            // if (($('.referInput'+$(this).attr('data-userId')).val()) == '' || $('.referInput'+$('.referInput'+$(this).attr('data-userId')).val() < 0) 
            //     {
            //         toastr.error('Please enter a valid amount.');
            //         return;
            //     }
            if ($('.referInput' + $(this).attr('data-userId')).val() === '' || parseFloat($('.referInput' + $(this).attr('data-userId')).val()) < 0) {
                toastr.error('Please enter a valid amount.');
                return;
            }

            var gameTitle = $(this).attr("data-title");
            var gameId = $(this).parent().find('.refer-from').val();

            var gameBtn = $("." + gameTitle + '-' + gameId + "");

            var user = $(this).attr('data-user');
            var userId =$(this).attr('data-userId');
           
            var userBalanceBtn = $(".user-" + $('.referInput'+$(this).attr('data-userId')).attr('data-user'));
            var useReferBtn = $(".user-refer-" + $('.referInput'+$(this).data('userId')).attr('data-user'));
            var userCashAppCollapse = useReferBtn.attr('data-target');

            var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
            var currentUserBalance = parseInt(useReferBtn.attr('data-balance'));

            var amount = parseInt($('.referInput'+$(this).attr('data-userId')).val());

            if (amount > currentGameBalance) {
                $('.referInput'+$(this).attr('data-userId')).removeAttr('disabled');
                toastr.error('Balance to load is greater than the game balance.');
                return;
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var type = "POST";
                var ajaxurl = '/table-referBalance';
                var interval = null;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: {
                        "gameId": gameId,
                        "userId": userId,
                        "amount": amount,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        i = 0;
                        $(".load-btn").addClass("disabled");
                        interval = setInterval(function() {
                            i = ++i % 4;
                            $(".load-btn").html("Loading Balance" + Array(i + 1).join("."));
                        }, 300);
                    },
                    success: function(data) {
                        $('.referInput'+$(this).attr('data-userId')).removeAttr('disabled');
                        clearInterval(interval);

                        $(userCashAppCollapse).collapse('hide');

                        var totalGameBalance = currentGameBalance - amount;
                        var totalUserBalance = amount + currentUserBalance;

                        $(".load-btn").removeClass("disabled");
                        $(".load-btn").html("Load");

                        // userBalanceBtn.attr('data-balance',totalUserBalance);
                        // userBalanceBtn.text('$ '+totalUserBalance);


                        useReferBtn.attr('data-balance', totalUserBalance);
                        useReferBtn.text('$ ' + totalUserBalance);

                        gameBtn.attr('data-balance', totalGameBalance);

                        $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                        // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                        amount = 0;
                        currentGameBalance = 0;
                        currentUserBalance = 0;

                        $('#exampleModalCenter').modal('hide');
                        toastr.success('Balance Referred to User : ' + user);

                        $('.amount').val('');
                        $('.referInput').val('');
                        // optionLoop = '';
                        // options = data;
                        // options.forEach(function(index) {
                        //   optionLoop +=
                        //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                        // });
                        // $(".load-from").html(optionLoop);

                    },
                    error: function(data) {
                        $('.referInput'+$(this).attr('data-userId')).removeAttr('disabled');
                        clearInterval(interval);
                        $(".refer-btn").removeClass("disabled");
                        $(".refer-btn").html("Load");
                        toastr.error('Error', data.responseText);
                        console.log('error in referring balance');
                    }
                });
            }
        });
    });
    
    
    $(function() {
        $('.load-btn').on('click', function(e) {
            // var userCashAppBtn = $(".user-" + $('.loadInput').attr('data-user'));
            // var userCashAppCollapse = userCashAppBtn.attr('data-target');
            var dataUserId = $(this).attr('data-userId'); // Assuming 'this' refers to the element you want to target
            
            // Constructing the selector to target elements with the class '.referInput' and the appropriate 'data-userId' attribute
            var selector = '.referInput[data-userId="' + dataUserId + '"]';
            
            // Selecting the desired element using the constructed selector
            var userCashAppBtn = $(".user-refer-" + $(selector).attr('data-user'));
            
            // Accessing the 'data-target' attribute of the selected element
            var userCashAppCollapse = userCashAppBtn.attr('data-target');
            var userId = $(this).attr('data-userId');
            // console.log(userId);
            // var loadBtn = $('.load-btn-'+userId);
            // console.log(loadBtn);
            // loadBtn.removeClass();
            // loadBtn.addClass('btn btn-success dsf text-center load-btn load-btn-'+userId);
            // loadBtnClickEvent();
                $('.loadInput'+$(this).attr('data-userId')).attr('disabled','disabled');
                // $('.load-btn').on('click', function(e) {
                if (($('.loadInput'+$(this).attr('data-userId')).val()) == '' || $('.loadInput'+$(this).attr('data-userId')).val() <= 0) {
                    $('.loadInput'+$(this).attr('data-userId')).removeAttr('disabled');
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(".load-from").attr("data-title");
                var gameId = $(this).parent().find('.load-from').val();
        
                var gameBtn = $("." + gameTitle + '-' + gameId + "");
        
                var user = $(this).attr('data-user');
        
                var userBalanceBtn = $(".user-" + $(this).attr('data-user'));
                // console.log(userBalanceBtn);
                var useRedeemBtn = $(".user-redeem-" + $(this).attr('data-user'));
                var userBalanceCollapse = userBalanceBtn.attr('data-target');
        
                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(userBalanceBtn.attr('data-balance'));
                // console.log(currentUserBalance);
                var amount = parseInt($('.loadInput'+$(this).attr('data-userId')).val());
        
                var cashAppId = $(".cash-app-btn").attr("data-id");
                var cashAppTitle = $(".cash-app-btn").attr("data-title");
                var cashAppBalance = $(".cash-app-btn").attr("data-balance");
                var cashAppBtn = $(".cash-app-btn");
                var userCashAppBtn = $(".user-cashapp-" + $('.cashApp-btn').attr('data-user'));
                var userCashAppCollapse = userCashAppBtn.attr('data-target');
                var currentCashAppBalance = parseInt(cashAppBalance);
                
                //  console.log(cashAppId + ',' + cashAppTitle + ',' + cashAppBalance + ',');
                // console.log(user + ','  + currentCashAppBalance + ',' + ', '+ gameId + ',' + amount);
        
                if (amount > currentGameBalance) {
                    $('.loadInput'+$(this).attr('data-userId')).removeAttr('disabled');
                    toastr.error('Balance to load is greater than the game balance.');
                    return;
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var type = "POST";
                    var ajaxurl = '/table-loadBalance';
                    var interval = null;
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        data: {
                            "gameId": gameId,
                            "userId": userId,
                            "amount": amount,
                            "cashAppId": cashAppId,
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            i = 0;
                            $(".load-btn").addClass("disabled");
                            interval = setInterval(function() {
                                i = ++i % 4;
                                $(".load-btn").html("Loading Balance" + Array(i + 1).join("."));
                            }, 300);
                        },
                        success: function(data) {
                            console.log('success');
                            $('.loadInput'+$(this).attr('data-userId')).removeAttr('disabled');
                            clearInterval(interval);
        
                            $(userBalanceCollapse).collapse('hide');
        
                            var totalGameBalance = currentGameBalance - amount;
                            console.log(amount + ', ' + currentUserBalance);
                            var totalUserBalance = amount + currentUserBalance;
                            console.log(totalUserBalance);
        
                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");
        
                            userBalanceBtn.attr('data-balance', totalUserBalance);
                            userBalanceBtn.text('$ ' + totalUserBalance);
        
        
                            // useRedeemBtn.attr('data-balance', totalUserBalance);
                            // useRedeemBtn.text('$ ' + totalUserBalance);
        
                            $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                            gameBtn.attr('data-balance', totalGameBalance);
                            // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);
        
                            amount = 0;
                            currentGameBalance = 0;
                            currentUserBalance = 0;
        
                            $('#exampleModalCenter').modal('hide');
                            toastr.success('Balance Loaded to User : ' + user);
        
                            $('.amount').val('');
                            $('.loadInput'+$(this).attr('data-userId')).val('');
        
                            // optionLoop = '';
                            // options = data;
                            // options.forEach(function(index) {
                            //   optionLoop +=
                            //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                            // });
                            // $(".load-from").html(optionLoop);
        
                        },
                        error: function(data) {
                            alert(data.responseText);
                            $('.loadInput'+$(this).attr('data-userId')).removeAttr('disabled');
                            clearInterval(interval);
                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");
                            toastr.error('Error', data.responseText);
                            console.log('error in loading balance');
                        }
                    });
                }
                // });
        });
    });
    
    $(function() {
        $('.tip-btn').on('click', function(e) {
           
                $('.tipInput'+$(this).attr('data-userId')).attr('disabled','disabled');
                // $('.tip-btn').on('click', function(e) {
                if (($('.tipInput'+$(this).attr('data-userId')).val()) == '' || $('.tipInput'+$(this).attr('data-userId')).val() <= 0) {
                    $('.tipInput'+$(this).attr('data-userId')).removeAttr('disabled');
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(".tip-from").attr("data-title");
                var gameId = $(this).parent().find('.tip-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userId');
                var userBalanceBtn = $(".user-tip-" + $(this).attr('data-user'));
                // var useRedeemBtn = $(".user-redeem-" + $(this).attr('data-user'));
                var userTipCollapse = userBalanceBtn.attr('data-target');


                // var cashAppBtn = $('.cash-app-btn');
                // var cashAppId = $('.cash-app-btn').attr('data-id');
                // var cashAppBlncSpan = $('.cash-app-blnc');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(userBalanceBtn.attr('data-balance'));
                // var currentCashAppBlnc = parseInt(cashAppBtn.attr('data-balance'));

                var amount = parseInt($('.tipInput'+$(this).attr('data-userId')).val());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var type = "POST";
                var ajaxurl = '/table-tipBalance';
                var interval = null;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: {
                        "gameId": gameId,
                        "userId": userId,
                        "amount": amount,
                        // "cashAppId": cashAppId,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        i = 0;
                        $(".tip-btn").addClass("disabled");
                        interval = setInterval(function() {
                            i = ++i % 4;
                            $(".tip-btn").html("Load" + Array(i + 1).join("."));
                        }, 300);
                    },
                    success: function(data) {
                        $('.tipInput'+$(this).attr('data-userId')).removeAttr('disabled');
                        clearInterval(interval);

                        $(userTipCollapse).collapse('hide');

                        var totalGameBalance = currentGameBalance + amount;
                        var totalUserBalance = currentUserBalance + amount;
                        // var totalCashAppBalance = currentCashAppBlnc - amount;

                        $(".tip-btn").removeClass("disabled");
                        $(".tip-btn").html("Load");

                        // useRedeemBtn.attr('data-balance', totalUserBalance);
                        // useRedeemBtn.text('$ ' + totalUserBalance);

                        userBalanceBtn.attr('data-balance', totalUserBalance);
                        userBalanceBtn.text('$ ' + totalUserBalance);

                        gameBtn.attr('data-balance', totalGameBalance);
                        $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                        // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                        // cashAppBtn.attr('data-balance', totalCashAppBalance);
                        // cashAppBlncSpan.text('$ ' + totalCashAppBalance);

                        amount = 0;
                        currentGameBalance = 0;
                        currentUserBalance = 0;

                        // $('#exampleModalCenter').modal('hide');
                        toastr.success('Balance Tipped from : ' + user);

                        $('.amount').val('');
                        $('.tipInput').val('');
                        // optionLoop = '';
                        // options = data;
                        // options.forEach(function(index) {
                        //   optionLoop +=
                        //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                        // });
                        // $(".load-from").html(optionLoop);

                    },
                    error: function(data) {
                        $('.tipInput'+$(this).attr('data-userId')).removeAttr('disabled');
                        clearInterval(interval);
                        $(".tip-btn").removeClass("disabled");
                        $(".tip-btn").html("Tip");
                        toastr.error('Error', data.responseText);
                        console.log('error in tipping balance');
                    }
                });
                // });
        });
    });
    
    
    $(function() {
        $('.redeem-btn').on('click', function(e) {
            var dataUserId = $(this).attr('data-userId'); // Assuming 'this' refers to the element you want to target
        
                // Constructing the selector to target elements with the class '.referInput' and the appropriate 'data-userId' attribute
                var selector = '.referInput[data-userId="' + dataUserId + '"]';
                
                // Selecting the desired element using the constructed selector
                var userCashAppBtn = $(".user-refer-" + $(selector).attr('data-user'));
                
                // Accessing the 'data-target' attribute of the selected element
                var userCashAppCollapse = userCashAppBtn.attr('data-target');

                $('.redeemInput'+$(this).attr('data-userId')).attr('disabled','disabled');
                // $('.redeem-btn').on('click', function(e) {
                if (($('.redeemInput'+$(this).attr('data-userId')).val()) == '' || $('.redeemInput'+$(this).attr('data-userId')).val() <= 0) {
                    $('.redeemInput'+$(this).attr('data-userId')).removeAttr('disabled');
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(".redeem-from").attr("data-title");
                var gameId = $(this).parent().find('.redeem-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userId');
                var userBalanceBtn = $(".user-" +(this).attr('data-user'));
                var useRedeemBtn = $(".user-redeem-" + $('.redeemInput'+$(this).attr('data-user')));
                var userCashAppCollapse = useRedeemBtn.attr('data-target');


                var cashAppBtn = $('.cash-app-btn');
                var cashAppId = $('.cash-app-btn').attr('data-id');
                var cashAppBlncSpan = $('.cash-app-blnc');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(useRedeemBtn.attr('data-balance'));
                var currentCashAppBlnc = parseInt(cashAppBtn.attr('data-balance'));

                var amount = parseInt($('.redeemInput'+$(this).attr('data-userId')).val());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var type = "POST";
                var ajaxurl = '/table-redeemBalance';
                var interval = null;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: {
                        "gameId": gameId,
                        "userId": userId,
                        "amount": amount,
                        "cashAppId": cashAppId,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        i = 0;
                        interval = setInterval(function() {
                            i = ++i % 4;
                            $(".redeem-btn").html("Redeeming Balance" + Array(i + 1).join("."));
                        }, 300);
                    },
                    success: function(data) {
                        $('.redeemInput'+$(this).attr('data-userId')).removeAttr('disabled');
                        clearInterval(interval);

                        $(userCashAppCollapse).collapse('hide');

                        var totalGameBalance = currentGameBalance + amount;
                        var totalUserBalance = currentUserBalance + amount;
                        var totalCashAppBalance = currentCashAppBlnc - amount;

                        $(".redeem-btn").removeClass("disabled");
                        $(".redeem-btn").html("Load");

                        useRedeemBtn.attr('data-balance', totalUserBalance);
                        useRedeemBtn.text('$ ' + totalUserBalance);

                        // userBalanceBtn.attr('data-balance', totalUserBalance);
                        // userBalanceBtn.text('$ ' + totalUserBalance);

                        gameBtn.attr('data-balance', totalGameBalance);
                        gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                        cashAppBtn.attr('data-balance', totalCashAppBalance);
                        cashAppBlncSpan.text('$ ' + totalCashAppBalance);

                        amount = 0;
                        currentGameBalance = 0;
                        currentUserBalance = 0;

                        $('#exampleModalCenter').modal('hide');
                        toastr.success('Balance Redeemed for : ' + user);

                        $('.amount').val('');
                        $('.redeemInput'+$(this).attr('data-userId')).val('');
                        // optionLoop = '';
                        // options = data;
                        // options.forEach(function(index) {
                        //   optionLoop +=
                        //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                        // });
                        // $(".load-from").html(optionLoop);

                    },
                    error: function(data) {
                        $('.redeemInput'+$(this).attr('data-userId')).removeAttr('disabled');
                        clearInterval(interval);
                        $(".load-btn").removeClass("disabled");
                        $(".load-btn").html("Load");
                        toastr.error('Error', data.responseText);
                        console.log('error in loading balance');
                    }
                });
                // });
        });
    });
    
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
   
     function loadNewBalance(e, thes){
            var userCashAppBtn = $(".user-" + $(thes).attr('data-user'));
            var userCashAppCollapse = userCashAppBtn.attr('data-target');
            var userId = $(thes).attr('data-userId');
    
            if (e.which == 9) {
                $(userCashAppCollapse).collapse('hide');

                var nextBtn = $(".user-refer-" + $(thes).attr('data-user'));
                var nextCollapse = nextBtn.attr('data-target');
                $(nextCollapse).collapse('show');
            }
            if (e.which === 13) {
                if (($(thes).val()) == '' || $(thes).val() < 0) {
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(".load-from").attr("data-title");
                var gameId = $(thes).parent().find('.load-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(thes).attr('data-user');

                var userBalanceBtn = $(".user-" + $(thes).attr('data-user'));
                console.log(userBalanceBtn);
                var useRedeemBtn = $(".user-redeem-" + $(thes).attr('data-user'));
                var userBalanceCollapse = userBalanceBtn.attr('data-target');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(userBalanceBtn.attr('data-balance'));
                console.log(currentUserBalance);
                var amount = parseInt($(thes).val());

                var cashAppId = $(".cash-app-btn").attr("data-id");
                var cashAppTitle = $(".cash-app-btn").attr("data-title");
                var cashAppBalance = $(".cash-app-btn").attr("data-balance");
                var cashAppBtn = $(".cash-app-btn");
                var userCashAppBtn = $(".user-cashapp-" + $('.cashApp-btn').attr('data-user'));
                var userCashAppCollapse = userCashAppBtn.attr('data-target');
                var currentCashAppBalance = parseInt(cashAppBalance);
                

                if (amount > currentGameBalance) {
                    toastr.error('Balance to load is greater than the game balance.');
                    return;
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var type = "POST";
                    var ajaxurl = '/table-loadBalance';
                    var interval = null;
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        data: {
                            "gameId": gameId,
                            "userId": userId,
                            "amount": amount,
                            "cashAppId": cashAppId,
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            i = 0;
                            $(".load-btn").addClass("disabled");
                            interval = setInterval(function() {
                                i = ++i % 4;
                                $(".load-btn").html("Loading Balance" + Array(i + 1).join("."));
                            }, 300);
                        },
                        success: function(data) {
                            console.log('Hey I am loading');
                            clearInterval(interval);

                            $(userBalanceCollapse).collapse('hide');

                            var totalGameBalance = currentGameBalance - amount;
                            console.log(amount + ', ' + currentUserBalance);
                            var totalUserBalance = amount + currentUserBalance;
                            console.log(totalUserBalance);

                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");

                            userBalanceBtn.attr('data-balance', totalUserBalance);
                            userBalanceBtn.text('$ ' + totalUserBalance);


                            $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                            gameBtn.attr('data-balance', totalGameBalance);

                            amount = 0;
                            currentGameBalance = 0;
                            currentUserBalance = 0;

                            $('#exampleModalCenter').modal('hide');
                            toastr.success('Balance Loaded to User : ' + user);

                            $('.amount').val('');
                            $('.loadInput').val('');

                        },
                        error: function(data) {
                            clearInterval(interval);
                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");
                            toastr.error('Error', data.responseText);
                        }
                    });
                }
            }
  }
  
  
  function loadNewRefer(e, thys){
            var userCashAppBtn = $(".user-refer-" + $(thys).attr('data-user'));
            var userCashAppCollapse = userCashAppBtn.attr('data-target');


            if (e.which == 9) {
                $(userCashAppCollapse).collapse('hide');

                var nextBtn = $(".user-redeem-" + $(thys).attr('data-user'));
                console.log(nextBtn);
                var nextCollapse = nextBtn.attr('data-target');
                $(nextCollapse).collapse('show');

                
            }
            if (e.which === 13) {

                if (($(thys).val()) == '' || $(thys).val() < 0) {
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(thys).parent().find(".refer-from").attr("data-title");
                var gameId = $(thys).parent().find('.refer-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(thys).attr('data-user');
                var userId = $(thys).attr('data-userid');
                var userBalanceBtn = $(".user-" + $(thys).attr('data-user'));
                var useReferBtn = $(".user-refer-" + $(thys).attr('data-user'));
                var userCashAppCollapse = useReferBtn.attr('data-target');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(useReferBtn.attr('data-balance'));

                var amount = parseInt($(thys).val());

                if (amount > currentGameBalance) {
                    toastr.error('Balance to load is greater than the game balance.');
                    return;
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var type = "POST";
                    var ajaxurl = '/table-referBalance';
                    var interval = null;
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        data: {
                            "gameId": gameId,
                            "userId": userId,
                            "amount": amount,
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            i = 0;
                            $(".load-btn").addClass("disabled");
                            interval = setInterval(function() {
                                i = ++i % 4;
                                $(".load-btn").html("Loading Balance" + Array(i + 1).join("."));
                            }, 300);
                        },
                        success: function(data) {
                            clearInterval(interval);

                            $(userCashAppCollapse).collapse('hide');

                            var totalGameBalance = currentGameBalance - amount;
                            var totalUserBalance = amount + currentUserBalance;

                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");

                           


                            useReferBtn.attr('data-balance', totalUserBalance);
                            useReferBtn.text('$ ' + totalUserBalance);

                            gameBtn.attr('data-balance', totalGameBalance);

                            $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                           

                            amount = 0;
                            currentGameBalance = 0;
                            currentUserBalance = 0;

                            $('#exampleModalCenter').modal('hide');
                            toastr.success('Balance Referred to User : ' + user);

                            $('.amount').val('');
                            $('.referInput').val('');
                            

                        },
                        error: function(data) {
                            clearInterval(interval);
                            $(".refer-btn").removeClass("disabled");
                            $(".refer-btn").html("Load");
                            toastr.error('Error', data.responseText);
                            console.log('error in referring balance');
                        }
                    });
                }
            }
  }
  
  
  function loadNewRedeem(e, redim){
            var userCashAppBtn = $(".user-redeem-" + $(redim).attr('data-user'));
            var userCashAppCollapse = userCashAppBtn.attr('data-target');


            if (e.which == 9) {
                $(userCashAppCollapse).collapse('hide');

                var nextBtn = $(".user-tip-" + $(redim).attr('data-user'));
                var nextCollapse = nextBtn.attr('data-target');
                $(nextCollapse).collapse('show');

               
            }
            if (e.which === 13) {
                // $('.redeem-btn').on('click', function(e) {
                if (($(redim).val()) == '' || $(redim).val() < 0) {
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(".redeem-from").attr("data-title");
                var gameId = $(redim).parent().find('.redeem-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(redim).attr('data-user');
                var userId = $(redim).attr('data-userId');
                var userBalanceBtn = $(".user-" + $(redim).attr('data-user'));
                var useRedeemBtn = $(".user-redeem-" + $(redim).attr('data-user'));
                var userCashAppCollapse = useRedeemBtn.attr('data-target');


                var cashAppBtn = $('.cash-app-btn');
                var cashAppId = $('.cash-app-btn').attr('data-id');
                var cashAppBlncSpan = $('.cash-app-blnc');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(useRedeemBtn.attr('data-balance'));
                var currentCashAppBlnc = parseInt(cashAppBtn.attr('data-balance'));

                var amount = parseInt($(redim).val());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var type = "POST";
                var ajaxurl = '/table-redeemBalance';
                var interval = null;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: {
                        "gameId": gameId,
                        "userId": userId,
                        "amount": amount,
                        "cashAppId": cashAppId,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        i = 0;
                        $(".redeem-btn").addClass("disabled");
                        interval = setInterval(function() {
                            i = ++i % 4;
                            $(".redeem-btn").html("Redeeming Balance" + Array(i + 1).join("."));
                        }, 300);
                    },
                    success: function(data) {
                        clearInterval(interval);

                        $(userCashAppCollapse).collapse('hide');

                        var totalGameBalance = currentGameBalance + amount;
                        var totalUserBalance = currentUserBalance + amount;
                        var totalCashAppBalance = currentCashAppBlnc - amount;

                        $(".redeem-btn").removeClass("disabled");
                        $(".redeem-btn").html("Load");

                        useRedeemBtn.attr('data-balance', totalUserBalance);
                        useRedeemBtn.text('$ ' + totalUserBalance);

                        // userBalanceBtn.attr('data-balance', totalUserBalance);
                        // userBalanceBtn.text('$ ' + totalUserBalance);

                        gameBtn.attr('data-balance', totalGameBalance);
                        gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                        cashAppBtn.attr('data-balance', totalCashAppBalance);
                        cashAppBlncSpan.text('$ ' + totalCashAppBalance);

                        amount = 0;
                        currentGameBalance = 0;
                        currentUserBalance = 0;

                        $('#exampleModalCenter').modal('hide');
                        toastr.success('Balance Redeemed for : ' + user);

                        $('.amount').val('');
                        $('.redeemInput').val('');
                        // optionLoop = '';
                        // options = data;
                        // options.forEach(function(index) {
                        //   optionLoop +=
                        //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                        // });
                        // $(".load-from").html(optionLoop);

                    },
                    error: function(data) {
                        clearInterval(interval);
                        $(".load-btn").removeClass("disabled");
                        $(".load-btn").html("Load");
                        toastr.error('Error', data.responseText);
                        console.log('error in loading balance');
                    }
                });
                // });

            }
  }
  
  function loadNewTip(e, this_tip){
            if (e.which === 13) {
                // $('.tip-btn').on('click', function(e) {
                if (($(this_tip).val()) == '' || $(this_tip).val() < 0) {
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(".tip-from").attr("data-title");
                var gameId = $(this_tip).parent().find('.tip-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this_tip).attr('data-user');
                var userId = $(this_tip).attr('data-userId');
                var userBalanceBtn = $(".user-tip-" + $(this_tip).attr('data-user'));
                
                var userTipCollapse = userBalanceBtn.attr('data-target');


                

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(userBalanceBtn.attr('data-balance'));
               

                var amount = parseInt($(this_tip).val());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var type = "POST";
                var ajaxurl = '/table-tipBalance';
                var interval = null;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: {
                        "gameId": gameId,
                        "userId": userId,
                        "amount": amount,
                        
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        i = 0;
                        $(".tip-btn").addClass("disabled");
                        interval = setInterval(function() {
                            i = ++i % 4;
                            $(".tip-btn").html("Load" + Array(i + 1).join("."));
                        }, 300);
                    },
                    success: function(data) {
                        clearInterval(interval);

                        $(userTipCollapse).collapse('hide');

                        var totalGameBalance = currentGameBalance + amount;
                        var totalUserBalance = currentUserBalance + amount;
                       

                        $(".tip-btn").removeClass("disabled");
                        $(".tip-btn").html("Load");

                      

                        userBalanceBtn.attr('data-balance', totalUserBalance);
                        userBalanceBtn.text('$ ' + totalUserBalance);

                        gameBtn.attr('data-balance', totalGameBalance);
                        $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                        

                        amount = 0;
                        currentGameBalance = 0;
                        currentUserBalance = 0;

                        
                        toastr.success('Balance Tipped from : ' + user);

                        $('.amount').val('');
                        $('.tipInput').val('');
                      

                    },
                    error: function(data) {
                        clearInterval(interval);
                        $(".tip-btn").removeClass("disabled");
                        $(".tip-btn").html("Tip");
                        toastr.error('Error', data.responseText);
                        console.log('error in tipping balance');
                    }
                });
                // });

            }
  }
</script>