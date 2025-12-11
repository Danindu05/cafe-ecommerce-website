<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sips of Serenity | Coffee Shop</title>
    <link rel="stylesheet" href="Css/index.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-brand">
            <img src="Assets/logo1.png" alt="Sips of Serenity" id="navLogo">
        </div>

        
        <div class="nav-toggle" id="navToggle">
            <i class='bx bx-menu'></i>
        </div>

        <div class="nav-links">
            <a href="index.php" class="active">Home</a>
            <a href="menu.php">Menu</a>
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

    <div class="smoke-wrap">
        <img class="smoke" src="Assets/smoke.png" alt="Smoke Animation">
    </div>
    <div class="smoke-wrap">
        <img class="smoke2" src="Assets/smoke.png" alt="Smoke Animation">
    </div>
    <div class="smoke-wrap">
        <img class="smoke3" src="Assets/smoke.png" alt="Smoke Animation">
    </div>
    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Welcome to Sips of Serenity</h1>
            <p>Each sip brings warmth, comfort, and a hint of adventure.</p>
            <a href="menu.php" class="cta-btn">View Menu</a>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" class="featured">
        <h2>Featured Drinks</h2>
        <div class="products-grid">
            <div class="product-card">
                <img src="Assets/ame.jpg" alt="Americano">
                <h3>Americano</h3>
                <p>Espresso diluted with hot water for a smooth, rich flavor</p>
                <span class="price">LKR: 699.99/=</span>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="Assets/cap.jpg" alt="Cappuccino">
                <h3>Cappuccino</h3>
                <p>A classic Italian coffee with a balance of espresso, steamed milk, and frothy foam</p>
                <span class="price">LKR: 499.99/=</span>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="Assets/mat.jpg" alt="Matcha latte">
                <h3>Matcha latte</h3>
                <p>A soothing, creamy drink combining green tea matcha powder with milk</p>
                <span class="price">LKR: 599.49/=</span>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card">
                <img src="Assets/moc.jpg" alt="Cafe Mocha">
                <h3>Cafe Mocha</h3>
                <p>A delightful blend of espresso, chocolate, and steamed milk, topped with whipped cream</p>
                <span class="price">LKR: 550.00/=</span>
                <button class="add-to-cart">Add to Cart</button>
            </div>  
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="about-content">
            <h2>Our Story</h2>
            <p>
            Welcome to Sips of Serenity, your peaceful retreat in the heart of Sri Lanka. Inspired by the lush tea gardens, mist-covered mountains, and rich traditions of our homeland, we envisioned a café that captures the warmth and heritage of Sri Lankan culture. Here, each sip is more than just a taste—it’s an experience, a connection to the beautiful landscapes and hardworking communities that bring these flavors to life.

Our commitment to quality begins at the source. We carefully select teas and coffees from local farmers who share our passion for authenticity, ensuring that every cup carries a story of dedication, sustainability, and care. By supporting local producers, we create a bridge between our guests and the communities that make these traditions possible, celebrating the unique qualities of Sri Lankan agriculture. From the iconic Ceylon teas to aromatic, carefully crafted coffee blends, our beverages embody the vibrant, diverse essence of Sri Lanka.

At Sips of Serenity, we go beyond serving beverages; we invite you to discover the rich heritage that makes Sri Lanka a destination for tea and coffee lovers worldwide. Our menu offers a selection of curated tea blends, each one evoking the distinct characteristics of Sri Lankan soil and climate. For coffee aficionados, our beans are expertly roasted to balance boldness and smoothness, capturing the very essence of Sri Lanka’s highlands. And for those seeking a taste of local cuisine, we offer traditional Sri Lankan snacks and small plates, crafted with recipes passed down through generations. Each dish is a tribute to Sri Lanka’s culinary heritage, blending spices, textures, and flavors that will make you feel at home.

