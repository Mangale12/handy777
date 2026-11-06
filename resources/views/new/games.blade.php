@extends('layouts.newLayout')

@section('title')
    Games
@endsection
@section('content')
@php
    use Carbon\Carbon;
@endphp
<style>
    .count-row{
        font-weight: 700;
    }
    .name-td,.status-td{
      text-transform:capitalize;
    }
</style>
<div class="row justify-content-center">
            <div class="col-md-12 card">
                <div class="card-body">
                <div class="row justify-content-between">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg1">
                      Add Game
                    </button>
                 
                 </div>
                </div>
                <div class="table-responsive p-4" style="overflow-x:auto;">
                     <!--id="datatable-crud"-->
                    <table class="table datatable" style="font-size:14px">
                        <thead>
                            <tr>
                                    <th style="width: 26.328100000000006px!important;">No</th>
                                    <th class="big-col">Action</th>
                                    <th class="cus-width">Image</th>
                                    <th class="cus-width">Name</th>
                                    <th class="cus-width">Title</th>
                                    <th class="cus-width">Balance</th>
                                    <th class="cus-width">Status</th>
                            </tr>
                        </thead>
                         <tbody>
                   @php
                   $count = 1;
                   @endphp
                  @foreach($forms as $num)
                  <tr class="tr-{{$num->id}}">
                    <td class="count-row">{{$count++}}</th>
                     <td class="display-inline-block">
                         <a href="javascript:void(0);" data-id="{{$num->id}}" class="btn btn-success edit-game padding-5">
                            <i class="fa fa-edit font-13"></i>
                        </a>
                         <a href="javascript:void(0);" data-id="{{$num->id}}" class="btn btn-danger delete-game padding-5">
                            <i class="fa fa-trash font-13"></i>
                        </a>
                        <a href="javascript:void(0);" data-id="{{$num->id}}" class="btn btn-warning image-game padding-5">
                           <i class="fa fa-image font-13"></i>
                       </a>
                     </td>
                     <td>
                       <img style="max-width: 100%" src="{{asset('uploads/'.$num->image)}}" alt="{{($num->name)}}">
                     </td>
                    <td class="name-td td-name-{{$num->id}}">{{($num->name)}}</td>
                    <td class="title-td td-title-{{$num->id}}">{{($num->title)}}</td>
                    <td class="td-balance-{{$num->id}}">{{($num->balance)}}</td>
                    <td class="status-td td-status-{{$num->id}}">
                      {{ucwords($num->status)}}
                    </td>

                  </tr>
                  @endforeach
               </tbody>
                    </table>
                </div>

                </div>
            </div>
    </div>
    <div class="modal fade bd-example-modal-lg editFormModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: {{isset($color)?$color->color:'purple'}}">
                  <h5 class="modal-title" id="exampleModalLabel" style="color: white">Edit User</h5>
                </div>
                <div class="modal-body editFormModalBody">
                  <div class="appendHere">

                  </div>
                </div>
              </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg editImageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: {{isset($color)?$color->color:'purple'}}">
                  <h5 class="modal-title" id="exampleModalLabel" style="color: white">Edit Image</h5>
                </div>
                <div class="modal-body editFormModalBody">
                  <div class="appendHere">
                    <form action="{{route('gameImageStore')}}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                        <input type="hidden" name="id" id="game-id-image" value="">
                        <div class="col-12 mt-2">
                          <label for="image" class="form-label">Image</label>
                          <input type="file" name="file" class="form-control" id="image">
                        </div>
                        <div class="col-12 mt-2">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
      
    <div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Games</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{route('gameStore')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-6">
                      <label for="name" class="form-label">Name</label>
                      <input required name="name" type="text" class="form-control" id="name" placeholder="Name">
                    </div>
                    <div class="col-6">
                      <label for="title" class="form-label">Title</label>
                      <input required name="title" type="text" class="form-control" id="title" placeholder="Title">
                    </div>
                    <div class="col-6 mt-2">
                      <label for="balance" class="form-label">Balance</label>
                      <input required name="balance" type="number" class="form-control" id="balance" placeholder="Balance">
                    </div>
                    <div class="col-6 mt-2">
                      <label for="status" class="form-label">Status</label>
                      <select required name="status" id="" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                      </select>
                    </div>
                    <div class="col-6 mt-2">
                      <label for="image" class="form-label">Image</label>
                      <input type="file" name="file" class="form-control" id="image">
                    </div>
                    <div class="col-12 mt-2">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
   
@endsection

@section('script')
<script>
      jQuery(document).ready( function () {
        
        $('.datatable tbody').on('click', '.image-game', function () {
          $('#game-id-image').val($(this).data('id'));
          $('.editImageModal').modal('show');
        });
        $('.datatable tbody').on('click', '.edit-game', function () {
            $('.editFormModal').modal('show');
            var cid = $(this).data('id');
                    $.ajax({
                        type: 'get',
                        url: "/games/edit/"+cid,
                        data: {
                            "cid": $(this).data('id'),
                        },
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            $('.appendHere').remove();
                            $('.editFormModalBody').append('<div class="appendHere"></div>');
                            $('.appendHere').append(data);
                            // $('#summernote').summernote();
                            // $( ".count-row" ).each(function( index ) {
                                // $(this).text((index+1));
                                // console.log( index + ": " + $( this ).text() );
                            // })
                            // toastr.success('Success',"Deleted");
                            
                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error('Error',data.responseText);
                        }
                    });
        });
        var link = $('.delete-form').attr("href");
        // var link = $('.delete-form');
        $('.datatable tbody').on('click', '.delete-game', function (e) {
            e.preventDefault();
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
                    var cid = $(this).data('id');
                    $.ajax({
                        type: 'get',
                        url: "/games/destroy/"+cid,
                        data: {
                            "cid": $(this).data('id'),
                        },
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            $('.tr-'+cid).remove();
                            $( ".count-row" ).each(function( index ) {
                                $(this).text((index+1));
                                // console.log( index + ": " + $( this ).text() );
                            });
                            toastr.success('Success',"Deleted");
                            
                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error('Error',data.responseText);
                        }
                    });
                    // window.location = link;
                }
            });
        });
      });
        
    </script>
@endsection

