<!doctype html>
<html lang="en" dir="ltr">
	<?php include_once "includes/header.php"; include_once 'admin/includes/functions.php';






	 ?>
	<body>

		<!--Loader
		<div id="global-loader">
			<img src="assets/images/loader.svg" class="loader-img " alt="">
		</div>-->

		<!--Topbar-->
		<?php include_once "includes/topbar.php"; ?>
		<!--/Topbar-->

		<!--Section-->
		<div>
		<?php include_once "dashboard/get_partbar.php"; ?>
		</div>
		<!--Section-->

		<div class="bg-white border-bottom">
			<div class="container">
				<div class="page-header">
					<h4 class="page-title">Parts list</h4>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Pages</a></li>
						<li class="breadcrumb-item active" aria-current="page">Parts list</li>
					</ol>
				</div>
			</div>
		</div>
		<section class="spt mb-5 mt-5">
			
			<div class="container">
				<div class="row">
					<div class="col-xl-9 col-lg-9 col-md-12">
						<!--Lists-->
						<div class=" mb-0">
							<div class="">
								<div class="item2-gl ">
									<div class=" mb-0">
										<div class="">
											<div class="bg-white p-5 item2-gl-nav d-flex">
												<h6 class="mb-0 mt-3 text-left">Showing 1 to 10 of 30 entries</h6>
												<ul class="nav item2-gl-menu ml-auto mt-1">
													<li class=""><a href="#tab-11" class="active show" data-toggle="tab" title="List style"><i class="fa fa-list"></i></a></li>
													<li><a href="#tab-12" data-toggle="tab" class="" title="Grid"><i class="fa fa-th"></i></a></li>
												</ul>
												<div class="d-sm-flex">
													
													<label class="mr-2 mt-2 mb-sm-1">Sort By:</label>
													<div class="selectgroup">
														<label class="selectgroup-item mb-md-0">
															<input type="radio" name="value" value="Price" class="selectgroup-input" checked="">
															<span class="selectgroup-button">Price <i class="fa fa-sort ml-1"></i></span>
														</label>
														<label class="selectgroup-item mb-md-0">
															<input type="radio" name="value" value="Popularity" class="selectgroup-input">
															<span class="selectgroup-button">Popularity</span>
														</label>
														<label class="selectgroup-item mb-md-0">
															<input type="radio" name="value" value="Latest" class="selectgroup-input">
															<span class="selectgroup-button">Latest</span>
														</label>
														<label class="selectgroup-item mb-0">
															<input type="radio" name="value" value="Rating" class="selectgroup-input">
															<span class="selectgroup-button">Rating</span>
														</label>
													</div>
												
												</div>
											</div>
										</div>
									</div>
									<div class="tab-content">
										<div class="tab-pane active" id="tab-11">
						<?php 	

		if (isset($_REQUEST['get'])) {
			$getTypeof='vehicle_'.$_REQUEST['get'];
			$getInof=$_REQUEST['get'];
			$q=mysqli_query($dbc,"SELECT * FROM vehicle_info WHERE `$getTypeof`=".$_REQUEST[$getInof]." ");
			
		}elseif (isset($_REQUEST['s']) AND $_REQUEST['s']=="body") {
		
			 $q = mysqli_query($dbc,"SELECT vehicle_info.*,body_type.* FROM vehicle_info INNER JOIN body_type ON body_type.body_type_id = vehicle_info.vehicle_type WHERE body_type.body_type_name LIKE '%".$_REQUEST['body']."%'");

		}elseif (isset($_REQUEST['gs'])) {
		
			 $getTypeof='vehicle_'.$_REQUEST['gs'];
			$getInof=$_REQUEST['gs'];
			$q=mysqli_query($dbc,"SELECT * FROM vehicle_info WHERE `$getTypeof` LIKE '%".$_REQUEST[$getInof]."%' ");

		}elseif (isset($_REQUEST['advance'])) {
			$makerV=$brandV=$body_typeV=$optionsV=$driveV=$fuelV=$part_year=$min_price=$transmissionV='';
		if (isset($_REQUEST['maker']) AND $_REQUEST['maker']!='null') {
			$makerV="AND part_maker=".$_REQUEST['maker'];
		}
		if (isset($_REQUEST['brands']) AND $_REQUEST['brands']!='null') {
			$brandV="AND part_brand=".$_REQUEST['brands'];
		}
		if (isset($_REQUEST['options']) AND $_REQUEST['options']!='null') {
			$optionsV="AND part_option='".$_REQUEST['options']."'";
		}
		if (isset($_REQUEST['min_price']) AND $_REQUEST['min_price']!='null' AND $_REQUEST['max_price']!='null') {
			$min_price="AND  part_fob_price BETWEEN ".$_REQUEST['min_price']." AND ".$_REQUEST['max_price'] ;
		}
	
		if (isset($_REQUEST['part_year_min']) AND $_REQUEST['part_year_min']!='null' AND $_REQUEST['part_year_max']!='null') {
			$part_year="AND  part_year BETWEEN ".$_REQUEST['part_year_min']." AND ".$_REQUEST['part_year_max'] ;
		}
		if (isset($_REQUEST['transmission']) AND $_REQUEST['transmission']!='null') {
			$transmissionV="AND part_transmission='".$_REQUEST['transmission']."'";
		}
		if (isset($_REQUEST['fuel']) AND $_REQUEST['fuel']!='null') {
			$fuelV="AND vehicle_fuel='".$_REQUEST['fuel']."'";
		}
			$sq="SELECT * FROM vehicle_parts WHERE part_sts=1 ".$makerV." ".$brandV." ".$body_typeV." ".$transmissionV." ".$optionsV." ".$fuelV." ".$part_year." ".$min_price." ";
			//echo $sq;
			$q=mysqli_query($dbc,$sq);

		}else{
				$sq="SELECT * FROM vehicle_parts WHERE part_sts=1 ";
				$q=mysqli_query($dbc,$sq);

		}

