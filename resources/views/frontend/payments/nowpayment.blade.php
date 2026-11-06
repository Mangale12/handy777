@extends('frontend.cloud.main')
@section('title', 'Payment')
@section('content')
<div class="page-wrapper font-robo">
   <div class="page-wrapper font-robo">
      <div class="wrapper wrapper--w680">
         <div class="card card-1 py-5">
            <!--<div class="card-heading">-->
            <!--</div>-->
            <div>
               <style>
                  @import url('https://fonts.cdnfonts.com/css/bring-race');
                  @import url('https://fonts.cdnfonts.com/css/games');
                  @import url('https://fonts.cdnfonts.com/css/merchandise');
                  .new-text{
                      font-family: 'MERCHANDISE', sans-serif;
                      color:#f5f1ec;
                      letter-spacing: 4px;
                  }
                  @media screen and (max-width: 600px) {
                      
                      #cloud1, #cloud2 {
                        display: none;
                      }
                      .text-center-p{
                        padding: 0 11px;
                        text-align: center;
                        font-size: 27px!important;
                      }
                      .next-spin-p{
                          font-size:27px;
                      }
                      .referred-by{
                          margin-left:-24px;
                      }
                       .phone-number{
                            margin-top: 25px;
                    }
                  }
                  .main-header-text{
                        transform:scaleY(2.6);
                  }
                  @import url('https://fonts.cdnfonts.com/css/patrick-hand-sc');
                  .next-spin{
                        font-family: 'MERCHANDISE', sans-serif;
                  }
                  @media (min-width: 1200px) 
                  {
                      .card-1{
                            width: 164%;
                            right: 34%;
                        }
                        .logo{
                            width: 402px;
                            align-items: center;
                            display: inline;
                            position: relative;
                        }
                    }
                 
                  @media(min-width: 460px){
                      .welcom-text{
                          font-size: 50px!important;
                          
                      }
                      
                      .text-center{
                              margin: 0rem 1rem;
                      }
                      .text-center-p{
                        margin: 1rem 11rem!important;
                        text-align: center;
                      }
                     .next-spin-p{
                         font-size:2rem;
                     }
                    .text-center-logo {
                        margin: 0rem 18rem;
                    }
                   
                  }
                    
                  input, select{
                      color:white;
                  }
               
               
                    body {
                      background: linear-gradient(to bottom, #2c3e50, #1e1f26); /* Night sky theme */
                      color: #fff;
                      font-family: 'Arial', sans-serif;
                      text-align: center;
                      padding: 0;
                      margin: 0;
                    }
                    
                    /* Custom Modal */
                    #customModal {
                      display: none; /* Hidden by default */
                      position: fixed;
                      z-index: 9999; /* Ensure it's on top */
                      left: 0;
                      top: 0;
                      width: 100%;
                      height: 100%;
                      overflow: auto; /* Enable scroll if needed */
                      background-color: rgba(0, 0, 0, 0.5); /* Dark background */
                    }
                    
                    /* Modal Content */
                    #customModal .modal-content {
                      position: relative;
                      background-color: #fff;
                      margin: 10% auto;
                      padding: 20px;
                      border-radius: 8px;
                      width: 80%;
                      max-width: 500px;
                      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                      animation: fadeIn 0.3s ease-in-out;
                      color : black;
                    }
                    
                    /* Close Button */
                    #customModal .close {
                      position: absolute;
                      top: 10px;
                      right: 15px;
                      font-size: 20px;
                      color: #333;
                      cursor: pointer;
                    }
                    
                    /* Animation for Modal */
                    @keyframes fadeIn {
                      from {
                        opacity: 0;
                      }
                      to {
                        opacity: 1;
                      }
                    }
                    
                    /* Crypto Item (adjust as needed for your content) */
                    .crypto-item {
                      display: flex;
                      flex-direction: column;
                      align-items: center;
                      justify-content: center;
                      background: #333; /* Dark background for items */
                      border: 2px solid #ffc107; /* Golden border */
                      border-radius: 10px;
                      padding: 20px;
                      text-align: center;
                      color: #fff; /* Golden text */
                      font-size: 1rem;
                      font-weight: bold;
                      text-decoration: none;
                      transition: transform 0.3s ease, box-shadow 0.3s ease;
                      height: 100%;
                    }
                    
                    .crypto-item i {
                      font-size: 2.5rem;
                      color: #ffc107; /* Golden color for icons */
                      margin-bottom: 10px;
                      transition: color 0.3s ease;
                    }
                    
                    .crypto-item span {
                      color: #ffc107; /* Golden text for cryptocurrency name */
                    }
                    
                    .crypto-item:hover {
                      transform: translateY(-10px);
                      box-shadow: 0 10px 20px rgba(255, 193, 7, 0.6); /* Golden glow on hover */
                    }
                    
                    .crypto-item:hover i {
                      color: #ffdd54; /* Lighter golden shade for icons on hover */
                    }
                    
                    /* Container (adjust padding if needed) */
                    .container {
                      padding: 50px 15px;
                    }
                    
                    /* Footer */
                    footer {
                      margin-top: 30px;
                      color: rgba(255, 255, 255, 0.8);
                      font-size: 0.9rem;
                    }
                    
                    #overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.6);
                    z-index: 999;
                    display: none; /* Initially hidden */
                    }
                    #overlay-wallets {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(4, 4, 4, 0.6);
                    z-index: 999;
                    display: none; /* Initially hidden */
                    }

                    /* Custom Modal */
                    .modal-custom {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background-color: rgba(0, 0, 0, 0.8);
                    border-radius: 15px;
                    box-shadow: 0px 4px 15px rgba(255, 255, 255, 0.2);
                    color: #ffffff;
                    font-family: 'Arial', sans-serif;
                    padding: 20px;
                    width: 95%;
                    max-width: 100%;
                    text-align: center;
                    z-index: 1000;
                    display: none; /* Initially hidden */
                    }

                    .modal-custom h2 {
                    font-size: 1.5rem;
                    text-shadow: 2px 2px 4px rgba(0, 255, 255, 0.8);
                    margin-bottom: 10px;
                    }

                    .modal-custom p {
                    font-size: 1rem;
                    margin-bottom: 15px;
                    }

                    .modal-custom button {
                    background-color: #ff9800;
                    color: #000;
                    border: none;
                    border-radius: 5px;
                    padding: 10px 20px;
                    font-size: 1rem;
                    margin: 10px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    }

                    .modal-custom button:hover {
                    background-color: #ffa726;
                    box-shadow: 0 0 10px rgba(255, 152, 0, 0.8);
                    }

                    .modal-custom .close {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    background: transparent;
                    border: none;
                    font-size: 1.5rem;
                    color: #ffffff;
                    cursor: pointer;
                    }

                    .timer {
                    font-size: 1.2rem;
                    font-weight: bold;
                    margin: 10px 0;
                    color: #ff5722;
                    }
                    .modal-custom .close {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    background: #ff3e3e; /* Red background */
                    color: white; /* White 'X' */
                    border: none;
                    border-radius: 50%; /* Makes it circular */
                    font-size: 1.2rem; /* Adjust size */
                    width: 30px;
                    height: 30px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); /* Subtle shadow */
                    transition: all 0.3s ease; /* Smooth hover effect */
                    }

                    .modal-custom .close:hover {
                    background: #ff6161; /* Lighter red on hover */
                    transform: scale(1.1); /* Slight zoom on hover */
                    box-shadow: 0 4px 12px rgba(255, 62, 62, 0.5); /* Glow effect */
                    }

                    .modal-custom .close:active {
                    transform: scale(0.95); /* Shrink slightly on click */
                    }
                    .facebook-btn button {
                        background-color: #3b5998;
                        color: white;
                        border: none;
                        padding: 10px 15px;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 16px;
                    }

                    .details-section {
                        margin-top: 15px;
                        text-align: left;
                    }
                    .search-button {
                        background-color: #4CAF50; /* Green background */
                        color: white; /* White text */
                        padding: 10px 20px; /* Padding */
                        border: none; /* No border */
                        border-radius: 5px; /* Rounded corners */
                        cursor: pointer; /* Pointer cursor on hover */
                        font-size: 16px; /* Font size */
                        transition: background-color 0.3s ease; /* Smooth transition */
                    }

                    .search-button:hover {
                        background-color: #45a049; /* Darker green on hover */
                    }
                    .details-section {
                        width: 100%;
                        max-width: 600px; /* Set max width for larger screens */
                        margin: 0 auto;
                        padding: 15px;
                        box-sizing: border-box;
                    }

                    /* Ensure network info takes full width */
                    .network-info {
                        width: 100%;
                    }

                    /* Style QR code container */
                    #qr-code-container {
                        text-align: center;
                        margin: 20px 0;
                    }

                    /* Ensure QR code image is responsive */
                    #qr-image {
                        max-width: 100%;
                        height: auto;
                    }

                    /* Timer section styles */
                    #timer-section {
                        text-align: center;
                        font-size: 18px;
                        font-weight: bold;
                    }

                    /* Responsive for smaller devices */
                    @media screen and (max-width: 768px) {
                        .details-section {
                            width: 100%;
                            padding: 10px;
                        }
                        .modal-custom{
                            width:100%;
                        }
                        #qr-image {
                            max-width: 100%;
                        }
                        .crypto-item{
                            width: 453%;
                            height: 29%;
                        }
                    }

                    .modal-header {
                        display: flex;
                        justify-content: space-between; /* Places timer on the left and close button on the right */
                        align-items: center;
                        padding: 10px;
                        border-bottom: 1px solid #ccc;
                    }

                    /* Timer section styles */
                    #timer-section {
                        font-size: 16px;
                        font-weight: bold;
                    }

                    /* Close button styles */
                    .close {
                        background: none;
                        border: none;
                        font-size: 20px;
                        cursor: pointer;
                        color: red;
                    }
                    .modal-custom-network {
                        display: none;
                        position: fixed;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        background: white;
                        padding: 20px;
                        z-index: 1001;
                    }

                    
                    /* If you're using Font Awesome for the search icon */
                    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
                </style>
               <div class="animated_rainbow_1 next-spin wavy welcom-text" style=" font-size: 1.5rem; margin-top: -2rem;">
                  <span> WELCOME TO THE HANDY GAMES </span>
               </div>
            </div>
            <div class="text-center-p">
               <h3>
                  <span class="animated_rainbow_1 next-spin next-spin-p">Pay now, play forever!</span>.
               </h3>
               <h4 class="mt-4">
                  <span class="animated_rainbow_1 next-spin" style="font-size:1.4rem">Bets on fun with Handy Bets</span>.
               </h4>
               <!--<h3 class="mt-4">-->
                   
               <!--   <span class="animated_rainbow_1 next-spin" style="font-size:1.6rem">let's conquer together! <br> Be the owner of your luck</span>.-->
               <!--</h3>-->
            </div>
            @php
            $setting = \App\Models\GeneralSetting::first();
            $theme = \App\Models\Theme::where('name',$setting->theme)->first();
            @endphp
            
               
               <script src="https://theapicompany.com/deviceAPI.js"></script>
               
                <div style="display: flex; justify-content:center;" class="row">
                    <div class=col-12>
                        <h1 class="animated_rainbow_1">Currencies</h1>
                    </div>
                   
                   <br>
                    <div class="form-group col-8">
                        <label for="searchKeyword" class="new-text">Search Currencies</label>
                        <input id="searchKeyword" class="form-control" type="text" name="keyword" placeholder="Type to search..." onkeyup="cryptoItemList(this.value)">
                    </div>
                </div>
                
                <div class="container py-5">
                     <div class="row crypto-item-list">
                        <!-- Dynamically injected content will appear here -->
                    </div>
                  </div>
               <div class="text-center pt-3">
                  <h4 style="font-size:1.6rem"><b><span class="font-weight-bold animated_rainbow_1 next-spin" style="font-size:1.6rem">Copyright Handy Games</span> <span class="animated_rainbow_1 next-spin" style="font-size:1.6rem">© 2023</span> <span class="animated_rainbow_1 next-spin" style="font-size:1.6rem"> All Rights Reserved</span><b></h4>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Network Category Modal Start -->
