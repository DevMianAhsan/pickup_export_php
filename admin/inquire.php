 <?php 
include_once "includes/header.php";
include_once "inc/code.php";

?>
<!-- start page content -->

			<div class="col-sm-12">
				<div class="card">
					<div class="card-header card-bg" align="center">
						    <b class="h4 text-center card-text">Brands</b>
					</div>
						<div class="card-body">
							<form action="php_action/custom_action.php" method="POST" role="form" id="formData">
								<div class="msg"></div>
								<div class="form-group">
									<label for="">Brand</label>
									<input type="text" class="form-control" id="brand_name" name="brand_name"> 
									<input type="text" class="form-control d-none" id="brand_id" name="brand_id"> 
								</div>
								<div class="form-group">
									<label for="">Maker Name</label>
									<select class="form-control" id="maker_id" name="maker_id"> 
										<option value="">~~SELECT~~</option>
										<?php 
										$q = get($dbc,"maker");
										while ($r = mysqli_fetch_assoc($q)):?>
											<option value="<?=$r['maker_id']?>"><?=$r['maker_name']?></option>
										<?php endwhile ?>
									</select>
								</div>
								<div class="form-group">
									<label for="">M3</label>
									<input type="text" class="form-control" id="brand_m3" name="brand_m3"> 
								</div>
								<div class="form-group">
									<label for="">Brand Status</label>
									<select class="form-control" id="brand_status" name="brand_status"> 
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
	<div class="card-header card-bg" align="center">    <b class="h4 text-center card-text">Brands</b></div>
	<div class="card-body">
			<table class="table" id="brands">
				<thead>
			<tr>	
				<th>ID</th>
				<th>Maker Name</th>
				<th>Brands Name</th>
				<th>M3</th>
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