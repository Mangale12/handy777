@extends('newLayout.layouts.newLayout')

@section('title')
    Logs
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


.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.7);
  transition: opacity 500ms;
  visibility: hidden;
  opacity: 0;
  z-index: 9999;
}
.overlay:target {
  visibility: visible;
  opacity: 1;
}


.popup {
  margin: 70px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 50% ;
  position: relative;
  transition: all 5s ease-in-out;
 
  

}

.popup h2 {
  margin-top: 0;
  color: #333;
  font-family: Tahoma, Arial, sans-serif;

}
.popup .close {
  position: absolute;
  top: 20px;
  right: 30px;
  transition: all 200ms;
  font-size: 30px;
  font-weight: bold;
  text-decoration: none;
  color: #333;

}
.popup .close:hover {
  color: #FF9800;
}
.popup .content {
  max-height: calc(100vh - 210px);
    overflow-y: auto;
}

@media screen and (max-width: 700px){
  .box{
    width: 70%;
  }
  .popup{
    width: 70%;
  }
}


</style>
<div class="row" style="padding-top:20px;">
  <div class="col-12">
     <div class="card mb-4">
        <div class="card-body px-0 pt-0 pb-2">
           <div class="table-responsive p-4">
              <table class="table align-items-center mb-0 datatable">
                 <thead class="sticky" >
                    <tr  >
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">SN</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Name</th>
                      {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Month</th> --}}
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Last Login Time</th>
                      {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Total Time</th> --}}
                      {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Action</th> --}}
                    </tr>
                 </thead>
                 <tbody class="user-history-body">                          
                  @php
                    $count = 1;
                  @endphp
                  @foreach($logs as $user_id=>$num)
                    {{-- @foreach($log as $key=>$num) --}}
                    <tr class="tr-{{$num['id']}}" style="text-align: center">
                       <td class="count-row align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$count++}}</h6>
                             </div>
                          </div>
                       </td>
                       <td class="count-row align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$num['user']['name']}}</h6>
                             </div>
                          </div>
                       </td>
                       {{-- <td class="count-row align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$all_months[ltrim($key, "0")]}}</h6>
                             </div>
                          </div>
                       </td> --}}
                       <td class="count-row align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                              <h6 class=" mb-0 text-sm">{{$num['login_time']}}</h6>
                             </div>
                          </div>
                       </td>
                       <td class="count-row align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                              <h6 class=" mb-0 text-sm">
                                 {{-- {{ $num['total_login_time']['d'] .'days '. $num['total_login_time']['h'] .'hrs '.  $num['total_login_time']['i'] .'mins '. $num['total_login_time']['s'] .'secs' }} --}}
                              </h6>
                             </div>
                          </div>
                       </td>
                       {{-- <td class="count-row align-middle text-center ">

                            <a href="#popup1" href="javascript:void(0);" class="btn this-month-logs btn-primary mb-0" style="background-color:#FF9800;" data-month="{{ltrim($key, "0")}}" data-userId="{{$user_id}}">View
                            </a>

                            <div id="popup1" class="overlay">
                              <div class="popup" style="width:95%">
                                 <h2 class="popup-title login-log-header">Login Log</h2>
                                 <a class="close" href="#">&times;</a>
                                 <div class="content ">
                                    <div class="row" style="padding-top:20px;">
                                       <div class="col-12">
                                          <div class="card mb-4">
                                             <div class="card-header pb-0">
                                                <div class="row w-100" style="justify-content: space-around;">
                                                <h6>Authors table</h6>
                                                </div>
                                             </div> 
                                             <div class="card-body px-0 pt-0 pb-2">
                                                <div class="table-responsive p-0">
                                                   <table class="table align-items-center mb-0">
                                                      <thead class="sticky" >
                                                         <tr  >
                                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Name</th>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time</th>
                                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Last Login Time</th>
                                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Time</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody  class="login-log-body">
                                                         
                                                      </tbody>
                                                   </table>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div >
                             </div >
                             </div>
                       </td> --}}
                    </tr>
                    {{-- @endforeach --}}
                  @endforeach
                 </tbody>
              </table>
           </div>
        </div>
     </div>
  </div>
</div>
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
      });

    $('.this-month-logs').on('click', function(e) {
        var month_symbols = ['','January', 'February', 'March', 'April', 'May', 'June', 'July', 'September', 'October', 'November', 'December'];
        var month = $(this).attr("data-month");
        var userId = $(this).attr("data-userId");
        $('.login-log-header').html('Login Log of month '+month_symbols[month]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "POST";
        var ajaxurl = "{{route('thisMonthLogs')}}";
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {
                "user": userId,
                "month": month,
            },
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(data) {
                
                console.log(data);
                if (data != '') {
                    var optionLoop = '',
                        monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    $.each(data, function(k,index) {
                        optionLoop +=
                            '<tr><td class="text-center">' + index.user_name + '</td>\
                            <td class="text-center">' + index.date + '</td>\
                            <td class="text-center">' + index.time + '</td>\
                            <td class="text-center">' + index.last_login_time + '</td>\
                            <td class="text-center">' + index.total_login_time.d + 'days ' + index.total_login_time.h + 'hrs ' + index.total_login_time.i + 'mins ' + index.total_login_time.s + 'secs' + '</td></tr>';
                    });

                } else {
                    optionLoop = '<tr><td>No Logs</td></tr>';
                }
                $(".login-log-body").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
    });
</script>
@endsection
