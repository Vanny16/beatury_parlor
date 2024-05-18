<?php
session_start();
error_reporting(0);
include('dbconnection.php');
$ID = $_SESSION['empid'];

if(isset($_POST["serviceimage"]))
{
 $ID = $_GET['editid'];
 $data = $_POST["serviceimage"];
 $img_array_1 = explode(";", $data);
 $img_array_2 = explode(",", $img_array_1[1]);
 $basedecode = base64_decode($img_array_2[1]);
 $filename = time() . '.jpg';
 file_put_contents("../serviceimg/$filename", $basedecode);
 //file_put_contents($filename, $basedecode);
 echo '<img src="'.$filename.'" class="img-thumbnail" />';
 
 $sql = "UPDATE tblservices SET Image='$filename' WHERE ID='$ID'"; 
 $pic = $_GET['ppic'];
 $ppicpath = "../serviceimg" . "/" . $pic;
 unlink($ppicpath);


 if($con->query($sql)){
  echo "<script>alert('Service Picture updated');</script>";
  echo "<script>window.location.href = 'service-edit.php?editid=$ID'</script>";
 } 
}


?>