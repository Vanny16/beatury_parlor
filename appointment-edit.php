<?php
//Databse Connection file
session_start();
error_reporting(0);
include('dbconnection.php');
if (strlen($_SESSION['bpmsuid'] == 0)) {
  header('location:logout.php');
} else {
  $ID = $_SESSION['bpmsuid'];

  if (isset($_POST['submit'])) {
    $cid = $_GET['editid'];

    if (($_POST['aptserv']) <> 0) { // if updated service
      $aptservID = $_POST['aptserv'];
      $ret = mysqli_query($con, "DELETE FROM tblaptservice WHERE AptNum='$cid';");
      for ($i = 0; $i < count($aptservID); $i++) {
        $svid = $aptservID[$i];
        $ret = mysqli_query($con, "INSERT into tblaptservice(AptNum,ServiceID) values('$cid','$svid');");
      }
      $adate = $_POST['adate'];
      $atime = $_POST['atime'];
      $stat = $_POST['stat'];
      $message = $_POST['message'];

      $sql = "SELECT * FROM tblappointments WHERE AptDate='$adate' AND AptTime='$atime' AND Status='$stat' AND AptNum ='$cid'";
      $res = mysqli_query($con, $sql);

      $sql1 = "SELECT * FROM tblappointments WHERE Message='$message' AND AptNum ='$cid'";
      $res1 = mysqli_query($con, $sql);
        if (mysqli_num_rows($res1) > 0) {
          $query = mysqli_query($con, "UPDATE tblappointments SET AptDate='$adate', AptTime='$atime', where AptNum ='$cid'");
          if ($query) {
            echo '<script>alert("Appointment has been updated.")</script>';
            echo "<script type='text/javascript'> document.location ='users-profile.php?'; </script>";
          } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
          }
        } else {
          $query = mysqli_query($con, "UPDATE tblappointments SET AptDate='$adate', AptTime='$atime', Message='$message', Status='$stat' where AptNum ='$cid'");
          if ($query) {
            echo '<script>alert("Appointment has been updated.")</script>';
            echo "<script type='text/javascript'> document.location ='users-profile.php?'; </script>";
          } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
          }
        }
    }
    else //if info updated but not service
    {
      $adate = $_POST['adate'];
      $atime = $_POST['atime'];
      $stat = $_POST['stat'];
      $message = $_POST['message'];

      $sql = "SELECT * FROM tblappointments WHERE AptDate='$adate' AND AptTime='$atime' AND Status='$stat' AND AptNum ='$cid'";
      $res = mysqli_query($con, $sql);

      $sql1 = "SELECT * FROM tblappointments WHERE Message='$message' AND AptNum ='$cid'";
      $res1 = mysqli_query($con, $sql);

      if (mysqli_num_rows($res) > 0) {
        echo '<script>alert("No changes were made.")</script>';
      } else {
        if (mysqli_num_rows($res1) > 0) {
          $query = mysqli_query($con, "UPDATE tblappointments SET AptDate='$adate', AptTime='$atime', where AptNum ='$cid'");
          if ($query) {
            echo '<script>alert("Appointment has been updated.")</script>';
            echo "<script type='text/javascript'> document.location ='users-profile.php?'; </script>";
          } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
          }
        } else {
          $query = mysqli_query($con, "UPDATE tblappointments SET AptDate='$adate', AptTime='$atime', Message='$message', Status='$stat' where AptNum ='$cid'");
          if ($query) {
            echo '<script>alert("Appointment has been updated.")</script>';
            echo "<script type='text/javascript'> document.location ='users-profile.php?'; </script>";
          } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
          }
        }
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
          <li class="breadcrumb-item active">Update Appointment</a></li>
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
        <?php
        $cid = $_GET['editid'];
        $ret = mysqli_query($con, "SELECT * FROM tblappointments WHERE AptNum='$cid'");
        while ($row = mysqli_fetch_array($ret)) {
        ?>
          <div class="col-xl-8">
            <div class="card">
              <div class="card-body">
                <div class="card-title">
                  <h3><b> Appointment No. <?php echo $row['AptNum']; ?></b></h3>
                </div>

                <form method="POST" enctype="multipart/form-data">

                  <div class="row g-3">

                    <div class="col-md-6">
                      <label class="form-label">Customer</label>

                      <?php
                      $sql = "SELECT * FROM tblcustomers WHERE CustID=$ID";
                      $query = mysqli_query($con, $sql);

                      while ($row = mysqli_fetch_assoc($query)) {
                        $FullName = $row['FirstName'] . " " . $row['LastName'];
                      ?>
                        <input class="form-control" name="uid" id="uid" value="<?php echo $FullName; ?>" disabled> <?php } ?>

                    </div>
                    <?php
                    $cid = $_GET['editid'];
                    $ret = mysqli_query($con, "SELECT * FROM tblappointments WHERE AptNum='$cid'");
                    while ($row = mysqli_fetch_array($ret)) {
                    ?>

                      <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <input class="form-control" name="uid" id="uid" value="<?php echo $row['Status']; ?>" disabled>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="adate" id='adate' value="<?php echo $row['AptDate']; ?>">

                        <select class="form-select" name="stat" id='stat' hidden>
                          <option value="Re-Scheduled" selected>Re-Scheduled</option>
                        </select>
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

                      <div class="col-md-6">
                        <label class="form-label">Service/s</label>
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
                        <textarea class="form-control" id="message" name="message"><?php echo $row['Message']; ?></textarea>
                      </div>

                  </div>
                  <br> <?php } ?>
                <div align="center">
                  <button type="submit" class="add-btn" name="submit" style="width: 150px;">SAVE CHANGES</button>
                  <a type="button" class="add-btn" href="users-profile.php">CANCEL</a>
                </div>
              <?php } ?>
                </form>
              </div>
            </div>
          </div>
      </div>
    </section>

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

</body>

</html>