<?php
session_start();
include('conn.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Payment Status</title>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="10;url=payment_success.php"> <!-- Auto return -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="text-center">
        <h2 class="text-success">Waiting for Transaction Approval...</h2>
        <p>Please complete the payment by entering your M-Pesa PIN.</p>
        <p>If the transaction is not completed, you will be redirected shortly.</p>
    </div>
</body>

</html>
