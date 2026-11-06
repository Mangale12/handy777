@component('mail::message')
  @if(isset($details) && !empty($details))
      @php
        $details = json_decode($details, true);
        $message = $details['message'];
         $extra_details = isset($details['details'])?json_decode($details['details']):'';
      @endphp
  @endif
  <table style="width: 100%;border: 3px solid #dddddd;border-radius: 10px;padding: 20px 0 20px 0;width: 100%;">
   <tbody>
       <tr style="text-align: center;">
           <td>
           <img style="max-width: 20%;" src="<?php echo URL::to('/images/default/dragonnn.gif') ?>" alt="Game"> 
           </td>
       </tr>
       <tr>
           <td style="color: black;font-size: 15px;padding: 0 50px 0 50px;text-align:center;">
               <?php echo  $message ?><br><br>
               <?php 
               if(!empty($extra_details) || $extra_details != ''){
                    foreach($extra_details as $a => $b){
                        echo $a.' is '.$b.'<br>';
                    }
                }
                ?>
               <br><br>
               Sincerely,<br>
               <b>Noor Games </b>
           </td>
       </tr>
   </tbody>
</table>
@endcomponent
