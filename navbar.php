<?php
session_start();


$currentPage = basename($_SERVER['PHP_SELF']); 


$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'en';
$_SESSION['lang'] = $lang;

// Language files
$langFile = "lang/$lang.php";
if(!file_exists($langFile)) { $langFile = "lang/en.php"; }
$trans = include $langFile;
?>
<script>
function googleTranslateElementInit() {
  new google.translate.TranslateElement(
    {
      pageLanguage: 'en',
      includedLanguages: 'en,ur,ar',
      autoDisplay: false
    },
    'google_translate_element'
  );
}
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<body>
  
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/white_logo.svg" alt="Logo" height="80">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" 
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage=='index.php') ? 'active' : ''; ?>" href="index.php">
                        <?php echo $trans['home']; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage=='all_products.php') ? 'active' : ''; ?>" href="all_products.php">
                        <?php echo $trans['our_menu']; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage=='how-it-works.php') ? 'active' : ''; ?>" href="how-it-works.php">
                        <?php echo $trans['how_it_works']; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage=='contact.php') ? 'active' : ''; ?>" href="contact.php">
                        <?php echo $trans['contact']; ?>
                    </a>
                </li>
      
       <li class="nav-item ms-3">
<div id="google_translate_element"></div>
</li>

                
            </ul>
        </div>
    </div>
</nav>


