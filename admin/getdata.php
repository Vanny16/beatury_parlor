<?php
 require_once 'dbconfig.php';

 if (isset($_REQUEST['id'])) {

 $id = intval($_REQUEST['id']);
 $query = "SELECT * FROM tblemployee WHERE EmployeeID=:id";
 $stmt = $DBcon->prepare( $query );
 $stmt->execute(array(':id'=>$id));
 $row=$stmt->fetch(PDO::FETCH_ASSOC);
 extract($row);

 ?>
 <div class="row">
   <div class="col-lg">
     <div class="card">
       <div class="card-body">

       <div class="card-title">
       <h2><b><?php  echo $row['FirstName'];?> <?php  echo $row['LastName'];?></b></h2>
       </div>
         <div class="table-responsive">

           <table cellpadding="0" cellspacing="0" border="0" class="display table" id="hidden-table-info">

             <tbody>
                 <tr>
                     <th width="200">Profile Picture</th>
                     <?php if (($row['ProfilePic']) == 0) { ?>
                       <td><img src="../profilepics/default-avatar.png" style="max-height: 80px;" alt="Profile" class="rounded-circle"></td>
                   <?php } else { ?>
                     <td><img src="../profilepics/<?php  echo $row['ProfilePic'];?>" alt="Profile" class="rounded-circle" width="80" height="80"></td>
                   <?php } ?>
                       <th width="200">Creation Date</th>
                     <td><?php  echo $row['CreationDate'];?></td>
                 </tr>

               <tr>
                 <th>First Name</th>
                 <td><?php  echo $row['FirstName'];?></td>
                 <th>Last Name</th>
                 <td><?php  echo $row['LastName'];?></td>
               </tr>
               <tr>
                 <th>Email</th>
                 <td><?php  echo $row['Email'];?></td>
                 <th>Mobile Number</th>
                 <td><?php  echo $row['MobileNumber'];?></td>
               </tr>
               <tr>
                 <th>Address</th>
                 <td><?php  echo $row['Address'];?></td>

               </tr>


             </tbody>
           </table>
        </div>
        <div>
      </div>
           <?php }?>
     </div>
   </div>
 </div>
 <?php
