<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8" />
</head>
{{-- @php
    echo "<pre>";
    print_r($final);
    die;
@endphp --}}
<body class="g-sidenav-show  bg-gray-100">
  <table class="table align-items-center mb-0">
     <thead class="sticky" >
        <tr  >
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">S. No.</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Full Name</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Fb Name</th>
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
            <td>{{ $loop->iteration  }}</td>
           <td class="align-middle text-center ">{{$item['full_name']}}</td>
           <td class="align-middle text-center ">{{$item['facebook_name']}}</td>

           {{-- <td class="align-middle text-center ">
              <button type="button" class="btn  btn-primary mb-0" style="background-color:#FF9800;">View</button>
           </td> --}}
        </tr>
      @endforeach
      {{-- {{ $old->links() }} --}}
     </tbody>
  </table>

</body>

<!--   Core JS Files   -->

<body>

</html>
