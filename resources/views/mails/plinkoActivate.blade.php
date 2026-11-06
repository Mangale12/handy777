<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plinko Games - You've Been Chosen!</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    
    @if(isset($details1) && !empty($details1))
        @php
            $name = $details1['full_name'];
            $token_id = $details1['plinko_token'];
            $token = URL::to('/plinko/game/'.$token_id);
        @endphp
    @endif
    <!-- Email Container -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow: hidden;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%); background-color: #ff6b6b; padding: 30px; text-align: center;">
                            <h1 style="margin: 0; font-size: 32px; font-weight: bold; color: #ffffff; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                                🎰 The Emmy Games 🎰
                            </h1>
                            <p style="margin: 10px 0 0 0; font-size: 16px; color: #ffffff; opacity: 0.9;">
                                Your Gaming Adventure Awaits!
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px 30px; background-color: #ffffff;">
                            
                            <!-- Greeting -->
                            <h2 style="margin: 0 0 20px 0; font-size: 20px; font-weight: bold; color: #2c3e50;">
                                Hi {{ ucwords($name) }},
                            </h2>
                            
                            <!-- Main Text -->
                            <p style="margin: 0 0 25px 0; font-size: 16px; color: #34495e; line-height: 1.6;">
                                We're absolutely thrilled to announce that you've been chosen to <strong style="color: #e74c3c;">Plinko</strong>. Are you ready to play?
                            </p>
                            
                            <!-- Instructions Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 25px 0;">
                                <tr>
                                    <td style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); background-color: #f093fb; padding: 25px; border-radius: 10px; color: #ffffff;">
                                        <h3 style="margin: 0 0 15px 0; font-size: 18px; font-weight: bold; color: #ffffff;">
                                            🚀 Here's What You Need to Do:
                                        </h3>
                                        <p style="margin: 0; font-size: 16px; line-height: 1.5; color: #ffffff;">
                                            Simply click the button below to join the fun and get your chance to win big! Don't miss out—exciting prizes are just a spin away!
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Play Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 35px 0;">
                                <tr>
                                    <td align="center">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); background-color: #4facfe; border-radius: 50px; box-shadow: 0 8px 20px rgba(79, 172, 254, 0.4);">
                                                    <a href="{{ $token }}" target="_blank" style="display: inline-block; padding: 18px 50px; color: #ffffff; text-decoration: none; font-size: 20px; font-weight: bold; border-radius: 50px;">
                                                        🎮 PLAY NOW 🎮
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Support Section -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 25px 0;">
                                <tr>
                                    <td style="background-color: #f8f9fa; padding: 25px; border-radius: 10px; border-left: 5px solid #3498db;">
                                        <p style="margin: 0; color: #2c3e50; font-size: 16px; line-height: 1.5;">
                                            Got questions? Drop us a message on <a href="https://facebook.com/ABGaming" style="color: #3b5998; text-decoration: none; font-weight: bold;">AB Gaming's Facebook page</a>, and we'll get right back to you.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Closing -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 30px 0 0 0;">
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0 0 15px 0; font-size: 16px; color: #2c3e50; text-align: center;">
                                            Best of luck, and we can't wait to see you there! Let the games begin! 🎲
                                        </p>
                                        <p style="margin: 20px 0 0 0; font-weight: bold; color: #e74c3c; font-size: 18px; text-align: center;">
                                            Cheers,<br>
                                            The Emmy Games Team
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-color: #667eea; padding: 20px; text-align: center;">
                            <p style="margin: 0; font-size: 14px; color: #ffffff; opacity: 0.8;">
                                © 2025 The Emmy Games
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
    
</body>
</html>