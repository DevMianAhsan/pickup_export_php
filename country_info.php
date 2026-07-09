<?php


include_once "includes/header.php";
$country_code = @$_REQUEST['country_code'];
$countrynameFetch		= @$_REQUEST['countryname'];


$sql = mysqli_query($dbc,"SELECT * FROM countries WHERE country_code = 'country_code' OR country_name = '$countrynameFetch' ");

while($country = mysqli_fetch_assoc($sql)){

	$countryname = strtolower($country['country_name']);



	$regulations = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM country_regulation WHERE country_regulation_country = '$countryname'"));
	if(empty($regulations)){
			$age = 0;
	}else{
			$age = $regulations['country_regulation_year'];
	}
}

$offices = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM nexco_offices  "));



 $maker		= @$_GET['maker'];
 $model		= @$_GET['model'];
 $body_type		= @$_GET['body_type'];
 
 $fromyear		= @$_GET['fromyear'];
 $frommonth		= @$_GET['frommonth'];
 $toyear		= @$_GET['toyear'];
 $tomonth		= @$_GET['tomonth'];
 $price_from	= @$_GET['price_from'];
 $price_to		= @$_GET['price_to'];
 $stockid		= @$_GET['stockid'];


$vehicle_info = mysqli_query($dbc,"SELECT * FROM vehicle_info WHERE vehicle_est_price > '-1'  AND vehicle_maker =  '$maker' OR vehicle_brand = '$model' OR vehicle_type = '$body_type' ");
$vehicle_info2 = mysqli_query($dbc,"SELECT * FROM vehicle_info WHERE vehicle_est_price > '-1'  AND vehicle_maker =  '$maker' OR vehicle_brand = '$model' OR vehicle_type = '$body_type' ");

?>
<!--Breadcrumb-->
		<!-- <div class="bg-white border-bottom">
			<div class="container">
				<div class="page-header">
					<h4 class="page-title">Country Regulation and Car</h4>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Pages</a></li>
						<li class="breadcrumb-item active" aria-current="page">Cars list</li>
					</ol>
				</div>
			</div>
		</div> -->
		<!--/Breadcrumb-->


		<!--Section-->
		<div>
			<div class="cover-image  bg-background" data-image-src=" assets/images/banners/banner1.jpg">
				<div class="header-text1 mb-0">
					<div class="container">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 d-block mx-auto">
								<div class="text-center text-white "><br/>
									<h1 class=""><span class="font-weight-bold">16,25,365&nbsp;</span>Offered Cars Available</h1>
								</div>
								<div class="search-background bg-transparent mt-5">
									<div class="form row no-gutters ">
										<div class="form-group  col-xl-3 col-lg-3 col-md-3 mb-0 bg-white ">
											<div class="card">
												<div class="card-title text-center label label-info" >Country </div>
												<div class="card-body text-center">
													<img src="assets/images/flags/<?=strtolower($country_code)?>.svg" alt="img" style="width: 200px" class="" ><br/>
													<br/>

													<h6><b>Country Name:</b><?=strtoupper($countryname) ?></h6>
													<table class="table table-bordered table-hover" style="font-size: 12px">
								
								<tr>
									<th>Age Limit:</th>
									<td><?=$age?></td>
								</tr>
								<tr>
									<th>Ports:</th>
									<td><?=$regulations['country_regulation_destination_port']?></td>
								</tr>
								<tr>
									<th>Inspection:</th>
									<td><?=$regulations['country_regulation_inspection']?></td>
								</tr>

								<tr>
									<th>Hand:</th>
									<td><?=$regulations['country_regulation_hand']?></td>
								</tr>



							</table>

								
													
												</div>
											</div>
										</div>
										
										
									

							<div class="form-group  col-xl-6 col-lg-6 col-md-6 mb-0 bg-white ">

								<?php

									include_once "slider.php"
								?>
								<br/>

											<div class="card">
												<div class="card-title text-center"><?=$countryname ?> Sellers</div>
												<div class="card-body">

						<table class="table table-bordered">
							<tr>
								<td> Name</td>
								<td><?=$offices['office_sellername'] ?></td>
							</tr>
							<tr>
								<td> Phone</td>
								<td><?=$offices['office_sellerphone'] ?></td>
							</tr>
							<tr>
								<td> Post</td>
								<td><?=$offices['office_sellerpost'] ?></td>
							</tr>
							
						</table>							
													

								
													
												</div>
											</div>
										</div><!-- 9 sm end -->
										<div class="form-group  col-xl-3 col-lg-3 col-md-3 mb-0 bg-white ">
								<div class="card">
									<div class="card-title text-center label label-info">Office Info</div>
									<div class="card-body">
											<table class="table table-bordered table-hover">
								<tr>
									<td>Office Name:</td>
									<td><?=$offices['office_name'] ?></td>
									
									
									
									
								</tr>
								<tr>
									<td>Office Address:</td>
									<td><?=$offices['office_address'] ?></td>
									
									
								</tr>
								<tr>
									<td>Office Phone:</td>
									<td><?=$offices['office_phone'] ?></td>
								</tr>
								<tr  >
									<td colspan="2">Office Map Location:</td>
								</tr>
								<tr>

									<td colspan="2">
										<img src="https://www.google.com/maps/d/u/0/thumbnail?mid=1_wV22amgac2Wt4gvMqstKu57Fg0">
											
										</td>
								</tr>
								



							</table>
						</div>
					</div>

										</div>
										
										
										
									</div>
								</div>
							</div><!-- Col-sm-6 end -->
						</div>
					</div>
				</div><!-- /header-text -->
			</div>
		</div>
		<!--Section-->

		

		<!--listing-->
		<section class="sptb">
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

