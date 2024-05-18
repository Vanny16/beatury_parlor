<?php
include('dbconnection.php');
session_start();
error_reporting(0);
$ID = $_SESSION['empid'];
if (strlen($_SESSION['empid'] == 0)) {
  header('location:logout.php');
}

if (isset($_POST['submit'])) {
  //getting the post values
  $sname = $_POST['sname'];
  $price = $_POST['price'];
  $desc = $_POST['desc'];

  $sql = "SELECT * FROM tblservices WHERE ServiceName='$sname'";
  $res = mysqli_query($con, $sql);


  if (mysqli_num_rows($res) > 0) {
    echo "<script>alert('Sorry! Service already exists!');</script>";
  } else {

    // Query for data insertion
    $query = mysqli_query($con, "insert into tblservices(ServiceName, Cost, ServiceDescription) value('$sname','$price', '$desc' )");
    if ($query) {
      echo "<script>alert('You have successfully inserted the data');</script>";
      echo "<script type='text/javascript'> document.location ='service.php'; </script>";
    } else {
      echo "<script>alert('Something Went Wrong. Please try again');</script>";
    }
  }
}

include('head.php');

//Code for deletion
if (isset($_GET['delid'])) {
  $rid = intval($_GET['delid']);
  $profilepic = $_GET['ppic'];
  $ppicpath = "../serviceimg" . "/" . $profilepic;
  $sql = mysqli_query($con, "delete from tblservices where ID=$rid");
  unlink($ppicpath);
?>
  <script type="text/javascript">
    swal({
      position: "top-end",
      type: "success",
      title: "Your work has been saved",
      showConfirmButton: false,
      timer: 1500
    })
  </script>
<?php
  echo "<script>alert('Data deleted');</script>";
  echo "<script>window.location.href = 'service.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<body>

  <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <div class="card-title">
        <h3><b>SERVICE INFORMATION</h3>
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
             </div>
           <!-- mysql data will be load here -->
           <div id="dynamic-content"></div>





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
                <h3><b>ADD NEW SERVICE</h3>
              </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <h4>Service Information</h4>

                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label">Service Name<i>*</i></label>
                        <input type="text" class="form-control" name="sname" required="true">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Price<i>*</i></label>
                        <input type="text" class="form-control" name="price" pattern="^[0-9]+(?:[.-][0-9]+)*$" required="true">
                      </div>

                      <div class="col-12">
                        <label class="form-label">Description<i>*</i></label>
                        <textarea class="form-control" name="desc" required="true"></textarea>
                      </div>

                      </div>

                </div>
                <div align="center"><button type="submit" class="add-btn" name="submit" style="width: 100px;">Add</button></div>
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
        <a class="nav-link" href="service.php">
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
      <h1>SERVICES</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Services</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
              <button data-toggle="modal" data-target="#employeeaddmodal" class="add-btn">ADD SERVICE</button>

              </h5>
              <div class=" table-responsive">
                <div class="table-wrapper">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Service Name</th>
                        <th>Cost</th>
                        <th>Date Created</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ret = mysqli_query($con, "select * from tblservices");
                      $row = mysqli_num_rows($ret);
                      if ($row > 0) {
                        while ($row = mysqli_fetch_array($ret)) {
                      ?>
                          <!--Fetch the Records -->
                          <tr>
                            <td><?php echo $row['ID']; ?></td>
                            <?php if (($row['Image']) == 0) { ?>
                              <td><img src="../serviceimg/default-service.png" style="max-height: 30px;" alt="Profile" class="rounded-circle"></td>
                            <?php } else { ?>
                              <td><img src="../serviceimg/<?php echo $row['Image']; ?>" alt="Profile" class="rounded-circle" width="30" height="30"></td>
                            <?php } ?>
                            <td><?php echo $row['ServiceName']; ?></td>
                            <td><?php echo $row['Cost']; ?></td>
                            <td> <?php echo $row['CreationDate']; ?></td>
                            <td>
                              <a type=button data-id=<?php echo htmlentities($row['ID']); ?> id=getService data-target=#view-modal class=view title=View data-toggle=modal><i class=material-icons>&#xE417;</i></a>

                              <a href="service-view.php?viewid=<?php echo htmlentities($row['ID']); ?>" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                              <a href="service-edit.php?editid=<?php echo htmlentities($row['ID']); ?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                              <a href="service.php?delid=<?php echo ($row['ID']); ?>&&ppic=<?php echo $row['Image']; ?>" class="delete" title="Delete" data-toggle="tooltip" onclick="return confirm('Do you really want to Delete ?');"><i class="material-icons">&#xE872;</i></a>
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


<script>
$(document).ready(function(){

    $(document).on('click', '#getService', function(e){

     e.preventDefault();

     var uid = $(this).data('id'); // get id of clicked row

     $('#dynamic-content').html(''); // leave this div blank
     $('#modal-loader').show();      // load ajax loader on button click

     $.ajax({
          url: 'getservice.php',
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
