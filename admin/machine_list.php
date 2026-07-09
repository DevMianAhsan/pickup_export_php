<?php
include_once "includes/header.php";
include_once "inc/code.php";

?>
<style>
	/* Center SweetAlert buttons */
	.swal-footer {
		text-align: center !important;
	}

	/* Make buttons larger and spaced */
	.swal-button {
		min-width: 120px;
		font-weight: bold;
		padding: 10px 20px;
	}

	/* Cancel button styles */
	.swal-button--cancel {
		background-color: #6c757d;
		/* Bootstrap secondary gray */
		color: #fff;
		opacity: 1 !important;
		box-shadow: none !important;
	}

	/* Remove hover effect from Cancel button */
	.swal-button--cancel:hover {
		background-color: #6c757d !important;
		/* keep same color */
		color: #fff !important;
	}
</style>
<!-- start page content -->
<div class="page-content-wrapper">
	<div class="page-content">


		<div class="col-sm-12">
			<div class="card">
				<div class="card-header card-bg" align="center">
					<h4>Machines List</h4>
				</div>
				<div class="card-body">
					<table class="table dataTable" id="mach_table">
						<thead>
							<tr>
								<th>Sr#</th>
								<th>Maker / Brand</th>
								<th>Machine Type</th>
								<th>Part No.</th>
								<th>Manu. Year</th>
								<th>Weight</th>
								<th>Sold Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>




							<?php $c = 0;
							$q = get($dbc, "machines WHERE machine_sts!=0 ");
							while ($r = mysqli_fetch_assoc($q)):
								$c++;
								$maker = fetchRecord($dbc, "maker", "maker_id", $r['machine_maker'])['maker_name'];
								$brand = fetchRecord($dbc, "brands", "brand_id", $r['machine_brand'])['brand_name'];
								?>
								<tr>
									<td><?= $c ?></td>
									<td><?= $maker ?> 	<?= $brand ?></td>
									<td><?= $r['machine_type'] ?></td>
									<td><?= $r['part_no'] ?></td>
									<td><?= $r['machine_manu_year'] ?></td>
									<td><?= $r['machine_weight'] ?></td>
									<td>
										<?php

										if (@$r['machine_sale_stts']) {

											?>

											<span class="badge badge-success p-2">Sold</span><br />



											<?php

										} else {

											?>

											<span class="badge badge-danger p-2">Not Sold</span>

											<?php

										}

										?>

									</td>
									<td>
										<div class="dropdown">

											<button class="btn btn-secondary dropdown-toggle" type="button"
												id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true"
												aria-expanded="false">
												Action
											</button>

											<div class="dropdown-menu" aria-labelledby="dropdownMenu3">
												<!-- btn-admin2   edit aditional class-->
												<a href="machines.php?machine_id=<?= $r['machine_id'] ?>"
													class="dropdown-item"><i class="mr-1 fa fa-edit"></i>Edit</a>
												<a href="javascript:void(0);" class="dropdown-item deleteVehicleBtn"
													data-id="<?= $r['machine_id'] ?>">
													<i class="fa fa-trash mr-1"></i> Delete
												</a>

												<button id="myFunction"
													onclick="stats('machines','machine_id',<?= $r['machine_id'] ?>,'machine_sale_stts')"
													class="dropdown-item">
													<i class="mr-1 fa fa-check"></i>Mark as Sold</button>
											</div>
										</div>
									</td>
								</tr>
							<?php endwhile; ?>
							<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

							<script type="text/javascript">
								function stats($tblname, $tblid, $id, $column) {
									// alert($tblname);
									$.ajax({
										url: 'php_action/custom_action.php',
										type: 'post',
										data: { tablename: $tblname, tableid: $tblid, id: $id, column: $column },
										dataType: 'JSON',
										success: function (response) {
											console.log(response.sts);
											swal("Good job!", response.msg, response.sts);
											$("#mach_table").load(location.href + " #mach_table > *");
										}
									});

								}
							</script>
						</tbody>
					</table>

				</div>
			</div>

		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
	$(document).ready(function () {
		$(document).on('click', '.deleteVehicleBtn', function (e) {
			e.preventDefault();
			let machineId = $(this).data('id');
			let row = $(this).closest('tr'); // table row

			swal({
				title: "Are you sure?",
				text: "This will permanently delete the Machine Info and its images!",
				icon: "warning",
				dangerMode: true,
				buttons: {
					cancel: {
						text: "Cancel",
						value: false,
						visible: true,
						className: "btn btn-secondary mx-2",
						closeModal: true,
					},
					confirm: {
						text: "Yes, Delete!",
						value: true,
						visible: true,
						className: "btn btn-danger mx-2",
						closeModal: false
					}
				}
			}).then((willDelete) => {
				if (willDelete) {
					$.ajax({
						url: 'php_action/vehicle_delete.php',
						type: 'POST',
						dataType: 'json',
						data: { machine_id: machineId },
						success: function (response) {
							if (response.success) {
								swal("Deleted!", response.message, "success")
									.then(() => {
										row.remove(); // or location.reload();
									});
							} else {
								swal("Error!", response.message, "error");
							}
						},
						error: function () {
							swal("Error!", "Something went wrong. Please try again.", "error");
						}
					});
				}
			});
		});
	});
</script>
<?php
include_once "includes/footer.php";
?>