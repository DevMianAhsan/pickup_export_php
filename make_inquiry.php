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
		<?php include_once "get_vehicle.php"; ?>
		</div>
	<section  class="sptb bg-white mb-0">
		
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-xl-4 col-md-12">
						<div class="contact-description">
							<h2>Say Hello</h2>
							<p class="mt-5">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt</p>

							<div class="mb-5">
								<small class="text-muted">Need Help?</small>
								<p class="mb-0 fs-16 font-weight-bold"><?=$company_email?></p>
							</div>
							<div class="mb-5">
								<small class="text-muted">Feel Like Talking?</small>
								<p class="mb-0 fs-16 font-weight-bold"><?=$company_company_phone?></p>
							</div>
						</div>
					</div>
				    <div class="col-lg-7 col-xl-8 col-md-12">
						<div class="single-page" >
							<div class="col-lg-12 col-md-12 mx-auto d-block">
								<div class="wrapper wrapper2">
									<div class="card box-shadow-0 mb-0">
										<div class="card-body">
											<div class="form-group">
												<input type="text" class="form-control" id="name1" placeholder="Your Name">
											</div>
											<div class="form-group">
												<input type="email" class="form-control" id="email" placeholder="Email Address">
											</div>
											<div class="form-group">
												<textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Message"></textarea>
											</div>
											<a href="#" class="btn btn-primary">Send Message</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
	</section>		
		<!--latest Posts-->
		<?php include_once "includes/footer.php" ?>
		<!--Footer Section-->
	</body>
</html>