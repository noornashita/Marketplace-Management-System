<?php
include('../config.php');
session_start();
if (!isset($_SESSION['Type']) || $_SESSION['Type'] != 'Seller') {
    header("Location: ../visitor/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Main Page | Seller</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }

    /* Navbar */
    .header {
      background-color: #ffffff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 20px;
    }
    .navbar-brand {
      font-size: 28px;
      font-weight: bold;
      background: linear-gradient(45deg, #007BFF, #00C6FF);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-decoration: none;
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
      border-radius: 6px;
      transition: all 0.3s ease;
    }
    .navbar-link:hover {
      background-color: #007BFF;
      color: #fff;
    }

    /* Slideshow */
    .slideshow-container {
      max-width: 100%;
      position: relative;
      margin: 0 auto;
    }
    .mySlides {
      display: none;
    }
    .mySlides img {
      width: 100%;
      border-radius: 8px;
    }
    .dot {
      height: 12px;
      width: 12px;
      margin: 0 3px;
      background-color: #ccc;
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.6s ease;
    }
    .active {
      background-color: #007BFF;
    }

    /* Banner */
    .banner {
      padding: 4em 2em;
      text-align: center;
      background: linear-gradient(135deg, #007BFF, #00C6FF);
      color: #fff;
      border-radius: 10px;
      max-width: 1000px;
      margin: 40px auto;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .banner h2 {
      margin: 0;
      font-size: 2.5em;
      font-weight: bold;
      letter-spacing: 2px;
    }
    .banner p {
      font-size: 1.1em;
      margin-top: 15px;
    }

    footer {
      text-align: center;
      padding: 15px;
      background-color: #f8f9fa;
      margin-top: 30px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<header class="header">
  <nav class="navbar">
    <a href="sellerMain.php" class="navbar-brand">SecondHand Marketplace</a>
    <ul class="navbar-list">
      <!--<li><a href="../buyer/buyerMain.php" class="navbar-link">Buyer Centre</a></li>-->
      <li><a href="sellerMain.php" class="navbar-link">Home</a></li>
      <li><a href="sellerProduct.php" class="navbar-link">My Product</a></li>
      <li><a href="sellerOrder.php" class="navbar-link">My Order</a></li>
      <li><a href="income.php" class="navbar-link">My Income</a></li>
      <li><a href="../logout.php" class="navbar-link">Logout</a></li>
    </ul>
  </nav>
</header>

<!-- Slideshow -->
<div class="slideshow-container">
  <div class="mySlides fade"><img src="../images/logo/sellitem.png"></div>
</div>
<div style="text-align:center; margin-top:10px;">
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
</div>

<!-- Banner Section -->
<div class="banner">
  <h2>5% Commission</h2>
  <p>We charge only 5% for each successfully completed order.</p>
</div>

<!-- Footer -->
<footer>
  <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> Second Hand Shopping Platform</p>
</footer>

<!-- Slideshow Script -->
<script>
var slideIndex = 0;
showSlides();
function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) { slides[i].style.display = "none"; }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  for (i = 0; i < dots.length; i++) { dots[i].className = dots[i].className.replace(" active", ""); }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 2000);
}
</script>
</body>
</html>
