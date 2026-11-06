@php
// dd($_GET);
    if(isset($_GET['date']) && !empty($_GET['date'])){
        session()->put('tableDate',$_GET['date']);
    }
@endphp
<style>
  /* position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0,0,0,0.5);
  z-index: 1000;
  cursor: pointer;
} */
</style>
<div id="overlay" onclick="off()"></div>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="">

                    <h6>Just Search The Player Name </h6>
                    
                    <button  class="btn  btn-primary mb-0 datepickeTrigger" style="background-color:#00ff00;"> 
                        <span>[ Selected Date : {{((isset($_GET['date']) && !empty($_GET['date']))?session()->get('tableDate'):'')}} ]</span> 
                        <input name="tableDate" id="tableDate" style="position: absolute;clip: rect(0,0,0,0);">
                    </button>
                </div>
                <div class="row pb-3">
                    <div class="col-8">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="text" class="form-control search-user" id="search-user" placeholder="Search User">
                        </div>
                    </div>
                    <div class="col-4">
                        <button  class="btn  btn-primary mb-0" style="background-color:#FF9800;">
                            <a href="#popup33" style="color:white;" onclick="add_class('show');">ADD USER</a>
                        </button>
                        <button  class="btn  btn-primary mb-0 undo-transaction" style="background-color:#1100ff;">
                            <a href="#popup7" style="color:white;">Undo</a>
                        </button>
                       
                        <div id="popup7" class="overlay" style="max-widtzh:100%; width:100%;">
                            <div class="popup">
                                <h2>Undo Transaction</h2>
                                <a class="close" href="#">&times;</a>
                                <div class="content ">
                                    <div class="row" style="padding-top:20px;">
                                        <div class="col-12">
                                                <label for="filter-type12">TYPE:</label>
                                                <select id="filter-type12" name="type" id="" class="filter-type12">
                                                    <option value="all">All</option>
                                                    <option value="load">Load</option>
                                                    <option value="redeem">Redeem</option>
                                                    <option value="refer">Bonus</option>
                                                    <option value="tip">Tip</option>
                                                </select>

                                                <label for="filter-game12">Game:</label>
                                                <select id="filter-game12" name="game" id="filter-game12" class="filter-game12">
                                                    <option value="all">All</option>                         --}}
                                                      @foreach (\App\Models\Account::get()->toArray() as $key => $item)    
                                                      <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                      @endforeach
                                                   </select>

                                                <label for="cars">User:</label>
                                                <!--select2 -->
                                                <select id="filter-user12" name="user" id="filter-user12" class="filter-user12">
                                                    <option value="all">All</option>
                                                    {{-- @if (isset($forms) && !empty($forms))                              --}}
                                                    @foreach (\App\Models\Form::get()->toArray() as $key => $item)      
                                                    <option value="{{$item['id']}}">{{(empty($item['facebook_name']))?'Empty':$item['facebook_name']}}</option>
                                                    @endforeach
                                                    {{-- @endif --}}
                                                </select>

                                                <label for="filter-start12">Start Date:</label>
                                                <input id="filter-start12" type="date" name="start" class="filter-start12">

                                                <label for="filter-end12">End Date:</label>
                                                <input id="filter-end12" type="date" name="end" class="filter-end12">
                                                
                                                <button class="btn btn-primary filter-undo">Filter</button>
                                        </div>
                                        <div class="col-12">
                                            <div class="card mb-4">
                                                <div class="card-body px-0 pt-0 pb-2">
                                                    <input type="text" class="search-undo" placeholder="Search Here..">
                                                    <button class="btn btn-danger delete-bulk"><i class="fa fa-trash"></i> </button>
                                                    <div class="table-responsive p-0">
                                                        <table class="table table-responsive align-items-center mb-0">
                                                            <thead class="sticky" >
                                                                <tr>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">                
                                                                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                                                                        </button>
                                                                    </th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">FB Name</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Game</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Game Id</th>
                                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amoount</th>
                                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created By</th>
                                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action by</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody  style="text-align: center!important;" class="undo-history-body undo-history-body123">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div >
                            </div >
                        </div >
                    </div>
                </div>
                <div id="popup33" class="overlay">
                    <div class="popup">
                        <h2>User</h2>
                        <a class="close" href="#">&times;</a>
                        <div class="content ">
                            <label for="cars">User: Full Name [ Facebook Name ]</label>
                            <form action="{{route('addUser')}}" method="post">
                                @csrf
                                <input type="hidden" name="account_id" value="{{$activeGame['id']}}">
                                <select name="id" id="id" class="select2" required>
                                    @if (isset($forms) && !empty($forms))
                                    @foreach($forms as $a => $num)
                                    <option value="{{$num['id']}}">{{$num['full_name']}}  [{{(!empty($num['facebook_name'])?$num['facebook_name']:'empty')}}]</option>
                                    @endforeach
                                    @else
                                    <option disabled>No Users</option>
                                    @endif
                                </select>
                                <br>
                                <label for="cars">Game Id:</label>
                                <input class="form-control" type="text" name="game_id" id="game_id" required>
                                {{-- <input class="form-control" type="text" value=""> --}}
                                <br>
                                <button class="btn  btn-primary mb-0 " style="background-color:#FF9800;"  >ADD</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2" style="background: #ffff!important">
            <div class="table-responsive p-0 authorTable">
                @include('newLayout.components.listTable')
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="add-new-player" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@section('script')
<script>

   // start Muniraj
    $(function(){
      $("#popup33").find(".select2").select2({
               dropdownParent: $('#popup33')
           });
    });
    
    function add_class(class_name){
        $("#popup33").addClass(class_name);
        $("#popup33 .my_select2").select2();
       
    }
    // End Muniraj
$('#tableDate').datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'mm/dd/yy',
    beforeShow: function (input, inst) {
        var wWidth = $(window).width();
        var wHeight = $(window).height();
        setTimeout(function () {
	        inst.dpDiv.css({ top: (wHeight/2) - ($('#ui-datepicker-div').height()/2), left: (wWidth/2) - ($('#ui-datepicker-div').width()/2), backgroundColor: "#00ff00", padding: "10px", position:"fixed", borderRadius: "5px", zIndex: 1001 });
        }, 0);
    }
})

function off() {
  document.getElementById("overlay").style.display = "none";
}

$('.datepickeTrigger').click(function() {
    document.getElementById("overlay").style.display = "block";
    $('#tableDate').datepicker('show');
});
    $(document).on('change','#tableDate',function(){
        window.location.replace('/table?date='+$(this).val());
    });
    
    $(document).on('click','.add-new-player', function(){
        $('#add-new-player').modal('show');
    })
</script>
@endsection
