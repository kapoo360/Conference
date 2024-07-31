<?php
// Start the session
session_start();

// Include the database configuration file
include 'config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = ''; // Initialize error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize input
    $email = htmlspecialchars(strip_tags($email));
    $password = htmlspecialchars(strip_tags($password));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check if the user exists and the password is correct
        $sql = "SELECT user_id, username, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($user_id, $username, $hashed_password);

            if ($stmt->num_rows == 1 && $stmt->fetch()) {
                if (password_verify($password, $hashed_password)) {
                    // Password is correct, set session variables
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;

                    // Redirect to index page after successful login
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Incorrect password. Please try again.";
                }
            } else {
                $error = "No account found with that email.";
            }

            $stmt->close();
        } else {
            $error = "Database error.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/png" href="images/icc1.png">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="icon" type="png" href="images/icc1.png">
</head>
<body>
  <div class="form-container" data-aos="zoom-in" data-aos-duration="3500">
    <div class="logo1">
      <img src="images/logoblack.png" alt="" style="width: 300px; margin-left: 45px; margin-top: 20px;">
    </div>
    <form class="form" method="POST" action="login.php" style="margin-top: 130px;">
      <!-- <p class="sub-title">Let's get started</p> -->
      <input type="email" class="input" name="email" placeholder="Email" required>
      <input type="password" class="input" name="password" placeholder="Password" required>
      <button type="submit" class="form-btn">Login</button>
    </form>
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    
    <div class="buttons-container">
      <!-- <div class="apple-login-button">
        <svg stroke="currentColor" fill="currentColor" stroke-width="0" class="apple-icon" viewBox="0 0 1024 1024" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
          <path d="M747.4 535.7c-.4-68.2 30.5-119.6 92.9-157.5-34.9-50-87.7-77.5-157.3-82.8-65.9-5.2-138 38.4-164.4 38.4-27.9 0-91.7-36.6-141.9-36.6C273.1 298.8 163 379.8 163 544.6c0 48.7 8.9 99 26.7 150.8 23.8 68.2 109.6 235.3 199.1 232.6 46.8-1.1 79.9-33.2 140.8-33.2 59.1 0 89.7 33.2 141.9 33.2 90.3-1.3 167.9-153.2 190.5-221.6-121.1-57.1-114.6-167.2-114.6-170.7zm-105.1-305c50.7-60.2 46.1-115 44.6-134.7-44.8 2.6-96.6 30.5-126.1 64.8-32.5 36.8-51.6 82.3-47.5 133.6 48.4 3.7 92.6-21.2 129-63.7z"></path>
        </svg>
        <span>Login with Apple</span>
      </div> -->
      <div class="google-login-button">
        <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" x="0px" y="0px" class="google-icon" viewBox="0 0 48 48" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
          <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12
      c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24
      c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
          <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657
      C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
          <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36
      c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
          <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571
      c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
        </svg>
        <span>Login with Google</span>
      </div>
      <p class="login-label">
      Don't have an account? <a href="signup.php">Sign up</a>
    </p>
    </div>
  </div>
  <!-- <footer>
    <div class="copyright">
      <div class="container">
        <p>Copyright 2024 All Right Reserved By <a href="https://www.facebook.com/SBS.Student.Activity?mibextid=LQQJ4d" style="color: black;">Team-5 Conference</a></p>
      </div>
    </div>
  </footer> -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>

</body>
</html>