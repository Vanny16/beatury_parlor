<!-- Delete Modal  -->
<div id="EmpDeleteModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header flex-column">
                <i class="bi bi-question-circle icon-box"></i>
                <h4 class="modal-title w-100">Are you sure?</h4>
                <i type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</i>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-pink"> <a href="employee.php?delid=<?php echo ($row['EmployeeID']); ?>&&ppic=<?php echo $row['ProfilePic']; ?>">Delete</a></button>
            </div>
        </div>
    </div>
</div><!-- End Delete Modal-->