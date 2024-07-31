<?php
// Include database configuration
include 'config.php';

// Start session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or display a message
    echo "<p>You must be logged in to view this page. Please <a href='login.php'>log in</a> or <a href='register.php'>register</a>.</p>";
    exit();
}

// Fetch user information from the session
$username = $_SESSION['username'];
$email = $_SESSION['email'];

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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
    $order_price = $product['product_price'];

    // Sanitize and validate the email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Prepare the query to insert the order
    $query = "INSERT INTO orders (username, email, product_name, location, comment_message, order_price) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sssssd", $username, $email, $product['product_name'], $location, $comment, $order_price);
        $stmt->execute();
        $stmt->close();

        echo "<p>Thank you for your order!</p>";
    } else {
        echo "<p>Failed to place order.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Order</title>
    <link rel="stylesheet" href="css/product_details.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="css/nav.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Additional CSS files -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <!-- favicon -->
    <link rel="icon" href="images/fevicon.png" type="image/png" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/check.css">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <link rel="icon" type="png" href="images/icc1.png">

</head>
<body>
<?php include 'navigation.php'; ?>
    <div class="checkout-screen" data-aos="zoom-in" data-aos-duration="3500">
        <div class="checkout-card">
            <div class="card-left">
                <img src="<?php echo htmlspecialchars($product['product_image']); ?>" class="product-image" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
            </div>
            <div class="card-right">
                <form action="" method="post">
                    <h1 id="placeorder">Place Order</h1>
                    <h2>Please fill out the form</h2>

                    <p>Username: <?php echo htmlspecialchars($username); ?></p>
                    <p>Email: <?php echo htmlspecialchars($email); ?></p>
                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">

                    <p>Product Name:</p>
                    <input type="text" class="input-field" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" readonly />

                    <p>Order Price:</p>
                    <input type="text" class="input-field" name="order_price" value="$<?php echo htmlspecialchars(number_format($product['product_price'], 2)); ?>" readonly />

                    <p>Location:</p>
                    <input type="text" class="input-field" name="location" required />

                    <p>Comment:</p>
                    <textarea class="input-field" name="comment" rows="4"></textarea>

                    <button type="submit" class="submit-button">Place Order</button>
                </form>
            </div>
        </div>
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
