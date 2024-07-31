<?php
include 'config.php';

// Start session to use session variables
session_start();

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $productQuery = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($productQuery);
    if ($stmt) {
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_details = $_POST['product_details'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $updateQuery = "UPDATE products SET product_name = ?, product_details = ?, product_price = ?, product_image = ? WHERE product_id = ?";
    $stmt = $conn->prepare($updateQuery);
    if ($stmt) {
        $stmt->bind_param('ssdsi', $product_name, $product_details, $product_price, $product_image, $product_id);
        $stmt->execute();
        $stmt->close();

        // Set a session variable for success message
        $_SESSION['message'] = "Product updated successfully.";
        header("Location: all_products.php");
        exit();
    }
}

// Retrieve and clear session message
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
    <title>Edit Product</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
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
        <h1>Edit Product</h1>
        <form action="edit_product.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">

            <label for="product_name">Name:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>

            <label for="product_details">Description:</label>
            <textarea id="product_details" name="product_details" required><?php echo htmlspecialchars($product['product_details']); ?></textarea>

            <label for="product_price">Price:</label>
            <input type="text" id="product_price" name="product_price" value="<?php echo htmlspecialchars($product['product_price']); ?>" required>

            <label for="product_image">Image URL:</label>
            <input type="text" id="product_image" name="product_image" value="<?php echo htmlspecialchars($product['product_image']); ?>" required>

            <button type="submit">Update Product</button>
        </form>
    </div>
</body>
</html>
