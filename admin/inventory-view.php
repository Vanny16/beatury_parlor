<?php
include('dbconnection.php');
session_start();
error_reporting(0);
$ID = $_SESSION['empid'];
if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
}

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
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>

  <?php include('header.php'); ?>
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item ">
        <a class="nav-link collapsed" href="appointment.php">
          <i class="bi bi-calendar-week"></i>
          <span>Appointments</span>
        </a>
      </li><!-- End Appointments Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="customer.php">
          <i class="bi bi-person"></i>
          <span>Customers</span>
        </a>
      </li><!-- End Customers Page Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="employee.php">
          <i class="bi bi-person"></i>
          <span>Employee</span>
        </a>
      </li><!-- End Employee Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="service.php">
          <i class="bi bi-card-list"></i>
          <span>Services</span>
        </a>
      </li><!-- End Services Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="transaction.php">
          <i class="bi bi-cart-dash"></i>
          <span>Service Orders</span>
        </a>
      </li><!-- End Service Orders Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#inventory-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="inventory-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="inventory.php">
              <i class="bi bi-circle"></i><span>Inventory</span>
            </a>
          </li>
          <li>
            <a href="inventory-stockin.php">
              <i class="bi bi-circle"></i><span>Stock In Log</span>
            </a>
          </li>
          <li>
            <a href="inventory-stockout.php">
              <i class="bi bi-circle"></i><span>Stock Out Log</span>
            </a>
          </li>
        </ul>
      </li><!-- End inventory Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="income.php">
              <i class="bi bi-circle"></i><span>Income Report</span>
            </a>
          </li>
          <li>
            <a href="stock.php">
              <i class="bi bi-circle"></i><span>Stocks Report</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <?php
  $vid = $_GET['viewid'];
  $ret = mysqli_query($con, "select * from tblinventory where ID =$vid");
  while ($row = mysqli_fetch_array($ret)) {
  ?>

    <main id="main" class="main">

      <div class="pagetitle">
        <h1>INVENTORY</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active"><a href="inventory.php">Inventory</a></li>
            <li class="breadcrumb-item active"><?php echo $row['ProductName']; ?></li>
          </ol>
        </nav>
      </div><!-- End Page Title -->

      <section class="section">
        <div class="row">
          <div class="col-lg">
            <div class="card">
              <div class="card-body">

                <div class="card-title">
                  <h2><b><?php echo $row['ProductName']; ?></b></h2>
                </div>

                <div class="row">
                  <div class="column right">
                    <h4>Product Information</h4>

                    <div class="row g-3">
                      <div class="col-lg-12">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="pname" value="<?php echo $row['ProductName']; ?>" disabled>
                      </div>

                      <div class="col-lg-12">
                        <label class="form-label">Quantity</label>
                        <input type="text" class="form-control" name="quantity" value="<?php echo $row['Quantity']; ?>" disabled>
                      </div>

                      <div class="col-lg-12">
                        <label class="form-label">Date Registered</label>
                        <input type="text" class="form-control" name="date creation" value="<?php echo $row['CreationDate']; ?>" disabled>
                      </div>

                    </div>
                  </div>
                </div>
                <div>
                </div>
                <div align="center">
                  <a href="inventory-edit.php?editid=<?php echo htmlentities($row['ID']); ?>" class="add-btn">UPDATE PRODUCT</a>
                </div>
              <?php } ?>
              </div>
            </div>
          </div>
      </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
      <div class="copyright">
        &copy; Copyright <strong><span>Belen's Beauty Parlor</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="">Team Belen</a>
      </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.min.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>