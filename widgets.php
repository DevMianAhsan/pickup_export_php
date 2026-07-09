
<?php

include_once "includes/header.php";

 $category = $_GET['category'];

 if($category == 'maker'){

 $sql = mysqli_query($dbc,"SELECT * FROM $category ");
}elseif($category == 'bodytype'){
	 $sql = mysqli_query($dbc,"SELECT * FROM body_type ");
}




?>


<!--BreadCrumb-->
		<div class="bg-white border-bottom">
			<div class="container">
				<div class="page-header">
					<h4 class="page-title">Cars</h4>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.php">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Categories</a></li>
						<li class="breadcrumb-item active" aria-current="page"><?=strtoupper($category)?></li>
					</ol>
				</div>
			</div>
		</div>
		<!--/BreadCrumb-->
<div class="container-fluid" >
<hr/>
<h3 class="" ><?=strtoupper($category)?></h3>
			<hr>

			<?php

if($category == 'maker'){
			?>
			<div class="row">
				
					


<?php
while($row = mysqli_fetch_assoc($sql)):

?>			


<div class="col-lg-1 col-sm-6">
																<div class="card border-2 box-shadow2 text-center" >
																	<a href="#" class="cat-img mx-auto text-center bg-transparent"><img src="admin/img/vehicles_images/<?=$row['maker_img']?>" class="w-80" style="height: 50px " alt=""></a><h6 class="font-weight-semibold mb-0"><?=strtoupper($row['maker_name'])?></h6>

																</div>
															</div>			
					<!-- <div class="col-sm-1 ">
						<div class="item">
							<div class="card">
								<div class="card-body">
									<div class="cat-item text-center">
										<a href="search.php?maker=<?=$row['maker_id']?>"></a>
										<div class="cat-img">
											<img src="admin/img/vehicles_images/<?=$row['maker_img']?>" alt="img">
										</div>
										<div class="cat-desc">
											<h4 class="font-weight-semibold mb-0"><?=strtoupper($row['maker_name'])?></h4>
											<span>(<?=rand(124,453)?>)</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> -->
<?php

endwhile;
?>						
						
						
					
				
			</div>

			<?php
}elseif($category == 'bodytype'){
			?>

<div class="row">
				
					


<?php
while($row = mysqli_fetch_assoc($sql)):
?>						<div class="col-sm-2">
						<div class="item">
							<div class="card">
								<div class="card-body">
									<div class="cat-item text-center">
										<a href="search.php?body_type=<?=$row['body_type_name']?>"></a>
										<div class="cat-img">
											<img src="admin/img/vehicles_images/<?=$row['body_type_img']?>" alt="img">
										</div>
										<div class="cat-desc">
											<h4 class="font-weight-semibold mb-0"><?=strtoupper($row['body_type_name'])?></h4>
											<span>(<?=rand(124,453)?>)</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
<?php

endwhile;
?>						
						
						
					
				
			</div>

<?php

}
?>			




</div>



<?php

include_once "includes/footer.php";
?>