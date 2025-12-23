<?php 
include("_head.php");
include("_topbar.php");
include("navbar.php");
include("includes/db.php");

// Define WhatsApp number
define('WHATSAPP_NUMBER', '923036580158');

// Get category id
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get category info
$catQuery = mysqli_query($conn, "SELECT * FROM categories WHERE id = $category_id");
$catRow = mysqli_fetch_assoc($catQuery);
$categoryName = $catRow['name'] ?? 'Category';
$categoryImage = $catRow['image'] ?? 'images/default-category.jpg';


$productQuery = mysqli_query($conn, "SELECT * FROM products WHERE category_id = $category_id");
?>

<section>
    <div class="container py-4" data-aos="fade-up" data-aos-duration="800">

  <!-- <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($categoryName); ?></li>
    </ol>
  </nav> -->

 
<div class="row align-items-center mb-4 " style="background-color: #F2F6ED;">
  <!-- Left: Text -->
  <div class="col-md-6 ">
   <div class="text-center my-4">
  <h2 class="fw-bold mb-2"><?php echo htmlspecialchars($categoryName); ?></h2>
  <p class="text-sm mx-3">
    Explore all meals in the <?php echo htmlspecialchars($categoryName); ?> category. 
    Freshly prepared, chef-made, and ready to enjoy!
  </p>
</div>
  </div>

  <div class="col-md-6 p-0">
    <img 
      src="<?php echo !empty($catRow['image']) ? 'uploads/categories/' . $catRow['image'] : 'images/default-category.jpg'; ?>" 
      class="img-fluid rounded-end shadow" 
      alt="<?php echo htmlspecialchars($categoryName); ?>" 
      style="width: 100%; height: 250px; object-fit: cover;"
    >
  </div>
</div>
</div>
</section>



<?php include("category_section.php"); ?>

<section class="mb-5 mt-5" style="background-color: #F2F6ED;" data-aos="fade-up" data-aos-duration="800">
    <div class="container py-5">
       <h3 class="text-center text-success ">Fresh & Delicious</h3>
<p class="text-center text-muted mb-4">Handpicked meals ready to order and enjoy!</p>

        <div class="row g-4">
            <?php 
            if ($productQuery && mysqli_num_rows($productQuery) > 0): 
                while ($product = mysqli_fetch_assoc($productQuery)):

                  
                    $msg = "Hello 👋 I want to order:\n\n";
                    $msg .= "*Product:* {$product['name']}\n";
                    $msg .= "*Price:* € " . number_format($product['price'],2) . "\n";
                    $msg .= "*Details:* {$product['description']}\n";
                    $msg .= "*Link:* " . "https://limo.idealdollarshop.com/product.php?id={$product['id']}";
                    $waLink = "https://wa.me/" . WHATSAPP_NUMBER . "?text=" . urlencode($msg);
            ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                <div class="card mini-product-card border-0 h-100 position-relative overflow-hidden shadow-sm"
                     data-aos="fade-up" data-aos-duration="600">

                    <!-- Product Image -->
                    <div class="position-relative overflow-hidden rounded-top">
                        <div class="img-container">
                            <img src="<?php echo !empty($product['image']) ? 'uploads/products/' . htmlspecialchars($product['image']) : 'images/default-product.jpg'; ?>" 
                                 class="card-img-top img-fluid product-img" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>

                        <!-- Overlay -->
                        <div class="overlay d-flex flex-column justify-content-between">
                            <a href="singleProduct.php?id=<?php echo $product['id']; ?>" 
                               class="search-icon btn btn-light btn-sm rounded-circle text-dark">
                                <i class="fas fa-search"></i>
                            </a>
                            <a href="<?php echo $waLink; ?>" target="_blank" 
                               class="btn btn-success btn-sm text-white order-btn w-100">
                               Order Now
                            </a>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body text-start p-2">
                        <p class="mb-1 text-truncate fw-semibold"><?php echo htmlspecialchars($product['name']); ?></p>
                        <p class="fw-bold mb-0 text-dark">From € <?php echo number_format($product['price'],2); ?></p>
                    </div>
                </div>
            </div>
            <?php 
                endwhile; 
            else: 
            ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">No products found in this category.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>





 
       


<?php include("_subfooter.php"); ?>
<?php include("_footer.php"); ?>
