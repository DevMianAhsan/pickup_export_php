<?php 
include_once "includes/header.php";
include_once "inc/code.php";

?>

			<div class="col-sm-12">
				<div class="card">
					<div class="card-header card-bg" align="center"><h4>Create CC</h4></div>
						<div class="card-body">
							<form action="php_action/custom_action.php" method="POST" role="form" id="formData">
								<div class="msg"></div>
								<div class="form-group">
									<label for="">CC</label>
									<input type="text" class="form-control" id="cc_name" name="cc_name"> 
									<input type="text" class="form-control d-none" id="cc_id" name="cc_id"> 
								</div>
								<div class="form-group">
									<label for="">CC Status</label>
									<select class="form-control" id="cc_sts" name="cc_sts"> 
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
	<div class="card-header card-bg" align="center"><h4>CC List</h4></div>
	<div class="card-body">
			<table class="table" id="cc">
				<thead>
			<tr>	
				<th>ID</th>
				<th>cc Name</th>
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
	
<?php
include_once "includes/footer.php";
?>