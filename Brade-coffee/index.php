<?php
session_start();
include('conn.php');
include('functions.php');

// Handle contact form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $query = "INSERT INTO feedback (customer_name, email, message) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $success = "Thank you, $name! Your message has been received.";
}

// Fetch menu items


$menuItems = [];
$menuQuery = "SELECT * FROM menu";
$menuResult = mysqli_query($con, $menuQuery);

while ($row = mysqli_fetch_assoc($menuResult)) {
    $menuItems[] = $row;
}

// Fetch testimonials
$testimonialsQuery = "SELECT * FROM testimonials ORDER BY created_at DESC";
$testimonialsResult = mysqli_query($con, $testimonialsQuery);
$testimonials = [];
while ($row = mysqli_fetch_assoc($testimonialsResult)) {
    $testimonials[] = $row;
}










// Add to Cart Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $item_name = mysqli_real_escape_string($con, $_POST['item_name']);
    $price = (float)$_POST['price'];
    $session_id = session_id(); // Unique session for each user

    $check_cart = mysqli_query($con, "SELECT * FROM cart WHERE item_id = '$item_id' AND session_id = '$session_id'");
    if (mysqli_num_rows($check_cart) > 0) {
        mysqli_query($con, "UPDATE cart SET quantity = quantity + 1 WHERE item_id = '$item_id' AND session_id = '$session_id'");
    } else {
        mysqli_query($con, "INSERT INTO cart (item_id, item_name, price, session_id) VALUES ('$item_id', '$item_name', '$price', '$session_id')");
    }

    header("Location: index.php"); // Refresh page
    exit();
}

// Check if the user is an admin
$isAdmin = isset($_SESSION['user']) && $_SESSION['user'] === 'admin@bradegate.com';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bradegate Coffee Shop</title>
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">



    <!-- Grid Layout -->
<style>
    .testimonial-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive columns */
        gap: 20px;
    }

    .testimonial {
        text-align: center;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .user-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
    }

    .name {
        margin: 10px 0;
        font-size: 1.2em;
    }

    .feedback {
        font-style: italic;
        color: #555;
    }

    .menu-content {
        display: flex;
        flex-direction: column;
        align-items: center; /* Center horizontally */
        justify-content: center; /* Center vertically */
        text-align: center; /* Ensure text alignment */
    }

    .add-to-cart {
        background-color: #4CAF50; /* Green button */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
    }

</style>



</head>

<body>

<header>
    <nav class="navbar section-content">
        <a href="#" class="nav-logo">
            <p class="logo-text"><img src="images/logo.png" alt=""> Bradegate</p>
        </a>
        <ul class="nav-menu">
            <button id="menu-close-button" class="fas fa-times" style="display:none"></button>
            
            
            <li class="nav-item">
                <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_number(); ?></sup></a>
            </li>


            <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="#about-section" class="nav-link">About</a></li>
            <li class="nav-item"><a href="#menu" class="nav-link">Menu</a></li>
            <li class="nav-item"><a href="#Gallery" class="nav-link">Gallery</a></li>
            <li class="nav-item"><a href="#Testimonials" class="nav-link">Testimonials</a></li>
            <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
            <li class="nav-item"><a href="admin/adminlogin.php" class="nav-link">Admin Login</a></li>
            <?php if ($isAdmin): ?>
                <li class="nav-item"><a href="admin.php" class="nav-link">Admin Panel</a></li>
            <?php endif; ?>
        </ul>

        <button id="menu-open-button" class="fas fa-bars" style="display:none"></button>
    </nav>
</header>

<main>
    <section class="hero-section">
        <div class="section-content">
            <div class="hero-details">
                <h2 class="title">Best Coffee</h2>
                <h3 class="subtitle">Make your day great with our special coffee!</h3>
                <p class="description">Welcome to our coffee paradise, where every bean tells a story and every cup sparks joy.</p>
                <div class="buttons">
                    <a href="#menu" class="button order-now">Order Now</a>
                    <a href="#contact" class="button contact-us">Contact Us</a>
                </div>
            </div>
            <div class="hero-image-wrapper">
                <img src="images/coffee-hero-section.png" alt="Hero" class="hero-image">
            </div>
        </div>
    </section>
</main>




<!--About-->
<section class="about-section">
    <div class="section-content" id="about-section">
        <div class="about-image-wrapper">
            <img src="images/about-image.jpg" alt="About" class="about-image">
        </div>
        <div class="about-details">
            <h2 class="section-title">About Us</h2>
            <p class="text"> <p>At BRADEGATE COFFEE SHOP, we are passionate about serving the best coffee and coffee products. Our mission is to provide 
                high-quality beverages and a relaxing environment for coffee lovers.</p>
            
                <div class="social-link-list">
                    <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Menu Section -->
<section id="menu">
    <h2 class="section-title">Our Menu</h2>
    <div class="menu-items">
        <?php foreach ($menuItems as $item): ?>
            <div class="menu-item">
                <img src="admin/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>">
                <div class="menu-content">
                    <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                    <p>KES <?php echo number_format($item['price'], 2); ?></p>

                    <!-- Add to Cart Form -->
                    <form method="POST">
                        <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($item['item_name']); ?>">
                        <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                        <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                    </form>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>






