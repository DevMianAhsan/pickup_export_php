<!doctype html>
<html lang="en" dir="ltr">
	<?php include_once "includes/header.php"; include_once 'admin/includes/functions.php';
	$vehicle_id = base64_decode($_GET['i']);
$data = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM machines WHERE machine_id = '$vehicle_id'"));
$maker = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM maker WHERE maker_id = '$data[machine_maker]'"));

$brand = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM brands WHERE brand_id = '$data[machine_brand]'"));


$img = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$vehicle_id' AND images_type='machine' "));

$imgloop = mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$vehicle_id' AND images_type='machine'"); 
$stock_id=$data['machine_stock_id'];

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
									<a href="#" class="text-dark"><h3> <?=ucfirst($maker['maker_name'])?> <?=ucfirst($brand['brand_name'])?> (<?=$data['machine_stock_id']?>)</h3></a>
									<h2> <span class="float-right" id="est_price">$<?=$data['machine_fob_price']?></span></h2> 
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
								<input class="d-none" type="text" name="machine_id" value="<?=$_GET['i']?>">
								<input type="hidden" name="DownloadImagesZipmachine" value="DownloadImagesZipmachine">
								<input type="hidden" name="type" value="part">
								<button type="submit" class="btn btn-success btn-block" name="create_pdf" id="create_pdf">Download Images as Zip</button>
								</form>


							</div>
						</div>
						<!--/Classified Description-->

						

						

						
						
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
												<?=$data['machine_note']?>
											</div>
											<!-- <h4 class="mb-4">Specifications</h4> -->
											<div class="row">
												<div class="col-xl-12 col-md-12">
													<div class="table-responsive">
														<table class="table table-bordered w-100 m-0 text-wrap ">
															<tbody>
																<tr>
																	<th><span class="font-weight-bold">Maker/Brand :</span> </th>
																	<td> <span style="float: left"><?=$maker['maker_name']?> / <?=$brand['brand_name']?></span></td>

																	<th><span class="font-weight-bold">Stock Id</span> </th>
																	<td> <span style="float: left"><?=$data['machine_stock_id']?></span></td>
																</tr>
																<tr>

																	<th><span class="font-weight-bold"> Serial No  :</span> </th>
																	<td> <span style="float: left"><?=$data['machine_serial_no']?></span></td>

																	<th><span class="font-weight-bold">Machine No</span> </th>
																	<td> <span style="float: left"><?=$data['part_no']?></span></td>


																	
																</tr>
																<tr>

																	<th><span class="font-weight-bold">Machine Type</span> </th>
																	<td> <span style="float: left"><?=$data['machine_type']?></span></td>

																	<th><span class="font-weight-bold">Color :</span> </th>
																	<td> <span style="float: left"><?=$data['machine_color']?></span></td>

																</tr>
																<tr>

																	<th><span class="font-weight-bold">Year  :</span> </th>
																	<td> <span style="float: left"><?=$data['machine_year']?></span></td>

																	<th><span class="font-weight-bold">Manufacture Year :</span> </th>
																	<td> <span style="float: left"><?=$data['machine_manu_year']?></span></td>



																</tr>
																<tr>

																	<th><span class="font-weight-bold">LxWxH (M3)  :</span> </th>
																	<td> <span style="float: left"><?=$data['machine_l']?>x<?=$data['machine_w']?>x<?=$data['machine_h']?></span></td>


																	<th><span class="font-weight-bold">Total Weight   :</span> </th>
																	<td> <span style="float: left"><?=$data['machine_weight']?></span></td>

																	
																</tr>
																<tr>
																	<th><span class="font-weight-bold">Fuel</span> </th>
																	<td> <span style="float: left"><?=$data['machine_fuel']?></span></td>

																	<th><span class="font-weight-bold">Steering</span> </th>
																	<td> <span style="float: left"><?=$data['machine_steering']?></span></td>


																	
																</tr>
																<tr class="d-none">
																		<th><span class="font-weight-bold">Condition Remarks</span> </th>
																	<td colspan="3"> <span style="float: left"><?=$data['machine_condition_remarks']?></span></td>
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
    	      		<input type="hidden" name="inquiry_of" value="machine">
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
      			<input type="text" class="form-control" name="inquiry_fullName" required>
      		</div>
      	</div>
      	<div class="row ">
      		<div class="col-sm-6">
      			<label>Email</label>
      			<input type="email" class="form-control" name="inquiry_email" required>
      		</div>
      		<div class="col-sm-6">
      			<label>Phone Number</label>
      			<input type="text" class="form-control" name="inquiry_phoneNumber" required>
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
<input  type="hidden"  name="inquiry_services[]" value="">
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
                Sendalert(response.msg,response.sts,2000);
            }
        });//ajax call
    });//main
</script> required