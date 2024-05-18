<?php

    session_start();
    error_reporting(0);
    include('dbconnection.php');
    $ID = $_SESSION['empid'];
    $msg = "";
    if(isset($_SESSION['msg'])){
        $msg = $_SESSION['msg'];
    }



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

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <title>Multistep Form</title>
</head>
<body onload="showTab(current);hideMsg();">
<?php

    if($msg == "done"){
    echo "<div id='msg' class='msg'>
            <p>You have registered successfully!</p>
          </div>";
    }

?>
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
</body>
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
</html>