while($vehicle = mysqli_fetch_assoc($vehicle_info)):
	$vehicle_id = $vehicle['vehicle_id'];
	$maker = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM maker WHERE maker_id = '$vehicle_id'"));
$brand = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM brands WHERE brand_id = '$vehicle_id'"));
	$img = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$vehicle_id'"));
?>											
											<div class="card overflow-hidden ">
												<div class="d-md-flex">
													<div class="item-card9-img">
														<div class="arrow-ribbon bg-primary"><?=$vehicle['vehicle_mode']?></div>
														<div class="item-card9-imgs">
															<a class="link" href="singlecar.php?vehicle_id=<?=base64_encode($vehicle['vehicle_id'])?>"></a>
															<img src="admin/img/vehicles_images/<?=$img['vehicle_image_name']?>" alt="img" class="cover-image">
														</div>
														<div class="item-card9-icons">
															<a href="#" class="item-card9-icons1 wishlist"> <i class="fa fa fa-heart-o"></i></a>
														</div>
														<div class="item-overly-trans">
															<div class="rating-stars">
																<input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value"  value="3">
																<div class="rating-stars-container">
																	<div class="rating-star sm">
																		<i class="fa fa-star"></i>
																	</div>
																	<div class="rating-star sm">
																		<i class="fa fa-star"></i>
																	</div>
																	<div class="rating-star sm">
																		<i class="fa fa-star"></i>
																	</div>
																	<div class="rating-star sm">
																		<i class="fa fa-star"></i>
																	</div>
																	<div class="rating-star sm">
																		<i class="fa fa-star"></i>
																	</div>
																</div>
															</div>
															<span><a href="singlecar.php?vehicle_id=<?=base64_encode($vehicle['vehicle_id'])?>" class="bg-blue">Used</a></span>
														</div>
													</div>
													<div class="card border-0 mb-0">
														<div class="card-body ">
															<div class="item-card9">
																<a href="cars.html" class="text-dark"><h4 class="font-weight-semibold mt-1"> <?=$maker['maker_name']?> <?=$brand['brand_name']?></h4></a>
																<div class="item-card9-desc mb-2">
																	<a href="#" class="mr-4"><span class=""><i class="fa fa-map-marker text-muted mr-1"></i> Japan</span></a>
																	<a href="#" class="mr-4"><span class=""><i class="fa fa-calendar-o text-muted mr-1"></i>  2 days ago</span></a>
																</div>
																<p class="mb-0 leading-tight">
																	<?=$vehicle['vehicle_note']?> 
																</p>
															</div>
														</div>
														<div class="card-footer pr-4 pl-4 pt-4 pb-4">
															<div class="item-card9-footer d-sm-flex">
																<div class="item-card9-cost">
																	<h4 class="text-dark font-weight-bold mb-0 mt-0">$<?=$vehicle['vehicle_est_price']?> </h4>
																</div>
																<div class="ml-auto">
																	<a href="#" class="mr-2" title="Car type"><i class="fa fa-car  mr-1 text-muted"></i>  <?=$vehicle['vehicle_type']?></a>
																	<a href="#" class="mr-2" title="Kilometrs"><i class="fa fa-road text-muted mr-1 "></i><?=$vehicle['vehicle_km']?></a>
																	<a href="#" class="" title="FuealType"><i class="fa fa-tachometer text-muted mr-1"></i><?=$vehicle['vehicle_fuel']?></a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											
