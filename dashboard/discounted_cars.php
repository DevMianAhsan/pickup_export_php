<style type="text/css">
	.d_images{
		max-width: 440px !important;
	}
</style>
<section class="sptb bg-white">
			<div class="container">
				<div class="section-title center-block text-center">
					<h2>Discounted Cars</h2>
<!-- 					<p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>
 -->				</div>
				<div id="feature-carousel" class="owl-carousel owl-carousel-icons auction-content">
	<?php

$sqlvehicle = mysqli_query($dbc,"SELECT * FROM vehicle_info ORDER BY vehicle_id DESC LIMIT 12 ");
	while($vehicle=mysqli_fetch_assoc($sqlvehicle)):

		$img = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$vehicle[vehicle_id]' ORDER BY vehicle_image_id ASC LIMIT 1"));

		$VDat=getVehicleInfo($dbc,$vehicle['vehicle_id'],true);
					?>
					<div class="item">
						<div class="card mb-0">
							<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-bolt"></i></span></div>
							<div class="item-card2-img">
								<a class="link" href="cars-services-detail.html"></a>
								<img src="admin/img/vehicles_images/<?=$img['vehicle_image_name']?>" alt="img" class="d_images cover-image" style="height: 220px;" >
								<div class="item-tag-overlaytext">
									<span class="text-white bg-success"> Service</span>
								</div>
								<div class="item-card2-icons">
									<a href="cars-services-detail.html" class="item-card2-icons-l bg-primary"> <i class="car car-<?=strtolower($VDat['maker_name'])?>"></i></a>
									<a href="#" class="item-card2-icons-r wishlist active"><i class="fa fa fa-heart-o"></i></a>
								</div>
							</div>
							<div class="card-body pb-0">
								<div class="item-card2">
									<div class="item-card2-desc">
										<div class="item-card2-text">
											<a href="cars-services-detail.html" class="text-dark"><h4 class="mb-0"><?=$VDat['maker_name']?> <?=$VDat['brand_name']?> </h4></a>
										</div>
										<div class="d-flex">
											<a href="">
												<p class="pb-0 pt-0 mb-2 mt-2"><i class="fa fa-car text-danger mr-2"></i><?=$VDat['vehicle_transmission']?></p>
											</a>
											<span class="ml-3 pb-0 pt-0 mb-2 mt-2 font-weight-bold"><?=$VDat['vehicle_km']?> Km</span>
											<p class="pb-0 pt-0 mb-2 ml-2 mt-2"><i class="fa fa-tachometer text-danger mr-2"></i><?=$VDat['vehicle_fuel']?></p>
											
										</div>
										<p class="">Lorem Ipsum available, quis int nostrum exercitationem </p>
									</div>
								</div>
								<div class=" item-card2-footer mt-4 mb-4">
									<div class="item-card2-footer-u d-none">
										<div class="d-flex">
											<span class="review_score mr-2 badge badge-primary">4.0/5</span>
                                            <div class="rating-stars d-inline-flex ml-auto">
												<input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value" value="3">
												<div class="rating-stars-container">
													<div class="rating-star sm is--active">
														<i class="fa fa-star"></i>
													</div>
													<div class="rating-star sm is--active">
														<i class="fa fa-star"></i>
													</div>
													<div class="rating-star sm is--active">
														<i class="fa fa-star"></i>
													</div>
													<div class="rating-star sm">
														<i class="fa fa-star"></i>
													</div>
													<div class="rating-star sm">
														<i class="fa fa-star"></i>
													</div>
												</div> (5 Reviews)
											</div>
										</div>
									</div>
									<a class="btn btn-danger mt-3 d-block" href="#">More Details</a>
								</div>
							</div>
						</div>
					</div>
		<?php 	endwhile; ?>
				</div>
			</div>
		</section>