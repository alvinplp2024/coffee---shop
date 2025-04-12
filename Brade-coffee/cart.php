<?php
session_start();
include('conn.php');
include('functions.php');

// Ensure the user session is active
$session_id = session_id();

// Handle cart item removal
if (isset($_POST['remove_item'])) {
    $remove_id = $_POST['remove_item'];
    $delete_query = "DELETE FROM cart WHERE session_id = ? AND item_id = ?";
    $stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($stmt, "si", $session_id, $remove_id);
    mysqli_stmt_execute($stmt);
}

// Handle quantity update
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $item_id => $qty) {
        if ($qty > 0) {
            $update_query = "UPDATE cart SET quantity = ? WHERE session_id = ? AND item_id = ?";
            $stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($stmt, "isi", $qty, $session_id, $item_id);
            mysqli_stmt_execute($stmt);
        }
    }
}

$query = "SELECT c.item_id, c.quantity, m.item_name, m.price, m.image 
          FROM cart c 
          JOIN menu m ON c.item_id = m.id 
          WHERE c.session_id = ?";
$stmt = mysqli_prepare($con, $query);
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($con));
}
mysqli_stmt_bind_param($stmt, "s", $session_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$cart_items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cart_items[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bradegate Coffee Shop - Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
    .cart-img {
        width: 80px; /* Set width to desired size */
        height: 80px; /* Set height to desired size */
        object-fit: cover; /* Ensure image maintains aspect ratio */
        border-radius: 8px; /* Optional: Rounds the corners */
    }
</style>

</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Your Cart</h2>

        <?php if (!empty($cart_items)): ?>
            <form action="" method="post">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Image</th>
                            <th>Price (KES)</th>
                            <th>Quantity</th>
                            <th>Total (KES)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                <td>
                                    <img src="admin/<?php echo htmlspecialchars($item['image']); ?>" 
                                    alt="<?php echo htmlspecialchars($item['item_name']); ?>" 
                                    class="cart-img">
                                </td>
                                <td><?php echo number_format($item['price'], 2); ?></td>
                                <td><input type="number" name="quantity[<?php echo $item['item_id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="form-control"></td>
                                <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                <td>
                                    <button type="submit" name="remove_item" value="<?php echo $item['item_id']; ?>" class="btn btn-danger btn-sm">Remove</button>
                                </td>
                            </tr>
                            <?php $total += $item['price'] * $item['quantity']; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h4>Total: KES <?php echo number_format($total, 2); ?></h4>

                <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
                <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
                <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
            </form>

        <?php else: ?>
            <p class="text-center">Your cart is empty. <a href="index.php">Go back to shop</a></p>
        <?php endif; ?>
    </div>
</body>

</html>
