<?php
include '../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Review Product | Admin</title>
  <link rel="stylesheet" href="../css/menu.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <style>
    body {
      background-color: #fff;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Navbar */
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
      font-size: 26px;
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

      .navbar-menu.active {
        display: flex;
      }

      .navbar-toggler {
        display: block;
        cursor: pointer;
      }

      .navbar-list {
        flex-direction: column;
        gap: 10px;
      }

      .navbar-link {
        display: block;
        text-align: center;
      }
    }

    /* Page Content */
    .center {
      margin: 30px auto;
      width: 95%;
      padding: 10px;
      text-align: center;
    }

    h1 {
      color: #007BFF;
      margin-bottom: 20px;
    }

    #users {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    #users td, #users th {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
      vertical-align: middle;
    }

    #users tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    #users tr:hover {
      background-color: #f1f1f1;
    }

    #users th {
      background-color: #007BFF;
      color: white;
      padding: 12px;
    }

    /* Buttons */
    .btn-approve {
      background-color: #28a745;
      border-radius: 25px;
      width: 75px;
      border: none;
      display: block;
      color: white;
      margin: 5px auto;
      padding: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-approve:hover {
      background-color: #218838;
    }

    .btn-decline {
      background-color: #dc3545;
      border-radius: 25px;
      width: 75px;
      border: none;
      display: block;
      margin: 5px auto;
      padding: 6px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-decline:hover {
      background-color: #c82333;
    }

    .reason-box {
      width: 90%;
      padding: 5px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    /* Footer */
    footer {
      text-align: center;
      padding: 15px;
      background-color: #f8f9fa;
      margin-top: 30px;
      border-top: 1px solid #ddd;
    }
  </style>
</head>
<body>

<header class="header">
  <nav class="navbar container">
    <a href="ahome.php" class="navbar-brand">SecondHand Marketplace</a>
    <div class="navbar-menu">
      <ul class="navbar-list">
        <li><a href="aUserList.php" class="navbar-link">Customer List</a></li>
        <li><a href="aHome.php" class="navbar-link">Review Product</a></li>
        <li><a href="aCategory.php" class="navbar-link">Category List</a></li>
        <li><a href="../logout.php" class="navbar-link">Logout</a></li>
      </ul>
    </div>
    <button class="navbar-toggler" aria-label="Toggle menu">
      <i class="fas fa-bars"></i>
    </button>
  </nav>
</header>

<div class="center">
  <h1>Review List</h1>
  <table id="users">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Image</th>
        <th>Description</th>
        <th>Username</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $query = "SELECT * FROM product WHERE status = 'pending' ORDER BY id ASC";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {    
          while($row = mysqli_fetch_array($result)){
      ?>
      <tr>
        <td><?php echo $row['id'];?></td>
        <td><?php echo $row['title'];?></td>
        <td><?php echo $row['category'];?></td>
        <td><?php echo $row['quantity'];?></td>
        <td><?php echo $row['price'];?></td>
        <td><img src="../images/<?php echo $row['image'];?>" width="100"></td>
        <td><?php echo $row['description'];?></td>
        <td><?php echo $row['seller_id'];?></td>
        <td>
          <form method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
            <input type="submit" name="approve" value="✓" class="btn-approve"/>
          </form>
          <form method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
            <input type="submit" name="decline" value="X" class="btn-decline"/>
            <input type="text" name="reason" placeholder="Reason?" class="reason-box" required/>
          </form>
        </td>
      </tr>
      <?php
          }
        } else {
          echo "<tr><td colspan='9' style='color:red; font-weight:bold;'>No item to be reviewed!</td></tr>";
        }
      ?>
    </tbody>
  </table>
</div>

<footer>
  <p>Copyright &copy;
    <script>document.write(new Date().getFullYear());</script>
    Second Hand Shopping Platform - Admin
  </p>
</footer>

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
</script>

</body>
</html>

<?php
if(isset($_POST['approve'])){
    $id = $_POST['id'];
    $select = "UPDATE product set status = 'approve'  WHERE id = '$id'";
    $result = mysqli_query($conn, $select);

    echo '<script>alert("Product Approved!"); window.location.href="ahome.php";</script>';
}

if(isset($_POST['decline'])){
    $id = $_POST['id'];
    $reason = $_POST['reason'];
    $select = "UPDATE product set status = 'decline', reason = '$reason' WHERE id = '$id'";
    $result = mysqli_query($conn, $select);

    echo '<script>alert("Product Declined!"); window.location.href="ahome.php";</script>';
}
?>
