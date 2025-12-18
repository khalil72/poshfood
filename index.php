<?php 
include("_head.php");
include("_topbar.php");
include("navbar.php");
include("includes/db.php");


$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'en';
$_SESSION['lang'] = $lang;

$langFile = "lang/$lang.php";
if (!file_exists($langFile)) { $langFile = "lang/en.php"; }
$trans = include $langFile;

// -------------------- Helper: Translate Product Text via Google API --------------------
function translateText($text, $target = 'en') {
    $text = urlencode($text);
    $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=$target&dt=t&q=$text";
    $response = file_get_contents($url);
    $result = json_decode($response, true);
    return $result[0][0][0] ?? $text;
}


// Get all categories
$categoriesQuery = "SELECT id, name FROM categories ORDER BY name ASC";
$categoriesResult = mysqli_query($conn, $categoriesQuery);
$categories = [];
while ($cat = mysqli_fetch_assoc($categoriesResult)) {
    $categories[] = $cat;
}

// Get all products with category info
$productsQuery = "SELECT p.*, c.name AS category_name, c.id AS category_id 
                  FROM products p 
                  JOIN categories c ON c.id = p.category_id 
                  ORDER BY c.name ASC, p.name ASC";
$productsResult = mysqli_query($conn, $productsQuery);
$allProducts = [];
while ($prod = mysqli_fetch_assoc($productsResult)) {
    $allProducts[] = $prod;
}

// Group products by category
$productsByCategory = [];
foreach ($allProducts as $product) {
    $catId = $product['category_id'];
    if (!isset($productsByCategory[$catId])) {
        $productsByCategory[$catId] = [
            'category_name' => $product['category_name'],
            'products' => []
        ];
    }
    $productsByCategory[$catId]['products'][] = $product;
}

define('WHATSAPP_NUMBER', preg_replace('/\D/', '', '+92 303 6580158')); 
?>
<div id="google_translate_element" style="display:none;"></div>

<section class="home-slider owl-carousel img">
    <div class="slider-item">
        <div class="ftco-animate">
            <img src="images/Calibite_banner1.png" class="img-fluid" alt="">
        </div>
    </div>
    <div class="slider-item">
        <div class="ftco-animate">
            <img src="images/Calibite_banners2.png" class="img-fluid" alt="">
        </div>
    </div>
    <div class="slider-item">
        <div class="ftco-animate">
            <img src="images/Calibite_banners3.png" class="img-fluid" alt="">
        </div>
    </div>
</section>

<!-- About Section -->
<section class="ftco-about d-flex align-items-center min-vh-100 mt-5 mb-5">
  <div class="container">
    <div class="row align-items-center">

      <!-- Image Column -->
      <div class="col-md-6">
         <img src="images/mockup1b.png" alt="Healthy Meals" class="about-img img-fluid"/>
      </div>

      <!-- Content Column -->
      <div class="col-md-6 text-left">
        <div class="heading-section">
          <h2 class="mb-4">Chef-Prepared Healthy Meals Delivered Fresh Every Week</h2>
        </div>
        <p class="mb-4">
          Fresh, chef-made meals crafted to support your personal health goals.
          Our healthy meal prep is delivered weekly and designed for weight loss,
          muscle gain, or simply eating better. Every dish is cooked fresh using
          balanced, nutritious ingredients and stays delicious all week.
        </p>
        <a href="#menu" class="btn btn-primary py-3 px-4">See the Menu</a>
      </div>

    </div>
  </div>
</section>

<!-- How It Works -->
<section class="ftco-section bg-primary mt-5 mb-5">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-8 text-center">
        <h2 class="mb-3 text-white">How It Works</h2>
        <p class="text-white-50">Getting healthy meals is simple, fast, and hassle-free.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="work-step text-center">
          <span class="step-number">01</span>
          <div class="step-icon">🥗</div>
          <h4>Pick Your Meals</h4>
          <p>Choose from our weekly chef-designed menu tailored to your goals.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="work-step text-center">
          <span class="step-number">02</span>
          <div class="step-icon">👨‍🍳</div>
          <h4>Fresh Cooking</h4>
          <p>Our chefs cook your meals fresh using premium, balanced ingredients.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="work-step text-center">
          <span class="step-number">03</span>
          <div class="step-icon">🚚</div>
          <h4>Doorstep Delivery</h4>
          <p>Receive fresh meals weekly, ready to heat and enjoy anytime.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Products / Menu -->
