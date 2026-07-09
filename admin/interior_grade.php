 <?php 
include_once "includes/header.php";
include_once "inc/code.php";

?>
<!-- start page content -->
            <div class="page-content-wrapper">
                <div class="page-content">
            

			<div class="col-sm-12">
				<div class="card">
					<div class="card-header card-bg" align="center"><h4>Create Interior Grade</h4></div>
						<div class="card-body">
							<form action="php_action/custom_action.php" method="POST" role="form" id="formData">
								<div class="msg"></div>
								<div class="form-group">
									<label for="">Interior Grade</label>
									<input type="text" class="form-control" id="interior_grade_name" name="interior_grade_name"> 
									<input type="text" class="form-control d-none" id="interior_grade_id" name="interior_grade_id"> 
								</div>
								<div class="form-group">
									<label for="">Interior Grade Status</label>
									<select class="form-control" id="interior_grade_sts" name="interior_grade_sts"> 
										<option value="">~~SELECT~~</option>
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</div>
							
							<?php if (@$userPrivileges['nav_add']==1 || $fetchedUserRole=="admin"): ?>
								<button type="submit" class="btn btn-primary" class="saveData">Save</button>
								<?php endif ?>
							</form>
							</div>
						</div>
					</div>


<div class="col-sm-12">
		<div class="card">
	<div class="card-header card-bg" align="center"><h4>Interior Grade</h4></div>
	<div class="card-body">
			<table class="table" id="interior_grade">
				<thead>
			<tr>	
				<th>ID</th>
				<th>Interior Grade Name</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			</tbody>
			
			
			</table>
		
	</div>
</div>

</div>
	</div></div>
<?php
include_once "includes/footer.php";
?>