<?php
session_start();
error_reporting(0);
include('dbconnection.php');

if (isset($_POST['login'])) {
  $emailcon = $_POST['emailcont'];
  // $password = md5($_POST['password']);
  $password = ($_POST['password']);



  $query = mysqli_query($con, "SELECT CustID from tblcustomers where  (Email='$emailcon' || MobileNumber='$emailcon') && Password='$password' ");

  $query2 = mysqli_query($con, "SELECT EmployeeID from tblemployee where  (Email='$emailcon' || MobileNumber='$emailcon') && Password='$password' ");

  $ret = mysqli_fetch_array($query);
  $ret2 = mysqli_fetch_array($query2);

  if ($ret > 0) {
    $_SESSION['bpmsuid']=$ret['CustID'];
    header('location:index.php');
  } 
  else if($ret2 > 0)
  {
    $_SESSION['empid']=$ret2['EmployeeID'];
     header('location:admin/index.php');
  }
  else {
    echo "<script>alert('Invalid credentials.');</script>";
  }
}


else if (isset($_POST['submit'])) {
  $fname = $_POST['firstname'];
  $lname = $_POST['lastname'];
  $contno = $_POST['mobilenumber'];
  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $ret = mysqli_query($con, "SELECT Email from tblcustomers where Email='$email' || MobileNumber='$contno'");
  $result = mysqli_fetch_array($ret);
  if ($result > 0) {
    echo "<script>alert('This email or contact Number already associated with another account!.');</script>";
  } else {
    $query = mysqli_query($con, "INSERT INTO tblcustomers(FirstName, LastName, MobileNumber, Email, Password) value('$fname', '$lname','$contno', '$email', '$password')");
    if ($query) {
      echo "<script>alert('You have successfully registered.');</script>";
    } else {

      echo "<script>alert('Something Went Wrong. Please try again.');</script>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Belen's Beauty Parlor</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <script src="assets/js/kitfontawesome.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/login-style.css" />
  <title>Sign in & Sign up Form</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form method="post" class="sign-in-form">

          <a href="index.php" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" style="max-width: 200px;" class="img-fluid"></a><br>
          <h2 class="title">Sign in</h2>

          <div class="input-field">
            <i class="fas fa-user"></i>
            <input class="form-control" name="emailcont" placeholder="Email or Mobile Number" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" class="form-control" name="password" placeholder="Password" maxlength="120" required="true" />
          </div>
          <button type="submit" class="btn solid" name="login">Login</button>

        </form>
        <!---- END OF LOGIN ------>

        <form method="post" name="signup" onsubmit="return checkpass();" class="sign-up-form">

          <a href="index.php" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" style="max-width: 200px;" class="img-fluid"></a><br>
          <h2 class="title">Sign up</h2>

          <div class="col-sm-3 input-field">
            <i class="fas fa-user"></i>
            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" required>
          </div>

          <div class="col-sm-3 input-field">
            <i class="fas fa-user"></i>
            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" required>
          </div>

          <div class="input-field">
            <i class="fas fa-mobile"></i>
            <input type="text" class="form-control" placeholder="Mobile Number" required="" name="mobilenumber" pattern="[0-9]+" maxlength="11">
          </div>

          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" class="form-control" placeholder="Email address" required name="email">
          </div>

          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
          </div>

          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" class="form-control" name="repeatpassword" placeholder="Confirm password" required="true">
          </div>

          <button type="submit" class="btn btn-contact" name="submit">Sign Up</button>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here?</h3>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
            ex ratione. Aliquid!
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Sign up
          </button>
        </div>
        <img src="img/log.png" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Already a valued customer?</h3>
          <p>
            Sign in and book an appointment now!
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Sign in
          </button>
        </div>
        <img src="img/sign.png" class="image" alt="" />
      </div>
    </div>
  </div>


  <script type="text/javascript">
    function checkpass() {
      if (document.signup.password.value != document.signup.repeatpassword.value) {
        alert('Password and Repeat Password field does not match');
        document.signup.repeatpassword.focus();
        return false;
      }
      return true;
    }
  </script>

  <script src="assets/js/login-script.js"></script>
</body>

</html>