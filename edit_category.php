<?php 
include("admin/_head.php");
include("includes/db.php"); // make sure $conn is defined
session_start();

$error = "";

// Get category id from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: category.php?msg=Invalid+category");
    exit;
}

// Fetch existing category
$stmt = $conn->prepare("SELECT id, name FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result   = $stmt->get_result();
$category = $result->fetch_assoc();

if (!$category) {
    header("Location: category.php?msg=Category+not+found");
    exit;
}

// Handle form submit (update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        $error = "Category name is required.";
    } else {
        $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);

        if ($stmt->execute()) {
            header("Location: category.php?msg=Category+updated+successfully");
            exit;
        } else {
            $error = "Error updating category: " . $conn->error;
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
                    <h3 class="mb-4">Edit Category</h3>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form method="post" action="">
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                class="form-control" 
                                placeholder="Enter category name" 
                                required
                                value="<?php 
                                    echo htmlspecialchars(
                                        $_POST['name'] ?? $category['name']
                                    ); 
                                ?>"
                            >
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-1"></i>
                            <span class="mx-2 text-white">Update</span>
                        </button>
                       
                    </form>
                </div>
            </div>
        </div>

    </main>
  </div>
</div>