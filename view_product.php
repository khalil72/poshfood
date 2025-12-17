<?php
include("admin/_head.php");
include("includes/db.php");
session_start();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: product.php?msg=" . urlencode("Invalid product"));
    exit;
}

$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        JOIN categories c ON c.id = p.category_id 
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    header("Location: product.php?msg=" . urlencode("Product not found"));
    exit;
}
?>
<div class="container-fluid">
  <div class="row">
    <?php include("admin/_sidebar.php"); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
      <?php include("admin/_topheader.php"); ?>

      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="fw-bold mb-0">
              <i class="fa fa-eye me-2 text-primary"></i> Product Details
            </h4>
            <p class="text-muted mb-0 small">View complete product information</p>
          </div>
          <a href="product.php" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-2"></i> Back to Products
          </a>
        </div>

        <div class="card shadow-lg border-0 rounded-4 animate-slide-up ">
          <div class="card-body p-4">
            <div class="row g-4">
              
              <!-- Product Image -->
              <div class="col-md-5">
                <div class="position-relative">
                  <?php if (!empty($product['image'])): ?>
                    <img src="uploads/products/<?php echo htmlspecialchars($product['image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>" 
                         class="img-fluid rounded-3 shadow-sm"
                         style="width:100%;max-height:300px;object-fit:fill;">
                  <?php else: ?>
                    <div class="bg-light d-flex flex-column align-items-center justify-content-center rounded-3 shadow-sm" 
                         style="height:400px;border:2px dashed #dee2e6;">
                      <i class="fa fa-image fa-4x text-muted mb-3"></i>
                      <span class="text-muted">No image available</span>
                    </div>
                  <?php endif; ?>
                </div>
                 <div class="mt-3">
                    <div class="row g-3 mb-4">
                      <div class="col-6">
                        <div class="p-3 bg-light rounded-3">
                          <label class="text-muted small fw-semibold mb-1 d-block">Product ID</label>
                          <span class="fw-bold">#<?php echo $product['id']; ?></span>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="p-3 bg-light rounded-3">
                          <label class="text-muted small fw-semibold mb-1 d-block">Created At</label>
                          <span class="fw-bold">
                            <?php echo !empty($product['created_at']) ? date('M d, Y', strtotime($product['created_at'])) : 'N/A'; ?>
                          </span>
                        </div>
                      </div>
                    </div>

                  
                  </div>
              </div>

              <!-- Product Information -->
              <div class="col-md-7">
                <div class="d-flex flex-column h-100">
                  
                  <!-- Product Name -->
                  <div class="mb-4">
                    <h3 class="fw-bold text-dark mb-2">
                      <i class="fa fa-tag text-primary me-2 mr-1"></i>
                      <?php echo htmlspecialchars($product['name']); ?>
                    </h3>
                    <div class="badge bg-primary text-white  px-3 py-2">
                      <i class="fa fa-tags me-1 mr-1"></i>
                      <?php echo htmlspecialchars($product['category_name']); ?>
                    </div>
                  </div>

                  <!-- Price -->
                  <div class="mb-4 p-3 bg-light rounded-3">
                    <label class="text-muted small fw-semibold mb-1">Price</label>
                    <h2 class="fw-bold text-primary mb-0 mr-1">
                      ₹ <?php echo number_format($product['price'], 2); ?>
                    </h2>
                  </div>

                  <!-- Description -->
                  <div class="mb-4">
                    <label class="form-label fw-semibold mb-2">
                      <i class="fa fa-align-left text-primary me-2 mr-1"></i>Description
                    </label>
                    <div class="p-3 bg-light rounded-3" >
                      <?php if (!empty($product['description'])): ?>
                        <p class="mb-0 text-dark" >
                          <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                        </p>
                      <?php else: ?>
                        <p class="text-muted mb-0 fst-italic">No description available</p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <!-- Additional Info -->
                 

                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</div>

