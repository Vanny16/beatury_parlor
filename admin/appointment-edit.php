<?php

session_start();
// error_reporting(0);
include('dbconnection.php');
$ID = $_SESSION['empid'];

if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
}
if (isset($_POST['submit'])) {
  $cid = $_GET['editid'];
  $adate = $_POST['adate'];
  $atime = $_POST['atime'];
  $stat = 'Re-Scheduled';
  $remark = $_POST['remark'];

  $sql = "SELECT * FROM tblappointments WHERE AptDate='$adate' AND AptTime='$atime' AND Remarks='$remark' AND Status='$stat' AND AptNum ='$cid'";
  $res = mysqli_query($con, $sql);

  if (mysqli_num_rows($res) > 0) {
    echo '<script>alert("No changes were made.")</script>';
  } else {
    $query = mysqli_query($con, "INSERT INTO tblaptremarks(Remarks, AptNum, AptDate, AptTime, AptStatus) VALUES ('$remark','$cid','$adate','$atime','$stat');");
    
    $query = mysqli_query($con, "UPDATE tblappointments SET AptDate='$adate', AptTime='$atime', Remarks='$remark', Status='$stat' where AptNum ='$cid'");
    if ($query) {
      echo '<script>alert(Appointment has been updated.")</script>';
      echo "<script type='text/javascript'> document.location ='appointment-view.php?viewid=$cid'; </script>";
    } else {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
  }
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
    <?php
    $cid = $_GET['editid'];
    $ret = mysqli_query($con, "select tblcustomers.FirstName, tblcustomers.LastName, tblcustomers.Email, tblcustomers.MobileNumber, tblappointments.AptID as bid, tblappointments.AptNum, tblappointments.AptDate,tblappointments.AptTime,tblappointments.Message,tblappointments.BookDate,tblappointments.Remarks,tblappointments.Status,tblappointments.RemarksDate from tblappointments join tblcustomers on tblcustomers.CustID=tblappointments.CustID where tblappointments.AptNum='$cid'");
    while ($row = mysqli_fetch_array($ret)) {
    ?>
      <div class="pagetitle">
        <h1>APPOINTMENTS</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="appointment.php">Appointments</a></li>
            <li class="breadcrumb-item"><a href="appointment-view.php?viewid=<?php echo htmlentities($row['AptNum']); ?>"> Appointment No. <?php echo $row['AptNum']; ?></a></li>

            <li class="breadcrumb-item active">Update</a></li>
          </ol>
        </nav>
      </div><!-- End Page Title -->

      <section class="section">
        <div class="row">
          <div class="col-lg">
            <div class="card">
              <div class="card-body">
                <div class="card-title">
                  <h3><b>UPDATE INFORMATION</b></h3>
                </div>

                <form method="POST" enctype="multipart/form-data">
                  <div class="row">
                    <div class="column">
                      <div class="row g-3">
                        <div class="col-12">
                          <label class="form-label">Appointment Number</label>
                          <input type="text" class="form-control" value="<?php echo $row['AptNum']; ?>" disabled>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Date</label>
                          <input type="date" class="form-control" name="adate" id='adate' value="<?php echo $row['AptDate']; ?>">
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Time</label>

                          <select class="form-select" name="atime" id='atime'>
                            <option value="<?php echo $row['AptTime']; ?>"> </option>
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
                      $cid = $_GET['editid'];
                      $ret = mysqli_query($con, "select tblcustomers.FirstName, tblcustomers.LastName, tblcustomers.Email, tblcustomers.MobileNumber, tblappointments.AptID as bid, tblappointments.AptNum, tblappointments.AptDate,tblappointments.AptTime,tblappointments.Message,tblappointments.BookDate,tblappointments.Remarks,tblappointments.Status,tblappointments.RemarksDate from tblappointments join tblcustomers on tblcustomers.CustID=tblappointments.CustID where tblappointments.AptNum='$cid'");
                      while ($row = mysqli_fetch_array($ret)) {
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
                          <label class="form-label" required="true">Remarks<i>*</i></label>
                          <textarea type="text" class="form-control" name="remark" rows="5" required="true"></textarea>
                        </div>

                        <div class="col-12">
                          <label class="form-label">Remarks Date</label>
                          <input type="text" class="form-control" value="<?php echo $row['RemarksDate']; ?>" disabled>
                        </div>

                      </div>
                    </div>
                  </div> <?php } ?>
                <div align="center">
                  <button type="submit" class="add-btn" name="submit">SAVE</button>
                  <a href="appointment-view.php?viewid=<?php echo htmlentities($cid); ?>" class="add-btn">CANCEL</a>
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