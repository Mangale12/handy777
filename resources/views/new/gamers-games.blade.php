@extends('layouts.newLayout')

@section('title')
    Gamer & Games
@endsection
@section('content')
@php
    use Carbon\Carbon;
@endphp
<style>
    .count-row{
        font-weight: 700;
    }
</style>
<div class="row justify-content-center">
            <div class="col-md-12 card">
                <div class="card-body">
                <div class="row justify-content-between">
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg1">Restore</button> -->
                 
                 </div>
                </div>
                <div class="table-responsive" style="overflow-x:auto;">
                     <!--id="datatable-crud"-->
                    <table class="table datatable" style="font-size:14px">
                        <thead>
                            <tr>
                                    <th style="width: 26.328100000000006px!important;">No</th>
                                    <th class="cus-width">Full Name</th>
                                    <th class="cus-width">Number</th>
                                    <th class="cus-width">Email</th>
                                    <th class="cus-width">Fb ID</th>
                                    <th class="cus-width">CashApp</th>
                                    <th class="cus-width">Balance Load</th>
                            </tr>
                        </thead>
                         <tbody>
                   @php
                    $count = 1;
                   @endphp
                  @foreach($forms as $num)
                  <tr class="tr-{{$num['form_id']}}">
                    <td class="count-row">{{$count++}}</th>
                    <td class="td-full_name-{{$num['form_id']}}">{{ucwords($num['full_name'])}}</td>
                    <td class="td-game_id-{{$num['form_id']}}">{{($num['number'])}}</td>
                    <td class="td-game_id-{{$num['form_id']}}">{{($num['email'])}}</td>
                    <td class="td-facebook_name-{{$num['form_id']}}">{{($num['facebook_name'])}}</td>
                    <td class="td-cashAppLoad-{{$num['form_id']}}">{{($num['totals']['cashAppLoad'])}}</td>
                    <td class="td-load-{{$num['form_id']}}">{{($num['totals']['load'])}}</td>

                  </tr>
                  @endforeach
               </tbody>
                    </table>
                </div>

                </div>
            </div>
    </div>
@endsection

