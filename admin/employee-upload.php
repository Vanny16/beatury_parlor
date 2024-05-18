<?php
session_start();
error_reporting(0);
include('dbconnection.php');
$ID = $_SESSION['empid'];

if(isset($_POST["image"]))
{
 $ID = $_GET['editid'];
 $data = $_POST["image"];
 $img_array_1 = explode(";", $data);
 $img_array_2 = explode(",", $img_array_1[1]);
 $basedecode = base64_decode($img_array_2[1]);
 $filename = time() . '.jpg';
 file_put_contents("../profilepics/$filename", $basedecode);
 //file_put_contents($filename, $basedecode);
 echo '<img src="'.$filename.'" class="img-thumbnail" />';
 $sql = "UPDATE tblemployee SET ProfilePic='$filename' WHERE EmployeeID='$ID'"; 
 if($con->query($sql)){
    
  echo "<script>alert('Profile Picture updated');</script>";
  echo "<script>window.location.href = 'employee-edit.php?editid=$ID'</script>";
 } 
}
?>