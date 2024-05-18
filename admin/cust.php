<?php
include'../includes/connection.php';
include'../includes/sidebar.php';

?><?php

                $query = 'SELECT ID, t.TYPE
                          FROM users u
                          JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = '.$_SESSION['MEMBER_ID'].'';
                $result = mysqli_query($db, $query) or die (mysqli_error($db));

                while ($row = mysqli_fetch_assoc($result)) {
                          $Aa = $row['TYPE'];

if ($Aa=='User'){

             ?>    <script type="text/javascript">
                      //then it will be redirected
                      alert("Restricted Page! You will be redirected to POS");
                      window.location = "pos.php";
                  </script>
             <?php   }


}
            ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title> Supply and Sales Management System </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">


</head>
<body>
<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Customer&nbsp;<a  href="#" data-toggle="modal" data-target="#customerModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                      <th>ID</th>
                      <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Date Register</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      $query = 'SELECT * FROM cust ';
                      $result = mysqli_query($db, $query) or die (mysqli_error($db));

                      while ($row = mysqli_fetch_assoc($result)) {

                       $u_id=$row['u_id'];
                       $username=$row['username'];
                       $f_name=$row['f_name'];
                       $l_name=$row['l_name'];
                       $email=$row['email'];
                       $phone=$row['phone'];
                       $address=$row['address'];
                       $date=$row['date'];

                       ?>

<tr>

                <td> <?php echo $u_id; ?> </td>
								<td> <?php echo $username; ?>     </td>
								<td> <?php echo $f_name; ?>     </td>
								<td> <?php echo $l_name; ?>     </td>
                <td> <?php echo $email; ?> </td>
								<td> <?php echo $phone; ?>     </td>
								<td> <?php echo $address; ?>     </td>
								<td> <?php echo $date; ?>     </td>


                <td>

<a class = "btn btn-primary btn-sm" id="editcustomerbtn" name="editcustomerbtn"

data-bs-toggle="modal"  data-bs-target="#custeditModal">EDIT</a>

<a class = "btn btn-warning btn-sm" id="viewcustomerbtn"

data-bs-toggle="modal"
data-bs-target="#custviewModal">VIEW</a>

<a class = "btn btn-danger btn-sm" id="customerdeletebtn"  data-cname="<?php echo $username; ?>" >DELETE</a>


</td>

                      </tr>
                       <?php
                      }
                      ?>
                      <!-- Delete Modal-->

                  </tbody>
                </table>
              </div>
            </div>

          </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


    <script>

$(function(){

  $("#dataTable").DataTable({"responsive":true,"autoWidth":true,});

  $(document).on('click', '#customerdeletebtn', function(){
                      var username = $(this).data('cname');
                      //alert(productID);

                        Swal.fire({
                        title: 'Are you sure you want to delete customer ' + username +"?",
                        text: "Deleting this will not undo changes!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#008000',
                        cancelButtonColor: '#FF0000',
                      }).then((result) => {
                        if (result.isConfirmed) {
                          deletecustomer(username);
                          showDeletedSuccess();
                        }
                      });
                    });


                    function deletecustomer(cname){
                      var data ={"username": cname};


                      $.ajax({
                          type: "POST",
                          url: "cust_del1.php",
                          data: data,
                          cache: false,
                          success: function(data){
                            if(data=="success")
                            deleted();
                            else
                            notdeleted("error","ERROR","Can't delete customer!");

                          }

                      });

                    }
                    function deleted(icon,title,content){
                      Swal.fire(
                        title,
                        content,
                        icon
                      )
                    }
                    function notdeleted(){
                      Swal.fire({
                      icon: 'success',
                      title: 'DELETED',
                      text: 'You successfully deleted a customer!',
                      confirmButtonText: 'CONTINUE',
                      allowEscapeKey: false,
                      allowOutsideClick: false,
                      }).then((result) => {
                      if (result.isConfirmed) {
                      location.reload(true);
                      }
                      });
                    }

});

</script>
</html>








<?php
include'../includes/footer.php';
?>
