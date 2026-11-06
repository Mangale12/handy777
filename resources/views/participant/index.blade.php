@extends('newLayout.layouts.newLayout')

@section('title', $_panel.' List')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection
@section('content')
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
          <div class="col-sm-6"><h3 class="mb-0">{{ $_panel }} Tables</h3></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $_panel }} List</li>
            </ol>
          </div>
        </div>
        <!--end::Row-->
      </div>
      <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
          <div class="col-md-12">
            <div class="card mb-4">
             
            <div class="card-header d-flex justify-content-end">
    <a href="{{ Route::has($_base_route.'create') ? route($_base_route.'create') : '#' }}" class="btn btn-primary me-2">Add New</a>
    <a href="{{ Route::has('participants.spinner') ? route('participants.spinner') : '#' }}" class="btn btn-secondary">Spinner</a>
</div>

              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" id="list-table">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Participants</th>
                      <th>Winner</th>
                      
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @foreach($participants as $participant)
                      <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $participant->participants }}</td>
                        <td>{{ $participant->winner }}</td>
               
                        <td>
                          <a href="{{ route($_base_route.'edit', $participant->id) }}" class="btn btn-sm btn-primary">Edit</a>
                          <form action="{{ route($_base_route.'destroy', $participant->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                          </form>
                        </td>
                      
                      </tr>
                      @endforeach

                   
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              
            </div>
          </div>
        </div>
        <!--end::Row-->
      </div>
      <!--end::Container-->
    </div>
    <!--end::App Content-->
  </main>
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://kit.fontawesome.com/08292006d8.js" crossorigin="anonymous"></script>
<script>
  

</script>
@endsection