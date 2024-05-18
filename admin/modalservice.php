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
                <li class="active" id="account">CREATE SERVICE</li>
                <li id="personal">ADD PRICE</li>
                <li id="contact">SELECT SERVICE/S</li>
            </ul>
            <div class="tab">
                <label class="form-label">Customer<i>*</i></label>
                  <?php
                  $sql = "SELECT * FROM tblservices";
                  $query = mysqli_query($con, $sql);


                  ?>


                <input type="text" name="uname" placeholder="Create new service" oninput="this.className=''">

            </div>
            <div class="tab">
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

                <input type="text" name="fname" placeholder="Enter First Name" oninput="this.className=''">
                <input type="text" name="lname" placeholder="Enter Last Name" oninput="this.className=''">
                <input type="date" name="dob" placeholder="Enter Date of Birth" oninput="this.className=''">
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
                    <div class="form-checkbox-group" required>
                      <input class="form-check-input" type="checkbox" id='aptserv[]' name='aptserv[]' value="<?php echo $row['ID']; ?>">
                      <label class="form-check-label" for="gridCheck1">
                        <?php echo $row['ServiceName'] . "  <i>₱" . $row['Cost']; ?></i>
                      </label>
                    </div>
                <?php }
                } ?>

              </div>
                <input type="text" name="addr" placeholder="Enter Address" oninput="this.className=''">
                <input type="email" name="email" placeholder="Enter Email" oninput="this.className=''">
                <input type="text" name="mob" placeholder="Enter Mobile" oninput="this.className=''">
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
</html>
