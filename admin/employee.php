<?php
include('head.php');
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

if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
}

//Code for deletion
if (isset($_GET['delid'])) {
  $rid = intval($_GET['delid']);
  // $profilepic = $_GET['ppic'];
  // $ppicpath = "../profilepics" . "/" . $profilepic;
  $sql = mysqli_query($con, "delete from tblemployee where EmployeeID=$rid");
  // unlink($ppicpath);
  echo "<script>alert('Data deleted');</script>";
  echo "<script>window.location.href = 'employee.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<body>

   <!-- Modal -->
   <div class="modal fade" id="empaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card-title">
                <h3><b>ADD NEW EMPLOYEE</h3>
              </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" name="add" onsubmit="return checkpass();" enctype="multipart/form-data">
                    <div class="modal-body">
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
                    </div>
                    <div class="modal-footer">
                    </div>
                <div align="center"><button type="submit" class="add-btn" name="submit" style="width: 100px;">Add</button>

                </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->

    <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <div class="card-title">
          <h3><b>EMPLOYEE PROFILE</b></h3>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>



          <div class="modal-body">
             <div id="modal-loader" style="display: none; text-align: center;">
             <!-- ajax loader -->
             <img src="ajax-loader.gif">
             </div>

             <!-- mysql data will be load here -->
             <div id="dynamic-content"></div>



              <div align="center">
            <a href="employee-edit.php?editid=<?php echo htmlentities ($row['EmployeeID']);?>" class="add-btn">EDIT USER DETAILS</a>
             <a href="employee.php" class="add-btn">CANCEL</a>
  </div>
          </div>
    </div>
  </div>
    </div>



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
          <li class="breadcrumb-item active">Employee</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">

              <!-- <button data-toggle="modal" data-target="#employeeaddmodal" class="add-btn">ADD EMPLOYEE</button> -->
                <button data-toggle="modal" data-target="#empaddmodal" class="add-btn">ADD EMPLOYEE</button>
              </h5>
              <div class=" table-responsive">
                <div class="table-wrapper">
                  <div class="table-title">

                  </div>
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Date Created</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ret = mysqli_query($con, "select * from tblemployee");
                      $cnt = 1;
                      $row = mysqli_num_rows($ret);
                      if ($row > 0) {
                        while ($row = mysqli_fetch_array($ret)) {
                      ?>
                          <!--Fetch the Records -->
                          <tr>
                            <td><?php echo $row['EmployeeID']; ?></td>
                            <?php if (($row['ProfilePic']) == 0) { ?>
                              <td><img src="../profilepics/default-avatar.png" style="max-height: 30px;" alt="Profile" class="rounded-circle"></td>
                            <?php } else { ?>
                              <td><img src="../profilepics/<?php echo $row['ProfilePic']; ?>" alt="Profile" class="rounded-circle" width="30" height="30"></td>
                            <?php } ?>
                            <td><?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?></td>
                            <td><?php echo $row['Email']; ?></td>
                            <td><?php echo $row['MobileNumber']; ?></td>
                            <td> <?php echo $row['CreationDate']; ?></td>
                            <td>
                              <a type=button data-id=<?php echo htmlentities($row['EmployeeID']); ?> id=getdata data-target=#view-modal class=view title=View data-toggle=modal><i class=material-icons>&#xE417;</i></a>
                              <a href="employee-edit.php?editid=<?php echo htmlentities($row['EmployeeID']); ?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                              <a href="#EmpDeleteModal" class="delete" title="Delete" data-toggle="modal"><i class="material-icons">&#xE872;</i></a>
                            </td>
                            <?php include('includes/employee-delete-modal.php'); ?>
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
  $(document).ready(function(){

      $(document).on('click', '#getdata', function(e){

       e.preventDefault();

       var uid = $(this).data('id'); // get id of clicked row

       $('#dynamic-content').html(''); // leave this div blank
       $('#modal-loader').show();      // load ajax loader on button click

       $.ajax({
            url: 'getdata.php',
            type: 'POST',
            data: 'id='+uid,
            dataType: 'html'
       })
       .done(function(data){
            console.log(data);
            $('#dynamic-content').html(''); // blank before load.
            $('#dynamic-content').html(data); // load here
            $('#modal-loader').hide(); // hide loader
       })
       .fail(function(){
            $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            $('#modal-loader').hide();
       });

      });
  });
  </script>

</body>

</html>
