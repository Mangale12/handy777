<div class="col-lg-3 col-md-4 d-md-block d-none">
    <div class="sidebar-menu">
        <ul class="m-0 p-0">
            <li class="px-3 py-2">
                @php
                    $frontsetting = \App\Models\FrontSetting::first();
                @endphp
                <div class="d-flex justify-content-center align-items-center flex-wrap py-lg-4 py-2">
                    <img src="{{ asset($frontsetting->admin_login_sidebar) }}" class="logo img-fluid">
                    <div class="info ml-lg-3 ml-0 mt-lg-0 mt-3">
                        <h6 class="p-0 text-uppercase">Admin</h6>
                        <a class="m-0 p-0 text-light">Upload Photo</a>
                    </div>
                </div>

            </li>
            <li class="px-3 py-2 mx-3 my-2 active">
                <a href="{{ route('admin.index') }}">
                    <div class="d-flex"> <span class="mr-4"><i
                                class="fa fa-dashboard"></i></span>Dashboard
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('admin.chat') }}">
                    <div class="d-flex"> <span class="mr-4"><i
                                class="fa fa-comments"></i></span>Chat
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
                <a href="{{ route('admin.allplayers') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-clone"
                                aria-hidden="true"></i></span>All Players
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
        <a href="{{ route('colab') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-area-chart"
                                aria-hidden="true"></i></span>Collab
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('cashapp.index') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-area-chart"
                                aria-hidden="true"></i></span>Cash App
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('trash.cashapp') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-area-chart"
                                aria-hidden="true"></i></span>Trash CashApp
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('admin.games') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-area-chart"
                                aria-hidden="true"></i></span>My Games
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('trash.games') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-area-chart"
                                aria-hidden="true"></i></span>Trash Games
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-area-chart"
                                aria-hidden="true"></i></span>Cashier
                    </div>
                </a>
            </li>
           <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('cashier.frontend') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-cog"
                                aria-hidden="true"></i></span>Cashier Frontend Setting
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('image') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-cog"
                                aria-hidden="true"></i></span>Image
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('show.images') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-cog"
                                aria-hidden="true"></i></span>Show Image
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('admin.credential') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-cog"
                                aria-hidden="true"></i></span>Credentials Setting
                    </div>
                </a>
            </li>
            <li class="px-3 py-2 mx-3 my-2">
                <a href="{{ route('admin.frontend') }}">
                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-area-chart"
                                aria-hidden="true"></i></span>Frontend Setting
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
