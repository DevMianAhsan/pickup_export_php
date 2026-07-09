<!doctype html>
<html lang="en" dir="ltr">
<?php include_once "includes/header.php"; ?>

<div class="mt-"  >
		<?php
		include "slider.php";
		?>
	</div>
<div class="container-fluid mt-4 bg-white">
	
	<div class="row">
		<div class="col-sm-2  d-none d-sm-block d-md-block">
			<?php
			include_once "brandbar.php";
			?>
		</div>
		<!-- Cols-m-3 end -->

		<div class="col-sm-7">

			<div class="row" >
				<!-- <div class="col-sm-12 d-none d-sm-block d-md-block">
					
					<div class="row" style="margin-top: 10px">
						<div class="col-4 d-none d-sm-block d-md-block" align="center">
							<img src="admin/img/web/mid.jpg" style="height: 180px;">
							<div class=" bg-info text-white " style="font-size:18px">Mid year sale</div>
						</div>
						<div class="col-4 d-none d-sm-block d-md-block" align="center">
							<img src="admin/img/web/truck.jpg" style="height: 180px;">
							<div class=" bg-info text-white " style="font-size:18px">Truck For sale</div>

						</div>
						<div class="col-4 d-none d-sm-block d-md-block" align="center">
							<img src="admin/img/web/suv.jpg" style="height: 180px;">
							<div class=" bg-info text-white " style="font-size:18px">Checkout Our SUV</div>

						</div>
						<div class="col-3 d-none d-sm-block d-md-block" align="center">
							<img src="admin/img/web/sports.jpg" style="height: 180px;">
						<span>JDM Sprots Car</span>	
								<div class=" bg-info text-white " style="font-size:18px"> Sprots Car</div>

						</div>
					</div>
				</div> -->
				<div class="col-sm-12">
					<?php
					include_once "latestvehicleinfo.php";
					?>
				</div>

				<div class="col-sm-12">
					<?php
					include_once "discountusedcar.php";
					?>
				</div>
			</div>

		</div>
		<div class="col-sm-3">
			<?php
			include_once "rightbarreviews.php";
			?>
		</div>
	</div>
</div>


<?php
include_once "includes/footer.php";
?>