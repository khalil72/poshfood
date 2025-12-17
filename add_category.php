<?php 
include("admin/_head.php");
include("includes/db.php"); // make sure $conn is defined
session_start();

$error = "";
$success = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        $error = "Category name is required.";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            // Success → redirect to category page with success message
            header("Location: category.php?msg=Category+added+successfully");
            exit;
        } else {
            $error = "Error adding category: " . $conn->error;
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

                    <form method="post" action="">
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                class="form-control" 
                                placeholder="Enter category name" 
                                required
                                value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                            >
                        </div>

                          <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>  <span class="mx-2 text-white">Save</span>
                            </button>
                    </form>
                </div>
            </div>
        </div>

    </main>
  </div>
</div>


