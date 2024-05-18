<?php
//database conection  file
include('dbconnection.php');
error_reporting(0);
session_start();
if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {

    if (empty($_POST['custType'])) {
      echo '<script>alert("Please select customer type.")</script>';
    }
    else if (($_POST['aptserv']) == 0) {
      echo '<script>alert("Please select atleast one(1) service.")</script>';
    } 
    else {
      $stat = "Ongoing";
      $paystat = "Unpaid";
      $empid = $_SESSION['empid'];
      $custType = $_POST['custType'];

      if (!empty($_POST['AptNum'])) {
        $AptNum = $_POST['AptNum'];
        $aptservID = $_POST['aptserv'];
        $invoiceID = mt_rand(100000000, 999999999);


        $ret = mysqli_fetch_assoc(mysqli_query($con, "SELECT CustID from tblappointments where AptNum='$AptNum'; "));
        $CustID = $ret['CustID'];

        $query = mysqli_query($con, "INSERT into tblserviceorder(AptNum, EmployeeID, InvoiceID, CustomerID, Status, CustType, PaymentStatus) value('$AptNum','$empid','$invoiceID','$CustID','$stat','$custType', '$paystat')");

        if ($query) {
          $ret = mysqli_fetch_assoc(mysqli_query($con, "SELECT soID from tblserviceorder where InvoiceID='$invoiceID';"));
          $soID = $ret['soID'];

          for ($i = 0; $i < count($aptservID); $i++) {
            $svid = $aptservID[$i];
            $ret = mysqli_query($con, "INSERT into tblinvoice(InvoiceID,soID,ServiceID) values('$invoiceID','$soID','$svid');");
          }
          
          echo '<script>alert("Service order has been created!")</script>';
          echo "<script>window.location.href='transaction.php'</script>";
        } else {
          echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
      } else {
        $aptservID = $_POST['aptserv'];
        $CustID = $_POST['CustID'];
        $invoiceID = mt_rand(100000000, 999999999);

        $query = mysqli_query($con, "INSERT into tblserviceorder(EmployeeID, InvoiceID, CustomerID, Status, CustType, PaymentStatus) value('$empid','$invoiceID','$CustID','$stat','$custType','$paystat')");

        if ($query) {
          $ret = mysqli_fetch_assoc(mysqli_query($con, "SELECT soID from tblserviceorder where InvoiceID='$invoiceID';"));
          $soID = $ret['soID'];

          for ($i = 0; $i < count($aptservID); $i++) {
            $svid = $aptservID[$i];
            $ret = mysqli_query($con, "INSERT into tblinvoice(InvoiceID,soID,ServiceID) values('$invoiceID','$soID','$svid');");
          }

          echo '<script>alert("Service order has been created!")</script>';
          echo "<script>window.location.href='transaction.php'</script>";

        } else {
          echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
      }
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

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>SERVICE ORDERS</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="transaction.php">Service Orders</a></li>
          <li class="breadcrumb-item active">New Service Order</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="card-title">
                <h3><b>New Service Order</b></h3>
              </div>

              <form method="POST">

                <div class="row g-3">

                  <div class="col-lg-12">
                    <label class="form-label" style="margin-right: 1em;">Customer Type<i>*</i> </label>

                    <script type="text/javascript">
                      function yesnoCheck() {
                        if (document.getElementById('custType1').checked) {
                          document.getElementById('ifYes').style.display = 'block';
                          document.getElementById('ifNo').style.display = 'none';
                          document.getElementById('AptNum').setAttribute('required', '');
                          document.getElementById('CustID').removeAttribute('required');
                        } else if (document.getElementById('custType2').checked) {
                          document.getElementById('ifNo').style.display = 'block';
                          document.getElementById('ifYes').style.display = 'none';
                          document.getElementById('CustID').setAttribute('required', '');
                          document.getElementById('AptNum').removeAttribute('required');
                        }

                      }
                    </script>
                    <input class="form-check-input" type="radio" name="custType" id="custType1" value="Appointment" onclick="javascript:yesnoCheck();">
                    <label class="form-check-label" for="custType1"> Appointment</label>

                    <input class="form-check-input" type="radio" name="custType" id="custType2" value="Walk-In" onclick="javascript:yesnoCheck();">
                    <label class="form-check-label" for="custType2"> Walk-In</label>
                  </div>

                  <div class="col-lg-12" id="ifYes" style="display:none">
                    <label class="form-label">Appointment Number<i>*</i></label>

                    <select class="form-select" name="AptNum" id="AptNum">
                      <option></option>
                      <?php
                      $sql = "SELECT tblappointments.AptNum, tblappointments.CustID, tblcustomers.CustID, tblcustomers.FirstName, tblcustomers.LastName
                        FROM tblappointments
                        JOIN tblcustomers
                        ON tblcustomers.CustID=tblappointments.CustID;";
                      $query = mysqli_query($con, $sql);

                      while ($row = mysqli_fetch_assoc($query)) {
                        $FullName = $row['FirstName'] . " " . $row['LastName'];
                      ?>
                        <option value="<?php echo $row['AptNum']; ?>">#<?php echo $row['AptNum'] . " -  " . $FullName; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-lg-12" id="ifNo" style="display:none">
                    <label class="form-label">Customer<i>*</i></label>

                    <select class="form-select" name="CustID" id="CustID">
                      <option></option>
                      <?php
                      $sql = "SELECT * FROM tblcustomers";
                      $query = mysqli_query($con, $sql);

                      while ($row = mysqli_fetch_assoc($query)) {
                        $FullName = $row['FirstName'] . " " . $row['LastName'];
                      ?>
                        <option value="<?php echo $row['CustID']; ?>">
                          ID#<?php echo $row['CustID'] . " -  " . $FullName; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-lg-12">
                    <label class="form-label">Service/s<i>*</i></label>
                    <!-- START -->
                  <table class="table" >
									<thead>
										<tr>
											<th></th>
											<th>Service</th>
											<th>Price</th>
                      <th>Employee</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$ret = mysqli_query($con, "select *from  tblservices");
										$cnt = 1;
										while ($row = mysqli_fetch_array($ret)) {

										?>

											<tr>
                        <input class="form-check-input" type="checkbox" id='aptserv[]' name='aptserv[]' value="0" disabled hidden>
												<td><input type="checkbox" id='aptserv[]' name='aptserv[]' value="<?php echo$row['ID']; ?>"></td>
												<td><?php echo $row['ServiceName']; ?></td>
												<td><?php echo "<i>₱" .$row['Cost']."</i>"; ?></td>
                        <td><select name="" class="form-control" id=""></select></td>
											</tr>
										<?php
										} ?>

									</tbody>
								</table>

                  </div>

                </div>
                <br>
                <div align="center">
                  <button type="submit" class="add-btn" name="submit" style="width: 100px;">BOOK</button>
                  <a href="transaction.php" class="add-btn" name="submit">CANCEL</a>
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