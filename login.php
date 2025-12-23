<?php
// Start session and output buffering at the very top
ob_start();
session_start();

include("includes/db.php");

// If admin already logged in, redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
$email = "";

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = "Email and Password are required";
    } else {
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, password FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_email'] = $email;

                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Email or Password is incorrect";
            }

        } else {
            $error = "Email or Password is incorrect";
        }
    }
}

// Include head and navbar AFTER processing login logic
include("_head.php");
include("navbar.php");
?>


<section class="ftco-section bg-light d-flex align-items-center" style="min-height: 100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">

        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-body p-5">

            <h3 class="text-center mb-4 fw-bold">Admin Login</h3>

            <!-- Error Message -->
            <?php if (!empty($error)) : ?>
              <div class="alert alert-danger text-center">
                <?= htmlspecialchars($error) ?>
              </div>
            <?php endif; ?>

            <form method="POST">

              <!-- Email -->
              <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input 
                  type="email" 
                  name="email" 
                  class="form-control form-control-lg"
                  placeholder="Enter admin email"
                  value="<?= htmlspecialchars($email) ?>"
                  required
                >
              </div>

              <!-- Password -->
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input 
                  type="password" 
                  name="password" 
                  class="form-control form-control-lg"
                  placeholder="Enter password"
                  required
                >
              </div>

              <!-- Forgot Password -->
              <div class="text-end mb-4">
                <a href="forgot-password.php" class="text-primary text-decoration-none">
                  Forgot Password?
                </a>
              </div>

              <!-- Button -->
              <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                  Login
                </button>
              </div>

            </form>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<?php include("_footer.php"); ?>
