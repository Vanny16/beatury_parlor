<?php
session_start();
error_reporting(0);
include('dbconnection.php');
$ID = $_SESSION['empid'];

if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
}

if (isset($_POST['submit'])) {

  $invoiceID = $_POST['invoiceID'];
  $total = $_POST['total'];
  $payment = $_POST['payment'];

  if ((intval($payment)) < (intval($total))) {
    echo "<script>alert('Payment is less than the total. Please try again');</script>";
  } else {
    $getQ = mysqli_fetch_assoc(mysqli_query($con, "SELECT AptNum FROM tblserviceorder WHERE InvoiceID='$invoiceID'"));
    $aptnum = $getQ['AptNum'];

    $query = mysqli_query($con, "INSERT into tblpayment(InvoiceID, AptNum, Total, Payment,EmployeeID) value('$invoiceID','$aptnum ','$total','$payment','$ID')");

    if ($query) {
      $getQ = mysqli_fetch_assoc(mysqli_query($con, "SELECT PaymentID FROM tblpayment WHERE InvoiceID='$invoiceID'"));
      $payid = $getQ['PaymentID'];
      $query = mysqli_query($con, "UPDATE tblserviceorder SET PaymentStatus = 'Paid', PaymentID = '$payid' WHERE InvoiceID ='$invoiceID'");
      echo "<script>alert('You have successfully recorded a payment!');</script>";
      echo "<script type='text/javascript'> document.location ='transaction.php'; </script>";
    } else {
      echo "<script>alert('Something Went Wrong. Please try again');</script>";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body>

  <?php include('header.php') ?>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
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
        <a class="nav-link" href="transaction.php">
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

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>SERVICE ORDERS</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="transaction.php">Service Order</a></li>
          <li class="breadcrumb-item active">Payment</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <div class="card-title">
                <h3><b>Record Payment</b></h3>
              </div>


              <form method="POST" enctype="multipart/form-data">

                <div class="row g-3">
                  <?php
                  $cid = $_GET['invid'];
                  $ret = mysqli_query($con, "select tblinvoice.InvoiceID, tblservices.ServiceName, tblservices.Cost  
                        from  tblinvoice 
                        join tblservices on tblservices.ID=tblinvoice.ServiceId 
                        where tblinvoice.InvoiceID='$cid'");
                  $row = mysqli_fetch_array($ret);
                  ?>
                    <div class="col-12">
                      <label class="form-label">Invoice Number</label>

                      <input type="text" class="form-control" value="<?php echo $row['InvoiceID']; ?>" disabled>
                      <input type="text" name="invoiceID" id="invoiceID" value="<?php echo $row['InvoiceID']; ?>" hidden="true">
                    <?php
                    $subtotal = $row['Cost'];
                    $gtotal += $subtotal;
                    $total = sprintf('%0.2f', $gtotal);
                    ?>
                    </div>
                      <div class="col-12">
                        <label class="form-label">Total (₱)</label>
                        <input type="text" class="form-control" name="total" id="total" value="<?php echo $total; ?>" disabled>
                        <input type="text" class="form-control" name="total" id="total" value="<?php echo $total; ?>" hidden>
                      </div>

                      <div class="col-12">
                        <label class="form-label">Total Payment Recieved (₱)</label>
                        <input type="text" class="form-control" pattern="[0-9]+" name="payment" id="payment" required>
                      </div>

                </div>
                <br>
              <div align="center">
                <button type="submit" class="add-btn" name="submit" style="width: 100px;">SAVE</button>
                <a href="transaction.php" class="add-btn">CANCEL</a>
              </div>
              </form>
            </div>
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

  <script>
    $(function() {
      var dtToday = new Date();

      var month = dtToday.getMonth() + 1;
      var day = dtToday.getDate();
      var year = dtToday.getFullYear();
      if (month < 10)
        month = '0' + month.toString();
      if (day < 10)
        day = '0' + day.toString();

      var maxDate = year + '-' + month + '-' + day;
      $('#adate').attr('min', maxDate);
    });
  </script>

</body>

</html>