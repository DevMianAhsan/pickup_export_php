 <?php 
include_once "includes/header.php";
include_once "inc/code.php";

?>
<!-- start page content -->
<?php if ($_REQUEST['o']=='add'): ?>
				<div class="col-sm-12">
				<div class="card">
					<div class="card-header card-bg" align="center">
						    <b class="h4 text-center card-text">Add Inquiry</b>
					</div>
						<div class="card-body">
							<form action="php_action/inner_action.php" method="POST" role="form" id="formDataIQ">
								<input type="hidden" name="inquiry_id" value="" >
								<div class="form-group row">
									<div class="col-sm-6">
										
									<label for="">Select Vehicle</label>
									<select class="form-control" id="inquiryvehicle" name="inquiryvehicle"> 
										<option value="">Select</option>
										<?php 
										$q = get($dbc,"vehicle_info");
										while ($r = mysqli_fetch_assoc($q)):
								$brand=fetchRecord($dbc,"brands","brand_id",$r['vehicle_brand']);
								$maker=fetchRecord($dbc,"maker","maker_id",$r['vehicle_maker']);
											?>
											<option value="<?=$r['vehicle_id']?>"><?=$maker['maker_name']?> <?=$brand['brand_name']?></option>
										<?php endwhile ?>
									</select>
								
								
									</div>
									<div class="col-sm-6">
									<label for="">Select Customer </label>
									<select class="form-control" id="customer_id" name="customer_id"> 
										<option value="">Select Customer </option>
										<?php 
										$q = get($dbc,"customers WHERE customer_active = 1 AND customer_role = 'customer'");
										while ($r = mysqli_fetch_assoc($q)):?>
											<option value="<?=$r['customer_id']?>"><?=$r['customer_name']?></option>
										<?php endwhile ?>
									</select>
								</div>
								</div>
								
								
								<div class="form-group row">
									<div class="col-sm-6">
									<label for="">Sold Rate</label>
									<input type="number" min="0" class="form-control" id="sold_rate" name="sold_rate"> 
								</div>
									<div class="col-sm-6">
										
									<label for="">Select Currency </label>
									<select class="form-control" id="currency_id" name="currency_id"> 
										<option value="">Select Currency </option>
										<?php 
										$q = get($dbc,"currency WHERE currency_status = 1");
										while ($r = mysqli_fetch_assoc($q)):?>
											<option value="<?=$r['currency_id']?>"><?=$r['currency_name']?></option>
										<?php endwhile ?>
									</select>
								
									</div>

								</div>
									<?php if (@$userPrivileges['nav_add']==1 || $fetchedUserRole=="admin"): ?>
								<button type="submit" class="btn btn-primary" id="formDataIQ_btn">Save</button>
								<?php endif ?>
							</form>
							</div>
						</div>
					</div>

<?php endif ?>

<?php if ($_REQUEST['o']=='list'): ?>
	

<div class="col-sm-12">
		<div class="card">
	<div class="card-header card-bg" align="center">    <b class="h4 text-center card-text">Inquiry Lists</b></div>
	<div class="card-body">
			<table class="table dataTable" id="formDataIQTb">
				<thead>
			<tr>	
				<th>ID</th>
				<th>Vehicle Info</th>
				<th>Customer Info</th>
				<th>Sold Rate</th>
				<th>Currency</th>
				<th>Timestamp</th>
			</tr>
			</thead>
			<tbody>
				<?php
				$q = get($dbc,"inquiry");
				$c=0;
				while ($r = mysqli_fetch_assoc($q)):
				$vehicle=fetchRecord($dbc,"vehicle_info","vehicle_id",$r['vehicle_id']);
				$brand=fetchRecord($dbc,"brands","brand_id",$vehicle['vehicle_brand']);
				$maker=fetchRecord($dbc,"maker","maker_id",$vehicle['vehicle_maker']);
				$customer=fetchRecord($dbc,"customers","customer_id",$r['customer_id']);
				$currency=fetchRecord($dbc,"currency","currency_id",$r['currency_id']);
				$c++;
			?>
					<tr>	
					<td><?=$c?></td>
					<td><?=$maker['maker_name']?> <?=$brand['brand_name']?></td>
					<td><?=$customer['customer_name']?></td>
					<td><?=$r['sold_rate']?></td>
					<td><?=$currency['currency_name']?></td>
					<td><?=$r['timestamp']?></td>


					</tr>	
			<?php 	endwhile; ?>
										
			</tbody>
			
			
			</table>
		
	</div>
</div>

</div>
	<?php endif ?>

	<?php if ($_REQUEST['o']=='web'): ?>
	

<div class="col-sm-12">
		<div class="card">
	<div class="card-header card-bg" align="center">    <b class="h4 text-center card-text">Inquiry Lists</b></div>
	<div class="card-body">
			<table class="table dataTable" id="formDataIQTb">
				<thead>
			<tr>	
				<th>ID</th>
				<th>Vehicle Info</th>
				<th>Customer Info</th>
				<th>Sold Rate</th>
				<th>Currency</th>
				<th>Timestamp</th>
			</tr>
			</thead>
			<tbody>
				<?php
				$q = get($dbc,"inquiry");
				$c=0;
				while ($r = mysqli_fetch_assoc($q)):
				$vehicle=fetchRecord($dbc,"vehicle_info","vehicle_id",$r['vehicle_id']);
				$brand=fetchRecord($dbc,"brands","brand_id",$vehicle['vehicle_brand']);
				$maker=fetchRecord($dbc,"maker","maker_id",$vehicle['vehicle_maker']);
				$customer=fetchRecord($dbc,"customers","customer_id",$r['customer_id']);
				$currency=fetchRecord($dbc,"currency","currency_id",$r['currency_id']);
				$c++;
			?>
					<tr>	
					<td><?=$c?></td>
					<td><?=$maker['maker_name']?> <?=$brand['brand_name']?></td>
					<td><?=$customer['customer_name']?></td>
					<td><?=$r['sold_rate']?></td>
					<td><?=$currency['currency_name']?></td>
					<td><?=$r['timestamp']?></td>


					</tr>	
			<?php 	endwhile; ?>
										
			</tbody>
			
			
			</table>
		
	</div>
</div>

</div>
	<?php endif ?>

<?php
include_once "includes/footer.php";

?>
<script type="text/javascript" src="assets/js/custom2.js"></script>