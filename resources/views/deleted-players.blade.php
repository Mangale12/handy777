@extends('layouts.app')

@section('content')
<div class="card-body">
                <div class="row justify-content-between">
                        <h2> Total deleted players: {{$count}}</h2>
                @include('butt')
                 </div>
                </div>
  <div class="table-responsive">
                     <!--id="datatable-crud"-->
                    <table class="table datatable" style="font-size:14px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Note</th>
                                <th>Game ID</th>
                                <th>Number</th>
                                <th>Mail</th>
                                <th>Facebook ID</th>
                                <th>State</th>
                                <th>Referrer Id</th>
                                <th>Month Completed</th>
                                <th>Next-Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                         <tbody>
                   @php
                   $count = 1;
                   @endphp
                  @foreach($forms as $num)
                  <tr>
                    <td scope="row" data-editable="false"><b>{{$count++}}</b></th>
                    <td>{{ucwords($num->full_name)}}</td>
                    <td class="class" data-id="{{$num->id}}">
                                {{($num->note)}}
                    </td>
                    <td>{{($num->game_id)}}</td>
                    <td>{{($num->number)}}</td>
                    <td>{{($num->email)}}</td>
                    <td>{{($num->facebook_name)}}</td>
                    <td>{{ucwords($num->mail)}}</td>
                    <td>{{($num->r_id)}}</td>
                    <td>{{($num->count)}}</td>
                    <td>{{($num->intervals)}}</td>
                     <td> 
                     
                         <a href="{{route('forms.restore',['id'=>$num->id])}}" class="btn btn-success">
                            <i class="fa fa-undo"></i>
                        <!--</a>-->
                        
                        <!--{{route('forms.destroy',['id'=>$num->id])}}-->
                         <a href="{{route('forms.fdestroy',['id'=>$num->id])}}" class="btn btn-danger delete-form">
                            <i class="fa fa-trash"></i>
                        </a>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
                    </table>
                </div>
@endsection