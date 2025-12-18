<?php
include("_head.php");
include("_topbar.php");
include("navbar.php");
include("includes/db.php");

define('WHATSAPP_NUMBER', preg_replace('/\D/', '', '+92 303 6580158')); 


$productsQuery = "SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON c.id = p.category_id ORDER BY p.name ASC";
$productsResult = mysqli_query($conn, $productsQuery);
$allProducts = [];
while($row = mysqli_fetch_assoc($productsResult)){
    $allProducts[] = $row;
}

// Fetch categories
$categoriesResult = mysqli_query($conn, "SELECT id, name FROM categories ORDER BY name ASC");
$categories = [];
while ($cat = mysqli_fetch_assoc($categoriesResult)) {
    $categories[] = $cat;
}
?>

<div class="container my-5">
  <div class="row">

  
    <div class="col-lg-3 mb-4">
      <h5 class="fw-bold mb-3">Categories</h5>
      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active" data-category="">All</a>
        <?php foreach ($categories as $cat): ?>
          <a href="#" class="list-group-item list-group-item-action" data-category="<?php echo $cat['id']; ?>">
            <?php echo htmlspecialchars($cat['name']); ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Products Section -->
    <div class="col-lg-9">
      <!-- Search bar -->
      <input type="text" id="searchInput" class="form-control mb-4" placeholder="Search products...">

      <!-- Products Grid -->
      <div class="row g-4" id="productsGrid">
        <?php if($allProducts): ?>
          <?php foreach($allProducts as $product):
            $msg = "Hello 👋 I want to order:\n\n";
            $msg .= "*Product:* {$product['name']}\n";
            $msg .= "*Price:* Rs " . number_format($product['price']) . "\n";
            $msg .= "*Details:* {$product['description']}\n";
            $msg .= "*Link:* " . "https://limo.idealdollarshop.com/singleProduct.php?id={$product['id']}";
            $waLink = "https://wa.me/" . WHATSAPP_NUMBER . "?text=" . urlencode($msg);
          ?>
          <div class="col-sm-6 col-md-4 product-item mb-5" data-category="<?php echo $product['category_id']; ?>">
            <div class="card product-card border-0 shadow-sm h-100">
                  <div class="position-relative overflow-hidden rounded-top-4">

                    <a href="singleProduct.php?id=<?php echo $product['id']; ?>" class="d-block overflow-hidden rounded-top-4">
            <img src="<?php echo !empty($product['image']) ? 'uploads/products/' . htmlspecialchars($product['image']) : 'images/default-product.jpg'; ?>" 
                 class="card-img-top product-img img-fluid" 
                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                 style="transition: transform 0.3s ease;">
        </a>
                    <div class="price-tag">Rs <?php echo number_format($product['price']); ?></div>
                  </div>
                  <div class="card-body text-center p-3">
                    <h6 class="fw-bold mb-2"><?php echo htmlspecialchars($product['name']); ?></h6>
                       <p>
                    <?php 
$words = explode(' ', strip_tags($product['description']));
if(count($words) > 10){
    $shortDesc = implode(' ', array_slice($words, 0, 10)) . '...';
} else {
    $shortDesc = $product['description'];
}
echo htmlspecialchars($shortDesc);
?>
            </p>
                    <a href="<?php echo $waLink; ?>" target="_blank" 
                       class="btn btn-whatsapp w-100 rounded-pill order-btn"
                       data-product-name="<?php echo htmlspecialchars($product['name']); ?>">
                      <i class="fab fa-whatsapp me-2"></i> Order Now
                    </a>
                  </div>
                </div>
            
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12 text-center py-5">
            <h5>No products found.</h5>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include("_footer.php"); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const productsGrid = document.getElementById('productsGrid');
  const categoryLinks = document.querySelectorAll('.list-group-item');

  let selectedCategory = '';

  // Filter products by search and category
  function filterProducts() {
    const searchVal = searchInput.value.toLowerCase();
    document.querySelectorAll('.product-item').forEach(item=>{
      const name = item.querySelector('h6').innerText.toLowerCase();
      const category = item.getAttribute('data-category');
      const matchesSearch = name.includes(searchVal);
      const matchesCategory = selectedCategory === '' || category === selectedCategory;
      item.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
    });
  }

  // Search input
  searchInput.addEventListener('input', filterProducts);

  // Category click
  categoryLinks.forEach(link=>{
    link.addEventListener('click', function(e){
      e.preventDefault();
      categoryLinks.forEach(l=>l.classList.remove('active'));
      this.classList.add('active');
      selectedCategory = this.getAttribute('data-category');
      filterProducts();
    });
  });

  // Hover effect
  document.querySelectorAll('.product-card').forEach(card=>{
    card.addEventListener('mouseenter',()=>{card.style.transform='translateY(-5px)'; card.style.transition='all 0.3s ease'; card.style.boxShadow='0 10px 20px rgba(0,0,0,0.1)';});
    card.addEventListener('mouseleave',()=>{card.style.transform='translateY(0)'; card.style.boxShadow='none';});
  });
});
</script>
