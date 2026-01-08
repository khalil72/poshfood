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
<section class="about-section d-flex align-items-center mt-0 mt-md-5 " data-aos="fade-up" data-aos-duration="800"
style="background-image: url('images/transparent-image-6.png');"
>
  <div class="container">
    <div class="row align-items-start">

      
   <div class="col-md-6 d-flex justify-content-center">
  <div class="about-image-overlap">
    <img src="images/rotate-image-2.jpg"  class="img img-front" alt="Healthy Meal">
    <img src="images/rotate-image-1.jpg" class="img img-back" alt="Meal Prep">
  </div>
</div>


     
      <div class="col-md-6 text-left">
        <div class="sec-title mb-4" style="background-image: url('images/line-two.png');">
          <h2 class="text-success mb-0 ">
             <i>About Us</i>
          </h2>
          <h1 class="mb-0">
           WE ARE TASTY
          </h1>
        </div >

        <div class="mb-3">
            <p>
  Fresh, chef-made meals crafted to support
  your personal health goals. Each dish is made
  with locally sourced ingredients,
  ensuring maximum flavor and nutrition.
</p>
<p>
  Our healthy meal prep is delivered weekly
  and designed for weight loss, muscle gain,
  or simply eating better. With flexible plans
  and customizable options, healthy eating has never been easier.
</p>
        </div>
 



<a href="all_products.php" class="theme-btn uppercase" data-aos="fade-right" data-aos-duration="800">
  See The Menu
  <i class="icon fa fa-angle-right"></i>
</a>

        
      </div>

    </div>
  </div>
</section>


<!-- How It Works -->
<section class="ftco-section banner-bg " data-aos="fade-up" data-aos-duration="800">
  <div class="container">
    <div class="row justify-content-center mb-5 ">
    <div class="col-md-8 text-center">
  <span class="text-white">Getting healthy meals is simple, fast, and hassle-free.</span>
  <h2 class="text-white font-bold mb-0">How It Works</h2>
  <a href="/how-it-works.php" class="animated-link underline" data-aos="fade-up" data-aos-duration="800">
    Learn More <i class="icon fa fa-angle-right mx-2"></i>
  </a>
</div>


    </div>
    <div class="row" data-aos="fade-right" data-aos-duration="800">
      <div class="col-md-4 mb-4">
        <div class="work-step text-center">
          <span class="step-number">01</span>
        
            <img src="icons/checklist.avif" class="img mb-3"/>
        
         <h4 class="mb-0 text-success ">Pick Your Meals</h4>
<p>
  Choose from our weekly chef-designed menu tailored to your goals
</p>




        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="work-step text-center">
          <span class="step-number">02</span>
          
              <img src="icons/lunch-box.avif" class="mb-3"/>
          
    <h4 class="mb-0 text-success ">
      Fresh Cooking
    </h4>
<p>
  Our chefs cook your meals fresh using premium ingredients.
</p>

        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="work-step text-center">
          <span class="step-number">03</span>
         
             <img src="icons/delivery-man.avif" class="img mb-3" />
         
         <h4 class="mb-0 text-success ">Doorstep Delivery</h4>
<p>
  Receive fresh meals weekly, ready to heat and enjoy
</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-menu py-5" id="menu" data-aos="fade-up" data-aos-duration="800">
  <div class="container">

    <!-- Section Header -->
    <div class="row justify-content-center mb-4">
      <div class="col-md-8 text-center animate-fade-in">
        <h4 class="text-success mb-0">
          <i>Something For Every Taste And Goal</i>
        </h4>
        <p class="text-muted">
          Whether you’re building muscle, trimming down, or just want tasty meals without the hassle, every dish is fresh, packed with care, and ready to heat in minutes.
        </p>
      </div>
    </div>

    <div class="row g-4 justify-content-center" data-aos="fade-right" data-aos-duration="800">
      <?php
      $sql = "SELECT id, name, image FROM categories ORDER BY id DESC LIMIT 6";
      $result = mysqli_query($conn, $sql);
      if ($result && mysqli_num_rows($result) > 0):
        while ($category = mysqli_fetch_assoc($result)):
      ?>
      <div class="col-sm-6 col-md-4 col-lg-2">
        <a href="category_products.php?id=<?php echo $category['id']; ?>" class="text-decoration-none">
          <div class="card product-card border-0  shadow-sm h-100 text-center border-0">
            <div class="overflow-hidden rounded-top">
              <img src="<?php 
                echo !empty($category['image']) ? 'uploads/categories/' . $category['image'] : 'images/default-category.jpg';
              ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($category['name']); ?>" style="height:150px; object-fit:cover;">
            </div>
            <div class="card-body p-2">
              <h6 class="fw-bold mb-0 text-dark"><?php echo htmlspecialchars($category['name']); ?></h6>
            </div>
          </div>
        </a>
      </div>
      <?php
        endwhile;
      else:
      ?>
      <div class="col-12 text-center">
        <p class="text-muted">No categories found.</p>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Certifications Section -->


 <!-- logo section -->

