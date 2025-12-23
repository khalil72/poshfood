<?php
include("_head.php");
include("_topbar.php");
include("navbar.php");
include("includes/db.php");
$alert = "";
$alertType = "";
if(isset($_GET['success'])) {
    $alert = "✅ Your message has been sent successfully!";
    $alertType = "success";
} elseif(isset($_GET['error'])) {
    $alert = "❌ Something went wrong. Please try again.";
    $alertType = "danger";
}

// Handle POST submission
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $contact = mysqli_real_escape_string($conn,$_POST['contact']);
    $type = mysqli_real_escape_string($conn,$_POST['type']);
    $message = mysqli_real_escape_string($conn,$_POST['message']);

    $sql = "INSERT INTO contacts (name,email,contact,type,message)
            VALUES ('$name','$email','$contact','$type','$message')";
    
   if(mysqli_query($conn,$sql)){
        $alert = "✅ Thanks for contacting us. We'll get back to you as soon as possible.!";
        $alertType = "success";
    } else {
        $alert = "❌ Something went wrong. Please try again.";
        $alertType = "danger";
    }
}
?>


<section class="py-5 bg-white contact-section">
  <div class="container">
    <div class="row g-4">

      <!-- LEFT SIDE -->
      <div class="col-md-5 slide-up delay-1">
        <div class="help-box h-100">
          <h4 class="mb-3">Need Help?</h4>
          <p class="text-muted mb-4">
            Have a question about your order or want to know more about our meals?
            Send us a message and we’ll get back to you as soon as possible.
            We’re here to help you get the most out of Phosh Food.
          </p>

          <div class="contact-item">
            <span class="icon">📞</span>
            <div>
              <h6 class="mb-1">Contact Number</h6>
              <a href="https://wa.me/923036580158" target="_blank">+92 303 6580158</a>
            </div>
          </div>

          <div class="contact-item mt-4">
            <span class="icon">✉️</span>
            <div>
              <h6 class="mb-1">Email</h6>
              <a href="mailto:info@phoshfood.com">info@phoshfood.com</a>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT SIDE -->
      <div class="col-md-7 slide-up delay-2">
        <div class="form-box h-100 with-divider">
          <h4 class="mb-4">Contact Form</h4>
      <?php if($alert): ?>
<div id="formAlert" class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
  <?php echo $alert; ?>
 
</div>

<script>
  setTimeout(function(){
    var alertEl = document.getElementById('formAlert');
    if(alertEl){
      var bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
      bsAlert.close();
    }
  }, 3000);
</script>
<?php endif; ?>

   

          <form action="" method="POST">
            <div class="row g-3">

              <div class="col-md-6 mb-3">
                <input type="text" name="name" class="form-control"
                       placeholder="Enter your name" required>
              </div>

              <div class="col-md-6 mb-3">
                <input type="email" name="email" class="form-control"
                       placeholder="Enter your email" required>
              </div>

              <div class="col-md-6 mb-3">
                <input type="text" name="contact" class="form-control"
                       placeholder="Enter your contact number" required>
              </div>

              <div class="col-md-6 mb-3 mt-3">
                <select name="type" class="form-select custom-select" required>
                  <option value="">Select Type</option>
                  <option value="complaint">Complaint</option>
                  <option value="feedback">Feedback</option>
                </select>
              </div>

              <div class="col-md-12 mb-3 mt-3">
                <textarea name="message" rows="3" class="form-control"
                          placeholder="Write your message" required></textarea>
              </div>

              <div class="col-md-12 mt-2">
                <button type="submit" class="btn btn-primary">Send Message</button>
              </div>

            </div>
          </form>

        </div>
      </div>

    </div>
  </div>
</section>




<?php include("_subfooter.php") ?>
<?php include("_footer.php"); ?>

<!-- AUTO OPEN MODAL -->

