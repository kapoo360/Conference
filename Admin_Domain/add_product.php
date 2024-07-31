<?php
// Start the session
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $product_name = htmlspecialchars(trim($_POST['product_name']));
    $product_details = htmlspecialchars(trim($_POST['product_details']));
    $product_price = floatval($_POST['product_price']);
    $product_image = htmlspecialchars(trim($_POST['product_image']));

    // Prepare and execute the SQL statement
    $insertQuery = "INSERT INTO products (product_name, product_details, product_price, product_image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    if ($stmt) {
        $stmt->bind_param('ssis', $product_name, $product_details, $product_price, $product_image);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirect to the products page if the insert was successful
            header("Location: all_products.php");
            exit();
        } else {
            echo "<script>alert('Failed to add product.'); window.location.href = 'add_product.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Database error.'); window.location.href = 'add_product.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/addproducts.css">
</head>
<body>
    <div class="container">
        <?php include 'navigation.php'; ?>
        
        <div id="add-product-container">
            <h1 id="add-product-heading">Add Product</h1>
            <form action="add_product.php" method="post" id="add-product-form">
                <label for="product_name">Name:</label>
                <input type="text" id="product_name" name="product_name" required class="form-control">

                <label for="product_details">Description:</label>
                <textarea id="product_details" name="product_details" required class="form-control"></textarea>

                <label for="product_price">Price:</label>
                <input type="text" id="product_price" name="product_price" required class="form-control">

                <label for="product_image">Image URL:</label>
                <input type="text" id="product_image" name="product_image" required class="form-control">

                <input type="submit" value="Add Product" id="add-product-btn" class="btn">
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
