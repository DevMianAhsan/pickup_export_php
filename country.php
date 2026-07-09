<?php

include_once "includes/header.php";

$sql = mysqli_query($dbc,"SELECT * FROM countries ORDER BY country_name ASC");

?>


 <!--BreadCrumb-->
		<div class="bg-white border-bottom">
			<div class="container">
				<div class="page-header">
					<h4 class="page-title">Countries Regulations </h4>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.php">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Countries</a></li>
						<li class="breadcrumb-item active" aria-current="page">Countries Regulations</li>
					</ol>
				</div>
			</div>
		</div>
		<!--/BreadCrumb-->
<div class="container">
		<hr>
			<h3 class="">Countries rules</h3>
			<hr>
<div class="row">
	
		
	<?php
while($country = mysqli_fetch_assoc($sql)):

	$countryname = strtolower($country['country_name']);



	// $regulations = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM country_regulation WHERE country_regulation_country = '$countryname'"));
	// if(empty($regulations)){
	// 		$age = 0;
	// }else{
	// 		$age = $regulations['country_regulation_year'];
	// }
	?>

				<div class="col-sm-1">
				<div class="card border-2 box-shadow2 text-center" style="width: 95px!important;margin-top: -20px" >
					<a href="country_info.php?country_code=<?=$country['country_code']?>&country=<?=$country['country_id']?>&countryname=<?=$country['country_name']?>" class="cat-img mx-auto text-center bg-transparent">
						<img src="assets/images/flags/<?=strtolower($country['country_code'])?>.svg" class="" style="height: 50px " alt=""></a><h6 class="font-weight-semibold mb-0"><?=strtoupper($country['country_name'])?></h6>

																</div>
															</div>						
				<!-- <div class="col-lg-1  col-md-4 col-sm-4">
					<div class="card">
						<div class="card-body" style="background-color: #eeeff5">
							<div class="product-item text-center">
								<a href="country_info.php?country_code=<?=$country['country_code']?>&country=<?=$country['country_id']?>&countryname=<?=$country['country_name']?>">
								<img src="assets/images/flags/<?=strtolower($country['country_code'])?>.svg" alt="img"  >
								</a>
							</div>
						</div>
						<div class="card-footer">
							<a href="country_info.php?country_code=<?=$country['country_code']?>&country=<?=$country['country_id']?>&countryname=<?=$country['country_name']?>">
							<h5 class="text-center mb-0 font-weight-semibold"><?=$country['country_name']?></h5>
						</a>
							<table class="table table-bordered table-hover">
								<tr>
									<td>Age Limit:</td>
									<td><?=$age?></td>
								</tr>
								<tr>
									<td>Ports:</td>
									<td><?=$regulations['country_regulation_destination_port']?></td>
								</tr>
								<tr>
									<td>Inspection:</td>
									<td><?=$regulations['country_regulation_inspection']?></td>
								</tr>

								<tr>
									<td>Hand:</td>
									<td><?=$regulations['country_regulation_hand']?></td>
								</tr>



							</table>
							
						</div>
					</div>
				</div> -->

				<?php
endwhile;
				?>
			</div>
</div>






























<?php

include_once "includes/footer.php";

?>