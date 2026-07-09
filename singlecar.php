<!doctype html>
<html lang="en" dir="ltr">
	<?php
	// print_r($_REQUEST);
	// exit();
	include_once "includes/header.php"; include_once 'admin/includes/functions.php';
	?>
	<style>
		.showm {
    border: 1px solid grey !important;
    padding: 3px 8px;
    color: black !important;
    border-radius: 15px;
}
	</style>
	<body>
		<!--Loader
		<div id="global-loader">
										<img src="assets/images/loader.svg" class="loader-img " alt="">
		</div>-->
		<!--Topbar-->
		<?php @include_once "includes/topbar.php"; ?>
		<!--/Topbar-->
		<!--Section-->
		<div>
			<?php
			$vehicle_id = base64_decode($_GET['i']);
			if(empty($vehicle_id)){
			$vehicle_id = base64_decode($_GET['vehicle_id']);
			}
			//echo $vehicle_id;
			$data = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_info WHERE vehicle_id = '$vehicle_id'"));
			$maker = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM maker WHERE maker_id = '$data[vehicle_maker]'"));
			$bodyType = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM body_type WHERE body_type_id = '$data[vehicle_type]'"));
			$brand = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM brands WHERE brand_id = '$data[vehicle_brand]'"));
			$Features = json_decode($data['vehicle_feature_list']);
			$FeaturesSize = count($Features);
			$img = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$vehicle_id' AND vehicle_image_featured = '1'"));
			$imgloop = mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$vehicle_id' ORDER BY order_no ASC");
			//include_once "get_vehicle.php"; ?>
		</div>
		<!--Section-->
		<!--Section-->
		<section class="sptb">
			
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-12">
						<!--Classified Description-->
						<div class="card overflow-hidden">
							<div class="ribbon ribbon-top-left text-danger"><span class="bg-danger"><?=$data['vehicle_mode']?></span></div>
							<div class="card-body">
								<div class="item-det mb-4"><br/><br/><br/>
									<a href="#" class="text-dark"><h3>
									<?=$data['vehicle_stock_id']?>  <?=ucfirst($maker['maker_name'])?> <?=ucfirst($brand['brand_name'])?>-<?=$data['vehicle_reg_year']?> </h3></a>
									<h2> <span class="float-right" id="est_price">$<?=$data['vehicle_est_price']?> <span class="" style="font-size:15px">FOB</span> </span></h2>
									<div class=" d-flex">
										<ul class="d-flex mb-0">
											<li class="mr-5"><a href="#" class="icons"><i class="ti-car text-muted mr-1 fs-18"></i> <?=$bodyType['body_type_name']?></a></li>
											<!-- <li class="mr-5"><a href="#" class="icons"><i class="ti-location-pin text-muted mr-1"></i> USA</a></li> -->
											
											<li class="mr-5"><a href="#" class="icons"><i class="ti-eye text-muted mr-1 fs-15"></i> 765</a></li>
										</ul>
										
										<div class="rating-stars d-flex">
											<div class="rating-stars-container mr-2">
												<div class="rating-star sm">
													<i class="fa fa-heart"></i>
												</div>
											</div> 135
										</div>
									</div>
								</div>
								<div class="product-slider">
									<div id="" class=" slide" data-ride="">
										<!-- <div class="arrow-ribbon2 bg-primary">$539</div> -->
										<div class="carousel-inner">
											<div class=""> <img src="admin/img/vehicles_images/<?=$img['vehicle_image_name']?>" alt="img" class="img img-responsive" style="width: 800px"> </div>
											<?php
												while($imges = mysqli_fetch_assoc($imgloop)):
											?>
											
											<div class="" style="float: left;margin-left: 5px">
												<a data-fancybox="gallary" href="admin/img/vehicles_images/<?=$imges['vehicle_image_name']?>" target="_new"><img src="admin/img/vehicles_images/<?=$imges['vehicle_image_name']?>" alt="" class="img img-responsive" style="width: 110px; height: 100px; margin-left: 5px; margin-top: 5px;"></a>
												<!-- <img src=" admin/img/vehicles_images/<?=$imges['vehicle_image_name']?>" alt="img" style="width: 170px"> --> </div>
												<?php
												endwhile;
												?>
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header">
									<h3>Downloads</h3>
								</div>
								<div class="card-body" style="text-align: center;">
									<?php
										include_once 'admin/includes/functions.php';
										
								echo '</tr>';
								// $x = 0;
								// while ($abc) {
								//     echo $abc[$x];
								//     $x++;
								// }
								?>
								<form method='post' action='admin/downloadZip.php'>
									<input class="d-none" type="text" name="vehicle_id" value="<?=base64_decode($_GET['i'])?>">
									<input type="hidden" name="DownloadImagesZip" value="DownloadImagesZip">
									<input type="hidden" name="type" value="vehicle">
									<button type="submit" class="btn btn-success btn-block" name="create_pdf">Download Images as Zip</button>
								</form>
							</div>
						</div>
						<!--/Classified Description-->
						
						<!--Related Posts-->
						<div>
							<h2>
							Similar <?= $maker['maker_name'] ?> <!-- <?= $brand['brand_name'] ?> --> Stock.
							</h2>
						</div>
						<div class="row d-flex justify-content-between">
							<?php
							$relatedvehicle = mysqli_query($dbc,"SELECT * FROM vehicle_info WHERE vehicle_maker ='$maker[maker_id]'  AND vehicle_id !='$vehicle_id' LIMIT 3");
							// echo "SELECT * FROM vehicle_info WHERE vehicle_maker ='$maker[maker_id]'  AND vehicle_id !='$vehicle_id' LIMIT 3";
								// print_r($relatedvehicle);
							while($vehicle=mysqli_fetch_assoc($relatedvehicle)):
								// print_r($vehicle);
								$img = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$vehicle[vehicle_id]' LIMIT 1"));
								$rel_maker = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM maker WHERE maker_id = '$vehicle[vehicle_maker]'"));
								// print_r($rel_maker);
								$rel_brand = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM brands WHERE brand_id = '$vehicle[vehicle_brand]'"));
								$rel_bodytype = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM body_type WHERE body_type_id = '$vehicle[vehicle_type]'"));
								// print_r($img);
							?>
							<div class="col-sm-4">
								<div class="card">
									<div class="card-header py-2 px-2 h5">
										
										<div class="col px-0" style="">
											<?php
												if (@$img['vehicle_image_name']=='')
											{
											?>
											<a href="singlecar.php?i=<?=base64_encode(@$vehicle['vehicle_id'])?>">
												<img src="admin/img/logo/alternative.png" alt="img" class="cover-image" width="100%" style="height: 150px;">
											</a>
											<?php
												}else {
											?>
											<a href="singlecar.php?i=<?=base64_encode(@$vehicle['vehicle_id'])?>">
												<img src="admin/img/vehicles_images/<?=@$img['vehicle_image_name']?>" alt="img" class="cover-image" style="height: 150px;">
											</a>
											<?php
											}
											?>
										</div>
									</div>
									<div class="card-body py-2 px-2">
										<div class="row">
											<div class="col  pr-0">
												<a href="singlecar.php?i=<?=base64_encode(@$vehicle['vehicle_id'])?>">
													<span class="h4"><?= $rel_maker['maker_name'] ?>  <?= $rel_brand['brand_name']?> (<?= $vehicle['vehicle_manu_year']?>-<?= $vehicle['vehicle_manu_month']?>)</span>
												</a>
												<div><?= $vehicle['vehicle_transmission']?> | <?= $vehicle['vehicle_cc']?>cc</div>
												<div><span class="font-weight-bold">Car Price: $
													<span class=""><?= $vehicle['vehicle_est_price']?></span></span></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php
									endwhile;
								?>
							</div>
							<div class="row py-2">
								<div class="col-md-6 offset-md-6 font-weight-bold">
									<a href="#" class="float-right text-dark showm">Show More <i class='fa fa-caret-right'></i></a>
								</div>
							</div>
							<div class="card">
								<div class="card-body item-user">
									<h4 class="mb-4">Contact Info</h4>
									<div>
										<h6><span class="font-weight-bold"><i style="font-size: 23px;" class="fa fa-home mr-3 mb-2"></i></span><a href="#" class="text-body"> <?=$company_name?></a></h6>
										<h6><span class="font-weight-bold"><i style="font-size: 20px;" class="fa fa-envelope mr-3 mb-2"></i></span><a href="#" class="text-body"><?=$company_email?></a></h6>
										<h6><span class="font-weight-bold"><i style="font-size: 23px;" class="fa fa-phone mr-3  mb-2"></i></span><a href="#" class="text-body"> <?=$company_personal_phone?></a></h6>
										<h6><span class="font-weight-bold"><i style="font-size: 25px;" class="fa fa-mobile mr-3 mb-2"></i></span><a href="#" class="text-body"><?=$company_company_phone?></a></h6>
										<h6><span class="font-weight-bold"><i style="font-size: 23px;" class="fa fa-whatsapp mr-3 mb-2"></i></span><a href="#" class="text-body"><?=$company_company_phone?></a></h6>
										<h6><span class="font-weight-bold"><i style="font-size: 23px;" class="fa fa-map-marker mr-3 "></i></span><a class="text-body"><?=$company_address?></a></h6>
									</div>
									<div class=" item-user-icons mt-4">
										<a href="#" class="facebook-bg mt-0"><i class="fa pt-2 fa-facebook"></i></a>
										<a href="#" class="twitter-bg"><i class="fa pt-2 fa-twitter"></i></a>
										<a href="#" class="google-bg"><i class="fa pt-2 fa-google"></i></a>
										<!-- <a href="#" class="dribbble-bg"><i class="fa pt-2 fa-dribbble"></i></a> -->
									</div>
								</div>
								<div class="card-footer">
									<div class="text-left">
										<a href="mailto:info@htcjapan.com" class="btn  btn-info"><i class="fa fa-envelope"></i> Chat</a>
										<a href="https://api.whatsapp.com/send?phone=+81 80-7235-1820&amp;text=Hi..!." target="_blank" class="btn btn-primary"><i class="fa fa-user"></i> Contact Me</a>
										<!-- <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#contact"><i class="fa fa-share-alt"></i> Share</a> -->
									</div>
								</div>
							</div>
						</div>
						<!--left Side Content-->
						<div class="col-xl-6 col-lg-6 col-md-12">
							<div class="">
								<div class="">
									<div class="border-0">
										<div class="wideget-user-tab wideget-user-tab3">
											<div class="tab-menu-heading">
												<div class="tabs-menu1">
													<ul class="nav">
														<li class=""><a href="#tab-1" class="active" data-toggle="tab">Specifications</a></li>
														<li><a href="#tab-3" data-toggle="tab" class="">Features</a></li>
														<!--<li><a href="#tab-4" data-toggle="tab" class="">Vehicle Services</a></li>-->
														<?php
														if(!empty($data['vehicle_url'])):
														?>
														<li><a href="#tab-5" data-toggle="tab" class="">About Video</a></li>
														<?php
														endif;
														?>
													</ul>
												</div>
											</div>
										</div>
										<div class="tab-content border-left border-left border-top br-tr-3 border-bottom br-br-3 br-bl-3 p-5 bg-white mb-4">
											<div class="tab-pane active" id="tab-1">
												<h3 class="card-title mb-3 font-weight-semibold">Specifications</h3>
												<div class="mb-4">
													<?=$data['vehicle_note']?>
												</div>
												<!-- <h4 class="mb-4">Specifications</h4> -->
												<div class="row">
													<div class="col-xl-12 col-md-12">
														<div class="">
															<?php
															// $related = mysqli_query($dbc,"SELECT * FROM vehicle_info LIMIT 2 ORDER BY vehicle_id DESC ");
															// // print_r($related);
															// // exit();
															// while($row=mysqli_fetch_assoc($related)):
															// $maker = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM maker WHERE maker_id = '$row[vehicle_maker]'"));
															// $brand = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM brands WHERE brand_id = '$row[vehicle_brand]'"));
															// $img = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$row[vehicle_id]' AND vehicle_image_featured = '1'"));
															// endwhile;
															?>
															<table class="table table-bordered w-100 m-0 text-nowrap   " style=" text-transform: uppercase;">
																<tbody>
																	<tr>
																		<th><span class="font-weight-bold">Maker/Brand :</span> </th>
																		<td> <span style="float: left">
																		<?=ucfirst($maker['maker_name'])?> <?=ucfirst($brand['brand_name'])?></span></td>
																		<th><span class="font-weight-bold"> Body Type :</span> </th>
																		<td> <span style="float: left"><?=$bodyType['body_type_name']?></span></td>
																	</tr>
																	<tr>
																		<th><span class="font-weight-bold"> Chassis No  :</span> </th>
																		<td> <span style="float: left"><?=strtoupper(substr($data['vehicle_chassis_no'] , 0 , -5))?>XXXXX</span></td>
																		<th><span class="font-weight-bold">Chassis Code :</span> </th>
																		<?php
																		$chasis = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM models WHERE model_id = '$data[vehicle_chassis_code]'"))
																		?>
																		<td> <span style="float: left"><?=strtoupper($chasis['model_name'])?></span></td>
																		
																	</tr>
																	<tr>
																		<th><span class="font-weight-bold">Transmission  :</span> </th>
																		<td> <span style="float: left"><?=strtoupper($data['vehicle_transmission'])?></span></td>
																		<th><span class="font-weight-bold">Seats :</span> </th>
																		<td> <span style="float: left"><?=$data['vehicle_seat']?></span></td>
																	</tr>
																	<!--<tr>-->
																	<!--	<th><span class="font-weight-bold">Width  :</span> </th>-->
																	<!--	<td> <span style="float: left"><?=$data['vehicle_width']?></span></td>-->
																	<!--	<th><span class="font-weight-bold">Height :</span> </th>-->
																	<!--	<td> <span style="float: left"><?=$data['vehicle_height']?></span></td>-->
																	<!--</tr>-->
																	<tr>
																		<!--<th><span class="font-weight-bold">Length  :</span> </th>-->
																		<!--<td> <span style="float: left"><?=$data['vehicle_length']?></span></td>-->
																		<th><span class="font-weight-bold">Reg Year/month: </span> </th>
																		<td> <span style="float: left"><?=$data['vehicle_reg_year']?> - <?=$data['vehicle_reg_month']?></span></td>
																		
																		<th><span class="font-weight-bold">Fuel :</span> </th>
																		<td> <span style="float: left"><?=ucfirst($data['vehicle_fuel'])?></span></td>
																		
																	</tr>
																	<tr>
																		<th><span class="font-weight-bold">Color Code   :</span> </th>
																		<td> <span style="float: left"><?=$data['vehicle_color']?></span></td>
																		<th><span class="font-weight-bold">Color Name  :</span> </th>
																		<td> <span style="float: left"><?=$data['vehicle_color_name']?></span></td>
																		
																	</tr>
																	<tr>
																		<th><span class="font-weight-bold">Interior Color    :</span> </th>
																		<td> <span style="float: left"><?=$data['vehicle_interior']?></span></td>
																		<th><span class="font-weight-bold">Loading Capacity :</span> </th>
																		<td> <span style="float: left"><?=$data['vehicle_loading_capacity']?></span></td>
																		
																	</tr>
																	<!--<tr>-->
																	<!--	<th><span class="font-weight-bold">Total Weight   :</span> </th>-->
																	<!--	<td> <span style="float: left"><?=$data['vehicle_weight']?></span></td>-->
																	<!--	<th><span class="font-weight-bold">Engine No. :</span> </th>-->
																	<!--	<td> <span style="float: left"><?=substr($data['vehicle_engine_no'],0,-5)?>XXXXX</span></td>-->
																	
																	<!--</tr>-->
																	<tr>
																		<th><span class="font-weight-bold">Engine CC :</span> </th>
																		<td> <span style="float: left"><?=$data['vehicle_cc']?></span></td>
																		<th><span class="font-weight-bold">Engine Type  :</span> </th>
																		<td> <span style="float: left"><?=$data['vehicle_engine_type']?></span></td>
																		
																	</tr>
																	
																	<tr>
																		<th><span class="font-weight-bold">Drive: </span> </th>
																		<td> <span style="float: left"><?=$data['vehicle_drive']?></span></td>
																		<th><span class="font-weight-bold">M3 :</span> </th>
																		<td> <span style="float: left"><?=$data['vehicle_m3']?></span></td>
																		
																	</tr>
																	
																	
																</tbody>
															</table>
														</div>
													</div>
												</div>
												<hr/>
												<div class="row">
													<div class="col-md-12">
														<h3 class="card-title mb-3 font-weight-bold">Features</h3>
														<div class="table-responsive">
															<table class="table table-striped  border-top mb-0">
																<tbody>
																	<tr style="color: #000 !important;font-size: 16px;">
																		<?php
																		$count=1;
																		// $reminder='';
																			foreach ($Features as $value) {
																		?>
																		<td width="" colspan="2" class="px-2 py-2 font-weight-bold text-uppercase">
																			<i class="fa fa-check-circle text-blue"></i>
																			<?= $value ?>
																		</td>
																		<?php
																			if ($count%2=='0') {
																		?>
																	</tr>
																	<tr style="color: #000 !important;font-size: 16px;">
																		<?php
																		}
																			$count++;
																		}
																		?>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>
												<hr/>
												<!-- <div class="row">
																		
																		<div class="col-md-12">
																								<h3 class="card-title mb-3 font-weight-semibold">Extra Feature</h3>
																								<div class="table-responsive">
																														<table class="table table-bordered border-top mb-0">
																																				<tbody>
																																										<tr>
																		<?php
																			for ($i=0; $i <$FeaturesSize ; $i++) {
																		?>
																		<th><?=$Features[$i]?></th>
																		<td><i class="icon icon-check text-success"></i></td>
																		<?php
																			if (($i % 2)==0) {
																	echo "</tr><tr>";
																	}
																	}
																	?>
																</tr>
																
															</tbody>
														</table>
													</div>
												</div>
												
												
											</div> -->
										</div>
										<div class="tab-pane" id="tab-3">
											<div class="row">
												
												<div class="col-md-12">
													<h3 class="card-title mb-3 font-weight-semibold">Feature</h3>
													<div class="">
														<table class="table table-bordered border-top mb-0">
															<tbody>
																<tr>
																	<?php
																	$q1= mysqli_query($dbc,"SELECT * FROM vehicle_feature WHERE vehicle_feature_sts = '1'");
																	$i = 0;
																	while ($r = mysqli_fetch_assoc($q1)):
																	
																	
																		
																	?>
																	<?php
																	$v_f = $r['vehicle_feature_name'];
																			// if($r['vehicle_feature_name'] == $Features[$v_f ]){
																			if(in_array($r['vehicle_feature_name'],$Features)){
																				
																				if (($i % 2)==0) {
																echo "</tr><tr>";
																}
																?>
																<th><?=$r['vehicle_feature_name']?></th>
																<td><i class="icon icon-check text-success" style="font-size: 18px;"></i></td>
																<?php
																}else{
																if (($i % 2)==0) {
															echo "</tr><tr>";
															}
															?>
															<th><?=$r['vehicle_feature_name']?></th>
															<td><i class="fa fa-warning text-danger" style="font-size: 18px;"></i></td>
															<?php
															}
																
																$i++;
															endwhile;
															?>
														</tr>
														
													</tbody>
												</table>
											</div>
										</div>
										
										
									</div>
								</div>
								<div class="tab-pane" id="tab-4">
									<div class="row">
										
										<div class="col-md-12">
											<div class="table-responsive">
												<table class="table table-bordered border-top mb-0">
													<tbody>
														<tr>
															<?php
																for ($i=0; $i <$FeaturesSize ; $i++) {
															?>
															<th><?=$Features[$i]?></th>
															<td><i class="icon icon-check text-success"></i></td>
															<?php
																if (($i % 2)==0) {
														echo "</tr><tr>";
														}
														}
														?>
													</tr>
													
												</tbody>
											</table>
										</div>
									</div>
									
									
								</div>
							</div>
							
							<div class="tab-pane" id="tab-5">
								<ul class="list-unstyled video-list-thumbs row ">
									<li class="mb-0">
										<iframe width="560" height="315" src="<?=$data['vehicle_url']?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Vechicle Services</h3>
				</div>
				<div class="card-body">
					<table class="table table-bordered p-0 m-0">
						<?php
						$sql = mysqli_query($dbc,"SELECT * FROM vehicle_services WHERE vehicle_info_id='$vehicle_id' ");
						while($Veh=mysqli_fetch_assoc($sql)):
						?>
						
						
						<tr>
							<td><?=ucwords($Veh['vehicle_services_name'])?></td><td><?=$Veh['vehicle_services_amount']?></td>
						</tr>
						<?php
						endwhile;
						?>
					</table>
					</div><!-- card -->
					<div class="card-footer">
						<button type="submit" class="btn btn-primary btn-lg btn-block text-white" data-toggle="modal" data-target="#iquiryMake">Send Inquiry</button>
					</div>
				</div>
				
				
				<div class="card d-none">
					<div class="card-header">
						<h3 class="card-title">Map location</h3>
					</div>
					<div class="card-body">
						<div class="map-header">
							<div class="map-header-layer" id="map2"></div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Search Vehicle</h3>
					</div>
					<div class="card-body">
						<div class="form-group">
							<input type="text" class="form-control" id="search-text" placeholder="What are you looking for?">
						</div>
						<div class="form-group search-cars1">
						</div>
						<div>
							<a href="#" class="btn btn-block btn-primary"><i class="fa fa-search"></i> Search</a>
						</div>
					</div>
				</div>
				
			</div>
			<!--/left Side Content-->
		</div>
	</div>
