<?php
	include_once "includes/header.php";

	// --- POST handling must run before getMessage() is echoed below ---

	if (isset($_REQUEST['addimg'])) {

		if (empty($_FILES['slider_img']['tmp_name'])) {
			$msg = "Please Choose a Slider Image";
			$sts = "danger";
		} else {
			$uploaded = upload_pic($_FILES['slider_img'],'img/slider/');

			if (!$uploaded) {
				// upload_pic() already set $msg/$sts (e.g. invalid type)
				$sts = @$sts ?: "danger";
				$msg = @$msg ?: "Image Not Uploaded";
			} else {
				$data=[
		 			'slider_img' => $_SESSION['pic_name'],
					'slider_img_heading' => @$_POST['slider_img_heading'],
					'slider_img_desc' => @$_POST['slider_img_desc'],
					'slider_img_sts' => @$_POST['slider_img_sts'],
					'slider_img_type' => 'vertical'
		 				
				];	
	 			if (insert_data($dbc,'slider_img', $data)) {
					$msg = "Image Added";
					$sts = 'success';
					redirect("vertical_slider_manager.php",2000);
				}else{
					$msg = mysqli_error($dbc);
					$sts ="danger";
				}
			}
		}

	}    /*Add image*/

	if (isset($_REQUEST['delete_img_slider'])) {

		$id = $_REQUEST['delete_img_slider'];
		$row = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT slider_img FROM slider_img WHERE slider_img_id = '$id' "));
		$file = @$row['slider_img'];
		if ($file != "" && file_exists('img/slider/'.$file)) {
			@unlink('img/slider/'.$file);
		}
		$sql = "DELETE FROM slider_img WHERE slider_img_id = '$id' AND slider_img_type = 'vertical' ";
		if(mysqli_query($dbc,$sql)){
			$msg = "Vertical Slider Image Deleted...!";
			$sts = 'success';
			redirect("vertical_slider_manager.php",2000);
		}
		else{
			$msg = mysqli_error($dbc);
			$sts ="danger";

		}
	}   /*Delete Image */

	if (isset($_POST['editimg'])) {

		$slider_id = $_REQUEST['i'];

		$data=[
			'slider_img_heading' => @$_POST['slider_img_heading'],
			'slider_img_desc' => @$_POST['slider_img_desc'],
			'slider_img_sts' => @$_POST['slider_img_sts'],
			'slider_img_type' => 'vertical'
		];

		$proceed = true;
		if (!empty($_FILES['slider_img']['tmp_name'])) {
			$uploaded = upload_pic($_FILES['slider_img'],'img/slider/');

			if (!$uploaded) {
				$sts = @$sts ?: "danger";
				$msg = @$msg ?: "Image Not Uploaded";
				$proceed = false;
			} else {
				$data['slider_img'] = $_SESSION['pic_name'];
			}
		}

		if ($proceed) {
			if (update_data($dbc,'slider_img', $data , 'slider_img_id',$slider_id)) {
				$msg = "Image Updated";
				$sts = 'success';
				redirect("vertical_slider_manager.php",2000);
			}else{
				$msg = mysqli_error($dbc);
				$sts ="danger";
			}
		}
	}

	?>

	<script type="text/javascript">
		$(document).ready( function () {
	    $('#myTable').DataTable();
	} );
	</script>

	<script type="text/javascript">
		document.addEventListener('click', function(e) {
			var btn = e.target.closest ? e.target.closest('.deleteSliderBtn') : null;
			if (!btn) return;
			e.preventDefault();
			var id = btn.getAttribute('data-id');
			Swal.fire({
				title: 'Are you sure?',
				text: 'This will permanently delete the slider image!',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: 'Yes, delete it!'
			}).then(function (result) {
				if (result.isConfirmed) {
					window.location.href = 'vertical_slider_manager.php?delete_img_slider=' + id;
				}
			});
		});
	</script>

	<div class="row">
		<?php
			if (!empty(@$msg)) {
				$sweetType = (@$sts == 'success') ? 'success' : 'error';
		?>
		<script>
			Swal.fire({
				icon: '<?= $sweetType ?>',
				title: '<?= ($sweetType == 'success') ? 'Success!' : 'Error!' ?>',
				text: '<?= addslashes(@$msg) ?>',
				confirmButtonColor: '#3085d6'
			});
		</script>
		<?php } ?>
		<?php
			if (@$_GET['i']) {
				$slider_img_id = $_GET['i'];
				$selectProduct = "SELECT * FROM slider_img WHERE slider_img_id = '$slider_img_id' AND slider_img_type = 'vertical' ";
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
				<div class="card-header card-bg" align="center"><em>Add Vertical Slider Image</em></div>
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
					   		<select class="form-control select2" name="slider_img_sts">
					   			
					   			<option value="1" <?=@$slider_img_sts=="1"?"selected":""?>>Available</option>
					   			<option value="2" <?=@$slider_img_sts=="2"?"selected":""?>>Not Available</option>
					   		</select>
					  </div>
					<?php
						if (isset($_GET['i'])) {
							?>
							<input type="submit" name="editimg" class="btn btn-info" value="Edit Vertical Slider Img">
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
				<div class="card-header card-bg" align="center"><em>Show Vertical Slider Images</em></div>
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
			<?php $q=mysqli_query($dbc,"SELECT * FROM slider_img WHERE slider_img_type = 'vertical'  ORDER BY slider_img_id DESC LIMIT 50 ");
			while($r=mysqli_fetch_assoc($q)):
				//$customer_id = $r['customer_id'];
			 ?>
			<tr>
				<td><?=$r['slider_img_id']?></td>
				<td class="text-capitalize"><img src="img/slider/<?=$r['slider_img']?>" width="100%" height="100" alt=""></td>

				<td><?=$r['slider_img_heading']?></td>
				<td style="font-size: 5px;"><?=$r['slider_img_desc']?></td>
				<td><?=$r['slider_img_sts']?></td>
				<td><a href="vertical_slider_manager.php?i=<?=$r['slider_img_id'];?>"> <button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span>Edit</button></a></td>
				<td><a href="javascript:void(0);" class="deleteSliderBtn" data-id="<?=$r['slider_img_id'];?>"> <button class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span>DELETE</button></a></td>
				
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

	?>