<?php
endwhile;
?>	
											
											
											
										</div>
										<div class="tab-pane" id="tab-12">
											<div class="row">

<?php

while($vehicle2 = mysqli_fetch_assoc($vehicle_info2)):
	$vehicle_id = $vehicle2['vehicle_id'];
	$maker = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM maker WHERE maker_id = '$vehicle_id'"));
$brand = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM brands WHERE brand_id = '$vehicle_id'"));
	$img = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$vehicle_id'"));
?>													
												<div class="col-lg-6 col-md-12 col-xl-4">
													<div class="card overflow-hidden">
														<div class="item-card9-img">
															<div class="arrow-ribbon bg-primary">$<?=$vehicle2['vehicle_est_price']?></div>
															<div class="item-card9-imgs">
																<a class="link" href="singlecar.php?vehicle_id=<?=base64_encode($vehicle2['vehicle_id'])?>"></a>
																<img src="admin/img/vehicles_images/<?=$img['vehicle_image_name']?>" alt="img" class="cover-image">
															</div>
															<div class="item-card9-icons">
																<a href="#" class="item-card9-icons1 wishlist"> <i class="fa fa fa-heart-o"></i></a>
															</div>
															<div class="item-overly-trans">
																<div class="rating-stars">
																	<input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value"  value="3">
																	<div class="rating-stars-container">
																		<div class="rating-star sm">
																			<i class="fa fa-star"></i>
																		</div>
																		<div class="rating-star sm">
																			<i class="fa fa-star"></i>
																		</div>
																		<div class="rating-star sm">
																			<i class="fa fa-star"></i>
																		</div>
																		<div class="rating-star sm">
																			<i class="fa fa-star"></i>
																		</div>
																		<div class="rating-star sm">
																			<i class="fa fa-star"></i>
																		</div>
																	</div>
																</div>
																<span><a href="singlecar.php?vehicle_id=<?=base64_encode($vehicle['vehicle_id'])?>" class="bg-gray"><?=$vehicle2['vehicle_mode']?></a></span>
															</div>
														</div>
														<div class="card border-0 mb-0">
															<div class="card-body ">
																<div class="item-card9">
																	<a href="cars.html" class="text-dark"><h4 class="font-weight-semibold mt-1"> <?=$maker['maker_name']?> <?=$brand['brand_name']?></h4></a>
																	<div class="item-card9-desc mb-2">
																		<a href="#" class="mr-4"><span class=""><i class="fa fa-map-marker text-muted mr-1"></i> JAPAN</span></a>
																		<a href="#" class="mr-4"><span class=""><i class="fa fa-calendar-o text-muted mr-1"></i>  2 days ago</span></a>
																	</div>
																	<p class="mb-0 leading-tight">
																		<?=$vehicle2['vehicle_est_price']?> 
																	</p>
																</div>
															</div>
															<div class="card-footer pr-4 pl-4 pt-4 pb-4">
																<div class="item-card9-footer d-sm-flex">
																	<div class="">
																		<a href="#" class="w-50 mt-1 mb-1 float-left" title="Car type"><i class="fa fa-car  mr-1 text-muted"></i>  <?=$vehicle2['vehicle_type']?></a>
																		<a href="#" class="w-50 mt-1 mb-1 float-left" title="Kilometrs"><i class="fa fa-road text-muted mr-1 "></i><?=$vehicle2['vehicle_km']?></a>
																		<a href="#" class="w-50 mt-1 mb-1 float-left" title="FuealType"><i class="fa fa-tachometer text-muted mr-1"></i><?=$vehicle2['vehicle_fuel']?></a>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