</section>
<!--latest Posts-->
<?php include_once "includes/footer.php" ?>
<!--Footer Section-->
</body>
</html>
<div class="modal fade " id="iquiryMake" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
	<form action="admin/php_action/inner_action.php" method="post" id="sendInquiryfm">
		<input type="hidden" name="vehicle_id" value="<?=$_GET['i']?>">
		<input type="hidden" name="inquiry_of" value="vehicle">
		<div class="modal-header">
			<h5 class="modal-title">Send Inquiry</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="row form-group">
				<div class="col-sm-12">
					<Label>Full Name</Label>
					<input type="text" class="form-control" name="inquiry_fullName">
				</div>
			</div>
			<div class="row ">
				<div class="col-sm-6">
					<label>Email</label>
					<input type="email" class="form-control" name="inquiry_email">
				</div>
				<div class="col-sm-6">
					<label>Phone Number</label>
					<input type="text" class="form-control" name="inquiry_phoneNumber">
				</div>
			</div>
			<div class="row ">
				<div class="col-sm-6">
					<Label>Country</Label>
					<select class="form-control country_name "  name="inquiry_country">
						<option value="">Select Country</option>
						<?php
										$sql = mysqli_query($dbc,"SELECT * FROM country_regulation GROUP BY country_regulation_country");
										while($countries=mysqli_fetch_assoc($sql)):
						?>
						<option <?=(@strtoupper($invoice_country)==strtoupper($countries['country_regulation_country']))?"selected":""?> value="<?=$countries['country_regulation_country']?>"><?=$countries['country_regulation_country']?></option>
						<?php
						endwhile;
						?>
					</select>
				</div>
				<div class="col-sm-6">
					<Label>Destination Port</Label>
					<select class="form-control port_name" name="inquiry_destPort">
						<option value="">Destination Port</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					
					<Label>Select Services</Label>
					
					<select class="form-control select2-show-search border-bottom-0 w-100 br-3" multiple name="inquiry_services[]">
						<optgroup label="Select Services">
							<?php 	$sql = mysqli_query($dbc,"SELECT * FROM vehicle_services WHERE vehicle_info_id='$vehicle_id' ");
							while($Veh=mysqli_fetch_assoc($sql)): ?>
							<option value="<?=$Veh['vehicle_services_id']?>"><?=$Veh['vehicle_services_name']?></option>
							<?php endwhile ?>
						</optgroup>
					</select>
					
					
				</div>
			</div>
			<div class="row ">
				<div class="col-sm-12">
					<Label>Message</Label>
					<textarea class="form-control" name="inquiry_msg"></textarea>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" id="sendInquiryfm_btn" class="btn btn-primary">Send Iquiry</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
	</form>
</div>
</div>
</div>
<script type="text/javascript">
	$("#sendInquiryfm").on('submit',function(e) {
e.preventDefault();
e.stopPropagation(); // only neccessary if something above is listening to the (default-)event too
var form = $('#sendInquiryfm');
$.ajax({
type: 'POST',
url: form.attr('action'),
data: new FormData(this),
contentType: false,
cache: false,
processData: false,
dataType:"json",
beforeSend:function() {
$('#sendInquiryfm_btn').prop("disabled",true);
$('#sendInquiryfm_btn').text("Loading...");
},
success:function (response) {
$('#sendInquiryfm_btn').text("Save");
$('#sendInquiryfm_btn').prop("disabled",false);
$('#iquiryMake').modal("hide");
$('#sendInquiryfm').each(function(){
this.reset();
});
sweeetalert(response.msg,response.sts,2000);
}
});//ajax call
});//main
</script>
<style>
table {
display: flex;
flex-flow: column;
width: 100%;
}
thead {
flex: 0 0 auto;
}
tbody {
flex: 1 1 auto;
display: block;
overflow-y: auto;
overflow-x: hidden;
}
tr {
width: 100%;
display: table;
table-layout: fixed;
}
</style>