if ($q):
if (mysqli_num_rows($q)>0){
	while ($getV=mysqli_fetch_assoc($q)):
//	$setVeh=getVehicleInfo($dbc,$getV['part_id'],true);
	$maker = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM maker WHERE maker_id = '".$getV['part_maker']."'"));

$brand = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM brands WHERE brand_id = '".$getV['part_brand']."' "));
	$img = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$getV[part_id]' AND images_type='part' LIMIT 1"));



						 ?>
											<div class="card overflow-hidden">
												<div class="d-md-flex">
													<div class="item-card9-img">
														<div class="arrow-ribbon bg-primary">Part</div>
														<div class="item-card9-imgs">
															<a class="link" href="singlepart.php?i=<?=base64_encode($getV['part_id'])?>"></a>
															<img src="admin/img/vehicles_images/<?=$img['vehicle_image_name']?>" alt="img" class="cover-image">
														</div>
														<div class="item-card9-icons">
															<a href="#" class="item-card9-icons1 wishlist"> <i class="fa fa fa-heart-o"></i></a>
														</div>
														<div class="item-overly-trans">
															
															<span class="d-none"><a href="cars.html" class="bg-gray">Used</a></span>
														</div>
													</div>
													<div class="card border-0 mb-0">
														<div class="card-body ">
															<div class="item-card9">
																<a href="singlepart.php?i=<?=base64_encode($getV['part_id'])?>" class="text-dark"><h4 class="font-weight-semibold mt-1"> <?=$maker['maker_name']?> <?=$brand['brand_name']?> </h4></a>
																<div class="item-card9-desc mb-2">
																	<a href="#" class="mr-4"><span class=""><i class="fa fa-truck text-muted mr-1"></i> <?=ucwords($getV['part_chassis_no'])?></span></a>
																	<a href="#" class="mr-4"><span class=""><i class="fa fa-calendar-o text-muted mr-1"></i>  <?=$getV['part_timestamp']?></span></a>
																</div>
																<p class="mb-0 leading-tight"><?=$getV['part_note']?></p>
															</div>
														</div>
														<div class="card-footer pr-4 pl-4 pt-4 pb-4">
															<div class="item-card9-footer d-sm-flex">
																<div class="item-card9-cost">
																	<h4 class="text-dark font-weight-bold mb-0 mt-0">$<?=$getV['part_fob_price']?></h4>
																</div>
																<div class="ml-auto">
																	<a href="#" class="mr-2" title="Car type"><i class="fa fa-car  mr-1 text-muted"></i>  <?=ucwords($getV['part_transmission'])?></a>
																	<a href="#" class="mr-2" title="Kilometrs"><i class="fa fa-road text-muted mr-1 "></i> <?=$getV['part_km']?>Km</a>
																	<a href="#" class="" title="FuealType"><i class="fa fa-tachometer text-muted mr-1"></i><?=ucwords($getV['part_fuel'])?></a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
<?php 	endwhile; }else{ ?>

<div class="row bg-white p-4 mb-3">
	<div class="col-sm-12">
		<h4 class="text-dark text-center">Not Found</h4>
	</div>
</div>
				
<?php } endif; 
 ?>
						</div>
									
									</div>
								</div>
								<div class="center-block text-center">
									<ul class="pagination mb-3">
										<li class="page-item page-prev disabled">
											<a class="page-link" href="#" tabindex="-1">Prev</a>
										</li>
										<li class="page-item active"><a class="page-link" href="#">1</a></li>
										<li class="page-item"><a class="page-link" href="#">2</a></li>
										<li class="page-item"><a class="page-link" href="#">3</a></li>
										<li class="page-item page-next">
											<a class="page-link" href="#">Next</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<!--/Lists-->
					</div>

					<!--Right Side Content-->
					<div class="col-xl-3 col-lg-3 col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="input-group">
									<input type="text" class="form-control br-tl-3  br-bl-3" placeholder="Search">
									<div class="input-group-append ">
										<button type="button" class="btn btn-primary br-tr-3  br-br-3">
											Search
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="card overflow-hidden">
									<form action="part-list.php" method="get">
	<input type="hidden" name="advance" value="as">
							<div class="px-4 py-3 border-bottom">
								<h4 class="mb-0">Makers</h4>
							</div>
							<div class="card-body">
								<div class="" id="container">
									<div class="filter-product-checkboxs">
					<?php $q = get($dbc,"maker WHERE maker_sts = '1'");
						 $arr_i=0;
							while($r = mysqli_fetch_assoc($q)): 
								if ($r['maker_name']!='') {
									// code...
								
						

						?>

										<label class="custom-control custom-radio mb-3">
											<input type="radio" class="custom-control-input" name="maker" value="<?=$r['maker_id']?>">
											<span class="custom-control-label">
												<?=ucwords($r['maker_name'])?><span class="label label-secondary float-right">14</span>
											</span>
										</label>
									<?php }	endwhile; ?>	
									</div>
								</div>
							</div>
			
										
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="mb-0">Price Range</h4>
							</div>

								<div class="card-body">
								<div class="row">
									<div class="form-group col-md-6 mb-0">
															<label>Price Range</label>
													<select class="form-control select2-show-search border-bottom-0 w-100 br-3" data-placeholder="Select" name="min_price">
														<optgroup label="Min Price">
															<option value="null">Min</option>
															  <?php
                               $i =1000;
                              while($i<50001){
                                ?>
                                <option value="<?=$i?>" >$<?=$i?> </option>
                                <?php
                                $i = $i+500;
                              }
                               ?>
														</optgroup>
													</select>
												</div>
									<div class="form-group col-md-6 mb-0">
													<label style="visibility: hidden;">a</label>
													<select class=" form-control select2-show-search border-bottom-0 w-100 br-3" data-placeholder="Select" name="max_price">
														<optgroup label="Max Price">
															<option value="null">Max</option>
															 <?php
                               $i =1000;
                              while($i<50001){
                                ?>
                                <option value="<?=$i?>" >$<?=$i?> </option>
                                <?php
                                $i = $i+500;
                              }
                               ?>
														</optgroup>
													</select>
												</div>
								</div>
							</div>
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="mb-0">Year</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="form-group col-md-6 mb-0">
										<label for="inputState1" class="col-form-label">Min</label>
										<select id="inputState1" name="part_year_min" class="form-control select2">
											<option value="null">Min Year</option>
										<?php $date = date('Y');
											for ($i = $date; $i >= 1900; $i--) {?>
												<option value="<?=$i?>"><?=$i?></option>
											<?php }  ?>
										</select>
									</div>
									<div class="form-group col-md-6 mb-0">
										<label for="inputState2" class="col-form-label">Max</label>
										<select id="inputState2" name="part_year_max" class="form-control select2">
											<option value="null">Max Year</option>
										<?php $date = date('Y');
											for ($i = $date; $i >= 1900; $i--) {?>
												<option value="<?=$i?>"><?=$i?></option>
											<?php }  ?>
										</select>
									</div>
								</div>
							</div>
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="mb-0">Steering</h4>
							</div>
							<div class="card-body">
								<div class="filter-product-checkboxs">
									<?php $q = get($dbc,"options WHERE option_sts = '1'");
										while($r = mysqli_fetch_assoc($q)): 
						

						?>
									<label class="custom-control custom-radio mb-2">
										<input type="radio" class="custom-control-input" name="option" value="<?=$r['option_name']?>">
										<span class="custom-control-label"><?=$r['option_name']?></span>
									</label>
								<?php endwhile; ?>
									
								</div>
							</div>
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="mb-0">Fuel Type</h4>
							</div>
							<div class="card-body">
								<div class="filter-product-checkboxs">
									<?php $q = get($dbc,"fuel WHERE fuel_sts = '1'");
										while($r = mysqli_fetch_assoc($q)): 
						?>
									<label class="custom-control custom-radio mb-2">
										<input type="radio" class="custom-control-input" name="fuel" value="<?=$r['fuel_name']?>">
										<span class="custom-control-label"><?=$r['fuel_name']?></span>
									</label>
								<?php endwhile; ?>
								</div>
							</div>
							
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="mb-0">Transmission</h4>
							</div>
							<div class="card-body">
								<div class="filter-product-checkboxs">
									<?php $q = get($dbc,"transmission WHERE transmission_sts = '1'");
										while($r = mysqli_fetch_assoc($q)): 
						?>
									<label class="custom-control custom-radio mb-2">
										<input type="radio" class="custom-control-input" name="transmission" value="<?=$r['transmission_name']?>">
										<span class="custom-control-label"><?=$r['transmission_name']?></span>
									</label>
								<?php endwhile; ?>
								</div>
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-secondary btn-block">Apply Filter</button>
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