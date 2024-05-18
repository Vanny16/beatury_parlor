<?php session_start();
// error_reporting(0);
include('dbconnection.php');
$ID = $_SESSION['bpmsuid'];
 
if (strlen($_SESSION['bpmsuid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_GET['delid'])) {
    $sid = $_GET['delid'];
    mysqli_query($con, "DELETE from tblappointments where AptNum ='$sid'");
    echo "<script>alert('Data Deleted');</script>";
    echo "<script>window.location.href='users-profile.php'</script>";
  }

  if (isset($_GET['delpicid'])) {
    $rid = intval($_GET['delpicid']);
    $profilepic = $_GET['ppic'];
    $ppicpath = "profilepics" . "/" . $profilepic;
    $sql = mysqli_query($con, "UPDATE tblcustomers SET ProfilePic=NULL  where CustID=$rid");
    unlink($ppicpath);
    echo "<script>alert('Profile picture has been deleted.');</script>";
    echo "<script>window.location.href='users-profile.php'</script>";
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
            echo "<script type='text/javascript'> document.location ='users-profile.php'; </script>";
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
            echo "<script type='text/javascript'> document.location ='users-profile.php'; </script>";
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
            echo "<script type='text/javascript'> document.location ='users-profile.php'; </script>";
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
            echo "<script type='text/javascript'> document.location ='users-profile.php'; </script>";
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

    $sql0 = "SELECT Password FROM tblcustomers WHERE Password='$curpass' AND CustID='$eid'";
    $res0 = mysqli_query($con, $sql0);

    $sql1 = "SELECT * FROM tblcustomers WHERE MobileNumber='$contno' AND CustID='$eid'";
    $sql2 = "SELECT * FROM tblcustomers WHERE Email='$email'AND CustID='$eid'";

    $sql3 = "SELECT * FROM tblcustomers WHERE MobileNumber='$contno'";
    $sql4 = "SELECT * FROM tblcustomers WHERE Email='$email'";

    $res1 = mysqli_query($con, $sql1);
    $res2 = mysqli_query($con, $sql2);

    if (mysqli_num_rows($res0) > 0) {
      if ($newpass == $renewpass) {
        // Query for data insertion
        $query = mysqli_query($con, "UPDATE  tblcustomers set Password='$newpass' WHERE CustID='$eid'");
        if ($query) {
          echo "<script>alert('You have successfully updated $fullname.');</script>";
          echo "<script type='text/javascript'> document.location ='users-profile.php'; </script>";
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
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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

  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />

</head>

<body>

<?php include('header-cust') ?>
  <main id="main" class="main">
    <section class="section profile">
    <div class="pagetitle">
      <h1>MY PROFILE</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">My Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
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
                  <img src="profilepics/default-avatar.png" alt="Profile" class="rounded-circle">
                <?php } ?>
                <h2><?php echo $row['FirstName'] . " " . $row['LastName']; ?> </h2> <br>
                Date Created: <?php echo $row['CreationDate']; ?>
                <!-- <h3>Web Designer</h3> -->
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
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#appointment">Appointments</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password"> Account Settings</button>
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
              <div class="tab-pane fade profile-edit pt-3" id="appointment">
                  <a href="appointment-add.php" class="add-btn">BOOK APPOINTMENT</a>
                <div class=" table-responsive">
                  <div class="table-wrapper">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Appointment Number</th>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $ret = mysqli_query($con, "SELECT * from tblappointments where CustID=$ID");
                        $row = mysqli_num_rows($ret);
                        if ($row > 0) {
                          while ($row = mysqli_fetch_array($ret)) {
                        ?>
                            <!--Fetch the Records -->
                            <tr>
                              <td><?php echo $row['AptID']; ?></td>
                              <td><?php echo $row['AptNum']; ?></td>
                              <td><?php echo $row['AptDate']; ?></td>
                              <td><?php echo $row['AptTime']; ?></td>
                              <td><?php echo $row['Status']; ?></td>
                              <td>
                                <a href="appointment-view.php?viewid=<?php echo htmlentities($row['AptNum']); ?>" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                                <a href="appointment-edit.php?editid=<?php echo htmlentities($row['AptNum']); ?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                <a href="users-profile.php?delid=<?php echo ($row['AptNum']); ?>" class="btn delete" title="Delete" data-toggle="tooltip" onclick="return confirm('Do you really want to Delete ?');" width="100%"><i class="material-icons">&#xE872;</i></a>
                              </td>
                            </tr>
                          <?php
                          }
                        } else { ?>
                          <tr>
                            <th style="text-align:center; color: rgb(206, 2, 74);" colspan="8">No Record Found</th>
                          </tr>
                        <?php } ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                <?php
                $ret = mysqli_query($con, "SELECT * from tblcustomers where CustID =$ID");
                while ($row = mysqli_fetch_array($ret)) { ?>

                  <!-- Profile Edit Form -->
                  <form method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-sm-3 profileImg">
                        <?php if (isset($row['ProfilePic'])) { ?>
                          <img src="profilepics/<?php echo $row['ProfilePic']; ?>" style="width: 100%;" alt="Profile" class="rounded-circle">

                          <a href="users-profile.php?delpicid=<?php echo ($row['CustID']); ?>&&ppic=<?php echo $row['ProfilePic']; ?>" 
                          class="btn btn-light btn-sm" style="width: 100%;" title="Remove my profile image" onclick="return confirm('Do you really want to remove your profile picture?');"><i class="bi bi-trash"></i><strong>Delete</strong></a>
                        <?php
                        } else { ?>
                          <img src="profilepics/default-avatar.png" style="width: 100%;" alt="Profile" class="rounded-circle">
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
                              url: "customer-upload.php?editid=<?php echo htmlentities ($row['CustID']);?>",
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
                      <input name="currentPassword" type="password" class="form-control" id="currentPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="newpassword" type="password" class="form-control" id="newPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn add-btn" name="changepass">Change Password</button>
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