<!-- Products / Menu -->
<!-- <section class="ftco-menu py-5 " id="menu" data-aos="fade-up" data-aos-duration="800">
  <div class="container">
    
    <div class="row justify-content-center mb-5">
      <div class="col-md-8 text-center animate-fade-in">
        <h2 class="fw-bold mb-3"><?php echo $trans['explore_menu']; ?></h2>
        <p class="text-muted">
        <?php echo $trans['menu_desc']; ?>
        </p>
      </div>
    </div>

    <div class="row d-md-flex">
      <div class="col-lg-4 d-none d-lg-block mb-4">
        <div class="rounded-4 shadow-lg h-100 overflow-hidden position-relative hover-zoom"
             style="background:url('images/about.jpg') center/cover; min-height:450px;">
             <div class="image-overlay-text">
              
             </div>
        </div>
      </div>

      <div class="col-lg-8">
       
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
                    <div class="price-tag">€ <?php echo number_format($product['price']); ?></div>
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
                   <?php echo $trans['view_full_menu']; ?> <i class="fa fa-arrow-right ms-2"></i>
                </a>
              </div>
            </div>
          </div>

         
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
                    <div class="price-tag">€ <?php echo number_format($product['price']); ?></div>
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
</section> -->

<!-- /faq section -->
<section class="faq-section py-5 bg-light" data-aos="fade-up" data-aos-duration="800">
  <div class="container ftco-animate">
    <div class="row justify-content-center align-items-center">
      
      <!-- Left Content -->
      <div class="col-md-4 mb-4 text-center text-md-center justify-items-center">
        <h2 class="fw-bold mb-3 faq-heading">
        Have Questions? 
        <br>
          <span class="text-success">
            We Have Answers
          </span>
        </h2>
 <p>
  Everything you need to know about ordering, delivery, and keeping your meals fresh. Quick answers to help you get started with confidence.

 </p>
       <a href="how-it-work.php" class="theme-btn uppercase" data-aos="fade-right" data-aos-duration="800">
How its work
  <i class="icon fa fa-angle-right"></i>
</a>
      </div>

      <div class="col-md-8">
        <div class="accordion" id="faqAccordion">

          <?php foreach ($trans['faqs'] as $i => $faq): ?>
          <div class="accordion-item border-0 mb-3  rounded">
            <h2 class="accordion-header">
              <button class="accordion-header faq-btn btn <?php echo $i !== 0 ? 'collapsed' : ''; ?>"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#faq<?php echo $i; ?>">
                <?php echo $faq['q']; ?>
              </button>
            </h2>

            <div id="faq<?php echo $i; ?>"
                 class="accordion-collapse collapse <?php echo $i === 0 ? 'show' : ''; ?>"
                 data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                <?php echo $faq['a']; ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>

        </div>
      </div>

    </div>
  </div>
</section>







<section class="ftco-menu py-5" id="certifications" data-aos="fade-up" data-aos-duration="800">
  <div class="container">
    <!-- Heading -->
    <div class="row justify-content-center mb-4 text-center">
      <div class="col-md-8 animate-fade-in">
        <h4 class="text-success mb-2"><i>Important Certification</i></h4>
        <p class="text-muted mb-0">
          Whether you’re building muscle, trimming down, or just want tasty meals without the hassle, every dish is fresh, packed with care, and ready to heat in minutes.
        </p>
      </div>
    </div>

    <!-- Slider -->
    <div class="row">
      <div class="col-12">
        <div class="certification-slider">
          <?php
          $certifications = [
              "images/logo1.jpg",
              "images/logo2.jpg",
              "images/logo3.jpg",
              "images/logo4.jpg",
              "images/logo6.jpg",
              "images/logo7.jpg",
          ];
          foreach ($certifications as $cert): ?>
            <div class="cert-slide">
              <img src="<?php echo $cert; ?>" alt="Certification" class="img-fluid rounded shadow-sm" style="max-height:80px; cursor:pointer;">
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>






<?php include("_subfooter.php") ?>

<?php include("_footer.php"); ?>




<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
$(document).ready(function(){
  $('.certification-slider').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    arrows: false,        
    dots: false,
    centerMode: true,
    centerPadding: '20px',
    focusOnSelect: true,  
    responsive: [
      { breakpoint: 1200, settings: { slidesToShow: 3, centerPadding: '15px' } },
      { breakpoint: 768,  settings: { slidesToShow: 1, centerPadding: '0px' } }
    ]
  });
});
</script>

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
<script>
document.addEventListener("DOMContentLoaded", function () {
  const lang = localStorage.getItem("siteLang");
  if (lang) changeLang(lang);
});

function changeLang(lang) {
  localStorage.setItem("siteLang", lang);
  const select = document.querySelector(".goog-te-combo");
  if (select) {
    select.value = lang;
    select.dispatchEvent(new Event("change"));
  }
}
</script>


