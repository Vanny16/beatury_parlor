<?php
session_start();
error_reporting(0);
include('dbconnection.php');
$ID = $_SESSION['empid'];

if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
}

if (isset($_GET['conid'])) {
  $cid = $_GET['conid'];
  $stat = 'Confirmed';

  $query = mysqli_query($con, "UPDATE tblappointments SET Status='$stat' where AptNum ='$cid'");
  if ($query) {
    echo '<script>alert(Appointment has been updated.")</script>';
    echo "<script type='text/javascript'> document.location ='appointment-view.php?viewid=$cid'; </script>";
  } else {
    echo '<script>alert("Something Went Wrong. Please try again")</script>';
  }
} else if (isset($_GET['comid'])) {
  $cid = $_GET['comid'];
  $stat = 'Completed';

  $query = mysqli_query($con, "UPDATE tblappointments SET Status='$stat' where AptNum ='$cid'");
  if ($query) {
    echo '<script>alert(Appointment has been updated.")</script>';
    echo "<script type='text/javascript'> document.location ='appointment-view.php?viewid=$cid'; </script>";
  } else {
    echo '<script>alert("Something Went Wrong. Please try again")</script>';
  }
}
else if (isset($_GET['noid'])) {
  $cid = $_GET['noid'];
  $stat = 'No Show';

  $query = mysqli_query($con, "UPDATE tblappointments SET Status='$stat' where AptNum ='$cid'");
  if ($query) {
    echo '<script>alert(Appointment has been updated.")</script>';
    echo "<script type='text/javascript'> document.location ='appointment-view.php?viewid=$cid'; </script>";
  } else {
    echo '<script>alert("Something Went Wrong. Please try again")</script>';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>


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

  <?php
  $cid = $_GET['viewid'];
  $ret = mysqli_query($con, "select tblcustomers.FirstName, tblcustomers.LastName, tblcustomers.Email, tblcustomers.MobileNumber, tblappointments.AptID as bid, tblappointments.AptNum, tblappointments.AptDate,tblappointments.AptTime,tblappointments.Message,tblappointments.BookDate,tblappointments.Remarks,tblappointments.Status,tblappointments.RemarksDate from tblappointments join tblcustomers on tblcustomers.CustID=tblappointments.CustID where tblappointments.AptNum='$cid'");
  while ($row = mysqli_fetch_array($ret)) {
  ?>

    <main id="main" class="main">

      <div class="pagetitle">
        <h1>APPOINTMENTS</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active"><a href="appointment.php">Appointments</a></li>
            <li class="breadcrumb-item active">Appointment No. <?php echo $row['AptNum']; ?></li>
          </ol>
        </nav>
      </div><!-- End Page Title -->

      <section class="section">
        <div class="row">
          <div class="col-lg">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex justify-content-between">
                  <h2><b>Appointment No. <?php echo $row['AptNum']; ?></b></h2>
                  <div>
                    <?php $stat = $row['Status'];
                    if (($stat == 'Confirmed')) { ?>

                      <a href="appointment-edit.php?editid=<?php echo htmlentities($cid); ?>" class="add-btn">EDIT</a>
                    <?php } ?>
                    <a href="appointment.php" class="add-btn">BACK</a>
                  </div>

                </div>

                <div class="row">
                  <div class="column">

                    <div class="row g-3">
                      <div class="col-12">
                        <label class="form-label">Appointment Number</label>
                        <input type="text" class="form-control" value="<?php echo $row['AptNum']; ?>" disabled>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Date</label>
                        <input type="text" class="form-control" value="<?php echo $row['AptDate']; ?>" disabled>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Time</label>
                        <input type="text" class="form-control" value="<?php echo $row['AptTime']; ?> " disabled>
                      </div>

                      <div class="col-12">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" value="<?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?>" disabled>
                      </div>
                    <?php } ?>

                    <div class="col-md-6">
                      <label class="form-label">Service/s</label>
                      <?php
                      $ret = mysqli_query($con, "SELECT tblservices.ID, tblservices.ServiceName, tblservices.Cost, tblaptservice.AptNum, tblaptservice.ServiceID from tblaptservice join tblservices on tblaptservice.ServiceID=tblservices.ID where tblaptservice.AptNum='$cid' ");
                      $row = mysqli_num_rows($ret);
                      while ($row = mysqli_fetch_array($ret)) {
                      ?>
                        <div class="form-check" required>
                          <input class="form-check-input" type="checkbox" id='lang[]' name='lang[]' value="<?php echo $row['ID']; ?>" checked disabled>
                          <label class="form-check-label" for="gridCheck1">
                            <?php echo $row['ServiceName'] . "  <i>₱" . $row['Cost']; ?></i>
                          </label>
                        </div>
                      <?php } ?>

                    </div>
                    <?php
                    $ret = mysqli_query($con, "select tblcustomers.FirstName, tblcustomers.LastName, tblcustomers.Email, tblcustomers.MobileNumber, tblappointments.AptID as bid, tblappointments.AptNum, tblappointments.AptDate,tblappointments.AptTime,tblappointments.Message,tblappointments.BookDate,tblappointments.Remarks,tblappointments.Status,tblappointments.RemarksDate from tblappointments join tblcustomers on tblcustomers.CustID=tblappointments.CustID where tblappointments.AptNum='$cid'");
                    
                    while ($row = mysqli_fetch_array($ret)) {
                      $stat = $row['Status'];
                    ?>

                      <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" value="<?php echo $row['Email']; ?>" disabled>
                      </div>

                      <div class="col-12">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" value="<?php echo $row['MobileNumber']; ?>" disabled>
                      </div>

                      <div class="col-12">
                        <label class="form-label">Creation Date</label>
                        <input type="text" class="form-control" value="<?php echo $row['BookDate']; ?>" disabled>
                      </div>

                    </div>
                  </div>

                  <div class="column">
                    <div class="row g-3">

                      <div class="col-12">
                        <label class="form-label">Status</label>
                        <input type="text" class="form-control" value="<?php echo $row['Status']; ?>" disabled>
                      </div>

                      <div class="col-12">
                        <label class="form-label">Message</label>
                        <textarea type="text" class="form-control" rows="3" disabled> <?php echo $row['Message']; ?></textarea>
                      </div>

                      <div class="col-12">
                        <label class="form-label">Remarks</label>
                        <textarea type="text" class="form-control" rows="5" disabled> <?php echo $row['Remarks']; ?></textarea>
                      </div>

                      <div class="col-12">
                        <label class="form-label">Remarks Date</label>
                        <input type="text" class="form-control" value="<?php echo $row['RemarksDate']; ?>" disabled>
                      </div>

                    </div>

                  </div>

                  <div align="center">
                    <?php if ($stat == 'Confirmed') { ?>
                      <a href="appointment-view.php?comid=<?php echo htmlentities($cid); ?>" class="add-btn">COMPLETED</a>
                      <a href="appointment-view.php?noid=<?php echo htmlentities($cid); ?>" class="add-btn">NO SHOW</a>
                    <?php } if ($stat == 'Completed') { ?>
                    <?php } if (($stat == 'Scheduled') || ($stat == 'Re-Scheduled')) { ?>
                      <a href="appointment-view.php?conid=<?php echo htmlentities($cid); ?>" class="add-btn">CONFIRM</a>
                      <a href="appointment-view.php?noid=<?php echo htmlentities($cid); ?>" class="add-btn">NO SHOW</a>
                    <?php } ?> 

                  </div>

                <?php } ?>

                </div>
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
                  REMARKS HISTORY
                </h5>
                <div class=" table-responsive">
                  <div class="table-wrapper">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Appointment Date</th>
                          <th>Appointment Time</th>
                          <th>Status</th>
                          <th>Remarks</th>
                          <th>Remarks Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $cid = $_GET['viewid'];
                        $ret = mysqli_query($con, "SELECT * FROM tblaptremarks WHERE AptNUm='$cid'");
                        $row = mysqli_num_rows($ret);
                        if ($row > 0) {
                          while ($row = mysqli_fetch_array($ret)) {
                        ?>
                            <!--Fetch the Records -->
                            <tr>
                              <td><?php echo $row['remarkID']; ?></td>
                              <td><?php echo $row['AptDate']; ?></td>
                              <td><?php echo $row['AptTime']; ?></td>
                              <td><?php echo $row['AptStatus']; ?></td>
                              <td><?php echo $row['Remarks']; ?></td>
                              <td><?php echo $row['RemarksDate']; ?></td>
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

</body>

</html>