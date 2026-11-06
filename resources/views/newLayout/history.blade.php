@extends('newLayout.layouts.newLayout')

@section('title')
     Dashboard 
@endsection
@section('content')
<style>
  .dataTables_wrapper{
    padding: 25px;
  }
  .dataTables_wrapper .row{
    padding: 10px;
  }
  tbody tr td{
    border-bottom: none;
  }
  select,
  input[type="date"]{
      max-width:100%;
  }
</style>
<div class="row" style="padding-bottom:20px;">
  <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
     <div >
        <div class="row">
           <div class="col-xl-3 col-md-6 col-sm-12 mb-xl-0 mb-4">
              <div class="card">
                 <div class="card-body p-3">
                    <div class="row">
                       <div class="col-12">
                          <div class="numbers">
                             <p class="text-sm mb-0 text-uppercase font-weight-bold"><label for="filter-type12">TYPE:</label></p>
                             <h5 class="font-weight-bolder">
                                <div class="dropdown">                   
                                  <select id="filter-type12" name="type" id="" class="filter-type12">
                                      <option value="all">All</option>
                                      <option value="load">Load</option>
                                      <option value="redeem">Redeem</option>
                                      <option value="refer">Bonus</option>
                                      <option value="tip">Tip</option>
                                      <!--<option value="cashAppLoad">Cash App</option>-->
                                  </select>
                                </div>
                             </h5>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="col-xl-3 col-md-6 col-sm-12 mb-xl-0 mb-4">
              <div class="card">
                 <div class="card-body p-3">
                    <div class="row">
                       <div class="col-12">
                          <div class="numbers">
                             <p class="text-sm mb-0 text-uppercase font-weight-bold"><label for="filter-game12">Game:</label></p>
                             <h5 class="font-weight-bolder">
                                <div class="dropdown">             
                                  <select id="filter-game12" name="game" id="filter-game12" class="filter-game12">
                                   <option value="all">All</option>
                                    @if (isset($games) && !empty($games))                             
                                     @foreach ($games as $key => $item)    
                                     <option value="{{$item['id']}}">{{$item['name']}}</option>
                                     @endforeach
                                    @endif
                                  </select>
                                </div>
                             </h5>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="col-xl-3 col-md-6 col-sm-12 mb-xl-0 mb-4">
              <div class="card">
                 <div class="card-body p-3">
                    <div class="row">
                       <div class="col-12">
                          <div class="numbers">
                             <p class="text-sm mb-0 text-uppercase font-weight-bold"><label for="cars">User:</label></p>
                             <h5 class="font-weight-bolder">
                                <div class="dropdown">             
                                  <select id="filter-user12" name="user" id="filter-user12" class="filter-user12">
                                   <option value="all">All</option>
                                    @if (isset($forms) && !empty($forms))                             
                                     @foreach ($forms as $key => $item)      
                                     <option value="{{$item['id']}}">{{(empty($item['facebook_name']))?'Empty':$item['facebook_name']}}</option>
                                     @endforeach
                                    @endif
                                  </select>
                                </div>
                             </h5>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="col-xl-3 col-md-6 col-sm-12 mb-xl-0 mb-4">
              <div class="card">
                 <div class="card-body p-3">
                    <div class="row">
                       <div class="col-12">
                          <div class="numbers">
                             <p class="text-sm mb-0 text-uppercase font-weight-bold"><label for="filter-start12">Start Date:</label></p>
                             <h5 class="font-weight-bolder">
                                <div class="dropdown">
                                  <input id="filter-start12" type="date" name="start" class="filter-start12">
                                </div>
                             </h5>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="col-xl-3 col-md-6 col-sm-12 mb-xl-0 mb-4">
              <div class="card">
                 <div class="card-body p-3">
                    <div class="row">
                       <div class="col-12">
                          <div class="numbers">
                             <p class="text-sm mb-0 text-uppercase font-weight-bold"><label for="filter-end12">End Date:</label></p>
                             <h5 class="font-weight-bolder">
                                <div class="dropdown">
                                  <input id="filter-end12" type="date" name="end" class="filter-end12">
                                </div>
                             </h5>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="col-xl-3 col-md-6 col-sm-12 mb-xl-0 mb-4">
              <div class="card">
                 <div class="card-body p-0">
                    <center>
                       <p class="text-sm mb-0 mt-3 text-uppercase font-weight-bold"><label for="cars">Action:</label></p>
                    </center>
                    <div class="d-flex justify-content-center">
                       <div style="width:45%">
                          <div class="numbers">
                             <div class="text-center">
                              <button class="filter-all-history user-all btn btn-primary mt-0 mb-3" data-userId="" data-game="" style="background-color:#FF9800;">Go</button>
                                {{-- <button type="filter-all-history user-all" data-userId="" data-game="" class="btn  btn-primary mt-0 mb-4" style="background-color:#FF9800;">Go</button> --}}
                             </div>
                          </div>
                       </div>
                       <div style="width:45%">
                          <div class="numbers">
                             <div class="text-center">
                              <a href="javascript:void(0);" class="export-file btn btn-primary mt-0 mb-3" style="background-color:#FF9800;">
                                 Export
                              </a>
                                {{-- <button type="button" class="btn  btn-primary  mt-4 mb-0" style="background-color:#FF9800;">Pdf</button> --}}
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
</div>
       @if (Auth::user()->role == 'admin')
