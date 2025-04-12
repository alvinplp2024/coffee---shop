<?php
session_start();
include('conn.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f8d7da;
            color: #721c24;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
        }
        h1 {
            color: #dc3545;
        }
        p {
            font-size: 18px;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Payment Error</h1>
        <p>We encountered an issue while processing your payment request.</p>
        <p>Please check your details and try again.</p>
        <a href="../cart.php">Returning to Cart Page</a>
    </div>
</body>

</html>
