<?php 
include("_head.php");
include("_topbar.php");
include("navbar.php");
$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'en';
$_SESSION['lang'] = $lang;

$langFile = "lang/$lang.php";
if (!file_exists($langFile)) { $langFile = "lang/en.php"; }
$trans = include $langFile;


function translateText($text, $target = 'en') {
    $text = urlencode($text);
    $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=$target&dt=t&q=$text";
    $response = file_get_contents($url);
    $result = json_decode($response, true);
    return $result[0][0][0] ?? $text;
}
?>

<section class="ftco-section bg-primary  mb-5">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-8 text-center">
        <h2 class="mb-3 text-white"><?php echo $trans['how_it_works']; ?></h2>
        <p class="text-white-50"><?php echo $trans['how_it_works_text']; ?></p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="work-step text-center">
          <span class="step-number">01</span>
          <div class="step-icon">🥗</div>
         <h4><?php echo $trans['step_pick']; ?></h4>
<p><?php echo $trans['step_pick_desc']; ?></p>




        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="work-step text-center">
          <span class="step-number">02</span>
          <div class="step-icon">👨‍🍳</div>
    <h4><?php echo $trans['step_cook']; ?></h4>
<p><?php echo $trans['step_cook_desc']; ?></p>

        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="work-step text-center">
          <span class="step-number">03</span>
          <div class="step-icon">🚚</div>
         <h4><?php echo $trans['step_delivery']; ?></h4>
<p><?php echo $trans['step_delivery_desc']; ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-about d-flex align-items-center min-vh-100 mt-5 mb-5">
  <div class="container">
    <div class="row align-items-center">

      <!-- Image Column -->
      <div class="col-md-6">
         <img src="images/mockup1b.png" alt="Healthy Meals" class="about-img img-fluid"/>
      </div>

      <!-- Content Column -->
      <div class="col-md-6 text-left">
        <div class="heading-section">
          <h2 class="mb-4">
                <?php echo $trans['how_it_works_text']; ?>
          </h2>
        </div>
         <p class="mb-4">
  <?php echo $trans['how_it_works_desc']; ?>
</p>

<a href="all_products.php" class="btn btn-primary py-3 px-4">
  <?php echo $trans['see_menu']; ?>
</a>

        
      </div>

    </div>
  </div>
</section>
<section class="ftco-animated py-5 bg-light">
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
</section>




<?php include("_subfooter.php") ?>

<?php include("_footer.php"); ?>