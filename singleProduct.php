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
            <h2 class="fw-bold mb-3"><?php echo htmlspecialchars($product['name']); ?></h2>
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
                       class="btn btn-whatsapp  rounded-pill order-btn"
                       data-product-name="<?php echo htmlspecialchars($product['name']); ?>">
                      <i class="fab fa-whatsapp me-2"></i> Order Now
                    </a>
        </div>
    </div>

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
            <div class="col-sm-6 col-md-4 product-item">
                <div class="card product-card border-0 shadow-sm h-100">
                    <a href="product.php?id=<?php echo $rel['id']; ?>" class="overflow-hidden">
                        <img src="<?php echo !empty($rel['image']) ? 'uploads/products/' . htmlspecialchars($rel['image']) : 'images/default-product.jpg'; ?>" 
                             class="card-img-top product-img img-fluid" alt="<?php echo htmlspecialchars($rel['name']); ?>">
                    </a>
                    <div class="card-body text-center p-3">
                        <h6 class="fw-bold mb-2"><?php echo htmlspecialchars($rel['name']); ?></h6>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="product.php?id=<?php echo $rel['id']; ?>" class="btn btn-outline-dark btn-sm flex-grow-1">
                                <i class="fa fa-eye me-1"></i> View
                            </a>
                            <a href="<?php echo $waLinkRel; ?>" target="_blank" 
                               class="btn btn-success btn-sm flex-grow-1">
                               <i class="fab fa-whatsapp me-1"></i> Order
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>



<?php include("_footer.php"); ?>
