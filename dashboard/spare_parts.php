<section class="sptb bg-patterns bg-white">
			<div class="container">
				<div class="section-title center-block text-center">
					<h2>Featured Spare Parts</h2>
					<p class="d-none">Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>
				</div>
				<div id="feature-carousel" class="owl-carousel owl-carousel-icons2 auction-content">
					<?php

$sqlvehicle = mysqli_query($dbc,"SELECT * FROM vehicle_parts ORDER BY part_id DESC LIMIT 6 ");
	while($vehicle=mysqli_fetch_assoc($sqlvehicle)):

		$img = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM vehicle_images WHERE vehicle_id = '$vehicle[part_id]' AND images_type='part' LIMIT 1"));

		$maker = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM maker WHERE maker_id = '$vehicle[part_maker]'"));
$brand = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM brands WHERE brand_id = '$vehicle[part_brand]'"));

					?>
										<div class="item">
						<div class="card mb-0">
							<div class="product-item3 bg-light border-bottom">
								<a class="link" href="singlepart.php?i=<?=base64_encode($vehicle['part_id'])?>"></a>
								<div class="product-item2-img text-center">
									<img src="admin/img/vehicles_images/<?=$img['vehicle_image_name']?>" alt="img" class="mx-auto">
								</div>
							</div>
							<div class="item-card2-icons">
								<a href="#" class="item-card2-icons-l bg-dark-transparent-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add To Wishlist"> <i class="fa fa-heart-o"></i></a>
								<a href="#" class="item-card2-icons-l bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add to Cart"> <i class="fa fa-shopping-cart"></i></a>
								<a href="#" class="item-card2-icons-l bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Compare"> <i class="fa fa-exchange"></i></a>
							</div>
							<div class="card-body">
								<div class="product-item2-desc">
									<h4 class="font-weight-semibold"><a href="cars-parts-detail.html" class=" text-dark"><?=$maker['maker_name']?> <?=$brand['brand_name']?> </a></h4>
									<div class="d-flex pb-0 pt-0">
										<a href="">
											<p class="pb-0 pt-0 mb-2 mt-2"><i class="fa fa-map-marker text-danger mr-2"></i><?=$vehicle['part_stock_id']?></p>
										</a>
										<span class="ml-3 pb-0 pt-0 mb-2 mt-2 font-weight-bold">$<?=$vehicle['part_fob_price']?></span>
									</div>
									
									<a href="singlepart.php?i=<?=base64_encode($vehicle['part_id'])?>" class="btn btn-primary text-white mt-3 btn-block">
										Buy Now
									</a>
								</div>
							</div>
						</div>
					</div>
				<?php 	endwhile; ?>
				</div>
			</div>
		</section>