<?php
include("_head.php");
include("_topbar.php");
include("navbar.php");
include("includes/db.php");

define('WHATSAPP_NUMBER', preg_replace('/\D/', '', '+92 303 6580158'));


$limit = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

$countRes = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$totalRow = mysqli_fetch_assoc($countRes);
$totalProducts = $totalRow['total'];
$totalPages = ceil($totalProducts / $limit);

// products
$productsQuery = "
  SELECT p.*, c.name AS category_name
  FROM products p
  JOIN categories c ON c.id = p.category_id
  ORDER BY p.name ASC
  LIMIT $limit OFFSET $offset
";
$productsResult = mysqli_query($conn, $productsQuery);

// categories
$categoriesRes = mysqli_query($conn, "SELECT id, name FROM categories ORDER BY name ASC");
$categories = [];
while ($cat = mysqli_fetch_assoc($categoriesRes)) {
  $categories[] = $cat;
}
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
  <h2 class="fw-bold mb-2">All Meals</h2>
  <p class="text-sm mx-3">
    Explore our full selection of fresh, chef-prepared meals, from protein-packed bowls to plant-based options. Use the filters to find meals that fit your goals, or pick a category below to get started quickly.
  </p>
</div>
  </div>

  <div class="col-md-6 p-0">
    <img 
      src="images/gallery-1.jpg" 
      class="img-fluid rounded-end shadow" 
      alt="All Meals" 
      style="width: 100%; height: 250px; object-fit: cover;"
    >
  </div>
</div>
</div>
</section>
<div class="container my-5" data-aos="fade-up" data-aos-duration="800">
  <div class="row">

    <!-- DESKTOP CATEGORIES -->
    <div class="col-lg-3 d-none d-lg-block">
      <h5 class="fw-bold mb-3">Categories</h5>
      <div class="list-group category-links">
        <a href="#" class="list-group-item active" data-category="">All</a>
        <?php foreach ($categories as $cat): ?>
          <a href="#" class="list-group-item" data-category="<?= $cat['id']; ?>">
            <?= htmlspecialchars($cat['name']); ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- PRODUCTS -->
    <div class="col-lg-9">

      <!-- MOBILE CATEGORIES -->
     <!-- MOBILE CATEGORY TOGGLE -->
<div class="d-lg-none mb-3">

  <!-- Toggle Button -->
  <button class="btn btn-success text-white w-100 d-flex justify-content-between align-items-center"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#mobileCategories"
          aria-expanded="false">

    <span>Categories</span>
    <i class="fas fa-chevron-down"></i>
  </button>

  <!-- Collapsible Categories -->
  <div class="collapse mt-2" id="mobileCategories">
    <div class=" gap-2 category-scroll">

       <div class="list-group category-links">
        <a href="#" class="list-group-item active" data-category="">All</a>
        <?php foreach ($categories as $cat): ?>
          <a href="#" class="list-group-item" data-category="<?= $cat['id']; ?>">
            <?= htmlspecialchars($cat['name']); ?>
          </a>
        <?php endforeach; ?>
      </div>

    </div>
  </div>

</div>


      <!-- SEARCH -->
      <input type="text" id="searchInput" class="form-control mb-4"
             placeholder="Search products...">

      <!-- GRID -->
      <div class="row g-4" id="productsGrid">

        <?php while ($product = mysqli_fetch_assoc($productsResult)):
          $msg  = "Hello 👋 I want to order:\n\n";
          $msg .= "*Product:* {$product['name']}\n";
          $msg .= "*Price:* Rs " . number_format($product['price']) . "\n";
          $msg .= "*Details:* {$product['description']}\n";
          $msg .= "*Link:* https://limo.idealdollarshop.com/singleProduct.php?id={$product['id']}";
          $waLink = "https://wa.me/" . WHATSAPP_NUMBER . "?text=" . urlencode($msg);
        ?>

        <div class="col-6 col-sm-4 col-md-4 col-lg-3 product-item"
             data-category="<?= $product['category_id']; ?>">

          <div class="card mini-product-card border-0 h-100 shadow-sm">

            <div class="img-container position-relative">
              <img src="<?= !empty($product['image'])
                    ? 'uploads/products/'.$product['image']
                    : 'images/default-product.jpg'; ?>"
                   class="img-fluid product-img"
                   alt="<?= htmlspecialchars($product['name']); ?>">

              <!-- OVERLAY -->
              <div class="overlay">
                <a href="singleProduct.php?id=<?= $product['id']; ?>"
                class="search-icon btn btn-light btn-sm rounded-circle text-dark">
                  <i class="fas fa-search"></i>
                </a>

                <a href="<?= $waLink; ?>" target="_blank"
                   class="btn btn-success btn-sm text-white order-btn w-100">
                  Order Now
                </a>
              </div>
            </div>

            <div class="card-body p-2 text-start">
              <p class="product-name fw-semibold mb-1 text-truncate">
                <?= htmlspecialchars($product['name']); ?>
              </p>
              <p class="fw-bold text-dark mb-0">From € <?= number_format($product['price']); ?></p>
            </div>

          </div>
        </div>

        <?php endwhile; ?>

        <div id="noProducts" class="col-12 text-center d-none">
          <h5 class="py-5">No products found</h5>
        </div>

      </div>

      <!-- PAGINATION -->
      <?php if ($totalPages > 1): ?>
      <nav class="mt-5">
        <ul class="pagination justify-content-center">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
              <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
      <?php endif; ?>

    </div>
  </div>
</div>

<section 
  class="ftco-section d-flex align-items-center whatsapp-banner"
  style="background-image: url('images/bg_2.jpg');"
  
  data-aos="fade-up" data-aos-duration="800"
>
  <div class="overlay"></div>

  <div class="container position-relative text-center">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">

        <h2 class="text-white fw-bold mb-3">
          Not sure what to get?
        </h2>

        <p class="text-white mb-4">
          Get in touch through our contact page or tap the button below to chat with us on WhatsApp!
        </p>

        <a 
          href="https://wa.me/923036580158" 
          target="_blank" 
          class="btn btn-success text-white btn-lg px-4"
        >
          Chat on WhatsApp
        </a>

      </div>
    </div>
  </div>
</section>


<?php include("_subfooter.php") ?>
<?php include("_footer.php"); ?>



<script>
document.querySelectorAll('#mobileCategories [data-category]').forEach(btn => {
  btn.addEventListener('click', () => {
    const collapse = bootstrap.Collapse.getOrCreateInstance(
      document.getElementById('mobileCategories')
    );
    collapse.hide();
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const search = document.getElementById('searchInput');
  const items = document.querySelectorAll('.product-item');
  const buttons = document.querySelectorAll('[data-category]');
  const empty = document.getElementById('noProducts');
  let activeCategory = '';

  function filter() {
    let visible = 0;
    const text = search.value.toLowerCase();

    items.forEach(item => {
      const name = item.querySelector('.product-name').innerText.toLowerCase();
      const cat = item.dataset.category;

      if (
        name.includes(text) &&
        (activeCategory === '' || cat === activeCategory)
      ) {
        item.style.display = '';
        visible++;
      } else {
        item.style.display = 'none';
      }
    });

    empty.classList.toggle('d-none', visible !== 0);
  }

  search.addEventListener('input', filter);

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      buttons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeCategory = btn.dataset.category || '';
      filter();
    });
  });
});
</script>
