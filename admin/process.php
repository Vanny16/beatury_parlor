<?php

    session_start();
    include('dbconnection.php');

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

    // $helper = new master();
    // $msg = $helper->doRegister($uname, $pass, $fname, $lname, $dob, $addr, $email, $mob);
    //
    // $_SESSION['msg'] = $msg;
    // header("Location: index.php");
    // exit();

?>
