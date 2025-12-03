<?php
include '../config.php';
error_reporting(0);

if (isset($_POST['submit'])) {
    $username      = mysqli_real_escape_string($conn, $_POST['username']);
    $email         = mysqli_real_escape_string($conn, $_POST['email']);
    $password      = md5($_POST['password']);
    $cpassword     = md5($_POST['cpassword']);
    $address       = mysqli_real_escape_string($conn, $_POST['address']);
    $street        = mysqli_real_escape_string($conn, $_POST['street']);
    $area          = mysqli_real_escape_string($conn, $_POST['area']);
    $phone_number  = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $type          = mysqli_real_escape_string($conn, $_POST['type']);

    if ($password === $cpassword) {
        $checkEmail = "SELECT * FROM users WHERE email='$email'";
        $result     = mysqli_query($conn, $checkEmail);

        if (mysqli_num_rows($result) == 0) {
            $insertUser = "INSERT INTO users (username, email, password, Type, address, street, area, phone_number)
                           VALUES ('$username', '$email', '$password', '$type', '$address', '$street', '$area', '$phone_number')";
            $insertAddress = "INSERT INTO address (email, home_address, street, area, phone_number)
                              VALUES ('$email', '$address','$street', '$area', '$phone_number')";

            if (mysqli_query($conn, $insertUser) && mysqli_query($conn, $insertAddress)) {
                echo "<script src='../javascript/jquery-3.3.1.min.js'></script>";
                echo "<script src='../javascript/toastr.min.js'></script>";
                echo "<link rel='stylesheet' href='../css/toastr.min.css'>";
                echo "<script>toastr.success('Registration successful! Redirecting to login...');</script>";
                echo "<script>setTimeout(function(){ window.location.href = '../visitor/login.php'; }, 1500);</script>";
                exit();
            } else {
                echo "<script>toastr.error('Something went wrong while saving.');</script>";
            }
        } else {
            echo "<script>toastr.error('Email Already Exists!');</script>";
        }
    } else {
        echo "<script>toastr.error('Passwords do not match.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>2nd Hand | Register</title>
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
    
    .register-container {
        max-width: 800px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    }
    h2 {
        color: #007BFF;
        margin-bottom: 15px;
    }
    input[type=text],
    input[type=email],
    input[type=password],
    input[type=tel],
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        transition: 0.3s;
    }
    input:focus, select:focus {
        border-color: #007BFF;
        outline: none;
        box-shadow: 0 0 4px rgba(0,123,255,0.4);
    }
    .register {
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
    .register:hover {
        background-color: #0056b3;
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
                <li><a href="register.php" class="navbar-link" style="font-weight:bold;">Register Now!</a></li>
                <li><a href="../index.php" class="navbar-link">Home</a></li>
                <li><a href="vProduct.php" class="navbar-link">Product</a></li>
                <li><a href="about_us.php" class="navbar-link">About</a></li>
                <li><a href="login.php" class="navbar-link">Login</a></li>
            </ul>
        </div>
    </nav>
</header>


<div class="register-container">
    <form method="post">
        <h2>General Information</h2>
        <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" placeholder="Username" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="cpassword" placeholder="Confirm Password" required>

        <!--  User Type Selection -->
        <label for="type">Select User Type</label>
        <select name="type" id="type" required>
            <option value="">-- Choose --</option>
            <option value="Admin" <?php if(($_POST['type'] ?? '')=='Admin') echo 'selected'; ?>>Admin</option> 
            <option value="Buyer" <?php if(($_POST['type'] ?? '')=='Buyer') echo 'selected'; ?>>Buyer</option>
            <option value="Seller" <?php if(($_POST['type'] ?? '')=='Seller') echo 'selected'; ?>>Seller</option>
        </select>

        <h2>Contact Details</h2>
        <input type="text" name="address" value="<?php echo htmlspecialchars($_POST['address'] ?? ''); ?>" placeholder="City" required>
        <input type="text" name="street" value="<?php echo htmlspecialchars($_POST['street'] ?? ''); ?>" placeholder="Street" required>
        <input type="text" name="area" value="<?php echo htmlspecialchars($_POST['area'] ?? ''); ?>" placeholder="Area" required>
        <input type="tel" name="phone_number" pattern="[0-9]*" value="<?php echo htmlspecialchars($_POST['phone_number'] ?? ''); ?>" placeholder="Phone Number" required>

        <input type="submit" name="submit" class="register" value="Register">
    </form>
</div>

<footer>
    <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> Second Hand Shopping Platform</p>
</footer>

<script src="../javascript/jquery-3.3.1.min.js"></script>
<script src="../javascript/toastr.min.js"></script>

</body>
</html>
