<?php
// print_r($_REQUEST);
// exit();
?>

<!doctype html>
<html lang="en" dir="ltr">
<style>
	.arrow-ribbonv {
		transform: rotate(-45deg) !important;
		height: 20px;
		color: #fff;
		padding: 2px 0px;
		position: absolute;
		top: 16px;
		text-align: center;
		font-size: 12px !important;
		left: -23px;
		width: 35%;
		z-index: 98;
	}
</style>
<?php
include_once "includes/header.php";
include_once 'admin/includes/functions.php';
// print_r($_REQUEST);
?>

<body>

	<div id="global-loader">
		<img src="assets/images/loader.svg" class="loader-img" alt="">
	</div>
	<!--Topbar-->
	<?php include_once "includes/topbar.php"; ?>
	<!--/Topbar-->
	<!--Section-->
	<div>
		<?php //include_once "get_vehicle.php"; ?>
	</div>
	<?php
	if (@$_REQUEST['maker'] == 'null') {
		?>
		<!-- <meta http-equiv = "refresh" content = "0; url = car-lists?type=htcjapan_stock" /> -->
		<?php
		// echo "abcd";			
	}
	@$type = $_GET['type'];

	@$limit = 10;

	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

	$offsets = ($page - 1) * $limit;

	if (@$type == 'htcjapan_stock') {
		@$query = mysqli_query($dbc, "SELECT * FROM vehicle_info ORDER BY vehicle_id DESC LIMIT {$offsets},{$limit}");

	} elseif (isset($_REQUEST['get'])) {
		$getTypeof = 'vehicle_' . $_REQUEST['get'];
		// echo $getTypeof;
		$getInof = $_REQUEST['get'];
		// $new=mysqli_query($dbc,"SELECT vehicle_info.*,maker.* FROM vehicle_info INNER JOIN maker ON  WHERE `$getTypeof`=".$_REQUEST[$getInof]." ");
		$query = mysqli_query($dbc, "SELECT * FROM vehicle_info WHERE `$getTypeof`=" . $_REQUEST[$getInof] . " ORDER BY vehicle_id DESC");
		// echo "SELECT * FROM vehicle_info WHERE `$getTypeof`=".$_REQUEST[$getInof]."";
	
	} elseif (isset($_REQUEST['s']) and $_REQUEST['s'] == "body") {

		$query = mysqli_query($dbc, "SELECT vehicle_info.*,body_type.* FROM vehicle_info INNER JOIN body_type ON body_type.body_type_id = vehicle_info.vehicle_type WHERE body_type.body_type_name LIKE '%" . $_REQUEST['body'] . "%' ORDER BY vehicle_info.vehicle_id DESC");
	} elseif (isset($_REQUEST['gs'])) {

		$getTypeof = 'vehicle_' . $_REQUEST['gs'];
		$getInof = $_REQUEST['gs'];
		$query = mysqli_query($dbc, "SELECT * FROM vehicle_info WHERE `$getTypeof` LIKE '%" . $_REQUEST[$getInof] . "%' ORDER BY vehicle_id DESC LIMIT {$offsets},{$limit} ");
	} elseif (isset($_REQUEST['advance'])) {
		$stockidV = $makerV = $brandV = $body_typeV = $optionsV = $driveV = $fuelV = $min_year = $reg_year_from = $min_price = $transmissionV = $newV = $discountV = $min_pr = '';

		if (isset($_REQUEST['maker']) and $_REQUEST['maker'] != 'null' and $_REQUEST['maker'] != '0') {
			$makerV = "AND vehicle_maker=" . $_REQUEST['maker'];
		}
		if (isset($_REQUEST['brands']) and $_REQUEST['brands'] != 'null') {
			$brandV = "AND vehicle_brand=" . $_REQUEST['brands'];
		}
		if (isset($_REQUEST['body_type']) and $_REQUEST['body_type'] != 'null') {
			$body_typeV = "AND vehicle_type=" . $_REQUEST['body_type'];
			// print_r($body_typeV);
		}
		if (isset($_REQUEST['options']) and $_REQUEST['options'] != 'null') {
			$optionsV = "AND vehicle_option='" . $_REQUEST['options'] . "'";
		}
		if (isset($_REQUEST['drive']) and $_REQUEST['drive'] != 'null') {
			$driveV = "AND vehicle_drive='" . $_REQUEST['drive'] . "'";
		}
		if (isset($_REQUEST['fuel']) and $_REQUEST['fuel'] != 'null') {
			$fuelV = "AND vehicle_fuel='" . $_REQUEST['fuel'] . "'";
		}
		if (isset($_REQUEST['transmission']) and $_REQUEST['transmission'] != 'null') {
			$transmissionV = "AND vehicle_transmission='" . $_REQUEST['transmission'] . "'";
		}
		if (!empty($_REQUEST['stockid']) and $_REQUEST['stockid'] != 'null') {
			$stockidV = "AND vehicle_stock_id='" . $_REQUEST['stockid'] . "'";
		}
		// echo $stockidV ;
		if (isset($_REQUEST['minimum_price']) and $_REQUEST['minimum_price'] != 'null' and $_REQUEST['maximum_price'] != 'null') {
			$min_pr = "AND vehicle_est_price BETWEEN " . $_REQUEST['minimum_price'] . " AND " . $_REQUEST['maximum_price'];
		}


		// -----------
	

		if (isset($_REQUEST['reg_year_from']) and $_REQUEST['reg_year_from'] != 'null' and $_REQUEST['reg_year_to'] != 'null') {
			$reg_year_from = "AND vehicle_reg_year BETWEEN " . $_REQUEST['reg_year_from'] . " AND " . $_REQUEST['reg_year_to'];
		}
		if (isset($_REQUEST['min_price']) and $_REQUEST['min_price'] != 'null' and $_REQUEST['max_price'] != 'null') {
			$min_price = "AND vehicle_est_price BETWEEN " . $_REQUEST['min_price'] . " AND " . $_REQUEST['max_price'];
		}
		if (isset($_REQUEST['min_year']) and $_REQUEST['min_year'] != 'null' and $_REQUEST['max_year'] != 'null') {
			@$min_year = "AND vehicle_manu_year BETWEEN " . $_REQUEST['min_year'] . " AND " . $_REQUEST['max_year'];
		}
		if (isset($_REQUEST['discount']) == 'discount') {
			$discountV = "AND vehicle_mode='" . $_REQUEST['discount'] . "'";
		}
		if (isset($_REQUEST['new']) == 'new') {
			$newV = "AND vehicle_mode='" . $_REQUEST['new'] . "'";
		}
		$sq = "SELECT * FROM vehicle_info WHERE vehicle_status!='' " . $makerV . " " . $brandV . " " . $body_typeV . " " . @$transmissionV . " " . $optionsV . " " . $driveV . " " . $fuelV . " " . $reg_year_from . " " . $min_price . " " . $stockidV . " " . @$min_year . " " . @$discountV . " " . @$newV . " " . $min_pr . " ORDER BY vehicle_id DESC LIMIT {$offsets},{$limit} ";
		//echo $sq;
		$query = mysqli_query($dbc, $sq);

	}
	?>
	<!--Section-->
	<div class="bg-white border-bottom">
		<div class="container">
			<div class="page-header">
				<h2 class="page-title "><a class="text-dark" href="car-lists.php?type=htcjapan_stock">Cars list</a></h2>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Pages</a></li>
					<li class="breadcrumb-item active" aria-current="page">Cars list</li>
				</ol>
			</div>
		</div>
	</div>
	<section class="spt mb-5 mt-5">

		<div class="container-fluid">
			<div class="row d-flex justify-content-center">
				<!-- <div class="col-xl-2 col-lg-2 col-md-12">
						<?php // include "brandbar.php"; ?>
					</div> -->
				<div class="col-xl-8 col-lg-8 col-md-12">
					<!--Lists-->
					<div class=" mb-0">
						<div class="">
							<div class="item2-gl ">
								<div class=" mb-0">
									<div class="bg-white p-3 item2-gl-nav d-flex">
										<h2 class="mb-0  text-left">
											<?php
											if (isset($_REQUEST['maker'])) {
												$maker_id = $_REQUEST['maker'];
												$maker = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM maker WHERE	maker_id = '$maker_id'"))
												;

												// print_r($maker);
												?>
												<img src="admin/img/vehicles_images/<?= $maker['maker_img'] ?>" width='60px'
													alt="">
												<span class="pt-2">
													<?= @$maker['maker_name'] ?> Stock
												</span>
												<?php
											} else {
												?>
												All HTC Japan Stock
												<?php
											}
											?>
										</h2>
									</div>
								</div>
								<div class="center-block text-center py-3">
									<?php
									// Initialize count query
									$sql1 = null;
									$query_string = http_build_query($_REQUEST); // Preserve all request parameters for pagination links
									
									if (@$type == 'htcjapan_stock') {
										$sql1 = mysqli_query($dbc, "SELECT COUNT(*) as total FROM vehicle_info");
									} elseif (isset($_REQUEST['get'])) {
										$getTypeof = 'vehicle_' . $_REQUEST['get'];
										$getInof = $_REQUEST['get'];
										$sql1 = mysqli_query($dbc, "SELECT COUNT(*) as total FROM vehicle_info WHERE `$getTypeof`=" . mysqli_real_escape_string($dbc, $_REQUEST[$getInof]));
									} elseif (isset($_REQUEST['s']) && $_REQUEST['s'] == "body") {
										$sql1 = mysqli_query($dbc, "SELECT COUNT(*) as total FROM vehicle_info INNER JOIN body_type ON body_type.body_type_id = vehicle_info.vehicle_type WHERE body_type.body_type_name LIKE '%" . mysqli_real_escape_string($dbc, $_REQUEST['body']) . "%'");
									} elseif (isset($_REQUEST['gs'])) {
										$getTypeof = 'vehicle_' . $_REQUEST['gs'];
										$getInof = $_REQUEST['gs'];
										$sql1 = mysqli_query($dbc, "SELECT COUNT(*) as total FROM vehicle_info WHERE `$getTypeof` LIKE '%" . mysqli_real_escape_string($dbc, $_REQUEST[$getInof]) . "%'");
									} elseif (isset($_REQUEST['advance'])) {
										$count_sq = "SELECT COUNT(*) as total FROM vehicle_info WHERE vehicle_status!='' " . $makerV . " " . $brandV . " " . $body_typeV . " " . $transmissionV . " " . $optionsV . " " . $driveV . " " . $fuelV . " " . $reg_year_from . " " . $min_price . " " . $stockidV . " " . $min_year . " " . $discountV . " " . $newV . " " . $min_pr;
										$sql1 = mysqli_query($dbc, $count_sq);
									}
									if ($sql1 && mysqli_num_rows($sql1) > 0) {
										$row = mysqli_fetch_assoc($sql1);
										$total_row = $row['total'];
										$totalpage = ceil($total_row / $limit);
										?>
										<ul class="pagination mb-3 d-flex justify-content-end">
											<?php if ($page > 1) { ?>
												<li class="page-item"><a class="page-link"
														href="car-lists.php?<?php echo $query_string; ?>&page=<?= $page - 1 ?>">Pre</a>
												</li>
											<?php } ?>
											<?php
											for ($i = 1; $i <= $totalpage; $i++) {
												$active = ($i == $page) ? 'active' : '';
												?>
												<li class="page-item <?= $active ?>"><a class="page-link ml-1 mr-1"
														href="car-lists.php?<?php echo $query_string; ?>&page=<?= $i ?>"><?= $i ?></a>
												</li>
												<?php
											}
											?>
											<?php if ($totalpage > $page) { ?>
												<li class="page-item"><a class="page-link"
														href="car-lists.php?<?php echo $query_string; ?>&page=<?= $page + 1 ?>">Next</a>
												</li>
											<?php } ?>
										</ul>
										<?php
									}
									?>
								</div>
								<div class="tab-content pt-0">
									<div class="tab-pane active" id="tab-11">
										<?php
										// print_r(json_encode($_REQUEST));
										if (@$query):
											if (mysqli_num_rows($query) > 0) {
												while (@$getV = mysqli_fetch_assoc($query)):
													// print_r(@$getV['vehicle_id']);
													@$setVeh = getVehicleInfo($dbc, @$getV['vehicle_id'], true);
													// print_r($setVeh);
													$img = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM vehicle_images WHERE vehicle_id = '$getV[vehicle_id]' AND vehicle_image_featured = 1 LIMIT 1"));
													?>
													<div class="card overflow-hidden">
														<div class="d-md-flex" style="height: ;">
															<div class="item-card9-img">
																<div class="arrow-ribbonv bg-primary">
																	<?= ucwords(@$getV['vehicle_mode']) ?>
																</div>
																<div class="item-card9-imgs">
																	<a class="link"
																		href="singlecar.php?i=<?= base64_encode(@$getV['vehicle_id']) ?>"></a>
																	<img src="admin/img/vehicles_images/<?= $img['vehicle_image_name'] ?>"
																		alt="img" class="cover-image">
																</div>
																<div class="item-card9-icons">
																	<a href="#" class="item-card9-icons1 wishlist"> <i
																			class="fa fa fa-heart-o"></i></a>
																</div>
															</div>
															<div class="card mb-0" style="border: none !important;">
																<div class="card-body border-0 pt-2 pl-2 pb-0">
																	<div class="item-card9">
																		<a href="singlecar.php?i=<?= base64_encode(@$getV['vehicle_id']) ?>"
																			class="text-dark">
																			<h4 class="font-weight-semibold mt-1">
																				<?= @$setVeh['vehicle_stock_id'] ?>
																				<?= @$setVeh['maker_name'] ?>
																				<?= @$setVeh['brand_name'] ?>
																			</h4>
																		</a>
																		<a class=""
																			href="https://api.whatsapp.com/send?phone=+81-90-9961-1411&amp;text=Hi..!."
																			target="_blank">
																			<img class="float-right mr-3"
																				src="admin/img/socialicon/whatsapp.png" width="30px"
																				alt="">
																		</a>
																		<div class="item-card9-desc pt-1">
																			<a href="#" class="mr-4"><span class=""><i
																						class="fa fa-truck text-muted mr-1"></i>
																					<?= ucwords(@$setVeh['body_type_name']) ?></span></a>
																			<a href="#" class="mr-4"><span class=""></span></a>
																		</div>
																	</div>
																	<div class="item-card9-cost pt-1">
																		<span>Total Price:</span>
																		<h3 class="d-inline text-danger font-weight-bold mb-0 mt-0">
																			$<?= @$setVeh['vehicle_est_price'] ?></h3>
																	</div>
																	<div class="ml-auto pt-1">
																		<a href="#" class="mr-2" title="Car type"><i
																				class="fa fa-car  mr-1 text-muted"></i>
																			<?= ucwords(@$setVeh['vehicle_transmission']) ?></a>
																		<a href="#" class="mr-2" title="Color"><i
																				class="fa fa-tint mr-1 text-muted"></i>
																			<?= ucwords(@$setVeh['vehicle_color_name']) ?></a>
																		<a href="#" class="mr-2" title="FuealType"><i
																				class="fa fa-tachometer text-muted mr-1"></i><?= ucwords(@$setVeh['vehicle_fuel']) ?></a>
																		<a href="#" class="mr-2" title="FuealType"><i
																				class="fa fa-tachometer text-muted mr-1"></i><?= ucwords(@$setVeh['vehicle_cc']) ?>CC</a>
																		<a href="#" class="mr-2" title="FuealType"><i
																				class="fa fa-tachometer text-muted mr-1"></i><?= ucwords(@$setVeh['vehicle_drive']) ?></a>
																	</div>
																</div>
																<div class="card-footer p-3"
																	style="background-color: #f4efef !important;">
																	<div class="item-card9-footer">
																		<div class="ml-auto">
																			<a href="#" style="font-size: 15px;"
																				class="mr-2 text-dark font-weight-semibold"
																				title="Car type"><?= ucwords(@$setVeh['vehicle_access']) ?></a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												<?php endwhile;
											} else { ?>
												<div class="row bg-white p-4 mb-3">
													<div class="col-sm-12">
														<h4 class="text-dark text-center">Not Found</h4>
													</div>
												</div>

												<?php
											}
										endif;
										?>
									</div>
								</div>
							</div>
							<div class="center-block text-center py-3">
								<?php
								// Initialize count query
								$sql1 = null;
								$query_string = http_build_query($_REQUEST); // Preserve all request parameters for pagination links
								
								if (@$type == 'htcjapan_stock') {
									$sql1 = mysqli_query($dbc, "SELECT COUNT(*) as total FROM vehicle_info");
								} elseif (isset($_REQUEST['get'])) {
									$getTypeof = 'vehicle_' . $_REQUEST['get'];
									$getInof = $_REQUEST['get'];
									$sql1 = mysqli_query($dbc, "SELECT COUNT(*) as total FROM vehicle_info WHERE `$getTypeof`=" . mysqli_real_escape_string($dbc, $_REQUEST[$getInof]));
								} elseif (isset($_REQUEST['s']) && $_REQUEST['s'] == "body") {
									$sql1 = mysqli_query($dbc, "SELECT COUNT(*) as total FROM vehicle_info INNER JOIN body_type ON body_type.body_type_id = vehicle_info.vehicle_type WHERE body_type.body_type_name LIKE '%" . mysqli_real_escape_string($dbc, $_REQUEST['body']) . "%'");
								} elseif (isset($_REQUEST['gs'])) {
									$getTypeof = 'vehicle_' . $_REQUEST['gs'];
									$getInof = $_REQUEST['gs'];
									$sql1 = mysqli_query($dbc, "SELECT COUNT(*) as total FROM vehicle_info WHERE `$getTypeof` LIKE '%" . mysqli_real_escape_string($dbc, $_REQUEST[$getInof]) . "%'");
								} elseif (isset($_REQUEST['advance'])) {
									$count_sq = "SELECT COUNT(*) as total FROM vehicle_info WHERE vehicle_status!='' " . $makerV . " " . $brandV . " " . $body_typeV . " " . $transmissionV . " " . $optionsV . " " . $driveV . " " . $fuelV . " " . $reg_year_from . " " . $min_price . " " . $stockidV . " " . $min_year . " " . $discountV . " " . $newV . " " . $min_pr;
									$sql1 = mysqli_query($dbc, $count_sq);
								}
								if ($sql1 && mysqli_num_rows($sql1) > 0) {
									$row = mysqli_fetch_assoc($sql1);
									$total_row = $row['total'];
									$totalpage = ceil($total_row / $limit);
									?>
									<ul class="pagination mb-3 d-flex justify-content-end">
										<?php if ($page > 1) { ?>
											<li class="page-item"><a class="page-link"
													href="car-lists.php?<?php echo $query_string; ?>&page=<?= $page - 1 ?>">Pre</a>
											</li>
										<?php } ?>
										<?php
										for ($i = 1; $i <= $totalpage; $i++) {
											$active = ($i == $page) ? 'active' : '';
											?>
											<li class="page-item <?= $active ?>"><a class="page-link ml-1 mr-1"
													href="car-lists.php?<?php echo $query_string; ?>&page=<?= $i ?>"><?= $i ?></a>
											</li>
											<?php
										}
										?>
										<?php if ($totalpage > $page) { ?>
											<li class="page-item"><a class="page-link"
													href="car-lists.php?<?php echo $query_string; ?>&page=<?= $page + 1 ?>">Next</a>
											</li>
										<?php } ?>
									</ul>
									<?php
								}
								?>
							</div>
						</div>
					</div>
					<!--/Lists-->
				</div>
				<!--Right Side Content-->
				<div class="col-xl-2 col-lg-2 col-md-12">
					<!-- <div class="card">
								<div class="card-body p-3">
										<div class="input-group">
												<input type="text" class="form-control br-tl-3  br-bl-3" placeholder="Search">
												<div class="input-group-append ">
														<button type="button" class="btn btn-primary br-tr-3  br-br-3">
															Search
														</button>
												</div>
										</div>
								</div>
						</div> -->
					<div class="card overflow-hidden">
						<form action="car-lists.php" method="post">
							<input type="hidden" name="advance" value="as">
							<!-- <div class="px-4 py-3 border-bottom">
										<h4 class="text-danger">Makers</h4>
								</div>
								<div class="card-body p-3">
										<div class="" id="container">
												<div class="filter-product-checkboxs">
											<?php $query = get($dbc, "maker WHERE maker_sts = '1'");
											$arr_i = 0;
											while ($r = mysqli_fetch_assoc($query)):
												if ($r['maker_name'] != '') {
													?>
											<label class="custom-control custom-radio mb-3">
												<input type="radio" class="custom-control-input" name="maker" value="<?= $r['maker_id'] ?>">
												<span class="custom-control-label">
													<?= ucwords($r['maker_name']) ?><span class="label label-secondary float-right">14</span>
												</span>
											</label>
											<?php }endwhile; ?>
										</div>
									</div>
								</div> -->


							<div class="px-4 py-3 border-bottom">
								<h4 class="text-purple mb-0">Price Range</h4>
							</div>
							<div class="card-body p-3">
								<div class="row">
									<div class="form-group col-md-6 mb-0">
										<label>Price Range</label>
										<select class="form-control select2-show-search border-bottom-0 w-100 br-3"
											data-placeholder="Select" name="min_price">
											<optgroup label="Min Price">
												<option value="null">Min</option>
												<?php
												$i = 1000;
												while ($i < 50001) {
													?>

													<option value="<?= $i ?>">$<?= $i ?> </option>
													<?php
													$i = $i + 500;
												}
												?>
											</optgroup>
										</select>
									</div>
									<div class="form-group col-md-6 mb-0">
										<label style="visibility: hidden;">a</label>
										<select class=" form-control select2-show-search border-bottom-0 w-100 br-3"
											data-placeholder="Select" name="max_price">
											<optgroup label="Max Price">
												<option value="null">Max</option>
												<?php
												$i = 1000;
												while ($i < 50001) {
													?>
													<option value="<?= $i ?>">$<?= $i ?> </option>
													<?php
													$i = $i + 500;
												}
												?>
											</optgroup>
										</select>
									</div>
								</div>
							</div>
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="text-purple mb-0">Year</h4>
							</div>
							<div class="card-body p-3">
								<div class="row">

									<div class="form-group col-md-6 mb-0">
										<label>Year Range</label>

										<select id="inputState1" class="form-control select2" name="min_year">
											<option value="null">Min Year</option>
											<?php $date = date('Y');
											for ($i = $date; $i >= 1900; $i--) { ?>
												<option value="<?= $i ?>"><?= $i ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group col-md-6 mb-0">
										<label style="visibility: hidden;">Price Range</label>

										<select id="inputState2" class="form-control select2" name="max_year">
											<option value="null">Max Year</option>
											<?php $date = date('Y');
											for ($i = $date; $i >= 1900; $i--) { ?>
												<option value="<?= $i ?>"><?= $i ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="text-purple mb-0">Drive</h4>
							</div>
							<div class="card-body p-3">
								<div class="filter-product-checkboxs">
									<?php $query = get($dbc, "drive WHERE drive_sts = '1'");
									while ($r = mysqli_fetch_assoc($query)):

										?>
										<label class="custom-control custom-radio mb-2">
											<input type="radio" class="custom-control-input" name="drive"
												value="<?= $r['drive_name'] ?>">
											<span class="custom-control-label"><?= $r['drive_name'] ?></span>
										</label>
									<?php endwhile; ?>

								</div>
							</div>
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="text-purple mb-0">Fuel Type</h4>
							</div>
							<div class="card-body p-3">
								<div class="filter-product-checkboxs">
									<?php $query = get($dbc, "fuel WHERE fuel_sts = '1'");
									while ($r = mysqli_fetch_assoc($query)):
										?>
										<label class="custom-control custom-radio mb-2">
											<input type="radio" class="custom-control-input" name="fuel"
												value="<?= $r['fuel_name'] ?>">
											<span class="custom-control-label"><?= $r['fuel_name'] ?></span>
										</label>
									<?php endwhile; ?>
								</div>
							</div>
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="text-purple mb-0">Body Type</h4>
							</div>
							<div class="card-body p-3">
								<div class="filter-product-checkboxs">
									<?php $query = get($dbc, "body_type WHERE body_type_sts = '1'");
									while ($r = mysqli_fetch_assoc($query)):
										?>
										<label class="custom-control custom-radio mb-2">
											<input type="radio" class="custom-control-input" name="body_type"
												value="<?= $r['body_type_id'] ?>">
											<span class="custom-control-label"><?= $r['body_type_name'] ?></span>
										</label>
									<?php endwhile; ?>
								</div>
							</div>
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="text-purple mb-0">Transmission</h4>
							</div>
							<div class="card-body p-3">
								<div class="filter-product-checkboxs">
									<?php $query = get($dbc, "transmission WHERE transmission_sts = '1'");
									while ($r = mysqli_fetch_assoc($query)):
										?>
										<label class="custom-control custom-radio mb-2">
											<input type="radio" class="custom-control-input" name="transmission"
												value="<?= $r['transmission_name'] ?>">
											<span class="custom-control-label"><?= $r['transmission_name'] ?></span>
										</label>
									<?php endwhile; ?>
								</div>
							</div>
							<div class="card-footer text-center">
								<button type="submit" class="btn btn-purple showmore">Apply Filter</button>
							</div>
					</div>
					</form>
				</div>
				<!--/Right Side Content-->
			</div>
		</div>

	</section>
	<!--latest Posts-->
	<?php include_once "includes/footer.php" ?>
	<!--Footer Section-->
</body>

</html>