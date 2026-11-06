@extends('cashier.layout.app')
@section('content')
<div class="col-lg-9 col-md-6 ml-auto">
        
    <div class="clearfix">
        <div class="pull-left"><h2 class="text-white">CashApp Setting</h2></div>
        <div class="pull-right"><h4 class="text-white"><a href="{{ route('cashapp.create') }}"><button class="btn btn-dark">CashApp</button></a></h4></div>
    </div>
    <div class="sidebar-content p-4">
        <table class="w-100 table-striped" id="table">
            <thead>
                <tr class="text-center">
                    <th>Id</th>
                    <th>Title</th>
                    <th>Balance</th>
                    <th>Status</th>
                </tr>
            </thead> 
            @foreach ($cashapp as $cashapps)
            <tbody>
            <tr class="text-center">
                <td>{{ $loop->iteration++ }}</td>
                <td>{{ $cashapps->title }}</td>
                <td class="class" data-id="{{ $cashapps->id }}">{{ $cashapps->balance }}</td>
                <td>{{ $cashapps->status }}</td>
               
            </tr>
        </tbody>
        @endforeach

            </tr>
        </table>
    </div>

</div>
<script>
 

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
                url: '/updateBalance',
                data: {
                    "cid": $(this).data('id'),
                    "balance" : newValue
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    toastr.success('Success',"Balance Update");
                    
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