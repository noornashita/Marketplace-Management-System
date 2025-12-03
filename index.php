<?php
include('config.php');
$sql = "SELECT * FROM product WHERE shelf='on' AND quantity > 0 ORDER BY price;";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>2nd Hand | Main Page</title>

    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/slideshow.css">
    <link rel="stylesheet" href="css/product_slider.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background-color: #fff;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            transition: transform 0.3s ease;
        }
        .navbar-brand:hover {
            transform: scale(1.05);
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
    </style>
</head>

<body>

<header class="header">
    <nav class="navbar container">
 
        <a href="index.php" class="navbar-brand">SecondHand Marketplace</a>

        <div class="navbar-menu">
            <ul class="navbar-list">
                <li><a href="visitor/register.php" class="navbar-link" style="font-weight:bold;">Register Now!</a></li>
                <li><a href="index.php" class="navbar-link">Home</a></li>
                <li><a href="visitor/vProduct.php" class="navbar-link">Product</a></li>
                <li><a href="visitor/about_us.php" class="navbar-link">About</a></li>
                <li><a href="visitor/login.php" class="navbar-link">Login</a></li>
            </ul>
        </div>

        <button class="navbar-toggler" aria-label="Toggle menu">
            <i class="fas fa-bars"></i>
        </button>
    </nav>
</header>

<div class="slideshow-container">
    <div class="mySlides fade"><img src="images/home/second1.jpg" style="width:100%"></div>
    <div class="mySlides fade"><img src="images/home/second2.jpg" style="width:100%"></div>
    <div class="mySlides fade"><img src="images/home/second3.jpg" style="width:100%"></div>
</div>

<div style="text-align:center">
    <span class="dot"></span> 
    <span class="dot"></span> 
    <span class="dot"></span> 
</div>

<footer style="text-align:center; padding:15px; background-color:#f8f9fa; margin-top:20px;">
    <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> Second Hand Shopping Platform</p>
</footer>

<script src="javascript/product_slider.js"></script>
<script>

    document.addEventListener("DOMContentLoaded", function() {
        const toggler = document.querySelector(".navbar-toggler");
        const menu = document.querySelector(".navbar-menu");
        if (toggler && menu) {
            toggler.addEventListener("click", function() {
                menu.classList.toggle("active");
            });
        }
    });

    var slideIndex = 0;
    showSlides();
    function showSlides() {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) { slides[i].style.display = "none"; }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        if(slides.length > 0) slides[slideIndex-1].style.display = "block";
        if(dots.length > 0) dots[slideIndex-1].className += " active";
        setTimeout(showSlides, 2000);
    }
</script>

</body>
</html>