<?php
// Start the session
session_start();
include 'config.php'; // Ensure this file contains the $conn variable for the database connection

// Handle admin deletion
if (isset($_POST['delete_admin_id'])) {
    $adminIdToDelete = intval($_POST['delete_admin_id']);

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Get the admin name of the admin to delete
        $getAdminNameQuery = "SELECT admin_name FROM admins WHERE admin_id = ?";
        $stmt = $conn->prepare($getAdminNameQuery);
        $stmt->bind_param("i", $adminIdToDelete);
        $stmt->execute();
        $stmt->bind_result($adminName);
        $stmt->fetch();
        $stmt->close();

        if ($adminName) {
            // Delete all orders associated with the admin (if applicable)
            $deleteOrdersQuery = "DELETE FROM orders WHERE admin_name = ?";
            $stmt = $conn->prepare($deleteOrdersQuery);
            $stmt->bind_param("s", $adminName);
            $stmt->execute();
            $stmt->close();
        }

        // Delete the admin
        $deleteQuery = "DELETE FROM admins WHERE admin_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $adminIdToDelete);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Commit the transaction
            $conn->commit();
            echo "<script>alert('Admin deleted successfully.'); window.location.href = 'admins.php';</script>";
        } else {
            throw new Exception("Failed to delete admin.");
        }

        $stmt->close();
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo "<script>alert('Failed to delete admin: " . $e->getMessage() . "'); window.location.href = 'admins.php';</script>";
    }
}

// Handle admin update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_admin_id'])) {
    $adminId = intval($_POST['update_admin_id']);
    $adminName = $_POST['admin_name'];
    $adminEmail = $_POST['admin_email'];
    $adminPassword = $_POST['admin_password']; // Get the password if provided

    // Hash the new password if it is set
    if (!empty($adminPassword)) {
        $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE admins SET admin_name = ?, admin_email = ?, admin_password = ? WHERE admin_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssi", $adminName, $adminEmail, $hashedPassword, $adminId);
    } else {
        // Update without changing the password
        $updateQuery = "UPDATE admins SET admin_name = ?, admin_email = ? WHERE admin_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssi", $adminName, $adminEmail, $adminId);
    }
    
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Admin updated successfully.'); window.location.href = 'admins.php';</script>";
    } else {
        echo "<script>alert('No changes made.'); window.location.href = 'admins.php';</script>";
    }

    $stmt->close();
}

// Handle admin addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_admin_name'])) {
    $newAdminName = $_POST['new_admin_name'];
    $newAdminEmail = $_POST['new_admin_email'];
    $newAdminPassword = $_POST['new_admin_password']; // Get the password

    // Hash the password
    $hashedPassword = password_hash($newAdminPassword, PASSWORD_DEFAULT);

    $addAdminQuery = "INSERT INTO admins (admin_name, admin_email, admin_password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($addAdminQuery);
    $stmt->bind_param("sss", $newAdminName, $newAdminEmail, $hashedPassword);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Admin added successfully.'); window.location.href = 'admins.php';</script>";
    } else {
        echo "<script>alert('Failed to add admin.'); window.location.href = 'admins.php';</script>";
    }

    $stmt->close();
}

// Fetch all admins
$adminsQuery = "SELECT admin_id, admin_name, admin_email FROM admins";
$adminsResult = $conn->query($adminsQuery);

if (!$adminsResult) {
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
    <title>Admin Panel - Admin Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/users.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <style>
 

    </style>
    <script>
        // Function to confirm admin deletion
        function confirmDelete(form) {
            return confirm('Are you sure you want to delete this admin? This action cannot be undone.');
        }

        // Function to show the edit admin modal
        function showEditAdminModal(adminId, adminName, adminEmail) {
            document.getElementById('editAdminId').value = adminId;
            document.getElementById('editAdminName').value = adminName;
            document.getElementById('editAdminEmail').value = adminEmail;
            document.getElementById('editAdminModal').style.display = 'block';
        }

        // Function to show the add admin modal
        function showAddAdminModal() {
            document.getElementById('addAdminModal').style.display = 'block';
        }

        // Function to close the modals
        function closeModal() {
            document.getElementById('editAdminModal').style.display = 'none';
            document.getElementById('addAdminModal').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <?php include 'navigation.php'; ?>

        <div class="user-management-container">
            <h1 id="user-management-heading">Admin Management</h1>

            <button class="add-btn" onclick="showAddAdminModal()">Add Admin</button>
            
            <table class="user-management-table">
                <thead>
                    <tr>
                        <th>Admin Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($admin = $adminsResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admin['admin_name']); ?></td>
                        <td><?php echo htmlspecialchars($admin['admin_email']); ?></td>
                        <td>
                            <button class="user-management-btn edit-btn" onclick="showEditAdminModal(<?php echo $admin['admin_id']; ?>, '<?php echo htmlspecialchars($admin['admin_name']); ?>', '<?php echo htmlspecialchars($admin['admin_email']); ?>')">Edit</button>
                            <form method="post" action="admins.php" style="display:inline;">
                                <input type="hidden" name="delete_admin_id" value="<?php echo $admin['admin_id']; ?>">
                                <button type="submit" class="user-management-btn delete-btn" onclick="return confirmDelete(this.form);">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Admin Modal -->
    <div id="editAdminModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Edit Admin</h2>
            <form action="admins.php" method="post">
                <input type="hidden" id="editAdminId" name="update_admin_id">
                <label for="editAdminName">Admin Name:</label>
                <input type="text" id="editAdminName" name="admin_name" required>
                <label for="editAdminEmail">Email:</label>
                <input type="email" id="editAdminEmail" name="admin_email" required>
                <label for="editAdminPassword">Password (leave blank if not changing):</label>
                <input type="password" id="editAdminPassword" name="admin_password">
                <button type="submit" class="edit-user-btn">Update</button>
            </form>
        </div>
    </div>

    <!-- Add Admin Modal -->
    <div id="addAdminModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add Admin</h2>
            <form action="admins.php" method="post">
                <label for="newAdminName">Admin Name:</label>
                <input type="text" id="newAdminName" name="new_admin_name" required>
                <label for="newAdminEmail">Email:</label>
                <input type="email" id="newAdminEmail" name="new_admin_email" required>
                <label for="newAdminPassword">Password:</label>
                <input type="password" id="newAdminPassword" name="new_admin_password" required>
                <button type="submit" class="edit-user-btn">Add Admin</button>
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
