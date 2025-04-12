<?php
function cart_number() {
    global $con;
    $session_id = session_id();

    $query = "SELECT SUM(quantity) AS total FROM cart WHERE session_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $session_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query Error: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);
    echo ($row['total'] ?? 0);
}
?>
