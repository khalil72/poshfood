<?php 
include("_head.php");
include("_topbar.php");
include("navbar.php");

?>

<section class="ftco-section banner-bg mb-5" data-aos="fade-up" data-aos-duration="800">
  <div class="container">
    <div class="row justify-content-center mb-5 ">
    <div class="col-md-8 text-center">
  <span class="text-white">Getting healthy meals is simple, fast, and hassle-free.</span>
  <h2 class="text-white font-bold mb-0">How It Works</h2>
 
</div>


    </div>
    <div class="row" data-aos="fade-right" data-aos-duration="800">
      <div class="col-md-4 mb-4">
        <div class="work-step text-center">
          <span class="step-number">01</span>
        
            <img src="icons/checklist.avif" class="img mb-3"/>
        
         <h4 class="mb-0 text-success ">Pick Your Meals</h4>
<p>
  Choose from our weekly chef-designed menu tailored to your goals
</p>




        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="work-step text-center">
          <span class="step-number">02</span>
          
              <img src="icons/lunch-box.avif" class="mb-3"/>
          
    <h4 class="mb-0 text-success ">
      Fresh Cooking
    </h4>
<p>
  Our chefs cook your meals fresh using premium ingredients.
</p>

        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="work-step text-center">
          <span class="step-number">03</span>
         
             <img src="icons/delivery-man.avif" class="img mb-3" />
         
         <h4 class="mb-0 text-success ">Doorstep Delivery</h4>
<p>
  Receive fresh meals weekly, ready to heat and enjoy
</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="about-section d-flex align-items-center mt-0 mt-md-5 " data-aos="fade-up" data-aos-duration="800"
style="background-image: url('images/transparent-image-6.png');"
>
  <div class="container">
    <div class="row align-items-start">

      
   <div class="col-md-6 d-flex justify-content-center align-items-center">
  <div class="about-image-overlap">
    <img src="images/gallery-4.jpg"  class="img img-front" alt="Healthy Meal">
    <img src="images/gallery-1.jpg" class="img img-back" alt="Meal Prep">
  </div>
</div>


     
      <div class="col-md-6 text-left">
        <div class="sec-title mb-4" style="background-image: url('images/line-two.png');">
          <h2 class="text-success mb-0 ">
             <i>Who We Are</i>
          </h2>
          <h1 class="mb-0">
       Real Food. Real Results
          </h1>
        </div >

        <div class="mb-3">
            <p>
  Fresh, chef-made meals crafted to support
  your personal health goals. Each dish is made
  with locally sourced ingredients,
  ensuring maximum flavor and nutrition.
</p>

        </div>
 



<a href="all_products.php" class="theme-btn uppercase" data-aos="fade-right" data-aos-duration="800">
  See The Menu
  <i class="icon fa fa-angle-right"></i>
</a>

        
      </div>

    </div>
  </div>
</section>
<section class="divide-section bg-light " data-aos="fade-up" data-aos-duration="800">
  <div class="container">
    <div class="row align-items-center  gx-10">

      <!-- LEFT: Text -->
      <div class="col-md-6 text-left">
        <div class="sec-title mb-4" style="background-image: url('images/line-two.png');">
          <h2 class="text-success mb-1"><i>Built for Healthy Living</i></h2>
          <h1 class="mb-3">

          About Our Kitchen
          </h1>
        </div>

        <p class="">
         All meals are cooked to order using fresh, high-quality ingredients.

We use packaging that keeps food fresh until you’re ready to eat. Each dish comes with clear heating instructions for the microwave or oven.
        </p>
      </div>

      <!-- RIGHT: Full-width Image -->
      <div class="col-md-6 text-center">
        <img src="images/Copy_of_DSC05470_1.webp" 
             class="img-fluid rounded shadow-lg" 
             alt="Healthy Meal"
             style="width: 100%; height: auto; object-fit: contain;">
      </div>

    </div>
  </div>
</section>



<!-- <section class="ftco-animated py-5 bg-light">
  <div class="container justify-content-center text-center">
       <h2 class="mb-1"><?php echo $trans['why_choose_us']; ?></h2>
    <p class="mb-3 text-muted"><?php echo $trans['choose_us_subtitle']; ?></p>
    <div class="row text-center g-4 mt-3">
       

      <div class="col-md-3">
        <div class="badge-icon p-4 rounded shadow-sm position-relative overflow-hidden bg-white hover-effect">
          <div class="icon mb-3 fs-2">🥬</div>
          <p class="mb-0 fw-bold"><?php echo $trans['fresh_ingredients']; ?></p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="badge-icon p-4 rounded shadow-sm position-relative overflow-hidden bg-white hover-effect">
          <div class="icon mb-3 fs-2">⏱️</div>
          <p class="mb-0 fw-bold"><?php echo $trans['fast_delivery']; ?></p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="badge-icon p-4 rounded shadow-sm position-relative overflow-hidden bg-white hover-effect">
          <div class="icon mb-3 fs-2">🌱</div>
          <p class="mb-0 fw-bold"><?php echo $trans['healthy_meals']; ?></p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="badge-icon p-4 rounded shadow-sm position-relative overflow-hidden bg-white hover-effect">
          <div class="icon mb-3 fs-2">🥗</div>
          <p class="mb-0 fw-bold"><?php echo $trans['variety_menu']; ?></p>
        </div>
      </div>

    </div>
  </div>
</section> -->



<?php include("faq_section.php") ?>
<?php include("_subfooter.php") ?>

<?php include("_footer.php"); ?>