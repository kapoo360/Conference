<?php


// Include the database configuration file
include 'config.php';

// Determine admin's name for greeting
$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Guest';
?>



<!-- navigation.php -->
<div class="navigation">
    <ul>
    <img src="assets/imgs/logo1.png" id="logonav">
       
        <li>
            <a href="index.php">
                <span class="icon">
                    <ion-icon name="home-outline"></ion-icon>
                </span>
                <span class="title">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="users.php">
                <span class="icon">
                    <ion-icon name="people-outline"></ion-icon>
                </span>
                <span class="title">Customers</span>
                <!-- <span class="count"><?php echo number_format($totalUsers); ?></span> -->
            </a>
        </li>

        <li>
            <a href="orders.php">
                <span class="icon">
                    <ion-icon name="chatbubble-outline"></ion-icon>
                </span>
                <span class="title">Orders</span>
            </a>
        </li>

        <li>
            <a href="all_products.php">
                <span class="icon">
                     <ion-icon name="albums-outline"></ion-icon>
                </span>
                <span class="title">All Products</span>
            </a>
        </li>

        <li>
            <a href="add_product.php">
                <span class="icon">
                    <ion-icon name="add-circle-outline"></ion-icon>
                </span>
                <span class="title">Add Product</span>
            </a>
        </li>

        <li>
            <a href="admins.php">
                <span class="icon">
                    <ion-icon name="people-circle-outline"></ion-icon>
                </span>
                <span class="title">Admins</span>
            </a>
        </li>

       

        <li>
            <a href="admin_login.php">
                <span class="icon">
                    <ion-icon name="log-out-outline"></ion-icon>
                </span>
                <span class="title">Sign Out</span>
            </a>
        </li>
    </ul>
</div>

<!-- ========================= Main ==================== -->
<div class="main">
    <div class="topbar">
        <div class="toggle">
            <ion-icon name="menu-outline"></ion-icon>
        </div>

        <!-- <div class="search">
            <label>
                <input type="text" placeholder="Search here">
                <ion-icon name="search-outline"></ion-icon>
            </label>
        </div> -->

        <!-- <div class="user">
            <img src="assets/imgs/customer01.jpg" alt="">
        </div> -->
        <li class="greeting">
            
                <span class="icon">
                    <ion-icon name="person-outline"></ion-icon>
                </span>
                <span class="title">Hello, <?php echo htmlspecialchars($admin_name); ?></span>
           
        </li>
        
    </div>
