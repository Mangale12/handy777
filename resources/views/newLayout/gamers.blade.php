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
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg1">Restore</button>
               <button  class="btn  btn-primary" style="background-color:#1100ff; margin-right: -54rem; margin-left: 1rem;">
                            <a href="{{ route('admin.add_players') }}" style="color:white;">Add New Player</a>
                        </button>
           
           </div>
           <div class="table-responsive p-4">
              <table class="table align-items-center mb-0 datatable">
                 <thead class="sticky" >
                    <tr  >
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Action</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Full Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Code</th>
                       <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Date Joined</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Note</th>
                        @if (Auth::user()->role == 'admin')
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Number</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Email</th>
                        @endif
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Fb ID</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Game ID</th>
                       <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Total Load</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Total Redeem</th>
                         <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Total tips</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">State</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Ref Id</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Months</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Next-Date</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Messenger Id</th>
                    </tr>
                 </thead>
                 <tbody class="user-history-body">                          
                  @php
                    $count = 1;
                  @endphp
                  @foreach($forms as $num)
                    <tr class="tr-{{$num->id}}" style="text-align: center">
                       <td class="count-row align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$count++}}</h6>
                             </div>
                          </div>
                       </td>
                       <td class="align-middle text-center ">
                              <a href="javascript:void(0);" data-id="{{$num->id}}" class="btn btn-success edit-form padding-5">
                                <i class="fa fa-edit font-13"></i>
                            </a>
                            <a href="javascript:void(0);" data-id="{{$num->id}}" class="btn btn-danger delete-form padding-5">
                                <i class="fa fa-trash font-13"></i>
                            </a>
                            <a href="javascript:void(0);" data-id="{{$num->id}}" class="btn btn-info history-form padding-5" data-toggle="modal" data-target="#historyModal{{$num->id}}">
                                <i class="fa fa-history font-13"></i>
                            </a>
                       </td>
                       <td class="td-full_name-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{ucwords($num->full_name)}}</h6>
                            </div>
                          </div>
                       </td>
                       <td class="td-full_name-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$num->latestCode->code ?? '-'}}</h6>
                            </div>
                          </div>
                       </td>
                         <td class="td-intervals-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{date('d M,Y', strtotime($num->created_at))}}</h6>
                            </div>
                          </div>
                       </td>
                       <td class="class td-note-{{$num->id}} align-middle text-center " data-id="{{$num->id}}">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{($num->note)}}</h6>
                            </div>
                          </div>
                       </td>
                       @if (Auth::user()->role == 'admin')
                       <td class="td-game_id-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{($num->number)}}</h6>
                            </div>
                          </div>
                       </td>
                       <td class="td-game_id-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{($num->email)}}</h6>
                            </div>
                          </div>
                       </td>
                        @endif
                       <td class="td-facebook_name-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{($num->facebook_name)}}</h6>
                             </div>
                          </div>
                       </td>
                       
                       {{-- <td class="td-game_id-{{$num->id}}" align-middle text-center ">
                          <span class="badge  bg-gradient-success">{{($num->email)}}</span>
                       </td> --}}
                       <td class="td-game_id-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{($num->game_id)}}</h6>
                            </div>
                          </div>
                       </td>
                       <td class="td-facebook_name-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$num->getLoadSum()}}</h6>
                             </div>
                          </div>
                       </td>
                       <td class="td-facebook_name-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$num->getRedeemSum()}}</h6>
                             </div>
                          </div>
                       </td>
                       <td class="td-facebook_name-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$num->getTipsSum()}}</h6>
                             </div>
                          </div>
                       </td>
                       <td class="td-mail-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{ucwords($num->mail)}}</h6>
                            </div>
                          </div>
                       </td>
                       <td class="td-r_id-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{($num->r_id)}}</h6>
                             </div>
                          </div>
                       </td>
                       <td class="td-r_id-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{($num->count)}}</h6>
                            </div>
                          </div>
                       </td>
                       {{-- <td class="td-count-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">1</h6>
                            </div>
                          </div>
                       </td> --}}
                       <td class="td-intervals-{{$num->id}} align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{date('d M,Y', strtotime($num->intervals))}}</h6>
                            </div>
                          </div>
                       </td>
                       <td> 
                        <input type="text" class="form-control messenger-id" data-id="{{ $num->id }}" placeholder="messanger id"> 
                      </td>
                       {{-- <td class="td-intervals-{{$num->id}} align-middle text-center ">
                          <span class="badge  bg-gradient-success">1</span>
                       </td> --}}
                       {{-- <td class="align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">1</h6>
                            </div>
                          </div>
                       </td> --}}
                    </tr>
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


