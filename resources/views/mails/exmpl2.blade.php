
   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    @if(isset($details) && !empty($details))

    @php
    $details = json_decode($details,'true');
    $token = 'https://woodswoood.com/spinner/form/'.$details['form']['token'];
    // dd($details);
    // print_r($details['token']);
    $active_theme = \App\Models\Theme::where('name',$details['theme'])->first();
    @endphp
    <img style="max-width: 20%;" src="<?php echo URL::to('/images/'.$details['theme'].'/'.$active_theme->logo) ?>" alt="Game">
 <br>
     <p>
       Congratulations {{ $details['form']['full_name']}}!! <br>
       You have loaded enough balance to be eligible for spinner lottery.
       <br>
       Click this link below and fill up the form to go to further process.
       <br>
     </p>

        <a href="https://test99.caandv.com/spinner/form/{{$details['form']['token']}}" style="padding: 15px 25px; font-size: 24px; text-align: center; cursor: pointer; outline: none; color: #fff; background-color: #04AA6D; border: none; border-radius: 15px; box-shadow: 0 9px #999;">Click me</a>
   <br>
 @endif

        <span>Sincerely,
         Woodswood Games.</span>

</body>
</html>
