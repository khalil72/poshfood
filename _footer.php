   <footer class="ftco-footer ftco-section footer-modern">
  <div class="container">
    <div class="row mb-5">

      <!-- About -->
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="ftco-footer-widget">
          <h2 class="ftco-heading-2"><?php echo $trans['about_us']; ?></h2>
          <p class="footer-text">
            <?php echo $trans['about_desc']; ?>
          </p>

          <ul class="ftco-footer-social list-unstyled d-flex gap-3 mt-4">
            <li><a href="#"><span class="icon-twitter"></span></a></li>
            <li><a href="#"><span class="icon-facebook"></span></a></li>
            <li><a href="#"><span class="icon-instagram"></span></a></li>
          </ul>
        </div>
      </div>

      <!-- Services -->
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="ftco-footer-widget">
          <h2 class="ftco-heading-2"><?php echo $trans['our_services']; ?></h2>
          <ul class="list-unstyled footer-links">
            <li><?php echo $trans['service_1']; ?></li>
            <li><?php echo $trans['service_2']; ?></li>
            <li><?php echo $trans['service_3']; ?></li>
            <li><?php echo $trans['service_4']; ?></li>
          </ul>
        </div>
      </div>

      <!-- Contact -->
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="ftco-footer-widget">
          <h2 class="ftco-heading-2"><?php echo $trans['have_questions']; ?></h2>
          <ul class="list-unstyled footer-contact">
            <li>
              <span class="icon icon-map-marker"></span>
              <span><?php echo $trans['location']; ?></span>
            </li>
            <li>
              <span class="icon icon-phone"></span>
              <span>+92 303 6580158</span>
            </li>
            <li>
              <span class="icon icon-envelope"></span>
              <span>info@calibite.com</span>
            </li>
          </ul>
        </div>
      </div>

    </div>

    <!-- Bottom -->
    <div class="row">
      <div class="col-md-12 text-center footer-bottom">
        <p>
          © <script>document.write(new Date().getFullYear());</script>
          <strong>Calibite</strong>. <?php echo $trans['rights']; ?>
        </p>
      </div>
    </div>
  </div>
</footer>


  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>



<div id="google_translate_element"></div>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'en', // default language
    includedLanguages: 'en,es,ca',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
    autoDisplay: false
  }, 'google_translate_element');
}


document.addEventListener("DOMContentLoaded", function() {
  const interval = setInterval(() => {
    const select = document.querySelector(".goog-te-combo");
    if (select) {
      select.value = 'en'; // default English
      select.dispatchEvent(new Event('change', { bubbles: true }));
      clearInterval(interval);
    }
  }, 300);
});
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>








<!-- <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <!-- <script>
// Language switcher
document.getElementById('languageSwitcher').addEventListener('change', function() {
    window.location.href = "?lang=" + this.value;
});
</script> -->
  </body>
</html>