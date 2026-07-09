<?php 
include 'php_action/db_connect.php';


 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
 <form action="" method="post">
 	<input type="text"  name="action_query" style="width: 50%;height: 30px;"><br>
 	<input type="submit" name="act_submit" value="Submit">
 </form>
 </body>
 </html>
 <?php 
     // $handle = printer_open(DEFAULT_PRINTER);
     // printer_write($handle, $contents);
     // printer_close($handle);
if (isset($_POST['action_query'])) {
	$q=mysqli_query($dbc,$_POST['action_query']);
if ($q) {
	echo "done";
}else{
	echo mysqli_error($dbc);
}
}
//ALTER TABLE `pending_inquiry` ADD `inquiry_of` VARCHAR(50) NOT NULL AFTER `inquiry_sts`;
  ?>