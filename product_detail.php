<?php
include('../config.php');
session_start();

// FIX: Ensure this is the correct file name (product_detail.php) for internal redirects
$current_page_file = "product_detail.php";

$product_data = null;
if(isset($_GET['pid'])){
    $pid = $_GET['pid'];
    // Sanitizing PID for database query
    $safe_pid = mysqli_real_escape_string($conn, $pid); 
    
    // JOIN to get category name and select all required fields including seller_username
    $sql="SELECT 
            p.*, 
            c.name AS category_name 
          FROM product p
          LEFT JOIN category c ON p.category = c.id 
          WHERE p.id = '$safe_pid'";
    $result=$conn->query($sql);
    
    if($result && $result->num_rows > 0){
        $product_data = $result->fetch_assoc();
    }
}

// Function to handle add to cart
if(isset($_POST['addcart'])){
    if(!isset($_SESSION['email'])){
        echo '<script type="text/javascript">';
        echo 'alert("Please log in to add products to the cart.");';
        echo 'window.location.href = "login.php"';
        echo '</script>';
        exit;
    }
    
    // Sanitize and get POST data
    $email = mysqli_real_escape_string($conn, $_SESSION['email']);
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $quantity_to_add = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; 
    $price = floatval($_POST['price']);

    // Check if item is already in cart
    $check_sql = "SELECT quantity, price FROM cart WHERE id = '$id' AND email = '$email'";
    $check_result = $conn->query($check_sql);
    
    if($check_result->num_rows > 0) {
        // Item exists, update quantity
        $row = $check_result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity_to_add;
        $new_total_price = $row['price'] * $new_quantity; 
        
        $update_query = "UPDATE cart SET quantity = $new_quantity, totalPrice = $new_total_price WHERE id = '$id' AND email = '$email'";
        mysqli_query($conn, $update_query);
        
        echo '<script type="text/javascript">';
        echo 'alert("Product quantity updated in cart! Total quantity: ' . $new_quantity . '");';
        echo 'window.location.href = "' . $current_page_file . '?pid=' . $id . '"';
        echo '</script>';
    } else {
        // Item does not exist, insert into cart
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $image = mysqli_real_escape_string($conn, $_POST['image']);
        $category_id = mysqli_real_escape_string($conn, $_POST['category']);
        $seller_id = mysqli_real_escape_string($conn, $_POST['seller_id']);
        $ikey = $id . $email;
        $totalprice = $price * $quantity_to_add;
        
        $insert_query = "INSERT INTO cart (id, title, description, quantity, price, image, category, totalPrice, email, ikey, seller_id) 
                         VALUES ('$id', '$title', '$description', $quantity_to_add, $price, '$image', '$category_id', $totalprice, '$email', '$ikey', '$seller_id')";
        
        if (mysqli_query($conn, $insert_query)) {
            echo '<script type="text/javascript">';
            echo 'alert("Product added to cart!");';
            echo 'window.location.href = "' . $current_page_file . '?pid=' . $id . '"';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Error adding product to cart: ' . mysqli_error($conn) . '");';
            echo 'window.location.href = "' . $current_page_file . '?pid=' . $id . '"';
            echo '</script>';
        }
    }
    exit;
}

// Durant (Delete) and Chat logic are kept for completeness
if(isset($_POST['durant'])){
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $select = "DELETE FROM product WHERE id = '$id'";
    $result_delete = mysqli_query($conn, $select);

    echo '<script type="text/javascript">';
    echo 'alert("Product Deleted!");';
    echo 'window.location.href = "ApproveList.php"';
    echo '</script>';
    exit;
}

