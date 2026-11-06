<div class="col-lg-3 col-md-4 d-md-block d-none">
    <div class="sidebar-menu">
        <ul class="m-0 p-0">
            <li class="px-3 py-2">
                @php
                    $frontsetting = \App\Models\CashierFrontend::first();
                @endphp
                <div class="d-flex justify-content-center align-items-center flex-wrap py-lg-4 py-2">
                    <img src="{{ asset($frontsetting->cashier_login_sidebar) }}" class="logo img-fluid">
                    <div class="info ml-lg-3 ml-0 mt-lg-0 mt-3">
                        <h6 class="p-0 text-uppercase">Cashier</h6>
                        <a class="m-0 p-0 text-light">Upload Photo</a>
                    </div>
                </div>

            </li>
            <li class="px-3 py-2 mx-3 my-2 active">
                <a href="">
                    <div class="d-flex"> <span class="mr-4"><i
                                class="fa fa-dashboard"></i></span>Dashboard
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('table') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-user"
                                aria-hidden="true"></i></span>Account
                    </div>
                </a>
            </li>

            <li class="px-3 py-2 mx-3 my-2">
                <a href="">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-clone"
                                aria-hidden="true"></i></span>Game ID
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('cashier.showcashapp') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-area-chart"
                                aria-hidden="true"></i></span>Change CashApp
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-cog"
                                aria-hidden="true"></i></span>Setting
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('cashier.showtoday') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-cog"
                                aria-hidden="true"></i></span>Bonus User
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('logout') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-lock"
                                aria-hidden="true"></i></span>Log Out
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>