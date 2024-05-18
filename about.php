<?php
session_start();
error_reporting(0);
include('dbconnection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Belen's Beauty Parlor</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/cust-profile.css" rel="stylesheet">
  <link href="assets/css/index-style.css" rel="stylesheet">

</head>

<body>

  <?php include('header-cust'); ?>

  <main id="about">

    <section id="about" class="about">

      <div class="container">
        <div class="row about-about">
          <div class="main-titles-head text-center">
            <h1 class="header-name display-5 fw-bold d-flex justify-content-center" style="margin-top: 2em;" data-aos="fade-up" data-aos-delay="100">
              ABOUT
            </h1>
            </br></br>
          </div>

          <div class="row align-items-md-stretch">
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="150">
              <img src="assets/img/about1.png" class="rounded-3" width="100%" alt="">
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="150">
              <div class="h-100 p-5 rounded-3">
                <h1><strong>Belen's Beauty Parlor</strong></h1><br>
                <h5>Founded in 1995, Belen's Beauty Parlor provides a variety of beauty treatments and services. It serves walk-in consumers of all ages and genders.</h5>
              </div>
            </div>
            <section data-aos="fade-up" data-aos-delay="100"> <br> <br>
              <h2>BRIEF HISTORY</h2>
              <p>The name of the beauty parlor originated from the nickname of the owner namely Evelyn Ewayan. Belen's Beauty Parlor provides superior hair and nail treatments, as well as the finest beauty products. They want the hair and skin of their clients to radiate energy from within and outside. It resided in Agton Street, Toril, Davao City, from its founding until 2020. But during the early months of the pandemic, Belen's Beauty Parlor was forced to shut due to the impact of the epidemic on companies.  </p>

              <p>In 2021, the beauty salon reopened its doors in a new site which is Toril Public Market, Piedad Street, Toril, Davao City, to serve its loyal clients. Their dedication to delivering all of these services in a single, convenient location will set Belen's Beauty Parlor apart from the competition. The position is ideally placed on one of Toril's main streets, a prominent region with easy access from all areas of the poblacion.</p>

              <p>Belen's Beauty Parlor has been and continues to be a full-service beauty salon committed to offering high client satisfaction on a constant basis by providing outstanding service, quality products, and a pleasurable ambiance at an appropriate price and value ratio. They also maintain a welcoming, equitable, and inventive atmosphere that values variety, ideas, and effort.</p>
            </section>
          </div>

        </div>
      </div>
    </section><!-- End Services Section -->
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>
      <p>Everyone is beautiful, we just make it obvious!</p>
      <div class="social-links">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
      </div>
      <div class="copyright">
        &copy; Copyright <strong><span>Belen's Beauty Parlor</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="">Team Belen</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/index.js"></script>

</body>

</html>