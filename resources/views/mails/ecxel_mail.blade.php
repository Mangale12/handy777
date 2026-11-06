<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sixtyfour&display=swap" rel="stylesheet">
                
<style>
// <uniquifier>: Use a uniquifier for the class name
    .container{
height:auto;
width:80%;
transform: translate(-50%, -50%);
box-shadow: 0 5px 15px rgba(161, 151, 151, 0.7);
margin-left:10%;
    }
    
@media screen and (max-width: 480px) { 
     .container{
        width:100%; 
         
     }
}
@media screen and (min-width: 480px) { 
     .message-text{
        margin-left: 5%;
    }
}
</style>
@php 
$background_image = $data["background_image"];
@endphp
<!-- partial:index.partial.html -->
<div class="container" style="background-image: url('https://handy777.net/public/uploads/{{$background_image}}'); padding: 10px; position:relative; color: white !important; filter: blur(10000px); height: 100%; background-position: center; background-size: cover;">
    <div >
         @if($data['enable_logo']=='1')
        <img src="https://handy777.net/public/uploads/{{$data['image']}}" alt="" style="height: 9rem; widht:10%; display: block; margin-left: auto;
        margin-right: auto;">
        @endif
        <div class="message-text" style="width:100%;">
            <h4 style="color:#ebebd9; font-weight:bold; font-size:1.5rem; font-family: 'Titania', sans-serif; font-family: 'Titania Outline', sans-serif;">Hey {{ $data['user']['first_name'] }},</h4>
            
            <pre style="color:#ebebd9; font-weight:bold; font-size:1.5rem; padding:20px;" class="uniquifier">
            {!! $data['message'] !!} </pre>
            <!--<p style="color:#ebebd9; text-align: center;">-->
            <!-- Sincerely,<br>-->
            <!--{{ $data['copyright_text'] }} Family ...</p>-->
        </div>
        
        <!--<div class="mt-5 my-3">-->
        <!--    <p style="color:rgb(178, 190, 181); text-align: center;">copyright @ {{ $data['copyright_text'] }}</p>-->
        <!--</div>-->
    </div>

</div>

