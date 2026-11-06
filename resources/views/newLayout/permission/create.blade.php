
@extends('newLayout.layouts.newLayout')

@section('title')
    Gamers
@endsection
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Permission</h3>
                            <a href="{{route('permissions.index')}}" class="btn btn-success btn-sm float-right">View Permission</a>
                        </div>
                        {{-- <div class="col-md-12 p-0">
                            @include('admin.includes.message')
                        </div> --}}
                        <div class="card-body">
                            <form action="{{route('permissions.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="role">Permission</label>
                                            <input type="text" class="form-control" name="permission">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm float-right">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
