@component('mail::message')

@if(isset($details1) && !empty($details1))
    @php
        $name = isset($details1['text']['name']) ? $details1['text']['name'] : '';
        $token_id = $details1['text']['token_id'];
        $token = URL::to('/spinner/form/'.$token_id);
    @endphp
@endif

<!-- Logo Row -->
<div style="text-align: center; padding-bottom: 20px;">
    @php
        $active_theme = \App\Models\Theme::where('name', $details1['theme'])->first();
    @endphp
    <img style="max-width: 150px;" src="{{ URL::to('/images/' . $details1['theme'] . '/' . $active_theme->logo) }}" alt="Game Logo">
</div>

<!-- Greeting -->
<p style="font-size: 18px; font-weight: bold; text-align: center;">Hi {{ $name }},</p>

<!-- Main Message -->
<p style="font-size: 16px; color: #555555; line-height: 1.6;">
    We're absolutely thrilled to announce that you've been chosen to join our exhilarating Spinner Event exclusively at Emmy Games! This is your golden ticket to potentially snag some fantastic rewards. Are you ready to take a spin?
</p>

<!-- Event Information -->
<div style="text-align: center; background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin: 20px 0;">
    <p style="font-size: 16px; font-weight: bold;">🎉 <strong>Mark Your Calendar!</strong></p>
    <p><strong>Date:</strong> 15th September<br><strong>Time:</strong> 12:00 AM CST</p>
</div>

<!-- Call to Action -->
<p style="font-size: 16px; text-align: center; color: #555555;">
    🚀 <strong>Here’s What You Need to Do:</strong> Simply click the button below to join the fun and get your chance to win big! Don’t miss out—exciting prizes are just a spin away!
</p>

<!-- Join Button -->
<div style="text-align: center; margin: 30px 0;">
    <a href="{{ $token }}" target="_blank" style="background-color: #28a745; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-size: 18px; font-weight: bold;">
        Join the Spinner
    </a>
</div>

<!-- Social Media Callout -->
<p style="font-size: 16px; text-align: center; color: #555555;">
    Got questions? Drop us a message on <a href="https://www.facebook.com/share/p/chWQTLp65HJaxfAQ/" style="color: #007bff; text-decoration: none;">AB Gaming's Facebook page</a>, and we'll get right back to you.
</p>

<!-- Additional Message -->
<p style="font-size: 16px; text-align: center; color: #555555;">
    Best of luck, and we can’t wait to see you there! Let the games begin! 🎲
</p>

<!-- Signature -->
<p style="font-size: 16px; font-weight: bold; text-align: center; color: #555555;">
    Cheers,<br>
    The Emmy Games Team
</p>

@endcomponent
