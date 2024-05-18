<?php
//database conection  file
include('dbconnection.php');
session_start();
error_reporting(0);
if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
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
  <?php
  $invid = intval($_GET['invoiceid']);
  $ret = mysqli_query($con, "SELECT DISTINCT date(tblinvoice.PostingDate) as invoicedate, 
							tblcustomers.CustID, tblcustomers.FirstName, tblcustomers.LastName, tblcustomers.Email, tblcustomers.MobileNumber,tblcustomers.CreationDate, tblserviceorder.CustomerID,
              tblserviceorder.soID, tblserviceorder.EmployeeID, tblserviceorder.InvoiceID, tblserviceorder.custType, tblserviceorder.Status,
              tblemployee.EmployeeID, tblemployee.FirstName as empFname, tblemployee.LastName as empLname
              FROM tblinvoice 
              JOIN tblserviceorder ON tblinvoice.InvoiceID = tblserviceorder.InvoiceID
              JOIN tblcustomers ON tblcustomers.CustID = tblserviceorder.CustomerID
              JOIN tblemployee ON tblserviceorder.EmployeeID=tblemployee.EmployeeID
              WHERE  tblserviceorder.InvoiceID='$invid' ");


  // join tblcustomers 
  // where tblinvoice.InvoiceID='$invid'");
  $cnt = 1;
  while ($row = mysqli_fetch_array($ret)) {

  ?>

    <main id="main" class="main">
      <div class="pagetitle">
        <h1>SERVICE ORDERS</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="transaction.php">Service Orders</a></li>
            <li class="breadcrumb-item"><a href="transaction-view.php?viewid=<?php echo htmlentities($row['soID']); ?>">Service Order No. <?php echo $row['soID']; ?></a></li>
            <li class="breadcrumb-item active">Invoice No. <?php echo $invid; ?></li>
          </ol>
        </nav>
      </div><!-- End Page Title -->
      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="card-title">
                  <h3><b>Invoice No. <?php echo $invid; ?></b></h3>
                </div>
                <table class="table table-bordered" width="100%" border="1">
                  <tr>
                    <th colspan="6">Customer Details</th>
                  </tr>
                  <tr>
                    <th>Name</th>
                    <td><?php echo $row['FirstName'] ?> <?php echo $row['LastName'] ?></td>
                    
                    <th>Email </th>
                    <td><?php echo $row['Email'] ?></td>
                  </tr>
                  <tr>
                  <th>Contact no.</th>
                    <td><?php echo $row['MobileNumber'] ?></td>
                    <th>Invoice Date</th>
                    <td colspan="3"><?php echo $row['invoicedate'] ?></td>
                  </tr>
                <?php } ?>
                </table>
                <table class="table table-bordered" width="100%" border="1">
                  <tr>
                    <th colspan="3">Services Details</th>
                  </tr>
                  <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Cost</th>
                  </tr>

                  <?php
                  $ret = mysqli_query($con, "select tblservices.ServiceName,tblservices.Cost  
                        from  tblinvoice 
                        join tblservices on tblservices.ID=tblinvoice.ServiceId 
                        where tblinvoice.InvoiceID='$invid'");
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($ret)) {
                  ?>

                    <tr>
                      <th><?php echo $cnt; ?></th>
                      <td><?php echo $row['ServiceName'] ?></td>
                      <td>₱<?php echo $row['Cost'] ?></td>
                    </tr>
                  <?php
                    $cnt = $cnt + 1;
                    $subtotal = $row['Cost'];
                    $gtotal += $subtotal;
                  } ?>

                  <tr>
                    <th colspan="2" style="text-align:center">Grand Total</th>
                    <th>₱<?php echo $gtotal ?></th>

                  </tr>
                </table>
                <div align="center">
                  <?php
                  $invid = intval($_GET['invoiceid']);
                  $getpaystat = mysqli_fetch_assoc(mysqli_query($con, "SELECT PaymentStatus FROM tblserviceorder WHERE InvoiceID='$invid'"));
                  $paystat = $getpaystat['PaymentStatus'];

                  if ($paystat != 'Paid') { ?>
                    <a href="payment.php?invid=<?php echo htmlentities($invid); ?>" class="add-btn">RECORD PAYMENT</a>
                  <?php } ?>
                  <a href="transaction.php" class="add-btn">BACK</a>
                </div>

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