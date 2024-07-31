<?php
session_start();
include('config.php'); // Include your database connection

// Initialize variables for error messages
$error_message = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email belongs to an admin
    $stmt = $conn->prepare("SELECT admin_id, admin_name, admin_email, admin_password FROM admins WHERE admin_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($admin_id, $admin_name, $admin_email, $admin_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        // Verify the password
        if (password_verify($password, $admin_password)) {
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_name'] = $admin_name;
            $_SESSION['admin_email'] = $admin_email;
            header("Location: index.php"); // Redirect to admin dashboard
            exit();
        } else {
            $error_message = 'Email or password is incorrect';
        }
    } else {
        $error_message = 'Email or password is incorrect';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="assets/css/login.css"> <!-- Link to your CSS -->
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="col-left">
                <div class="login-text">
                    <!-- <h2>Welcome Back</h2> -->
                    <!-- <p>Create your account.<br>It's totally free.</p>
                    <a class="btn" href="">Sign Up</a> -->
                    <img src="assets/imgs/logo1.png">
                </div>
            </div>
            <div class="col-right">
                <div class="login-form">
                    <h2>Login</h2>
                    <?php if ($error_message): ?>
                        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
                    <?php endif; ?>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <p>
                            <label for="email">email address<span>*</span></label>
                            <input type="email" id="email" name="email" placeholder="Username or Email" required>
                        </p>
                        <p>
                            <label for="password">Password<span>*</span></label>
                            <input type="password" id="password" name="password" placeholder="Password" required>
                        </p>
                        <p>
                            <input type="submit" value="Sign In" />
                        </p>
                        <!-- <p>
                            <a href="#">Forget Password?</a>
                        </p> -->
                    </form>
                </div>
            </div>
        </div>
       
    </div>
</body>
</html>
