<table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($unsubs as $item)
            <tr>
                <td>
                    {{$item->created_at}}
                </td>
                <td>
                    {{$item->days}} days
                </td>
                <td>
                    {{$item->is_seen == 1?'Seen':'Not Seen'}}
                </td>
            </tr>
            
        @endforeach
    </tbody>
</table>
