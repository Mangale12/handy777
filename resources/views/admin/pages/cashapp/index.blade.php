@extends('admin.layout.app')
@section('content')
    <div class="col-lg-9 col-md-6 ml-auto">
        
        <div class="clearfix">
            <div class="pull-left"><h2 class="text-white">CashApp Setting</h2></div>
            <div class="pull-right"><h4 class="text-white"><a href="{{ route('cashapp.create') }}"><button class="btn btn-dark">CashApp</button></a></h4></div>
        </div>
        <div class="sidebar-content p-4">
            <table class="w-100 table-striped">
                <tr class="text-center">
                    <th>Id</th>
                    <th>Title</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                @foreach ($cashapp as $cashapps)
                <tr class="text-center">
                    <td>{{ $loop->iteration++ }}</td>
                    <td>{{ $cashapps->title }}</td>
                    <td>{{ $cashapps->balance }}</td>
                    <td>{{ $cashapps->status }}</td>

                    <td>
                        
                        <form action="{{ route('cashapp.destroy',$cashapps->id) }}" method="POST">
                            <a href="{{ route('cashapp.edit',$cashapps->id) }}"><i class="fa fa-edit text-white mr-4"></i></a>
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" onclick="return confirm('Sure Want Delete?')" style="border : none; background-color:transparent;"><i class="fa fa-trash text-white " ></i></button>
                        </form>
                           
                    </td>
                </tr>
            @endforeach

                </tr>
            </table>
        </div>

    </div>
    </div>
    <script>
        function del()
        {
            alert('hh');
        }
        @if(Session::has('message'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.success("{{ session('message') }}");
        @endif
      
        @if(Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.error("{{ session('error') }}");
        @endif
      
        @if(Session::has('info'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.info("{{ session('info') }}");
        @endif
      
        @if(Session::has('warning'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.warning("{{ session('warning') }}");
        @endif
      </script>
@endsection