<?php
endwhile;
?>												
												
													
											</div>
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
									<input type="text" class="form-control br-tl-3  br-bl-3" placeholder="Search bY Keywords">
									<div class="input-group-append ">
										<button type="button" class="btn btn-primary br-tr-3  br-br-3">
											Search
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="card overflow-hidden">
							<div class="px-4 py-3 border-bottom">
								<h4 class="mb-0">Brand</h4>
							</div>
							<div class="card-body">
								<?php
											$sql = mysqli_query($dbc,"SELECT * FROM maker WHERE maker_sts = 1 ORDER BY maker_id ASC LIMIT 8");
											while($maker=mysqli_fetch_assoc($sql)):
																?>
					<p style="margin-top: 10px!important">
						<img src="admin/img/vehicles_images/<?=$maker['maker_img']?>" style="width: 30px" / >
						<span><?=$maker['maker_name']?></span><br/>
					</p>																
																<?php
															endwhile;
																?>
							</div>
							
							<div class="px-4 py-3 border-bottom">
								<h4 class="mb-0">Condition</h4>
							</div>
							<div class="card-body">
								<div class="filter-product-checkboxs">
								<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox2" value="option2">
										<span class="custom-control-label">
											All
										</span>
									</label>

									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox1" value="option1">
										<span class="custom-control-label">
											New
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox2" value="option2">
										<span class="custom-control-label">
											Used
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox3" value="option2">
										<span class="custom-control-label">
											Discounted 
										</span>
									</label>
								</div>
							</div>
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="mb-0">Year</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="form-group col-md-6 mb-0">
										<label for="inputState1" class="col-form-label">Min</label>
										<select id="inputState1" class="form-control select2">
											<option>1995</option>
											<option>1996</option>
											<option>1997</option>
											<option>1998</option>
											<option>1999</option>
											<option>2000</option>
											<option>2001</option>
											<option>2002</option>
											<option>2003</option>
											<option>2004</option>
											<option>2005</option>
											<option>2006</option>
											<option>2007</option>
											<option>2008</option>
											<option>2009</option>
											<option>2010</option>
											<option>2011</option>
											<option>2012</option>
											<option>2013</option>
											<option>2014</option>
											<option>2015</option>
											<option>2016</option>
											<option>2017</option>
											<option>2019</option>
											<option>2019</option>
											<option>2020</option>
										</select>
									</div>
									<div class="form-group col-md-6 mb-0">
										<label for="inputState2" class="col-form-label">Max</label>
										<select id="inputState2" class="form-control select2">
											<option>2020</option>
											<option>2019</option>
											<option>2019</option>
											<option>2017</option>
											<option>2016</option>
											<option>2015</option>
											<option>2014</option>
											<option>2013</option>
											<option>2012</option>
											<option>2011</option>
											<option>2010</option>
											<option>2009</option>
											<option>2008</option>
											<option>2007</option>
											<option>2006</option>
											<option>2005</option>
											<option>2004</option>
											<option>2003</option>
											<option>2002</option>
											<option>2001</option>
											<option>2000</option>
											<option>1999</option>
											<option>1998</option>
											<option>1997</option>
											<option>1996</option>
											<option>1995</option>
										</select>
									</div>
								</div>
							</div>
							
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="mb-0">Fuel Type</h4>
							</div>
							<div class="card-body">
								<div class="filter-product-checkboxs">
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox11" value="option1">
										<span class="custom-control-label">
											Electric
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox11" value="option2">
										<span class="custom-control-label">
											Diesel
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox11" value="option2">
										<span class="custom-control-label">
											Petrol
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox11" value="option2">
										<span class="custom-control-label">
											Hybrid
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox11" value="option2">
										<span class="custom-control-label">
											Petrol+CNG
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox11" value="option2">
										<span class="custom-control-label">
											Petrol+LPG
										</span>
									</label>
								</div>
							</div>
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="mb-0">Body Type</h4>
							</div>
							<div class="card-body">
								<div class="filter-product-checkboxs">
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox12" value="option1">
										<span class="custom-control-label">
											Convertable
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox12" value="option2">
										<span class="custom-control-label">
											Coupe
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox12" value="option2">
										<span class="custom-control-label">
											Crossover
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox12" value="option2">
										<span class="custom-control-label">
											Hatchback
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox12" value="option2">
										<span class="custom-control-label">
											Muv
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox12" value="option2">
										<span class="custom-control-label">
											Quadricycle
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox12" value="option2">
										<span class="custom-control-label">
											Ringer Ace
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox12" value="option2">
										<span class="custom-control-label">
											SUV
										</span>
									</label>
								</div>
							</div>
							<div class="px-4 py-3 border-bottom border-top">
								<h4 class="mb-0">Transmission</h4>
							</div>
							<div class="card-body">
								<div class="filter-product-checkboxs">
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox13" value="option1">
										<span class="custom-control-label">
											AMT
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox13" value="option2">
										<span class="custom-control-label">
											Automatic
										</span>
									</label>
									<label class="custom-control custom-checkbox mb-2">
										<input type="checkbox" class="custom-control-input" name="checkbox13" value="option2">
										<span class="custom-control-label">
											Manual
										</span>
									</label>
								</div>
							</div>
							<div class="card-footer">
								<a href="#" class="btn btn-secondary btn-block">Apply Filter</a>
							</div>
						</div>
						<div class="card mb-0">
									<?php
										include_once "shareicons.php";
																			?>
					</div>
					<!--/Right Side Content-->
				</div>
			</div>
		</section>
		<!--/Listing-->

		<!-- Newsletter-->
		<section class="sptb2 bg-white border-top">
			<div class="container">
				<div class="row">
					<div class="col-lg-7 col-xl-6 col-md-12">
						<div class="sub-newsletter">
							<h3 class="mb-2"><i class="fa fa-paper-plane-o mr-2"></i> Subscribe To Our Newsletter</h3>
							<p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
						</div>
					</div>
					<div class="col-lg-5 col-xl-6 col-md-12">
						<div class="input-group sub-input mt-1">
							<input type="text" class="form-control input-lg " placeholder="Enter your Email">
							<div class="input-group-append ">
								<button type="button" class="btn btn-primary btn-lg br-tr-3  br-br-3">
									Subscribe
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/Newsletter-->

		<!-- Recent Post-->
		<section class="sptb2 border-top">
			<div class="container">
				<h6 class="fs-18 mb-4">Latest Posts</h6>
				<hr class="deep-purple  accent-2 mb-4 mt-0 d-inline-block mx-auto">
				<div class="row">
					<div class="col-md-12 col-lg-4">
						<div class="d-flex mt-0 mb-5 mb-lg-0 border bg-white p-4 box-shadow2">
							<img class="w-8 h-8 mr-4" src=" assets/images/media/6.png" alt="img">
							<div class="media-body">
								<h4 class="mt-0 mb-1 fs-16"><a class="text-body" href="#">Buy a CrusaderRecusandae</a></h4>
								<span class="fs-12 text-muted"><i class="fa fa-calendar"></i> 13th May 2019</span>
								<div class="h6 mb-0 mt-1 font-weight-normal"><span class="font-weight-semibold">Price:</span> $128 <del>$218</del></div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-lg-4">
						<div class="d-flex mt-0 mb-5 mb-lg-0 border bg-white p-4 box-shadow2">
							<img class="w-8 h-8 mr-4" src=" assets/images/media/4.png" alt="img">
							<div class="media-body">
								<h4 class="mt-0 mb-1 fs-16"><a class="text-body" href="#">Best New Car</a></h4>
								<span class="fs-12 text-muted"><i class="fa fa-calendar"></i> 20th Jun 2019</span>
								<div class="h6 mb-0 mt-1 font-weight-normal"><span class="font-weight-semibold">Price:</span> $245 <del>$354</del></div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-lg-4">
						<div class="d-flex mt-0 mb-0 border bg-white p-4 box-shadow2">
							<img class="w-8 h-8 mr-4" src=" assets/images/media/2.png" alt="img">
							<div class="media-body">
								<h4 class="mt-0 mb-1 fs-16"><a class="text-body" href="#">Fuel Effeciency Car</a></h4>
								<span class="fs-12 text-muted"><i class="fa fa-calendar"></i> 14th Aug 2019</span>
								<div class="h6 mb-0 mt-1 font-weight-normal"><span class="font-weight-semibold">Price:</span> $214 <del>$562</del></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Recent Post-->

		<!--Footer Section-->
		<?php
include_once "includes/footer.php";
		?>