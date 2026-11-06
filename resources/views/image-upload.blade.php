@extends('layouts.app')

@section('content')

<div class="card">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" id="myBtn">
        Add Image
      </button>
    <div class="card-header">
      Add Image
    </div>
    <div class="card-body">
        <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Position</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @php
                    $image = \App\Models\Image::all();
                @endphp
                 @foreach ($image as $images)  
              <tr>
                
                <th scope="row">{{ $loop->iteration ++ }}</th>
                <td><img src="{{ asset('storage/app/'.$images->image) }}" alt="" height="70px" width="70px"></td>
                <td>{{ $images->position }}</td>
                <td>
                    <label class="switch">
                        <input onchange="update_image_published(this)" value="{{ $images->id }}" type="checkbox" <?php if($images->status == 1) echo "checked";?> >
                        <span class="slider round"></span></label></td>
                   </td>
                <td>
                <form action="{{ route('imageupload.destroy',$images->id) }}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    @csrf
                    <button type="submit" style="color:red" onclick="return confirm('Are you sure?')">Delete</button></td>
                </form>
              </tr>
              @endforeach
            </tbody>
          </table>
          
          
    </div>
  </div>
   
  <!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('imageupload.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image[]" multiple>
                        <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                      </div>
                  </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
  </div>
 
 
  <script>
  
     function update_image_published(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('image.update_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                showAlert('success', 'Image status updated successfully');
            }
            else{
                showAlert('danger', 'Maximum 4 image to be published');
            }
        });
    }
    
      </script>

@endsection

