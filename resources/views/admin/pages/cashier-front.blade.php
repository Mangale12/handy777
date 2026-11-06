@extends('admin.layout.app')
@section('content')
<div class="col-lg-9 col-md-6 ml-auto">
    <button class="btn-glass text-white px-5 d-md-none d-block w-100 mb-2 border-0" data-toggle="modal" data-target="#leftsidebarfilter"> <span class="mr-2"><i class="fa fa-tachometer"
                aria-hidden="true"></i></span><span>Dashboard Menu</span>
    </button>
    <h2 class="text-white">Cashier Frontend Setting</h2>
    <div class="sidebar-content p-4">
        <form action="{{ route('cashier.store.frontsetting') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form">
                <div class="form-group col-md-6">
                    <label>Logo</label>
                    <input type="file" class="form-control-file p-2" id="logo" name="logo">
                </div>
                <div class="form-group col-md-6">
                    <label>Cashier Logo</label>
                    <input type="file" class="form-control-file p-2" id="cashier_logo" name="cashier_logo">
                </div>
                <div class="form-group col-md-6">
                    <label>Favicon</label>
                    <input type="file" class="form-control-file p-2" id="cashier_favicon" name="cashier_favicon">
                </div>
                <div class="form-group col-md-6">
                    <label>Cashier Login Background</label>
                    <input type="file" class="form-control-file p-2" id="cashier_login_background" name="cashier_login_background">
                </div>
                <div class="form-group col-md-6">
                    <label>Cashier Logo Sidebar</label>
                    <input type="file" class="form-control-file p-2" id="cashier_login_sidebar" name="cashier_login_sidebar">
                </div>
            </div>
            <button type="submit" class="btn btn-1 hover-filled-slide-up text-white px-5">
                <span>Save</span>
            </button>
        </form>
    </div>
</div>
@endsection