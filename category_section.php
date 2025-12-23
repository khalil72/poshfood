<secttion class="my-4 mt-5 ftco-section" data-aos="fade-up" data-aos-duration="800">
   <div class="container">
       
<h3 class="text-success mb-0  text-center mb-3">
             <i>Change Category</i>
          </h3>

<div class="row g-4 justify-content-center" data-aos="fade-right" data-aos-duration="800">
 
  <!-- All Meals First -->
  <div class="col-6 col-sm-4 col-md-3 col-lg-1-5">
    <a href="all_meals.php" class="text-decoration-none">
      <div class="card product-card border-0 shadow-sm h-100 text-center">
        <div class="overflow-hidden rounded-top">
          <img src="images/Cauliflower.jpg" class="card-img-top img-fluid" alt="All Meals" style="height:150px; object-fit:cover;">
        </div>
        <div class="card-body p-2">
          <h6 class="fw-bold mb-0 text-dark">All Meals</h6>
        </div>
      </div>
    </a>
  </div>

  <?php
  include("includes/db.php");

  $sql = "SELECT id, name, image FROM categories ORDER BY id DESC";
  $result = mysqli_query($conn, $sql);
  if ($result && mysqli_num_rows($result) > 0):
      while ($category = mysqli_fetch_assoc($result)):
  ?>
  <div class="col-6 col-sm-4 col-md-3 col-lg-1-5 mb-3">
    <a href="category_products.php?id=<?php echo $category['id']; ?>" class="text-decoration-none">
      <div class="card product-card border-0 shadow-sm h-100 text-center">
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
