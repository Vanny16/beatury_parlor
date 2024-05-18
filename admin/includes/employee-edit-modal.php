
  <?php

if (isset($_POST['submit'])) {
  $eid = $_GET['editid'];
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
          echo "<script type='text/javascript'> document.location ='employee.php'; </script>";
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
        $query = mysqli_query($con, "UPDATE  tblemployee set FirstName='$fname',LastName='$lname', MobileNumber='$contno', Email='$email', Address='$add' where EmployeeID='$eid'");
        if ($query) {

          echo "<script>alert('You have successfully updated $fullname.');</script>";
          echo "<script type='text/javascript'> document.location ='employee.php'; </script>";
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
          echo "<script type='text/javascript'> document.location ='employee.php'; </script>";
        } else {
          echo "<script>alert('Something Went Wrong. Please try again');</script>";
        }
      }
    }
  }
}

?>
  
  <!-- Modal -->
  <div class="modal fade" id="EmpEditModal" tabindex="-5" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card-title">
                <h3><b>EDIT EMPLOYEE</b></h3>
              </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                  
                    <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
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
                              url: "employee-upload.php?editid=<?php echo htmlentities($row['EmployeeID']); ?>",
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
                    <a href="employee-view.php?viewid=<?php echo htmlentities($eid); ?>" class="add-btn">CANCEL</a>
                  </div>
              
                </form>

            </div>
        </div>
    </div>

    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->



