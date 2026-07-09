<!--Section-->
		<section class=" mt-5 bg-patterns bg-white" >
			<div class="container" >
				<div class="section-title center-block text-center">
					<h2>New Arrival</h2>
<!-- 					<p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>
 -->				</div>
				
					<!-- Wrapper for carousel items -->
					<div class="row">
					<?php

$sqlvehicle = mysqli_query($dbc,"SELECT * FROM vehicle_info ORDER BY vehicle_id DESC LIMIT 6 ");
	while($vehicle=mysqli_fetch_assoc($sqlvehicle)):

		$img = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$vehicle[vehicle_id]' AND images_type='vehicle' LIMIT 1"));

		$maker = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM maker WHERE maker_id = '$vehicle[vehicle_maker]'"));
$brand = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM brands WHERE brand_id = '$vehicle[vehicle_brand]'"));

					?>
				<div class="col-lg-4 col-md-12">
					<div class="card">
						<div class="arrow-ribbon bg-primary">New</div>
						<div class="bg-white h-100">
							<img class="card-img-top br-tr-7 br-tl-7" src="admin/img/vehicles_images/<?=$img['vehicle_image_name']?>" style="max-height: 220px;" alt="">
						</div>
						<div class="card-body border-top">
								<div class="item-card2">
									<div class="item-card2-desc">
										<div class="item-card2-text">
											<a href="cars-services-detail.html" class="text-dark"><h4 class="mb-0"><?=$maker['maker_name']?> <?=$brand['brand_name']?> </h4></a>
										</div>
										<div class="d-flex">
											<a href="">
												<p class="pb-0 pt-0 mb-2 mt-2"><i class="fa fa-car text-danger mr-2"></i><?=$vehicle['vehicle_transmission']?></p>
											</a>
											<span class="ml-3 pb-0 pt-0 mb-2 mt-2 font-weight-bold"><?=$vehicle['vehicle_km']?> Km</span>
											<p class="pb-0 pt-0 mb-2 ml-2 mt-2"><i class="fa fa-tachometer text-danger mr-2"></i><?=$vehicle['vehicle_fuel']?></p>
											
										</div>
										<p class=""><?=$vehicle['vehicle_note']?>$</p>
									</div>
								</div>
							</div>
						<div class="card-footer">
							<div class="product-item-wrap d-flex">
								<div class="product-item-price">
									<span class="newprice text-dark"><?=$vehicle['vehicle_est_price']?>$</span>
<!-- 									<del class="oldprice text-muted">$195</del>
 -->								</div>
								<a href="singlecar.php?i=<?=base64_encode($vehicle['vehicle_id'])?>" class="btn btn-info btn-sm ml-auto">More Info</a>
							</div>
						</div>
					</div>
				</div>
					



					<?php
endwhile;
					?>
				</div>
			</div>
		</section>
		<!--Section-->