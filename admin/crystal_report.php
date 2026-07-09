<?php 
include_once 'php_action/db_connect.php';
include_once 'inc/functions.php';
// if($dbc){
// 	echo "connected";
// }else{
// 	echo mysqli_error($query);
// }
$v_id=$_GET['v_id'];
$q=mysqli_query($dbc,"SELECT * FROM vehicle_info WHERE vehicle_id=$v_id ;");
$f=mysqli_fetch_assoc($q);
$makers=fetchRecord($dbc,"maker","maker_id",$f['vehicle_maker']);
$brands=fetchRecord($dbc,"brands","brand_id",$f['vehicle_brand']);
$type=fetchRecord($dbc,"body_type","body_type_id",$f['vehicle_type']);

 ?>

<html>
<head>
	<title></title>
	<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  font-size: 12px;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
tr:nth-child(even) {
  background-color: #dddddd;
}
th,td{
  text-transform:capitalize;;
}
</style>
</head>
<body>
<h3>Vehicle Info</h3>
<table>
  <tr>
    <th>Index</th>
    <th>Detail</th>
    <th>Index</th>
    <th>Detail</th>
    <th>Index</th>
    <th>Detail</th>
    <th>Index</th>
    <th>Detail</th>
  </tr>
  <tr>
    <td>Vehicle ID</td>
    <td><?=$f['vehicle_id']?></td>
     <td>stock ID</td>
    <td><?=$f['vehicle_stock_id']?></td>

    <td>type</td>
    <td><?=@$type['body_type_name']?></td>
  
     <td>engine no</td>
    <td><?=$f['vehicle_engine_no']?></td>
    </tr>
   
  <tr>
      <td>Manu. year</td>
    <td><?=$f['vehicle_manu_year']?></td>
      <td>reg year</td>
    <td><?=$f['vehicle_reg_year']?></td>
   
      <td>Reg month</td>
    <td><?=$f['vehicle_reg_month']?></td>
    <td>Manu. month</td>
    <td><?=$f['vehicle_manu_month']?></td>
  </tr>
   <tr>
     <td>maker</td>
    <td><?=$makers['maker_name']?></td>
    <td>brand</td>
    <td><?=$brands['brand_name']?></td>
    <td>chassis no</td>
    <td style="text-transform: uppercase;"><?=$f['vehicle_chassis_no']?></td>
     <td>chassis code</td>
     <?php
     $getchasis = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM models WHERE model_id = '$f[vehicle_chassis_code]'"));
     ?>
    <td><?=$getchasis['model_name']?></td>
  </tr>
  <tr>
      <td>transmission</td>
    <td><?=$f['vehicle_transmission']?></td>
    <td>exterior grade</td>
    <td><?=$f['vehicle_exterior']?></td>
      <td>interior grade</td>
    <td><?=$f['vehicle_interior']?></td>
      <td>package</td>
    <td><?=$f['vehicle_package']?></td>
  </tr>
  <tr>
    <td>access</td>
    <td style="text-transform: uppercase;"><?=$f['vehicle_access']?></td>
        <td>door</td>
    <td><?=$f['vehicle_door']?></td>

          <td>color name</td>
    <td><?=$f['vehicle_color_name']?></td>
    <td>option</td>
    <td><?=$f['vehicle_option']?></td>
  </tr>
  <tr>
    <td>mode</td>
    <td><?=$f['vehicle_mode']?></td>
   <td>seat</td>
    <td><?=$f['vehicle_seat']?></td>

  <td>color</td>
    <td style="text-transform: uppercase;"><?=$f['vehicle_color']?></td>
        <td>interior color</td>
    <td><?=$f['vehicle_interior_color']?></td>
  </tr>
  <tr>
     <td>length</td>
    <td><?=$f['vehicle_length']?></td>
    <td>width</td>
    <td><?=$f['vehicle_width']?></td>
    <td>height</td>
    <td><?=$f['vehicle_height']?></td>
        <td>weight</td>
    <td><?=$f['vehicle_weight']?></td>

  </tr>
  <tr>
    <td>grade</td>
    <td style="text-transform: uppercase;"><?=$f['vehicle_grade']?></td>
     <td>loading caacity</td>
    <td><?=$f['vehicle_loading_capacity']?></td>
    <td>M3</td>
    <td><?=$f['vehicle_m3']?></td>

     <td>KM</td>
    <td><?=$f['vehicle_km']?></td>
  </tr>
  <tr>
    <td>Estimated price</td>
    <td>$<?=$f['vehicle_est_price']?></td>
       <td>discount</td>
    <td><?=$f['vehicle_discount']?>%</td>
     <td>note</td>
    <td><?=$f['vehicle_note']?></td>
     <td>KM2</td>
    <td><?=$f['vehicle_km2']?></td>
  </tr>
  <!-- --------------- -->
    <tr>
    <td>CC</td>
    <td><?=$f['vehicle_cc']?></td>
    <td>drive</td>
    <td><?=$f['vehicle_drive']?></td>
    <td>Engine type</td>
    <td><?=$f['vehicle_engine_type']?></td>
    <td>fuel</td>
    <td><?=$f['vehicle_fuel']?></td>
   </tr><!--  -->
   <!--  -->
   <tr>
    <td>Auction House</td>
    <td><?=$f['vehicle_auctionhouse']?></td>
    <td>Buying Date </td>
    <td><?=$f['buying_date']?></td>
    <td>Buying Price</td>
    <td><?=$f['buying_price']?></td>
    <td>Lot Number</td>
    <td><?=$f['lot_number']?></td>
   </tr>
   <!--  -->
    <tr>
    <td>Vehicle features</td>
     <td colspan="7">
       <?php 
       if (!empty($f['vehicle_feature_list'])) {
         # code...
       
        foreach (json_decode($f['vehicle_feature_list']) as  $value){
          echo $value.",";
          }
          }
          ?> 
     </td>

   </tr>
    
 
</table>


</body>
</html>