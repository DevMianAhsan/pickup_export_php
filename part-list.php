<!doctype html>
<html lang="en" dir="ltr">
	<?php include_once "includes/header.php"; include_once 'admin/includes/functions.php';
	?>
	<body>
		<!--Topbar-->
		<?php include_once "includes/topbar.php"; ?>
		<!--/Topbar-->
		<!--Section-->
		<div>
			<?php include_once "dashboard/get_partbar.php"; ?>
		</div>
		<!--Section-->
		<div class="container py-5">
			<div class="row">
				<div class="col text-center text-uppercase font-weight-bold">
					<h2>
					SOP's for maintaining quality for our business
					</h2>
				</div>
			</div>
			<section>
				<div class="row my-3">
					<div class="col">
						<h3>How To Buy Containers of used auto parts from Japan.
						
						</h3>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<p>
							1. You have to confirm us the below information regarding your required vehicles
								<br><li>Quantity</li>
								<br><li>Maker</li>
								<br><li>Brand</li>
								<br><li>Engine CC</li>
								<br><li>Port of Discharge</li>
								<br><li>Type of Service (Nose Cut, Half Cut, Complete Dismentle)</li><br><br>
 
2. We will reply you the quoation.<br><br>

3. Customer will have to pay 100% amount via T.T (Telegrahic Transfer).<br><br>

4. Container will be packed as per your requirments & shiped to  your designated port.<br><br>


						</p>
					</div>
				</div>
			</section>
			<section>
				<div class="row my-3">
					<div class="col">
						<h3>
						Damage Prevention
						</h3>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<p>
							<h5>Damage Prevention By Optimal Stock Location.</h5> It's impossible to avoid parts damage if panels are left on front cuts. If the parts are removed they can be packed in the optimal way in the container to reduce the space take and be protected from damage.

						</p>
						<p>
							<h5>Damage Prevention By Tightness Of Packing.</h5> When the container is at sea it is constantly moving up and down, back and forth, side to side - with the load constantly weighting and unweighting. If the stock is not packed tightly together you will get movement of the stock and with movement you get damage. With panels removed stacks of front cuts can be stacked tightly against each other which prevents movement and costly damage. And no more tears when you open up the container and find that perfectly good stock has been turned into scrap.

						</p>
						<p>
							<h5>Ease Of Loading And Unloading.</h5> Our modular loading and unloading system is based on panels being removed. This means you can unload the front halves in the same modules that they were loaded, quickly, safely and without damage.

						</p>
						<p>
							<h5>Biological Cleanliness.</h5> Many countries now require that the stock is biologically clean before it can be imported. This means no dirt, bugs, leaves, grass-seeds, etc. The main areas where these contaminants are found on front cuts are inside fenders and bumpers, the plenum chamber, under the engine-transmission and on the underside of the strut towers. The only way that these areas can be properly cleaned is by removing all panels and underbody plastics and cleaning with a jet-spray. The parts removed also need to be cleaned and this can only be done if they are removed. Doing this work in Japan saves you time and money on cleaning, storage and penalties when the shipment arrives. And since cleaning has to be done anyway, why not do it at the earliest point in the supply chain?


						</p>
					</div>
				</div>
			</section>
			<div class="row">
				<?php
				$parts_info = mysqli_query($dbc,"SELECT vehicle_image_name FROM `vehicle_images` WHERE vehicle_id='15' AND images_type='part' ORDER BY order_no ASC LIMIT 20");
				if (mysqli_num_rows($parts_info)>0) {
					while ($part_img=mysqli_fetch_assoc($parts_info)) {
				?>

				<div class="col-sm-3 my-2">
				<a data-fancybox="gallary" href="admin/img/vehicles_images/<?= $part_img['vehicle_image_name'] ?>">	
					<img class="img img-responsive rounded" src="admin/img/vehicles_images/<?= $part_img['vehicle_image_name'] ?>" width='100%' height='250px' alt="">
				</a>
				</div>
					    
				<?php
					}
					
				}
				?>

			</div>
			<section>
				<div class="row mt-5">
					<div class="col">
						
					<h2>TYPES OF CUTS</h2>
					</div>
				</div>
				<div class="row my-3">
					<div class="col">
						<h3>
						Front Cuts
						</h3>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<p>
							These are the same cuts, but have different names in different world markets. Typically cut on the A-Pillar just above the highest point of the dash (usually the meter area) and through the floor just behind the transmission lever. All mechanicals are left intact and the propeller shaft and exhaust system unbolted. Great for performance conversions, because you get all the bits, unlike say getting an engine-transmission only. By default:

