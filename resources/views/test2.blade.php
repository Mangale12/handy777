<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="https://noorgames.net/images/logochangecolor.gif">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Noor Games</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <!-- CSS Files -->
    <link href="../../public/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../public/css/light-bootstrap-dashboard790f.css" rel="stylesheet" />
    <link href="../../public/css/demo.css" rel="stylesheet" />
    </head>

    <body>

    <div class="wrapper">
        <div class="sidebar">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="https://www.creative-tim.com/" class="simple-text">
                        Noor Games
                    </a>
                </div>
                <ul class="nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="dashboard.html">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="user.html">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Colab</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="table.html">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Yesterday</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="typography.html">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Today</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="icons.html">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Tomorrow</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- fixed plugin  -->
            <div class="fixed-plugin">
                <div class="dropdown"> 
                    <a href="#" data-toggle="dropdown">
                        <i class="fa fa-cog fa-2x"> </i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header-title"> Sidebar Style</li>
                        <li class="adjustments-line">
                            <a href="javascript:void(0)" class="switch-trigger background-color">
                                <p>Filters</p>
                                <div class="pull-right">
                                    <span class="badge filter badge-black" data-color="black"></span>
                                    <span class="badge filter badge-azure" data-color="azure"></span>
                                    <span class="badge filter badge-green" data-color="green"></span>
                                    <span class="badge filter badge-orange" data-color="orange"></span>
                                    <span class="badge filter badge-red" data-color="red"></span>
                                    <span class="badge filter badge-purple active" data-color="purple"></span>
                                </div>
                                <div class="clearfix"></div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class=" container-fluid  ">
                    <a class="navbar-brand" href="#pablo"> Dashboard </a>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <span class="no-icon">Log out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4 class="card-title">131</h4>
                                </div>
                                <div class="card-body ">
                                    <p class="card-category">Total Noor Gamers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="../../public/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="../../public/js/core/popper.min.js" type="text/javascript"></script>
<script src="../../public/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="../../public/js/plugins/bootstrap-notify.js"></script>
<script src="../../public/js/light-bootstrap-dashboard790f.js" type="text/javascript"></script>
<script src="../../public/js/demo.js"></script>

<script>
    $(document).ready( function () {
        $('.datatable').DataTable({
            "pageLength": 100
        });
    } );
</script>
</html>
