<?php
// Include database configuration
include 'config.php';

// Fetch all products from the database
$query = "SELECT product_id, product_name, product_image FROM products";
$result = $conn->query($query);

if (!$result) {
    echo "Error fetching products.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <link rel="stylesheet" href="css/userallproducts.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="css/nav.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css"> <!-- Custom scrollbar -->
    <link rel="icon" href="images/fevicon.png" type="image/png" /> <!-- Favicon -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css"> <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"> <!-- Fancybox -->
    <link rel="stylesheet" href="css/about_us.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="icon" type="png" href="images/icc1.png">
    
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="products-container" data-aos="zoom-in" data-aos-duration="3500">
        <?php while ($product = $result->fetch_assoc()): ?>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-image">
                <h2 class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></h2>
                <a href="product_details.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>" class="view-details-button">View Details</a>
            </div>
        <?php endwhile; ?>
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
