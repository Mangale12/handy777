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
                        <h3 class="card-title">Add User</h3>
                        <a href="{{route('user.index')}}" class="btn btn-success btn-sm float-right">View Users</a>
                    </div>
                    {{-- <div class="col-md-12 p-0">
                        @include('admin.includes.message')
                    </div> --}}
                    <div class="card-body">
                        <form action="{{route('user.update',$user->id)}}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{old('name',$user->name)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                            <select class="form-control" name="role">
                                              <option selected disabled>---Select role---</option>
                                              @foreach ($roles as $role)
                                                <option value="{{$role->name}}" @if($user->hasRole($role->name)) selected @endif>{{$role->name}}</option>
                                              @endforeach
                                            </select>

                                            {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{old('email',$user->email)}}">
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    @foreach ($role->permissions as $permission)
                                        <span class="badge badge-success">{{$permission->name}}</span>
                                    @endforeach
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirmPassword">
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
@endsection
