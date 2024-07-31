
<?php
// Start the session

// Include database configuration
include 'config.php';

// Check if the user is logged in
$loggedIn = isset($_SESSION['username']);


// Close the connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    
<div class="sidebar">
    <!-- Sidebar  -->
     
    <li>
        <button type="button" id="sidebarCollapse">
            <img src="images/menu_icon.png" alt="#" />
        </button>
    </li>
    <nav id="sidebar">
        

        <div id="dismiss">
            <i class="fa fa-arrow-left"></i>
        </div>
            <li id="nav">
                <a href="index.php"><img src="images/LOGOm.png" alt="#" class="sidebar-logo"></a>
            </li>
        <ul class="list-unstyled components">
        
        

            <!-- <h3 style="padding-left: 22px;">Smart Senses</h3> -->

            <li class="active">
                <a href="index.php">Home</a>
            </li>
            <li>
                <a href="about_us.php">About Us</a>
            </li>
            <li>
                <a href="#sec1-2">E-AR</a>
            </li>
            <li>
                <a href="#sec1-2">A-EYE</a>
            </li>
            <li>
                <a href="userallproducts.php">All Products</a>
            </li>
            <?php if ($loggedIn): ?>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            <?php endif; ?>
        </ul>

    </nav>


    
</div>


</body>
</html>

