@extends('newLayout.layouts.newLayout')

@section('title')
     Dashboard
@endsection
@section('content')
<style>
    table {
    margin: 1em 0;
    border-collapse: collapse;
    border: 0.1em solid #d6d6d6;
    }
    caption {
    text-align: left;
    font-style: italic;
    padding: 0.25em 0.5em 0.5em 0.5em;
    }
    th,
    td {
    padding: 0.25em 0.5em 0.25em 1em;
    vertical-align: text-top;
    text-align: left;
    text-indent: -0.5em;
    }
    th {
    vertical-align: bottom;
    background-color: #666;
    color: #fff;
    }
    tr:nth-child(even) th[scope=row] {
    background-color: #f2f2f2;
    }
    tr:nth-child(odd) th[scope=row] {
    background-color: #fff;
    }
    tr:nth-child(even) {
    background-color: rgba(0, 0, 0, 0.05);
    }
    tr:nth-child(odd) {
    background-color: rgba(255, 255, 255, 0.05);
    }
 </style>
 <style>
    #timedate {
    font: small-caps lighter auto/150% "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
    text-align:left;
    margin: 40px auto;
    color:#fff;
    padding: 20px ;
    }
 </style>
 <style>
    .dropbtn {
    background-color: #ffb342;
    color: white;
    padding: 20px;
    width:auto;
    font-size: 16px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    }
    .dropbtn:hover, .dropbtn:focus {
    background-color:#ff9f0f ;
    }
    .dropdown {
    position: relative;
    display: inline-block;
    }
    .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    }
    .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    }
    .dropdown a:hover {background-color: #ddd;}
    .show {display: block;}
 </style>
 @if (Auth::user()->hasRole("Admin"))
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Balance</p>
                <h5 class="font-weight-bolder">
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
                <h5 class="font-weight-bolder">
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
                <h5 class="font-weight-bolder">
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
                <h5 class="font-weight-bolder">
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
    <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Refer </p>
                <h5 class="font-weight-bolder">
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

    <!--<div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">-->
    <!--  <div class="card">-->
    <!--    <div class="card-body p-3">-->
    <!--      <div class="row">-->
    <!--        {{-- <div class="col-8">-->
    <!--          <div class="numbers">-->
    <!--            <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Amount</p>-->
    <!--            <h5 class="font-weight-bolder">-->
    <!--              +{{$total['cashAppLoad']}}-->
    <!--            </h5>-->

    <!--          </div>-->
    <!--        </div> --}}-->
    <!--        <div class="col-4 text-end">-->
    <!--          <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">-->
    <!--            <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->

    <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Cloud Gamers</p>
                  <h5 class="font-weight-bolder">
                    +{{$formCount}}
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
</div>


  <div class="row mt-4">
    <div class="col-lg-7 mb-lg-0 mb-4">
      <div class="card z-index-2 h-100">
        <div class="card-header pb-0 pt-3 bg-transparent">
          <h6 class="text-capitalize">Sales overview</h6>
          <p class="text-sm mb-0">
            <i class="fa fa-arrow-up text-success"></i>
            <span class="font-weight-bold">4% more</span> in 2021
          </p>
        </div>
        <div class="card-body p-3">
          <div class="chart">
            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>

     <div class="col-lg-5">
      <div class="card">
        <div class="card-header pb-0 p-3">
          <h6 class="mb-0">All Games</h6>
        </div>
        <div class="card-body p-3">
          <ul class="list-group">
              @if (isset($games) && !empty($games))
                  @foreach ($games as $a => $num)
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                            <i class="ni ni-mobile-button text-white opacity-10"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark text-sm">{{($num['name'])}}</h6>
                            <span class="text-xs">{{($num['balance'])}}</span>
                        </div>
                        </div>
                        <div class="d-flex">
                        <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                        </div>
                    </li>
                  @endforeach
              @endif
          </ul>
        </div>
      </div>
    </div>


  </div>
  @endif
   <div class="row">
    <!--<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">-->
    <!--  <div class="card">-->
    <!--    <div class="card-body p-3">-->
    <!--      <div class="row">-->
    <!--        <div class="col-8">-->
    <!--          <div class="numbers">-->
    <!--            <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Balance</p>-->
    <!--            <h5 class="font-weight-bolder">-->
    {{-- <!--              ${{$total['load']}}--> --}}
    <!--            </h5>-->

    <!--          </div>-->
    <!--        </div>-->
    <!--        <div class="col-4 text-end">-->
    <!--          <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">-->
    <!--            <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->
    <!--<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">-->
    <!--  <div class="card">-->
    <!--    <div class="card-body p-3">-->
    <!--      <div class="row">-->
    <!--        <div class="col-8">-->
    <!--          <div class="numbers">-->
    <!--            <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Tip</p>-->
    <!--            <h5 class="font-weight-bolder">-->
    {{-- <!--              ${{$total['tip']}}--> --}}
    <!--            </h5>-->

    <!--          </div>-->
    <!--        </div>-->
    <!--        <div class="col-4 text-end">-->
    <!--          <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">-->
    <!--            <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->
    <!--<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">-->
    <!--  <div class="card">-->
    <!--    <div class="card-body p-3">-->
    <!--      <div class="row">-->
    <!--        <div class="col-8">-->
    <!--          <div class="numbers">-->
    <!--            <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Redeem</p>-->
    <!--            <h5 class="font-weight-bolder">-->
    {{-- <!--              +{{$total['redeem']}}--> --}}
    <!--            </h5>-->

    <!--          </div>-->
    <!--        </div>-->
    <!--        <div class="col-4 text-end">-->
    <!--          <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">-->
    <!--            <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->

</div>
<div class="row" style="padding-top:40px;">



<a href ={{route('gamers')}}>
    <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Noor Gamers</p>
                  <h5 class="font-weight-bolder">
                    +{{$formCount}}
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
    </a>
</div>


  <div class="row mt-4">


     <div class="col-lg-5">
      <div class="card">
        <div class="card-header pb-0 p-3">
          <h6 class="mb-0">All Games</h6>
        </div>
        <div class="card-body p-3">
          <ul class="list-group">
              @if (isset($games) && !empty($games))
                  @foreach ($games as $a => $num)
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                            <i class="ni ni-mobile-button text-white opacity-10"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark text-sm">{{($num['name'])}}</h6>
                            <span class="text-xs">{{($num['balance'])}}</span>
                        </div>
                        </div>
                        <a href="{{route('games')}}">
                        <div class="d-flex">
                        <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                        </div></a>
                    </li>
                  @endforeach
              @endif
          </ul>
        </div>
      </div>
    </div>


  </div>
   <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
@endsection

