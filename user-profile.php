<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_sql = "SELECT * FROM user WHERE U_ID = $user_id";
$user_result = $conn->query($user_sql);
$user = $user_result->fetch_assoc();

// Update user details
if (isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    $update_sql = "UPDATE user SET username='$name', email='$email', contact='$contact', address='$address' WHERE U_ID=$user_id";
    $conn->query($update_sql);
    header('Location: user-profile.php');
}

// Delete contact message
if (isset($_POST['delete_message'])) {
    $message_id = (int)$_POST['message_id'];
    $conn->query("DELETE FROM contact_messages WHERE id = $message_id AND user_id = '{$user['U_ID']}'");
}

// Cancel order
if (isset($_POST['cancel_order'])) {
    $order_id = (int)$_POST['order_id'];
    $conn->query("UPDATE orders SET order_status = 'Cancelled' WHERE order_id = $order_id AND user_id = $user_id");
}

// Fetch user's orders
$orders_sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC";
$orders_result = $conn->query($orders_sql);

// Fetch user's contact messages
$messages_sql = "SELECT * FROM contact_messages WHERE user_id = '{$user['U_ID']}' ORDER BY created_at DESC";
$messages_result = $conn->query($messages_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Sips of Serenity</title>
    <link rel="stylesheet" href="Css/user-profile.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="profile-container">
        <aside class="sidebar">
            <div class="user-info">
                <i class='bx bxs-user-circle'></i>
                <h3><?php echo $user['username']; ?></h3>
                <p><?php echo $user['email']; ?></p>
            </div>
            <nav class="profile-nav">
                <a href="#profile" class="active" data-tab="profile"><i class='bx bxs-user-detail'></i> Profile</a>
                <a href="#orders" data-tab="orders"><i class='bx bxs-shopping-bag'></i> Orders</a>
                <a href="#messages" data-tab="messages"><i class='bx bxs-message-dots'></i> Messages</a>
                <a href="logout.php"><i class='bx bxs-log-out'></i> Logout</a>
            </nav>
        </aside>

        <main class="main-content">
            <!-- Profile Section -->
            <section id="profile" class="tab-content active">
                <h2>Profile Details</h2>
                <form method="POST" class="profile-form">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="<?php echo $user['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact" value="<?php echo $user['contact']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" required><?php echo $user['address']; ?></textarea>
                    </div>
                    <button type="submit" name="update_profile" class="update-btn">
                        <i class='bx bxs-save'></i> Update Profile
                    </button>
                </form>
            </section>

            <!-- Orders Section -->
            <section id="orders" class="tab-content">
                <h2>My Orders</h2>
                <div class="orders-grid">
                    <?php while($order = $orders_result->fetch_assoc()): 
                        $order_items = json_decode($order['order_items'], true);
                    ?>
                    <div class="order-card">
                        <div class="order-header">
                            <h3>Order #<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></h3>
                            <span class="status <?php echo strtolower($order['order_status']); ?>">
                                <?php echo $order['order_status']; ?>
                            </span>
                        </div>
                        <div class="order-details">
                        <div class="order-items">
                            <?php foreach($order_items as $item): ?>
                            <div class="item">
                                <div class="item-image">
                                    <img src="uploads/<?php echo basename($item['image_path']); ?>" alt="<?php echo $item['name']; ?>">
                                </div>
                                <div class="item-details">
                                    <span><?php echo $item['name']; ?></span>
                                    <span><?php echo $item['price']; ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                            <div class="order-total">
                                Total: LKR: <?php echo number_format($order['total_amount'], 2); ?>/=
                            </div>
                        </div>
                        <?php if($order['order_status'] == 'Pending'): ?>
                        <form method="POST" class="order-actions">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <button type="submit" name="cancel_order" class="cancel-btn">
                                <i class='bx bx-x'></i> Cancel Order
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <!-- Messages Section -->
            <section id="messages" class="tab-content">
                <h2>My Messages</h2>
                <div class="messages-grid">
                    <?php while($message = $messages_result->fetch_assoc()): ?>
                    <div class="message-card">
                        <div class="message-header">
                            <h3><?php echo $message['subject']; ?></h3>
                            <span class="date"><?php echo date('M d, Y', strtotime($message['created_at'])); ?></span>
                        </div>
                        <p class="message-content"><?php echo $message['message']; ?></p>
                        <form method="POST" class="message-actions">
                            <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                            <button type="submit" name="delete_message" class="delete-btn">
                                <i class='bx bxs-trash'></i> Delete
                            </button>
                        </form>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Tab switching functionality
        document.querySelectorAll('.profile-nav a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const tab = this.dataset.tab;
                
                // Update active states
                document.querySelectorAll('.profile-nav a').forEach(l => l.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
                
                this.classList.add('active');
                document.getElementById(tab).classList.add('active');
            });
        });
    </script>
</body>
</html>
