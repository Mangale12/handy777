<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Website</title>
  <!-- Bootstrap link Starts -->
  <link rel="stylesheet" href="../../public/admin/assets/bootstrap-4.3.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../public/admin/assets/bootstrap-4.3.1/css/bootstrap.min.css.map" />
  <!-- Bootstrap link Ends -->
  <!-- Font Awesome Link Starts -->
  <link rel="stylesheet" href="../../public/admin/assets/font-awesome-4.7.0/css/font-awesome.min.css" />
  <!-- Font Awesome Link Ends -->
  <!-- Slick Css -->
  <link rel="stylesheet" href="../../public/admin/assets/slick/slick.css" />
  <link rel="stylesheet" href="../../public/admin/assets/slick/slick-theme.css" />
  <!-- Slick Css Ends-->
  <!-- Custom Links -->
  <!-- Font Link -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Orbitron:wght@400;500;600;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100;1,300;1,400;1,500&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,600&display=swap"
    rel="stylesheet" />
  <!-- Font Link Ends -->
  <link rel="stylesheet" href="../../public/admin/assets/css/style.css" />
  <link rel="stylesheet" href="../../public/admin/assets/css/responsive.css" />
  <style>
      .grid-container {
    display: grid;
    grid-template-columns: auto auto auto auto auto;
    grid-row-gap: 30px;
    grid-column-gap: 30px;
    width: 100%;
    place-items: center;
    padding: 20px;
}
  </style>
  <!-- Custom Links Ends -->
</head>

<body>
  <div class="overlay2 position-absolute">
    <img src="admin/assets/images/a (3).jpg" class="img-fluid" />
  </div>
  <!-- Whole Body Wrapper Starts -->
  <!-- <section id="navigation-wrapper">
    <nav class="navbar navbar-expand-lg">
      <button class="navbar-toggler p-0" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav justify-content-between w-100">
          <li class="nav-item nav-item2 active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              Dropdown link
            </a>
            <div class="dropdown-menu p-0 rounded-0" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">Action 1</a>
              <a class="dropdown-item" href="#">Action 2</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </section> -->
  <section id="dashboard-wrapper" class="position-relative">
    <div class="container-fluid">
      <div class="row sidebar-content">
        <!-- Grid Cards -->
        <div class="grid-container">
             @foreach($image as $images)
          <div class="grid-item">
             
            <img src="{{ asset('storage/app/'.$images->image) }}" alt="winner-image" class="img-fluid" height="750px" width="350px">
           
          </div>
          @endforeach
        </div>
        <!-- Grid Cards Ends -->
      </div>
    </div>
  </section>
 
  <!-- Whole Body Wrapper Ends -->
  <!-- 1st Jquery Link Starts-->
  <script src="../../public/admin/assets/jquery-3.5.1/jquery-3.5.1.js "></script>
  <!-- Jquery Link Ends-->
  <!-- 2nd Popper Js Starts -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js "
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN " crossorigin="anonymous ">
  </script>
  <!-- Popper Js Ends -->
  <!-- 3rd Bootstrap Js Link Starts -->
  <script src="../../public/admin/assets/bootstrap-4.3.1/js/bootstrap.min.js "></script>
  <script src="../../public/admin/assets/bootstrap-4.3.1/js/bootstrap.min.js.map "></script>
  <!-- Bootstrap Js Link Ends -->
  <!-- Slick Js -->
  <script src="../../public/admin/assets/slick/slick.min.js "></script>
  <!-- Slick Js Ends-->
  <!-- Custom Js Starts -->
  <script src="../../public/admin/assets/js/main.js "></script>
  <!-- Custom Js Ends -->
  <!-- Modal -->
  <div class="modal fade" id="leftsidebarfilter" tabindex="-1" role="dialog" aria-labelledby="leftsidebarfilterlabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="leftsidebarfilterlabel">
            Dashboard Menu
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="left-side-wrapper">
            <div class="sidebar-menu">
              <ul class="m-0 p-0">
                <li class="px-3 py-2">
                  <div class="d-flex justify-content-center align-items-center flex-wrap py-lg-4 py-2">
                    <img src="admin/assets/images/bg1.jpg" class="logo img-fluid" />
                    <div class="info ml-lg-3 ml-0 mt-lg-0 mt-3">
                      <h6 class="p-0 text-uppercase">Company Name</h6>
                      <a class="m-0 p-0 text-light">Upload Photo</a>
                    </div>
                  </div>
                </li>
                <li class="px-3 py-2 mx-3 my-2 active">
                  <a href="">
                    <div class="d-flex">
                      <span class="mr-4"><i class="fa fa-dashboard"></i></span>Dashboard
                    </div>
                  </a>
                </li>
                <li class="px-3 py-2 mx-3 my-2">
                  <a href="">
                    <div class="d-flex">
                      <span class="mr-4"><i class="fa fa-user" aria-hidden="true"></i></span>User
                    </div>
                  </a>
                </li>
                <li class="px-3 py-2 mx-3 my-2">
                  <a href="">
                    <div class="d-flex">
                      <span class="mr-4"><i class="fa fa-clone" aria-hidden="true"></i></span>Text
                    </div>
                  </a>
                </li>
                <li class="px-3 py-2 mx-3 my-2">
                  <a href="">
                    <div class="d-flex">
                      <span class="mr-4"><i class="fa fa-area-chart" aria-hidden="true"></i></span>Chart
                    </div>
                  </a>
                </li>
                <li class="px-3 py-2 mx-3 my-2">
                  <a href="">
                    <div class="d-flex">
                      <span class="mr-4"><i class="fa fa-cog" aria-hidden="true"></i></span>Setting
                    </div>
                  </a>
                </li>
                <li class="px-3 py-2 mx-3 my-2">
                  <a href="">
                    <div class="d-flex">
                      <span class="mr-4"><i class="fa fa-lock" aria-hidden="true"></i></span>Log Out
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- <div class="modal-footer">
              </div> -->
      </div>
    </div>
  </div>
  <!-- Mobile Filter Pop Up Ends -->
</body>

</html>