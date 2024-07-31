<?php
include 'config.php';

// Start the session to use session variables
session_start();

// Handle product deletion
if (isset($_POST['delete_product'])) {
    $product_id = intval($_POST['product_id']);
    $deleteQuery = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    if ($stmt) {
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $stmt->close();

        // Set a session variable for success message
        $_SESSION['message'] = "Product deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete product.";
    }
}

// Fetch all products
$productsQuery = "SELECT * FROM products";
$productsResult = $conn->query($productsQuery);

// Close the connection
$conn->close();

// Unset the session message after displaying it
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    $message = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Product Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/allproducts.css">
    <script>
        // Function to show the edit product modal
        function showEditProductModal(product) {
            document.getElementById('editProductId').value = product.product_id;
            document.getElementById('editProductName').value = product.product_name;
            document.getElementById('editProductDetails').value = product.product_details;
            document.getElementById('editProductPrice').value = product.product_price;
            document.getElementById('editProductImage').value = product.product_image;
            document.getElementById('editProductModal').style.display = 'block';
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('editProductModal').style.display = 'none';
        }

        // Function to show the alert message
        function showAlert(message) {
            if (message) {
                alert(message);
            }
        }

        // Call showAlert() function if there is a message
        window.onload = function() {
            var message = "<?php echo addslashes($message); ?>";
            showAlert(message);
        };
    </script>
</head>
<body>
<div class="container">
<?php include 'navigation.php'; ?>

    <div id="product-management-container">
        <h1 id="product-management-heading">Product Management</h1>
        
        <table id="product-management-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $productsResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td class="description"><?php echo htmlspecialchars($product['product_details']); ?></td>
                    <td><?php echo number_format($product['product_price'], 2); ?></td>
                    <td><img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image" width="100"></td>
                    <td>
                        <button class="btn" id="edit-product-btn" onclick='showEditProductModal(<?php echo json_encode($product); ?>)'>Edit</button>
                        <form action="all_products.php" method="post" style="display:inline-block;">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <input type="submit" name="delete_product" value="Delete" class="btn" id="delete-product-btn" onclick="return confirm('Are you sure you want to delete this product?');">
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Edit Product</h2>
            <form action="edit_product.php" method="post">
                <input type="hidden" id="editProductId" name="product_id">
                
                <label for="editProductName">Name:</label>
                <input type="text" id="editProductName" name="product_name" required>
                
                <label for="editProductDetails">Description:</label>
                <textarea id="editProductDetails" name="product_details" required></textarea>
                
                <label for="editProductPrice">Price:</label>
                <input type="text" id="editProductPrice" name="product_price" required>
                
                <label for="editProductImage">Image URL:</label>
                <input type="text" id="editProductImage" name="product_image" required>
                
                <button type="submit" class="btn">Update Product</button>
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
