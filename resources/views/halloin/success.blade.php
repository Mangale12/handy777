
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://handy777.net/images/handy_fav.png" rel="icon" type="image/x-icon">
<link href="https://handy777.net/images/handy_fav.png" rel="apple-touch-icon" type="image/x-icon">
<link rel="shortcut icon" href="https://handy777.net/images/handy_fav.png" type="image/x-icon">
    <title>Registration Form</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Full height of the viewport */
            background-image: url('/images/halloin.png'); /* Use your image URL */
            background-size: contain; /* Background covers the entire screen */
            background-repeat: no-repeat;
            background-position: center;
            background-color: #d2845e;
        }

        /* Form container */
        .form-container {
            margin-top: 9%;
            width: 100%;
            max-width: 400px; /* Maximum width for larger screens */
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.094); /* White background with transparency */
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Light shadow for depth */
            text-align: center;
        }

        /* Form elements */
        .form-container h1 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="tel"] {
            width: 100%; /* Full width for inputs */
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .form-container input[type="submit"] {
            width: 100%; /* Full width for submit button */
            padding: 12px;
            background-color: #ff5733;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .form-container input[type="submit"]:hover {
            background-color: #e04d27;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-container {
                width: 90%; /* Slightly reduce width on smaller screens */
            }

            .form-container h1 {
                font-size: 1.25rem; /* Smaller font for heading */
            }

            .form-container input[type="text"],
            .form-container input[type="email"],
            .form-container input[type="tel"] {
                padding: 10px; /* Adjust padding for smaller screens */
            }

            .form-container input[type="submit"] {
                padding: 10px; /* Adjust padding for submit button */
            }
        }

        /* iPhone 5/SE */
        @media (max-width: 320px) {
            .form-container {
                width: 95%; /* Take almost full width on very small screens */
            }

            .form-container h1 {
                font-size: 1rem; /* Smaller heading */
            }

            .form-container input[type="text"],
            .form-container input[type="email"],
            .form-container input[type="tel"],
            .form-container input[type="submit"] {
                padding: 8px; /* Reduce padding for very small screens */
            }
        }
    </style>
</head>
<body>
    <!-- Transparent Form -->
    <div class="form-container">
        <h1>Please check your email for the comformation .</h1>
        
    </div>
</body>
</html>

