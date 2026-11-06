@extends('newLayout.layouts.newLayout')

@section('title')
    Redeem Data
@endsection
@section('content')
    <style>
        .dataTables_wrapper {
            padding: 25px;
        }

        .dataTables_wrapper .row {
            padding: 10px;
        }

        tbody tr td {
            border-bottom: none;
        }

        .active-game-btn {
            background: #feb343;
        }

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
            width: 50%;
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

        @media screen and (max-width: 700px) {
            .box {
                width: 70%;
            }

            .popup {
                width: 70%;
            }
        }


        #timedate {
            font: small-caps lighter auto/150% "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
            text-align: left;

            margin: 40px auto;
            color: #fff;
            padding: 20px;
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
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);

        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1
        }

        .dropdown:hover .dropdown-content {
            display: block;
            left: 0px;
            top: 0px;
            position: absolute;
            margin: 0rem 0rem -4rem -4rem;

        }


        .hidden {
            display: none;
        }

        .game-head-btn-div a:hover {
            background: #fdb244;
        }

        .active-game-btn .card {
            background: #fdb244;
        }

        .breadcrumb-div {
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

    <style>
        .color-red {
            color: red;
        }

        .color-green {
            color: green;
        }

        .color-yellow {
            color: yellow;
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Redeem</p>
                                    <h5 class="font-weight-bolder total-redeem">
                                        +{{ $total['redeem'] }}
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
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Left</p>
                                    <h5 class="font-weight-bolder total-left">
                                        {{ count($grouped) }}
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
        </div>
    @endif
    <div class="row justify-content-center mt-5">
        <div class="col-md-12 card upCard">
            <div class="card-body">
                <div class="row">
                    {{-- @php echo $month; @endphp --}}
                    @foreach ($all_months as $m => $i)
                        <div class="col-2 game-head-btn-div">
                            {{-- @if (isset($games) && !empty($games)) --}}
                            @if ($month < 10)
                                @php
                                    $z = str_replace('0', '', $month);
                                @endphp
                           @else
                              @php
                                 $z = $month;
                              @endphp
                            @endif
                            @if ($z == $m)
                                @php
                                    $current_month = $i;
                                @endphp
                            @endif
                            <a href="{{ '/redeem-history?year=' . $year . '&month=' . $m . ($sel_cat ? '&category=' . $sel_cat : '') }}"
                                class="btn btn-success w-100 mb-1 {{ $z == $m ? 'active-game-btn' : '' }}">
                                {{ $i }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row justify-content-center mt-5">
   <div class="col-md-12 card upCard">
      <div class="card-body">
         <div class="row">
            <div class="col-2 game-head-btn-div">  
               <a href="{{ route('monthlyHistory').'?year='.$year.'&month='.$z}}" class="btn btn-success w-100 mb-1 {{($sel_cat == '')?'active-game-btn':''}}" class="btn btn-success w-100 mb-1">
                  All
               </a>
            </div>
            @foreach ($game_categories as $gc => $c) 
            <div class="col-2 game-head-btn-div">  
               <a href="{{ route('monthlyHistory').'?year='.$year.'&month='.$z.'&category='.$c->name}}" class="btn btn-success w-100 mb-1 {{($c->name == $sel_cat)?'active-game-btn':''}}" class="btn btn-success w-100 mb-1">
                  {{$c->name}}
               </a>
            </div>
            @endforeach
         </div>
      </div>
   </div>
</div> --}}
    <div class="row" id="werqwerq" style="padding-top:20px;">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 datatableCustom">
                            <thead class="sticky">
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        SN</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Previous</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Name</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Redeem Amount</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Balance</th>
                                    {{-- @if (Auth::user()->role == 'admin')
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Updated By
                                          </th>
                                    @endif --}}
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Status</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="verified-table">
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($grouped as $key => $item)
                                    <tr class="tr-{{ $item['form']['id'] }}" data-all="0">
                                        <td class="align-middle text-center" style="text-align: center">{{ $count++ }}
                                        </td>
                                        <td class="align-middle text-center" style="text-align: center">
                                            {{-- {{$current_month.' ,'.$key}} --}}
                                            @if (!empty($item['redeemstatus1']))
                                                @if ($item['redeemstatus1']['status'] == 1)
                                                    <i class="fa fa-circle color-green" style="margin-right: 5px;"></i>
                                                @elseif($item['redeemstatus1']['status'] == 2)
                                                    <i class="fa fa-circle color-red" style="margin-right: 5px;"></i>
                                                @else
                                                    <i class="fa fa-circle color-yellow" style="margin-right: 5px;"></i>
                                                @endif
                                            @else
                                                <i class="fa fa-circle color-yellow" style="margin-right: 5px;"></i>
                                            @endif

                                            @if (!empty($item['redeemstatus2']))
                                                @if ($item['redeemstatus2']['status'] == 1)
                                                    <i class="fa fa-circle color-green" style="margin-right: 5px;"></i>
                                                @elseif($item['redeemstatus2']['status'] == 2)
                                                    <i class="fa fa-circle color-red" style="margin-right: 5px;"></i>
                                                @else
                                                    <i class="fa fa-circle color-yellow" style="margin-right: 5px;"></i>
                                                @endif
                                            @else
                                                <i class="fa fa-circle color-yellow" style="margin-right: 5px;"></i>
                                            @endif
                                            @if (!empty($item['redeemstatus3']))
                                                @if ($item['redeemstatus3']['status'] == 1)
                                                    <i class="fa fa-circle color-green"></i>
                                                @elseif($item['redeemstatus3']['status'] == 2)
                                                    <i class="fa fa-circle color-red"></i>
                                                @else
                                                    <i class="fa fa-circle color-yellow"></i>
                                                @endif
                                            @else
                                                <i class="fa fa-circle color-yellow"></i>
                                            @endif
                                            {{-- {{$item['form']['full_name']}} --}}
                                        </td>
                                        <td class="align-middle text-center" style="text-align: center">
                                            {{-- {{$current_month.' ,'.$key}} --}}
                                            {{ $item['form']['full_name'] }}
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge  bg-gradient-success">{{ $item['redeem'] }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge  bg-gradient-success">{{ $item['totalLoad'] }}</span>
                                        </td>


                                        {{-- @if (Auth::user()->role == 'admin')
                                            <td class="align-middle text-center creator-{{ $item['form']['id'] }}">
                                                {{ !empty($item['creator']) ? $item['creator']['name'] : '' }}
                                            </td>
                                        @endif --}}
                                        <td class="align-middle text-center">
                                            <select class="form-control status-change"
                                                data-parent="tr-{{ $item['form']['id'] }}"
                                                data-id="{{ $item['form']['id'] }}" name=""
                                                id="status-{{ $count }}">
                                                <option value="0">Select Status</option>
                                                @foreach ($status as $a => $b)
                                                    <option
                                                        {{ !empty($item['redeemstatus']['status']) && $item['redeemstatus']['status'] == $b['id'] ? 'selected' : '' }}
                                                        value="{{ $b['id'] }}">{{ ucwords($b['name']) }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="#popup1" class="this-day-redeem btn btn-primary"
                                                data-form="{{ $item['form']['id'] }}" data-year="{{ $year }}"
                                                data-month="{{ $month }}" data-day="{{ $key }}"
                                                data-category="{{ $sel_cat ? $sel_cat : 'all' }}"
                                                href="javascript:void(0);">
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
                                                                        <div class="row w-100"
                                                                            style="justify-content: space-around;">
                                                                            {{-- <h6>Authors table</h6> --}}
                                                                            @foreach ($game_categories as $gc => $c)
                                                                                <div
                                                                                    class="col-lg-2 col-md-6 game-popup game-categories-wrapper">
                                                                                    <button
                                                                                        class="btn btn-success history-type-change-btn-allDate1 game-category {{ $c->name == $sel_cat ? 'active-game-btn' : '' }}"
                                                                                        data-year="{{ $year }}"
                                                                                        data-month="{{ $month }}"
                                                                                        data-day="" data-type="all"
                                                                                        data-category="{{ $c->name }}">{{ $c->name }}</button>
                                                                                    <div
                                                                                        class="game-category-info reset-to-blank">
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <input type="hidden" name="type"
                                                                            class="user-current-game-history-input">
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
                                                                        <button
                                                                            class="filter-history btn btn-primary hidden"
                                                                            data-userId="" data-game="">Go</button>
                                                                        {{-- </div> --}}
                                                                        {{-- </div> --}}
                                                                        <div class="table-responsive p-0">
                                                                            <table class="table align-items-center mb-0">
                                                                                <thead class="sticky">
                                                                                    <tr>
                                                                                        <th
                                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Time</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Amount</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            FB Name</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Game</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Game ID</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Creator</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="user-history-body">

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
                                            {{-- <button class="btn btn-primary">View</button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                                {{-- @php
                      dd($doubt);
                  @endphp --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="werqwerq" style="padding-top:20px;">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                    {{-- data-parent="tr-{{$item['form']['id']}}" data-id="{{$item['form']['id']}}" --}}
                    <select class="form-control search-undo" name="" id="status-{{ $count }}">
                        <option value="0">All</option>
                        <option value="1">Verified</option>
                        <option value="2">Doubtful</option>

                    </select>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 datatable">
                            <thead class="sticky">
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        SN</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Previous</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Name</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Amount</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Balance</th>
                                    @if (Auth::user()->role == 'admin')
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Updated By</th>
                                    @endif
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Status</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="doubful-table">
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($doubt as $key => $item)
                                    <tr class="doubtful-tr tr-{{ $item['form']['id'] }}" data-all="0"
                                        data-status="{{ !empty($item['redeemstatus']['status']) ? $item['redeemstatus']['status'] : '' }}">
                                        <td class="align-middle text-center" style="text-align: center">
                                            {{ $count++ }}</td>
                                        <td class="align-middle text-center" style="text-align: center">
                                            {{-- {{$current_month.' ,'.$key}} --}}
                                            @if (!empty($item['redeemstatus1']))
                                                @if ($item['redeemstatus1']['status'] == 1)
                                                    <i class="fa fa-circle color-green" style="margin-right: 5px;"></i>
                                                @elseif($item['redeemstatus1']['status'] == 2)
                                                    <i class="fa fa-circle color-red" style="margin-right: 5px;"></i>
                                                @else
                                                    <i class="fa fa-circle color-yellow" style="margin-right: 5px;"></i>
                                                @endif
                                            @else
                                                <i class="fa fa-circle color-yellow" style="margin-right: 5px;"></i>
                                            @endif

                                            @if (!empty($item['redeemstatus2']))
                                                @if ($item['redeemstatus2']['status'] == 1)
                                                    <i class="fa fa-circle color-green" style="margin-right: 5px;"></i>
                                                @elseif($item['redeemstatus2']['status'] == 2)
                                                    <i class="fa fa-circle color-red" style="margin-right: 5px;"></i>
                                                @else
                                                    <i class="fa fa-circle color-yellow" style="margin-right: 5px;"></i>
                                                @endif
                                            @else
                                                <i class="fa fa-circle color-yellow" style="margin-right: 5px;"></i>
                                            @endif
                                            @if (!empty($item['redeemstatus3']))
                                                @if ($item['redeemstatus3']['status'] == 1)
                                                    <i class="fa fa-circle color-green"></i>
                                                @elseif($item['redeemstatus3']['status'] == 2)
                                                    <i class="fa fa-circle color-red"></i>
                                                @else
                                                    <i class="fa fa-circle color-yellow"></i>
                                                @endif
                                            @else
                                                <i class="fa fa-circle color-yellow"></i>
                                            @endif
                                            {{-- {{$item['form']['full_name']}} --}}
                                        </td>
                                        <td class="align-middle text-center" style="text-align: center">
                                            {{-- {{$current_month.' ,'.$key}} --}}
                                            {{ $item['form']['full_name'] }}
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge  bg-gradient-success">{{ $item['redeem'] }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge  bg-gradient-success">{{ $item['totalLoad'] }}</span>
                                        </td>
                                        @if (Auth::user()->role == 'admin')
                                            <td class="align-middle text-center creator-{{ $item['form']['id'] }}">
                                                {{ !empty($item['creator']) ? $item['creator']['name'] : '' }}
                                            </td>
                                        @endif
                                        <td class="align-middle text-center">
                                            <select class="form-control status-change"
                                                data-parent="tr-{{ $item['form']['id'] }}"
                                                data-id="{{ $item['form']['id'] }}" name=""
                                                id="status-{{ $count }}">
                                                <option value="0">Select Status</option>
                                                @foreach ($status as $a => $b)
                                                    <option
                                                        {{ !empty($item['redeemstatus']['status']) && $item['redeemstatus']['status'] == $b['id'] ? 'selected' : '' }}
                                                        value="{{ $b['id'] }}">{{ ucwords($b['name']) }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="#popup1" class="this-day-redeem btn btn-primary"
                                                data-form="{{ $item['form']['id'] }}" data-year="{{ $year }}"
                                                data-month="{{ $month }}" data-day="{{ $key }}"
                                                data-category="{{ $sel_cat ? $sel_cat : 'all' }}"
                                                href="javascript:void(0);">
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
                                                                        <div class="row w-100"
                                                                            style="justify-content: space-around;">
                                                                            {{-- <h6>Authors table</h6> --}}
                                                                            @foreach ($game_categories as $gc => $c)
                                                                                <div
                                                                                    class="col-lg-2 col-md-6 game-popup game-categories-wrapper">
                                                                                    <button
                                                                                        class="btn btn-success history-type-change-btn-allDate1 game-category {{ $c->name == $sel_cat ? 'active-game-btn' : '' }}"
                                                                                        data-year="{{ $year }}"
                                                                                        data-month="{{ $month }}"
                                                                                        data-day="" data-type="all"
                                                                                        data-category="{{ $c->name }}">{{ $c->name }}</button>
                                                                                    <div
                                                                                        class="game-category-info reset-to-blank">
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <input type="hidden" name="type"
                                                                            class="user-current-game-history-input">
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
                                                                        <button
                                                                            class="filter-history btn btn-primary hidden"
                                                                            data-userId="" data-game="">Go</button>
                                                                        {{-- </div> --}}
                                                                        {{-- </div> --}}
                                                                        <div class="table-responsive p-0">
                                                                            <table class="table align-items-center mb-0">
                                                                                <thead class="sticky">
                                                                                    <tr>
                                                                                        <th
                                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Time</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Amount</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            FB Name</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Game</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Game ID</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Creator</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="doubful-table2">

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
    @php
        $year = '';
        $month = '';
        if (isset($_GET['year'])) {
            $year = $_GET['year'];
        }
        if (isset($_GET['month'])) {
            $month = $_GET['month'];
        }
    @endphp
    <script>
      $('.datatableCustom').DataTable({
        "pageLength": 100
      });
        $(function() {
            $(".search-undo").on("change", function() {
                var value = $(this).val().toLowerCase();
                if (value != 0) {
                    $(".doubful-table > tr").filter(function() {
                        $(this).toggle($(this).attr('data-status').indexOf(value) > -1)
                    });
                } else {
                    // value = 'all';
                    $(".doubful-table > tr").filter(function() {
                        $(this).toggle($(this).attr('data-all').indexOf(value) > -1)
                    });
                }
            });
        });

        $(document).on('change', '.status-change', function(e) {
            var itemParent = $(this).attr('data-parent');
            var cid = $(this).attr('data-id');
            var newVal = $(this).val();
            var year = '{{ $year }}';
            var month = '{{ $month }}';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            var actionType = "POST";
            var ajaxurl = '/redeem-status';
            $.ajax({
                type: actionType,
                url: ajaxurl,
                data: {
                    "id": cid,
                    "year": year,
                    "month": month,
                    "redeem_status": newVal
                },
                dataType: 'json',
                beforeSend: function() {},
                success: function(data) {
                    var data2 = JSON.parse(JSON.stringify(data));
                    // $($(this).attr('data-parent')).remove;'
                    var oldCount = parseInt($('.total-left').text());
                    if (data2.status == "2" || data2.status == "1") {
                        var item = $('.' + itemParent);
                        $('.' + itemParent).remove();
                        $('.doubful-table').prepend(item);
                        var newCount = oldCount - 1;
                    } else {
                        var item = $('.' + itemParent);
                        $('.' + itemParent).remove();
                        $('.verified-table').prepend(item);
                        var newCount = oldCount + 1;
                    }

                    $(item).addClass('doubtful-tr');
                    $(item).attr('data-status', data2.status);
                    $('.creator-' + cid).text(data2.created_by);
                    if (newCount <= 0) {
                        newCount = 0;
                    }
                    $('.total-left').text(newCount);
                    toastr.success('Status Changed', data.responseText);

                },
                error: function(data) {
                    toastr.error('Error', data.responseText);
                }
            });
        });

        $(document).on('click', '.this-day-redeem', function(e) {
            console.log('asdf');
            var month_symbols = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                'September', 'October', 'November', 'December'
            ];
            var year = $(this).attr("data-year");
            var month = $(this).attr("data-month");
            var day = $(this).attr("data-day");
            var form = $(this).attr("data-form");
            var category = $(this).attr("data-category");
            $('.history-type-change-btn-allDate1').attr('data-day', day);
            $('.history-type-change-btn-allDate1.game-category').removeClass('active-game-btn');
            $('.history-type-change-btn-allDate1.game-type').removeClass('active-game-btn');
            $('.history-type-change-btn-allDate1.game-category').attr('data-type', 'all');
            $('.history-type-change-btn-allDate1.game-category[data-category="' + category + '"]').addClass(
                'active-game-btn');
            $('.history-type-change-btn-allDate1.game-type').attr('data-category', category);
            $('.history-type-change-btn-allDate1.game-type[data-type="all"]').addClass('active-game-btn');
            $('.game-category-info.reset-to-blank').html('');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            //   console.log(form);
            // console.log('1');
            var actionType = "POST";
            var ajaxurl = '/this-day-redeem';
            $.ajax({
                type: actionType,
                url: ajaxurl,
                data: {
                    "year": year,
                    "month": month,
                    "day": day,
                    "category": category,
                    'form': form
                },
                dataType: 'json',
                beforeSend: function() {
                    $(".user-history-body").html('Loading..');

                },
                success: function(data) {
                    var accounts = data.accounts;
                    var default_accounts = data.default_accounts;
                    $.each($('.history-type-change-btn-allDate1.game-category'), function() {
                        var that = $(this);
                        $.each(accounts, function(index, value) {
                            if (value.game_name == that.attr('data-category')) {
                                that.siblings('.game-category-info.reset-to-blank')
                                    .html('\
                                Game Title: ' + value.game_title + '\
                                <br>Game Balance: ' + value.game_balance + '\
                                <br>Redeem: ' + value.totals.redeem + '\
                                ');
                            } else if (that.siblings(
                                    '.game-category-info.reset-to-blank').html() ==
                                '') {
                                $.each(default_accounts, function(index, value) {
                                    if (value.name == that.attr(
                                        'data-category')) {
                                        that.siblings(
                                            '.game-category-info.reset-to-blank'
                                            ).html('\
                                        Game Title: ' + value.title + '\
                                        <br>Game Balance: ' + value.balance + '\
                                        <br>Redeem: 0\
                                        ');
                                    }
                                });
                            }
                        });
                    });
                    if (data.grouped != '') {
                        var optionLoop = '',
                            options = data.grouped;
                        var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug",
                            "Sep", "Oct", "Nov", "Dec"
                        ];
                        options.forEach(function(index, value) {
                            if (value == 0) {
                                $('h2.popup-title').html('History of ' + index.form.full_name);
                            }
                            var date_format = new Date(index.created_at),
                                redeem = parseInt(index.amount);
                            // var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                            var a = date_format.toLocaleString('en-US', {
                                hour: 'numeric',
                                minute: 'numeric',
                                hour12: true
                            });
                            optionLoop +=
                                '<tr><td class="text-center">' + a + '</td>\
                                <td class="text-center"><span class="badge  bg-gradient-success"> ' + index.amount + '$</span></td>\
                                <td class="text-center">' + index.form.facebook_name + '</td>\
                                <td class="text-center">' + index.account.name + '</td>\
                                <td class="text-center">' + index.form_game.game_id + '</td>\
                                <td class="text-center">' + index.created_by.name + '</td></tr>';
                        });

                    } else {
                        optionLoop = '<tr><td>No History</td></tr>';
                    }
                    $(".user-history-body").html(optionLoop);

                },
                error: function(data) {
                    toastr.error('Error', data.responseText);
                }
            });
        });
    </script>
@endsection
