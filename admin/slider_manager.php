<?php
	include_once "includes/header.php";


	?>

	<script type="text/javascript">
		$(document).ready( function () {
	    $('#myTable').DataTable();
	} );
	</script>

	<div class="row">
		<div class=""><?php getMessage(@$msg,@$sts); ?></div>
		<?php
			if (@$_GET['i']) {
				$slider_img_id = $_GET['i'];
				$selectProduct = "SELECT * FROM slider_img WHERE slider_img_id = '$slider_img_id' ";
				$run = mysqli_query($dbc,$selectProduct);
					while($row = mysqli_fetch_assoc($run)){

						$slider_img = $row['slider_img'];
						$slider_img_sts = $row['slider_img_sts'];
						$slide_heading =  $row['slider_img_heading'];
						$slider_desc =  $row['slider_img_desc'];
						
					}

				
			}
		?>
		<div class="col-sm-4">
			<div class="card">
				<div class="card-header card-bg" align="center"><em>Add Slider Image</em></div>
				<div class="card-body">
					<form action="" method="post" enctype="multipart/form-data">
					


					  <div class="form-group">
					    <label for="email">Slider img </label>
					    <?php if(!empty($_GET['i'])): ?>
								<img src="img/slider/<?=$slider_img?>" width="100%" height="100" alt="">
							<?php endif; ?>
					    <input type="file" class="form-control"  name="slider_img" >
					  </div>
							
							 <div class="form-group">
					    <label for="pwd">Slider img Heading</label>
					    <input type="text" class="form-control" id="pwd" name="slider_img_heading" value="<?= @$slide_heading?>">
					  </div>

					   <div class="form-group">
					    <label for="pwd">Image Description</label>
					    <input type="text" class="form-control" id="pwd" name="slider_img_desc" value="<?= @$slider_desc?>">
					  </div>			
					    <div class="form-group">
					    <label for="pwd">Status</label>
					   		<select class="form-control" name="slider_img_sts">
					   			
					   			<option value="1">Available</option>
					   			<option value="2">Not Available</option>
					   		</select>
					  </div>
					<?php
						if (isset($_GET['i'])) {
							?>
							<input type="submit" name="editimg" class="btn btn-info" value="Edit Slider Img">
							<?php
						}else{
					?>
					 <input type="submit" name="addimg" class="btn btn-success" value="Add Image">
					 <?php
					}
					 ?>
					</form>
				</div>
			</div>

		</div>  <!-- col-sm-4 end -->


		<div class="col-sm-8">
			<div class="card card-info">
				<div class="card-header card-bg" align="center"><em>Show Slider Images</em></div>
				<div class="card-body">
						<table class="table" id="myTable" class="table-responsive">

		<thead>
			<tr class="">
				<th>Image ID</th>
				<th>Image Name</th>
				<th>Heading</th>
				<th >Description</th>
				<th>Status</th>
				<th>Option</th>
				<th>DELETE</th>
			</tr>
		</thead>
		<tbody>
			<?php $q=mysqli_query($dbc,"SELECT * FROM slider_img  ORDER BY slider_img_id DESC LIMIT 50 ");
			while($r=mysqli_fetch_assoc($q)):
				//$customer_id = $r['customer_id'];
			 ?>
			<tr>
				<td><?=$r['slider_img_id']?></td>
				<td class="text-capitalize"><img src="img/slider/<?=$r['slider_img']?>" width="100%" height="100" alt=""></td>

				<td><?=$r['slider_img_heading']?></td>
				<td style="font-size: 5px;"><?=$r['slider_img_desc']?></td>
				<td><?=$r['slider_img_sts']?></td>
				<td><a href="slider_manager.php?i=<?=$r['slider_img_id'];?>"> <button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span>Edit</button></a></td>
				<td><a href="slider_manager.php?delete_img_slider=<?=$r['slider_img_id'];?>"> <button class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span>DELETE</button></a></td>
				
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
				</div>
			</div>

		</div>  <!-- col-sm-8 end -->
	 

	</div><!-- row end -->


	<?php

	include_once "includes/footer.php";
	// Add Slider image


	


	if (isset($_REQUEST['addimg'])) {
		
		if ($_FILES['slider_img']['tmp_name']) {
		 			# code...
		 			upload_pic($_FILES['slider_img'],'img/slider/');

		 		$data=[

		 		'slider_img' => $_SESSION['pic_name'],
			'slider_img_heading' => $_POST['slider_img_heading'],
			'slider_img_desc' => $_POST['slider_img_desc'],
			'slider_img_sts' => $_POST['slider_img_sts']
		 				
			 		];	
	
 			 if (insert_data($dbc,'slider_img', $data)) {
				# code...
				//echo "<script>alert('Slider Img Added....!')</script>";
				$msg = "Image Added";
					$sts = 'success';
					redirect("slider_manager.php",2000);
				}else{
					$msg = mysqli_error($dbc);
					$sts ="danger";
				}
		 		
		 	}




}    /*Add image*/

				if (isset($_REQUEST['delete_img_slider'])) {

				$sql = "DELETE FROM slider_img WHERE slider_img_id = '$_REQUEST[delete_img_slider]' ";
				if(mysqli_query($dbc,$sql)){
					$msg = "Slider Image Deleted...!";
					$sts = 'success';
					redirect("slider_manager.php",2000);
					
				}
				else{
					$msg = mysqli_error($dbc);
					$sts ="danger";

				}
				}   /*Delete Image */



			if (isset($_POST['editimg'])) {
		
		if ($_FILES['slider_img']['tmp_name']) {
			$slider_id = $_REQUEST['i'];
		 			# code...
		 			upload_pic($_FILES['slider_img'],'img/slider/');

		 		$data=[

		 		'slider_img' => $_SESSION['pic_name'],
			'slider_img_heading' => $_POST['slider_img_heading'],
			'slider_img_desc' => $_POST['slider_img_desc'],
			'slider_img_sts' => $_POST['slider_img_sts']
		 				
			 		];	
	
 			 if (update_data($dbc,'slider_img', $data , 'slider_img_id',$slider_id)) {
				# code...
				//echo "<script>alert('Slider Img Added....!')</script>";
				$msg = "Image Added";
					$sts = 'success';
					redirect("slider_manager.php",2000);
				}else{
					$msg = mysqli_error($dbc);
					$sts ="danger";
				}
		 		
		 	}
		 }
		


		 
	?>
