<?php
// Get current page filename
$current_page = basename($_SERVER['PHP_SELF']);

// Default page title
$page_title = "Dashboard";

// Map filenames to readable titles
$page_titles = [
    'dashboard.php'     => 'Dashboard',
    'category.php'    => 'Categories',
    'add_category.php'  => 'Add Category',
    'products.php'      => 'Products',
    'add_product.php'   => 'Add Product',
    'orders.php'        => 'Orders',
    'users.php'         => 'Users',
    'login.php'         => 'Login',
];


if (isset($page_titles[$current_page])) {
    $page_title = $page_titles[$current_page];
}
?>

<div class="top-header mb-4 d-flex justify-content-between align-items-center">
    <h4><?php echo htmlspecialchars($page_title); ?></h4>
    <div class="d-flex align-items-center">
        <span class="me-3"><i class="fa fa-user-circle me-1"></i> <?php echo htmlspecialchars($admin_name ?? 'Admin'); ?></span>
        
        <button class="btn d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
            <i class="fa fa-bars me-1"></i>
        </button>
    </div>
</div>
