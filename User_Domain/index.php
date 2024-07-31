<?php
// Start the session
session_start();

// Include database configuration
include 'config.php';

// Check if the user is logged in
$loggedIn = isset($_SESSION['username']);

// Retrieve all products from the database
$sql = "SELECT product_id, product_image FROM products";
$result = $conn->query($sql);

// Store products in an array
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Smart Senses</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/nav.css">

    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <link rel="icon" type="png" href="images/icc1.png">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<!-- body -->

<body class="main-layout">
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#" /></div>
    </div>


    <div class="wrapper">

        <!-- end loader -->

        <?php include 'navigation.php'; ?>

        <div id="content">
            <!-- header -->
            <header id="head">
                <!-- header inner -->
                <div class="head_top">
                    <div class="header">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-lg-3 logo_section">
                                    <div class="full">
                                        <div class="center-desk">
                                            <div class="logo">
                                                <a href="index.php"><img src="images/logo.png" alt="#"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="right_header_info">
                                        <ul>
                                            <li>
                                                <?php if ($loggedIn): ?>
                                                    <span>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                                <?php else: ?>
                                                    <span>Hello, Guest</span>
                                                <?php endif; ?>
                                            </li>
                                            
                                            <!-- Show login and signup links only if not logged in -->
                                            <?php if (!$loggedIn): ?>
                                                <li class="menu_iconb">
                                                    <a href="login.php">Log in <img style="margin-right: 15px;" src="icon/login.png" alt="#" /> </a>
                                                </li>
                                                <li class="menu_iconb">
                                                    <a href="signup.php">Signup<img style="margin-left: 15px;" src="icon/signup1.png" alt="#" /></a>
                                                </li>
                                            <?php endif; ?>

                                            <!-- <li class="tytyu">
                                                <a href="#"> <img style="margin-right: 15px;" src="icon/2.png" alt="#" /></a>
                                            </li> -->



                                            <!-- <li class="menu_iconb">
                                                <a href="#"><img style="margin-right: 15px;" src="icon/3.png" alt="#" /></a>
                                            </li> -->



                                            <!-- <li>
                                                <button type="button" id="sidebarCollapse">
                                                    <img src="images/menu_icon.png" alt="#" />
                                                </button>
                                            </li> -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- end header inner -->

                    <!-- end header -->
                    <section class="slider_section">
                        <div class="banner_main">
                            <div class="container-fluid padding3">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mapimg">
                                        <div class="text-bg">
                                            <h1>Hear, <br>
                                        See,<br>
                                        And <br>
                                        Connect</h1>
                                            <span>Now in Cairo, Giza, Alex</span>
                                            <a href="check.php">Get yours NOW!</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                                        <div id="myCarousel" class="carousel slide banner_Client" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                                
                                            </ol>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="container">
                                                        <div class="carousel-caption text">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="img_bg">
                                                                        <figure><img src="images/g11.png" /></figure>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="container">
                                                        <div class="carousel-caption text">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="img_bg">
                                                                        <figure><img src="images/g22.png" /></figure>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </header>


<!-- About Us Section -->
<!-- <section id="about-us">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="about-us-box">
                    <h2>About Smart Senses</h2>
                    <p>Smart Senses is dedicated to providing exceptional support for individuals with special needs. Our mission is to ensure that every person, regardless of their abilities, has access to the tools and resources they need to thrive. We are committed to enhancing the quality of life for our clients through innovative solutions and compassionate care.</p>
                    <p>Our team of experts works tirelessly to develop and deliver products that meet the diverse needs of our customers. From personalized assistance to cutting-edge technology, we aim to make a positive impact in the lives of those we serve. At Smart Senses, we believe in inclusivity and are driven by the desire to create a more accessible world for everyone.</p>
                </div>
            </div>
        </div>
    </div>
</section> -->

