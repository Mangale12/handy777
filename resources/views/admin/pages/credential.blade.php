@extends('admin.layout.app')
@section('content')

<div class="col-lg-9 col-md-6 ml-auto">
    <button class="btn-glass text-white px-5 d-md-none d-block w-100 mb-2 border-0" data-toggle="modal" data-target="#leftsidebarfilter"> <span class="mr-2"><i class="fa fa-tachometer"
                aria-hidden="true"></i></span><span>Dashboard Menu</span>
    </button>
    <h2 class="text-white">SMS Credential Setting</h2>
    <div class="sidebar-content p-4">
        <form>
            <div class="form">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">CLIENT ID</label>
                    <input type="email" class="form-control" id="inputEmail4" value="{{ \Config::get('nexmo.api_key') }}" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">CLIENT SECRET KEY</label>
                    <input type="text" class="form-control" id="inputPassword4" value="{{ \Config::get('nexmo.api_secret') }}" placeholder="Password">
                </div>
            </div>
            <button type="submit" class="btn btn-1 hover-filled-slide-up text-white px-5">
                <span>Save</span>
            </button>
        </form>
    </div>
    <h2 class="text-white mt-2">Gmail Credential Setting</h2>
<div class="sidebar-content p-4">
    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">MAIL DRIVER</label>
           
                <input type="email" class="form-control" id="inputEmail4" value="{{ \Config::get('mail.mailers.smtp.transport') }}" placeholder="Email">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">MAIL HOST</label>
                <input type="text" class="form-control" id="inputPassword4" value="{{ \Config::get('mail.mailers.smtp.host') }}" placeholder="Password">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">MAIL PORT</label>
                <input type="text" class="form-control" id="inputPassword4" value="{{ \Config::get('mail.mailers.smtp.port') }}" placeholder="Password">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">MAIL USERNAME</label>
                <input type="text" class="form-control" id="inputPassword4" value="{{ \Config::get('mail.mailers.smtp.username') }}" placeholder="Password">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">MAIL PASSWORD</label>
                <input type="text" class="form-control" id="inputPassword4" value="{{ \Config::get('mail.mailers.smtp.password') }}" placeholder="Password">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">MAIL ENCRYPTION</label>
                <input type="text" class="form-control" id="inputPassword4" value="{{ \Config::get('mail.mailers.smtp.encryption') }}" placeholder="Password">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">MAIL ADDRESS</label>
                <input type="text" class="form-control" id="inputPassword4" value="{{ \Config::get('mail.from.address') }}" placeholder="Password">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">MAIL NAME</label>
                <input type="text" class="form-control" id="inputPassword4" value="{{ \Config::get('mail.from.name') }}" placeholder="Password">
            </div>
        </div>
    
        <button type="submit" class="btn btn-1 hover-filled-slide-up text-white px-5">
            <span>Save</span>
        </button>
    </form>
</div>
</div>
</div>

@endsection