<?php 
include("admin/_head.php");
include("includes/db.php"); // make sure $conn is defined
session_start();

$error = "";
$success = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $imageName = null;

    if ($name === '') {
        $error = "Category name is required.";
    } else {

        /* ===== IMAGE UPLOAD ===== */
        if (!empty($_FILES['image']['name'])) {

            $uploadDir = "uploads/categories/";

            // create folder if not exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowed = ['jpg','jpeg','png','webp'];

            if (!in_array(strtolower($ext), $allowed)) {
                $error = "Only JPG, PNG, WEBP images allowed.";
            } else {

                $imageName = time() . "_" . uniqid() . "." . $ext;
                $imagePath = $uploadDir . $imageName;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    $error = "Image upload failed.";
                }
            }
        }

        /* ===== SAVE TO DATABASE ===== */
        if (!$error) {
            $stmt = $conn->prepare(
                "INSERT INTO categories (name, image) VALUES (?, ?)"
            );
            $stmt->bind_param("ss", $name, $imageName);

            if ($stmt->execute()) {
                header("Location: category.php?msg=Category+added+successfully");
                exit;
            } else {
                $error = "Database error: " . $conn->error;
            }
        }
    }
}

?>

<div class="container-fluid">
  <div class="row">


    <?php include("admin/_sidebar.php"); ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

    
        <?php include("admin/_topheader.php"); ?>

        
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-4">Add Category</h3>

               
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                  <form method="post" action="" enctype="multipart/form-data" class="needs-validation" novalidate>

  <!-- Row 1 -->
  <div class="row g-3 mb-3">

    <!-- Category Name -->
    <div class="col-md-6">
      <label class="form-label fw-semibold">
        Category Name <span class="text-danger">*</span>
      </label>
      <input 
        type="text" 
        name="name" 
        class="form-control"
        placeholder="Enter category name"
        required
        value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
      >
      <div class="invalid-feedback">
        Category name is required
      </div>
    </div>

    <!-- Category Image -->
    <div class="col-md-6">
      <label class="form-label fw-semibold">
        Category Image <span class="text-danger">*</span>
      </label>
      <input 
        type="file"
        name="image"
        class="form-control"
        accept="image/*"
        required
      >
      <small class="text-muted">JPG, PNG, WEBP (Max 2MB)</small>
      <div class="invalid-feedback">
        Category image is required
      </div>
    </div>

  </div>

  <!-- Row 2 (Action) -->
  <div class="row">
    <div class="col-12 d-flex gap-2 justify-content-start">
      <button type="submit" class="btn btn-sm btn-dark px-4 py-2">
         Save Category
      </button>

      
    </div>
  </div>

</form>

                </div>
            </div>
        </div>

    </main>
  </div>
</div>