if(isset($_POST['chat'])){
    $seller_id = mysqli_real_escape_string($conn, $_POST['seller_id']);
    echo '<script type="text/javascript">';
    echo 'alert("Starting chat with Seller ID: ' . $seller_id . '");';
    echo '</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>2nd Hand | Product Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 
    
    <style>
        /* Base Styles */
        :root {
            --primary-blue: #007BFF;
            --secondary-blue: #00C6FF;
            --light-bg: #f8f9fa;
            --text-color: #212529;
            --price-red: #ee4d2d; 
        }

        html {
            scroll-behavior: smooth;
            box-sizing: border-box;
            font-size: 62.5%; /* 1rem = 10px */
        }

        *, *::before, *::after {
            box-sizing: inherit;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 1.6rem;
            font-weight: 400;
            color: var(--text-color);
            margin: 0;
            background-color: #fff;
        }

        a {
            text-decoration: none;
            color: var(--primary-blue);
        }
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header/Navigation Styles */
        .header {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }
        .navbar-brand {
            font-size: 30px;
            font-weight: bold;
            background: linear-gradient(45deg, var(--primary-blue), var(--secondary-blue));
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
            color: var(--primary-blue);
            font-weight: 500;
            padding: 8px 14px;
            border: 2px solid var(--primary-blue);
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .navbar-link:hover {
            background-color: var(--primary-blue);
            color: #fff;
        }
        /* Style for Register/Login button to stand out */
        .navbar-list li:first-child a {
            background-color: var(--primary-blue);
            color: white !important;
            border-color: var(--primary-blue);
        }
        .navbar-list li:first-child a:hover {
             background-color: #0056b3;
        }
        .navbar-toggler {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: var(--primary-blue);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
                flex-direction: column;
                background-color: #fff;
                position: absolute;
                top: 60px;
                right: 0;
                width: 100%;
                border-top: 1px solid #ddd;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                padding: 10px 0;
                z-index: 100;
            }
            .navbar-menu.active { display: flex; }
            .navbar-toggler { display: block; }
            .navbar-list {
                flex-direction: column;
                gap: 10px;
                padding: 0 20px;
            }
            .navbar-link {
                display: block;
                text-align: center;
            }
        }

        /* Product Detail Styles */
        .section {
            padding: 5rem 0;
        }
        
        .product-detail .details {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 5rem;
            padding: 2rem 0;
            max-width: 1000px;
            margin: 0 auto;
        }

        .product-detail .left {
            display: flex;
            flex-direction: column;
        }

        .product-detail .left .main {
            text-align: center;
            background-color: var(--light-bg);
            height: 45rem;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 0.2rem 0.5rem rgba(0, 0, 0, 0.05);
        }

        .product-detail .left .main img {
            object-fit: contain;
            height: 100%;
            width: 100%;
            padding: 1rem;
        }
        
        .product-detail .right h1 {
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: #343a40;
        }
        
        .product-detail .right span {
            color: #6c757d;
            font-size: 1.4rem;
        }

        .product-detail .right .price {
            font-weight: 700;
            font-size: 3rem;
            color: var(--price-red);
            margin: 1.5rem 0;
        }
        
        .product-detail .right h5 {
            color: #28a745; /* Green for stock */
            font-size: 1.8rem;
            margin-bottom: 2rem;
        }
        .product-detail .right h5.out-of-stock {
            color: var(--price-red);
        }

        .product-detail .form {
            margin-bottom: 3rem;
        }
        
        .product-detail .form .addCart,
        .btn-chat {
            background-color: var(--primary-blue);
            color: white;
            border: none;
            padding: 1rem 3rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 1.6rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            display: inline-block;
            margin-right: 1.5rem;
            margin-top: 1rem;
        }
        
        .product-detail .form .addCart:hover,
        .btn-chat:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        
        .btn-chat {
            background-color: #28a745; 
        }
        .btn-chat:hover {
            background-color: #1e7e34;
        }

        .product-detail h3 {
            text-transform: uppercase;
            margin-top: 3rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--primary-blue);
            padding-bottom: 0.5rem;
            font-size: 2rem;
            color: #343a40;
        }
        
        .product-detail .right p {
            line-height: 1.6;
            color: #495057;
            font-size: 1.6rem;
        }
        
        .product-detail .right .login-message {
             font-size: 1.8rem;
             margin-top: 3rem;
             color: #dc3545;
        }
        
        .product-detail .right .login-message a {
            font-weight: 600;
            color: var(--primary-blue);
            text-decoration: underline;
        }
        .product-detail .right .login-message a:hover {
            color: #0056b3;
        }

        @media only screen and (max-width: 996px) {
             .product-detail .details {
                grid-template-columns: 1fr;
                gap: 3rem;
                padding: 2rem;
             }

             .product-detail .left .main {
                 height: 40rem;
             }
        }
        
        /* Footer */
        footer {
            text-align: center; 
            padding: 15px; 
            background-color: var(--light-bg); 
            margin-top: 3rem;
            color: #6c757d;
            font-size: 1.4rem;
        }
    </style>
</head>

<body>

