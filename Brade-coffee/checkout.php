<?php
session_start();
include 'conn.php';

$session_id = session_id();

// Calculate total amount from the cart
$query = "SELECT SUM(m.price * c.quantity) AS total_amount FROM cart c JOIN menu m ON c.item_id = m.id WHERE c.session_id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "s", $session_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$total_amount = $row['total_amount'] ?? 0;

if ($total_amount > 0) {
    // Redirect to stkpush page with the total amount
    header("Location: stkpush/index.php?amount=$total_amount");
    exit();
} else {
    echo "Your cart is empty!";
}
?>
