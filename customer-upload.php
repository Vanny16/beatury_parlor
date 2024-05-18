<?php
include('dbconnection.php');
if(isset($_POST["image"]))
{
 $ID = $_GET['editid'];
 $data = $_POST["image"];
 $img_array_1 = explode(";", $data);
 $img_array_2 = explode(",", $img_array_1[1]);
 $basedecode = base64_decode($img_array_2[1]);
 $filename = md5($ID) . '.jpg';
 file_put_contents("profilepics/$filename", $basedecode);
 //file_put_contents($filename, $basedecode);
 echo '<img src="'.$filename.'" class="img-thumbnail" />';
 $sql = "UPDATE tblcustomers SET ProfilePic='$filename' WHERE CustID='$ID'"; 
 if($con->query($sql)){
    
  echo "<script>alert('Profile Picture updated');</script>";
  echo "<script>window.location.href = 'users-profile.php'</script>";
 } 
}
?>