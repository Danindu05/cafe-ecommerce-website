
<?php
session_start();
require_once 'db.php';

$sql = "SELECT * FROM menu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Sips of Serenity</title>
    <link rel="stylesheet" href="Css/menu.css">
    <link rel="stylesheet" href="Css/index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
            <a href="menu.php" class="active">Menu</a>
            <a href="about.php">About</a>
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
                        Total: LKR: <span class="total-amount">0.00</span>
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
    <section class="menu-section">
        <div class="container">
            <h1>Our Menu</h1>
            <div class="menu-grid">
                <?php while($item = $result->fetch_assoc()): ?>
                    <div class="menu-card">
                        <div class="card-image">
                            <?php if (!empty($item['image_path'])): ?>
                                <img src="uploads/<?php echo basename($item['image_path']); ?>" alt="<?php echo $item['name']; ?>">
                            <?php else: ?>
                                <img src="images/default-menu-item.jpg" alt="Default Image">
                            <?php endif; ?>
                        </div>
                        <div class="card-content">
                            <h3><?php echo $item['name']; ?></h3>
                            <p class="description"><?php echo $item['description']; ?></p>
                            <div class="price">LKR: <?php echo number_format($item['price'], 2); ?>/=</div>
                            <div class="card-actions">
                                <button class="add-to-cart" data-item='<?php echo htmlspecialchars(json_encode($item)); ?>'>
                                    <i class='bx bx-cart-add'></i> Add to Cart
                                </button>
                                <button class="buy-now" onclick="buyNow(<?php echo htmlspecialchars(json_encode($item)); ?>)">
                                    <i class='bx bx-purchase-tag'></i> Buy Now
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
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
        document.addEventListener('DOMContentLoaded', () => {
            const navToggle = document.getElementById('navToggle');
            const navLinks = document.querySelector('.nav-links');
            const cartIcon = document.querySelector('.cart-icon');
            const cartPopup = document.querySelector('.cart-popup');
            const closeCart = document.querySelector('.close-cart');
            const cartItems = document.querySelector('.cart-items');
            const cartCount = document.querySelector('.cart-count');
            const totalAmount = document.querySelector('.total-amount');
            let cartProducts = [];

            navToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });

            cartIcon.addEventListener('click', () => {
                cartPopup.classList.toggle('active');
            });

            closeCart.addEventListener('click', () => {
                cartPopup.classList.remove('active');
            });

            // Add to cart functionality
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const itemData = JSON.parse(this.dataset.item);
                    addToCart(itemData);
                });
            });

            function addToCart(item) {
                cartProducts.push(item);
                updateCartDisplay();
                updateCartCount();
            }

            function updateCartCount() {
                cartCount.textContent = cartProducts.length;
            }

            function updateCartDisplay() {
                if (cartProducts.length === 0) {
                    cartItems.innerHTML = '<div class="empty-cart">Your cart is empty</div>';
                    totalAmount.textContent = '0.00';
                    document.querySelector('.buy-now-btn').disabled = true;
                    return;
                }

                let total = 0;
                cartItems.innerHTML = cartProducts.map((item, index) => {
                    total += parseFloat(item.price);
                    return `
                        <div class="cart-item">
                            ${item.image_path ? 
                                `<img src="uploads/${item.image_path.split('/').pop()}" alt="${item.name}" class="cart-item-image">` : 
                                `<img src="images/default-menu-item.jpg" alt="${item.name}" class="cart-item-image">`
                            }
                            <div class="cart-item-details">
                                <h4>${item.name}</h4>
                                <span class="cart-item-price">LKR: ${parseFloat(item.price).toFixed(2)}</span>
                                <button onclick="removeFromCart(${index})" class="remove-item">Remove</button>
                            </div>
                        </div>

                        `;                
                    }).join('');

                totalAmount.textContent = total.toFixed(2);
                document.getElementById('cartItemsInput').value = JSON.stringify(cartProducts);
                document.getElementById('totalAmountInput').value = total.toFixed(2);
                document.querySelector('.buy-now-btn').disabled = false;
            }

            // Close cart popup when clicking outside
            document.addEventListener('click', (e) => {
                if (!cartPopup.contains(e.target) && !cartIcon.contains(e.target)) {
                    cartPopup.classList.remove('active');
                }
            });

            window.removeFromCart = function(index) {
                cartProducts.splice(index, 1);
                updateCartDisplay();
                updateCartCount();
            };
        });

        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        function buyNow(item) {
            // Redirect to payment page with item details
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'payment.php';

            const itemInput = document.createElement('input');
            itemInput.type = 'hidden';
            itemInput.name = 'cart_items';
            itemInput.value = JSON.stringify([item]);

            const totalInput = document.createElement('input');
            totalInput.type = 'hidden';
            totalInput.name = 'total_amount';
            totalInput.value = item.price;

            form.appendChild(itemInput);
            form.appendChild(totalInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
