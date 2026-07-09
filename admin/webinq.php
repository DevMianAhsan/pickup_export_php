
 <?php 
include_once "includes/header.php";
include_once "inc/code.php";

?>
<!-- start page content -->
<?php if ($_REQUEST['o']=='add'): ?>
				<div class="col-sm-12">
				<div class="card">
					<div class="card-header card-bg" align="center">
						    <b class="h4 text-center card-text">Add Inquiry Of <?=$_REQUEST['inquiry_of']?> </b>
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
	<div class="card-header card-bg" align="center">    <b class="h4 text-center card-text">Inquiry Lists <?=$_REQUEST['inquiry_of']?></b></div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table dataTable" id="formDataIQTb">
				<thead>
			<tr>	
				<th>Inquiry ID</th>
				<th>Vehicle Info</th>
				<th>Customer Info</th>
				<th >Inquiry Msg</th>
				<th>Country/Port </th>
				<th>Inquiry Service </th>
				<th>Timestamp</th>
			</tr>
			</thead>
			<tbody>
				<?php
				$q = get($dbc,"pending_inquiry WHERE inquiry_of = '".$_GET['inquiry_of']."'");
				$c=0;
				while ($r = mysqli_fetch_assoc($q)):
					if($_GET['inquiry_of'] == 'machine'){
							$vehicle=fetchRecord($dbc,"machines","machine_id",$r['vehicle_id']);

							$brand=fetchRecord($dbc,"brands","brand_id",$vehicle['machine_brand']);
							$maker=fetchRecord($dbc,"maker","maker_id",$vehicle['machine_maker']);

						}elseif($_GET['inquiry_of'] == 'part'){
							$vehicle=fetchRecord($dbc,"vehicle_parts","part_id",$r['vehicle_id']);
							$brand=fetchRecord($dbc,"brands","brand_id",$vehicle['part_brand']);
							$maker=fetchRecord($dbc,"maker","maker_id",$vehicle['part_maker']);
						}else{
							$vehicle=fetchRecord($dbc,"vehicle_info","vehicle_id",$r['vehicle_id']);
							$brand=fetchRecord($dbc,"brands","brand_id",$vehicle['vehicle_brand']);
							$maker=fetchRecord($dbc,"maker","maker_id",$vehicle['vehicle_maker']);
						}
				
				
				
				$c++;
			?>
					<tr>	
					<td><?=$r['p_inquiry_id']?></td>
					<td><?=$maker['maker_name']?> <?=$brand['brand_name']?><br/>
					<?php if($_GET['inquiry_of'] == 'vehicle'){
						?>
						<button onclick="loadData('vehicle_info', <?=$vehicle['vehicle_id']?>)" class="dropdown-item text-success view">Vehicle Info</button>
						<?php
						 }elseif($_GET['inquiry_of'] == 'part') {
						 ?>
						 	<button onclick="loadData('vehicle_parts', <?=$vehicle['part_id']?>)" class="dropdown-item text-success view">Part Info</button>
						<?php
						 }elseif($_GET['inquiry_of'] == 'machine') {
						 	?>
						 	<button onclick="loadData('machines', <?=$vehicle['machine_id']?>)" class="dropdown-item text-success view">Machine Info</button>
						 <?php
						 }else {
						 	echo "Something Went wrong";
						 }
						 ?>
					</td>
					<td>
						<?=$r['inquiry_name']?><br/>
					<a href="tel:<?=$r['inquiry_phone']?>"><?=$r['inquiry_phone']?></a><br/>
					<a href="mailto:<?=$r['inquiry_email']?>"><?=$r['inquiry_email']?></a>	
					</td>
					<td><?=$r['inquiry_msg']?></td>
					<td><?=$r['inquiry_country']?>/<?=$r['inquiry_port']?></td>
					<td><?=$r['inquiry_services']?></td>
					<td><?=date('D,d-m-Y',strtotime($r['inquiry_timestamp']))?></td>


					</tr>	
			<?php 	endwhile; ?>
										
			</tbody>
			
			
			</table>
			</div>
		
	</div>
</div>

</div>
	<?php endif ?>

<?php
include_once "includes/footer.php";

?>
<script type="text/javascript" src="assets/js/custom2.js"></script>

<div class="modal fade" id="modal-id">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title"></h4>

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

      </div>

      <div class="modal-body" id="loadData">

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>

</div>
</div>
