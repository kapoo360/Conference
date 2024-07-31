<?php
// Start the session
session_start();

include 'config.php'; 

// Calculate total users
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
$totalUsersResult = $conn->query($totalUsersQuery);
if ($totalUsersResult) {
    $totalUsersData = $totalUsersResult->fetch_assoc();
    $totalUsers = $totalUsersData['total_users'];
} else {
    die("Error executing query: " . $conn->error);
}

// Calculate total comments
$totalCommentsQuery = "SELECT COUNT(comment_message) AS total_comments FROM orders";
$totalCommentsResult = $conn->query($totalCommentsQuery);
if ($totalCommentsResult) {
    $totalCommentsData = $totalCommentsResult->fetch_assoc();
    $totalComments = $totalCommentsData['total_comments'];
} else {
    die("Error executing query: " . $conn->error);
}

// Calculate total orders
$totalOrdersQuery = "SELECT COUNT(*) AS total_orders FROM orders";
$totalOrdersResult = $conn->query($totalOrdersQuery);
if ($totalOrdersResult) {
    $totalOrdersData = $totalOrdersResult->fetch_assoc();
    $totalOrders = $totalOrdersData['total_orders'];
} else {
    die("Error executing query: " . $conn->error);
}

// Calculate total sales
$totalSalesQuery = "SELECT COALESCE(SUM(order_price), 0) AS total_sales FROM orders";
$totalSalesResult = $conn->query($totalSalesQuery);
if ($totalSalesResult) {
    $totalSalesData = $totalSalesResult->fetch_assoc();
    $totalSales = $totalSalesData['total_sales'];
} else {
    die("Error executing query: " . $conn->error);
}

// Update the dashboard_stats table
$updateQuery = "INSERT INTO dashboard_stats (total_users, total_orders, total_sales,total_comments, last_updated)
                 VALUES (?, ?, ?,?, CURRENT_TIMESTAMP)
                 ON DUPLICATE KEY UPDATE
                 total_users = VALUES(total_users),
                 total_orders = VALUES(total_orders),
                 total_sales = VALUES(total_sales),
                 total_comments = VALUES(total_comments),
                 last_updated = VALUES(last_updated)";

$stmt = $conn->prepare($updateQuery);
if ($stmt) {
    $stmt->bind_param('iiii', $totalUsers, $totalOrders, $totalSales,$totalComments);
    $stmt->execute();
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}

// Fetch the latest stats
$statsQuery = "SELECT * FROM dashboard_stats ORDER BY last_updated DESC LIMIT 1";
$statsResult = $conn->query($statsQuery);
if ($statsResult) {
    $statsData = $statsResult->fetch_assoc();
} else {
    die("Error fetching dashboard stats: " . $conn->error);
}

// Fetch recent orders
$recentOrdersQuery = "SELECT * FROM orders ORDER BY order_id DESC LIMIT 5";
$recentOrdersResult = $conn->query($recentOrdersQuery);
if ($recentOrdersResult) {
    $recentOrders = $recentOrdersResult->fetch_all(MYSQLI_ASSOC);
} else {
    die("Error fetching recent orders: " . $conn->error);
}

// Fetch recent customers (most recent signed-up users)
$recentCustomersQuery = "SELECT username, registration_date FROM users ORDER BY registration_date DESC LIMIT 5";
$recentCustomersResult = $conn->query($recentCustomersQuery);
if ($recentCustomersResult) {
    $recentCustomers = $recentCustomersResult->fetch_all(MYSQLI_ASSOC);
} else {
    die("Error fetching recent customers: " . $conn->error);
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
    <title>Responsive Admin Dashboard</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="png" href="assets/imgs/icc1.png">
</head>
<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
    <?php include 'navigation.php'; ?>
        
        <!-- ======================= Cards ================== -->
        <div class="cardBox">
            <div class="card">
                <div>
                    <div class="numbers"><?php echo number_format($totalOrders); ?></div>
                    <div class="cardName">Total Orders</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="cart-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers"><?php echo number_format($totalSales, 2); ?></div>
                    <div class="cardName">Total Sales</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="cash-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers"><?php echo number_format($statsData['total_comments']); ?></div>
                    <div class="cardName">Comments</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="chatbubbles-outline"></ion-icon>
                </div>
            </div>

            <!-- <div class="card">
                <div>
                    <div class="numbers"><?php echo number_format($statsData['total_sales'], 2); ?></div>
                    <div class="cardName">Earning</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="cash-outline"></ion-icon>
                </div>
            </div> -->

            <div class="card">
                <div>
                    <div class="numbers"><?php echo number_format($totalUsers); ?></div>
                    <div class="cardName">Total Customers</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
            </div>
        </div>

        <!-- ================ Add Charts JS ================= -->
        <div class="chartsBx">
            <div class="chart"> <canvas id="chart-1"></canvas> </div>
            <div class="chart"> <canvas id="chart-2"></canvas> </div>
        </div>

        <!-- ================ Order Details List ================= -->
        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Recent Orders</h2>
                    <a href="orders.php" class="btn">View All</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Price</td>
                            <td>Location</td>
                            <td>Comment</td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td><?php echo number_format($order['order_price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($order['location']); ?></td>
                            <td><?php echo htmlspecialchars($order['comment_message']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- ================= New Customers ================ -->
            <div class="recentCustomers">
                <div class="cardHeader">
                    <h2>Recent Customers</h2>
                    <a href="users.php" class="btn">View All</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <td>Username</td>
                            <td>Registered On</td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($recentCustomers as $customer): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($customer['username']); ?></td>
                            <td><?php echo htmlspecialchars(date('F j, Y', strtotime($customer['registration_date']))); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
