<?php
session_start();
include('conn.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Payment Failed</title>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=../cart.php"> <!-- Auto return -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="text-center">
        <h2 class="text-danger">Payment Failed!</h2>
        <p>Transaction was not completed. Redirecting to try again...</p>
    </div>
</body>

</html>
