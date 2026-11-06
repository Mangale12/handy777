@extends('admin.layout.app')
@section('content')

<div class="col-lg-9 col-md-3 ml-auto">
    <div class="clearfix">
        <div class="pull-left"><h2 class="text-white">CashApp Setting</h2></div>
        <div class="pull-right"><h4 class="text-white"><a href="{{ route('cashapp.index') }}"><button class="btn btn-dark">Back</button></a></h4></div>
    </div>

    <div class="sidebar-content p-4">
        <form action="{{ route('cashapp.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Title</label>
                    <input type="text" class="form-control" id="inputEmail4" name="title" placeholder="Title">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Balance</label>
                    <input type="number" class="form-control" id="inputPassword4" name="balance" placeholder="Balance">
                </div>
            </div>
            <button type="submit" class="btn btn-1 hover-filled-slide-up text-white px-5">
                <span>Save</span>
            </button>
          
        </form>
    </div>
   
</div>

@endsection
<script>
   
         @if (Session::has('error'))
             toastr.error('{{ Session::get('error') }}');
         @elseif(Session::has('success'))
             toastr.success('{{ Session::get('success') }}');
         @endif

 
 </script>