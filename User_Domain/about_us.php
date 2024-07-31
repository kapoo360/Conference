<?php
// Include database configuration
include 'config.php';

// Start the session
session_start();

// Check if the user is logged in (this example assumes session-based authentication)
$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? $_SESSION['username'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Smart Senses</title>
    <!-- <link rel="stylesheet" href="css/product_details.css"> Link to your CSS file -->
    <link rel="stylesheet" href="css/nav.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css"> <!-- Custom scrollbar -->
    <link rel="icon" href="images/fevicon.png" type="image/png" /> <!-- Favicon -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css"> <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"> <!-- Fancybox -->
    <link rel="stylesheet" href="css/about_us.css">
    <link rel="icon" type="png" href="images/icc1.png">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
    <div class="wrapper">
        <?php include 'navigation.php'; ?>
    </div>

    <section class="about-section" id="s1" data-aos="zoom-in" data-aos-duration="3500">
        <div class="container">
            <div class="row">
                <div class="content-column col-lg-6 col-md-12 col-sm-12 order-2">
                    <div class="inner-column">
                        <div class="sec-title">
                            <span class="title">About Company</span>
                            <h2>We are leader in <br>Industrial market Since 1992</h2>
                        </div>
                        <div class="text">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                        </div>
                        <ul class="list-style-one">
                            <li>Lorem Ipsum is simply dummy text</li>
                            <li>Consectetur adipisicing elit</li>
                            <li>Sed do eiusmod tempor incididunt</li>
                        </ul>
                        <!-- <div class="btn-box">
                            <a href="#" class="theme-btn btn-style-one">Contact Us</a>
                        </div> -->
                    </div>
                </div>

                <!-- Image Column -->
                <div class="image-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column wow fadeInLeft">
                        <figure class="image-1"><a href="#" class="lightbox-image" data-fancybox="images"><img src="https://i.ibb.co/QP6Nmpf/image-1-about.jpg" alt=""></a></figure>
                        <figure class="image-2"><a href="#" class="lightbox-image" data-fancybox="images"><img src="https://i.ibb.co/JvN0NVB/image-2-about.jpg" alt=""></a></figure>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
