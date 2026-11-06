@extends('newLayout.layouts.newLayout')

@section('title')
Activity Status
@endsection
@section('content')
<div class="row">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-body py-2">
                <div class="table-responsive">
                    <table class="table align-items-center datatable">
                        <thead class="sticky" >
                            <tr  >
                                <th>SN</th>
                                <th>Status Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="user-history-body">
                            @forelse ($activity_status as $status)
                            <tr>
                                <td>
                                    <h6 class=" mb-0 text-sm">{{ $loop->iteration }}</h6>
                                </td>
                                <td>
                                    <h6 class=" mb-0 text-sm">{{ ucfirst($status->status) }}</h6>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info editStatus" data-id="{{ $status->id }}" data-status="{{ $status->status }}"><i class="fa fa-pencil"></i></button>
                                    <a href="{{ route('activity.status.delete', $status->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No Data Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 mb-4 p-4">
        <form action="{{ route('activity.status.store') }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" name="status" class="form-control statusTitle" placeholder="Status Title" required>
                <input name="id" class="statusId" type="hidden" disabled>
            </div>
            <button type="submit" class="btn btn-success mt-3">Submit</button>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).on("click", ".editStatus", function (event) {
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        console.log(id, status);
        $(".statusTitle").val(status);
        $(".statusTitle").focus();
        $(".statusId").removeAttr('disabled');
        $(".statusId").val(id);
    });
</script>
@endsection



