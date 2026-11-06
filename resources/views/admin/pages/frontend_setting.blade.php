@extends('admin.layout.app')
@section('content')
<div class="col-lg-9 col-md-6 ml-auto">
    <button class="btn-glass text-white px-5 d-md-none d-block w-100 mb-2 border-0" data-toggle="modal" data-target="#leftsidebarfilter"> <span class="mr-2"><i class="fa fa-tachometer"
                aria-hidden="true"></i></span><span>Dashboard Menu</span>
    </button>
    <h2 class="text-white">Frontend Setting</h2>
    <div class="sidebar-content p-4">
        <form action="{{ route('admin.store.frontsetting') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">App Name</label>
                    <input type="text" class="form-control" id="inputEmail4" value="{{ \Config::get('app.name') }}" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                    <label>Logo</label>
                    <input type="file" class="form-control-file p-2" id="logo" name="logo">
                </div>
                <div class="form-group col-md-6">
                    <label>Admin Logo</label>
                    <input type="file" class="form-control-file p-2" id="admin_logo" name="admin_logo">
                </div>
                <div class="form-group col-md-6">
                    <label>Favicon</label>
                    <input type="file" class="form-control-file p-2" id="favicon" name="favicon">
                </div>
                <div class="form-group col-md-6">
                    <label>Admin Login Background</label>
                    <input type="file" class="form-control-file p-2" id="admin_login_background" name="admin_login_background">
                </div>
                <div class="form-group col-md-6">
                    <label>Admin Logo Sidebar</label>
                    <input type="file" class="form-control-file p-2" id="admin_login_sidebar" name="admin_login_sidebar">
                </div>
            </div>
            <button type="submit" class="btn btn-1 hover-filled-slide-up text-white px-5">
                <span>Save</span>
            </button>
        </form>
    </div>
</div>
@endsection