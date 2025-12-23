<?php
// Get current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="col-md-3 col-lg-2 d-md-block sidebar collapse" id="sidebarMenu">
   
    <a class="navbar-brand d-block text-center mb-3" href="index.php">
       <img src="images/Calibite_logo.png" alt="Calibite Logo" height="40">
    </a>

  
    <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
        <i class="fa fa-home me-2 mr-1"></i> Dashboard
    </a>
    <a href="category.php" class="<?php echo ($current_page == 'category.php') ? 'active' : ''; ?>">
        <i class="fa fa-tags me-2 mr-1"></i> Categories
    </a>
    <a href="product.php" class="<?php echo ($current_page == 'product.php') ? 'active' : ''; ?>">
        <i class="fa fa-box me-2 mr-1"></i> Products
    </a>
    <a href="logout.php" class="text-danger">
        <i class="fa fa-sign-out-alt me-2"></i> Logout
    </a>
</div>

