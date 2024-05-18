<?php
//database conection  file
include('dbconnection.php');
session_start();
// error_reporting(0);
if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
}

if (isset($_GET['comid'])) {
  $cid = $_GET['comid'];
  $stat = 'Completed';

  $query = mysqli_query($con, "UPDATE tblserviceorder SET Status='$stat' where soID ='$cid'");
  if ($query) {
    echo '<script>alert(Appointment has been updated.")</script>';
    echo "<script type='text/javascript'> document.location ='transaction-view.php?viewid=$cid'; </script>";
  } else {
    echo '<script>alert("Something Went Wrong. Please try again")</script>';
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
  $cid = $_GET['viewid'];
  $ret = mysqli_query($con, "SELECT tblcustomers.CustID, tblcustomers.FirstName, tblcustomers.LastName, tblserviceorder.CustomerID, tblserviceorder.soID, tblserviceorder.EmployeeID, tblserviceorder.InvoiceID, tblserviceorder.custType, tblserviceorder.PaymentStatus, tblserviceorder.PaymentID, tblserviceorder.Status, tblserviceorder.CreationDate,tblemployee.EmployeeID, tblemployee.FirstName as empFname, tblemployee.LastName as empLname
        FROM tblserviceorder
        JOIN tblcustomers ON tblcustomers.CustID = tblserviceorder.CustomerID
        JOIN tblemployee ON tblserviceorder.EmployeeID=tblemployee.EmployeeID
        WHERE  tblserviceorder.soID='$cid' ");
  $row = mysqli_num_rows($ret);
  while ($row = mysqli_fetch_array($ret)) {
  ?>

    <main id="main" class="main">
      <div class="pagetitle">
        <h1>SERVICE ORDERS</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="transaction.php">Service Orders</a></li>
            <li class="breadcrumb-item active">Service Order No. <?php echo $cid ?> </a></li>
          </ol>
        </nav>
      </div><!-- End Page Title -->
      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex justify-content-between">
                  <h3><b>Service Order No. <?php echo $cid ?></b></h3>
                  <div>
                    <?php $stat = $row['Status'];
                    if ($stat != 'Completed') { ?>

                      <a href="transaction-edit.php?editid=<?php echo htmlentities($cid); ?>" class="add-btn">EDIT</a>
                    <?php } ?>
                    <a href="transaction.php" class="add-btn">BACK</a>
                  </div>
                </div>

                <form method="POST">

                  <div class="row g-3">

                    <div class="col-md-6">
                      <label class="form-label">Customer Type </label>

                      <input type="text" class="form-control" value="<?php echo $row['custType']; ?>" disabled>
                    </div>

                    <?php if (!empty($row['AptNum'])) { ?>
                      <div class="col-md-6">
                        <label class="form-label">Appointment Number</label>

                        <input type="text" class="form-control" value="<?php echo $row['AptNum']; ?>" disabled>
                      </div>

                    <?php } ?>
                    <div class="col-md-6">
                      <label class="form-label">Customer</label>

                      <input type="text" class="form-control" value="<?php echo $row['FirstName'] . " " . $row['LastName']; ?>" disabled>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Employee</label>
                      <input type="text" class="form-control" value="<?php echo $row['empFname'] . " " . $row['empLname']; ?>" disabled>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Service Order Status</label>
                      <input type="text" class="form-control" value="<?php echo $row['Status']; ?>" disabled>
                    </div>

                    <?php if(($row['PaymentStatus'])=='Unpaid') {?>
                      <div class="col-md-6">
                      <label class="form-label">Payment Status</label>
                      <input type="text" class="form-control" value="<?php echo $row['PaymentStatus']; ?>" disabled>
                    </div>
                    
                    <?php } else {?>

                      <div class="col-md-6">
                      <label class="form-label">Payment Status</label>
                      <input type="text" class="form-control" value="<?php echo $row['PaymentStatus']; ?>" disabled>
                    </div>
                    
                    <?php } ?>

                    

                    <div class="col-md-6">
                      <label class="form-label">Date Created</label>
                      <input type="text" class="form-control" value="<?php echo $row['CreationDate']; ?>" disabled>
                    </div>

                    <?php if (($row['Status']) == 'Completed') { ?>
                      <div class="col-md-6">
                        <label class="form-label">Invoice:</label> <i><a style="text-decoration: underline;" href="invoice.php?invoiceid=<?php echo htmlentities($row['InvoiceID']); ?>"><?php echo $row['InvoiceID'] ?></a></i>
                      </div>
                    <?php } ?>

                    <div class="col-lg-12">
                      <label class="form-label">Service/s</label>
                      <table class="table">
                        <thead>
                          <tr>
                            <th></th>
                            <th>Service</th>
                            <th>Price</th>
                            <th>Assigned Employee</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $ret = mysqli_query($con, "SELECT tblservices.ServiceName,tblservices.Cost  
                          from  tblinvoice 
                          join tblservices on tblservices.ID=tblinvoice.ServiceID 
                          where tblinvoice.soID='$cid'");

                          while ($row = mysqli_fetch_array($ret)) {
                          ?>

                            <tr>
                              <td><input type="checkbox" checked disabled></td>
                              <td><?php echo $row['ServiceName']; ?></td>
                              <td><?php echo "<i>₱" . $row['Cost'] . "</i>"; ?></td>
                              <td>Evelyn Ewayan</td>
                            </tr>
                        <?php
                          }
                        } ?>

                        </tbody>
                      </table>


                    </div>

                  </div>
                  <br>
                  <div align="center">
                    <?php
                    $cid = $_GET['viewid'];
                    $ret = mysqli_query($con, "SELECT tblcustomers.CustID, tblcustomers.FirstName, tblcustomers.LastName, tblserviceorder.CustomerID, tblserviceorder.soID, tblserviceorder.EmployeeID, tblserviceorder.InvoiceID, tblserviceorder.custType, tblserviceorder.PaymentStatus, tblserviceorder.Status, tblserviceorder.CreationDate,tblemployee.EmployeeID, tblemployee.FirstName as empFname, tblemployee.LastName as empLname
                      FROM tblserviceorder
                      JOIN tblcustomers ON tblcustomers.CustID = tblserviceorder.CustomerID
                      JOIN tblemployee ON tblserviceorder.EmployeeID=tblemployee.EmployeeID
                      WHERE  tblserviceorder.soID='$cid' ");
                    $row = mysqli_num_rows($ret);
                    while ($row = mysqli_fetch_array($ret)) {
                    ?>
                      <?php
                      $stat = $row['Status'];
                      $paystat = $row['PaymentStatus'];
                      
                      if ($stat == 'Ongoing') { ?>
                        <a href="transaction-view.php?comid=<?php echo htmlentities($cid); ?>" class="add-btn">MARK AS COMPLETED</a>
                      <?php } if ($stat == 'Completed') { ?>
                        <a href="invoice.php?invoiceid=<?php echo htmlentities($row['InvoiceID']); ?>" class="add-btn">VIEW INVOICE</a>
                      <?php } ?>

                      
                    <?php

                    }
                    ?>

                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="row">
          <div class="col-lg">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">
                  PAYMENT INFORMATION
                </h5>
                <div class=" table-responsive">
                  <div class="table-wrapper">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Total Amount</th>
                          <th>Total Payment</th>
                          <th>Employee Name</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $cid = $_GET['viewid'];
                        $getpaystat = mysqli_fetch_assoc(mysqli_query($con, "SELECT InvoiceID FROM tblserviceorder WHERE soID='$cid'"));
                        $invid = $getpaystat['InvoiceID'];
                        $ret = mysqli_query($con, "SELECT tblpayment.PaymentID, tblpayment.Total, tblpayment.Payment, tblpayment.PaymentDate, tblemployee.FirstName, tblemployee.LastName
                        FROM tblpayment
                        JOIN tblemployee ON tblpayment.EmployeeID=tblemployee.EmployeeID
                        WHERE tblpayment.InvoiceID='$invid'");
                        $row = mysqli_num_rows($ret);
                        if ($row > 0) {
                          while ($row = mysqli_fetch_array($ret)) {
                        ?>
                            <!--Fetch the Records -->
                            <tr>
                              <td><?php echo $row['PaymentID']; ?></td>
                              <td><?php echo $row['Total']; ?></td>
                              <td><?php echo $row['Payment']; ?></td>
                              <td><?php echo $row['FirstName']." ".$row['LastName']; ?></td>
                              <td><?php echo $row['PaymentDate']; ?></td>
                            </tr>
                          <?php
                          }
                        } else { ?>
                          <tr>
                            <th style="text-align:center; color: rgb(206, 2, 74);" colspan="7">No Record Found</th>
                          </tr>
                        <?php } ?>

                      </tbody>
                    </table>

                  </div>
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