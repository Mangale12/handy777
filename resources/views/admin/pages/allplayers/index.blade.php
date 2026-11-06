@extends('admin.layout.app')
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
                    <th>Full Name</th>
                    <th>Note</th>
                    <th>Game ID</th>
                    <th>Facebook ID</th>
                    <th>State</th>
                    <th>Referrer Id</th>
                    <th>Month Completed</th>
                    <th>Next-Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $count = 1;
                @endphp
               @foreach($forms as $num)
               <tr>
                 <td scope="row" data-editable="false"><b>{{$count++}}</b></th>
                 <td>{{ucwords($num->full_name)}}</td>
                 <td class="class" data-id="{{$num->id}}">
                             {{($num->note)}}
                 </td>
                 <td>{{($num->game_id)}}</td>
                 <td>{{($num->facebook_name)}}</td>
                 <td>{{ucwords($num->mail)}}</td>
                 <td>{{($num->r_id)}}</td>
                 <td>{{($num->count)}}</td>
                 <td>{{($num->intervals)}}</td>
                  <td> 
                  
                     <!-- <a href="{{url('forms/'.$num->id.'/edit')}}" class="btn btn-success">-->
                     <!--    <i class="fa fa-edit"></i>-->
                     <!--</a>-->
                      <a href="{{route('forms.edit',['id'=>$num->id])}}" class="btn btn-success">
                         <i class="fa fa-edit"></i>
                     </a>
                     <!--{{route('forms.destroy',['id'=>$num->id])}}-->
                      <a href="{{route('forms.destroy',['id'=>$num->id])}}" class="btn btn-danger delete-form">
                         <i class="fa fa-trash"></i>
                     </a>
                  </td>
               </tr>
               @endforeach
            </tbody>
                
                
            </table>
        </div>

    </div>
</div>
<script>

    var link = $('.delete-form').attr("href");
      $('.delete-form').on('click', function () {
          ans = confirm('Are you sure you want to delete this?');
          if (ans == true) {
              window.location = link;
          } else {
              return false;
          }
      });
      
      $(document).ready( function () {
         $('table').editableTableWidget();
         
         $('table td').on('change', function(evt, newValue) {
          var type = "POST";
          
          
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              }
          });
          
               $.ajax({
                  type: type,
                  url: '/saveNoteForm',
                  data: {
                      "cid": $(this).data('id'),
                      "note" : newValue
                  },
                  dataType: 'json',
                  success: function (data) {
                      console.log(data);
                      toastr.success('Success',"Note Saved");
                      
                  },
                  error: function (data) {
                      console.log(data);
                      toastr.error('Error',data.responseText);
                  }
              });
             console.log(newValue);
             console.log($(this).data('id'));
             });
      });
  </script>
  <script type="text/javascript">
   
  $(document).ready( function () {
  // $.ajaxSetup({
  // headers: {
  // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  // }
  // });
  
  // $('#datatable-crud').DataTable({
  // responsive: true,
  // processing: true,
  // serverSide: true,
  // ajax: "{{ url('home') }}",
  // columns: [
      
  // { data: 'id', name: 'id' },
  // { data: 'full_name', name: 'full_name' },
  // { data: 'game_id', name: 'game_id' },
  // { data: 'facebook_name', name: 'facebook_name' },
  // // { data: 'number', name: 'number' },
  // { data: 'mail', name: 'mail' },
  // { data: 'r_id', name: 'r_id' },
  // { data: 'count', name: 'count' },
  // // { data: 'created_at', name: 'created_at' },
  // { data: 'intervals', name: 'intervals' },
  // // { data: 'email', name: 'email' },
  // // { data: 'note', name: 'note' },
  // {data: 'action', name: 'action', orderable: false},
  // ],
  // order: [[0, 'desc']]
  // });
  // $('body').on('click', '.delete', function () {
  // if (confirm("Delete Record?") == true) {
  // var id = $(this).data('id');
  
  // }
  // });
  // });
  </script>
@endsection