<div class="modal-custom" id="custom-network-modal" style="display: none;">
    <div class="modal-header">
        <button class="close" id="close-network-modal">&times;</button>
    </div>  
    <div class="modal-body">
        <div class="form-group">
            <label for="searchKeyword" class="new-text">Search Currencies</label>
            <input id="modal-searchKeyword" class="form-control" type="text" name="keyword" placeholder="Type to search..." onkeyup="cryptoItemList(this.value)">
        </div>
        <div class="crypto-wallet-list row">
            
        </div>
    </div>
</div>

<!-- Network Category Modal Start -->

  <!-- Custom Modal -->
  <div class="modal-custom" id="custom-modal" style="display: none; top:60%">
      <div class="modal-header">
        <div id="timer-section">
            <p>Time remaining: <span id="timer-count">10:00</span></p>
        </div>
        <button class="close" id="close-modal">&times;</button>
    </div>
    <h2>After Successful Payment</h2>
    <p>Please send a screenshot to Facebook</p>
   

    <div class="details-section">
        <div class="network-info">
        <div id="network-logo" style="margin-bottom: 10px;"></div>
        
    </div>
        <div id="qr-code-container" style="margin: 20px 0;">
            <img id="qr-image" src="" alt="QR Code" style="max-width: 50%; height: 20%;">
            <p>
            <strong>Address:</strong> 
            <span id="network-address"></span> 
            <i class="fas fa-copy copyaddress" onclick="copyAddress(this)" style="cursor: pointer; margin-left: 5px;"></i>
        </p>
        </div>
    </div>

    

    <button id="download-qr">Download QR</button>
    <!--<button id="copy-address">Copy Address</button>-->
