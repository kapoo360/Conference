<?php
// Start the session
session_start();
include 'config.php'; // Ensure this file contains the $conn variable for the database connection

// Check if a deletion request is made
if (isset($_POST['delete_order_id'])) {
    $orderIdToDelete = intval($_POST['delete_order_id']);
    
    // Prepare the DELETE statement
    $deleteQuery = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    
    if ($stmt === false) {
        die("Failed to prepare the DELETE statement: " . $conn->error);
    }

    $stmt->bind_param("i", $orderIdToDelete);

    if ($stmt->execute()) {
        echo "<script>alert('Order deleted successfully.'); window.location.href = 'orders.php';</script>";
    } else {
        echo "<script>alert('Failed to delete order: " . $stmt->error . "'); window.location.href = 'orders.php';</script>";
    }

    $stmt->close();
}

// Fetch all orders
$ordersQuery = "SELECT * FROM orders";
$ordersResult = $conn->query($ordersQuery);

// Check if query was successful
if (!$ordersResult) {
    die("Query failed: " . $conn->error);
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Orders Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/orders.css">
    <script>
        // Function to confirm order deletion
        function confirmDelete(form) {
            return confirm('Are you sure you want to delete this order? This action cannot be undone.');
        }
    </script>
</head>
<body>
    <div class="container">
        <?php include 'navigation.php'; ?>

        <div class="orders-management-container">
            <h1 id="orders-management-heading">Orders Management</h1>
            
            <table class="orders-management-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Product Name</th>
                        <th>Location</th>
                        <th>Comment</th>
                        <th>Order Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $ordersResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['username']); ?></td>
                        <td><?php echo htmlspecialchars($order['email']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['location']); ?></td>
                        <td><?php echo htmlspecialchars($order['comment_message']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($order['order_price'], 2)); ?></td>
                        <td>
                            <!-- Add an Edit button if needed, e.g., to edit order details -->
                            <!-- <a href="edit_order.php?id=<?php echo $order['order_id']; ?>" class="orders-management-btn edit-btn">Edit</a> -->
                            <form method="post" action="orders.php" style="display:inline;">
                                <input type="hidden" name="delete_order_id" value="<?php echo $order['order_id']; ?>">
                                <button type="submit" class="orders-management-btn delete-btn" onclick="return confirmDelete(this.form);">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="assets/js/chartsJS.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
