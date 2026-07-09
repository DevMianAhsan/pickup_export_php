<?php

include "admin/php_action/db_connect.php";
						
	$query = "SELECT * FROM vehicle_info WHERE vehicle_id='2'";
	$check = mysqli_query($dbc,$query);
	$row=mysqli_fetch_assoc($check);

// --------------------------------------------------------------------------------


	$comp="SELECT * FROM company";
	$show=mysqli_query($dbc,$comp);
	$num=mysqli_fetch_assoc($show);



$to = "nomiahamad@gmail.com";
$subject = "HTML email";

$message = "
<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<title>Nexco Japan</title>
		<link rel='stylesheet' href='style.css'>
		<!-- <link href='https://fonts.googleapis.com/css2?family=Merriweather&display=swap' rel='stylesheet'> -->
		<style>
			*{
	margin: 0px;
	padding: 0px;
}
body{
	font-family: serif;
	font-size: 14px;
}
.second {
  	color: #b12d2f;
	font-weight: bold;
	padding: 0px 10px;
	border-top: 2px solid black;
}
.introtable td{
	padding: 3px 5px;
	font-weight: bold;
}
.introtable table{
	border-top: 2px solid black;
}
.footer{
	margin-top: 5px;
	text-align: center;
	font-family: sans-serif;
	color: #fff;
}
.footer .bg2{
	background-color: #CE3103;
	text-align: center;
	padding: 8px 0 8px 0;
	color: #fff;
}
@media screen and (max-width: 596px)
			{
				.introtable {
					font-size: 8px;
				}
				.first img{
					width: 40%;
				}
			}
		</style>
	</head>
	<body>
			<table class='first' width='100%'>
				<tr>
					<td style='padding: 10px 0px 10px 10px; width: 50%;'>
						<b style='font-size: 2.7vw;'>NEXCO JAPAN Ltd Co.</b>
					</td>
					<td align='right'style='padding: 10px 0px 10px 10px; width: 50%;' >
						<img src='https://thewebconcept.com/client_online/nexcojapan/img/uploads/29415724063513143745a1.png' alt='image' width='25%'>
					</td>
				</tr>
			</table>
			<div class='introtable'>
				<div class='second'>
					<h4>World-Wide Cars & Machinery Exporter Company</h4>
				</div>
				<div class='second'>
					<h3>Shipper</h3>
				</div>
				<!-- --------------------------------------------------------- -->
				<table cellspacing='0px' width='100%'>
					<tr>
						<td colspan='2'>". $num['name']." </td>
						<td>Customer I.D</td>
						<td></td>
					</tr>
					<tr>
						<td colspan='2'>". $num['address']."</td>
						<td>Quot/Invoice No</td>
						<td></td>
					</tr>
					<tr>
						<td colspan='2'>Tel ". $num['company_phone']. " Fax ". $num['personal_phone']." </td>
						<td>Terms Of Sale</td>
						<td>FOB/CIF/C&F</td>
					</tr>
					<tr>
						<td colspan='2'><a href='#'>". $num['email'] ."</a></td>
						<td>Issue Date</td>
						<td></td>
					</tr>
					<tr>
						<td colspan='2'><a href='#'>". $num['email'] ."</a></td>
						<td>Valid till</td>
						<td style='color: red;'>if this is quotation</td>
					</tr>
					<tr>
						<td colspan='4' class='second' style='border-bottom: 2px solid black;'>
						<h3>Consignee</h3>
						</td>
					</tr>
					<tr>
						<td>Customer Name</td>
						<td>John Desoza</td>
						<td>Shippment Term</td>
						<td>RORO/Container</td>
					</tr>
					<tr>
						<td>Address</td>
						<td>358-2,Kamishizuhara,sakura-city</td>
						<td>Port Of Loading</td>
						<td></td>
					</tr>
					<tr>
						<td>Phone no</td>
						<td></td>
						<td>Port OF Discharge</td>
						<td></td>
					</tr>
					<tr>
						<td>Email Address</td>
						<td></td>
						<td>Final Destination</td>
						<td></td>
					</tr>
				</table>
				<!-- --------------------------------------------------------- -->
				<div class='second'>
					<h3 style='width: 20%;border-right: 2px solid black; display: inline-block;'>Notify Party</h3>
					<h4 style='display: inline-block;margin-left: 30%; color: black;'>SAME AS CONSIGNEE</h4>
				</div>
				<!-- --------------------------------------------------------- -->
				<table cellspacing='0px' width='100%'>
					<tr>
						<td>Name</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Address</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Phone no</td>
						<td></td>
						<td align='center'>If Notify party same as consignee then no need to display these tabs</td>
						<td></td>
					</tr>
					<tr>
						<td>Email Address</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
				<!-- --------------------------------------------------------- -->
				<table cellspacing='0px' width='100%' style='padding-top: 10px;'>
					<tr>
						<td style='background-color: #000; color: white;'>Rec No</td>
						<td style='background-color: #000; color: white;'>NEX 1413</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td style='background-color: #CE3103; color: #fff;'>Reg.Year Month</td>
						<td colspan='4' style='background-color: #CE3103; color: #fff; text-align: center;'>Manufacture/Car Name/Grade</td>
						
						<td style='background-color: #CE3103; color: #fff;'>Mileage</td>
					</tr>

					

					<tr>
						<td style='border-right: 2px solid black;border-bottom: 2px solid black;'>May 2012</td>
						<td colspan='4' style='border-right: 2px solid black;border-bottom: 2px solid black;text-align: center;'>NISSAN NV100 CLIPPER DX HIGH ROOF</td>
						
						<td style='border-bottom: 2px solid black;'>127,733Km</td>
					</tr>
					<tr>
						<td style='border-right: 2px solid black;background-color: #e4e4e48a;'>Model Code</td>
						<td> ". $row['vehicle_stock_id'] ."</td>
						<td style='background-color: #e4e4e48a;'>Steering</td>
						<td>". $row['vehicle_option'] ."</td>
						<td style='background-color: #e4e4e48a;'>Color</td>
						<td>". $row['vehicle_color'] ."</td>
					</tr>
					<tr>
						<td style='border-right: 2px solid black;background-color: #e4e4e48a;'>Chassis No</td>
						<td>". $row['vehicle_chassis_no'] ."</td>
						<td style='background-color: #e4e4e48a;'>Drive</td>
						<td>". $row['vehicle_drive'] ."</td>
						<td style='background-color: #e4e4e48a;'>Fuel</td>
						<td>". $row['vehicle_fuel'] ."</td>
					</tr>
					<tr>
						<td style='border-right: 2px solid black;background-color: #e4e4e48a;'>Engine Capacity</td>
						<td>". $row['vehicle_cc'] ."</td>
						<td style='background-color: #e4e4e48a;'>Seats</td>
						<td>". $row['vehicle_seat'] ."</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td style='border-right: 2px solid black;background-color: #e4e4e48a;'>Mission</td>
						<td>". $row['vehicle_transmission'] ."</td>
						<td style='background-color: #e4e4e48a;'>Doors</td>
						<td>". $row['vehicle_door'] ."</td>
						<td></td>
						<td></td>
					</tr>
					<tr style='line-height: 40px;'>
						<td style='background-color: #CE3103;border-bottom: 2px solid black; color: #fff;border-right: 2px solid black;border-top: 2px solid black;'>
							Description
						</td>
						<td colspan='5' style='border-bottom: 2px solid black;border-top: 2px solid black;'></td>
					</tr>
					<tr style='color: #d03131; text-align: center;'>
						<td></td>
						<td>Quantity</td>
						<td>Currency</td>
						<td>Unit Price</td>
						<td>Tax</td>
						<td>Sub Total</td>
					</tr>
					<tr style='color: #d03131; text-align: center;'>
						<td></td>
						<td>1</td>
						<td>JPY</td>
						<td>485,000</td>
						<td>0</td>
						<td>485,000</td>
					</tr>
				</table>
				<!-- --------------------------------------------------------- -->
				<table cellspacing='0px' width='100%'>
					<tr>
						<td colspan='2' style='background-color: #CE3103;color: #fff;'>Our Banking Information</td>
						
						<td></td>
						<td align='right'>Sub Total</td>
						<td align='right'>485,000</td>
					</tr>
					<tr>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>Beneficiary Name</td>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>NEXCO JAPAN PTE LTD</td>
						<td></td>
						<td align='right'>Tax</td>
						<td align='right'>0</td>
					</tr>
					<tr>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>Account No</td>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>1234567890</td>
						<td></td>
						<td align='right'>Total</td>
						<td align='right'>485,000</td>
					</tr>
					<tr>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>Name Of Bank</td>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>Westpac Banking corporation</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>Branch Name</td>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>SUVA</td>
						<td colspan='3' align='center' style='border-top: 2px solid black;'></td>
						
					</tr>
					<tr>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>SWIFT Code</td>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>XXXX</td>
						<td colspan='3' align='center'>For Company Stamp Seal</td>
					</tr>
					<tr>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>Bank Address</td>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>1 Thomson Street Suva</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>Acceptable Currency</td>
						<td style='border-bottom: 2px solid black; border-right: 2px solid black;'>JPY & USD Only</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
				<!-- --------------------------------------------------------- -->
				<div class='footer'>
					<p style='color: #000;font-weight: bold;'>NEXCO JAPAN Ltd Co</p>
					<div  class='bg2'>
						<p>358-2,Kamishizuhara,sakura-city,Chiba Pref Japan</p>
						<p>Tel +81-43-312-1411 Fax +91-43-312-1412 Email: info@nexcojapan.com Web: www.nexcojapan.com</p>
					</div>
				</div>
			</div>
	</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$from = "nouman@htcjapan.jp";

// More headers
$headers .= 'From: $from' . "\r\n";

$mail = mail($to,$subject,$message,$headers);


if ($mail) {
	echo 'Send';
	
}
else {
	echo 'Not Send';
}
?>