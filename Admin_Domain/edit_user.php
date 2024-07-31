<?php
include 'config.php'; 

// Check if ID is provided
if (!isset($_GET['id'])) {
    die("No user ID specified.");
}

$userId = intval($_GET['id']);

// Fetch user details
$userQuery = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$userResult = $stmt->get_result();

if ($userResult->num_rows === 0) {
    die("User not found.");
}

$user = $userResult->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Update user details
    $updateQuery = "UPDATE users SET username = ?, email = ? WHERE user_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssi", $username, $email, $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<p>User updated successfully.</p>";
    } else {
        echo "<p>No changes made.</p>";
    }

    // Refresh the page to get updated data
    header("Location: edit_user.php?id=" . $userId);
    exit();
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
    <title>Edit User - Admin Panel</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/users.css">
</head>
<body>
    <div class="container">
    <?php include 'navigation.php'; ?>

        <div class="edit-user-container">
            <h1 id="edit-user-heading">Edit User</h1>
            
            <form action="edit_user.php?id=<?php echo $userId; ?>" method="post" class="edit-user-form">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                
                <button type="submit" class="edit-user-btn">Update</button>
            </form>
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