The ambiance at Sips of Serenity is crafted to be a sanctuary for all who enter. Our space is designed with natural wood accents, earthy tones, and soft lighting to evoke the tranquility of Sri Lanka’s landscapes. Gentle music plays in the background, creating a soothing environment that lets you pause, unwind, and recharge. Whether you’re stopping by for a quick break, meeting with friends, or seeking a quiet corner to work, our café provides an atmosphere of warmth and relaxation, inviting you to take a deep breath and enjoy the moment. 
            </p>
        </div>
        <div class="about-image">
            <img src="Assets/oss.webp" alt="Coffee Shop Interior">
        </div>
    </section>

    <!-- Customer Feedback Section -->
    <section class="feedback-section">
        <h2>What Our Customers Say</h2>
        <div class="feedback-container">
            <div class="feedback-card">
                <div class="customer-image">
                    <img src="Assets/2.png" alt="Sarah Johnson">
                </div>
                <div class="customer-info">
                    <h3>Sarah Johnson</h3>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                    </div>
                    <p>"The best coffee I've ever had! The atmosphere is perfect for both work and relaxation. Their caramel latte is absolutely divine."</p>
                </div>
            </div>

            <div class="feedback-card">
                <div class="customer-image">
                    <img src="Assets/7.png" alt="Michael Chen">
                </div>
                <div class="customer-info">
                    <h3>Michael Chen</h3>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star-half'></i>
                    </div>
                    <p>"Great place for meetings! The staff is incredibly friendly, and their pastries are freshly baked. Highly recommend the espresso."</p>
                </div>
            </div>

            <div class="feedback-card">
                <div class="customer-image">
                    <img src="Assets/4.png" alt="Ethan Clarke">
                </div>
                <div class="customer-info">
                    <h3>Ethan Clarke</h3>
                    <div class="rating">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                    </div>
                    <p>"The ambiance is perfect! I love working here with their fast WiFi and amazing coffee. The vanilla frappe is out of this world!"</p>
                </div>
            </div>
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
            });
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile Menu Toggle
            const navToggle = document.getElementById('navToggle');
            const navLinks = document.querySelector('.nav-links');

            navToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });

            // Cart Popup Functionality
            const cartIcon = document.querySelector('.cart-icon');
            const cartPopup = document.querySelector('.cart-popup');
            const closeCart = document.querySelector('.close-cart');
            const cartItems = document.querySelector('.cart-items');
            const cartCount = document.querySelector('.cart-count');
            const totalAmount = document.querySelector('.total-amount');
            let cartProducts = [];
            let count = 0;

            cartIcon.addEventListener('click', () => {
                cartPopup.classList.toggle('active');
            });

            closeCart.addEventListener('click', () => {
                cartPopup.classList.remove('active');
            });

            // Cart Functionality
            const cartBtns = document.querySelectorAll('.add-to-cart');

            cartBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const productCard = btn.closest('.product-card');
                    const productName = productCard.querySelector('h3').textContent;
                    const productPrice = productCard.querySelector('.price').textContent;
                    const productImage = productCard.querySelector('img').src;

                    count++;
                    cartCount.textContent = count;

                    // Add item to cart array
                    cartProducts.push({
                        name: productName,
                        price: productPrice,
                        image: productImage
                    });

                    // Update cart display
                    updateCartDisplay();

                    btn.textContent = 'Added to Cart';
                    btn.disabled = true;
                    setTimeout(() => {
                        btn.textContent = 'Add to Cart';
                        btn.disabled = false;
                    }, 2000);
                });
            });

            function updateCartDisplay() {
                if (cartProducts.length === 0) {
                    cartItems.innerHTML = '<div class="empty-cart">Your cart is empty</div>';
                    totalAmount.textContent = '0.00';
                    document.querySelector('.buy-now-btn').disabled = true;
                    return;
                }

                let total = 0;
                cartItems.innerHTML = cartProducts.map((item, index) => {
                    const price = parseFloat(item.price.replace('$', ''));
                    total += price;
                    return `
                        <div class="cart-item">
                            <img src="${item.image}" alt="${item.name}">
                            <div class="cart-item-details">
                                <h4>${item.name}</h4>
                                <span class="cart-item-price">${item.price}</span>
                            </div>
                        </div>
                    `;
                }).join('');

                totalAmount.textContent = total.toFixed(2);
    
                // Update hidden form inputs
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

            // Rest of the existing script remains the same
        });

        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        function proceedToPayment() {
            if (cartProducts.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            
            const cartData = {
                items: cartProducts,
                total: document.querySelector('.total-amount').textContent
            };

            // Create form and submit to payment page
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'payment.php';

            const cartInput = document.createElement('input');
            cartInput.type = 'hidden';
            cartInput.name = 'cart_items';
            cartInput.value = JSON.stringify(cartData.items);
            form.appendChild(cartInput);

            const totalInput = document.createElement('input');
            totalInput.type = 'hidden';
            totalInput.name = 'total_amount';
            totalInput.value = cartData.total;
            form.appendChild(totalInput);

            document.body.appendChild(form);
            form.submit();
        }

    </script>
</body>
</html>
