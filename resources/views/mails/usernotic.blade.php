
<?php 
  $details = json_decode($details,true);
     $active_theme = \App\Models\Theme::where('name',$details['theme'])->first();
?>
    <table style="width: 100%;border: 3px solid #dddddd;border-radius: 10px;padding: 20px 0 20px 0;width: 100%;">
        <tbody>
            <tr style="text-align: center;">
                <td>
               
                </td>
            </tr>
            <tr>
            <td style="color: black;font-size: 15px;padding: 0 50px 0 50px;text-align:center;">
                    <div>
                        <h1>New registration details</h1><br>
                        <p>Name: {{ $details['name'] }}</p>
                        <p>Email: {{ $details['email'] }}</p>
                        <p>Facebook: {{ $details['face_book'] }}</p>
                        <p>phone: {{ $details['phone'] }}</p>
                        <p>IP: {{ $details['ip'] }}</p>
                        
                    </div>
                    <hr>
                    [<?php echo Carbon\Carbon::now().'   ('.config('app.timezone').')'  ?>]
                    <br>
                    Sincerely,
                    <b><?php echo ($details['theme'] == 'default')?'Handy Games':ucfirst($details['theme']) ?> Games.<b>
                </td>
            </tr>
        </tbody>
    </table>