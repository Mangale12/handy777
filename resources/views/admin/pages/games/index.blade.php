@extends('admin.layout.app')
@section('content')
<style>
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color:  #5a5b7f;
}

input:focus + .slider {
  box-shadow: 0 0 1px  #5a5b7f;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
    <div class="col-lg-9 col-md-6 ml-auto">

        <div class="clearfix">
            <div class="pull-left"><h2 class="text-white">Games Setting</h2></div>
            <div class="pull-right"><h4 class="text-white"><a href="{{ route('store.games') }}"><button class="btn btn-dark"> Games</button></a></h4></div>
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
                @foreach ($account as $accounts)
                    <tr class="text-center">
                        <td>{{ $loop->iteration++ }}</td>
                        <td>{{ $accounts->title }}</td>
                        <td>{{ $accounts->balance }}</td>
                        <td>
                            <label class="switch">

                        <input onchange="update_game_status(this)" value="{{ $accounts->id }}" type="checkbox" <?php if($accounts->status == "active") echo "checked";?> >
                                <span class="slider round"></span>
                              </label>
                        </td>
                        <td>
                            <a href="{{ route('edit.games',$accounts->id) }}" ><i class="fa fa-edit text-white mr-4"></i></a>
                            <a href="{{ route('del.games',$accounts->id) }}" onclick="return confirm('Are you sure?');"><i class="fa fa-trash text-white"></i></a>
                        </td>
                    </tr>
                @endforeach

                </tr>
            </table>
        </div>

    </div>
    </div>
    <script>
       function update_game_status(el)
        {
            if(el.checked){
            var status = "active";
        }
        else{
            var status = "inactive";
        }
        $.post('{{ route('games.update_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == "active"){
                alert('success', 'Game status updated successfully');
            }
            else{
                alert('danger', 'Error');
            }
        });
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