<section class="ftco-menu py-5 " id="menu">
  <div class="container">

    <!-- Section Heading -->
    <div class="row justify-content-center mb-5">
      <div class="col-md-8 text-center animate-fade-in">
        <h2 class="fw-bold mb-3">Explore Our Menu</h2>
        <p class="text-muted">
          Freshly prepared meals made with care.  
          Order instantly via WhatsApp — fast & easy.
        </p>
      </div>
    </div>

    <div class="row d-md-flex">
      <div class="col-lg-4 d-none d-lg-block mb-4">
        <div class="rounded-4 shadow-lg h-100 overflow-hidden position-relative hover-zoom"
             style="background:url('images/about.jpg') center/cover; min-height:450px;">
             <div class="image-overlay-text">
                 <h4 class="text-white fw-bold">Fresh & Healthy</h4>
             </div>
        </div>
      </div>

      <div class="col-lg-8">
        <!-- Tabs -->
        <div class="text-center mb-5">
          <div class="nav nav-pills justify-content-center custom-pills" role="tablist">
            <a class="nav-link active" data-bs-toggle="pill" href="#all-products"><i class="fa fa-border-all me-1"></i> All</a>
            <?php foreach ($categories as $category): ?>
              <a class="nav-link" data-bs-toggle="pill" href="#cat-<?php echo $category['id']; ?>">
                <?php echo htmlspecialchars($category['name']); ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="tab-content">
          <!-- All Products -->
          <div class="tab-pane fade show active" id="all-products">
            <div class="row g-4 justify-content-center">
              <?php foreach (array_slice($allProducts, 0, 3) as $product): 
                $msg = "Hello 👋 I want to order:\n\n";
                $msg .= "*Product:* {$product['name']}\n";
                $msg .= "*Price:* Rs " . number_format($product['price']) . "\n";
                $msg .= "*Details:* {$product['description']}\n";
                $msg .= "*Link:* " . "https://limo.idealdollarshop.com/product.php?id={$product['id']}";
                $waLink = "https://wa.me/" . WHATSAPP_NUMBER . "?text=" . urlencode($msg);
              ?>
              <div class="col-sm-6 col-md-4 product-item">
                <div class="card product-card border-0 shadow-sm h-100">
                  <div class="position-relative overflow-hidden rounded-top-4">
                    <img src="<?php echo !empty($product['image']) ? 'uploads/products/' . htmlspecialchars($product['image']) : 'images/default-product.jpg'; ?>" 
                         class="card-img-top product-img" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="price-tag">Rs <?php echo number_format($product['price']); ?></div>
                  </div>
                  <div class="card-body text-center p-3">
                    <h6 class="fw-bold mb-2"><?php echo htmlspecialchars($product['name']); ?></h6>
                    <a href="<?php echo $waLink; ?>" target="_blank" 
                       class="btn btn-whatsapp w-100 rounded-pill order-btn"
                       data-product-name="<?php echo htmlspecialchars($product['name']); ?>">
                      <i class="fab fa-whatsapp me-2"></i> Order Now
                    </a>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
              <div class="col-12 text-center mt-4">
                <a href="all_products.php" class="btn btn-outline-dark px-5 py-2 rounded-pill fw-bold hover-lift">
                  View Full Menu <i class="fa fa-arrow-right ms-2"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Category Products -->
          <?php foreach ($categories as $category): ?>
          <div class="tab-pane fade" id="cat-<?php echo $category['id']; ?>">
            <div class="row g-4 justify-content-center">
              <?php 
                $catProducts = $productsByCategory[$category['id']]['products'] ?? [];
                if ($catProducts):
                  foreach (array_slice($catProducts, 0, 6) as $product):
                    $msg = "Hello 👋 I want to order:\n\n";
                    $msg .= "*Product:* {$product['name']}\n";
                    $msg .= "*Price:* Rs " . number_format($product['price']) . "\n";
                    $msg .= "*Details:* {$product['description']}\n";
                    $msg .= "*Link:* " . "https://limo.idealdollarshop.com/singleProduct.php?id={$product['id']}";
                    $waLink = "https://wa.me/" . WHATSAPP_NUMBER . "?text=" . urlencode($msg);
              ?>
              <div class="col-sm-6 col-md-4 product-item">
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
                    <a href="<?php echo $waLink; ?>" target="_blank" 
                       class="btn btn-whatsapp w-100 rounded-pill order-btn"
                       data-product-name="<?php echo htmlspecialchars($product['name']); ?>">
                      <i class="fab fa-whatsapp me-2"></i> Order Now
                    </a>
                  </div>
                </div>
              </div>
              <?php endforeach; else: ?>
              <div class="col-12 text-center py-5">
                <i class="fa fa-box-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">No products found in this category.</p>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section class="faq-section py-5 bg-light">
  <div class="container ftco-animate">
    <div class="row">
      <div class="col-md-4 mb-4 mb-md-0 text-center text-md-start">
        <h2 class="fw-bold mb-3 faq-heading">
          Have Questions?<br>
          <span class="text-success">We Have Answers</span>
        </h2>
        <p class="text-muted">
          Find quick answers about our services, delivery, and subscription plans to get started with confidence.
        </p>
        <a href="#how-it-works" class="btn btn-dark rounded mt-2">How It Works</a>
      </div>
      <div class="col-md-8">
        <div class="accordion" id="faqAccordion">
          <?php 
          $faqs = [
            "How do I place an order?" => "Simply browse our menu, choose your meals, and add them to your cart. You can place a one-time order or subscribe weekly.",
            "What areas do you deliver to?" => "We currently deliver to all major cities across the country. Enter your address at checkout to confirm availability.",
            "How fresh are your meals?" => "All meals are prepared fresh and delivered immediately. You can keep them refrigerated for up to 5 days.",
            "Can I customize my subscription plan?" => "Yes! You can mix and match meals, choose delivery days, and pause or cancel your subscription anytime.",
            "Are there any hidden fees?" => "No hidden fees. All prices are transparent and clearly displayed at checkout, including delivery charges."
          ];
          $i = 1;
          foreach ($faqs as $q => $a): ?>
          <div class="accordion-item border-0 mb-3 shadow-sm rounded">
            <h2 class="accordion-header" id="heading<?php echo $i; ?>">
              <button class="accordion-button faq-btn btn <?php echo $i!==1 ? 'collapsed':''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i; ?>" aria-expanded="<?php echo $i===1 ? 'true':'false'; ?>" aria-controls="collapse<?php echo $i; ?>">
                <?php echo $q; ?>
              </button>
            </h2>
            <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse <?php echo $i===1 ? 'show':''; ?>" aria-labelledby="heading<?php echo $i; ?>" data-bs-parent="#faqAccordion">
              <div class="accordion-body p-2"><?php echo $a; ?></div>
            </div>
          </div>
          <?php $i++; endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include("_subfooter.php") ?>

<?php include("_footer.php"); ?>
<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Product hover animation
  document.querySelectorAll('.product-item').forEach(item => {
    item.addEventListener('mouseenter', () => {
      item.style.transform = 'translateY(-10px)';
      item.style.transition = 'all 0.3s ease';
      item.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
    });
    item.addEventListener('mouseleave', () => {
      item.style.transform = 'translateY(0)';
      item.style.boxShadow = 'none';
    });
  });

  // Order Now button - show toast
  document.querySelectorAll('.order-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const productName = btn.getAttribute('data-product-name');
      showToast(productName + ' added to cart!');
    });
  });

  // Toast notification
  function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.innerHTML = `<div class="toast-content"><i class="fa fa-check-circle me-2"></i>${message}</div>`;
    document.body.appendChild(toast);
    setTimeout(() => { toast.classList.add('show'); }, 100);
    setTimeout(() => { toast.classList.remove('show'); setTimeout(()=>document.body.removeChild(toast),300); }, 3000);
  }
});
</script>


