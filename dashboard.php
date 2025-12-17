<?php
include("admin/_auth.php");
include("admin/_head.php");
include("includes/db.php");
// // session_start();
$admin_name = "Admin";


$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"))['total'];
$totalCategories = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM categories"))['total'];
$totalPrice = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(price) as total FROM products"))['total'] ?? 0;
$avgPrice = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(price) as avg FROM products"))['avg'] ?? 0;


$categoryData = [];
$categoryQuery = "SELECT c.name, COUNT(p.id) as count 
                  FROM categories c 
                  LEFT JOIN products p ON c.id = p.category_id 
                  GROUP BY c.id, c.name";
$catResult = mysqli_query($conn, $categoryQuery);
while ($row = mysqli_fetch_assoc($catResult)) {
    $categoryData[] = [
        'name' => $row['name'],
        'count' => (int)$row['count']
    ];
}

// Products added over time (last 7 days) for Line Chart
$dateData = [];
$dateLabels = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $dateLabels[] = date('M d', strtotime("-$i days"));
    $countQuery = "SELECT COUNT(*) as count FROM products WHERE DATE(created_at) = '$date'";
    $countResult = mysqli_query($conn, $countQuery);
    $dateData[] = (int)mysqli_fetch_assoc($countResult)['count'];
}

// Price Range Distribution for Bar Chart
$priceRanges = [
    '0-100' => 0,
    '101-500' => 0,
    '501-1000' => 0,
    '1001-5000' => 0,
    '5000+' => 0
];
$priceQuery = "SELECT price FROM products";
$priceResult = mysqli_query($conn, $priceQuery);
while ($row = mysqli_fetch_assoc($priceResult)) {
    $price = (float)$row['price'];
    if ($price <= 100) $priceRanges['0-100']++;
    elseif ($price <= 500) $priceRanges['101-500']++;
    elseif ($price <= 1000) $priceRanges['501-1000']++;
    elseif ($price <= 5000) $priceRanges['1001-5000']++;
    else $priceRanges['5000+']++;
}

// Recent Products
$recentProducts = [];
$recentQuery = "SELECT p.id, p.name, p.price, p.image, c.name AS category_name 
                FROM products p 
                JOIN categories c ON c.id = p.category_id 
                ORDER BY p.created_at DESC 
                LIMIT 5";
$recentResult = mysqli_query($conn, $recentQuery);
while ($row = mysqli_fetch_assoc($recentResult)) {
    $recentProducts[] = $row;
}
?>