<!-- Modal for History -->
<div class="modal history-modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel">History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Search by Date Form -->
                <form id="dateSearchForm" class="mb-3">
                    <div class="form-group row">
                        <label for="searchDate" class="col-sm-2 col-form-label">Search Date:</label>
                        <div class="form-group col-3">
                            <label for="startDate">Start Date</label>
                            <input type="date" class="form-control" id="first_date">
                        </div>
                        
                        <div class="form-group col-3">
                            <label for="endDate">End Date</label>
                            <input type="date" class="form-control" id="end_date">
                        </div>

                        
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary history-by-date">Search</button>
                        </div>
                    </div>
                </form>

                <!-- Table of History -->
                <table class="table table-bordered history-table" >
                    <thead>
                        
                    </thead>
                    <tbody id="history-table">
                        <!-- Table rows will be populated dynamically based on search results -->
                    </tbody>
                    <tfoot>
                        
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
     $(document).ready(function(){
      $(document).on('change', '.messenger-id', function(e) {
          e.preventDefault();

          var id = $(this).data('id'); // Get the ID from data attribute
          var messenger_id = $(this).val();
          $.ajax({
                url: '{{ route("messenger-id") }}',
                method: 'POST',
                data: { 
                    form_id: id, 
                    messenger_id:messenger_id,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    toastr.success('Messenger id added succesfully !');
                },
                error: function(error) {
                    toastr.error('Messenger id added unsuccesful !');
                }
            });
      });

         function searchByDate(id, first_date, end_date) {
            $.ajax({
                url: '{{ route("player.fetch-history") }}',
                method: 'GET',
                data: { 
                    first_date: first_date, 
                    id: id,
                    end_date: end_date,
                },
                success: function(response) {
                    console.log(response);

                    // Clear existing table
                    $('#history-table').empty();

                    // Generate dynamic table headers for types
                    const uniqueTypes = [...new Set(response.map(item => item.type))];
                    let tableHeader = `
                        <tr>
                            <th>Game</th>`;
                    uniqueTypes.forEach(type => {
                        tableHeader += `<th>${type}</th>`;
                    });
                    tableHeader += `</tr>`;
                    $('#history-table').append(tableHeader);

                    // Group data by game
                    const groupedByGame = response.reduce((acc, curr) => {
                        if (!acc[curr.account.name]) {
                            acc[curr.account.name] = {};
                        }
                        acc[curr.account.name][curr.type] = curr.total_loaded;
                        return acc;
                    }, {});

                    // Populate rows dynamically
                    for (const [game, types] of Object.entries(groupedByGame)) {
                        let row = `<tr><td>${game}</td>`;
                        uniqueTypes.forEach(type => {
                            row += `<td>${types[type] || 0}</td>`;
                        });
                        row += `</tr>`;
                        $('#history-table').append(row);
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
          }

          var player_id = null;
          $('.history-form').on('click', function() {
              var id = $(this).data('id');
              var first_date = $('#first_date').val();
              var end_date = $('#end_date').val();
              player_id = id;
              $('.history-modal').modal('show');

              searchByDate(id, first_date, end_date);
          });

        
        $('.history-by-date').on('click', function(){
            var id = player_id;
            var first_date = $('#first_date').val();
            var end_date = $('#end_date').val();
            searchByDate(id,first_date, end_date);
        })
      });
      
      

</script>


@endsection

