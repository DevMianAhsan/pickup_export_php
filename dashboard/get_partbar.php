			<div class="cover-image sptb-1 bg-background" data-image-src="../assets/images/banners/banner1.jpg">

				<div class="header-text1 mb-0">

					<div class="container">

						<div class="row">

							<div class="col-xl-10 col-lg-12 col-md-12 d-block mx-auto">

								<div class="text-center text-white ">

									<h1 class="mb-1 text-uppercase">Parts in Container</h1>

									<!-- <p>It is a long established fact that a reader will be distracted by the when looking at its layout.</p> -->

								</div>

								<!-- <div class="mb-0 bg-dark-transparent-2 p-4">

									<form method="get" action="part-list.php">

											<input type="hidden" name="advance" value="s">

											

									<div class="form row">

										<div class="col-xl-3 col-lg-3 col-md-12 mb-0">

											<div class="form-group select2-lg mb-xl-0">

												<select name="maker" class="form-control select2-show-search border-bottom-0 w-100" data-placeholder="Select">

													<optgroup label="Categories"><option value="null">Choose Maker</option>



												<?php $q = get($dbc,"maker WHERE maker_sts = '1'");

												while($r = mysqli_fetch_assoc($q)): ?>



													<option value="<?=$r['maker_id']?>"><?=$r['maker_name']?></option>



														<?php endwhile ?></optgroup>

												</select>

											</div>

										</div>

										<div class="col-xl-3 col-lg-3 col-md-12 mb-0">

											<div class="form-group select2-lg mb-xl-0">

												<select name="brands" class="form-control select2-show-search border-bottom-0 w-100" data-placeholder="Select">

													<optgroup label="Categories">

															<option value="null">Select Model</option>

															<?php $q = get($dbc,"brands WHERE brand_status = 1 ");

												while($r = mysqli_fetch_assoc($q)): ?>



													<option value="<?=$r['brand_id']?>"><?=$r['brand_name']?></option>



														<?php endwhile ?>

														</optgroup>

												</select>

											</div>

										</div>

										<div class="col-xl-3 col-lg-3 col-md-12">

											<div class="form-group select2-lg mb-xl-0">

												<select name="part_year" class="form-control select2-show-search border-bottom-0 w-100" data-placeholder="Select">

													<optgroup label="Year">

															<option value="null">Choose Year</option>

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

										<div class="col-xl-3 col-lg-3 col-md-12 mb-0">

											<button type="submit" class="btn btn-lg btn-block btn-primary br-bl-0 br-tl-0">Search</button>

										</div>

									</div>

								</div>

							</form>

							</div> -->

						</div>

					</div>

				</div><!-- /header-text -->

			</div>

		</div>

		<!--Section-->

