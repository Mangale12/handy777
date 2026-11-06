
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />

        <link rel="icon" href="assets/CAPTCHA.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/style.css">

        <link rel="stylesheet" href="https://unpkg.com/papercss@1.8.3/dist/paper.min.css">
        <title>WoodWoods/succes</title>
    </head>

    <body>
     <div>
        <video id="background-video" autoplay loop muted>
            <source src="assets/back.mp4" type="video/mp4">
        </video>
        <!-- baner -->
        <div id="main-container">
            <div class="text-area">
                <div>
                    <h1 class="animated_rainbow_1">WELCOME TO WoodsWooods</h1>
                    <span>You should get verification Email shortly  </span>
                </div>
                <div style="margin-top: 5rem;">
                    <!-- <img src="assets/animation.gif.mp4" alt="" style="width: 100%;"> -->
                    <video id="logo" autoplay loop muted poster="">
                        <source src="assets/animation.gif.mp4" type="video/mp4">
                    </video>
                    
                </div>
            </div>
            
        </div>
        <!-- banner -->
  

           <!-- game -->
            <div style="display: flex; justify-content:center;">
                <h1 class="animated_rainbow_1">Our Popular Games</h1>
            </div>

            <div class="catagory-tab">


                <button type="submit" class="btn btn-primary" style="border-radius: 3rem;"
                    onclick="toogleCatagory('all')">All</button>
                <button type="submit" class="btn btn-primary" style="border-radius: 3rem;"
                    onclick="toogleCatagory('catagory1')">Catagory1</button>
                <button type="submit" class="btn btn-primary" style="border-radius: 3rem;"
                    onclick="toogleCatagory('catagory2')">Catagory2</button>
            </div>
            <div class="gallery-section" id="gallery">

            </div>

<!-- endgames -->
       <!-- footer -->
        <div class="footer-container">
            <span id="footer-text"></span>
        </div>
        <!-- endfootr -->
    </div>
</div>
    </body>
    <script src="assets/js/index.js"></script>

    </html>
