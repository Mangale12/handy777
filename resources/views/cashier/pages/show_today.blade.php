@extends('cashier.layout.app')
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
                    <th>No</th>
                    <th>Name</th>
                    <th>Facebook Name</th>
                    <th>Game ID</th>
                   
                    <th>Month Completed</th>
                    <th>Date Joined</th>
                    <th>Action</th>
                </tr>
            </thead>
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
@endsection