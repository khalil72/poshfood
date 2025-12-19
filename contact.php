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

<section class="ftco-contact py-5 bg-light">
  <div class="container text-center">

    <!-- Heading -->
    <h2 class="mb-3"><?php echo $trans['contact_us']; ?></h2>
    <p class="mb-5 text-muted"><?php echo $trans['contact_subtitle']; ?></p>

    <!-- Contact Info -->
    <div class="row g-4 justify-content-center mb-5">
      <div class="col-md-3">
        <div class="contact-box p-4 rounded shadow-sm bg-white">
          <div class="icon fs-2 mb-3">📞</div>
          <h5><?php echo $trans['phone']; ?></h5>
          <a href="https://wa.me/923036580158" target="_blank">
            +92 303 6580158
          </a>
        </div>
      </div>

      <div class="col-md-3">
        <div class="contact-box p-4 rounded shadow-sm bg-white">
          <div class="icon fs-2 mb-3">✉️</div>
          <h5><?php echo $trans['email']; ?></h5>
        <a href="mailto:info@phoshfood.com">info@phoshfood.com</a>
        </div>
      </div>

      <div class="col-md-3">
        <div class="contact-box p-4 rounded shadow-sm bg-white">
          <div class="icon fs-2 mb-3">📍</div>
          <h5><?php echo $trans['address']; ?></h5>
          <p><?php echo $trans['address_text']; ?></p>
        </div>
      </div>
    </div>


    <div class="map-container rounded shadow-sm overflow-hidden" style="height:400px;">
      <iframe
        src="https://www.google.com/maps/embed?pb=YOUR_MAP_EMBED_CODE"
        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
      </iframe>
    </div>

 
    <a href="https://www.google.com/maps/dir/?api=1&destination=YOUR_LAT,YOUR_LNG" target="_blank" class="btn btn-primary mt-4">
      <?php echo $trans['get_directions']; ?>
    </a>

  </div>
</section>

<?php include("_subfooter.php") ?>
<?php include("_footer.php"); ?>