@extends('newLayout.layouts.newLayout')

@section('title')
     Redeems 
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
       @if (Auth::user()->role == 'admin')

@endif
<div class="row" style="padding-top:20px;">
   <div class="col-12">
      <div class="card mb-4">
         <form action="{{route('redeems.filter')}}" method="post">
         <div class="row card-body px-0pt-0 pb-2" style="margin: 20px 0 0 0;">
            @csrf
            <div class="col-4 form-group">
               <input type="date" class="form-control" name="start_date">
            </div>
            <div class="col-4">
               <input type="date" class="form-control" name="end_date">
            </div>
            <div class="col-4">
               <button type="submit">Submit</button>
            </div>
         @if (isset($filter_start) && !empty($filter_start))
             Data Start : {{$filter_start}}
         @endif
         @if (isset($filter_end) && !empty($filter_end))
             Data End : {{$filter_end}}
         @endif
         </div>
      </form>
      </div>
   </div>
  <div class="col-12">
     <div class="card mb-4">
        <div class="card-body px-0 pt-0 pb-2">
           <div class="table-responsive p-0">
              <table class="table align-items-center mb-0 datatable">
                 <thead class="sticky" >
                    <tr  >
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">SN</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Full Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Amount</th>
                    </tr>
                 </thead>
                 <tbody class="user-history-body">                          
                  @php
                    $count = 1;
                  @endphp
                  @foreach ($history as $key => $item)   
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
                                <h6 class=" mb-0 text-sm">{{$item['form']['full_name']}}</h6>
                            </div>
                          </div>
                       </td>
                       <td class="align-middle text-center ">
                          <span class="badge  bg-gradient-success">{{$item['sum']}}</span>
                       </td>
                    </tr>
                  @endforeach
                 </tbody>
              </table>
           </div>
        </div>
     </div>
  </div>
</div>
@endsection

