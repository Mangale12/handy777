
    <table style="width: 100%;border: 3px solid #dddddd;border-radius: 10px;padding: 20px 0 20px 0;width: 100%;">
      <tbody>
          <tr style="text-align: center;">
              <td>
              <?php 
                  $details = json_decode($details,true);
                  $token_id = $details['unsub_token'];
                  $token = URL::to('/unsubscribe-me/'.$token_id);
                  $active_theme = \App\Models\Theme::where('name',$details['theme'])->first();
              ?>
              <img style="max-width: 20%;" src="<?php echo URL::to('/images/'.$details['theme'].'/'.$active_theme->logo) ?>" alt="Game"> 
              </td>
          </tr>
          <tr>
          <td style="color: black;font-size: 15px;padding: 0 50px 0 50px;text-align:center;">
            <style>
               h2{
                  text-align: center!important;
               }
            </style>
                  <div style="text-align:center;">
                     <?php echo  $details['message'] ?>
                  </div>
                  <br><br>

                  <b>Please click the link below</b><br>
                    <a href="{{$token}}">
                        {{$token}}
                    </a>
                    <br>to unsubscribe from the family.
                  <br><br>Or<br><br>
                  <a target="_blank" href="{{$token}}" style="color: #fbfcff;text-decoration: none;background: #59ed29;padding: 5px 5px 5px 5px;border-radius: 5px;text-align: center;">
                     Click Here
                  </a>
                  <br>
                  <hr>
                  [<?php echo Carbon\Carbon::now().'   ('.config('app.timezone').')'  ?>]
                  <br>
                  Sincerely,
                  <b><?php echo ($details['theme'] == 'default')?'Noor':ucfirst($details['theme']) ?> Games.<b>
              </td>
          </tr>
      </tbody>
  </table>