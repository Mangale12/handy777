@extends('layouts.appcolab')


@section('content')
    <style>
    .datatable th{
        background-color: #04AA6D;
    }
    .datatable td, .datatable th {
        text-align:center;
      border: 1px solid #ddd;
      padding: 8px;
    }
    .badge{
        font-size: 15px!important;
        padding: 5px 14px 5px 15px!important;
    }
</style>
<div class="px-5">
   <div class="row justify-content-center">
      <div class="col-12 card">
         <div class="card-header">{{ __('Noor Games') }}</div>
         @if ($message = Session::get('success'))
         <div class="alert alert-success">
            <p>{{ $message }}</p>
         </div>
         @endif
         <div class="card-body">
            <div class="row justify-content-between">
               <h2>{{$title}} {{$total}}</h2>
               @include('butt')
            </div>
         </div>
         <div class="table-responsive">
            <table class="table datatable">
               <thead>
                  <tr>
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
</div>
</div>
<script>
    $('.confirm-delete').on('click', function () {
  var link = $(this).attr("href");
//   $(document).on('click', '.confirm-delete', function () {
       ans = confirm('Are you sure you want to delete this?');
       if (ans == true) {
           window.location = link;
       } else {
           return false;
       }
   });
   $(document).ready( function () {
       $('table').editableTableWidget();
       
       $('table td').on('change', function(evt, newValue) {
        var type = "POST";
        
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        
             $.ajax({
                type: type,
                url: '/saveNote',
                data: {
                    "cid": $(this).data('id'),
                    "note" : newValue
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    toastr.success('Success',"Note Saved");
                    
                },
                error: function (data) {
                    console.log(data);
                    toastr.error('Error',data.responseText);
                }
            });
           console.log(newValue);
           console.log($(this).data('id'));
           });
    });
</script>
@endsection