<?php
session_start();
require_once 'db.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header('Location: access-denied.php');
    exit();
}

// Delete menu item
if (isset($_POST['delete_item'])) {
    $id = (int)$_POST['delete_item'];
    $conn->query("DELETE FROM menu WHERE menu_id = $id");
}

// Update order status
if (isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $update_sql = "UPDATE orders SET order_status = '$new_status' WHERE order_id = $order_id";
    $conn->query($update_sql);
}

// Add new menu item
if (isset($_POST['add_item'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = floatval($_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    $image_path = '';
    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === 0) {
        // Create uploads directory if it doesn't exist
        $upload_dir = __DIR__ . '/uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_extension = pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_extension;
        $target_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['item_image']['tmp_name'], $target_path)) {
            $image_path = $target_path;
        }
    }
    
    $sql = "INSERT INTO menu (name, price, description, image_path) VALUES ('$name', $price, '$description', '$image_path')";
    $conn->query($sql);
}

// Update menu item
if (isset($_POST['update_item'])) {
    $id = (int)$_POST['menu_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = floatval($_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    $image_update = '';
    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === 0) {
        // Create uploads directory if it doesn't exist
        $upload_dir = __DIR__ . '/uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_extension = pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_extension;
        $target_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['item_image']['tmp_name'], $target_path)) {
            $image_update = ", image_path = '$target_path'";
        }
    }
    
    $sql = "UPDATE menu SET name = '$name', price = $price, description = '$description' $image_update WHERE menu_id = $id";
    $conn->query($sql);
}