<section class="about-section">
    	<div class="container">
        	<div class="row clearfix">
            	
                <!--Content Column-->
                <div class="content-column col-md-6 col-sm-12 col-xs-12" >
                	<div class="inner-column"data-aos="zoom-in" data-aos-duration="3500">
                    	<div class="sec-title">
                    		<div class="title">About Us</div>
                        	<h2>We Are The Leader In <br> The Interiores</h2>
                        </div>
                        <div class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</div>
                        <div class="email">Request Quote: <span class="theme_color">freequote@gmail.com</span></div>
                        <a href="about_us.php" class="theme-btn btn-style-three">Read More</a>
                    </div>
                </div>
                
                <!--Image Column-->
                <div class="image-column col-md-6 col-sm-12 col-xs-12" data-aos="zoom-in" data-aos-duration="3500">
                	<div class="inner-column " data-wow-delay="0ms" data-wow-duration="1500ms">
                    	<div class="image">
                        	<img src="images/abouthome.jpg" alt="">
                            <div class="overlay-box">
                            	<div class="year-box"><span class="number">5</span>Years <br> Experience <br> Working</div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

<!-- end about-us -->








            <!-- Categories -->
             
            <!-- <div class="Categories">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title">
                                <h2>Our Products</h2>
                               
                            </div>
                        </div>
                    </div> -->




              <!-- Product Gallery Section -->
<section id="product-gallery">
    <div class="container" id="sec1-2">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h2>Our Products</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="product-carousel" data-aos="fade-left" data-aos-duration="3500">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <a href="product_details.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>">
                                <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image" class="img-fluid">
                                <div class="view-details">
                                    <a href="product_details.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>">View Details</a>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Include Slick Carousel JS and CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.product-carousel').slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });
</script>










                    <!-- news brand -->
                     <!-- Product Details Section -->
                         <!-- Section for the first product -->
    <!-- <section id="sec1">
        <div id="brand" class="brand-bg">
            <h3 style="padding-left: 30%;">We reach all special needs as we can</h3>
            <div class="row" style="position: relative;">
                <?php if ($product): ?>
                    <div class="card">
                        <a href="product_details.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>">
                            <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                        </a>
                    </div>
                <?php else: ?>
                    <p>Product not found.</p>
                <?php endif; ?>
            </div>
        </div>
    </section> -->

    <!-- Save Section
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="save">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="save_box">
                                    <h3>Easier than ever</h3>
                                    <a href="check.php">Buy now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Jewellery Section -->
    <!-- <section id="sec2">
        <div id="jewellery" class="brand-bg">
            <h3 style="padding-left: 30%;">Enhancing senses, expanding horizons</h3>
            <div class="row" style="position: relative;">
                <?php if (!empty($jewelleryProducts)): ?>
                    <?php foreach ($jewelleryProducts as $product): ?>
                        <div class="card">
                            <a href="product_details.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>">
                                <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found.</p>
                <?php endif; ?>
            </div>
        </div>
    </section> -->

<!-- end news Jewellery -->

    <!-- end news Jewellery -->



     <!-- Save Section -->
     <section data-aos="zoom-in" data-aos-duration="3500">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="save">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="save_box">
                                    <h3>Easier than ever</h3>
                                    <a href="check.php">Buy now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
  

    </div>

    <div class="overlay"></div>

    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>

    <!-- sidebar -->
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
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
        });
    </script>

    <script>
        $(document).ready(function() {
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
    <script>
        // This example adds a marker to indicate the position of Bondi Beach in Sydney,
        // Australia.
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 11,
                center: {
                    lat: 40.645037,
                    lng: -73.880224
                },
            });

            var image = 'images/maps-and-flags.png';
            var beachMarker = new google.maps.Marker({
                position: {
                    lat: 40.645037,
                    lng: -73.880224
                },
                map: map,
                icon: image
            });
        }
    </script>
    <!-- google map js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8eaHt9Dh5H57Zh0xVTqxVdBFCvFMqFjQ&callback=initMap"></script>
    <!-- end google map js -->

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>

</body>

</html>