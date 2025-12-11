<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us | Sips of Serenity</title>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Css/about.css">
  <link rel="stylesheet" href="Css/index.css">

</head>
<body>
    <nav class="navbar">
        <div class="nav-brand">
            <img src="Assets/logo1.png" alt="Sips of Serenity" id="navLogo">
        </div>
        
        <div class="nav-toggle" id="navToggle">
            <i class='bx bx-menu'></i>
        </div>

        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="about.php" class="active">About</a>
            <a href="contact.php">Contact</a>
        </div>

        <div class="nav-auth">
            <?php if(isset($_SESSION['username'])): ?>
                <a href="user-profile.php" class="username">Welcome, <?php echo $_SESSION['username']; ?></a>
                <div class="cart-icon">
                    <i class='bx bx-cart'></i>
                    <span class="cart-count">0</span>
                </div>
                <!-- Update the cart popup section -->
                <div class="cart-popup">
                    <div class="cart-popup-header">
                        <h3>Shopping Cart</h3>
                        <span class="close-cart">×</span>
                    </div>
                    <div class="cart-items">
                        <!-- Cart items will be dynamically added here -->
                    </div>
                    <div class="cart-total">
                        Total: $<span class="total-amount">0.00</span>
                    </div>
                    <form id="paymentForm" action="payment.php" method="POST">
                        <input type="hidden" name="cart_items" id="cartItemsInput">
                        <input type="hidden" name="total_amount" id="totalAmountInput">
                        <button type="submit" class="buy-now-btn">Buy Now</button>
                    </form>
                </div>

                <a href="logout.php" class="logout-btn">Logout</a>
            <?php else: ?>
                <a href="login.php" class="login-btn">Login</a>
            <?php endif; ?>
        </div>    
    </nav>
<header>
    <br><br>
  <h1>About Our Cafe</h1><br><br>
  <p>Welcome to your cozy escape, where every sip and bite is crafted to bring you warmth and delight</p>
</header>

<div class="container">
  <div class="about-sections">
    <div class="section">
      <h2>Our Story</h2>
      <p>Founded with a passion for coffee and a love for community, SOP started as a small idea between friends and grew into a beloved spot for students, creatives, and locals alike. Our cafe was created to be more than just a coffee shop – it’s a place where ideas spark, friendships blossom, and every visit feels like coming home.</p>
    </div>
    <div class="section">
      <h2>Our Mission</h2>
      <p>At Sips of Serenity, our mission is to provide a welcoming and inclusive space where people can unwind, connect, and savor the finest coffee, teas, and locally-inspired dishes. We are committed to sustainability, sourcing responsibly, and delivering an unforgettable experience that makes each visit a delightful escape from the everyday.</p>
    </div>
    <div class="section">
      <h2>Our Vision</h2>
      <p>To be a vibrant gathering place that celebrates community, creativity, and quality in every cup and plate, inspiring a deep connection with the flavors and moments that make life rich and memorable.</p>
    </div>
  </div>
</div>
<!-- Footer -->
    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-section">
                <img src="Assets/logo1.png" alt="Sips of Serenity">
                <p>Your daily dose of comfort and luxury in every cup.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <a href="index.php">Home</a>
                <a href="menu.php">Menu</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
            </div>
            <div class="footer-section">
                <h3>Opening Hours</h3>
                <p>Monday - Friday: 7am - 10pm</p>
                <p>Saturday - Sunday: 8am - 11pm</p>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-links">
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-instagram'></i></a>
                    <a href="#"><i class='bx bxl-twitter'></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Sips of Serenity. All rights reserved.</p>
        </div>
    </footer>
<script>
    const navLogo = document.getElementById('navLogo');
    const defaultLogo = 'Assets/logo1.png';
    const scrollLogo = 'Assets/logo2.png';

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navLogo.src = scrollLogo;
        } else {
            navLogo.src = defaultLogo;
        }
    })
    // JavaScript for carousel functionality
    window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

    let currentIndex = 0;
    const images = ["cof6.png", "cof11.png", "cof12.png", "cof14.png","cof5.png"];
    const carousel = document.querySelector('.carousel img');

    function showImage(index) {
    carousel.src = images[index];
    }

    function prevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    showImage(currentIndex);
    }

    function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    showImage(currentIndex);
    }

    // Initialize with the first image
    showImage(currentIndex);

</script>
</body>
</html>
