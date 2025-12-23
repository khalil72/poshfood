<?php
include("admin/_auth.php");
include("admin/_head.php");
include("includes/db.php");
// session_start();

$successMsg = $_GET['msg'] ?? "";


$limit = 5; 
$page  = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Total records
$totalRes = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$totalRow = mysqli_fetch_assoc($totalRes);
$totalProducts = $totalRow['total'];
$totalPages = ceil($totalProducts / $limit);


$sql = "
SELECT p.id, p.name, p.price, p.image, c.name AS category_name
FROM products p
JOIN categories c ON c.id = p.category_id
ORDER BY p.id DESC
LIMIT $limit OFFSET $offset
";
$res = mysqli_query($conn, $sql);
?>
<div class="container-fluid">
  <div class="row">
    <?php include("admin/_sidebar.php"); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
      <?php include("admin/_topheader.php"); ?>

      <?php if ($successMsg): ?>
        <div id="success-alert" class="alert alert-success alert-dismissible fade show">
          <?php echo htmlspecialchars($successMsg); ?>
        </div>
      <?php endif; ?>

     

      <div class="card shadow-sm animate-slide-up">
        <div class="card-body">
             <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Product List</h5>
              <a href="add_product.php" class="theme-btn uppercase" >
          Add Product
 <i class="icon fa fa-angle-right"></i>
</a>
        
      </div>
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($res && mysqli_num_rows($res) > 0):
                $i = $offset + 1;
                while ($row = mysqli_fetch_assoc($res)):
              ?>
              <tr>
                <td><?php echo $i++; ?></td>
                <td>
                  <?php if (!empty($row['image'])): ?>
                    <img src="uploads/products/<?php echo htmlspecialchars($row['image']); ?>" alt=""
                         style="width:60px;height:60px;object-fit:cover;">
                  <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                <td><?php echo number_format($row['price'], 2); ?></td>
                <td class="text-center">
                  <a href="view_product.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-secondary text-white">
                    <i class="fa fa-eye"></i>
                  </a>
                  <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white">
                    <i class="fa fa-pen-to-square"></i>
                  </a>
                  <a href="delete_product.php?id=<?php echo $row['id']; ?>"
                     class="btn btn-sm btn-danger text-white"
                     onclick="return confirm('Delete this product?');">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
               <?php endwhile; else: ?>
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">
                    No products found
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
          <?php if ($totalPages > 1): ?>
        <nav class="mt-4">
          <ul class="pagination justify-content-center">

            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
              <a class="page-link" href="?page=<?php echo $page - 1; ?>">
                <i class="fa fa-angle-left"></i>
              </a>
            </li>

            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
              <li class="page-item <?php echo ($p == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $p; ?>">
                  <?php echo $p; ?>
                </a>
              </li>
            <?php endfor; ?>

            <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
              <a class="page-link" href="?page=<?php echo $page + 1; ?>">
                <i class="fa fa-angle-right"></i>
              </a>
            </li>

          </ul>
        </nav>
      <?php endif; ?>
        </div>
      </div>
    </main>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const alertBox = document.getElementById('success-alert');

  if (alertBox) {
    setTimeout(() => {
      alertBox.style.transition = "all 0.4s ease";
      alertBox.style.opacity = "0";
      alertBox.style.margin = "0";
      alertBox.style.padding = "0";

      setTimeout(() => {
        alertBox.remove();
      }, 400);

    }, 3000);

   
    if (window.history.replaceState) {
      const url = window.location.origin + window.location.pathname;
      window.history.replaceState(null, '', url);
    }
  }
});
</script>
