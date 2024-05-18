<?php
$con = mysqli_connect("localhost","root","", 'belensdb');
if(mysqli_connect_errno())
{
}

// if(isset($_POST['deletedata']))
// {
//     $id = $_POST['delete_id'];
//     $profilepic = $_POST['ppic'];
//     $ppicpath = "../profilepics" . "/" . $profilepic;

//     $query = "DELETE FROM tblcustomer WHERE id='$id'";
//     $query_run = mysqli_query($connection, $query);
//     unlink($ppicpath);

//     if($query_run)
//     {
//         echo '<script> alert("Data Deleted"); </script>';
//         header("Location:index.php");
//     }
//     else
//     {
//         echo '<script> alert("Data Not Deleted"); </script>';
//     }
// }

if (isset($_GET['delid'])) {
  $rid = intval($_GET['delid']);
//   $profilepic = $_GET['ppic'];
//   $ppicpath = "../profilepics" . "/" . $profilepic;
  $sql = mysqli_query($con, "delete from tblcustomers where CustID=$rid");
//   unlink($ppicpath);
  echo "<script>alert('Data deleted');</script>";
  echo "<script>window.location.href = 'customer.php'</script>";
}
?>
