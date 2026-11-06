@extends('newLayout.layouts.newLayout')

@section('title')
    Details of {{$form['full_name']}}
@endsection
@section('content')
@php
    use Carbon\Carbon;
    $settings = \App\Models\GeneralSetting::first()->toArray();
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
<div class="row justify-content-center">
            <div class="col-md-12 card">
                <div class="table-responsive p-4" style="overflow-x:auto;">
                     <!--id="datatable-crud"-->
                    <table class="table datatable" style="font-size:14px">
                        <thead>
                            <tr>
                              <th style="width: 26.328100000000006px!important;">No</th>
                              <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Game</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Game Id</th>                                    
                            </tr>
                        </thead>
                         <tbody>
                   @php
                    $count = 1;
                   @endphp
                   @if(isset($form_games) && !empty($form_games))
                      @foreach($form_games as $num)
                      <tr class="tr-{{$num['form_id']}}">
                        <td class="count-row">{{$count++}}</td>
                        <td class="text-center td-full_name-{{$num['form_id']}}">{{(isset($num['account']) && !empty($num['account']))?ucwords($num['account']['name']):''}}</td>
                        <td class="text-center class td-full_name-{{$num['form_id']}}" data-game="{{$num['account_id']}}" data-id="{{$num['form_id']}}">{{ucwords($num['game_id'])}}</td>
                      </tr>
                      @endforeach
                  @endif
               </tbody>
                    </table>
                </div>

                </div>
            </div>
    </div>
@endsection
@section('script')
<script>
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
                url: '/updateGameId',
                data: {
                    "cid": $(this).data('id'),
                    "accountId": $(this).data('game'),
                    "gameId" : newValue
                },
                dataType: 'json',
                success: function (data) {
                    toastr.success('Success',"Updated");
                    
                },
                error: function (data) {
                    toastr.error('Error',data.responseText);
                }
            });
           });
    });
</script>
@endsection