<div class="row">
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
     <div class="card">
        <div class="card-body p-3">
           <div class="row">
              <div class="col-8">
                 <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Balance</p>
                    <h5 class="font-weight-bolder total-balance">
                      ${{$total['load']}}
                    </h5>
                 </div>
              </div>
              <div class="col-4 text-end">
                 <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
     <div class="card">
        <div class="card-body p-3">
           <div class="row">
              <div class="col-8">
                 <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Tip</p>
                    <h5 class="font-weight-bolder total-tip">
                      ${{$total['tip']}}
                    </h5>
                 </div>
              </div>
              <div class="col-4 text-end">
                 <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
     <div class="card">
        <div class="card-body p-3">
           <div class="row">
              <div class="col-8">
                 <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Redeem</p>
                    <h5 class="font-weight-bolder total-redeem">
                      +{{$total['redeem']}}
                    </h5>
                 </div>
              </div>
              <div class="col-4 text-end">
                 <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
  
  <div class="col-xl-3 col-sm-6">
     <div class="card">
        <div class="card-body p-3">
           <div class="row">
              <div class="col-8">
                 <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Profit</p>
                    <h5 class="font-weight-bolder total-profit">
                      ${{$total['load'] - $total['redeem']}}
                    </h5>
                 </div>
              </div>
              <div class="col-4 text-end">
                 <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
</div>
    
<div class="row" style="padding-top:40px;">
  <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
     <div class="card">
        <div class="card-body p-3">
           <div class="row">
              <div class="col-8">
                 <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Refer </p>
                    <h5 class="font-weight-bolder total-refer">
                      ${{$total['refer']}}
                    </h5>
                 </div>
              </div>
              <div class="col-4 text-end">
                 <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
</div>
@endif
<div class="row" style="padding-top:20px;">
  <div class="col-12">
     <div class="card mb-4">
        <div class="card-body px-0 pt-0 pb-2">
           <div class="table-responsive p-0">
            {{-- datatable --}}
              <table class="table align-items-center mb-0">
                 <thead class="sticky" >
                    <tr  >
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">SN</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Fb Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Game</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Game Id </th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Amount</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Type</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Creator</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Date</th>
                      {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Balance</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bonus</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Redeem</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tips</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th> --}}
                    </tr>
                 </thead>
                 <tbody class="user-history-body">                          
                  @php
                    $count = 1;
                  @endphp
                  @foreach ($final as $key => $item)   
                    <tr>
                       <td class="align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                             <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$count++}}</h6>
                             </div>
                          </div>
                       </td>
                       <td class="align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$item['form']['facebook_name']}}</h6>
                            </div>
                          </div>
                       </td>
                       <td class="align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$item['account']['name']}}</h6>
                            </div>
                          </div>
                       </td>
                       <td class="align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$item['form_game']['game_id']}}</h6>
                            </div>
                          </div>
                       </td>
                       <td class="align-middle text-center ">
                          <span class="badge  bg-gradient-success">{{$item['amount_loaded']}}</span>
                       </td>
                       <td class="align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{(($item['type'] == 'refer')?'bonus':$item['type'])}}</h6>
                            </div>
                          </div>
                       </td>
                       <td class="align-middle text-center ">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class=" mb-0 text-sm">{{$item['created_by']['name']}}</h6>
                            </div>
                          </div>
                       </td>
                       <td>
                          <h6 class=" mb-0 text-sm">{{date('d M,Y H:i:s', strtotime($item['created_at']))}}</h6>
                       </td>
                       {{-- <td class="align-middle text-center ">
                          <button type="button" class="btn  btn-primary mb-0" style="background-color:#FF9800;">View</button>
                       </td> --}}
                    </tr>
                  @endforeach
                  {{-- {{ $old->links() }} --}}
                 </tbody>
              </table>
           </div>
        </div>
     </div>
  </div>
</div>
@endsection

