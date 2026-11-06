<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Our Page Has Moved</title>
</head>

<body style="margin:0; padding:0; background-color:#0b0f1a; font-family: Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:20px 0; background-color:#0b0f1a;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background:#111827; border-radius:10px; overflow:hidden;">

<!-- HEADER -->
<tr>
<td align="center" style="background-color:#1f2937; padding:25px;">
    <h1 style="color:#22c55e; margin:0;">Emmy Club</h1>
    <p style="color:#9ca3af; margin:5px 0 0;">Important Page Update</p>
</td>
</tr>

<!-- BODY -->
<tr>
<td style="padding:30px; color:#e5e7eb; font-size:15px; line-height:1.6;">

<p style="font-size:16px; margin-top:0;">Hi <strong>{{ $customerName }}</strong>,</p>

<p>We wanted to let you know that the <strong>AB page has been suspended</strong> and is no longer available.</p>

<p>Not to worry, we've set up a new page so you can stay connected with us. You can find it here:</p>

<!-- BUTTON -->
<table align="center" cellpadding="0" cellspacing="0" style="margin:25px auto;">
<tr>
<td align="center" bgcolor="#22c55e" style="border-radius:6px;">
<a href="{{ $newPageUrl }}" target="_blank"
   style="display:inline-block; padding:14px 28px; font-size:16px; color:#000000; text-decoration:none; font-weight:bold;">
   Visit Our New Page
</a>
</td>
</tr>
</table>

<!-- FALLBACK LINK -->
<p style="text-align:center; font-size:13px; color:#9ca3af; margin:0 0 20px;">
If the button doesn't work, copy this link:<br>
<a href="{{ $newPageUrl }}" target="_blank" style="color:#60a5fa; word-break:break-all;">{{ $newPageUrl }}</a>
</p>

<!-- CONTACT BOX -->
<table width="100%" cellpadding="0" cellspacing="0" style="background:#1f2937; border-radius:8px; margin:20px 0;">
<tr>
<td style="padding:20px;">
    <p style="margin:0 0 8px; color:#e5e7eb;"><strong>Emmy Club</strong></p>
    <p style="margin:0; font-size:14px; color:#9ca3af;">
        WhatsApp:
        <a href="{{ $whatsappLink }}" target="_blank" style="color:#60a5fa; text-decoration:none;">{{ $whatsapp }}</a>
    </p>
</td>
</tr>
</table>

<p>Please <strong>follow or bookmark</strong> the new page so you don't miss any updates, and feel free to share the link with anyone who followed the old one.</p>

<p>Thank you for your patience and continued support. If you have any questions, just reply to this email.</p>

<p style="margin-top:30px; margin-bottom:0;">
Best regards,<br>
<strong>Emmy William</strong><br>
<span style="color:#9ca3af; font-size:14px;">
    Emmy Club<br>
    WhatsApp: {{ $whatsapp }}
</span>
</p>

</td>
</tr>

<!-- FOOTER -->
<tr>
<td style="background:#020617; text-align:center; padding:20px; color:#6b7280; font-size:11px;">
&copy; {{ date('Y') }} Emmy Club<br>
<b>Stay connected for more updates and events.</b>
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>