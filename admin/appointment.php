<?php
session_start();
error_reporting(0);
include('dbconnection.php');
$ID = $_SESSION['empid'];

if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
}
else {
  if (isset($_POST['submit'])) {

    if (($_POST['aptserv']) == 0) {
      echo '<script>alert("Please select atleast one(1) service.")</script>';
      echo "<script>window.location.href='appointment-add.php'</script>";
    } else {
      $uid = $_POST['uid'];
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

      $query = mysqli_query($con, "insert into tblappointments(CustID,AptNum,AptDate,AptTime,Message,Status) value('$uid','$aptnumber','$adate','$atime','$msg','$stat')");

      if ($query) {
        $ret = mysqli_query($con, "SELECT AptNum from tblappointments where tblappointments.CustID='$uid' order by AptID desc limit 1;");
        $result = mysqli_fetch_array($ret);
        $_SESSION['aptno'] = $result['AptNum'];

        echo "<script>alert('Appointment No. $aptnumber has been booked.')</script>";
        echo "<script>window.location.href='appointment.php'</script>";
      } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
      }
    }
  }
}

//Code for deletion
if (isset($_GET['delid'])) {
  $sid = $_GET['delid'];
  mysqli_query($con, "DELETE from tblappointments where AptNum ='$sid'");
  echo "<script>alert('Data Deleted');</script>";
  echo "<script>window.location.href='appointment.php'</script>";

}

