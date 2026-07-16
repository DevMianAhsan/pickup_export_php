<?php
include_once "includes/header.php";
include_once "inc/code.php";

?>
<?php
// If editing, fetch the record
$machine_type_name = '';
$machine_type_id = '';
$machine_type_sts = '';
$machine_type_img = '';
if (!empty($_GET['edit']) && is_numeric($_GET['edit'])) {
	$eid = $_GET['edit'];
	$fetch = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM machine_type WHERE machine_type_id = '$eid'"));
	if ($fetch) {
		$machine_type_name = $fetch['machine_type_name'];
		$machine_type_id = $fetch['machine_type_id'];
		$machine_type_sts = $fetch['machine_type_sts'];
		$machine_type_img = $fetch['machine_type_img'];
	}
}
?>
<!-- start page content -->
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-bar">
			<div class="page-title-breadcrumb">
				<div class=" pull-left">
					<div class="page-title">machine Type</div>
				</div>
				<ol class="breadcrumb page-breadcrumb pull-right">
					<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="dashboard.php">Home</a>&nbsp;<i
							class="fa fa-angle-right"></i>
					</li>
					<li class="active">Machine Type</li>
				</ol>
			</div>
		</div>

		<div class="col-sm-12">
			<div class="panel">
				<div class="panel-heading panel-heading-red" align="center">
					<h4>Create machine Type</h4>
				</div>
				<div class="panel-machine">
					<form action="php_action/custom_action.php" method="POST" enctype="multipart/form-data" role="form" id="formData">
						<div class="msg"></div>
						<div class="form-group">
							<label for="">machine Type</label>
							<input type="text" class="form-control" id="machine_type_name" name="machine_type_name" value="<?= htmlspecialchars($machine_type_name) ?>">
							<input type="text" class="form-control d-none" id="machine_type_id" name="machine_type_id" value="<?= htmlspecialchars($machine_type_id) ?>">
						</div>
						<div class="form-group">
							<label for="">machine Type Image</label>
							<input type="file" class="form-control" id="machine_type_img" name="machine_type_img">
							<?php if (!empty($machine_type_img)): ?>
								<div style="margin-top:8px;"><img src="<?= 'img/vehicles_images/'.htmlspecialchars($machine_type_img) ?>" style="width:80px;" alt="current"/></div>
							<?php endif; ?>
						</div>
						<div class="form-group">
							<label for="">machine Type Status</label>
							<select class="form-control select2" id="machine_type_sts" name="machine_type_sts">
								<option value="">~~SELECT~~</option>
								<option value="1" <?= ($machine_type_sts == '1') ? 'selected' : '' ?>>Active</option>
								<option value="0" <?= ($machine_type_sts == '0') ? 'selected' : '' ?>>Inactive</option>
							</select>
						</div>
						<?php if (@$userPrivileges['nav_add'] == 1 || $fetchedUserRole == "admin"): ?>
							<?php if (!empty($machine_type_id)): ?>
								<button type="submit" class="btn btn-primary" name="machine_type_update">Update</button>
							<?php else: ?>
								<button type="submit" class="btn btn-primary" name="machine_type_add">Save</button>
							<?php endif; ?>
						<?php endif ?>
					</form>
				</div>
			</div>
		</div>


		<div class="col-sm-12">
			<div class="panel">
				<div class="panel-heading cyan-bgcolor" align="center">
					<h4>machine Types</h4>
				</div>
				<div class="panel-machine">
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
						<?php
						$q = mysqli_query($dbc, "SELECT * FROM machine_type ORDER BY machine_type_id DESC");
						if ($q && mysqli_num_rows($q) > 0) {
							while ($row = mysqli_fetch_assoc($q)) {
								$img = !empty($row['machine_type_img']) ? 'img/vehicles_images/'. $row['machine_type_img'] : 'assets/avatars/user.png';
								$status = (@$row['machine_type_sts'] == '1') ? 'Active' : 'Inactive';
								echo "<tr>";
								echo "<td>".htmlspecialchars($row['machine_type_id'])."</td>";
								echo "<td><img src='".htmlspecialchars($img)."' alt='img' style='width:60px;height:auto;'/></td>";
								echo "<td>".htmlspecialchars($row['machine_type_name'])."</td>";
								echo "<td>".htmlspecialchars($status)."</td>";
								echo "<td>";
								echo "<a href='?edit=".urlencode($row['machine_type_id'])."' class='btn btn-sm btn-primary mr-1'>Edit</a>";
								echo "<a href='php_action/custom_action.php?delete_machine_type=".urlencode($row['machine_type_id'])."' class='btn btn-sm btn-danger' onclick=\"return confirm('Delete record?')\">Delete</a>";
								echo "</td>";
								echo "</tr>";
							}
						} else {
							echo "<tr><td colspan='5'>No machine types found.</td></tr>";
						}
						?>

					</table>

				</div>
			</div>

		</div>
	</div>
</div>
<?php
include_once "includes/footer.php";
?>