the fuel and brake lines are cut long and wound up high on the stub of the A-Pillar to stop leaking,

the A-Pillars are cut horizontal - not at 90 degrees to the pillar - to facilitate stacking, and

all panels are removed to prevent damage, reduce the space take in the container, and allow for the front cut and inside of panels to be properly cleaned (this is a major area of biological contamination).

If you have special requirements just let us know when you are completing your dismantling instructions for the car. Its also a good idea to get the diff, because JDM ratios and export market ratios can sometimes be different.
<BR>
<H4>Nose Cuts</H4>
<BR>
These are as the name suggests, just the "nose". This include all front bits - with no dismantling - and cut just behind the radiator support. i.e. bumper, reinforcement bar, radiator, condenser, headlights, grille, etc. Because you get all the bits you need they are great for repairing minor front damage or for a "facelift" mod. e.g. "Onevia", "Sileighty" etc. Nose cuts are mostly available for older end of life cars. For late model cars or valuable cars you will usually need to source the whole vehicle and have the nose cut done as part of the dismantling process.

<BR><BR>
<H4>Side Cuts</H4>
<BR>
These are typically B-Pillar Cuts - with the B-Pillar and portions of turret and sill - or "Sill Cuts" with the complete sill and small portion of the B-Pillar. These are used for repairing side crash damage.

<BR><BR>
<H4>Side Quarter Cuts</H4>
<BR>
These are cuts typically cut through the floor in front of the B-Pillar and rearwards through the trunk, and through the roof inside of the edge. These are used for repairing rear side crash damage.
<BR><BR>
<H4>Rear Cuts</H4>
<BR>
In its most basic form this is a "Long Rear Cut", or what you get leftover when you do a front cut. i.e. all the rear from the A-Pillar onwards. They do take up a lot of space in a container, but you can pack out the trunk with small parts, and seats and small parts pack out well inside the car. There's also a technique to pack over the turret without damage. Another variation is to cut the turret just in front of the C-Pillar and the floor in front of the rear wheel arch to create a "Short Rear Cut". And you can go smaller still with a cut through the trunk area to create a "Tail Cut" or "Beaver Cut" which is used for repairing minor rear damage.

<BR><BR>
<H4>Roof Cuts</H4>
<BR>
As the name suggests, these are cut through the A, B and C-Pillars to get a "roof only" cut. Used for repairing bad turret damage - rollover, hail, fallen tree branches etc.

All of the cuts are by reciprocating saw which gives you clean cuts and avoids damage which is common with oxy-acetylene and rotary blade cutters.
						</p>
					</div>
				</div>
				<div class="row">	
				<?php
				$parts_info = mysqli_query($dbc,"SELECT vehicle_image_name FROM `vehicle_images` WHERE vehicle_id='16' AND images_type='part' ORDER BY order_no ASC LIMIT 20");
				if (mysqli_num_rows($parts_info)>0) {
					while ($part_img=mysqli_fetch_assoc($parts_info)) {
				?>

				<div class="col-sm-3 my-2">
					<a data-fancybox="gallary" href="admin/img/vehicles_images/<?= $part_img['vehicle_image_name'] ?>">	
					<img class="img img-responsive rounded" src="admin/img/vehicles_images/<?= $part_img['vehicle_image_name'] ?>" width='100%' height='250px' alt="">
					</a>
				</div>
					    
				<?php
					}
				}
				?>
				</div>
			</section>
		</div>
		
		<?php include_once "includes/footer.php" ?>
	</body>
</html>