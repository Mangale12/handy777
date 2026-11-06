@component('mail::message')
  @if(isset($details1) && !empty($details1))
      @php
         $name = isset($details1['text']['name'])?$details1['text']['name']:'';
         $message = $details1['text']['message'];
         $load = $details1['text']['load'];
         $token_id = $details1['text']['token_id'];
         $token = URL::to('/spinner/form/'.$token_id);
      @endphp
  @endif
  <table style="width: 100%;border: 3px solid #dddddd;border-radius: 10px;padding: 20px 0 20px 0;width: 100%;">
   <tbody>
       <tr style="text-align: center;">
           <td>
           <?php 
                $active_theme = \App\Models\Theme::where('name',$details1['theme'])->first();
            //    if($details1['theme'] == 'default'){
            //        $image = 'dragonnn.gif';
            //    }else{
            //        $image = 'logo.jpg';
            //    }
           ?>
           <img style="max-width: 20%;" src="<?php echo URL::to('/images/'.$details1['theme'].'/'.$active_theme->logo) ?>" alt="Game"> 
           </td>
       </tr>
       <tr>
           <td style="color: black;font-size: 15px;padding: 0 50px 0 50px;text-align:center;">
               {{$message['between_limit_text_1']}}, {{$name}} ,<br>
               {{-- <?php echo  $message ?><br><br> --}}
               {{-- <?php echo   ?><br><br> --}}
               <?php echo  $message['between_limit_text_2'] ?><br><br>
               <?php echo  $message['between_limit_text_3'] ?><br><br>
               <?php echo  $message['between_limit_text_4'] ?><br><br>
               @if($details1['text']['load-remaining'] > 0)
                  Only {{$details1['text']['load-remaining']}} left to be eligible for the spinner.
               @else
                  <b>{{$message['between_limit_text_2']}}</b><br>
                    <a href="{{$token}}">
                        {{$token}}
                    </a>
                    <br>{{$message['between_limit_text_3']}}
                  <br><br>Or<br><br>
                  <a target="_blank" href="{{$token}}" style="color: #fbfcff;text-decoration: none;background: #59ed29;padding: 5px 5px 5px 5px;border-radius: 5px;text-align: center;">
                     Click Here
                  </a>
               @endif
               <br><br>
               Sincerely,<br>
               <b><?php echo ($details1['theme'] == 'default')?'Noor':ucfirst($details1['theme']) ?> Games </b><br>
               <?php echo Carbon\Carbon::now().'   ('.config('app.timezone').')'  ?>

           </td>
       </tr>
   </tbody>
</table>
@endcomponent
