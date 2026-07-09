<!doctype html>
<html lang="en" dir="ltr">
	<?php include_once "includes/header.php"; include_once 'admin/includes/functions.php';
	$vehicle_id = base64_decode($_GET['i']);
$data = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_parts WHERE part_id = '$vehicle_id'"));
$maker = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM maker WHERE maker_id = '$data[part_maker]'"));

$brand = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM brands WHERE brand_id = '$data[part_brand]'"));


$img = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$vehicle_id' AND images_type='part' "));

$imgloop = mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$vehicle_id' AND images_type='part'"); 
$stock_id=$data['part_stock_id'];

?>
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
		<?php //include_once "get_vehicle.php"; ?>
		</div>
		<!--Section-->

		<!--Section-->
		<section class="sptb">
			
			<div class="container">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-12">
						<!--Classified Description-->
						<div class="card overflow-hidden">
							<div class="ribbon ribbon-top-left text-danger"><span class="bg-danger">New</span></div>
							<div class="card-body">
								<div class="item-det mb-4"><br/><br/><br/>
									<a href="#" class="text-dark"><h3> <?=ucfirst($maker['maker_name'])?> <?=ucfirst($brand['brand_name'])?> (<?=($data['part_stock_id'])?>)</h3></a>
									<h2> <span class="float-right" id="est_price">$<?=$data['part_fob_price']?></span></h2> 
									<div class=" d-flex">
										<ul class="d-flex mb-0">
											<li class="mr-5"><a href="#" class="icons"><i class="ti-car text-muted mr-1 fs-18"></i> <?=$stock_id?></a></li>
											<!-- <li class="mr-5"><a href="#" class="icons"><i class="ti-location-pin text-muted mr-1"></i> USA</a></li> -->
											
											<li class="mr-5"><a href="#" class="icons"><i class="ti-eye text-muted mr-1 fs-15"></i> 765</a></li>
										</ul>
										
										<div class="rating-stars d-flex">
											<div class="rating-stars-container mr-2">
												<div class="rating-star sm">
													<i class="fa fa-heart"></i>
												</div>
											</div> 13
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
												<a data-fancybox="gallary" href="admin/img/vehicles_images/<?=$imges['vehicle_image_name']?>" target="_new"><img src="admin/img/vehicles_images/<?=$imges['vehicle_image_name']?>" alt="" class="img img-responsive" style="width: 100px; height: 100px;margin: 5px 0px 0px 5px;"></a>



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
									
								
									// $x = 0;
									// while ($abc) {
									//     echo $abc[$x];
									//     $x++;
									// }
								?>

								<form method='post' action='admin/downloadZip.php'>
								<input class="d-none" type="text" name="part_id" value="<?=$_GET['i']?>">
								<input type="hidden" name="DownloadImagesZippart" value="DownloadImagesZippart">
								<input type="hidden" name="type" value="part">
								<button type="submit" class="btn btn-success btn-block" name="create_pdf">Download Images as Zip</button>
								</form>


							</div>
						</div>
						
						<!--/Classified Description-->

						<!-- <h3 class="mb-5 mt-6">Related Posts</h3> -->

						<!--Related Posts-->
						<div id="myCarousel5" class="owl-carousel owl-carousel-icons3">
							<!-- Wrapper for carousel items -->

							<!-- Wrapper for carousel items -->
							<?php
								$vehicle_id = base64_decode($_GET['i']);
							$related = mysqli_query($dbc,"SELECT * FROM vehicle_info WHERE vehicle_id = '$vehicle_id' ");
							while($row=mysqli_fetch_assoc($related)):

							$maker = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM maker WHERE maker_id = '$row[vehicle_maker]'"));
							$brand = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM brands WHERE brand_id = '$row[vehicle_brand]'"));
							$img = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$row[vehicle_id]'"));
							?>

							<div class="item">
								<div class="card mb-0">
									<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-bolt"></i></span></div>
									<div class="item-card2-img">
										<a class="link" href="singlecar.php?"></a>
										<img src="admin/img/vehicles_images/<?=$img['vehicle_image_name']?>" alt="img" class="cover-image">
									</div>
									<div class="item-card2-icons"></div>
									<div class="card-body pb-0">
										<div class="item-card2">
											<div class="item-card2-desc">
												<div class="item-card2-text">
													<a href="cars.html" class="text-dark"><h4 class="mb-0">
														<?=$maker['maker_name']?> <?=$brand['brand_name']?>
													</h4></a>
												</div>
												<div class="d-flex">
													<a href="">
														
													</a>
													<span class="ml-3 pb-0 pt-0 mb-2 mt-2 font-weight-bold">$<?=$row['vehicle_est_price']?></span>
												</div>
												<p class=""></p>
											</div>
										</div>
									</div>
									<div class="card-footer">
										<a href="#" class="mr-4" data-toggle="tooltip" data-placement="bottom" data-original-title="Automatic"><i class="fa fa-car text-muted"></i> <span class="text-default"><?=$row['vehicle_transmission']?></span></a>
										<a href="#" class="mr-4" data-toggle="tooltip" data-placement="bottom" data-original-title="<?=$row['vehicle_km']?> Kilometrs"><i class="fa fa-road text-muted"></i> <span class="text-default"><?=$row['vehicle_km']?></span></a>
										<a href="#" class="" data-toggle="tooltip" data-placement="bottom" data-original-title="FuelType"><i class="fa fa-tachometer text-muted"></i> <span class="text-default"><?=$row['vehicle_fuel']?></span></a>
									</div>
								</div>
							</div>
							<?php
							endwhile;
							?>							
						</div>
						<!--/Related Posts-->

						<!-- <div class="card mt-2"><div class="card-body p-0">
								<div class="media p-5 border-top mt-0">
									<div class="d-flex mr-3">
										<a href="#"> <img class="media-object brround" alt="64x64" src="../assets/images/users/male/3.jpg"> </a>
									</div>
									<div class="media-body">
										<h5 class="mt-0 mb-1 font-weight-semibold">Edward
										<span class="fs-14 ml-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="verified"><i class="fa fa-check-circle-o text-success"></i></span>
										
										</h5>
										<small class="text-muted"><i class="fa fa-calendar"></i> Dec 21st  <i class=" ml-3 fa fa-clock-o"></i> 16.35 </small>
                                        <p class="font-13  mb-2 mt-2">
                                           Lorem Ipsum available, quis Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et  nostrud exercitation ullamco laboris   commodo consequat.
                                        </p>
										
									</div>
								</div>
							</div>
						</div> -->
						<div class="card mb-lg-0 d-none">
							<div class="card-header">
								<h3 class="card-title">Leave a reply</h3>
							</div>
							<div class="card-body">
								<div>
									<div class="form-group">
										<input type="text" class="form-control" id="name1" placeholder="Your Name">
									</div>
									<div class="form-group">
										<input type="email" class="form-control" id="email" placeholder="Email Address">
									</div>
									<div class="form-group">
										<textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Comment"></textarea>
									</div>
									<a href="#" class="btn btn-primary">Send Reply</a>
								</div>
							</div>
						</div>
					</div>
					<!--left Side Content-->
					<div class="col-xl-6 col-lg-6 col-md-12">
						
						<div class="card">
							<div class="card-footer">
								<button type="submit" class="btn btn-primary btn-lg btn-block text-white" data-toggle="modal" data-target="#iquiryMake">Send Inquiry</button>
							</div>
						</div>
						<div class="">
							<div class="">
								<div class="border-0">
									<div class="wideget-user-tab wideget-user-tab3">
										<div class="tab-menu-heading">
											<div class="tabs-menu1">
												<ul class="nav">
													<li class=""><a href="#tab-1" class="active" data-toggle="tab">Specifications</a></li>
													
													<li><a href="#tab-5" data-toggle="tab" class="">About Video</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="tab-content border-left border-left border-top br-tr-3 border-bottom br-br-3 br-bl-3 p-5 bg-white mb-4">
										<div class="tab-pane active" id="tab-1">
											<h3 class="card-title mb-3 font-weight-semibold">Specifications</h3>
											<div class="mb-4">
												<?=$data['part_note']?>
											</div>
											<!-- <h4 class="mb-4">Specifications</h4> -->
											<div class="row">
												<div class="col-xl-12 col-md-12">
													<div class="table-responsive">
														<table class="table table-bordered w-100 m-0 text-nowrap ">
															<tbody>
																<tr>
																	<th><span class="font-weight-bold">Maker/Brand :</span> </th>
																	<td> <span style="float: left"><?=$maker['maker_name']?> / <?=$brand['brand_name']?></span></td>

																	<th><span class="font-weight-bold">Stock Id</span> </th>
																	<td> <span style="float: left"><?=$data['part_stock_id']?></span></td>
																</tr>
																<tr>

																	<th><span class="font-weight-bold"> Chassis No  :</span> </th>
																	<td> <span style="float: left"><?=$data['part_chassis_no']?></span></td>

																	<th><span class="font-weight-bold">Part No</span> </th>
																	<td> <span style="float: left"><?=$data['part_no']?></span></td>


																	
																</tr>
																<tr>

																	<th><span class="font-weight-bold">Part CC:</span> </th>
																	<td> <span style="float: left"><?=$data['part_cc']?></span></td>

																	<th><span class="font-weight-bold">Color :</span> </th>
																	<td> <span style="float: left"><?=$data['part_color']?></span></td>

																</tr>
																<tr>

																	<th><span class="font-weight-bold">Year  :</span> </th>
																	<td> <span style="float: left"><?=$data['part_year']?></span></td>

																	<th><span class="font-weight-bold">Manufacture Year :</span> </th>
																	<td> <span style="float: left"><?=$data['part_manu_year']?></span></td>



																</tr>
																<tr>

																	<th><span class="font-weight-bold">Package  :</span> </th>
																	<td> <span style="float: left"><?=$data['part_package']?></span></td>

																	<th><span class="font-weight-bold">KM :</span> </th>
																	<td> <span style="float: left"><?=$data['part_km']?></span></td>



																	
																</tr>
																<tr>
																	<th><span class="font-weight-bold">Fuel</span> </th>
																	<td> <span style="float: left"><?=$data['part_fuel']?></span></td>

																	<th><span class="font-weight-bold">Steering</span> </th>
																	<td> <span style="float: left"><?=$data['part_steering']?></span></td>


																	
																</tr>
																<tr>


																	<th><span class="font-weight-bold">Transmission</span> </th>
																	<td> <span style="float: left"><?=$data['part_transmission']?></span></td>
																			<th><span class="font-weight-bold">Total Weight   :</span> </th>
																	<td> <span style="float: left"><?=$data['part_weight']?></span></td>

													
																</tr>
																<!-- <tr>
																		<th><span class="font-weight-bold">Condition Remarks</span> </th>
																	<td colspan="3" > <span ><?=$data['part_condition_remarks']?></span></td>
																</tr> -->
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										
										<div class="tab-pane" id="tab-5">
											<ul class="list-unstyled video-list-thumbs row ">
												<li class="mb-0">
													<a data-toggle="modal" data-target="#homeVideo">
														<img src=" assets/images/media/others/v1.jpg" alt="Barca" class="img-responsive">
														<span class="mdi mdi-arrow-left-drop-circle-outline text-white"></span>
													</a>
												</li>
											</ul>

										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-body item-user">
								<h4 class="mb-4">Contact Info</h4>
								<div>
									<h6><span class="font-weight-semibold"><i class="fa fa-home mr-3 mb-2"></i></span><a href="#" class="text-body"> <?=$company_name?></a></h6>
									<h6><span class="font-weight-semibold"><i class="fa fa-envelope mr-3 mb-2"></i></span><a href="#" class="text-body"><?=$company_email?></a></h6>
									<h6><span class="font-weight-semibold"><i class="fa fa-phone mr-3  mb-2"></i></span><a href="#" class="text-body"> <?=$company_personal_phone?></a></h6>
									<h6><span class="font-weight-semibold"><i class="fa fa-link mr-3 mb-2"></i></span><a href="#" class="text-body"><?=$company_company_phone?>/</a></h6>
									<h6><span class="font-weight-semibold"><i class="fa fa-map-marker mr-3 "></i></span><a class="text-body"><?=$company_address?></a></h6>
								</div>
								<div class=" item-user-icons mt-4">
									<a href="#" class="facebook-bg mt-0"><i class="fa pt-2 fa-facebook"></i></a>
									<a href="#" class="twitter-bg"><i class="fa pt-2 fa-twitter"></i></a>
									<a href="#" class="google-bg"><i class="fa pt-2 fa-google"></i></a>
									<a href="#" class="dribbble-bg"><i class="fa pt-2 fa-dribbble"></i></a>
								</div>
							</div>
							<div class="card-footer">
								<div class="text-left">
									<a href="#" class="btn  btn-info"><i class="fa fa-envelope"></i> Chat</a>
									<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#contact"><i class="fa fa-user"></i> Contact Me</a>
									<a href="#" class="btn btn-danger" data-toggle="modal" data-target="#contact"><i class="fa fa-share-alt"></i> Share</a>
								</div>
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
						<!-- <div class="card">
							<div class="card-header">
								<div class="card-title">Latest Makers</div>
							</div>
							<div class="card-body ">
								<ul class="vertical-scroll">
									 			<?php
											$sql = mysqli_query($dbc,"SELECT * FROM maker WHERE maker_sts = 1 ORDER BY maker_id ASC LIMIT 10");
											while($maker=mysqli_fetch_assoc($sql)):
																?>
									<li class="news-item">
										<table>
											<tr>
												<td><img src="admin/img/vehicles_images/<?=$maker['maker_img']?>" alt="image" class="w-8 border"/></td>
												<td class="pl-3"><h5 class="mb-1 "><?=$maker['maker_name']?></h5><a href="#" class="btn-link">View Details</a></td>
											</tr>
										</table>
									</li>
								<?php 	endwhile; ?>
								</ul>
							</div>
						</div> -->

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
    	      		<input  type="hidden"  name="inquiry_services[]" value="">
      				<input type="hidden" name="inquiry_of" value="part">

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