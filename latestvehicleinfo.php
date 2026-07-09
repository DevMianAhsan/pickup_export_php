<section class="new-arrivals-section">
	<div class="">

		<div class="arrival-heading">
			NEW ARRIVALS
		</div>

		<div class="arrival-grid">

			<?php
			$sqlvehicle = mysqli_query($dbc, "SELECT * FROM vehicle_info ORDER BY vehicle_id DESC LIMIT 4");

			while ($vehicle = mysqli_fetch_assoc($sqlvehicle)):

				$img = mysqli_fetch_assoc(mysqli_query($dbc, "
                SELECT *
                FROM vehicle_images
                WHERE vehicle_id='$vehicle[vehicle_id]'
                AND vehicle_image_featured='1'
                LIMIT 1"));

				$maker = mysqli_fetch_assoc(mysqli_query($dbc, "
                SELECT * FROM maker
                WHERE maker_id='$vehicle[vehicle_maker]'"));

				$brand = mysqli_fetch_assoc(mysqli_query($dbc, "
                SELECT * FROM brands
                WHERE brand_id='$vehicle[vehicle_brand]'"));
				?>

				<div class="arrival-item">

					<a href="singlecar.php?i=<?= base64_encode($vehicle['vehicle_id']) ?>">

						<img src="admin/img/vehicles_images/<?= $img['vehicle_image_name'] ?>">

					</a>

					<h4>
						<?= strtoupper($maker['maker_name']) ?>
						<?= $brand['brand_name'] ?>
					</h4>

					<p>
						<?= $vehicle['vehicle_reg_year'] ?> -
						<?= $vehicle['vehicle_transmission'] ?>
						<?php
						if (!empty($vehicle['vehicle_drive'])) {
							echo " - " . $vehicle['vehicle_drive'];
						}
						?>
					</p>

				</div>

			<?php endwhile; ?>

		</div>

		<div class="arrival-btn">
			<a href="stock.php">See More →</a>
		</div>
		</br>

	</div>
</section>
<style>
	.new-arrivals-section {
		background: #fff;
		/* padding:25px 0; */
	}

	.arrival-heading {
		margin: 0 0 1rem 0 !important;
		/* mb-3 */
		padding: 0.25rem 1rem;
		/* py-1 px-4 */
		background: #b6bcc4;
		/* bg-black */
		color: #000;
		/* text-white *           /* text-center */
		font-weight: 700;
		/* font-bold */
		font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
			"Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
		/* font-sans */
		font-size: 1rem;
		/* 16px */
		line-height: 1.5;
		border-radius: 0.125rem;
		/* rounded-sm */
	}


	.arrival-grid {
		display: flex;
		flex-wrap: wrap;
		gap: 18px;
		padding-left: 4px;
	}

	.arrival-item {
		width: 23%;
	}

	.arrival-item a {
		display: block;
		overflow: hidden;
	}

	.arrival-item img {
		width: 100%;
		height: 145px;
		object-fit: cover;
		transition: .3s;
	}

	.arrival-item:hover img {
		transform: scale(1.05);
	}

	.arrival-item h4 {
		margin-top: 10px;
		margin-bottom: 2px;
		font-size: 17px !important;
		font-weight: 400 !important;
		color: #111;
		text-transform: uppercase;
		/* uppercase */
	}

	.arrival-item p {
		margin: 0;
		font-size: 12px !important;
		color: #4c5b6d;
		font-weight: 600 !important;
	}

	.arrival-btn {
		text-align: right;
		margin-top: 30px;
		padding-right: 4px;
	}

	.arrival-btn a {
		display: inline-block;
		border: 2px solid #ff6b2c;
		color: #ff6b2c;
		text-decoration: none;
		padding: 6px 18px;
		transition: .3s;
		font-size: 15px;
	}

	.arrival-btn a:hover {
		background: #ff6b2c;
		color: #fff;
	}

	@media(max-width:991px) {

		.arrival-item {
			width: 31%;
		}

	}

	@media(max-width:768px) {

		.arrival-item {
			width: 48%;
		}

	}

	@media(max-width:576px) {

		.arrival-item {
			width: 100%;
		}

		.arrival-item img {
			height: 220px;
		}

	}
</style>