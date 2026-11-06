@extends('admin.layout.app')
@section('content')

<section id="dashboard-wrapper" class="position-relative">
    <div class="container-fluid">
      <div class="row sidebar-content">
        <!-- Grid Cards -->
        <div class="grid-container">
          <div class="grid-item">
              @foreach ($image as $images)
            <img src="{{ asset($images->image) }}" alt="winner-image" class="img-fluid" width="500px" height="500px">
              @endforeach
          </div>  
        </div>
        <!-- Grid Cards Ends -->
      </div>
    </div>
  </section>
  
@endsection