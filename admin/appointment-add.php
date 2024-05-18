<?php
session_start();
error_reporting(0);
include('dbconnection.php');
$ID = $_SESSION['empid'];

if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {

    if (($_POST['aptserv']) == 0) {
      echo '<script>alert("Please select atleast one(1) service.")</script>';
      echo "<script>window.location.href='appointment-add.php'</script>";
    } else {
      $uid = $_POST['uid'];
      $aptservID = $_POST['aptserv'];
      $adate = $_POST['adate'];
      $atime = $_POST['atime'];
      $msg = $_POST['message'];
      $stat = "Scheduled";
      $aptnumber = mt_rand(100000000, 999999999);

      for ($i = 0; $i < count($aptservID); $i++) {
        $svid = $aptservID[$i];
        $ret = mysqli_query($con, "INSERT into tblaptservice(AptNum,ServiceID) values('$aptnumber','$svid');");
      }

      $query = mysqli_query($con, "insert into tblappointments(CustID,AptNum,AptDate,AptTime,Message,Status) value('$uid','$aptnumber','$adate','$atime','$msg','$stat')");

      if ($query) {
        $ret = mysqli_query($con, "SELECT AptNum from tblappointments where tblappointments.CustID='$uid' order by AptID desc limit 1;");
        $result = mysqli_fetch_array($ret);
        $_SESSION['aptno'] = $result['AptNum'];
        
        echo "<script>alert('Appointment No. $aptnumber has been booked.')</script>";
        echo "<script>window.location.href='appointment.php'</script>";
      } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
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
        <a class="nav-link" href="appointment.php">
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

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>APPOINTMENTS</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="appointment.php">Appointments</a></li>
          <li class="breadcrumb-item active">New Appointment</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <div class="card-title">
                <h3><b>Book New Appointment</b></h3>
              </div>

              <form method="POST" enctype="multipart/form-data">

                <div class="row g-3">

                  <div class="col-12">
                    <label class="form-label">Customer<i>*</i></label>

                    <select class="form-select" name="uid" id="uid" required>

                      <option value=""></option>
                      <?php
                      $sql = "SELECT * FROM tblcustomers";
                      $query = mysqli_query($con, $sql);

                      while ($row = mysqli_fetch_assoc($query)) {
                        $FullName = $row['FirstName'] . " " . $row['LastName'];
                      ?>
                        <option value="<?php echo $row['CustID']; ?>">
                          ID#<?php echo $row['CustID'] ." -  ". $FullName; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Date<i>*</i></label>
                    <input type="date" class="form-control appointment_date" name="adate" id='adate' required="true">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Time<i>*</i></label>

                    <select class="form-select" name="atime" id='atime' required>
                      <option value=""></option>
                      <option value="8:00AM">8:00AM</option>
                      <option value="9:00AM">9:00AM</option>
                      <option value="10:00AM">10:00AM</option>
                      <option value="11:00AM">11:00AM</option>
                      <option value="1:00PM">1:00PM</option>
                      <option value="2:00PM">2:00PM</option>
                      <option value="3:00PM">3:00PM</option>
                      <option value="4:00PM">4:00PM</option>
                      <option value="5:00PM">5:00PM</option>
                      <option value="6:00PM">6:00PM</option>

                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Service/s<i>*</i></label>
                    <input class="form-check-input" type="checkbox" id='aptserv[]' name='aptserv[]' value="0" disabled hidden>
                    <?php
                    $ret = mysqli_query($con, "SELECT * from tblservices");
                    $row = mysqli_num_rows($ret);
                    if ($row > 0) {
                      while ($row = mysqli_fetch_array($ret)) {
                    ?>
                        <div class="form-checkbox-group" required>
                          <input class="form-check-input" type="checkbox" id='aptserv[]' name='aptserv[]' value="<?php echo $row['ID']; ?>">
                          <label class="form-check-label" for="gridCheck1">
                            <?php echo $row['ServiceName'] . "  <i>₱" . $row['Cost']; ?></i>
                          </label>
                        </div>
                    <?php }
                    } ?>

                  </div>

                  <div class="col-12">
                    <label class="form-label">Message<i></i></label>
                    <textarea class="form-control" id="message" name="message"></textarea>
                  </div>

                </div>
                <br>
                <div align="center">
                  <button type="submit" class="add-btn" name="submit" style="width: 100px;">BOOK</button>
                  <a href="appointment.php" class="add-btn" name="submit">CANCEL</a>
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