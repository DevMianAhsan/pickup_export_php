<!doctype html>
<html lang="en" dir="ltr">
	<?php include_once "includes/header.php"; include_once 'admin/includes/functions.php'; ?>
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
		<?php include_once "slider.php"; ?>
		<?php include_once "get_vehicle.php"; ?>
		</div>
		<!--Section-->

		<!--Section-->
		<?php 	include_once 'dashboard/vehicle_types.php'; ?>
		<section class="sptb pb-8">
			<?php 	include_once 'dashboard/vehicle_services.php'; ?>
		</section>
		<?php 	include_once 'dashboard/latest_vehicle.php'; ?>
		<?php 	include_once 'dashboard/spare_parts.php'; ?>
		<?php 	include_once 'dashboard/discounted_cars.php'; ?>
		<section class="sptb">
			<section>
			<div class="about-1 cover-image sptb bg-background-color text-white" data-image-src="../assets/images/banners/banner2.jpg" style="background: url(&quot;../assets/images/banners/banner2.jpg&quot;) center center;">
				<div class="content-text mb-0">
					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-xl-4 mb-5 mb-xl-0">
								<h2 class="mb-2 h1">Call to Action</h2>
								<p class="fs-16 mb-0">It is a long established distracted.</p>
							</div>
							<div class="col-lg-6 col-xl-4">
								<div class="d-flex mt-4 widgets-cards mt-lg-0">
									<div class="widgets-cards-icons">
										<div class="wrp icon-circle bg-success">
											<i class="fa fa-envelope icons"></i>
										</div>
									</div>
									<div class="mt-3">
										<h6>Got any Question?</h6>
										<h2><a href="#" class="text-white"><?=$company_email?></a></h2>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-xl-4">
								<div class="d-flex mt-4 widgets-cards mt-lg-0">
									<div class="widgets-cards-icons">
										<div class="wrp icon-circle bg-primary">
											<i class="fa fa-phone icons"></i>
										</div>
									</div>
									<div class="mt-3">
										<h6>Got any Question?</h6>
										<h2><a href="#" class="text-white"><?=$company_company_phone?>/</a></h2>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="sptb position-relative mt-5 mb-4 pattern">
			<div class="container">
				<div class="section-title center-block text-center">
					<h2 class="text-white position-relative">Testimonials</h2>
					<p class="text-white-50 position-relative"></p>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div id="myCarousel" class="owl-carousel testimonial-owl-carousel owl-loaded owl-drag">
							
							
							
						<div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(-2402px, 0px, 0px); transition: all 0s ease 0s; width: 8407px;"><div class="owl-item cloned" style="width: 1176px; margin-right: 25px;"><div class="item text-center">
								<div class="row">
									<div class="col-xl-8 col-md-12 d-block mx-auto">
										<div class="testimonia">
											<p class="text-white-80"><i class="fa fa-quote-left"></i> Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore. </p>
											<div class="testimonia-data">
												<h3 class="title">williamson</h3>
												<span class="post"></span>
												<div class="rating-stars">
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
													</div>
													<div class="owl-controls clickable">
														<div class="owl-pagination">
															<div class="owl-page ">
																<span class=""></span>
															</div>
															<div class="owl-page active">
																<span class=""></span>
															</div>
															<div class="owl-page">
																<span class=""></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div></div><div class="owl-item cloned animated owl-animated-out fadeOutDown" style="width: 1176px; margin-right: 25px; left: 1201px;"><div class="item text-center">
								<div class="row">
									<div class="col-xl-8 col-md-12 d-block mx-auto">
										<div class="testimonia">
											<p class="text-white-80"><i class="fa fa-quote-left"></i> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. usantium doloremque laudantium.</p>
											<div class="testimonia-data">
											    <h3 class="title">Sophie Carr</h3>
												<span class="post"></span>
												<div class="rating-stars">
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
													</div>
													<div class="owl-controls clickable">
														<div class="owl-pagination">
															<div class="owl-page ">
																<span class=""></span>
															</div>
															<div class="owl-page">
																<span class=""></span>
															</div>
															<div class="owl-page active">
																<span class=""></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div></div><div class="owl-item animated owl-animated-out fadeOutDown owl-animated-in fadeInDowm active" style="width: 1176px; margin-right: 25px; left: 1201px;"><div class="item text-center">
								<div class="row">
									<div class="col-xl-8 col-md-12 d-block mx-auto">
										<div class="testimonia">
										    <p class="text-white-80">
												<i class="fa fa-quote-left text-white-80"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod eos id officiis hic tenetur quae quaerat ad velit ab. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore cum accusamus eveniet molestias voluptatum inventore laboriosam labore sit, aspernatur praesentium iste impedit quidem dolor Ipsum.
											</p>
											<h3 class="title">Elizabeth</h3>
											<span class="post"></span>
											<div class="rating-stars">
												<input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value" value="4">
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
													<div class="rating-star sm is--active">
														<i class="fa fa-star"></i>
													</div>
													<div class="rating-star sm">
														<i class="fa fa-star"></i>
													</div>
												</div>
											</div>
											<div class="owl-controls clickable">
												<div class="owl-pagination">
													<div class="owl-page active">
														<span class=""></span>
													</div>
													<div class="owl-page ">
														<span class=""></span>
													</div>
													<div class="owl-page">
														<span class=""></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div></div><div class="owl-item animated owl-animated-in fadeInDowm owl-animated-out fadeOutDown" style="width: 1176px; margin-right: 25px; left: 1201px;"><div class="item text-center">
								<div class="row">
									<div class="col-xl-8 col-md-12 d-block mx-auto">
										<div class="testimonia">
											<p class="text-white-80"><i class="fa fa-quote-left"></i> Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore. </p>
											<div class="testimonia-data">
												<h3 class="title">williamson</h3>
												<span class="post"></span>
												<div class="rating-stars">
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
													</div>
													<div class="owl-controls clickable">
														<div class="owl-pagination">
															<div class="owl-page ">
																<span class=""></span>
															</div>
															<div class="owl-page active">
																<span class=""></span>
															</div>
															<div class="owl-page">
																<span class=""></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div></div><div class="owl-item animated owl-animated-in fadeInDowm" style="width: 1176px; margin-right: 25px;"><div class="item text-center">
								<div class="row">
									<div class="col-xl-8 col-md-12 d-block mx-auto">
										<div class="testimonia">
											<p class="text-white-80"><i class="fa fa-quote-left"></i> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. usantium doloremque laudantium.</p>
											<div class="testimonia-data">
											    <h3 class="title">Sophie Carr</h3>
												<span class="post"></span>
												<div class="rating-stars">
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
													</div>
													<div class="owl-controls clickable">
														<div class="owl-pagination">
															<div class="owl-page ">
																<span class=""></span>
															</div>
															<div class="owl-page">
																<span class=""></span>
															</div>
															<div class="owl-page active">
																<span class=""></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div></div><div class="owl-item cloned" style="width: 1176px; margin-right: 25px;"><div class="item text-center">
								<div class="row">
									<div class="col-xl-8 col-md-12 d-block mx-auto">
										<div class="testimonia">
										    <p class="text-white-80">
												<i class="fa fa-quote-left text-white-80"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod eos id officiis hic tenetur quae quaerat ad velit ab. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore cum accusamus eveniet molestias voluptatum inventore laboriosam labore sit, aspernatur praesentium iste impedit quidem dolor Ipsum.
											</p>
											<h3 class="title">Elizabeth</h3>
											<span class="post"></span>
											<div class="rating-stars">
												<input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value" value="4">
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
													<div class="rating-star sm is--active">
														<i class="fa fa-star"></i>
													</div>
													<div class="rating-star sm">
														<i class="fa fa-star"></i>
													</div>
												</div>
											</div>
											<div class="owl-controls clickable">
												<div class="owl-pagination">
													<div class="owl-page active">
														<span class=""></span>
													</div>
													<div class="owl-page ">
														<span class=""></span>
													</div>
													<div class="owl-page">
														<span class=""></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div></div><div class="owl-item cloned" style="width: 1176px; margin-right: 25px;"><div class="item text-center">
								<div class="row">
									<div class="col-xl-8 col-md-12 d-block mx-auto">
										<div class="testimonia">
											<p class="text-white-80"><i class="fa fa-quote-left"></i> Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore. </p>
											<div class="testimonia-data">
												<h3 class="title">williamson</h3>
												<span class="post"></span>
												<div class="rating-stars">
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
													</div>
													<div class="owl-controls clickable">
														<div class="owl-pagination">
															<div class="owl-page ">
																<span class=""></span>
															</div>
															<div class="owl-page active">
																<span class=""></span>
															</div>
															<div class="owl-page">
																<span class=""></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div></div></div></div><div class="owl-nav"><button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button></div><div class="owl-dots disabled"></div></div>
					</div>
					
				</div>
			</div>
		</section>
		<!--latest Posts-->
		<?php include_once "includes/footer.php" ?>
		<!--Footer Section-->
	</body>
</html>