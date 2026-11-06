@extends('newLayout.layouts.newLayout')
@section('title')
Table
@endsection
@section('content')
@php
    $date = isset($_GET['date'])?$_GET['date']:Carbon\Carbon::now();
@endphp
<script>
    var dateCustom = '{{$date}}';
</script>
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
        /*width: 50% ;*/
        width: 80% ;
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
    .game-btn-card:hover{
        background: #fdb244;
    }
    .active-game-btn .card{
        background: #fdb244;
    }
    /* body{
        background-image: url('{{asset('uploads/'.$activeGame['image'])}}');
        background-size: cover;
    } */
    .breadcrumb-div{
        background: #5e5050cc;
        padding: 5px;
    }
</style>
@include('newLayout.components.totalPlayer')
@include('newLayout.components.games')
@include('newLayout.components.aurthorTable')

</div>
{{-- Redeem History Modal --}}
<div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered" role="document">
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
                                                                            Balance  IN: <span class="total-balance">0</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card col-sm-12 col-md-12 col-lg-2">
                                                                        <div class="card-body">
                                                                            Redeem : <span class="total-redeem">0</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card col-sm-12 col-md-12 col-lg-2">
                                                                        <div class="card-body">
                                                                            Bonus : <span class="total-refer">0</span>
                                                                        </div>
                                                                    </div>
                                                                    <!--<div class="card col-sm-12 col-md-12 col-lg-2">-->
                                                                    <!--    <div class="card-body">-->
                                                                    <!--        Total Amount : <span class="total-amount">0</span>-->
                                                                    <!--    </div>-->
                                                                    <!--</div>-->
                                                                    <!--<div class="card col-sm-12 col-md-12 col-lg-2">-->
                                                                    <!--    <div class="card-body">-->
                                                                    <!--        Total Profit : <span class="total-profit">0</span>-->
                                                                    <!--    </div>-->
                                                                    <!--</div>-->
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
                                                                       // start Muniraj
                                                                        $(function(){
                                                                          $("#popup33").find(".select2").select2({
                                                                                   dropdownParent: $('#popup33')
                                                                               });
                                                                        });
                                                                        
                                                                        function add_class(class_name){
                                                                            $("#popup33").addClass(class_name);
                                                                            $("#popup33 .my_select2").select2();
                                                                           
                                                                        }
                                                                        // End Muniraj
                                                                            var time = '{{$time}}';
                                                                            function resetData(){
                                                                                $(".resetThis").each(function( index ) {
                                                                                    $(this).text('$ 0');
                                                                                    $(this).attr("data-balance",0);
                                                                                })
                                                                                //  toastr.success("Data Reset");
                                                                                //  console.log('asdfasdf');
                                                                            }
                                                                            resetData();
                                                                            // setInterval(resetData, 1000*time);
                                                                            //    var d = new Date();
                                                                            // var n = d.getTimezoneOffset();
                                                                            // var ans = new Date(d.getTime() + n * 60 * 1000);
                                                                            //    var d = new Date();
                                                                            //     var t = d.toLocaleTimeString();
                                                                            // console.log(t);
                                                                            // <script>
                                                                                // var x = '';
                                                                                // var x = new Date();
                                                                                //         $('.date-countdown').text(x);
                                                                                //  function display_c(){
                                                                                    //   var refresh=1000; // Refresh rate in milli seconds
                                                                                    //   mytime=setTimeout('display_ct()',refresh);
                                                                                    //   var d = new Date('<?php echo Carbon\Carbon::now().'   ('.config('app.timezone').')' ?>');
                                                                                    //   console.log(d);
                                                                                    // console.log(x);
                                                                                    //  }
                                                                                    //  function display_ct() {
                                                                                        // x = '<?php echo Carbon\Carbon::now().'   ('.config('app.timezone').')' ?>';
                                                                                        //   $('.date-countdown').text(x);
                                                                                        //   x = '';
                                                                                        //   display_c();
                                                                                        //  }
                                                                                        //  display_ct();
                                                                                    </script>
                                                                                    {{-- {{dd(Carbon\Carbon::now())}} --}}
                                                                                    @endsection
