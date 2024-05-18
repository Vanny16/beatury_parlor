<?php
session_start();
error_reporting(0);
include('dbconnection.php');
if (strlen($_SESSION['bpmsuid'] == 0)) {
  header('location:logout.php');
} else {
  $ID = $_SESSION['bpmsuid'];
  if (isset($_POST['submit'])) {

    if (($_POST['aptserv']) == 0) {
      echo '<script>alert("Please select atleast one(1) service.")</script>';
      echo "<script>window.location.href='appointment-add.php'</script>";
    } else {
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

      $query = mysqli_query($con, "INSERT into tblappointments(CustID,AptNum,AptDate,AptTime,Message,Status) value('$ID','$aptnumber','$adate','$atime','$msg','$stat')");

      if ($query) {
        $ret = mysqli_query($con, "SELECT AptNum from tblappointments where tblappointments.CustID='$ID' order by AptID desc limit 1;");
        $result = mysqli_fetch_array($ret);
        $_SESSION['aptno'] = $result['AptNum'];

        echo "<script>alert('Your Appointment No. $aptnumber has been scheduled.');</script>";
        echo "<script>window.location.href='users-profile.php'</script>";
      } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
      }
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
  <link href="assets/css/cust-profile.css" rel="stylesheet">
  <link href="assets/css/index-style.css" rel="stylesheet">


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
</head>

<body>
  <?php include('header-cust') ?>
  <main id="main" class="main">
    <br><br>
    <div class="pagetitle">
      <h1>APPOINTMENTS</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="users-profile.php">My Profile</a></li>
          <li class="breadcrumb-item active">New Appointment</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <?php
              $ret = mysqli_query($con, "SELECT * from tblcustomers where CustID =$ID");
              while ($row = mysqli_fetch_array($ret)) {
                if (isset($row['ProfilePic'])) { ?>
                  <img src="profilepics/<?php echo $row['ProfilePic']; ?>" alt="Profile" class="rounded-circle">
                <?php
                } else { ?>
                  <img src="profilepics/default-avatar.png" style="max-height: 120px;" alt="Profile" class="rounded-circle">
                <?php } ?>
                <h2><?php echo $row['FirstName'] . " " . $row['LastName']; ?> </h2> <br>
                <p>Date Created: <?php echo $row['CreationDate']; ?> </p>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="col-xl-8">
          <div class="card">
            <div class="card-body">
              <div class="card-title">
                <h3><b>Book New Appointment</b></h3>
              </div>

              <form method="POST" enctype="multipart/form-data">

                <div class="row g-3">

                  <div class="col-12">
                    <label class="form-label">Customer</label>

                    <?php
                    $sql = "SELECT * FROM tblcustomers WHERE CustID=$ID";
                    $query = mysqli_query($con, $sql);

                    while ($row = mysqli_fetch_assoc($query)) {
                      $FullName = $row['FirstName'] . " " . $row['LastName'];
                    ?>
                      <input class="form-control" name="uid" id="uid" value="<?php echo $FullName; ?>" disabled>
                    <?php } ?>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Date<i>*</i></label>
                    <input type="date" class="form-control appointment_date" name="adate" id='adate' required="true">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Time<i>*</i></label>

                    <select class="form-select" name="atime" id='atime' required>
                      <option></option>
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
                  <a type="button" class="add-btn" href="users-profile.php#appointment.php">CANCEL</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>


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