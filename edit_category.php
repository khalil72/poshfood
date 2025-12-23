<?php
include("admin/_head.php");
include("includes/db.php");
session_start();

$error = "";

// Get category ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: category.php?msg=Invalid+category");
    exit;
}

// Fetch category
$stmt = $conn->prepare("SELECT id, name, image FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

if (!$category) {
    header("Location: category.php?msg=Category+not+found");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $imageName = $category['image']; 

    if ($name === '') {
        $error = "Category name is required.";
    } else {

        if (!empty($_FILES['image']['name'])) {

            $uploadDir = "uploads/categories/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $newImage = time() . '_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $newImage;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {

                // Delete old image
                if (!empty($category['image']) && file_exists($uploadDir . $category['image'])) {
                    unlink($uploadDir . $category['image']);
                }

                $imageName = $newImage;
            } else {
                $error = "Image upload failed.";
            }
        }

        // Update database
        if (!$error) {
            $stmt = $conn->prepare(
                "UPDATE categories SET name = ?, image = ? WHERE id = ?"
            );
            $stmt->bind_param("ssi", $name, $imageName, $id);

            if ($stmt->execute()) {
                header("Location: category.php?msg=Category+updated+successfully");
                exit;
            } else {
                $error = "Error updating category.";
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

      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="mb-4">Edit Category</h3>

          <?php if ($error): ?>
            <div class="alert alert-danger">
              <?php echo htmlspecialchars($error); ?>
            </div>
          <?php endif; ?>

          <form method="post" enctype="multipart/form-data">
            <div class="row g-3">

              <!-- Category Name -->
              <div class="col-md-6">
                <label class="form-label fw-semibold">Category Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required
                       value="<?php echo htmlspecialchars($_POST['name'] ?? $category['name']); ?>">
              </div>

              <!-- Image Upload -->
              <div class="col-md-6">
                <label class="form-label fw-semibold">Category Image</label>
                <input type="file"
                       name="image"
                       class="form-control"
                       accept="image/*">
                <small class="text-muted">Leave empty to keep existing image</small>
              </div>

              <!-- Existing Image -->
              <?php if (!empty($category['image'])): ?>
              <div class="col-12 mt-2">
                <label class="form-label fw-semibold">Current Image</label><br>
                <img src="uploads/categories/<?php echo $category['image']; ?>"
                     alt="Category Image"
                     style="width:120px;height:120px;object-fit:cover;border-radius:8px;border:1px solid #ddd;">
              </div>
              <?php endif; ?>

            </div>

            <button type="submit" class="btn btn-sm btn-dark text-white mt-4 px-3 py-2">
          Update Category
            </button>

          </form>
        </div>
      </div>

    </main>
  </div>
</div>
