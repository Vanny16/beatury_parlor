<?php
session_start();
error_reporting(0);
include('dbconnection.php');
$ID = $_SESSION['empid'];

if (isset($_POST['submit'])) {
  //getting the post values
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $contno = $_POST['contactno'];
  $email = $_POST['email'];
  $add = $_POST['address'];
  $password = md5($_POST['password']);

  $sql = "SELECT * FROM tblemployee WHERE Email='$email'";
  $sql1 = "SELECT * FROM tblemployee WHERE MobileNumber='$contno'";
  $res = mysqli_query($con, $sql);
  $res1 = mysqli_query($con, $sql1);


  if (mysqli_num_rows($res) > 0) {
    echo "<script>alert('Sorry! Email is already taken.');</script>";
  } else if (mysqli_num_rows($res1) > 0) {
    echo "<script>alert('Sorry! Mobile Number is already taken.');</script>";
  } else {

      // Query for data insertion
      $query = mysqli_query($con, "insert into tblemployee(FirstName,LastName, MobileNumber, Email, Password, Address) value('$fname','$lname', '$contno', '$email','$password','$add' )");
      if ($query) {

        echo "<script>alert('Employee has been added.');</script>";
        echo "<script>window.location.href = 'employee.php'</script>";
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
        <a class="nav-link" href="employee.php">
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
      <h1>EMPLOYEE</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="employee.php">Employee</a></li>
          <li class="breadcrumb-item active">Add New Employee</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg">
          <div class="card">
            <div class="card-body">
              <div class="card-title">
                <h3><b>ADD NEW EMPLOYEE</b></h3>
              </div>

              <form method="POST" name="add" onsubmit="return checkpass();" enctype="multipart/form-data">
                <div class="row">
                    <h4>Personal Information</h4>

                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label">First Name<i>*</i></label>
                        <input type="text" class="form-control" name="fname" required="true">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Last Name<i>*</i></label>
                        <input type="text" class="form-control" name="lname" required="true">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Mobile Number<i>*</i></label>
                        <input type="text" class="form-control" name="contactno" placeholder="09xxxxxxxxx" required="true" minlength="11" maxlength="11" pattern="[0-9]+">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Email<i>*</i></label>
                        <input type="email" class="form-control" name="email" placeholder="example@email.com"required="true">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Password<i>*</i></label>
                        <input type="password" class="form-control" name="password" placeholder="********"required="true">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Confirm Password<i>*</i></label>
                        <input type="password" class="form-control" name="repeatpassword" required="true">
                      </div>

                      <div class="col-12">
                        <label class="form-label">Address<i>*</i></label>
                        <textarea class="form-control" name="address" required="true"></textarea>
                      </div>

                  </div>

                </div> <br>
                <div align="center"><button type="submit" class="add-btn" name="submit" style="width: 100px;">Add</button>
                 <a type="button" href="employee.php" class="add-btn" name="submit">CANCEL</a>
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

  <script type="text/javascript">
    function checkpass() {
      if (document.add.password.value != document.add.repeatpassword.value) {
        alert('Password and Repeat Password field does not match');
        document.add.repeatpassword.focus();
        return false;
      }
      return true;
    }
  </script>

</body>

</html>