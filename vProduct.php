<?php
$min = 1;
$max = 10000;

if (!empty($_POST['min_price'])) {
    $min = $_POST['min_price'];
}

if (!empty($_POST['max_price'])) {
    $max = $_POST['max_price'];
}

$keyword = "";
if (!empty($_POST['search_product'])) {
    $keyword = $_POST['search_product'];
}

include('../config.php');

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$num_per_page = 6;
$start_from = ($page - 1) * $num_per_page; 

$select_category = "";
$base_query = "SELECT * FROM product 
               WHERE shelf='on' AND quantity > 0 
               AND price BETWEEN '$min' AND '$max' 
               AND title LIKE '%$keyword%'";

if (!empty($_POST['category'])) {
    $select_category = $_POST['category'];
    $sql = $base_query . " AND category IN (SELECT id FROM category WHERE name = '$select_category')";
    $count_query = $base_query . " AND category IN (SELECT id FROM category WHERE name = '$select_category')";
} else {
    $sql = $base_query;
    $count_query = $base_query;
}

$sql .= " ORDER BY price LIMIT $start_from, $num_per_page;";
$result = $conn->query($sql);

$sql5 = "SELECT * FROM category";
$result5 = $conn->query($sql5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>2nd Hand | Products</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Base Styles */
    :root {
        --primary-blue: #007BFF;
        --secondary-blue: #00C6FF;
        --light-bg: #f8f9fa;
        --text-color: #212529;
    }

    html {
        box-sizing: border-box;
        font-size: 62.5%; /* 1rem = 10px */
    }

    *, *::before, *::after {
        box-sizing: inherit;
    }

    body {
        background-color: #fff;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1.6rem;
    }

    a {
        text-decoration: none;
        color: var(--primary-blue);
    }
    
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Navbar (Matching Index/About Us) */
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
    /* Highlighted link (Register Now) */
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

    /* Search bar */
    .search {
        text-align: center;
        margin: 20px auto;
        max-width: 600px;
        padding: 0 20px;
    }
    .search input {
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 1.6rem;
        transition: 0.3s;
    }
    .search input:focus {
        border-color: var(--primary-blue);
        outline: none;
        box-shadow: 0 0 4px rgba(0,123,255,0.4);
    }

    /* Layout Sections */
    .page-section {
        padding: 20px 0;
    }
    .product-layout {
        display:flex; 
        gap:30px; 
        align-items: flex-start;
    }
    
    /* Sidebar (Categories) */
    .blog-form {
        padding: 20px;
        border: 1px solid #eee; 
        border-radius: 8px;
        background-color: var(--light-bg);
        flex: 1; 
        min-width: 200px;
    }
    .blog-sidebar-title {
        color: var(--primary-blue);
        font-size: 2.2rem;
        margin-top: 0;
    }
    .blog-form hr {
        border: 0;
        border-top: 1px solid #ccc;
        margin-bottom: 15px;
    }
    .blog-form p {
        font-size: 1.6rem;
        margin: 8px 0;
    }
    .blog-form input[type="radio"] {
        margin-right: 8px;
        transform: scale(1.2);
    }
    
    /* Products Grid */
    .products-main {
        flex: 3;
    }
    .products-grid {
        display:flex; 
        flex-wrap:wrap; 
        gap:20px;
    }

    /* Product Cards */
    .card {
        border: 1px solid #eee;
        border-radius: 8px;
        box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        flex: 1 1 calc(33.333% - 20px); 
        text-align: center;
        overflow: hidden;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 5px 15px rgba(0,0,0,0.2);
    }
    .card-body {
        padding: 15px;
    }
    .product-image {
        max-width: 100%;
        height: 180px;
        object-fit: contain;
        margin: 0 auto 10px auto;
        display: block;
        padding: 10px;
    }
    .card-title {
        font-size: 2rem;
        margin: 5px 0;
        color: #343a40;
    }
    .card-text.small {
        font-size: 1.4rem;
        color: #6c757d;
        height: 3.6rem; 
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .card-body p:last-of-type {
        font-size: 1.8rem;
        color: #ee4d2d; 
        font-weight: 700;
        margin: 10px 0;
    }
    .btn {
        display: inline-block;
        padding: 10px 18px;
        border-radius: 5px;
        text-decoration: none;
        transition: 0.3s;
        font-size: 1.6rem;
        font-weight: 500;
        cursor: pointer;
    }
    .btn-success {
        background: var(--primary-blue);
        color: #fff;
        border: none;
        margin-top: 5px;
    }
    .btn-success:hover {
        background: #0056b3;
    }

    /* Price Filter & Reset Buttons */
    .form-price-range-filter {
        text-align: center;
        margin: 0 0 20px 0;
        padding: 10px;
        border: 1px solid #eee;
        border-radius: 8px;
        background-color: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .form-price-range-filter input[type="text"] {
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: 80px;
        text-align: center;
        margin: 0 5px 10px;
    }
    .btn-submit {
        padding: 8px 14px;
        margin: 5px;
        border-radius: 5px;
        border: 2px solid var(--primary-blue);
        background: #fff;
        color: var(--primary-blue);
        cursor: pointer;
        transition: 0.3s;
        font-size: 1.5rem;
    }
    .btn-submit:hover {
        background: var(--primary-blue);
        color: #fff;
    }
    
    /* Pagination */
    .pagination-controls {
        margin: 20px 0; 
        text-align:center;
    }
    .pagination-controls a {
        margin: 0 5px;
    }
    .pagination-controls .current-page {
        background: var(--primary-blue);
        color: #fff;
        border-color: var(--primary-blue);
    }


    /* Responsive adjustments */
    @media (max-width: 992px) {
        .product-layout {
            flex-direction: column;
            gap: 20px;
        }
        .blog-form {
            min-width: auto;
            width: 100%;
        }
        .card {
             flex: 1 1 calc(50% - 15px); 
        }
    }
    @media (max-width: 576px) {
        .card {
            flex: 1 1 100%; 
        }
    }
</style>
</head>

<body>

<header class="header">
    <nav class="navbar container">
        <a href="../index.php" class="navbar-brand">SecondHand Marketplace</a>
        <div class="navbar-menu" id="navbarMenu">
            <ul class="navbar-list">
                <li><a href="register.php" class="navbar-link">Register Now!</a></li>
                <li><a href="../index.php" class="navbar-link">Home</a></li>
                <li><a href="vProduct.php" class="navbar-link">Product</a></li>
                <li><a href="about_us.php" class="navbar-link">About</a></li>
                <li><a href="login.php" class="navbar-link">Login</a></li>
            </ul>
        </div>
        <button class="navbar-toggler" aria-label="Toggle menu" onclick="document.getElementById('navbarMenu').classList.toggle('active')">
            <i class="fas fa-bars"></i>
        </button>
    </nav>
</header>

<form id="Formid" method="post" action="">
    <div class="search">
        <input type="text" name="search_product" value="<?php echo htmlspecialchars($keyword) ?>" placeholder="Search for Products, Brand and more..">
    </div>

    <section class="page-section">
        <div class="container product-layout">

            <div class="blog-form">
                <h2 class="blog-sidebar-title"><b>Categories</b></h2>
                <hr/>
                <?php
                if ($result5->num_rows > 0) {    
                    while($row = $result5->fetch_assoc()) {
                        $name = htmlspecialchars($row['name']);
                ?>
                <p>
                    <input type="radio" name="category" value="<?php echo $name ?>" 
                        <?php echo ($select_category == $name) ? 'checked' : '' ?> onchange="this.form.submit()"> 
                        <?php echo $name ?>
                </p>
                <?php
                    }
                }
                ?>
                <p>
                     <input type="radio" name="category" value="" 
                        <?php echo ($select_category == '') ? 'checked' : '' ?> onchange="this.form.submit()"> 
                        All Products
                </p>
            </div>

            <div class="products-main">
                <div class="form-price-range-filter">
                    <label for="min">BDT</label>
                    <input type="text" id="min" name="min_price" value="<?php echo htmlspecialchars($min); ?>">
                    <label for="max">- BDT</label>
                    <input type="text" id="max" name="max_price" value="<?php echo htmlspecialchars($max); ?>">
                    <div>
                        <input type="submit" name="submit_range" value="Filter Product" class="btn-submit">
                        <input type="button" onClick="window.location.href='vProduct.php'" value="Reset" class="btn-submit">
                    </div>
                </div>

                <div class="products-grid">
                <?php
                if ($result && $result->num_rows > 0) {    
                    while($row = $result->fetch_assoc()) {
                        $id = htmlspecialchars($row['id']);
                        $title = htmlspecialchars($row['title']);
                        $description = htmlspecialchars($row['description']);
                        $price = number_format(floatval($row['price']), 2); 
                        $image = htmlspecialchars($row['image']);
                ?>
                    <div class="card">
                        <div class="card-body">
                            
                            <img src="../images/<?php echo $image;?>" class="product-image" alt="<?php echo $title;?>">
                            <h5 class="card-title"><b><?php echo $title;?></b></h5>
                            <p class="card-text small"><?php echo $description;?></p>
                            <p><b>BDT <?php echo $price;?></b></p>
                            
                            <a href="product_detail.php?pid=<?php echo $id;?>" class="btn btn-success">Check Details</a>
                        </div>
                    </div>
                <?php
                    }
                } else {
                    echo "<p style='padding: 20px; font-size: 1.8rem; color: #dc3545;'>No results found. <br> Try different or more general keywords or reset filters.</p>";
                }
                ?>
                </div>

                <div class="pagination-controls">
                <?php 
                
                $pr_result = $conn->query($count_query);
                $total_record = mysqli_num_rows($pr_result);
                $total_page = ceil($total_record / $num_per_page);
                
                $current_params = "";
                if (!empty($keyword)) $current_params .= "&search_product=" . urlencode($keyword);
                if (!empty($select_category)) $current_params .= "&category=" . urlencode($select_category);
                if (!empty($min) && $min != 1) $current_params .= "&min_price=" . $min;
                if (!empty($max) && $max != 1000) $current_params .= "&max_price=" . $max;


                if($page > 1) {
                    echo "<a href='vProduct.php?page=".($page-1). $current_params ."' class='btn-submit'>Previous</a>";
                }
                
                $start_loop = max(1, $page - 2);
                $end_loop = min($total_page, $page + 2);
                
                for($i = $start_loop; $i <= $end_loop; $i++) {
                    $class = ($i == $page) ? 'current-page' : '';
                    echo "<a href='vProduct.php?page=".$i . $current_params ."' class='btn-submit $class'>$i</a>";
                }
                
                if ($end_loop < $total_page) {
                     echo "<span style='padding: 8px 14px;'>...</span>";
                     echo "<a href='vProduct.php?page=".$total_page . $current_params ."' class='btn-submit'>$total_page</a>";
                }


                if($page < $total_page) {
                    echo "<a href='vProduct.php?page=".($page+1). $current_params ."' class='btn-submit'>Next</a>";
                }
                ?>
                </div>
            </div>
        </div>
    </section>
</form>

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