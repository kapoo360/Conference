<?php
// Start the session
session_start();
include 'config.php'; // Ensure this file contains the $conn variable for the database connection

// Handle user deletion
if (isset($_POST['delete_user_id'])) {
    $userIdToDelete = intval($_POST['delete_user_id']);

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Get the username of the user to delete
        $getUsernameQuery = "SELECT username FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($getUsernameQuery);
        $stmt->bind_param("i", $userIdToDelete);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();

        if ($username) {
            // Delete all orders associated with the user
            $deleteOrdersQuery = "DELETE FROM orders WHERE username = ?";
            $stmt = $conn->prepare($deleteOrdersQuery);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->close();
        }

        // Delete the user
        $deleteQuery = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $userIdToDelete);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Commit the transaction
            $conn->commit();
            echo "<script>alert('User deleted successfully.'); window.location.href = 'users.php';</script>";
        } else {
            throw new Exception("Failed to delete user.");
        }

        $stmt->close();
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo "<script>alert('Failed to delete user: " . $e->getMessage() . "'); window.location.href = 'users.php';</script>";
    }
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user_id'])) {
    $userId = intval($_POST['update_user_id']);
    $username = $_POST['username'];
    $email = $_POST['email'];

    $updateQuery = "UPDATE users SET username = ?, email = ? WHERE user_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssi", $username, $email, $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('User updated successfully.'); window.location.href = 'users.php';</script>";
    } else {
        echo "<script>alert('No changes made.'); window.location.href = 'users.php';</script>";
    }

    $stmt->close();
}

// Handle user addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_username'])) {
    $newUsername = $_POST['new_username'];
    $newEmail = $_POST['new_email'];
    $newPassword = $_POST['new_password']; // Get the password

    // Hash the password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $addUserQuery = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($addUserQuery);
    $stmt->bind_param("sss", $newUsername, $newEmail, $hashedPassword);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('User added successfully.'); window.location.href = 'users.php';</script>";
    } else {
        echo "<script>alert('Failed to add user.'); window.location.href = 'users.php';</script>";
    }

    $stmt->close();
}

// Fetch all users
$usersQuery = "SELECT user_id, username, email, registration_date FROM users";
$usersResult = $conn->query($usersQuery);

if (!$usersResult) {
    die("Query failed: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Customer Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/users.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <style>
       
    </style>
    <script>
        // Function to confirm user deletion
        function confirmDelete(form) {
            return confirm('Are you sure you want to delete this user? This action cannot be undone.');
        }

        // Function to show the edit user modal
        function showEditUserModal(userId, username, email) {
            document.getElementById('editUserId').value = userId;
            document.getElementById('editUsername').value = username;
            document.getElementById('editEmail').value = email;
            document.getElementById('editUserModal').style.display = 'block';
        }

        // Function to show the add user modal
        function showAddUserModal() {
            document.getElementById('addUserModal').style.display = 'block';
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('editUserModal').style.display = 'none';
            document.getElementById('addUserModal').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <?php include 'navigation.php'; ?>

        <div class="user-management-container">
        <div class="user-management-header">
    <h1 id="user-management-heading">Customer Management</h1>
    <button class="add-btn" onclick="showAddUserModal()">Add User</button>
</div>

            
            <table class="user-management-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $usersResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['registration_date']); ?></td>
                        <td>
                            <button class="user-management-btn edit-btn" onclick="showEditUserModal(<?php echo $user['user_id']; ?>, '<?php echo htmlspecialchars($user['username']); ?>', '<?php echo htmlspecialchars($user['email']); ?>')">Edit</button>
                            <form method="post" action="users.php" style="display:inline;">
                                <input type="hidden" name="delete_user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="user-management-btn delete-btn" onclick="return confirmDelete(this.form);">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Edit User</h2>
            <form action="users.php" method="post">
                <input type="hidden" id="editUserId" name="update_user_id">
                <label for="editUsername">Username:</label>
                <input type="text" id="editUsername" name="username" required><br>
                <label for="editEmail">Email:</label>
                <input type="email" id="editEmail" name="email" required><br>
                <input type="submit" value="Update User">
            </form>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add User</h2>
            <form action="users.php" method="post">
                <label for="newUsername">Username:</label>
                <input type="text" id="newUsername" name="new_username" required><br>
                <label for="newEmail">Email:</label>
                <input type="email" id="newEmail" name="new_email" required><br>
                <label for="newPassword">Password:</label>
                <input type="password" id="newPassword" name="new_password" required><br>
                <button type="submit" class="edit-user-btn">Add User</button>
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
