<?php 
include '../config.php';
session_start();
error_reporting(0);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>2nd Hand | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <link rel="stylesheet" href="../css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background-color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }
        .header {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        .navbar-brand {
            font-size: 30px;
            font-weight: bold;
            background: linear-gradient(45deg, #007BFF, #00C6FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }
        .navbar-menu {
            display: flex;
            align-items: center;
        }
        .navbar-list {
            list-style: none;
            display: flex;
            gap: 15px;
            margin: 0;
            padding: 0;
        }
        .navbar-link {
            text-decoration: none;
            color: #007BFF;
            font-weight: 500;
            padding: 8px 14px;
            border: 2px solid #007BFF;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .navbar-link:hover {
            background-color: #007BFF;
            color: #fff;
        }

        .login-container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            color: #007BFF;
            margin-bottom: 20px;
            text-align: center;
        }
        input[type=email],
        input[type=password] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: 0.3s;
        }
        input:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 4px rgba(0,123,255,0.4);
        }
        .login-btn {
            background-color: #007BFF;
            border: none;
            padding: 12px;
            width: 100%;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }
        .login-btn:hover {
            background-color: #0056b3;
        }
        .signup_link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        .signup_link a {
            color: #007BFF;
            text-decoration: none;
            font-weight: 500;
        }
        .signup_link a:hover {
            text-decoration: underline;
        }
        footer {
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<header class="header">
    <nav class="navbar container">
        <a href="../index.php" class="navbar-brand">SecondHand Marketplace</a>
        <div class="navbar-menu">
            <ul class="navbar-list">
                <li><a href="../visitor/register.php" class="navbar-link" style="font-weight:bold;">Register Now!</a></li>
                <li><a href="../index.php" class="navbar-link">Home</a></li>
                <li><a href="../visitor/vProduct.php" class="navbar-link">Product</a></li>
                <li><a href="../visitor/about_us.php" class="navbar-link">About</a></li>
                <li><a href="../visitor/login.php" class="navbar-link">Login</a></li>
            </ul>
        </div>
    </nav>
</header>

<div class="login-container">
    <form method="POST">
        <h2>Login</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="submit" class="login-btn" value="Login">
        <div class="signup_link">
            Don't have an account? <a href="register.php">Register</a>
        </div>
    </form>
</div>

<footer>
    <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> Second Hand Shopping Platform</p>
</footer>

<script src="../javascript/jquery-3.3.1.min.js"></script>
<script src="../javascript/toastr.min.js"></script>

<?php
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);   
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['Type'] = $row['Type'];

        if ($_SESSION['Type'] == 'Admin') {
            echo '<script type="text/javascript">toastr.success("Login Successful! Redirecting...")</script>';
            echo "<script>setTimeout(\"location.href = '../admin/aUserList.php';\",1500);</script>";
        } elseif ($_SESSION['Type'] == 'Buyer') {
            echo '<script type="text/javascript">toastr.success("Login Successful! Redirecting...")</script>';
            echo "<script>setTimeout(\"location.href = '../buyer/buyerMain.php';\",1500);</script>";
        } elseif ($_SESSION['Type'] == 'Seller') {
            echo '<script type="text/javascript">toastr.success("Login Successful! Redirecting...")</script>';
            echo "<script>setTimeout(\"location.href = '../seller/sellerMain.php';\",1500);</script>";
        } else {
            echo '<script type="text/javascript">toastr.error("Unknown user type!")</script>';
        }
    } else {
        echo '<script type="text/javascript">toastr.error("Wrong Password or Email!")</script>';
    }
}
?>
</body>
</html>