<div class="container-fluid">
  <div class="row">
    <?php include("admin/_sidebar.php"); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 bg-light">
      <?php include("admin/_topheader.php"); ?>

      <!-- Page Header -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h3 class="fw-bold mb-0">
            <i class="fa fa-chart-line me-2 text-primary"></i> Dashboard
          </h3>
          <p class="text-muted mb-0 small">Welcome back, <?php echo htmlspecialchars($admin_name); ?>!</p>
        </div>
      </div>

      <!-- Statistics Cards -->
      <div class="row g-3 mb-4">
        <div class="col-md-6 col-sm-6">
          <div class="card border-0 rounded shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted mb-2">Total Products</h6>
                  <h3 class="fw-bold mb-0"><?php echo $totalProducts; ?></h3>
                </div>
                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                  <i class="fa fa-box fa-2x text-white"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-sm-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted mb-2">Total Categories</h6>
                  <h3 class="fw-bold mb-0"><?php echo $totalCategories; ?></h3>
                </div>
                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                  <i class="fa fa-tags fa-2x text-white"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        

        
      </div>

      <!-- Charts Row -->
      <div class="row g-4 mb-4">
        <!-- Products by Category - Pie Chart -->
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pb-0">
              <h5 class="fw-bold mb-0">
                <i class="fa fa-chart-pie me-2 text-primary"></i> Products by Category
              </h5>
            </div>
            <div class="card-body">
              <canvas id="categoryChart" height="250"></canvas>
            </div>
          </div>
        </div>

        <!-- Products Added Over Time - Line Chart -->
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pb-0">
              <h5 class="fw-bold mb-0">
                <i class="fa fa-chart-line me-2 text-primary"></i> Products Added (Last 7 Days)
              </h5>
            </div>
            <div class="card-body">
              <canvas id="lineChart" height="250"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Price Distribution - Bar Chart -->
      <div class="row g-4 mb-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
              <h5 class="fw-bold mb-0">
                <i class="fa fa-chart-bar me-2 text-primary"></i> Price Distribution
              </h5>
            </div>
            <div class="card-body">
              <canvas id="barChart" height="100"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Products -->
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0 d-flex justify-content-between align-items-center">
              <h5 class="fw-bold mb-0">
                <i class="fa fa-clock me-2 text-primary"></i> Recent Products
              </h5>
              <a href="product.php" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
              <?php if (!empty($recentProducts)): ?>
                <div class="table-responsive">
                  <table class="table table-hover align-middle">
                    <thead class="table-light">
                      <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($recentProducts as $product): ?>
                        <tr>
                          <td>
                            <?php if (!empty($product['image'])): ?>
                              <img src="uploads/products/<?php echo htmlspecialchars($product['image']); ?>" 
                                   alt="" 
                                   style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                            <?php else: ?>
                              <span class="text-muted small">No image</span>
                            <?php endif; ?>
                          </td>
                          <td><?php echo htmlspecialchars($product['name']); ?></td>
                          <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                          <td>₹<?php echo number_format($product['price'], 2); ?></td>
                          <td class="text-center">
                            <a href="view_product.php?id=<?php echo $product['id']; ?>" 
                               class="btn btn-sm btn-outline-secondary">
                              <i class="fa fa-eye"></i>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php else: ?>
                <div class="text-center py-4">
                  <i class="fa fa-box-open fa-3x text-muted mb-3"></i>
                  <p class="text-muted">No products found.</p>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      
    </main>
  </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Category Pie Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
const categoryData = <?php echo json_encode($categoryData); ?>;
const categoryChart = new Chart(categoryCtx, {
  type: 'pie',
  data: {
    labels: categoryData.map(item => item.name),
    datasets: [{
      data: categoryData.map(item => item.count),
      backgroundColor: [
        '#0d6efd',
        '#198754',
        '#ffc107',
        '#dc3545',
        '#0dcaf0',
        '#6610f2',
        '#fd7e14',
        '#20c997'
      ],
      borderWidth: 2,
      borderColor: '#fff'
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'bottom'
      }
    }
  }
});

// Line Chart - Products Added Over Time
const lineCtx = document.getElementById('lineChart').getContext('2d');
const lineChart = new Chart(lineCtx, {
  type: 'line',
  data: {
    labels: <?php echo json_encode($dateLabels); ?>,
    datasets: [{
      label: 'Products Added',
      data: <?php echo json_encode($dateData); ?>,
      borderColor: '#0d6efd',
      backgroundColor: 'rgba(13, 110, 253, 0.1)',
      tension: 0.4,
      fill: true,
      borderWidth: 3,
      pointRadius: 5,
      pointBackgroundColor: '#0d6efd',
      pointBorderColor: '#fff',
      pointBorderWidth: 2
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 1
        }
      }
    }
  }
});

// Bar Chart - Price Distribution
const barCtx = document.getElementById('barChart').getContext('2d');
const priceRanges = <?php echo json_encode($priceRanges); ?>;
const barChart = new Chart(barCtx, {
  type: 'bar',
  data: {
    labels: Object.keys(priceRanges),
    datasets: [{
      label: 'Number of Products',
      data: Object.values(priceRanges),
      backgroundColor: [
        'rgba(13, 110, 253, 0.8)',
        'rgba(25, 135, 84, 0.8)',
        'rgba(255, 193, 7, 0.8)',
        'rgba(220, 53, 69, 0.8)',
        'rgba(13, 202, 240, 0.8)'
      ],
      borderColor: [
        '#0d6efd',
        '#198754',
        '#ffc107',
        '#dc3545',
        '#0dcaf0'
      ],
      borderWidth: 2,
      borderRadius: 5
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 1
        }
      }
    }
  }
});
</script>

<style>
  .card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  
  .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
  }
  
  canvas {
    max-height: 300px;
  }
</style>
