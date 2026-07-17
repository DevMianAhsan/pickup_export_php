<?php 
include_once "includes/header.php";
include_once "inc/code.php";

?>
<!-- start page content -->

			<div class="col-sm-12">
				<div class="card">
					<div class="card-header card-bg" align="center">
						    <b class="h4 text-center card-text">Machine Type</b>
					</div>
						<div class="card-body">
							<form action="php_action/custom_action.php" method="POST" enctype="multipart/form-data" role="form" id="formData">
								<div class="form-group">
									<label for="">Machine Type</label>
									<input type="text" class="form-control" id="machine_type_name" name="machine_type_name"> 
									<input type="text" class="form-control d-none" id="machine_type_id" name="machine_type_id"> 
								</div>
								<div class="form-group">
									<label for="">Machine Type Image</label>
									<input type="file" class="form-control" id="machine_type_img" name="machine_type_img">
									<img id="machine_type_img_preview" src="" style="max-width:150px;margin-top:8px;display:none;">
								</div>
								<div class="form-group">
									<label for="">Machine Type Status</label>
									<select class="form-control select2" id="machine_type_sts" name="machine_type_sts"> 
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
	<div class="card-header card-bg" align="center">    <b class="h4 text-center card-text">Machine Types</b></div>
	<div class="card-body">
			<table class="table" id="machine_type">
				<thead>
			<tr>	
				<th>ID</th>
				<th>Image</th>
				<th>Name</th>
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
