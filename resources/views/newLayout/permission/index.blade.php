
@extends('newLayout.layouts.newLayout')

@section('title')
    Gamers
@endsection
@section('content')

    <section class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permissions</h3>

                    <a href="{{route('permissions.create')}}" class="btn btn-success btn-sm float-right">Add Permission</a>

                </div>
                <div class="card-body p-0">
                    {{-- @include('admin.includes.message') --}}
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Name </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td> {{$permission->name}} </td>

                                <form action="{{route('permissions.destroy',$permission->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <td class="project-actions">
                                        {{-- <a class="btn btn-primary btn-sm" href="#">
                                            <i class="fas fa-folder">
                                            </i>
                                            View
                                        </a> --}}
                                        <a class="btn btn-info btn-sm" href="{{route('permissions.edit',$permission->id)}}">
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

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
