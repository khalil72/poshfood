<?php 
$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'en';
$_SESSION['lang'] = $lang;

$langFile = "lang/$lang.php";
if (!file_exists($langFile)) { $langFile = "lang/en.php"; }
$trans = include $langFile;
?>
<section class="faq-section py-5 bg-white" data-aos="fade-up" data-aos-duration="800">
  <div class="container ftco-animate">
    <div class="row justify-content-center align-items-center">
      
 <div class="sec-title mb-4" style="background-image: url('images/line-two.png');">
          <h2 class="text-success mb-1"><i>FAQ</i></h2>
          <h1 class="mb-3">

         Frequently Asked Questions
          </h1>
        </div>

      <div class="col-md-8">
        <div class="accordion" id="faqAccordion">

          <?php foreach ($trans['faqs'] as $i => $faq): ?>
          <div class="accordion-item border-0 mb-3  rounded">
            <h2 class="accordion-header">
              <button class="accordion-header faq-btn btn <?php echo $i !== 0 ? 'collapsed' : ''; ?>"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#faq<?php echo $i; ?>">
                <?php echo $faq['q']; ?>
              </button>
            </h2>

            <div id="faq<?php echo $i; ?>"
                 class="accordion-collapse collapse <?php echo $i === 0 ? 'show' : ''; ?>"
                 data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                <?php echo $faq['a']; ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>

        </div>
      </div>

    </div>
  </div>
</section>