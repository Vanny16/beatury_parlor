<?php
session_start();
error_reporting(0);
include('dbconnection.php');
$ID = $_SESSION['empid'];

include('head.php');

if (isset($_POST['submit'])) {
  $eid = $_GET['editid'];
  //getting the post values
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $fullname = $_POST['fname'] . " " . $_POST['lname'];
  $contno = $_POST['contactno'];
  $email = $_POST['email'];
  $add = $_POST['address'];

  $sql0 = "SELECT * FROM tblcustomers WHERE FirstName='$fname' AND LastName='$lname' AND MobileNumber='$contno' AND Email='$email' AND Address='$add' AND CustID='$eid'";

  $sql1 = "SELECT * FROM tblcustomers WHERE MobileNumber='$contno' AND CustID='$eid'";
  $sql2 = "SELECT * FROM tblcustomers WHERE Email='$email'AND CustID='$eid'";

  $sql3 = "SELECT * FROM tblcustomers WHERE MobileNumber='$contno'";
  $sql4 = "SELECT * FROM tblcustomers WHERE Email='$email'";

  $res0 = mysqli_query($con, $sql0);

  $res1 = mysqli_query($con, $sql1);
  $res2 = mysqli_query($con, $sql2);

  $res3 = mysqli_query($con, $sql3);
  $res4 = mysqli_query($con, $sql4);

  if (mysqli_num_rows($res0) > 0) {
    echo "<script>alert('No changes were made.');</script>";
  } else {

    if (mysqli_num_rows($res1) > 0) { // If the same MobileNUmber
      if (mysqli_num_rows($res2) > 0) { // If the same MobileNUmber, and the same Email
        // Query for data insertion
        $query = mysqli_query($con, "UPDATE  tblcustomers set FirstName='$fname',LastName='$lname', MobileNumber='$contno', Email='$email', Address='$add' where CustID='$eid'");
        if ($query) {
          echo "<script>alert('You have successfully updated $fullname.');</script>";
          echo "<script type='text/javascript'> document.location ='customer.php'; </script>";
        } else {
          echo "<script>alert('Something Went Wrong. Please try again');</script>";
        }
      } else if (mysqli_num_rows($res4) > 0) // If the same MobileNUmber, but not the same Email: email is already taken
      {
        echo "<script>alert('Sorry! Email already taken.');</script>";
      } else // If the same MobileNUmber, but not the same Email: email is not yet taken
      {
        // Query for data insertion
        $query = mysqli_query($con, "update  tblcustomers set FirstName='$fname',LastName='$lname', MobileNumber='$contno', Email='$email', Address='$add' where CustID='$eid'");
        if ($query) {
          echo "<script>alert('You have successfully updated $fullname.');</script>";
          echo "<script type='text/javascript'> document.location ='customer.php'; </script>";
        } else {
          echo "<script>alert('Something Went Wrong. Please try again');</script>";
        }
      }
    } else if (mysqli_num_rows($res3) > 0) {
      echo "<script>alert('Sorry! MobileNumber is already taken.');</script>";
    } else {
      if (mysqli_num_rows($res2) > 0) { // If the same MobileNUmber, and the same Email
        // Query for data insertion
        $query = mysqli_query($con, "UPDATE  tblcustomers set FirstName='$fname',LastName='$lname', MobileNumber='$contno', Email='$email', Address='$add' where CustID='$eid'");
        if ($query) {

          echo "<script>alert('You have successfully updated $fullname.');</script>";
          echo "<script type='text/javascript'> document.location ='customer.php'; </script>";
        } else {
          echo "<script>alert('Something Went Wrong. Please try again');</script>";
        }
      } else if (mysqli_num_rows($res4) > 0) // If the same MobileNUmber, but not the same Email: email is already taken
      {
        echo "<script>alert('Sorry! Email already taken.');</script>";
      } else // If the same MobileNUmber, but not the same Email: email is not yet taken
      {
        // Query for data insertion
        $query = mysqli_query($con, "update  tblcustomers set FirstName='$fname',LastName='$lname', MobileNumber='$contno', Email='$email', Address='$add' where CustID='$eid'");
        if ($query) {
          echo "<script>alert('You have successfully updated $fullname.');</script>";
          echo "<script type='text/javascript'> document.location ='customer.php'; </script>";
        } else {
          echo "<script>alert('Something Went Wrong. Please try again');</script>";
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
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
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
        <a class="nav-link collapsed" href="appointment.php">
          <i class="bi bi-calendar-week"></i>
          <span>Appointments</span>
        </a>
      </li><!-- End Appointments Nav -->

      <li class="nav-item">
        <a class="nav-link" href="customer.php">
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
    $eid = $_GET['editid'];
    $ret = mysqli_query($con, "select * from tblcustomers where CustID='$eid'");
    while ($row = mysqli_fetch_array($ret)) {
    ?>
      <div class="pagetitle">
        <h1>CUSTOMERS</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="customer.php">Customers</a></li>
            <li class="breadcrumb-item"><a href="customer-view.php?viewid=<?php echo htmlentities($row['CustID']); ?>"> <?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?></a></li>

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
                    <div class="column left">
                      <div align="center">
                        <h3><?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?></h3>
                        <?php if (($row['ProfilePic']) == 0) { ?>
                          <img src="../profilepics/default-avatar.png" style="max-height: 200px;" alt="Profile" class="rounded-circle">
                        <?php } else { ?>
                          <img class="update-img" alt="Profile" class="rounded-circle" src="../profilepics/<?php echo $row['ProfilePic']; ?>">
                        <?php } ?>
                        <br><br>
                        <input type="file" class="form-control" name="upload_image" id="upload_image" accept="image/*" />
                        <div id="uploaded_image"></div>
                      </div>
                    </div>
                    <div class="column right">
                      <h4>Personal Information</h4>

                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label">First Name<i>*</i></label>
                          <input type="text" class="form-control" name="fname" value="<?php echo $row['FirstName']; ?>" required="true">
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Last Name<i>*</i></label>
                          <input type="text" class="form-control" name="lname" value="<?php echo $row['LastName']; ?>" required="true">
                        </div>

                        <div class="col-12">
                          <label class="form-label">Mobile Number<i>*</i></label>
                          <input type="text" class="form-control" name="contactno" value="<?php echo $row['MobileNumber']; ?>" required="true" minlength="11" maxlength="11" pattern="[0-9]+">
                        </div>

                        <div class="col-12">
                          <label class="form-label">Email<i>*</i></label>
                          <input type="email" class="form-control" name="email" value="<?php echo $row['Email']; ?>" required="true">
                        </div>

                        <div class="col-12">
                          <label class="form-label">Address<i>*</i></label>
                          <textarea class="form-control" name="address" required="true"><?php echo $row['Address']; ?></textarea>
                        </div>

                      </div>
                    </div>
                    <div id="uploadimageModal" class="modal" role="dialog">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Profile Picture</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body" align="center">
                            <div class="col-md-8 text-center">
                              <div id="image_demo" style="width:100%;"></div>
                            </div>
                            <div class="col-md-4" style="padding-top:30px;">
                              <button class="add-btn crop_image">Save Image</button>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <script>
                      $(document).ready(function() {

                        $image_crop = $('#image_demo').croppie({
                          enableExif: true,
                          viewport: {
                            width: 200,
                            height: 200,
                            type: 'circle'
                          },
                          boundary: {
                            width: 300,
                            height: 300
                          }
                        });

                        $('#upload_image').on('change', function() {
                          var reader = new FileReader();
                          reader.onload = function(event) {
                            $image_crop.croppie('bind', {
                              url: event.target.result
                            }).then(function() {
                              console.log('jQuery bind complete');
                            });
                          }
                          reader.readAsDataURL(this.files[0]);
                          $('#uploadimageModal').modal('show');
                        });

                        $('.crop_image').click(function(event) {
                          $image_crop.croppie('result', {
                            type: 'canvas',
                            size: 'viewport'
                          }).then(function(response) {
                            $.ajax({
                              url: "customer-upload.php?editid=<?php echo htmlentities($row['CustID']); ?>",
                              type: "POST",
                              data: {
                                "image": response
                              },
                              success: function(data) {
                                $('#uploadimageModal').modal('hide');
                                $('#uploaded_image').html(data);
                              }
                            });
                          })
                        });

                      });
                    </script>

                  </div>
                  <div align="center">
                    <button type="submit" class="add-btn" name="submit">SAVE CHANGES</button>
                    <a href="customer-view.php?viewid=<?php echo htmlentities($eid); ?>" class="add-btn">CANCEL</a>
                  </div>
                <?php } ?>
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

</body>

</html>