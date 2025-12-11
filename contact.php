<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
    
    $sql = "INSERT INTO contact_messages (name, email, subject, message, user_id) 
            VALUES ('$name', '$email', '$subject', '$message', " . ($user_id ? $user_id : 'NULL') . ")";
            
    if ($conn->query($sql)) {
        $success_message = "Message sent successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Sips of Serenity</title>
    <link rel="stylesheet" href="Css/contact.css">
    <link rel="stylesheet" href="Css/index.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
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
            <a href="about.php">About</a>
            <a href="contact.php" class="active">Contact</a>
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
    <section class="contact">
        <div class="contact-container">
            <div class="contact-info">
                <h2>Get in Touch</h2>
                <p>We'd love to hear from you! Reach out to us through any of these channels:</p>
                
                <div class="info-item">
                    <i class='bx bx-map'></i>
                    <div>
                        <h3>Visit Us</h3>
                        <p>Pitipana - Thalagala Rd, Homagama</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class='bx bx-phone'></i>
                    <div>
                        <h3>Call Us</h3>
                        <p>+94 123 456 789</p>
                        <p>+94 987 654 321</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class='bx bx-envelope'></i>
                    <div>
                        <h3>Email Us</h3>
                        <p>info@sos.com</p>
                        <p>support@sos.com</p>
                    </div>
                </div>
                
                <div class="social-links">
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-instagram'></i></a>
                    <a href="#"><i class='bx bxl-twitter'></i></a>
                </div>
            </div>
            
            <div class="contact-form">
                <h2>Send us a Message</h2>
                <?php if(isset($success_message)): ?>
                    <div class="success-message"><?php echo $success_message; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <input type="text" name="name" required>
                        <label>Your Name</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="email" name="email" required>
                        <label>Your Email</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="subject" required>
                        <label>Subject</label>
                    </div>
                    
                    <div class="form-group">
                        <textarea name="message" required></textarea>
                        <label>Your Message</label>
                    </div>
                    
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
        
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.383026560343!2d80.01212087571413!3d6.844602019347147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25300616a9889%3A0x69bd4e8852e35cce!2sSips%20Of%20Serenity!5e0!3m2!1sen!2slk!4v1740898780412!5m2!1sen!2slk" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
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
         window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
