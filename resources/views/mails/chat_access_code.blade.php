<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your support chat code</title>
</head>
<body style="margin:0;background:#f4f7fb;color:#172033;font-family:Arial,sans-serif;line-height:1.6;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="padding:32px 12px;background:#f4f7fb;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:560px;background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 8px 28px rgba(23,32,51,.10);">
                    <tr>
                        <td style="padding:28px 32px;text-align:center;background:linear-gradient(135deg,#246bfe,#7448f5);color:#ffffff;">
                            <h1 style="margin:0;font-size:25px;">Support chat access</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin-top:0;">Hello {{ $chatEmail->display_name ?: 'there' }},</p>
                            <p>Use the code below to identify your support chat account:</p>
                            <p style="margin:25px 0;text-align:center;">
                                <span style="display:inline-block;padding:14px 24px;border:1px solid #bfdbfe;border-radius:10px;color:#172033;background:#eff6ff;font-size:25px;font-weight:700;letter-spacing:4px;">
                                    {{ $chatEmail->chat_code }}
                                </span>
                            </p>
                            <p style="text-align:center;">
                                <a href="{{ route('chat') }}" style="display:inline-block;padding:12px 22px;border-radius:8px;color:#ffffff;background:#246bfe;text-decoration:none;font-weight:700;">
                                    Open support chat
                                </a>
                            </p>
                            <p style="margin-bottom:0;color:#667085;font-size:13px;">This code is linked to {{ $chatEmail->email }}.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
