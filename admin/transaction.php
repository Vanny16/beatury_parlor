<?php
//database conection  file
include('dbconnection.php');
session_start();
error_reporting(0);
if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
}else {
  if (isset($_POST['submit'])) {

    if (empty($_POST['custType'])) {
      echo '<script>alert("Please select customer type.")</script>';
    }
    else if (($_POST['aptserv']) == 0) {
      echo '<script>alert("Please select atleast one(1) service.")</script>';
    } 
    else {
      $stat = "Ongoing";
      $paystat = "Unpaid";
      $empid = $_SESSION['empid'];
      $custType = $_POST['custType'];

      if (!empty($_POST['AptNum'])) {
        $AptNum = $_POST['AptNum'];
        $aptservID = $_POST['aptserv'];
        $invoiceID = mt_rand(100000000, 999999999);


        $ret = mysqli_fetch_assoc(mysqli_query($con, "SELECT CustID from tblappointments where AptNum='$AptNum'; "));
        $CustID = $ret['CustID'];

        $query = mysqli_query($con, "INSERT into tblserviceorder(AptNum, EmployeeID, InvoiceID, CustomerID, Status, CustType, PaymentStatus) value('$AptNum','$empid','$invoiceID','$CustID','$stat','$custType', '$paystat')");

        if ($query) {
          $ret = mysqli_fetch_assoc(mysqli_query($con, "SELECT soID from tblserviceorder where InvoiceID='$invoiceID';"));
          $soID = $ret['soID'];

          for ($i = 0; $i < count($aptservID); $i++) {
            $svid = $aptservID[$i];
            $ret = mysqli_query($con, "INSERT into tblinvoice(InvoiceID,soID,ServiceID) values('$invoiceID','$soID','$svid');");
          }
          
          echo '<script>alert("Service order has been created!")</script>';
          echo "<script>window.location.href='transaction.php'</script>";
        } else {
          echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
      } else {
        $aptservID = $_POST['aptserv'];
        $CustID = $_POST['CustID'];
        $invoiceID = mt_rand(100000000, 999999999);

        $query = mysqli_query($con, "INSERT into tblserviceorder(EmployeeID, InvoiceID, CustomerID, Status, CustType, PaymentStatus) value('$empid','$invoiceID','$CustID','$stat','$custType','$paystat')");

        if ($query) {
          $ret = mysqli_fetch_assoc(mysqli_query($con, "SELECT soID from tblserviceorder where InvoiceID='$invoiceID';"));
          $soID = $ret['soID'];

          for ($i = 0; $i < count($aptservID); $i++) {
            $svid = $aptservID[$i];
            $ret = mysqli_query($con, "INSERT into tblinvoice(InvoiceID,soID,ServiceID) values('$invoiceID','$soID','$svid');");
          }

          echo '<script>alert("Service order has been created!")</script>';
          echo "<script>window.location.href='transaction.php'</script>";

        } else {
          echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
      }
    }
  }
}

//Code for deletion
if (isset($_GET['delid'])) {
  $sid = $_GET['delid'];
  mysqli_query($con, "DELETE from tblserviceorder where soID ='$sid'");
  mysqli_query($con, "DELETE from tblinvoice where soID ='$sid'");
  echo "<script>alert('Data Deleted');</script>";
  echo "<script>window.location.href='transaction.php'</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Appointments | Belen's Beauty Parlor</title>
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

<!-- Modal -->
<div class="modal fade" id="employeeaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <div class="card-title">
                <h3><b>ADD NEW SERVICE ORDERS</h3>
              </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST">
                <div class="modal-body">
                <div class="row g-3">

                  <div class="col-lg-12">
                    <label class="form-label" style="margin-right: 1em;">Customer Type<i>*</i> </label>

                    <script type="text/javascript">
                      function yesnoCheck() {
                        if (document.getElementById('custType1').checked) {
                          document.getElementById('ifYes').style.display = 'block';
                          document.getElementById('ifNo').style.display = 'none';
                          document.getElementById('AptNum').setAttribute('required', '');
                          document.getElementById('CustID').removeAttribute('required');
                        } else if (document.getElementById('custType2').checked) {
                          document.getElementById('ifNo').style.display = 'block';
                          document.getElementById('ifYes').style.display = 'none';
                          document.getElementById('CustID').setAttribute('required', '');
                          document.getElementById('AptNum').removeAttribute('required');
                        }

                      }
                    </script>
                    <input class="form-check-input" type="radio" name="custType" id="custType1" value="Appointment" onclick="javascript:yesnoCheck();">
                    <label class="form-check-label" for="custType1"> Appointment</label>

                    <input class="form-check-input" type="radio" name="custType" id="custType2" value="Walk-In" onclick="javascript:yesnoCheck();">
                    <label class="form-check-label" for="custType2"> Walk-In</label>
                  </div>

                  <div class="col-lg-12" id="ifYes" style="display:none">
                    <label class="form-label">Appointment Number<i>*</i></label>

                    <select class="form-select" name="AptNum" id="AptNum">
                      <option></option>
                      <?php
                      $sql = "SELECT tblappointments.AptNum, tblappointments.CustID, tblcustomers.CustID, tblcustomers.FirstName, tblcustomers.LastName
                        FROM tblappointments
                        JOIN tblcustomers
                        ON tblcustomers.CustID=tblappointments.CustID;";
                      $query = mysqli_query($con, $sql);

                      while ($row = mysqli_fetch_assoc($query)) {
                        $FullName = $row['FirstName'] . " " . $row['LastName'];
                      ?>
                        <option value="<?php echo $row['AptNum']; ?>">#<?php echo $row['AptNum'] . " -  " . $FullName; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-lg-12" id="ifNo" style="display:none">
                    <label class="form-label">Customer<i>*</i></label>

                    <select class="form-select" name="CustID" id="CustID">
                      <option></option>
                      <?php
                      $sql = "SELECT * FROM tblcustomers";
                      $query = mysqli_query($con, $sql);

                      while ($row = mysqli_fetch_assoc($query)) {
                        $FullName = $row['FirstName'] . " " . $row['LastName'];
                      ?>
                        <option value="<?php echo $row['CustID']; ?>">
                          ID#<?php echo $row['CustID'] . " -  " . $FullName; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-lg-12">
                    <label class="form-label">Service/s<i>*</i></label>
                    <!-- START -->
                  <table class="table" >
									<thead>
										<tr>
											<th></th>
											<th>Service</th>
											<th>Price</th>
                      <th>Employee</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$ret = mysqli_query($con, "select *from  tblservices");
										$cnt = 1;
										while ($row = mysqli_fetch_array($ret)) {

										?>

											<tr>
                        <input class="form-check-input" type="checkbox" id='aptserv[]' name='aptserv[]' value="0" disabled hidden>
												<td><input type="checkbox" id='aptserv[]' name='aptserv[]' value="<?php echo$row['ID']; ?>"></td>
												<td><?php echo $row['ServiceName']; ?></td>
												<td><?php echo "<i>₱" .$row['Cost']."</i>"; ?></td>
                        <td><select name="" class="form-control" id=""></select></td>
											</tr>
										<?php
										} ?>

									</tbody>
								</table>

                  </div>

                </div>
                
                
                <div align="center">
                  <button type="submit" class="add-btn" name="submit" style="width: 100px;">SUBMIT</button>
                 
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
        <a class="nav-link" href="transaction.php">
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
      <h1>SERVICE ORDERS</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Service Orders</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                           <button data-toggle="modal" data-target="#employeeaddmodal" class="add-btn">NEW ORDER</button>

              </h5>
              <div class=" table-responsive">
                <div class="table-wrapper">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Customer Name</th>
                        <th>Employee Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date Created</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ret = mysqli_query($con, "SELECT tblcustomers.CustID, tblcustomers.FirstName, tblcustomers.LastName, tblserviceorder.CustomerID, tblserviceorder.soID, tblserviceorder.EmployeeID, tblserviceorder.PaymentStatus,tblserviceorder.custType, tblserviceorder.Status, tblserviceorder.CreationDate,tblemployee.EmployeeID, tblemployee.FirstName as empFname, tblemployee.LastName as empLname
                      FROM tblserviceorder
                      JOIN tblcustomers ON tblcustomers.CustID = tblserviceorder.CustomerID
                      JOIN tblemployee ON tblserviceorder.EmployeeID=tblemployee.EmployeeID");
                      $row = mysqli_num_rows($ret);
                      if ($row > 0) {
                        while ($row = mysqli_fetch_array($ret)) {
                      ?>
                          <!--Fetch the Records -->
                          <tr>
                            <td><?php echo $row['soID']; ?></td>
                            <td><?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?></td>
                            <td><?php echo $row['empFname']; ?> <?php echo $row['empLname']; ?></td>
                            <td><?php echo $row['custType']; ?></td>
                            <td><?php echo $row['Status']; ?></td>
                            <td><?php echo $row['CreationDate']; ?></td>
                            <td>
                              <a href="transaction-view.php?viewid=<?php echo htmlentities($row['soID']); ?>" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                              <?php
                              $stat = $row['Status'];
                              $paystat = $row['PaymentStatus'];

                              if ($stat == 'Completed') { ?>
                                <a href="transaction-edit.php?editid=<?php echo htmlentities($row['soID']); ?>" class="edit" title="Edit" data-toggle="tooltip" hidden><i class="material-icons">&#xE254;</i></a>
                                <a href="transaction.php?delid=<?php echo ($row['soID']); ?>" class="delete" title="Delete" data-toggle="tooltip" onclick="return confirm('Do you really want to Delete ?');" hidden><i class="material-icons">&#xE872;</i></a>
                              <?php
                              } else { ?>
                                <a href="transaction-edit.php?editid=<?php echo htmlentities($row['soID']); ?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                <a href="transaction.php?delid=<?php echo ($row['soID']); ?>" class="delete" title="Delete" data-toggle="tooltip" onclick="return confirm('Do you really want to Delete ?');"><i class="material-icons">&#xE872;</i></a>

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

</body>

</html>