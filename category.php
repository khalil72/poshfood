<?php
include("admin/_auth.php");
include("admin/_head.php");
// session_start();
$admin_name = "Admin";

$successMsg = '';
if (!empty($_GET['msg'])) {
    $successMsg = $_GET['msg']; 
}
?>

<div class="container-fluid">
  <div class="row">

    <?php include("admin/_sidebar.php"); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 ">

        <?php include("admin/_topheader.php"); ?>

        <?php if (!empty($successMsg)): ?>
          <div id="success-alert" class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle me-1"></i>
            <?php echo htmlspecialchars($successMsg); ?>
          </div>
        <?php endif; ?>   


        <div class="d-flex justify-content-between align-items-center mb-3 ">
            <h5 class="mb-0">Category List</h5>
            <a href="add_category.php" class="theme-btn uppercase" >
          Add Category
 <i class="icon fa fa-angle-right"></i>
</a>
           
        </div>

        <div class="card shadow-sm ">
            <div class="card-body">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            
                            <th>Category Name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include("includes/db.php");

                    $sql = "SELECT id, name, image FROM categories ORDER BY id DESC";

                        $result = mysqli_query($conn, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                             <td>
                            <?php if (!empty($row['image'])): ?>
  <img src="uploads/categories/<?php echo htmlspecialchars($row['image']); ?>" class="category-thumb"
  
  >
<?php else: ?>
  <img src="assets/no-image.png" class="category-thumb">
<?php endif; ?>

      </td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td class="text-center">
                              <a href="edit_category.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white">
                                  <i class="fa fa-pen-to-square"></i>
                              </a>
                              <a href="delete_category.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger text-white"
                                 onclick="return confirm('Delete this category?');">
                                <i class="fa fa-trash"></i>
                              </a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="3" class="text-center">No categories found.</td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>

    </main>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const alertBox = document.getElementById('success-alert');
  if (alertBox) {
    setTimeout(function () {
      alertBox.classList.remove('show');
      alertBox.classList.add('hide');
    }, 3000); 

    if (window.history.replaceState) {
      const url = window.location.origin + window.location.pathname;
      window.history.replaceState(null, '', url);
    }
  }
});
</script>