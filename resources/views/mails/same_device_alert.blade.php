
<?php 
  $details = json_decode($details,true);
?>
    <table style="width: 100%;border: 3px solid #dddddd;border-radius: 10px;padding: 20px 0 20px 0;width: 100%;">
        <tbody>
            <tr style="text-align: center;">
                <td>
               
                </td>
            </tr>
            <tr>
            <td style="color: black;font-size: 15px;padding: 0 50px 0 50px;text-align:center;">
                <h style="text-align:center">Fake user dedtails</h>
                    <div>
                        <h1>New registration details</h1><br>
                        <p>Name: {{ $details['name'] }}</p>
                        <p>Email: {{ $details['email'] }}</p>
                        <p>Facebook: {{ $details['facebook_name'] }}</p>
                        <p>phone: {{ $details['phone'] }}</p>
                        <p>IP: {{ $details['ip'] }}</p>
                        
                    </div>
                    
                    <div>
                        <h1>Previous registration details</h1><br>
                        <p>Name: {{ $details['pre_details']['full_name'] }}</p>
                        
                        <p>Email: {{ $details['pre_details']['email'] }}</p>
                        
                        <p>Facebook: {{ $details['pre_details']['facebook_name'] }}</p>
                        <p>phone: {{ $details['pre_details']['number'] }}</p>
                        <p>IP: {{ $details['pre_details']['ip'] }}</p>
                        
                    </div>
                    <hr>
                    [<?php echo Carbon\Carbon::now().'   ('.config('app.timezone').')'  ?>]
                    <br>
                </td>
            </tr>
        </tbody>
    </table>