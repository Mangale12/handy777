@extends('admin.layout.app')
@section('content')
<div class="col-lg-9 col-md-8 ml-auto">
    <button class="btn-glass text-white px-5 d-md-none d-block w-100 mb-2 border-0" data-toggle="modal" data-target="#leftsidebarfilter"> <span class="mr-2"><i class="fa fa-tachometer"
                aria-hidden="true"></i></span><span>Dashboard Menu</span>
    </button>
    <div class="sidebar-content sidebar-content2 p-4">
        <div style="overflow-x:auto;">
            <table class="w-100 table-striped datatable">
                <thead>
                <tr class="text-center">
                    <th scope="col">#</th>
                     <th scope="col">Date</th>
                     <th scope="col">Name</th>
                     <th scope="col">Note</th>
                     <th scope="col">CashApp Limit</th>
                     <th scope="col">Driving License</th>
                     <th scope="col">State</th>
                     <th scope="col">Crime</th>
                     <th scope="col">Score</th>
                     <th scope="col">Number</th>
                     <th scope="col">Actions</th>
                </tr>
            </thead>
                <tbody>
                    @php
                    $count = 1;
                    @endphp
                   @foreach($number as $num)
                   <tr>
                     <td scope="row" data-editable="false"><b>{{$count++}}</b></th>
                     <td data-editable="false">{{date_format($num->created_at, 'M d,Y H:i:s')}}</td>
                     <td data-editable="false">{{ucwords($num->extra_2)}}</td>
                     <td class="class" data-id="{{$num->id}}">
                                 {{($num->note)}}
                     </td>
                     <td data-editable="false">
                         @if($num->cash_app_send_limit == 'yes')
                             <span class="badge badge-success">{{ucwords($num->cash_app_send_limit)}}</span>
                         @else
                             <span class="badge badge-danger">{{ucwords($num->cash_app_send_limit)}}</span>
                         @endif
                     </td>
                     <td data-editable="false">
                         @if($num->driving_license == 'yes')
                             <span class="badge badge-success">{{ucwords($num->driving_license)}}</span>
                         @else
                             <span class="badge badge-danger">{{ucwords($num->driving_license)}}</span>
                         @endif
                     </td>
                     <td data-editable="false">{{ucwords($num->state)}}</td>
                     <td data-editable="false">
                         
                         @if($num->crime == 'yes')
                             <span class="badge badge-success">{{ucwords($num->crime)}}</span>
                         @else
                             <span class="badge badge-danger">{{ucwords($num->crime)}}</span>
                         @endif
                     </td>
                     <td data-editable="false">
                         
                         @if($num->extra_1 == 'yes')
                             <span class="badge badge-success">{{ucwords($num->extra_1)}}</span>
                         @else
                             <span class="badge badge-danger">{{ucwords($num->extra_1)}}</span>
                         @endif
                     </td>
                      <td data-editable="false"><a href="tel:{{$num->phone_number}}">{{$num->phone_number}}</a></td>
                      <td data-editable="false"> 
                      <a href="{{route('colab.edit',['id'=>$num->id])}}" class="btn btn-success">
                         <i class="fa fa-edit"></i>
                     </a>
                      <a href="{{route('colab.destroy',['id'=>$num->id])}}" class="btn btn-danger confirm-delete">
                         <i class="fa fa-trash"></i>
                     </a>
                      </td>
                   </tr>
                   @endforeach
                </tbody>
                
                
            </table>
        </div>

    </div>
</div>
@endsection