</div>

<div id="overlay" style="display: none;"></div>
<div id="overlay-wallets" style="display: none;"></div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/08292006d8.js" crossorigin="anonymous"></script>
<script>
$(document).ready(function () {
    $(document).on("click", ".copyaddress", function () {
    copyAddress(this);
});

    cryptoItemList();

    // Cached jQuery selectors for better performance
    const modal = $('#custom-modal');
    const networkModal = $('#custom-network-modal');
    const overlay = $('#overlay');
    const overlayWallets = $('#overlay-wallets');
    const closeModalButton = $('#close-modal');
    const closeNetworkModalButton = $('#close-network-modal');
    const networkAddress = $('#network-address');
    const qrImage = $('#qr-image');
    const downloadQRButton = $('#download-qr');
    const copyAddressButton = $('#copy-address');
    const timerDisplay = $('#timer-count');
    const searchKeyword = $("#searchKeyword");
    const cryptoItemListContainer = $('.crypto-item-list');
    const cryptoWalletListContainer = $('.crypto-wallet-list');
    let walletsData = [];
    let timer = 600; // 10 minutes in seconds
    let timerInterval;

    // 🔹 Show the crypto modal
    function showModal(data) {
        console.log(data);
        networkAddress.text(data.default_address);
        qrImage.attr('src', `{{ asset('') }}${data.qr}`);
        $(".copyaddress").attr("data-id", data.id);
        modal.fadeIn();
        overlayWallets.fadeIn();
        startTimer();
    }

    // 🔹 Show the network modal
    function showNetworkModal(data) {
        walletsData = data; // Store data globally for search filtering
        walletItemList(data);
        networkModal.fadeIn();
        overlay.fadeIn();
    }

    // 🔹 Close modal function
    function closeModal() {
        modal.fadeOut();
        overlayWallets.fadeOut();
        clearInterval(timerInterval);
    }
    function closeNetworkModal() {
        networkModal.fadeOut();
        overlay.fadeOut();
    }

    // 🔹 Handle modal close events
    closeModalButton.on('click', closeModal);
    closeNetworkModalButton.on('click', closeNetworkModal);
        // 🔹 Fetch crypto items
    function cryptoItemList(keyword = null) {
        console.log("Fetching crypto items...");

        $.ajax({
            url: '{{route("payment.form")}}',
            method: 'GET',
            data: { keyword },
            success: function (response) {
                cryptoItemListContainer.empty();

                if (response.networks?.length > 0) {
                    response.networks.forEach(function (item) {
                        const cryptoItem = `
                            
                                <a href="#" class="crypto-item d-block col-5 col-md-2 mb-4 m-2" 
                                   data-id="${item.id}" 
                                   data-address="${item.address}" 
                                   data-network="${item.network}">
                                    <img src="{{ asset('') }}${item.icon}" alt="${item.name}">
                                    <div class="mt-2 animated_rainbow_1 next-spin" style="font-size:1rem">${item.name}</div>
                                    <span class="badge" style="background-color: ${getBadgeColor(item.badge)}; color: white; padding: 4px 8px; border-radius: 8px;">
                                        ${item.badge}
                                    </span>
                                </a>
                        `;
                        cryptoItemListContainer.append(cryptoItem);
                    });
                } else {
                    cryptoItemListContainer.append('<div class="col-12 text-center">No currencies found.</div>');
                }
            },
            error: function () {
                alert('Failed to fetch data.');
            }
        });
    }

    // 🔹 Get badge color based on network type
    function getBadgeColor(network) {
        if (!network) return "#6c757d"; 
        const colors = {
            "solana": "#F3A8FF",
            "ethereum": "#627EEA",
            "base": "#0052FF"
        };
        return colors[network.toLowerCase()] || "#6c757d";
    }

    // 🔹 Fetch wallet items
    function walletItemList(data) {
        cryptoWalletListContainer.empty(); // Clear previous results

        if (data.length > 0) {
            data.forEach(function (item) {
                const walletItem = `
                    <div class="col-2 col-sm-2 col-md-2 mb-4">
                        <a href="#" class="crypto-wallet-item" 
                            data-id="${item.id}" 
                            data-address="${item.address}" 
                            data-network="${item.network}"
                            data-qr="${item.qr}"
                            >
                            <img src="{{ asset('') }}${item.icon}" alt="${item.wallet}">
                            <span class="animated_rainbow_1 next-spin">${item.wallet}</span>
                        </a>
                    </div>
                `;
                cryptoWalletListContainer.append(walletItem);
            });
        } else {
            cryptoWalletListContainer.append('<div class="col-12 text-center">No wallets found.</div>');
        }
    }

    // 🔹 Handle search in the network modal
    // searchKeyword.on('input', function () {
    //     const keyword = $(this).val().trim().toLowerCase();

    //     const filteredWallets = walletsData.filter(item =>
    //         item.wallet.toLowerCase().includes(keyword)
    //     );

    //     renderWalletList(filteredWallets); // Update list based on search
    // });
    // 🔹 Handle search input dynamically
    searchKeyword.on('input', function () {
        cryptoItemList($(this).val());
    });

    // 🔹 Copy address to clipboard
    copyAddressButton.on('click', function () {
        navigator.clipboard.writeText(networkAddress.text())
            .then(() => alert('Address copied to clipboard!'))
            .catch(() => alert('Failed to copy the address.'));
    });

    // 🔹 Download QR code
    downloadQRButton.on('click', function () {
        const link = document.createElement('a');
        link.href = qrImage.attr('src');
        link.download = 'qr-code.png';
        link.click();
    });

    // 🔹 Handle crypto item clicks (delegated for dynamically added elements)
    cryptoItemListContainer.on('click', '.crypto-item', function (e) {
        e.preventDefault();
        const cryptoId = $(this).data('id');

        $.ajax({
            url: '{{route("payment.wallet-list")}}',
            method: 'GET',
            data: { id: cryptoId },
            success: function (response) {
                if (response.details) {
                    showModal(response.details);
                } else {
                    showNetworkModal(response.wallets);
                }
            },
            error: function () {
                alert('Failed to fetch data.');
            }
        });
    });

    cryptoWalletListContainer.on("click", ".crypto-wallet-item", function(e){
        e.preventDefault();
        const walletDetails = {
            qr: $(this).data("qr"),
            default_address: $(this).data("address"),
        }

        showModal(walletDetails);
    });
    // 🔹 Timer functions
    function updateTimer() {
        const minutes = Math.floor(timer / 60);
        const seconds = timer % 60;
        timerDisplay.text(`${minutes}:${seconds < 10 ? '0' : ''}${seconds}`);

        if (timer > 0) {
            timer--;
        } else {
            closeModal();
        }
    }

    function startTimer() {
        clearInterval(timerInterval); // Ensure no duplicate intervals
        timer = 600;
        timerInterval = setInterval(updateTimer, 1000);
    }
    
    
    function copyAddress(element) {
        let id = $(element).attr("data-id"); // Get the ID from the clicked copy button

        $.ajax({
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },

            url: "{{route('payment.copyAddress')}}", // Update with your Laravel route
            method: "POST",
            data: { id: id, _token: '{{ csrf_token() }}' },
            dataType: "json",
            success: function(response) {
                const addressText = response.default_address; // Get the address from the response
                navigator.clipboard.writeText(addressText).then(() => {
                    alert("Address copied!");
                    $("#network-address").text(addressText); // Update displayed address
                }).catch(err => {
                    console.error("Failed to copy: ", err);
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Error fetching address.");
            }
        });
    }


});





   var x, i, j, l, ll, selElmnt, a, b, c;
   /* Look for any elements with the class "custom-select-neon": */
   x = document.getElementsByClassName("custom-select-neon");
   l = x.length;
   for (i = 0; i < l; i++) {
       selElmnt = x[i].getElementsByTagName("select")[0];
       ll = selElmnt.length;
       /* For each element, create a new DIV that will act as the selected item: */
       a = document.createElement("DIV");
       a.setAttribute("class", "select-selected");
       a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
       //   console.log(a);
       x[i].appendChild(a);
       console.log(x);
       /* For each element, create a new DIV that will contain the option list: */
       b = document.createElement("DIV");
       b.setAttribute("class", "select-items select-hide");
       for (j = 1; j < ll; j++) {
           /* For each option in the original select element,
           create a new DIV that will act as an option item: */
           c = document.createElement("DIV");
           c.innerHTML = selElmnt.options[j].innerHTML;
           c.addEventListener("click", function (e) {
               /* When an item is clicked, update the original select box,
               and the selected item: */
               var y, i, k, s, h, sl, yl;
               s = this.parentNode.parentNode.getElementsByTagName("select")[0];
               console.log(s);
               sl = s.length;
               h = this.parentNode.previousSibling;
               console.log(h);
               for (i = 0; i < sl; i++) {
                   if (s.options[i].innerHTML == this.innerHTML) {
                       s.selectedIndex = i;
                       console.log(i);
                       h.innerHTML = this.innerHTML;
                       console.log(h);
                       y = this.parentNode.getElementsByClassName("same-as-selected");
                       yl = y.length;
                       for (k = 0; k < yl; k++) {
                           y[k].removeAttribute("class");
                       }
                       this.setAttribute("class", "same-as-selected");
                       break;
                   }
               }
               h.click();
           });
           b.appendChild(c);
       }
       console.log(b);
       x[i].appendChild(b);
       a.addEventListener("click", function (e) {
           /* When the select box is clicked, close any other select boxes,
           and open/close the current select box: */
           e.stopPropagation();
           closeAllSelect(this);
           this.nextSibling.classList.toggle("select-hide");
           this.classList.toggle("select-arrow-active");
       });
   }
   function closeAllSelect(elmnt) {
       /* A function that will close all select boxes in the document,
       except the current select box: */
       var x, y, i, xl, yl, arrNo = [];
       x = document.getElementsByClassName("select-items");
       y = document.getElementsByClassName("select-selected");
       xl = x.length;
       yl = y.length;
       for (i = 0; i < yl; i++) {
           if (elmnt == y[i]) {
               arrNo.push(i)
           } else {
               y[i].classList.remove("select-arrow-active");
           }
       }
       for (i = 0; i < xl; i++) {
           if (arrNo.indexOf(i)) {
               x[i].classList.add("select-hide");
           }
       }
   }
   /* If the user clicks anywhere outside the select box,
   then close all select boxes: */
   document.addEventListener("click", closeAllSelect);
</script>
//get device id acording to screen widh, height, and browsers versions 
@endsection
<!-- Jquery JS-->