?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
  <!-- Modal -->

  <div class="modal fade" id="bookappointmentmodal"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">

                 <div class="modal-header">
                 <div class="card-title">
                 <h3><b>BOOK NEW APPOINTMENT </h3>
               </div>

                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>

                <div class="modal-body">
                  <div id="container" class="container">

         <form id="regForm" method="post" action="process.php">

                         <ul id="progressbar">
                             <li class="active" id="account">SELECT CUSTOMER</li>
                             <li id="personal">SELECT TIME & DATE</li>
                             <li id="contact">SELECT SERVICE/S</li>
                         </ul>
                         <div class="tab">

                                       <table id="table" class="table table-hover">
                                         <thead>
                                           <tr>
                                             <th>ID</th>
                                             <th>Photo</th>
                                             <th>Name</th>

                                           </tr>
                                         </thead>
                                         <tbody>
                                           <?php
                                           $ret = mysqli_query($con, "select * from tblcustomers");
                                           $cnt = 1;
                                           $row = mysqli_num_rows($ret);
                                           if ($row > 0) {
                                             while ($row = mysqli_fetch_array($ret)) {
                                           ?>
                                               <!--Fetch the Records -->
                                               <tr>
                                                 <td><?php echo $row['CustID']; ?></td>
                                                 <?php if (($row['ProfilePic']) == 0) { ?>
                                                   <td><img src="../profilepics/default-avatar.png" style="max-height: 30px;" alt="Profile" class="rounded-circle"></td>
                                                 <?php } else { ?>
                                                   <td><img src="../profilepics/<?php echo $row['ProfilePic']; ?>" alt="Profile" class="rounded-circle" width="30" height="30"></td>
                                                 <?php } ?>
                                                 <td><?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?></td>

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

                                       <input type="text" name="uid" id="uid" oninput="this.className=''" readonly>
                                     <input type="text" name="Name" id="Name" oninput="this.className=''" readonly>
                         </div>
                         <div class="tab">
                           <label class="form-label">Time<i>*</i></label>

                           <select class="form-select" name="atime" id='atime' oninput="this.className=''" required>
                             <option value=""></option>
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


                             <input type="date" name="adate" placeholder="Enter Date of Birth" oninput="this.className=''">
                         </div>
                         <div class="tab">
                           <div class="col-md-6">
                             <label class="form-label">Service/s<i>*</i></label>
                             <input class="form-check-input" type="checkbox" id='aptserv[]' name='aptserv[]' value="0" disabled hidden>
                             <?php
                             $ret = mysqli_query($con, "SELECT * from tblservices");
                             $row = mysqli_num_rows($ret);
                             if ($row > 0) {
                               while ($row = mysqli_fetch_array($ret)) {
                             ?>
                                 <div class="form-checkbox-group" oninput="this.className=''" required>
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
                         <div style="overflow: hidden;">
                             <div style="float: right;">
                                 <button onclick="nextPrev(-1);" type="button" id="prev">Previous</button>
                                 <button onclick="nextPrev(1);" type="button" id="next">Next</button>
                             </div>
                         </div>
                     </form>
             </div>
             </div>
               </div>


         </div>
       </div>
     </div>

 <!-- Modal -->
 <div class="modal fade" id="employeeaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <div class="card-title">
                <h3><b>BOOK NEW APPOINTMENT </h3>
              </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">


<div class="row g-3">

  <div class="col-12">
    <label class="form-label">Customer<i>*</i></label>

    <select class="form-select" name="uid" id="uid" required>

      <option value=""></option>
      <?php
      $sql = "SELECT * FROM tblcustomers";
      $query = mysqli_query($con, $sql);

      while ($row = mysqli_fetch_assoc($query)) {
        $FullName = $row['FirstName'] . " " . $row['LastName'];
      ?>
        <option value="<?php echo $row['CustID']; ?>">
          ID#<?php echo $row['CustID'] ." -  ". $FullName; ?>
        </option>
      <?php } ?>
    </select>
  </div>

  <div class="col-md-6">
    <label class="form-label">Date<i>*</i></label>
    <input type="date" class="form-control appointment_date" name="adate" id='adate' required="true">
  </div>

  <div class="col-md-6">
    <label class="form-label">Time<i>*</i></label>

    <select class="form-select" name="atime" id='atime' required>
      <option value=""></option>
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
  <button type="submit" class="custom-btn" name="submit" style="width: 100px;">BOOK</button>
</div>
</form>

            </div>
        </div>
      </div>
    </div>

    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->

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

    <div class="pagetitle">
      <h1>APPOINTMENTS</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Appointments</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
              <button data-toggle="modal" data-target="#employeeaddmodal" class="add-btn">BOOK APPOINTMENT</button>
              <button data-toggle="modal" data-target="#bookappointmentmodal" class="add-btn">BOOK APPOINTMENT</button>

              <a href="appointment-modal.php" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>

              </h5>
              <div class=" table-responsive">
                <div class="table-wrapper">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Appointment Number</th>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ret = mysqli_query($con, "select tblcustomers.FirstName, tblcustomers.LastName, tblcustomers.Email, tblcustomers.MobileNumber, tblappointments.AptID, tblappointments.AptNum,tblappointments.AptDate, tblappointments.AptTime, tblappointments.Message, tblappointments.BookDate, tblappointments.Status from tblappointments join tblcustomers on tblcustomers.CustID=tblappointments.CustID");
                      $row = mysqli_num_rows($ret);
                      if ($row > 0) {
                        while ($row = mysqli_fetch_array($ret)) {
                      ?>
                          <!--Fetch the Records -->
                          <tr>
                            <td><?php echo $row['AptID']; ?></td>
                            <td><?php echo $row['AptNum']; ?></td>
                            <td><?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?></td>
                            <td><?php echo $row['MobileNumber']; ?></td>
                            <td><?php echo $row['AptDate']; ?></td>
                            <td><?php echo $row['AptTime']; ?></td>
                            <td><?php echo $row['Status']; ?></td>
                            <td>
                              <a href="appointment-view.php?viewid=<?php echo htmlentities($row['AptNum']); ?>" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                              <?php $stat = $row['Status'];
                              if ($stat == 'Confirmed') { ?>
                                <a href="appointment-edit.php?editid=<?php echo htmlentities($row['AptNum']); ?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                <a href="appointment.php?delid=<?php echo ($row['AptNum']); ?>" class="delete" title="Delete" data-toggle="tooltip" onclick="return confirm('Do you really want to Delete ?');"><i class="material-icons">&#xE872;</i></a>
                              <?php } ?>

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

  <link rel="stylesheet" href="style.css">
  <script src="script.js"></script>

  <script>

                var table = document.getElementById('table');

                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         //rIndex = this.rowIndex;
                         document.getElementById("uid").value = this.cells[0].innerHTML;
                         document.getElementById("Name").value = this.cells[2].innerHTML;
                    };
                }

         </script>

</body>

</html>