// Add user
if (isset($_POST['add_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "INSERT INTO user (username, email, password, contact, address, Created_At) VALUES ('$username', '$email', '$password', '$contact', '$address', NOW())";
    $conn->query($sql);
}

// Update user
if (isset($_POST['update_user'])) {
    $u_id = (int)$_POST['u_id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "UPDATE user SET username = '$username', email = '$email', contact = '$contact', address = '$address' WHERE U_ID = $u_id";
    $conn->query($sql);
}

// Delete user
if (isset($_POST['delete_user'])) {
    $u_id = (int)$_POST['delete_user'];
    $conn->query("DELETE FROM user WHERE U_ID = $u_id");
}

// Add contact message
if (isset($_POST['add_contact_message'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, subject, message, created_at) VALUES ('$name', '$email', '$subject', '$message', NOW())";
    $conn->query($sql);
}

// Fetch all menu items, orders, users, and contact messages
$result = $conn->query("SELECT * FROM menu ORDER BY menu_id DESC");
$result_order = $conn->query("SELECT * FROM orders ORDER BY order_id DESC");
$result_user = $conn->query("SELECT * FROM user ORDER BY U_ID DESC");
$result_contact = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Sips of Serenity</title>
    <link rel="stylesheet" href="Css/admin-profile.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="admin-info">
                <i class='bx bxs-user-circle'></i>
                <h3>Welcome, <?php echo $_SESSION['username']; ?></h3>
            </div>
            <nav class="admin-nav">
                <a href="#" onclick="showSection('dashboard')" class="active"><i class='bx bxs-dashboard'></i> Dashboard</a>
                <a href="#" onclick="showSection('menu-section')"><i class='bx bxs-food-menu'></i> Menu Management</a>
                <a href="#" onclick="showSection('orders-section')"><i class='bx bxs-food-menu'></i> Order Management</a>
                <a href="#" onclick="showSection('user-section')"><i class='bx bxs-user'></i> User Management</a>
                <a href="#" onclick="showSection('contact-section')"><i class='bx bxs-envelope'></i> Contact Messages</a>
                <a href="logout.php"><i class='bx bxs-log-out'></i> Logout</a>
            </nav>
        </aside>

        <main class="main-content">
            <section id="dashboard" class="stats-section">
                <div class="stat-card">
                    <i class='bx bxs-coffee'></i>
                    <div>
                        <h3>Total Items</h3>
                        <p><?php echo $result->num_rows; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class='bx bxs-cart'></i>
                    <div>
                        <h3>Total Orders</h3>
                        <p><?php echo $result_order->num_rows; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class='bx bxs-group'></i>
                    <div>
                        <h3>Total Users</h3>
                        <p><?php echo $result_user->num_rows; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class='bx bxs-envelope'></i>
                    <div>
                        <h3>Total Messages</h3>
                        <p><?php echo $result_contact->num_rows; ?></p>
                    </div>
                </div>
            </section>

            <section id="menu-section" class="menu-management" style="display: none;">
                <div class="section-header">
                    <h2>Menu Management</h2>
                    <button class="add-btn" onclick="showAddForm()">
                        <i class='bx bx-plus'></i> Add New Item
                    </button>
                </div>

                <!-- Add/Edit Form (Hidden by default) -->
                <div id="menuForm" class="menu-form" style="display: none;">
                    <form id="itemForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="menu_id" id="menu_id">
                        <div class="form-group">
                            <label>Item Name</label>
                            <input type="text" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <label>Price (LKR)</label>
                            <input type="number" name="price" id="price" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Item Image</label>
                            <input type="file" name="item_image" id="item_image" accept="image/*">
                        </div>
                        <div class="form-actions">
                            <button type="submit" name="add_item" id="submitBtn">Add Item</button>
                            <button type="button" onclick="hideForm()">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Menu Items Grid -->
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
                            <p class="price">LKR: <?php echo number_format($item['price'], 2); ?>/=</p>
                            <p class="description"><?php echo $item['description']; ?></p>
                            <div class="card-actions">
                                <button onclick="editItem(<?php echo htmlspecialchars(json_encode($item)); ?>)" class="edit-btn">
                                    <i class='bx bxs-edit'></i> Edit
                                </button>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="delete_item" value="<?php echo $item['menu_id']; ?>">
                                    <button type="submit" class="delete-btn" onclick="return confirm('Are you sure?')">
                                        <i class='bx bxs-trash'></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <!-- Orders Management Section -->
            <section id="orders-section" class="orders-management" style="display: none;">
                <div class="section-header">
                    <h2>Customer Orders</h2>
                    <div class="order-filters">
                        <select id="status-filter">
                            <option value="all">All Orders</option>
                            <option value="Pending">Pending</option>
                            <option value="Processing">Processing</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>

                <div class="orders-grid">
                    <?php
                    $orders_sql = "SELECT * FROM orders ORDER BY order_date DESC";
                    $orders_result = $conn->query($orders_sql);
                    while($order = $orders_result->fetch_assoc()):
                        $order_items = json_decode($order['order_items'], true);
                    ?>
                    <div class="order-card">
                        <div class="order-header">
                            <h3>Order #<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></h3>
                            <span class="order-date"><?php echo date('M d, Y H:i', strtotime($order['order_date'])); ?></span>
                        </div>
                        <div class="order-info">
                            <div class="customer-details">
                                <p><i class='bx bxs-user'></i> <?php echo $order['customer_name']; ?></p>
                                <p><i class='bx bxs-phone'></i> <?php echo $order['contact_number']; ?></p>
                                <p><i class='bx bxs-map'></i> <?php echo $order['shipping_address']; ?></p>
                            </div>
                            <div class="order-items">
                                <?php foreach($order_items as $item): ?>
                                <div class="item">
                                    <span><?php echo $item['name']; ?></span>
                                    <span><?php echo $item['price']; ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="order-summary">
                                <div class="total">
                                    <span>Total Amount:</span>
                                    <span>LKR: <?php echo number_format($order['total_amount'], 2); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="order-actions">
                            <form method="POST" class="status-form">
                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                <select name="status" onchange="this.form.submit()" class="status-select">
                                    <option value="Pending" <?php echo $order['order_status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Processing" <?php echo $order['order_status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                    <option value="Completed" <?php echo $order['order_status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                    <option value="Cancelled" <?php echo $order['order_status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <!-- User Management Section -->
            <section id="user-section" class="user-management" style="display: none;">
                <div class="section-header">
                    <h2>User Management</h2>
                    <button class="add-btn" onclick="showAddUserForm()">
                        <i class='bx bx-plus'></i> Add New User
                    </button>
                </div>

                <!-- Add/Edit User Form (Hidden by default) -->
                <div id="userForm" class="user-form" style="display: none;">
                    <form id="userItemForm" method="POST">
                        <input type="hidden" name="u_id" id="u_id">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" id="username" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" id="password" required>
                        </div>
                        <div class="form-group">
                            <label>Contact</label>
                            <input type="text" name="contact" id="contact" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" id="address" required></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="submit" name="add_user" id="submitUserBtn">Add User</button>
                            <button type="button" onclick="hideUserForm()">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Users Grid -->
                <div class="user-grid">
                    <?php while ($user = $result_user->fetch_assoc()): ?>
                    <div class="user-card">
                        <div class="card-content">
                            <h3><?php echo $user['username']; ?></h3>
                            <p class="email">Email: <?php echo $user['email']; ?></p>
                            <p class="contact">Contact: <?php echo $user['contact']; ?></p>
                            <p class="address">Address: <?php echo $user['address']; ?></p>
                            <div class="card-actions">
                                <button onclick="editUser(<?php echo htmlspecialchars(json_encode($user)); ?>)" class="edit-btn">
                                    <i class='bx bxs-edit'></i> Edit
                                </button>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="delete_user" value="<?php echo $user['U_ID']; ?>">
                                    <button type="submit" class="delete-btn" onclick="return confirm('Are you sure?')">
                                        <i class='bx bxs-trash'></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <!-- Contact Messages Section -->
            <section id="contact-section" class="contact-management" style="display: none;">
                <div class="section-header">
                    <h2>Contact Messages</h2>
                </div>

                <!-- Contact Messages Grid -->
                <div class="contact-grid">
                    <?php while ($message = $result_contact->fetch_assoc()): ?>
                    <div class="contact-card">
                        <div class="card-content">
                            <h3><?php echo $message['subject']; ?></h3>
                            <p class="name">From: <?php echo $message['name']; ?> (<?php echo $message['email']; ?>)</p>
                            <p class="message">Message: <?php echo $message['message']; ?></p>
                            <p class="created-at">Received on: <?php echo date('M d, Y H:i', strtotime($message['created_at'])); ?></p>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>
        </main>
    </div>

    <script>
        function showSection(sectionId) {
            // Hide all sections
            document.getElementById('dashboard').style.display = 'none';
            document.getElementById('menu-section').style.display = 'none';
            document.getElementById('orders-section').style.display = 'none';
            document.getElementById('user-section').style.display = 'none';
            document.getElementById('contact-section').style.display = 'none';
            
            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
            
            // Update active class in navigation
            const navLinks = document.querySelectorAll('.admin-nav a');
            navLinks.forEach(link => link.classList.remove('active'));
            event.target.classList.add('active');
        }

        // Show dashboard by default
        document.addEventListener('DOMContentLoaded', function() {
            showSection('dashboard');
        });

        function showAddForm() {
            document.getElementById('menuForm').style.display = 'block';
            document.getElementById('itemForm').reset();
            document.getElementById('submitBtn').name = 'add_item';
            document.getElementById('submitBtn').textContent = 'Add Item';
        }

        function hideForm() {
            document.getElementById('menuForm').style.display = 'none';
        }

        function editItem(item) {
            document.getElementById('menuForm').style.display = 'block';
            document.getElementById('menu_id').value = item.menu_id;
            document.getElementById('name').value = item.name;
            document.getElementById('price').value = item.price;
            document.getElementById('description').value = item.description;
            document.getElementById('submitBtn').name = 'update_item';
            document.getElementById('submitBtn').textContent = 'Update Item';
        }

        function showAddUserForm() {
            document.getElementById('userForm').style.display = 'block';
            document.getElementById('userItemForm').reset();
            document.getElementById('submitUserBtn').name = 'add_user';
            document.getElementById('submitUserBtn').textContent = 'Add User';
        }

        function hideUserForm() {
            document.getElementById('userForm').style.display = 'none';
        }

        function editUser(user) {
            document.getElementById('userForm').style.display = 'block';
            document.getElementById('u_id').value = user.U_ID;
            document.getElementById('username').value = user.username;
            document.getElementById('email').value = user.email;
            document.getElementById('contact').value = user.contact;
            document.getElementById('address').value = user.address;
            document.getElementById('submitUserBtn').name = 'update_user';
            document.getElementById('submitUserBtn').textContent = 'Update User';
        }
    </script>
</body>
</html>
