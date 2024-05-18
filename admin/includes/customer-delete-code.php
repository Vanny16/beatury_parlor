<?php
$con=mysqli_connect("localhost", "root", "", "belensdb");
if(mysqli_connect_errno())
{
echo "Connection Fail".mysqli_connect_error();
}

//Code for deletion
if (isset($_POST['delid']))
 {
  $rid = intval($_POST['delid']);
  $profilepic = $_POST['ppic'];
  $ppicpath = "../profilepics" . "/" . $profilepic;
  $sql = mysqli_query($con, "delete from tblcustomers where CustID=$id");
  unlink($ppicpath);
  echo "<script>alert('Data deleted');</script>";
  echo "<script>window.location.href = '../customer.php'</script>";
}
?>