<?php
session_start();
include 'conn.php';

$session_id = session_id();

// Clear cart after successful payment
$delete_query = "DELETE FROM cart WHERE session_id = ?";
$stmt = mysqli_prepare($con, $delete_query);
mysqli_stmt_bind_param($stmt, "s", $session_id);
mysqli_stmt_execute($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Payment Successful</title>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=../index.php"> <!-- Auto return -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="text-center">
        <h2 class="text-success">Payment Successful!</h2>
        <p>Thank you for your purchase. Redirecting to the home page...</p>
    </div>
</body>

</html>
