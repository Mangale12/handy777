@extends('newLayout.layouts.newLayout')

@section('title')
    Game Images
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    {{-- <div class="card-header">{{ __('Edit Noorgamers') }}</div> --}}

                    <div class="card-body">

                        <form action="{{ route('gameExtraImageStore') }}" method="POST"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            </br>
                            <input style="display:none;" type=""hidden" value="{{$game->id}}" name="id">
                            <div class="row">
                                <div class="col">
                                    <span>Images</span>
                                    <input type="file" name="file[]" class="form-control" id="image" multiple>
                                </div>
                            </div>
                            </br>
                               <div class="row">
                                    <div class="col">
                                        @if ($game->extra_images != '')
                                            @php                                            
                                                $images = explode(',',$game->extra_images);
                                            @endphp
                                            <div class="row">
                                                @foreach ($images as $key => $item)
                                                <div class="col-lg-2 col-md-2 col-sm-6">
                                                    <img style="max-width: 100%;min-height: 150px;max-height: 150px;object-fit: contain;" src="{{asset('public/uploads/games/'.$item)}}" alt="">
                                                    <a href="{{route('gameImage.destroy',['id'=> $game->id,'key'=>$key])}}" class="btn btn-danger confirm-delete">
                                                        <i class="fa fa-trash"></i>Delete
                                                    </a>
                                                    {{-- <a href="javascript:void(0)" class="delete-extra btn btn-primary">Delete</a> --}}
                                                </div>
                                                @endforeach
                                            </div>
                                        @else
                                            'No Images'
                                        @endif
                                        
                                    </div>

                            </div>
                            </br></br>
                            <button type="submit" class="btn btn-primary mb-2">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

                    @endsection
@section('script')
<script>
$(document).ready( function () {
 $('.confirm-delete').on('click', function (e) {
            e.preventDefault();
 var link = $(this).attr("href");
 Swal.fire({
            title: 'Are you sure you want to delete this?',
            showDenyButton: true,
            showCancelButton: true,
            showConfirmButton: false,
            // confirmButtonText: 'Save',
              denyButtonText: `Delete`,
            }).then((result) => {
                if (result.isConfirmed) {
                } 
                else if (result.isDenied) {
                    window.location = link;
                }
            });
    // ans = confirm('Are you sure you want to delete this?');
    // if (ans == true) {
    //     window.location = link;
    // } else {
    //     return false;
    // }
});
});
</script>
@endsection
