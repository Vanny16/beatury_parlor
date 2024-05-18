<?php session_start();
error_reporting(0);
include('dbconnection.php');
$ID = $_SESSION['empid'];

if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_GET['delid'])) {
    $sid = $_GET['delid'];
    mysqli_query($con, "DELETE from tblappointments where AptNum ='$sid'");
    echo "<script>alert('Data Deleted');</script>";
    echo "<script>window.location.href='admin-profile.php'</script>";
  }

  if (isset($_GET['delpicid'])) {
    $rid = intval($_GET['delpicid']);
    $profilepic = $_GET['ppic'];
    $ppicpath = "../profilepics" . "/" . $profilepic;
    $sql = mysqli_query($con, "UPDATE tblemployee SET ProfilePic=NULL  where EmployeeID=$rid");
    unlink($ppicpath);
    echo "<script>alert('Profile picture has been deleted.');</script>";
    echo "<script>window.location.href='admin-profile.php'</script>";
  }

  if (isset($_POST['submit'])) {
    $eid = $ID;
    //getting the post values
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $fullname = $_POST['fname'] . " " . $_POST['lname'];
    $contno = $_POST['contactno'];
    $email = $_POST['email'];
    $add = $_POST['address'];

    $sql0 = "SELECT * FROM tblemployee WHERE FirstName='$fname' AND LastName='$lname' AND MobileNumber='$contno' AND Email='$email' AND Address='$add' AND EmployeeID='$eid'";

    $sql1 = "SELECT * FROM tblemployee WHERE MobileNumber='$contno' AND EmployeeID='$eid'";
    $sql2 = "SELECT * FROM tblemployee WHERE Email='$email'AND EmployeeID='$eid'";

    $sql3 = "SELECT * FROM tblemployee WHERE MobileNumber='$contno'";
    $sql4 = "SELECT * FROM tblemployee WHERE Email='$email'";

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
          $query = mysqli_query($con, "UPDATE  tblemployee set FirstName='$fname',LastName='$lname', MobileNumber='$contno', Email='$email', Address='$add' where EmployeeID='$eid'");
          if ($query) {
            echo "<script>alert('You have successfully updated $fullname.');</script>";
            echo "<script type='text/javascript'> document.location ='admin-profile.php'; </script>";
          } else {
            echo "<script>alert('Something Went Wrong. Please try again');</script>";
          }
        } else if (mysqli_num_rows($res4) > 0) // If the same MobileNUmber, but not the same Email: email is already taken
        {
          echo "<script>alert('Sorry! Email already taken.');</script>";
        } else // If the same MobileNUmber, but not the same Email: email is not yet taken
        {
          // Query for data insertion
          $query = mysqli_query($con, "update  tblemployee set FirstName='$fname',LastName='$lname', MobileNumber='$contno', Email='$email', Address='$add' where EmployeeID='$eid'");
          if ($query) {
            echo "<script>alert('You have successfully updated $fullname.');</script>";
            echo "<script type='text/javascript'> document.location ='admin-profile.php'; </script>";
          } else {
            echo "<script>alert('Something Went Wrong. Please try again');</script>";
          }
        }
      } else if (mysqli_num_rows($res3) > 0) {
        echo "<script>alert('Sorry! MobileNumber is already taken.');</script>";
      } else {
        if (mysqli_num_rows($res2) > 0) { // If the same MobileNUmber, and the same Email
          // Query for data insertion
          $query = mysqli_query($con, "UPDATE  tblemployee set FirstName='$fname',LastName='$lname', MobileNumber='$contno', Email='$email', Address='$add' where EmployeeID='$eid'");
          if ($query) {

            echo "<script>alert('You have successfully updated $fullname.');</script>";
            echo "<script type='text/javascript'> document.location ='admin-profile.php'; </script>";
          } else {
            echo "<script>alert('Something Went Wrong. Please try again');</script>";
          }
        } else if (mysqli_num_rows($res4) > 0) // If the same MobileNUmber, but not the same Email: email is already taken
        {
          echo "<script>alert('Sorry! Email already taken.');</script>";
        } else // If the same MobileNUmber, but not the same Email: email is not yet taken
        {
          // Query for data insertion
          $query = mysqli_query($con, "update  tblemployee set FirstName='$fname',LastName='$lname', MobileNumber='$contno', Email='$email', Address='$add' where EmployeeID='$eid'");
          if ($query) {
            echo "<script>alert('You have successfully updated $fullname.');</script>";
            echo "<script type='text/javascript'> document.location ='admin-profile.php'; </script>";
          } else {
            echo "<script>alert('Something Went Wrong. Please try again');</script>";
          }
        }
      }
    }
  }

  if (isset($_POST['changepass'])) {
    $eid = $ID;
    //getting the post values
    $curpass = md5($_POST['currentPassword']);
    $newpass = md5($_POST['newpassword']);
    $renewpass = md5($_POST['renewpassword']);

    $sql0 = "SELECT Password FROM tblemployee WHERE Password='$curpass' AND EmployeeID='$eid'";
    $res0 = mysqli_query($con, $sql0);

    if (mysqli_num_rows($res0) > 0) {
      if ($newpass == $renewpass) {
        // Query for data insertion
        $query = mysqli_query($con, "UPDATE  tblemployee set Password='$newpass' WHERE EmployeeID='$eid'");
        if ($query) {
          echo "<script>alert('You have successfully updated your password.');</script>";
          echo "<script type='text/javascript'> document.location ='admin-profile.php'; </script>";
        } else {
          echo "<script>alert('Something Went Wrong. Please try again');</script>";
        }
      } else {
        echo "<script>alert('New password does not match. Please re-enter.');</script>";
      }
    } else {
      echo "<script>alert('Current password is incorrect.');</script>";
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

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">

      <a href="index.php"><img class="logo" src="assets/img/logo-b.png" alt=""></a>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown">
          <?php
          $ret1 = mysqli_query($con, "SELECT tblcustomers.FirstName, tblcustomers.LastName, tblappointments.AptNum from tblappointments join tblcustomers on tblcustomers.CustID=tblappointments.CustID WHERE tblappointments.Status='Scheduled' OR tblappointments.Status='Re-Scheduled'");
          $num = mysqli_num_rows($ret1);

          ?>

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i><?php if ($num > 0) { ?>
              <span class="badge bg-primary badge-number"><?php echo $num; ?></span><?php } ?>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">

            <li class="dropdown-header">
              You have <?php echo $num; ?> new notifications
              <a href="appointment.php"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <?php if ($num > 0) {
              while ($result = mysqli_fetch_array($ret1)) {
            ?>
                <a class="notification-item" href="appointment-view.php?viewid=<?php echo $result['AptNum']; ?>">
                  <i class="bi bi-info-circle text-primary"></i>
                  <div>
                    <h4>NEW APPOINTMENT</h4>
                    <p>New appointment received from <b> <?php echo $result['FirstName']; ?> <?php echo $result['LastName']; ?></b></p>
                    <p>Appointment No. <b><?php echo $result['AptNum']; ?></b></p>

                  </div>

                </a>
                <hr class="dropdown-divider">
              <?php }
            } else { ?>
              <a class="dropdown-item" href="all-appointment.php">No New Appointment Received</a>
            <?php } ?>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <?php $ID = $_SESSION['empid'];
        $ret = mysqli_query($con, "SELECT * from tblemployee where EmployeeID =$ID");
        while ($row = mysqli_fetch_array($ret)) { ?>

          <li class="nav-item dropdown pe-3">

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
              <?php if (isset($row['ProfilePic'])) { ?>
                <img src="../profilepics/<?php echo $row['ProfilePic']; ?>" alt="Profile" class="rounded-circle">
              <?php
              } else { ?>
                <img src="../profilepics/default-avatar.png" alt="Profile" class="rounded-circle">
              <?php } ?>
              <span class="d-none d-md-block dropdown-toggle ps-2"></span>
            </a><!-- End Profile Iamge Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
              <li class="dropdown-header">
                <h6><?php echo $row['FirstName'] . " " . $row['LastName']; ?></h6>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>

              <li>
                <a class="dropdown-item d-flex align-items-center" href="admin-profile.php">
                  <i class="bi bi-person"></i>
                  <span>My Profile</span>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
            <?php } ?>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

            </ul><!-- End Profile Dropdown Items -->
          </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <main id="main1" class="main1">
    <br>
    <div class="pagetitle">
      <h1>MY PROFILE</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">My Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <?php
              $ret = mysqli_query($con, "SELECT * from tblemployee where EmployeeID =$ID");
              while ($row = mysqli_fetch_array($ret)) {
                if (isset($row['ProfilePic'])) { ?>
                  <img src="../profilepics/<?php echo $row['ProfilePic']; ?>" alt="Profile" class="rounded-circle">
                <?php
                } else { ?>
                  <img src="../profilepics/default-avatar.png" alt="Profile" class="rounded-circle">
                <?php } ?>
                <h2><?php echo $row['FirstName'] . " " . $row['LastName']; ?> </h2> <br>
                <p>Date Created: <?php echo $row['CreationDate']; ?> </p>

            </div>
          </div>
        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password"> Account Settings</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#emp">Manage Employee</button>
                </li>

              </ul>

              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['FirstName'] . " " . $row['LastName']; ?> </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Mobile Number</div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['MobileNumber']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email Address </div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['Email']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['Address']; ?></div>
                  </div>
                </div>
              <?php } ?>

              <!-- Appointments -->
              <div class="tab-pane fade profile-edit pt-3" id="emp" align="center">
                <img src="assets/img/under.png" width=100% alt="">
                <div style="color: rgb(255, 0, 89);"> <br>
                  <h1><strong>Sorry!</strong></h1>
                  <h4>Webpage is still under construction.</h4>
                </div>


              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                <?php
                $ret = mysqli_query($con, "SELECT * from tblemployee where EmployeeID =$ID");
                while ($row = mysqli_fetch_array($ret)) { ?>

                  <!-- Profile Edit Form -->
                  <form method="POST" enctype="multipart/form-data">
                    <div class="row mb-3 d-flex align-items-center">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-sm-3 profileImg d-flex justify-content-center">
                        <?php if (isset($row['ProfilePic'])) { ?>
                          <img src="../profilepics/<?php echo $row['ProfilePic']; ?>" alt="Profile" class="rounded-circle">
                          <a href="admin-profile.php?delpicid=<?php echo ($row['EmployeeID']); ?>&&ppic=<?php echo $row['ProfilePic']; ?>" class="btn btn-light btn-sm" title="Remove my profile image" onclick="return confirm('Do you really want to remove your profile picture?');"><i class="bi bi-trash"></i><strong>Delete</strong></a>
                        <?php
                        } else { ?>
                          <img src="../profilepics/default-avatar.png" alt="Profile" class="rounded-circle">
                        <?php } ?>

                      </div>


                      <div class="col-md-5 d-flex align-items-center">
                        <input type="file" class="form-control" name="upload_image" id="upload_image" accept="image/*" />
                        <div id="uploaded_image"></div> <br>
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
                              url: "admin-upload.php?editid=<?php echo htmlentities($ID); ?>",
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

                    <div class="row mb-3">
                      <label for="fname" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" name="fname" value="<?php echo $row['FirstName']; ?>" required="true">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" name="lname" value="<?php echo $row['LastName']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" name="contactno" value="<?php echo $row['MobileNumber']; ?>" minlength="11" maxlength="11" pattern="[0-9]+">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="email" class="form-control" name="email" value="<?php echo $row['Email']; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2, 4}$">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="about" class="col-md-4 col-lg-3 col-form-label">Address</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea class="form-control" name="address"><?php echo $row['Address']; ?></textarea>
                      </div>
                    </div><?php } ?>

                  <div class="text-center">
                    <button type="submit" name="submit" class="btn add-btn">Save Changes</button>
                  </div>
                  </form><!-- End Profile Edit Form -->

              </div>

              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form method="POST" enctype="multipart/form-data">

                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="currentPassword" type="password" class="form-control" id="currentPassword" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="newpassword" type="password" class="form-control" id="newPassword" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="renewpassword" type="password" class="form-control" id="renewPassword" required>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="add-btn" name="changepass">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->

              </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer1" class="footer">
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