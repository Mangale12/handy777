@extends('newLayout.layouts.newLayout')

@section('title')
    Gamers
@endsection
@section('content')
@php
    use Carbon\Carbon;
@endphp
<style>
     td{
            border: none;
        }
    .count-row{
        font-weight: 700;
    }
</style>
<div class="row" style="padding-top:20px;">
  <div class="col-12">
     <div class="card mb-4">
        <div class="card-body px-0 pt-0 pb-2">
          <div class="d-flex justify-content-center pt-2">
              <a href="{{ route('user.create') }}"  class="btn btn-primary" >Create New</a>

           </div>
           <div class="table-responsive p-4">
              <table class="table align-items-center mb-0 datatable">
                 <thead class="sticky" >
                    <tr  >
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Email</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Role</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Action</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>

                    </tr>
                 </thead>
                 <tbody class="user-history-body">

                    @foreach ($users as $user)
                    <tr class="" style="text-align: center">
                        <td class="count-row align-middle text-center ">
                           {{ $loop->iteration }}
                        </td>
                        <td >
                            {{ $user->name }}
                         </td>
                         <td >
                            {{ $user->email }}
                         </td>

                         <td>
                            @foreach ($user->roles as $role)
                            {{ $role->name }}
                            @endforeach
                         </td>

                         <form id="deleteForm" action="{{route('user.destroy',$user->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <td class="project-actions">
                                <a class="btn btn-info btn-sm" href="{{route('user.edit',$user->id)}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <input onclick="confirmDelete(event)" class="btn btn-danger btn-sm" value="delete" />
                                    <i class="fas fa-trash">
                                    </i>
                                    Delete
                            </td>
                        </form>
                        <td><input type="checkbox" class="user-status" data-id="{{ $user->id }}" {{ $user->status == '1' ? "checked" : " " }}></td>
                     </tr>
                    @endforeach


                 </tbody>
              </table>
           </div>
        </div>
     </div>
  </div>
</div>
<script>
    let featured = Array.prototype.slice.call(document.querySelectorAll('.user-status'));
        featured.forEach(function(html) {
            let switchery = new Switchery(html,  { size: 'small' });
        });

</script>
<div class="modal fade bd-example-modal-lg editFormModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header" style="background: {{isset($color)?$color->color:'purple'}}">
            <h5 class="modal-title" id="exampleModalLabel" style="color: white">Edit User</h5>
            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-cross"></i> </button> --}}
          </div>
          <div class="modal-body editFormModalBody">
            <div class="appendHere">

            </div>
          </div>
          {{-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div> --}}
        </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Restore Deleted Gamers</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table">
              <thead >
                <tr>
                  <th class="text-center">S.N</th>
                  <th class="text-center">Deleted Date</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>

                      @php
                          $count = 1;
                      @endphp
                      @if (isset($trashed) && !empty($trashed))
                          @foreach ($trashed as $item)
                              <tr>
                                  <td>{{$count++}}</td>
                                  <td>{{date('D, M-d, Y [h:i:s a]', strtotime($item['deleted_at']))}}</td>
                                  <td>{{$item['full_name']}}</td>
                                  <td><a href="{{route('gamerRestore',['id' => $item['id']])}}" class="btn btn-primary">Restore</a> </td>
                              </tr>
                          @endforeach
                      @endif

               </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
    $('.user-status').on('change', function(evt, newValue) {
        var type = "POST";
        var status;
        if ($(this).prop('checked')==true){
            status = 1;
        }
        else{
         status = 0;
        }
        var user_id = $(this).data("id");
        // alert(user_id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                type: type,
                url: 'user-status',
                data: {
                    "status": status,
                    "user_id" : user_id,
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    toastr.success('Success',"user Status Updated Successfully");

                },
                error: function (data) {
                    console.log(data);
                    toastr.error('Error',data.responseText);
                }
            });
      });
    
    function confirmDelete(event) {
    // Display a confirmation dialog
    var result = confirm("Are you sure you want to delete this item?");
    
    // Check if the user clicked OK
    if (result) {
        // User confirmed, submit the form
        document.getElementById("deleteForm").submit();
    } else {
         e.preventDefault()
        // User clicked Cancel, do nothing
    }
}
</script>
@endsection

