<?php
include('conn.php');
include('functions.php');

// Add/Update Inventory
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_inventory'])) {
    $item_name = mysqli_real_escape_string($con, $_POST['item_name']);
    $item_price = (float)$_POST['item_price'];
    $check = "SELECT * FROM inventory WHERE item_name='$item_name'";
    $result = mysqli_query($con, $check);

    if (mysqli_num_rows($result) > 0) {
        $query = "UPDATE inventory SET price='$item_price' WHERE item_name='$item_name'";
    } else {
        $query = "INSERT INTO inventory (item_name, price) VALUES ('$item_name', '$item_price')";
    }
    mysqli_query($con, $query);
}




// Add Menu Item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_menu_item'])) {
  $menu_item_name = mysqli_real_escape_string($con, $_POST['menu_item_name']);
  $menu_item_price = (float)$_POST['menu_item_price'];

  // Handle image upload
  $image_name = $_FILES['menu_image']['name'];
  $image_tmp_name = $_FILES['menu_image']['tmp_name'];
  $upload_dir = 'uploads/';
  $image_path = $upload_dir . basename($image_name);

  if (move_uploaded_file($image_tmp_name, $image_path)) {
      $query = "INSERT INTO menu (item_name, price, image) VALUES ('$menu_item_name', '$menu_item_price', '$image_path')";
      mysqli_query($con, $query);
  }
}


// Fetch Menu Items
$menu_items = mysqli_query($con, "SELECT * FROM menu");


// Clear Orders
if (isset($_POST['clear_orders'])) {
    mysqli_query($con, "DELETE FROM orders");
}

// Clear Feedback
if (isset($_POST['clear_feedback'])) {
    mysqli_query($con, "DELETE FROM feedback");
}

// Fetch Data
$orders = mysqli_query($con, "SELECT * FROM orders");
$inventory = mysqli_query($con, "SELECT * FROM inventory");
$feedback = mysqli_query($con, "SELECT * FROM feedback");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard - Coffee Shop</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #3b141c, #5e2b3f);
            color: #fff;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        header, footer {
            text-align: center;
            padding: 1.5rem;
            background: #f3961c;
            color: #fff;
        }
        h1, h2 {
            margin: 0 0 20px;
            font-weight: 600;
        }
        main {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }

        /* Sections */
        section {
            margin-bottom: 30px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        /* Inputs and Buttons */
        input {
            padding: 12px;
            margin: 10px 0;
            width: 250px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            color: #3b141c;
        }
        button {
            padding: 12px 20px;
            margin: 10px 5px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
            font-weight: 600;
        }
        button:hover {
            opacity: 0.8;
        }
        .btn-primary {
            background: #f3961c;
            color: white;
        }
        .btn-danger {
            background: #d9534f;
            color: white;
        }
        .btn-admin {
            background: #17a2b8;
            color: white;
        }
        .btn-logout {
            background: #ff4444;
            color: white;
        }

        /* Lists */
        ul {
            padding: 0;
            list-style: none;
        }
        ul li {
            margin: 10px 0;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        /* Flex Layout */
        .flex-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        /* Footer */
        footer {
            font-size: 14px;
        }

        /* Top Menu */
        .top-menu {
            text-align: right;
            padding: 10px;
        }
        
        




        .menu-grid {
          display: grid;
          grid-template-columns: repeat(4, 1fr); /* 4 items per row */
          gap: 20px;
        }
        .menu-item {
          text-align: center;
          padding: 10px;
        
        }
        .menu-item img {
          max-width: 100%;
          border-radius: 8px;
        }
    </style>
</head>

<body>
    <header>
        <h1>☕ Bradegate Coffee Shop - Admin Dashboard</h1>
        <div class="top-menu">
            <a href="admin_register.php"><button class="btn-admin">Add Admin</button></a>
            <a href="logout.php"><button class="btn-logout">Logout</button></a>
        </div>
    </header>

    <main>
        <!-- Manage Orders -->
        <section id="orders">
            <h2>📦 Manage Orders</h2>
            <ul>
                <?php while ($row = mysqli_fetch_assoc($orders)) : ?>
                    <li><?= $row['item_name'] ?> - Ksh <?= $row['price'] ?></li>
                <?php endwhile; ?>
            </ul>
            <form method="POST">
                <button class="btn-danger" name="clear_orders">Clear Orders</button>
            </form>
        </section>


        <!-- Add Menu Item -->
        <section id="menu">
          <h2>📋 Add Menu Item</h2>
          <form method="POST" enctype="multipart/form-data">
            <input type="text" name="menu_item_name" placeholder="Menu Item Name" required>
            <input type="number" name="menu_item_price" placeholder="Price" required>
            <input type="file" name="menu_image" accept="image/*" required>
            <button class="btn-primary" type="submit" name="add_menu_item">Add to Menu</button>
          </form>
          <h3>🍴 Current Menu:</h3>
          <div class="menu-grid">
            <?php while ($menu = mysqli_fetch_assoc($menu_items)) : ?>
              <div class="menu-item">
                <img src="<?= $menu['image'] ?>" alt="<?= $menu['item_name'] ?>" width="100">
                <h4><?= htmlspecialchars($menu['item_name']) ?></h4>
                <p>Ksh <?= number_format($menu['price'], 2) ?></p>
              </div>
              <?php endwhile; ?>
          </div>

        </section>


        <!-- Update Inventory -->
        <section id="inventory">
            <h2>📊 Manage Inventory</h2>
            <form method="POST">
                <input type="text" name="item_name" placeholder="Item Name" required>
                <input type="number" name="item_price" placeholder="Price" required>
                <button class="btn-primary" type="submit" name="update_inventory">Update Price</button>
            </form>

            <h3>✅ Current Inventory:</h3>
            <ul>
                <?php while ($item = mysqli_fetch_assoc($inventory)) : ?>
                    <li><?= $item['item_name'] ?> - Ksh <?= $item['price'] ?></li>
                <?php endwhile; ?>
            </ul>
        </section>

        <!-- Generate Receipt -->
        <section id="receipts">
            <h2>🧾 Generate Receipts</h2>
            <form method="POST">
                <button class="btn-primary" type="submit" name="generate_receipt">Generate Receipt</button>
            </form>
        </section>

        <!-- Customer Feedback -->
        <section id="feedback">
            <h2>💬 Customer Feedback</h2>
            <ul>
                <?php while ($fb = mysqli_fetch_assoc($feedback)) : ?>
                    <li>
                        <strong><?= $fb['customer_name'] ?> (<?= $fb['email'] ?>):</strong> <?= $fb['message'] ?>
                    </li>
                <?php endwhile; ?>
            </ul>
            <form method="POST">
                <button class="btn-danger" name="clear_feedback">Clear Messages</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Bradegate Coffee Shop - Admin Panel</p>
    </footer>

</body>
</html>
