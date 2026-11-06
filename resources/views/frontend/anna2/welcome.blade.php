
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/style.css">

        <link rel="stylesheet" href="https://unpkg.com/papercss@1.8.3/dist/paper.min.css">
        <title>WoodWoods</title>
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
                    <span>Complete The registration and start getting your Rewards</span>
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
        <!-- formstr -->
        <div class="form-wrapper">
            <h2 class="animated_rainbow_1">Get Your Rewards!!!</h2>
            <div class="form-area" name="form">
                
                <div class="img-section">
                    <img src="assets/g1.jpeg" alt="" style="width: 100%;height:100%">
                </div>
                <div class="form-section">
                    <div style="display: flex;justify-content:center;margin-bottom:1rem ;">
                        <h2 class="animated_rainbow_1" style=" font-size:revert;">Registration Form</h2>
                    </div>
                    <form name="form" onsubmit="return(validate());">
                        <div class="section-1">
                            <div class="form-group">
                                <label for="paperInputs1">Full Name<sup>*</sup></label>
                                <input type="text" class="input-block" id="paperInputs1"
                                aria-describedby="emailHelp" placeholder="Enter name" name="fullname" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Phone<sup>*</sup></label>
                                <input type="text" class="input-block" id="exampleInputPassword1 "
                                placeholder="XXX XXX XXXX" name="phone" required>
                                
                            </div>
                            <div class="form-group">
                                <label for="paperSelects1">State<sup>*</sup></label>
                                <select id="paperSelects1" style="width: 10vw;" class="select-opt" name="state"
                                required>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">District of Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                            </select>
                        </div>
                    </div>
                    <div class="section-2">
                        <div class="form-group" style="width: 16vw;">
                            <label for="exampleInputPassword1">Referred By</label>
                            <input type="text" class="input-block" id="exampleInputPassword1"
                            placeholder="Referred By" name="referredBy">
                        </div>
                        
                        <div class="form-group" style="width: 16vw;">
                            <label for="exampleInputPassword1">Email<sup>*</sup></label>
                            <input type="text" class="input-block" id="exampleInputPassword1"
                            placeholder="XYZ@email.com" name="email" required>
                        </div>
                    </div>
                    <div class="section-3">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Facebook Name<sup>*</sup></label>
                            <input type="text" class="input-block" id="exampleInputPassword1"
                            placeholder="Facebook Name" name="facebook">
                        </div>
                        <div class="form-group">
                            <label for="paperSelects1">Game<sup>*</sup></label>
                            <select id="paperSelects1" style="width:10vw;" class="select-opt" name="game"
                            required>
                            <option value="1">Game 1</option>
                            <option value="2">Game 2</option>
                            <option value="3">Game 3</option>
                        </select>
                    </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Game ID<sup>*</sup></label>
                                    <input type="text" class="input-block" id="exampleInputPassword1"
                                        placeholder="Game ID" name="gameId" required>
                                </div>
                            </div>
                            <div class="captcha">
                                <img src="assets/CAPTCHA.png" alt="" style="height: 3rem;width:13rem;">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Enter the Text as shown above</label>
                                    <input type="text" class="input-block" id="exampleInputPassword1" placeholder="xxxx"
                                        name="captcha">
                                </div>
                            </div>
                            <div class="btn-submission">
                                <button type="submit" class="btn btn-primary"
                                    style="border-radius:3rem;     padding: 0.5rem 2rem;"
                                    onclick="validate()">Submit</button>
                            </div>
                        </form>
                    </div>



                </div>
            </div>

           <!-- form end -->

           <!-- game -->
            <div style="display: flex; justify-content:center;">
                <h1 class="animated_rainbow_1">Our Games</h1>
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
