 <footer class="ftco-footer footer-modern bg-light pt-5">
  <div class="container">
    <div class="row mb-5 align-items-start">

      <!-- Logo + About -->
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="footer-brand">
          <img src="images/Calibite_logo.png" alt="Calibite Logo" class="footer-logo mb-3">
          <p class="footer-text">
            Phosh Food delivers fresh, macro-balanced meals across Spain. 
            Chef-prepared, nutritionally designed, and ready to heat. 
            Healthy eating made simple.
          </p>
        </div>
      </div>

      <!-- Services -->
      <div class="col-lg-4 col-md-6 mb-4">
        <h5 class="footer-title">Our Services</h5>
        <ul class="footer-links">
          <li>Freshly Cooked Meals</li>
          <li>Weekly Delivery</li>
          <li>Healthy Nutrition</li>
          <li>Custom Meal Plans</li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-lg-4 col-md-6 mb-4">
        <h5 class="footer-title">Contact Us</h5>
        <ul class="footer-contact">
          <li><i class="fa fa-map-marker"></i> Lahore, Pakistan</li>
          <li><i class="fa fa-phone"></i> +92 303 6580158</li>
          <li><i class="fa fa-envelope"></i> info@poshfood.com</li>
        </ul>
      </div>

    </div>

    <!-- Bottom -->
    <div class="row border-top pt-3">
      <div class="col-md-12 text-center">
        <p class="mb-0">
          © <script>document.write(new Date().getFullYear());</script>
          <strong>Calibite</strong>. All Rights Reserved.
        </p>
      </div>
    </div>
  </div>
</footer>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>




<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'en', 
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

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const slideEls = document.querySelectorAll('.slide-up');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting){
        entry.target.classList.add('show');
      }
    });
  }, { threshold: 0.1 });

  slideEls.forEach(el => observer.observe(el));
});
</script>







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