<!--Gallery-->
<section class="gallery-section" id="Gallery">
    <h2 class="section-title">Gallery</h2>
    <div class="section-content">
        <ul class="gallery-list">
          <li class="gallery-item">
            <img src="images/gallery-1.jpg" alt="gallery" class="gallery-image">
          </li>  
          <li class="gallery-item">
            <img src="images/gallery-2.jpg" alt="gallery" class="gallery-image">
          </li>  
          <li class="gallery-item">
            <img src="images/gallery-3.jpg" alt="gallery" class="gallery-image">
          </li>  
          <li class="gallery-item">
            <img src="images/gallery-4.jpg" alt="gallery" class="gallery-image">
          </li>  
          <li class="gallery-item">
            <img src="images/gallery-5.jpg" alt="gallery" class="gallery-image">
          </li>  
          <li class="gallery-item">
            <img src="images/gallery-6.jpg" alt="gallery" class="gallery-image">
          </li>  
        </ul>
    </div>
</section>

<!-- Testimonials Section 
<section id="Testimonials">
    <h2 class="section-title">Testimonials</h2>
    <div class="testimonial-items">
        <?php foreach ($testimonials as $testimonial): ?>
            <div class="testimonial">
                <p>"<?php echo htmlspecialchars($testimonial['testimonial']); ?>"</p>
                <h4>- <?php echo htmlspecialchars($testimonial['customer_name']); ?></h4>
            </div>
        <?php endforeach; ?>
    </div>
</section>  -->




<!-- Testimonials -->
<section class="testimonials-section" id="Testimonials">
    <h2 class="section-title">Testimonials</h2>
    <div class="section-content">
        <div class="testimonial-grid">
            <div class="testimonial">
                <img src="images/user-1.jpg" alt="user" class="user-image">
                <h3 class="name">Sarah</h3>
                <i class="feedback">"Loved the French roast. Perfectly balanced and rich. Will order again."</i>
            </div>
            <div class="testimonial">
                <img src="images/user-2.jpg" alt="user" class="user-image">
                <h3 class="name">Wilson</h3>
                <i class="feedback">"Great Espresso blend! Smooth and bold flavor. Fast shipping too."</i>
            </div>
            <div class="testimonial">
                <img src="images/user-3.jpg" alt="user" class="user-image">
                <h3 class="name">Michael</h3>
                <i class="feedback">"Fantastic mocha flavor. Fresh and aromatic. Quick shipping!"</i>
            </div>
            <div class="testimonial">
                <img src="images/user-4.jpg" alt="user" class="user-image">
                <h3 class="name">Emily</h3>
                <i class="feedback">"Excellent quality! Fresh beans and quick delivery. Highly recommended."</i>
            </div>
            <div class="testimonial">
                <img src="images/user-5.jpg" alt="user" class="user-image">
                <h3 class="name">Anthony</h3>
                <i class="feedback">"Best decaf I ever tried! Smooth and flavorful. Arrived promptly."</i>
            </div>
        </div>
    </div>
</section>



         

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <h2 class="section-title">Contact Us</h2>
    <div class="section-content">



    <ul class="contact-info-list">
            <li class="contact-info">
                <i class="fa-solid fa-location-crosshair">
                    <p>Nyeri</p>
                </i>
            </li>
            <li class="contact-info">
                <i class="fa-regular fa-envelope">
                    <p>Kiprotichmeshack935@gmail.com</p>
                </i>
            </li>
            <li class="contact-info">
                <i class="fa-regular fa-phone">
                    <p>+254743042274</p>
                </i>
            </li>
            <li class="contact-info">
                <i class="fa-regular fa-clock">
                    <p>Monday-Friday: 8:30 AM- 5:00PM</p>
                </i>
            </li>
            <li class="contact-info">
                <i class="fa-regular fa-clock">
                    <p>Sunday: Closed</p>
                </i>
            </li>
            <li class="contact-info">
                <i class="fa-solid fa-globe">
                    <p>www.aboutbrade.com</p>
                </i>
            </li>
        </ul>


        <?php if (isset($success)): ?>
            <p class="success-message"><?php echo $success; ?></p>
        <?php endif; ?>

        <form action="" method="POST" class="contact-form">
            <input type="text" name="name" placeholder="Your Name" class="form-input" required>
            <input type="email" name="email" placeholder="Email" class="form-input" required>
            <textarea name="message" placeholder="Your Message" class="form-input" required></textarea>
            <button type="submit" name="submit" class="submit-button">Submit</button>
        </form>
    </div>
</section>

<footer class="footer">
    <p>&copy; 2025 BRADEGATE COFFEE SHOP. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    const menuOpenButton = document.querySelector("#menu-open-button");
    const menuCloseButton = document.querySelector("#menu-close-button");

    menuOpenButton.addEventListener('click', () => {
        document.body.classList.toggle("show-mobile-menu");
    });

    menuCloseButton.addEventListener('click', () => menuOpenButton.click());
</script>

</body>
</html>

<?php mysqli_close($con); ?>
