<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family:Verdana,Geneva,sans-serif;font-size:13px;">

<p>Hello Admin,</p>

@if(!empty($details['forms']) && count($details['forms']) > 0)

<p>
<strong>Run Date:</strong> {{ now()->format('F j, Y g:i A') }}<br>
<strong>Reporting Period:</strong> {{ $details['report_period'] }}
</p>

<table width="100%" cellpadding="0" cellspacing="0"
       style="border-collapse:collapse;max-width:800px;">
    <thead>
        <tr style="background:#001fff;color:#fff;">
            <th style="border:1px solid #333;padding:8px;">SN</th>
            <th style="border:1px solid #333;padding:8px;">Name</th>
            <th style="border:1px solid #333;padding:8px;">Facebook</th>
            <th style="border:1px solid #333;padding:8px;">7D Load</th>
            <th style="border:1px solid #333;padding:8px;">7D Redeem</th>
            <th style="border:1px solid #333;padding:8px;">7D Tips</th>
            <th style="border:1px solid #333;padding:8px;">Last Load</th>
            <th style="border:1px solid #333;padding:8px;">Game ID</th>
        </tr>
    </thead>
    <tbody>
        @foreach($details['forms'] as $i => $form)

        <tr>
            <td style="border:1px solid #333;padding:8px;text-align:center;">{{ $i+1 }}</td>
            <td style="border:1px solid #333;padding:8px;">{{ $form->full_name }}</td>
            <td style="border:1px solid #333;padding:8px;">{{ $form->facebook_name }}</td>
            <td style="border:1px solid #333;padding:8px;text-align:right;">${{ number_format($form->total_load_7d,2) }}</td>
            <td style="border:1px solid #333;padding:8px;text-align:right;">${{ number_format($form->total_redeem_7d,2) }}</td>
            <td style="border:1px solid #333;padding:8px;text-align:right;">${{ number_format($form->total_tip_7d,2) }}</td>
            <td style="border:1px solid #333;padding:8px;text-align:center;">
                {{ $form->last_load_at ? \Carbon\Carbon::parse($form->last_load_at)->format('Y-m-d') : 'No record' }}
            </td>
            <td style="border:1px solid #333;padding:8px;text-align:center;">{{ $form->game_id }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@else
<p>No users eligible today.</p>
@endif

<p>Regards,<br><strong>{{ config('app.name') }}</strong></p>

</body>
</html>
