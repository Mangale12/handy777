
@extends('newLayout.layouts.newLayout')

@section('title')
    Gamers
@endsection
@section('content')

    <section class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Roles</h3>

                    <a href="{{route('roles.create')}}" class="btn btn-success btn-sm float-right">Add Role</a>

                </div>
                <div class="card-body p-0">
                    {{-- @include('admin.includes.message') --}}
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Role </th>
                                <th> Permissions </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            @if ($role->name != 'Super Admin')
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td> {{$role->name}} </td>
                                <td>
                                    @foreach ($role->permissions as $permission)
                                        <span class="badge badge-success" style="color:black">{{$permission->name}}</span>
                                    @endforeach
                                </td>
                                <form action="{{route('roles.destroy',$role->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <td class="project-actions">

                                    <a class="btn btn-info btn-sm" href="{{route('roles.edit',$role->id)}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                        <button class="btn btn-danger btn-sm" type="submit">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
