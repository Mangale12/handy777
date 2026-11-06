
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
                            <h3 class="card-title">Add Role</h3>
                            <a href="{{route('roles.index')}}" class="btn btn-success btn-sm float-right">View Roles</a>
                        </div>
                        {{-- <div class="col-md-12 p-0">
                            @include('admin.includes.message')
                        </div> --}}
                        <div class="card-body">
                            <form action="{{route('roles.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <input type="text" class="form-control" name="role">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="permissions">Assign Permissions</label>
                                        <div class="row">
                                            {{-- @foreach($permissions as $value)
                                            <div class="form-check mr-5 ml-3">
                                            <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'permission')) }}
                                            {{ $value->name }}</label>
                                            <br/>
                                            </div>
                                            @endforeach --}}
                                            @foreach ($permissions as $permission)
                                            <div class="form-check mr-5 ml-3">
                                                <input class="form-check-input" type="checkbox" name="permission[]" value="{{$permission->id}}">{{$permission->name}}
                                            </div>
                                            @endforeach
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
