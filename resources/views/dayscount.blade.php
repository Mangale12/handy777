@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('30 Days Noor Gamers:') }}</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        {{-- @if ($message = Session::get('message'))

                        <div class="alert alert-success">

                            <p>{{ $message }}</p>

                        </div>

                    @endif --}}
                        <div class="row">

                            <div class="col-lg-12 margin-tb">

                                <div class="pull-left">

                                   
                                    
                                    <h2>Please press Update inorder to update the table if you see any data below: </h2>

                                </div>
 
                                <div class="pull-right">

                                    @include('butt')
                                

                                </div>

                            </div>

                        </div>







                        <table class="table table-responsive-striped">

                            <tr>

                                <th>No</th>
                                <th>Name</th>
                                <th>Facebook Name</th>
                                <th>Game ID</th>
                               
                                <th>Month Completed</th>
                                <th>Date Joined</th>
                                <th>Action</th>

                            </tr>

                            @foreach ($users as $product)

                                <tr>

                                    <td>{{ ++$i }}</td>
                                     <td>{{ $product->full_name }}</td>
                                    <td>{{ $product->facebook_name }}</td>
                                    <td>{{ $product->game_id }}</td>
                                  
                                
                               
                                    <td><span class="badge badge-success">{{ $product->count }}</span></td>
                                     <td>{{ $product->created_at }}</td>
                                    <td>
                                        <a href="{{ route('forms.sendmail', $product->id) }}" data-toggle="tooltip"
                                            data-original-title="Edit" class="edit btn btn-primary edit">
                                            Update
                                        </a>
                                       <form action="{{ route('forms.destroy',$product->id) }}" method="POST">

                    @csrf

                    @method('DELETE')

      

                    <button onclick="showAlert()" type="submit" class="btn btn-danger">Delete</button>

                </form>
                                    </td>



                                </tr>

                            @endforeach

                        </table>






                    </div>
                </div>
            </div>
        </div>
    </div>
      <script>
  function showAlert() {
    var myText = "Are you sure You want to remove !";
    alert (myText);
  }
  </script>
@endsection