<header class="header">
    <nav class="navbar container"> 
        <a href="../index.php" class="navbar-brand">SecondHand Marketplace</a>

        <div class="navbar-menu" id="navbarMenu">
            <ul class="navbar-list">
                <li><a href="../visitor/register.php" class="navbar-link">Register Now!</a></li>
                <li><a href="../index.php" class="navbar-link">Home</a></li>
                <li><a href="../visitor/vProduct.php" class="navbar-link">Product</a></li>
                <li><a href="../visitor/about_us.php" class="navbar-link">About</a></li>
                <li><a href="../visitor/login.php" class="navbar-link">Login</a></li>
            </ul>
        </div>

        <button class="navbar-toggler" aria-label="Toggle menu" onclick="document.getElementById('navbarMenu').classList.toggle('active')">
            <i class="fas fa-bars"></i>
        </button>
    </nav>
</header>

<main>
    <?php
        if ($product_data):
            // Use the data fetched earlier
            $id = htmlspecialchars($product_data['id']);
            $title = htmlspecialchars($product_data['title']);
            $description = htmlspecialchars($product_data['description']);
            $quantity = intval($product_data['quantity']);     
            $price = number_format(floatval($product_data['price']), 2);
            $image = htmlspecialchars($product_data['image']);
            $category_display = htmlspecialchars($product_data['category_name'] ?? 'All Product');
            $category_id = htmlspecialchars($product_data['category']);
            $seller_id = htmlspecialchars($product_data['seller_id']); 
            $seller_username = htmlspecialchars($product_data['seller_username'] ?? 'N/A');
    ?>

    <section class="section product-detail">
        <div class="details container">
            <div class="left">
                <div class="main">
                    
                    <img src="../images/<?php echo $image; ?>" alt="<?php echo $title; ?>">
                </div>
            </div>
            <div class="right">
                <span>Home / <?php echo $category_display; ?></span>
                <h1><?php echo $title; ?></h1>
                <div class="price">BDT <?php echo $price; ?></div>
                
                <h5 class="<?php echo $quantity > 0 ? '' : 'out-of-stock'; ?>">
                    Available stock: <?php echo $quantity; ?> 
                    (Seller: <?php echo $seller_username; ?>)
                </h5>

                <h3>Product Detail</h3>
                <p><?php echo $description; ?></p>

                <div class="form">
                    <?php if ($quantity > 0): ?>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <input type="hidden" value="<?php echo $title; ?>" name="title">
                            <input type="hidden" value="<?php echo $description; ?>" name="description">
                            <input type="hidden" value="<?php echo $category_id; ?>" name="category">
                            <input type="hidden" value="<?php echo $product_data['price']; ?>" name="price"> 
                            <input type="hidden" value="<?php echo $image; ?>" name="image">
                            <input type="hidden" value="<?php echo $seller_id; ?>" name="seller_id">
                            <input type="hidden" name="quantity" value="1">
                            
                            <?php if (isset($_SESSION['email'])): // Only show buttons if logged in ?>
                                <button type="submit" name="addcart" class="addCart">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                                <button type="submit" name="chat" class="btn-chat">
                                    <i class="fas fa-comment-alt"></i> Chat with Seller
                                </button>
                            <?php else: // Show login message if not logged in ?>
                                <p class="login-message">
                                    Please <a href="login.php">Log in</a> to buy this product or chat with the seller.
                                </p>
                            <?php endif; ?>
                        </form>
                    <?php else: ?>
                        <h4 class="login-message">This product is currently out of stock.</h4>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>

    <?php
        else:
    ?>
    <div class="container" style="text-align: center; padding: 10rem 0;">
        <h2 style="color: #dc3545;"><i class="fas fa-exclamation-triangle"></i> Product Not Found</h2>
        <p style="font-size: 1.8rem;">The product you are looking for does not exist or the ID is invalid.</p>
        <a href="vProduct.php" class="navbar-link" style="margin-top: 3rem; display: inline-block;">Browse All Products</a>
    </div>
    <?php
        endif;
    ?>
</main>

<footer>
    <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> Second Hand Shopping Platform</p>
</footer>
      
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggler = document.querySelector(".navbar-toggler");
        const menu = document.getElementById("navbarMenu");
        if (toggler && menu) {
            toggler.addEventListener("click", function() {
                menu.classList.toggle("active");
            });
        }
    });
</script>
</body>
</html>