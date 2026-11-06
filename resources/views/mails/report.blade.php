@component('mail::message')
{{-- @php
    dd(json_decode($details, true));
@endphp  --}}



@if(isset($details) && !empty($details))
Hello Admin, This is the 24 hour report.[<?php echo Carbon\Carbon::now().'   ('.config('app.timezone').')' ?>]<br>
<hr>
   {{-- @if ((is_array($details) || is_object($details))) --}}
@php
$details = json_decode($details,'true');
@endphp
<div>
@foreach ($details as $a => $b)
<table>
<tr style="">
<td  style="color: #ffff;background: #001fff;font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;" width="15%" height="32" align="center">
Game Name
</td>
<td  style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="25%" align="center">
{{$b['game_name']}}
</td>
</tr>
<tr style="">
<td  style="color: #ffff;background: #001fff;font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;" width="5%" height="32" align="center">
Game Title
</td>
<td  style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="25%" align="center">
{{$b['game_title']}}
</td>
</tr>
<tr style="">
<td  style="color: #ffff;background: #001fff;font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;" width="5%" height="32" align="center">
Game Balance
</td>
<td  style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="25%" align="center">
{{$b['game_balance']}}
</td>
</tr>
<tr style="">
<td  style="color: #ffff;background: #001fff;font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;" width="5%" height="32" align="center">
Transactions 
</td>
<td  style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="25%" align="center">
{{$b['total_transactions']}}
</td>
</tr>
<tr style="">
<td  style="color: #ffff;background: #001fff;font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;" width="5%" height="32" align="center">
Tip 
</td>
<td  style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="25%" align="center">
{{$b['totals']['tip']}}
</td>
</tr>
<tr style="">
<td  style="color: #ffff;background: #001fff;font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;" width="5%" height="32" align="center">
Load 
</td>
<td  style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="25%" align="center">
{{$b['totals']['load']}}
</td>
</tr>
<tr style="">
<td  style="color: #ffff;background: #001fff;font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;" width="5%" height="32" align="center">
Redeem 
</td>
<td  style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="25%" align="center">
{{$b['totals']['redeem']}}
</td>
</tr>
<tr style="">
<td  style="color: #ffff;background: #001fff;font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;" width="5%" height="32" align="center">
Bonus
</td>
<td  style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="25%" align="center">
{{$b['totals']['refer']}}
</td>
</tr>
</table>
<br>
<br>
<table  width="800px!important;" border="0" cellspacing="0" cellpadding="0">
<tr style="background: #001fff;color: #ffff;">
<td  style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;" width="5%" height="32" align="center">
SN
</td>
<td  style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="25%" align="center">
User Name
</td>
<td style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="25%" align="center">
Fb Name
</td>
<td style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="10%" align="center">
Amount
</td>
<td style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="5%" align="center">
Type
</td>
<td style="font-family:Verdana, Geneva, sans-serif; font-weight:600; font-size:13px; border-top:1px solid #333; border-bottom:1px solid #333; border-right:1px solid #333;" width="15%" align="center">
Date
</td>
</tr>
@foreach ($b['histories'] as $key => $item)
<tbody>
<tr>
<td style="padding: 3px;font-family:Verdana, Geneva, sans-serif; font-weight:300; font-size:13px; border-bottom:1px solid #333; border-left:1px solid #333; border-right:1px solid #333;" align="center">
{{ $key+1 }}
</td>
<td style="padding: 3px;font-family:Verdana, Geneva, sans-serif; font-weight:300; font-size:13px; border-bottom:1px solid #333; border-right:1px solid #333;" align="center">
{{ (!empty($item['form']['full_name']))?$item['form']['full_name']:'Empty' }}
</td>
<td style="padding: 3px;font-family:Verdana, Geneva, sans-serif; font-weight:300; font-size:13px; border-bottom:1px solid #333; border-right:1px solid #333;" align="center">
{{ (!empty($item['form']['facebook_name']))?$item['form']['facebook_name']:'Empty' }}
</td>
<td style="padding: 3px;font-family:Verdana, Geneva, sans-serif; font-weight:300; font-size:13px; border-bottom:1px solid #333; border-right:1px solid #333;" align="center">
{{ (!empty($item['amount_loaded']))?$item['amount_loaded']:'Empty' }}
</td>
<td style="padding: 3px;font-family:Verdana, Geneva, sans-serif; font-weight:300; font-size:13px; border-bottom:1px solid #333; border-right:1px solid #333;" align="center">
{{ (!empty($item['type']))?(($item['type']!='refer')?$item['type']:'bonus'):'Empty' }}
</td>
<td style="padding: 3px;font-family:Verdana, Geneva, sans-serif; font-weight:300; font-size:13px; border-bottom:1px solid #333; border-right:1px solid #333;" align="center">
{{ (!empty($item['created_at']))?date('d M-Y',strtotime($item['created_at'])):'Empty' }}
</td>
</tr>
</tbody>
@endforeach
</table>
<hr>
@endforeach
   {{-- @endif --}}
@else
Hello Admin, Nothing to report today.
@endif
<br>
<br>
</div>
Sincerely,
Noor Games.
@endcomponent