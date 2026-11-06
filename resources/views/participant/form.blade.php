@extends('newLayout.layouts.newLayout')
@section('css')
@endsection
@section('content')
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
          <div class="col-sm-6"><h3 class="mb-0"> Form</h3></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Create</li>
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
        <div class="row g-4">
          <!--begin::Col-->
          <div class="col-md-12">
            <!--begin::Quick Example-->
            <div class="card card-primary card-outline mb-4">
              <!--begin::Header-->
              <div class="card-header"><div class="card-title">Quick Example</div></div>
              <!--end::Header-->
              <!--begin::Form-->
                <form action="{{ route('participants.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="mb-3">
                          <label for="name">Name</label>
                         <textarea name="participants" class="form-control" id="users" placeholder="Enter participant names...Alice, Bob, Charlie, David, Eve..."></textarea>
                          <span class="text-danger">{{ $errors->first('participants') }}</span>
                         
                          </div>
                           

        
                          <div class="mb-3">

                            <label for="email">Winner Name</label>
                             <input type="text" class="form-control" id="winner" name="winner" placeholder="Enter winner's name">
                            
                            </div>
                            
                                
                              </div>
                              <!--end::Body-->

                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ isset($data['row']) ? 'Update' : 'Submit' }}</button>
                    </div>
                    <!--end::Footer-->
                </form>
              <!--end::Form-->
            </div>
            <!--end::Quick Example-->
          </div>
          <!--end::Col-->
          
        </div>
        <!--end::Row-->
      </div>
      <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>
  @endsection
  
@section('scripts')
@endsection