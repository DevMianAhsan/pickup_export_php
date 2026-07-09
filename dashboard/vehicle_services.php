
			<div class="container">
				<div class="section-title center-block text-center">
					<h2>Top Car Makers</h2>
					<p>Select your dreams car by thier maker</p>
				</div>
                <div class="row">
                	
					<?php $q = get($dbc,"maker WHERE maker_sts = '1' LIMIT 6");
						$random_bandage=array('badge-primary','badge-pink','badge-warning','badge-danger','badge-success','badge-dark');
						 $arr_i=0;
							while($r = mysqli_fetch_assoc($q)): 
						

						?>

					
										
					<div class="col-xl-4 col-lg-6 col-md-6">
						<div class="card">
							<div class="item-card item-card2">
								<div class="item-card-desc">
									<a href="car-lists.php?get=maker&maker=<?=$r['maker_id']?>"></a>
									<div class="item-card-img">
										<img src="admin/img/vehicles_images/<?=$r['maker_img']?>" alt="img" class="">
									</div>
									<div class="item-card-text">
										<h4 class="mb-3 fs-30"><strong><?=$r['maker_name']?></strong></h4>
										<div class="badge <?=$random_bandage[$arr_i];?> badge-pill px-5 py-2 fs-16"><?=countWhen($dbc,'vehicle_info','vehicle_maker',$r['maker_id'])?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php $arr_i= $arr_i+1; endwhile ?>
                </div>
			</div>
		