<?php
 require_once 'dbconfig.php';

 if (isset($_REQUEST['id'])) {

 $id = intval($_REQUEST['id']);
 $query = "SELECT * FROM tblservices WHERE ID=:id";
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
           <h2><b><?php echo $row['ServiceName']; ?></b></h2>
         </div>

         <div class="row">
           <div class="column left">
             <!-- <h4>Photo</h4> -->
             <div align="center">
               <br>

               <?php if (($row['Image']) == 0) { ?>
                 <td><img src="../serviceimg/default-service.png" style="max-height: 200px;" alt="Profile" class="rounded-circle"></td>
               <?php } else { ?>
                 <td><img src="../serviceimg/<?php echo $row['Image']; ?>" alt="Profile" class="rounded-circle" width="200" height="200"></td>
               <?php } ?>
             </div>
           </div>
           <div class="column right">
             <h4>Service Information</h4>

             <div class="row g-3">
               <div class="col-md-6">
                 <label class="form-label">Service Name</label>
                 <input type="text" class="form-control" name="sname" value="<?php echo $row['ServiceName']; ?>" disabled>
               </div>

               <div class="col-md-6">
                 <label class="form-label">Price</label>
                 <input type="text" class="form-control" name="price" value="<?php echo $row['Cost']; ?>" disabled>
               </div>

               <div class="col-12">
                 <label class="form-label">Description</label>
                 <textarea type="text" class="form-control" name="desc" disabled><?php echo $row['ServiceDescription']; ?></textarea>
               </div>

             </div>
           </div>
         </div>
         <div>
         </div>
          </div>
         <div class="modal-footer">
            </div>

           <div align="center">
             <a href="service-edit.php?editid=<?php echo htmlentities($row['ID']); ?>" class="add-btn">EDIT SERVICE DETAILS</a>
             <a href="service.php" class="add-btn">CANCEL</a>
           </div>


       <?php } ?>

     </div>
   </div>

 </div>
 <?php
