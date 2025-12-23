<?php
include("admin/_auth.php");
include("admin/_head.php");

$admin_name = "Admin";
$successMsg = '';
if (!empty($_GET['msg'])) {
    $successMsg = $_GET['msg']; 
}

include("includes/db.php");

// Pagination setup
$limit = 10; // records per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total records
$total_sql = "SELECT COUNT(*) as total FROM contacts";
$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch records for current page
$sql = "SELECT * FROM contacts ORDER BY id DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $sql);
?>

<div class="container-fluid">
  <div class="row">

    <?php include("admin/_sidebar.php"); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

        <?php include("admin/_topheader.php"); ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <?php if ($successMsg): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
                <?php endif; ?>

                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && mysqli_num_rows($result) > 0) {
                            $i = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['contact']); ?></td>
                            <td><?= htmlspecialchars($row['type']); ?></td>
                            <td><?= htmlspecialchars($row['message']); ?></td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="6" class="text-center">No contact found.</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php if($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page-1 ?>">Previous</a>
                                </li>
                            <?php endif; ?>

                            <?php for($p=1; $p<=$total_pages; $p++): ?>
                                <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page+1 ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

            </div>
        </div>

    </main>
  </div>
</div>
