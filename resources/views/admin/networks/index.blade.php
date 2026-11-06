@extends('newLayout.layouts.newLayout')

@section('title', 'Network')

@section('content')
<script src="https://kit.fontawesome.com/a26d9146a0.js" crossorigin="anonymous"></script>
    <section class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Networks</h3>
                    <a href="{{ route('admin.networks.create') }}" class="btn btn-success btn-sm float-right">Add Coin Address</a>
                </div>
                <div class="card-body p-0">
                    {{-- @include('admin.includes.message') --}}
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Networks</th>
                                <th>Logo</th>
                                <th>symbol</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['networks'] as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        {!! $item->logo !!}
                                    </td>
                                    <td>{{ $item->icon }}</td>
                                    <td>{{ $item->symbol }}</td>
                                    <td class="project-actions">
                                        <a class="btn btn-info btn-sm" href="{{ route('admin.networks.edit', $item->id) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.networks.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure you want to delete this item?')">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
