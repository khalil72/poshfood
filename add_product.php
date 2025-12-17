<?php
include("admin/_head.php");
include("includes/db.php");
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $price       = (float)($_POST['price'] ?? 0);
    $imageName   = null;

    if ($name === '' || $category_id <= 0) {
        $error = "Name and category are required.";
    } else {
        // Create uploads/products directory if it doesn't exist
        if (!is_dir(__DIR__ . "/uploads/products/")) {
            mkdir(__DIR__ . "/uploads/products/", 0777, true);
        }

        if (!empty($_FILES['image']['name'])) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageName = time() . '_' . rand(1000,9999) . '.' . strtolower($ext);
            $uploadPath = __DIR__ . "/uploads/products/" . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $error = "Failed to upload image.";
            }
        }

        if ($error === "") {
            // Insert product with description
            $stmt = $conn->prepare("INSERT INTO products (category_id, name, description, price, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issds", $category_id, $name, $description, $price, $imageName);
            if ($stmt->execute()) {
                header("Location: product.php?msg=" . urlencode("Product added successfully"));
                exit;
            } else {
                $error = "Error adding product: " . $conn->error;
            }
        }
    }
}

$cats = mysqli_query($conn, "SELECT id, name FROM categories ORDER BY name ASC");
?>
<div class="container-fluid ">
  <div class="row">
    <?php include("admin/_sidebar.php"); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
      <?php include("admin/_topheader.php"); ?>

  <div class="col-12">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-white border-0 pb-0">
      <h4 class="fw-bold mb-0">
        <i class="fa fa-box-open me-2 text-primary"></i> Add Product
      </h4>
      <p class="text-muted mb-0">Create a new product and assign it to a category</p>
    </div>

    <div class="card-body pt-4">

      <?php if ($error): ?>
        <div class="alert alert-danger d-flex align-items-center">
          <i class="fa fa-circle-exclamation me-2"></i>
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data" class="row grow-4 animate-slide-up ">

        <!-- Product Name -->
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Product Name</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa fa-tag"></i></span>
            <input type="text"
                   name="name"
                   class="form-control"
                   placeholder="Enter product name"
                   value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                   required>
          </div>
        </div>

       
      <div class="col-md-6 mb-3">
  <label class="form-label fw-semibold">Category</label>

  <div class="input-group custom-select-wrapper">
    <span class="input-group-text bg-white">
      <i class="fa fa-tags text-primary"></i>
    </span>

    <select name="category_id" class="form-select custom-select" required>
      <option value="">Select Category</option>
      <?php while ($c = mysqli_fetch_assoc($cats)): ?>
        <option value="<?php echo $c['id']; ?>"
          <?php echo (($_POST['category_id'] ?? '') == $c['id']) ? 'selected' : ''; ?>>
          <?php echo htmlspecialchars($c['name']); ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>
</div>


        <!-- Price -->
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Price</label>
          <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="number"
                   step="0.01"
                   name="price"
                   class="form-control"
                   placeholder="0.00"
                   value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>"
                   required>
          </div>
        </div>

     
        <div class="col-md-6">
          <label class="form-label fw-semibold">Product Image</label>
          <input type="file"
                 name="image"
                 class="form-control"
                 accept="image/*"
                 required
                 >
          <small class="text-muted">PNG, JPG, JPEG allowed</small>
        </div>
<div class="col-12">
                <label class="form-label fw-semibold">
                  <i class="fa fa-align-left me-2 mr-2 text-primary"></i>Product Description
                </label>
                <div class="position-relative">
                  <textarea name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Enter detailed product description (features, specifications, benefits, etc.)"
                            style="resize: vertical;"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                </div>
                <small class="text-muted d-flex align-items-center mt-2">
                  <i class="fa fa-info-circle me-1"></i>
                  Provide detailed information about the product to help customers make informed decisions
                </small>
              </div>
        <!-- Buttons -->
        <div class="col-12 d-flex justify-content-end gap-2 mt-4">
        
          <button type="submit" class="btn btn-primary px-4">
            <i class="fa fa-save me-2 mr-2"></i> Save Product
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

    </main>
  </div>
</div>