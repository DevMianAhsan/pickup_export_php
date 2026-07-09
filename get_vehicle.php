<div class="cover-image sptb-1 bg-background" data-image-src="../assets/images/banners/banner1.jpg">
				<div class="header-text1 mb-0">
							<div class="header-text1 mb-0">
					<div class="container">
						<div class="row">
							<div class="col-xl-7 col-lg-7 col-md-12">
								<div class="text-white mt-lg-8 mb-5">
									<h1 class="mb-3 display-3">Expert <span class="font-weight-bold">Technicians,</span><br> Best Prices</h1>
									<p class="fs-18 mb-6">If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
									<a href="#" class="btn btn-primary d-none btn-lg mr-2">View More</a>
									<a href="#" class="btn btn-success btn-lg">Contact Us</a>
								</div>
							</div>
							<div class="col-xl-5 col-lg-5 col-md-12">
								<div class="card mb-0 shadow-none">
									<div class="card-body">
										<form method="get" action="car-lists.php">
											<input type="hidden" name="advance" value="s">
											
										
										<h2 class="mb-4">Get Your Desired Vehicle</h2>
										<hr class="deep-purple  accent-2 mb-4 mt-0 d-inline-block mx-auto">
									<!-- 	<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<input type="text" class="form-control input-lg" id="text" placeholder="Name">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<input type="text" class="form-control input-lg" placeholder="Phone Number">
												</div>
											</div>
										</div> -->
										<div class="row">
											<div class="col-md-6">
												<div class="form-group ">
													<select class="form-control select2-show-search border-bottom-0 w-100 br-3" data-placeholder="Select" name="maker">
														<optgroup label="Makers">
															<option value="null">Choose Maker</option>

												<?php $q = get($dbc,"maker WHERE maker_sts = '1'");
												while($r = mysqli_fetch_assoc($q)): ?>

													<option value="<?=$r['maker_id']?>"><?=$r['maker_name']?></option>

														<?php endwhile ?>
														</optgroup>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<select class="form-control select2-show-search border-bottom-0 w-100 br-3" data-placeholder="Select"  name="brands">
														<optgroup label="Brands">
															<option value="null">Select Brand</option>
															<?php $q = get($dbc,"brands WHERE brand_status = 1 ");
												while($r = mysqli_fetch_assoc($q)): ?>

													<option value="<?=$r['brand_id']?>"><?=$r['brand_name']?></option>

														<?php endwhile ?>
														</optgroup>
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group ">
													<select class="form-control select2-show-search border-bottom-0 w-100 br-3" data-placeholder="Select" name="body_type">
														<optgroup label="Types">
															<option value="null">Type</option>
															<?php $q = get($dbc,"body_type WHERE body_type_sts = '1'");

							while($r = mysqli_fetch_assoc($q)): ?>

						<option value="<?=$r['body_type_id']?>"><?=$r['body_type_name']?></option>

					<?php endwhile ?>
														</optgroup>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<select class="form-control select2-show-search border-bottom-0 w-100 br-3" data-placeholder="Select" name="options">
														<optgroup label="Categories">
															<option value="null">Steering</option>
															<?php $q = get($dbc,"options WHERE option_sts = '1'");

							while($r = mysqli_fetch_assoc($q)): ?>

						<option <?=(strtoupper(@$stock['vehicle_option'])==strtoupper($r['option_name']))?"selected":""?> value="<?=strtoupper($r['option_name'])?>"><?=$r['option_name']?></option>

					<?php endwhile ?>
														</optgroup>
													</select>
												</div>
											</div>
										</div><div class="row">

											<div class="col-md-6">
												<div class="form-group ">
															<label>Registration Year </label>
													<select class="form-control select2-show-search border-bottom-0 w-100 br-3" data-placeholder="Select" name="reg_year_from">
														<optgroup label="From">
															<option value="null">From</option>
															<?php

						$date = date('Y');

						for ($i = $date; $i >= 1900; $i--) {?>

							<option value="<?=$i?>"><?=$i?></option>

						<?php

							} 

		     			?>

														</optgroup>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label style="visibility: hidden;">a</label>
													<select class=" form-control select2-show-search border-bottom-0 w-100 br-3" data-placeholder="Select" name="reg_year_to">
														<optgroup label="To Year">
															<option value="null">To</option>
															<?php

						$date = date('Y');

						for ($i = $date; $i >= 1900; $i--) {?>

							<option value="<?=$i?>"><?=$i?></option>

						<?php

							} 

		     			?>

														</optgroup>
													</select>
												</div>
											</div>
										</div>
										<div class="row">

											<div class="col-md-6">
												<div class="form-group ">
															<label>Price Range</label>
													<select class="form-control select2-show-search border-bottom-0 w-100 br-3" data-placeholder="Select" name="min_price">
														<optgroup label="Min Price">
															<option value="null">Min</option>
															  <?php
                               $i =1000;
                              while($i<50001){
                                ?>
                                <option value="<?=$i?>" >$<?=$i?> </option>
                                <?php
                                $i = $i+500;
                              }
                               ?>
														</optgroup>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label style="visibility: hidden;">a</label>
													<select class=" form-control select2-show-search border-bottom-0 w-100 br-3" data-placeholder="Select" name="max_price">
														<optgroup label="Max Price">
															<option value="null">Max</option>
															 <?php
                               $i =1000;
                              while($i<50001){
                                ?>
                                <option value="<?=$i?>" >$<?=$i?> </option>
                                <?php
                                $i = $i+500;
                              }
                               ?>
														</optgroup>
													</select>
												</div>
											</div>
										</div>
										
										<div class="d-none form-group relative">
											<input class="form-control fc-datepicker" placeholder="Appointment date" type="text">
											<div class="form-group-text">
												<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
											</div>
										</div>
										<Button class="btn btn-primary btn-lg btn-block" type="submit">Search it</Button>
										</form>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div><!-- /header-text -->
			
</div>
</div>