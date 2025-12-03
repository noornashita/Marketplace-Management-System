<?php
include('../config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>2nd Hand | About Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
        .navbar-toggler {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
        }

        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
                flex-direction: column;
                background-color: #fff;
                position: absolute;
                top: 60px;
                right: 0;
                width: 200px;
                border: 1px solid #ddd;
                padding: 10px 0;
            }
            .navbar-menu.active { display: flex; }
            .navbar-toggler { display: block; cursor: pointer; }
            .navbar-list {
                flex-direction: column;
                gap: 10px;
            }
            .navbar-link {
                display: block;
                text-align: center;
            }
        }

        .about-section {
            padding: 40px 50px;
            text-align: center;
            background: linear-gradient(45deg, #007BFF, #00C6FF);
            color: white;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .row {
            max-width: 1200px;
            margin: 30px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .column {
            flex: 1 1 30%;
            max-width: 30%;
            box-sizing: border-box;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .card .container {
            padding: 15px 20px;
        }
        .card h2 {
            margin: 10px 0;
            font-size: 22px;
            color: #007BFF;
        }
        .card p {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
        }

        @media screen and (max-width: 960px) {
            .column {
                max-width: 45%;
                flex: 1 1 45%;
            }
        }
        @media screen and (max-width: 650px) {
            .column {
                max-width: 100%;
                flex: 1 1 100%;
            }
            .about-section {
                font-size: 22px;
                padding: 30px 20px;
            }
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
        <button class="navbar-toggler" aria-label="Toggle menu">
            <i class="fas fa-bars"></i>
        </button>
    </nav>
</header>

<div class="about-section">
    ABOUT US
</div>

<div class="row">
    <div class="column">
        <div class="card">
            <img src="../images/about/buy.jpg" alt="Buy">
            <div class="container">
                <h2>Buy Desired 2nd-Hand Item</h2>
                <p>Find anything second hand through our website.</p>
                <p>Product can be searched by keywords, category and price.</p>
            </div>
        </div>
    </div>

    <div class="column">
        <div class="card">
            <img src="../images/about/sell.jpg" alt="Sell">
            <div class="container">
                <h2>Sell Your Own 2nd-Hand Item</h2>
                <p>Submit your product information for selling.</p>
                <p>Any Completed Order will be charged 5% commissions.</p>
            </div>
        </div>
    </div>

    <div class="column">
        <div class="card">
            <img src="../images/about/review.jpg" alt="Review">
            <div class="container">
                <h2>All Products Are Reviewed</h2>
                <p>Admin will review the product information first.</p>
                <p>Once the products are approved, they can start selling.</p>
            </div>
        </div>
    </div>

    <div class="column">
        <div class="card">
            <img src="../images/about/call.jpeg" alt="Contact">
            <div class="container">
                <h2>Feel Free To Contact Us</h2>
                <p>We hope you enjoy shopping with us!</p>
                <p>Email Address: ibrahim@gmail.com</p>
                <p>Phone Number: 01323414291</p>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> Second Hand Shopping Platform</p>
</footer>

<script>
document.querySelector('.navbar-toggler').addEventListener('click', function() {
    document.querySelector('.navbar-menu').classList.toggle('active');
});
</script>

</body>
</html>
