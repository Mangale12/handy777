@extends('layouts.newLayout')

@section('title')
    Gamers
@endsection
@section('content')
@php
    use Carbon\Carbon;
@endphp
<style>
    .count-row{
        font-weight: 700;
    }
</style>
<div class="row justify-content-center">
            <div class="col-md-12 card">
                <div class="card-body">
                <div class="row justify-content-between">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg1">Restore</button>
                 
                 </div>
                </div>
                <div class="table-responsive" style="overflow-x:auto;">
                     <!--id="datatable-crud"-->
                    <table class="table datatable" style="font-size:14px">
                        <thead>
                            <tr>
                                    <th style="width: 26.328100000000006px!important;">No</th>
                                    <th class="big-col">Action</th>
                                    <th class="cus-width">Full Name</th>
                                    <th class="cus-width">Note</th>
                                    <th class="cus-width">Number</th>
                                    <th class="cus-width">Email</th>
                                    <th class="cus-width">Game ID</th>
                                    <th class="cus-width">Fb ID</th>
                                    <th style="width: 56.3125px!important;text-align:center;!important">State</th>
                                    <th class="cus-width">Ref Id</th>
                                    <th class="cus-width" style="width: 56.3125px!important;text-align:center;!important">Months</th>
                                    <th class="cus-width">Next-Date</th>
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
                     
                        <!-- <a href="{{url('forms/'.$num->id.'/edit')}}" class="btn btn-success">-->
                        <!--    <i class="fa fa-edit"></i>-->
                        <!--</a>-->
                        {{-- {{route('gamerEdit',['id'=>$num->id])}} --}}
                         <a href="javascript:void(0);" data-id="{{$num->id}}" class="btn btn-success edit-form padding-5">
                            <i class="fa fa-edit font-13"></i>
                        </a>
                        <!--{{route('forms.destroy',['id'=>$num->id])}}-->
                         <a href="javascript:void(0);" data-id="{{$num->id}}" class="btn btn-danger delete-form padding-5">
                            <i class="fa fa-trash font-13"></i>
                        </a>
                     </td>
                    <td class="td-full_name-{{$num->id}}">{{ucwords($num->full_name)}}</td>
                    <td class="class td-note-{{$num->id}}" data-id="{{$num->id}}">
                                {{($num->note)}}
                    </td>
                    <td class="td-game_id-{{$num->id}}">{{($num->number)}}</td>
                    <td class="td-game_id-{{$num->id}}">{{($num->email)}}</td>
                    <td class="td-game_id-{{$num->id}}">{{($num->game_id)}}</td>
                    <td class="td-facebook_name-{{$num->id}}">{{($num->facebook_name)}}</td>
                    <td class="td-mail-{{$num->id}}" style="width: 56.3125px!important;text-align:center;!important">{{ucwords($num->mail)}}</td>
                    <td class="td-r_id-{{$num->id}}">{{($num->r_id)}}</td>
                    <td class="td-count-{{$num->id}}" style="width: 56.3125px!important;text-align:center;!important">{{($num->count)}}</td>

                    <td class="td-intervals-{{$num->id}}">
                        {{-- {{(date_format(date($num->intervals), 'M d,Y H:i:s'))}} --}}
{{date('d M,Y', strtotime($num->intervals))}}
                        {{-- {{Carbon::parse('Y-m-d', $num->intervals)->format('M d Y H:i:s')}} --}}
                    </td>

                  </tr>
                  @endforeach
               </tbody>
                    </table>
                </div>

                </div>
            </div>
    </div>
    <div style="top: -200px;" class="modal fade bd-example-modal-lg editFormModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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

