<?php
// Include database configuration
include 'config.php';

// Start session for user login status
session_start();

// Fetch product details based on a query parameter (e.g., product_id)
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Initialize the product variable
$product = null;

// Query to get product details
$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
    $stmt->close();
}

// Check if product is found
if ($product === null) {
    echo "<p>Product not found.</p>";
    exit();
}

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? htmlspecialchars($_SESSION['username']) : '';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - Product Details</title>
    <link rel="stylesheet" href="css/product_details.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="css/nav.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Additional CSS files -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/responsive.css">
    <!-- favicon -->
    <link rel="icon" href="images/fevicon.png" type="image/png" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="icon" type="png" href="images/icc1.png">
</head>
<body>
    <div class="wrapper">
        <?php include 'navigation.php'; ?>
    </div>

    <div class="product-container" data-aos="zoom-in" data-aos-duration="3500">
    <?php if ($product): ?>
        <div class="product-image">
            <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
        </div>
        <div class="product-info">
            <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
            <div class="price">$<?php echo htmlspecialchars(number_format($product['product_price'], 2)); ?></div>
            <div class="details"><?php echo nl2br(htmlspecialchars($product['product_details'])); ?></div>
            
            <?php if ($is_logged_in): ?>
                <a href="check.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>" class="order-button">Order Now</a>
            <?php else: ?>
                <p>Please <a href="login.php">log in</a> to place an order.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>Product details not available. Please check back later.</p>
    <?php endif; ?>
</div>


    <!-- JavaScript files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function() {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });

            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });

            $(".zoom").hover(function() {
                $(this).addClass('transition');
            }, function() {
                $(this).removeClass('transition');
            });
        });
    </script>
    <?php include 'footer.php'; ?>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>

</body>
</html>
