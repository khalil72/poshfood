<?php
include("_head.php");
include("_topbar.php");
include("navbar.php");
include("includes/db.php");

define('WHATSAPP_NUMBER', preg_replace('/\D/', '', '+92 303 6580158'));

// Get product ID from URL
$productId = $_GET['id'] ?? 0;
$productId = intval($productId);

// Fetch product
$productQuery = "SELECT p.*, c.name AS category_name 
                 FROM products p 
                 JOIN categories c ON c.id = p.category_id
                 WHERE p.id = $productId
                 LIMIT 1";
$productResult = mysqli_query($conn, $productQuery);
$product = mysqli_fetch_assoc($productResult);

if (!$product) {
    echo "<div class='container py-5'><h3>Product not found.</h3></div>";
    include("_footer.php");
    exit;
}

// WhatsApp message link
$msg = "Hello 👋 I want to order:\n\n";
$msg .= "*Product:* {$product['name']}\n";
$msg .= "*Price:* Rs " . number_format($product['price']) . "\n";
$msg .= "*Details:* {$product['description']}\n";
$msg .= "*Link:* " . "https://limo.idealdollarshop.com/singleProduct.php?id={$product['id']}";
$waLink = "https://wa.me/" . WHATSAPP_NUMBER . "?text=" . urlencode($msg);

// Fetch related products (same category)
$relatedQuery = "SELECT * FROM products WHERE category_id = {$product['category_id']} AND id != $productId LIMIT 6";
$relatedResult = mysqli_query($conn, $relatedQuery);
$relatedProducts = mysqli_fetch_all($relatedResult, MYSQLI_ASSOC);
?>

<div class="container my-5">
    <div class="row g-5">
        
        <div class="col-md-6">
            <div class="product-img-wrapper position-relative">
                <img src="<?php echo !empty($product['image']) ? 'uploads/products/' . htmlspecialchars($product['image']) : 'images/default-product.jpg'; ?>" 
                     class="img-fluid rounded shadow-sm" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
        </div>

      
        <div class="col-md-6">
            <h2 class="fw-bold  mb-3"><?php echo htmlspecialchars($product['name']); ?></h2>
            <p class="text-muted mb-3"><strong>Category:</strong> <?php echo htmlspecialchars($product['category_name']); ?></p>
            <h4 class="text-primary mb-3">Rs <?php echo number_format($product['price']); ?></h4>
            <p>
                <?php
                $descWords = explode(' ', strip_tags($product['description']));
                if (count($descWords) > 50) {
                    $shortDesc = implode(' ', array_slice($descWords, 0, 50)) . '...';
                    echo htmlspecialchars($shortDesc);
                } else {
                    echo htmlspecialchars($product['description']);
                }
                ?>
            </p>
            
           <a href="<?php echo $waLink; ?>" target="_blank" 
                       class="btn btn-dark text-white  rounded-pill order-btn"
                       data-product-name="<?php echo htmlspecialchars($product['name']); ?>">
                      Order Now
                    </a>
        </div>
    </div>
</div>


<!-- <section class="mb-5 mt-5" style="background-color: #F2F6ED;">
    <?php if ($relatedProducts): ?>
    <div class="mt-5">
        <h3 class="mb-4">Related Products</h3>
        <div class="row g-4">
            <?php foreach ($relatedProducts as $rel): 
                $msgRel = "Hello 👋 I want to order:\n\n";
                $msgRel .= "*Product:* {$rel['name']}\n";
                $msgRel .= "*Price:* Rs " . number_format($rel['price']) . "\n";
                $msgRel .= "*Details:* {$rel['description']}\n";
                $msgRel .= "*Link:* " . "https://limo.idealdollarshop.com/product.php?id={$rel['id']}";
                $waLinkRel = "https://wa.me/" . WHATSAPP_NUMBER . "?text=" . urlencode($msgRel);
            ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                <div class="card mini-product-card border-0 h-100 position-relative overflow-hidden shadow-sm"
                     data-aos="fade-up" data-aos-duration="600">

                   
                    <div class="position-relative overflow-hidden rounded-top">
                        <div class="img-container">
                            <img src="<?php echo !empty($product['image']) ? 'uploads/products/' . htmlspecialchars($product['image']) : 'images/default-product.jpg'; ?>" 
                                 class="card-img-top img-fluid product-img" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>

                       
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

                  
                    <div class="card-body text-start p-2">
                        <p class="mb-1 text-truncate fw-semibold"><?php echo htmlspecialchars($product['name']); ?></p>
                        <p class="fw-bold mb-0 text-dark">From € <?php echo number_format($product['price'],2); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
            </section> -->


<?php include("_subfooter.php") ?>
<?php include("_footer.php"); ?>
