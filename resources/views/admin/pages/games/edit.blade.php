@extends('admin.layout.app')
@section('content')

<div class="col-lg-9 col-md-3 ml-auto">
    <div class="clearfix">
        <div class="pull-left"><h2 class="text-white">Games Setting</h2></div>
        <div class="pull-right"><h4 class="text-white"><a href="{{ route('admin.games') }}"><button class="btn btn-dark">Back</button></a></h4></div>
    </div>

    <div class="sidebar-content p-4">
        <form action="{{ route('update.games',$account->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Title</label>
                    <input type="text" class="form-control" id="inputEmail4" value="{{ $account->title }}" name="title" placeholder="Title">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Balance</label>
                    <input type="number" class="form-control" id="inputPassword4" value="{{ $account->balance }}" name="balance" placeholder="Balance">
                </div>
            </div>
            <button type="submit" class="btn btn-1 hover-filled-slide-up text-white px-5">
                <span>Update</span>
            </button>
        </form>
    </div>
</div>
<script>
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