<?php
// session_start();
$currentPage = basename($_SERVER['PHP_SELF']); 

?>


<body>
  
<nav class="navbar navbar-expand-lg py-2 pb-3 bg-white shadow-sm ftco_navbar" id="ftco-navbar"
data-aos="fade-right" data-aos-duration="800"
>
  <div class="container">

   
    <a class="navbar-brand d-flex align-items-center mx-3 mx-sm-0" href="index.php">
      <img src="images/Calibite_logo.png" alt="Calibite Logo" height="50" width="75" class="image-fluid">
    </a>


    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ftco-nav">
      <span class="navbar-toggler-icon ">
        
      </span>
    </button>

    
    <div class="collapse navbar-collapse" id="ftco-nav">
      <ul class="navbar-nav mx-auto align-items-center gap-lg-4">
        <li class="nav-item">
          <a class="nav-link <?php echo ($currentPage=='index.php') ? 'active' : ''; ?>" href="index.php">
            Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($currentPage=='all_products.php') ? 'active' : ''; ?>" href="all_products.php">
            Our Menu
          </a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link <?php echo ($currentPage=='how-it-works.php') ? 'active' : ''; ?>" href="how-it-works.php">
            How It Works
          </a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link <?php echo ($currentPage=='contact.php') ? 'active' : ''; ?>" href="contact.php">
            Contact
          </a>
        </li>
      </ul>

      <!-- RIGHT: Language -->
       <div class="navbar-lang ms-auto text-center mt-3 mt-lg-0 ms-lg-3">
        <div id="google_translate_element"></div>
      </div>

    </div>
  </div>
</nav>

<button id="backToTop" title="Go to top">
  <i class="fa fa-arrow-up"></i>
</button>
<script>
const backToTop = document.getElementById("backToTop");

window.addEventListener("scroll", () => {
  if (window.scrollY > 300) {
    backToTop.style.display = "flex";
  } else {
    backToTop.style.display = "none";
  }
});

backToTop.addEventListener("click", () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
});
</script>



