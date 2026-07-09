<?php
include_once"includes/header.php";
		?>
		<!--/Topbar-->

		<!--Breadcrumb-->
		<div>
			<div class="bannerimg cover-image bg-background3" data-image-src="../assets/images/banners/banner2.jpg">
				<div class="header-text mb-0">
					<div class="container">
						<div class="text-center text-white ">
							<h1 class="">Contact Us</h1>
							<ol class="breadcrumb text-center">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active text-white" aria-current="page">Contact</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/Breadcrumb-->

		<!--Contact-->
		<div class="sptb bg-white mb-0">
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
								<p class="mb-0 fs-16 font-weight-bold">
								<a href="tel:<?=$company_company_phone?>"><?=$company_company_phone?></a><br/>
								<a href="tel:<?=$company_personal_phone?>"><?=$company_personal_phone?></a></p>
							</div>
							<?php
								include_once "shareicons.php";
							?>
						</div>
					</div>
				    <div class="col-lg-7 col-xl-8 col-md-12">
						<div class="single-page" >
							<div class="col-lg-12 col-md-12 mx-auto d-block">
								<div class="wrapper wrapper2">
									<div class="card box-shadow-0 mb-0">
										<div class="card-body">
											<form>
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
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--Contact-->

		<!-- Recent Post-->
			<?php
				include_once "post.php";
			?>
		<!-- Recent Post-->

		<!--Footer Section-->
		<?php
include_once"includes/footer.php";
		?>