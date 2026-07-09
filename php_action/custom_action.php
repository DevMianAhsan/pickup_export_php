<?php 
// print_r($_REQUEST);
	// namespace Dompdf;
	// reference the Dompdf namespace
	use Dompdf\Dompdf;
	include_once '../admin/php_action/db_connect.php';
	include_once '../admin/inc/functions.php';
	//Fetch Fee
	if (isset($_POST['countryFee'])) {
		$id = $_POST['countryFee'];
		$q = mysqli_query($dbc,"SELECT * FROM country_regulation WHERE country_regulation_country = '$id'");
		if (mysqli_num_rows($q) < 1) {
			$q = mysqli_query($dbc,"SELECT * FROM country_regulation WHERE country_regulation_id = '$id'");
		}
		$response = array();
		while($r = mysqli_fetch_assoc($q)){
			$response[] = $r;
		}
		echo json_encode($response);	
		exit();
	}
?>
<?php 	
		include_once '../vendor/dompdf/dompdf/src/autoloader.php';
		include_once '../vendor/dompdf/dompdf/src/options.php';
		include_once '../vendor/autoload.php';

	if (isset($_POST['create_pdf'])) {
		$id = $_POST['vehicle_id'];

		//Vehicle Main Info
		$vehicle_main = fetchRecord($dbc,"vehicle_info", "vehicle_id", $id);

		$vehicle_img = mysqli_query($dbc,"SELECT * FROM vehicle_img WHERE vehicle_id = '$vehicle_main[vehicle_id]'");
		$p = 1;
			while ($img= mysqli_fetch_assoc($vehicle_img)) {

				$img.$p = $img['vehicle_img_name'];
				$p++;
				# code...
			}

		//Company
		$company = fetchRecord($dbc, "company", "id", 5);
		
		$html1 = '
			<div style="width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto">
				<div style="border-top: 2px solid black;margin-top: 10px;padding-top: 10px;border-bottom: 2px solid black; padding-bottom: 10px;">	
					<img src="../admin/img/logov.png" style="width:30%; height: 50px; margin-top: 5px">
				</div>
				<br>
				<strong>Ref : 0873958 <span style="font-size: 16px">'.fetchRecord($dbc,"maker", "maker_id", $vehicle_main['vehicle_maker'])['maker_name']." ".fetchRecord($dbc,"brands","brand_id",$vehicle_main['vehicle_brand'])['brand_name']." ".$vehicle_main['vehicle_reg_month'].'</span></strong>
				<div style="margin-top: 10px;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;">
					<div style="border-right: 3px solid; position:relative;width:100%;padding-right:15px;padding-left:15px; -ms-flex:0 0 66.666667%;flex:0 0 66.666667%;max-width:66.666667%;">
						<h5 style="border-bottom: 2px solid black">Vehicle Info</h5>
						<table style="width:100%;margin-bottom:1rem;color:#212529;border-collapse:collapse!important; padding:.3rem;border:2px solid black;">
						<tbody>
							<tr>
								<td style="background-color:#6c757d!important;"><strong>Chassis</strong></td>
								<td>'.$vehicle_main['vehicle_chassis_code'].'</td>
								<td style="background-color:#6c757d!important;"><strong>Chassis No</strong></td>
								<td>'.$vehicle_main['vehicle_chassis_no'].'</td>
								<td style="background-color:#5c757d!important;"><strong>Mileage</strong></td>
								<td>'.$vehicle_main['vehicle_package'].'</td>
							</tr>
							<tr>
								<td style="background-color:#6c757d!important;"><strong>Reg. Year</strong></td>
								<td>'.$vehicle_main['vehicle_reg_month'].'</td>
								<td style="background-color:#6c757d!important;"><strong>Trans</strong></td>
								<td>'.$vehicle_main['vehicle_transmission'].'</td>
								<td style="background-color:#6c757d!important;"><strong>Fuel</strong></td>
								<td>'.$vehicle_main['vehicle_fuel'].'</td>
							</tr>
							<tr>
								<td style="background-color:#6c757d!important;"><strong>Seat</strong></td>
								<td>'.$vehicle_main['vehicle_seat'].'</td>
								<td style="background-color:#6c757d!important;"><strong>Drivetrain</strong></td>
								<td>'.$vehicle_main['vehicle_drive'].'</td>
								<td style="background-color:#6c757d!important;"><strong>Engine Size</strong></td>
								<td>'.$vehicle_main['vehicle_engine_type'].'</td>
							</tr>
							<tr>
								<td style="background-color:#6c757d!important;"><strong>Seats</strong></td>
								<td>'.$vehicle_main['vehicle_seat'].'</td>
								<td style="background-color:#6c757d!important;"><strong>Doors</strong></td>
								<td>'.$vehicle_main['vehicle_door'].'</td>
								<td style="background-color:#6c757d!important;"><strong>Engine Type</strong></td>
								<td>'.$vehicle_main['vehicle_engine_type'].'</td>
							</tr>
							<tr>
								<td style="background-color:#6c757d!important;"><strong>Colour</strong></td>
								<td>'.$vehicle_main['vehicle_color_name'].'</td>
								<td style="background-color:#6c757d!important;"><strong>Steering</strong></td>
								<td>'.$vehicle_main['vehicle_drive'].'</td>
								<td style="background-color:#6c757d!important;"><strong>Location</strong></td>
								<td>'.$vehicle_main['vehicle_id'].'</td>
							</tr>
						</tbody>
					</table>
					<br>
					<div style="display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px">
						<div style="-ms-flex:0 0 58.333333%;flex:0 0 58.333333%;max-width:58.333333%; padding-right: -130px;">
							<img src="../admin/img/vehicles_images/'.$img1.'" style="width: 75%; height: 150px; margin-bottom: 20px;"><br>
							<img src="../admin/img/vehicles_images/'.$img2.'" style="width: 75%; height: 150px; margin-bottom: 20px;"><br>
							<img src="../admin/img/vehicles_images/'.$img3.'" style="width: 75%; height: 150px; margin-bottom: 20px;"><br>
						</div>
						<div style="-ms-flex:0 0 41.666667%;flex:0 0 41.666667%;max-width:41.666667%; margin-left:270px;">
						<h5 style="border-bottom: 2px solid black; margin-top:-30px;">Options</h5>
						<table style="width:220px;margin-bottom:1rem;color:#212529;border-collapse:collapse!important; padding:.3rem;border:2px solid black;">
							<tbody>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>abc</td>
								</tr>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>Air Bag</td>
								</tr>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>Air Conditioning</td>
								</tr>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>Alloy Wheels</td>
								</tr>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>Antilock Braking System</td>
								</tr>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>Back Camera</td>
								</tr>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>Cassette Stereo</td>
								</tr>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>CD Changer</td>
								</tr>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>CD Player</td>
								</tr>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>Central Locking</td>
								</tr>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>Fog Lights</td>
								</tr>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>HID Xenon Light</td>
								</tr>
								<tr>
									<td style="background-color: lightgray">x</td>
									<td>Keyless Entry</td>
								</tr>
							</tbody>
						</table>
						<h5 style="border-bottom: 2px solid black;">Inspector Note</h5>
						Cubic meter : 15.3 m<sup>3</sup> <br>
						Length : 4.57 m <br>
						Width : 1.67 m <br>
						Height : 2 m <br>
						</div>
					</div>
					</div>
					<div style="-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%; margin-left:510px;width:200px; margin-top: -1980px">
					<h5 style="border-bottom: 2px solid black; background-color: black; color: white; padding-left: 5px; padding: 5px">Car Price</h5>
					<strong style="font-size: 20px; float:right!important">US $11,690</strong>	
					<h5 style="border-bottom: 2px solid black; margin-top: 50px; background-color: black; color: white; padding-left: 5px; padding: 5px">Car Price</h5>
					<strong style="font-size: 20px; float:right!important">US $11,690</strong>	
					<h4 style="border-bottom: 2px solid black; margin-top: 30px;"><strong>Destination Port</strong></h4>
					<strong>Country</strong> : Pakistan <br>
					<strong>Port</strong> : Karachi
					<br>
					<div>
						<h4 style="border-bottom: 2px solid black; margin-top: 30px;"><strong>Summary</strong></h4>
					</div>
					Car Price (FOB) <span>$11,690</span><br>
					Shipping Cost <span>$2,670</span><br>
					Warranty <span>$100</span><br>
					<hr style="border-bottom: 2px solid;">
					<h5><strong>Total Price</strong> <span>(CIF)US$14,460</span></h5> 
				</div>
			</div>
			<hr style="border: 2px solid; margin-top:320px">
				</div>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				<br><br><br><br><br><br>
				<div style="text-align:center!important;margin-top:25px; margin-right: 120px">
					<strong>
					Email: pboffer@picknbuy24.com <br>
					Tel: +81-3-4330-9090 Fax: +81-3-4330-9091 <br>
					Copyright © 2006 PicknBuy24.com. All rights reserved.
					</strong>
				</div>
			</div>';	

		if (!empty($_POST['invoice_pdf']) == '') {	
			$dompdf = new DOMPDF();
			ob_clean();
			$dompdf->loadHtml(html_entity_decode($html1));
			$dompdf->setPaper('A4', 'Portrait');
			$dompdf->render();
			$dompdf->stream("invoice_form.pdf");
		}else{
			$id = $_POST['vehicle_id'];

			//Vehicle Main Info
			$vehicle_main = fetchRecord($dbc,"vehicle_info", "vehicle_id", $id);

			//Company
			$company = fetchRecord($dbc, "company", "id", 5);

			//Invoice Add With Status Quotation
			$data = [
				'customer_name' => $_POST['customer_name'],
				'customer_email' => $_POST['customer_email'],
				'customer_password' => $_POST['customer_password'],
				'customer_phone' => $_POST['phone'],
			];

			if (insert_data($dbc,"customers", $data)) {
				$customer_id = mysqli_insert_id($dbc);
				$data = [ 
					'invoice_customer' => $customer_id,
					'invoice_vehicle' => $id,
					'invoice_sts' => '2',
					'invoice_quotation' => "quotation",
				];
				if (insert_data($dbc, "invoice", $data)) {//Invoice Insert
					echo 'Customer Added Successfully';
					$invoice_id = $_SESSION['invoice_id'] = mysqli_insert_id($dbc);	

		$html ='<div style="width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;">
			<div style="border-top: 2px solid black;margin-top: 10px;padding-top: 10px;border-bottom: 2px solid black; padding-bottom: 20px;">	
			<img src="../admin/img/logov.png" style="width:30%; height: 50px; margin-top: 5px">
			<small style="float:right!important"><strong>
				'.$company['name'].'<br>
				'.$company['address'].' <br>
				TEL: '.$company['company_phone'].' FAX: '.$company['personal_phone'].' <br>
				Email: '.$company['email'].' URL: '.$company['email'].'</strong>
			</small>
			</div>
			<div style="display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;">
				<div style="position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 41.666667%;flex:41.666667%;max-width:41.666667%">
					<h2>PROFORMA INVOICE</h2>
					This INVOICE is concluded between a "Consignee" (as "User" in PicknBuy24.com Terms of Use) and a "Seller".
				</div><!-- col -->
				<div style="border: 3px solid black; margin-top: 15px; margin-left: 350px; position:relative;width:100%;padding-right:15px;padding-left:15px; -ms-flex:0 0 50%;flex:0 0 50%;max-width:50%;">
					<div style="display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;height:150px">
						<div style="-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%; position:relative;width:100%;padding-right:15px;padding-left:15px">
							<br><br>
							<b>Invoice No :</b> <br><br><br>
							<b>Invoice Date :</b> <br>		
						<strong>Valid For 3 Days</strong>
						</div>
						<div style="-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%; position:relative;width:100%;padding-right:15px;padding-left:200px">
							 <strong><h1>'.$invoice_id.'</h1></strong>
							 <h3>'.fetchRecord($dbc,"invoice", "invoice_id", $invoice_id)['invoice_time'].'</h3>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div style="margin-top: -120px">		
				<div style="background-color: black; color: white; padding: 2px;padding-left: 5px;">
					<strong>Consignee Details</strong>
				</div>
				<span>
					Mr./Mrs '.$_POST['customer_name'].' <br>
					Tel: '.$_POST['phone'].' <strong>Email</strong> '.$_POST['customer_email'].'
				</span>
			</div>
			<div style="padding-top:-50px">
				<div style="background-color: black; color: white; padding: 2px;padding-left: 5px;">
					<strong>Seller</strong>
				</div>
				Mr. Abc Tel: 987654 <strong>Email</strong> sdgf@dhfgj.com
			</div>
			
			<div style="background-color: black; color: white; padding: 2px;padding-left: 5px;">
				<strong>ORDER DETAILS For the supply of one unit of used motor vehicle</strong>
			</div>
			Vehicle: <span style="font-size: 15px; padding-left: 40px; font-weight: 2em;">'.fetchRecord($dbc,"maker", "maker_id", $vehicle_main['vehicle_maker'])['maker_name']." ".fetchRecord($dbc,"brands","brand_id",$vehicle_main['vehicle_brand'])['brand_name']." ".$vehicle_main['vehicle_reg_month'].'</span><strong style="float:right!important">Country of Origin: Japan</strong>
			<br><br>
			<div style="display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;">
				<div style="border: 1px solid black;padding: 5px; margin-left: 20px; margin-top: 10px; width: 205px;">
					<strong>Vehicle Ref</strong><span style="float:right!important;padding-left: 20px">0100873958</span> <br>
					<strong>Year</strong><span style="float:right!important;padding-left: 20px">'.$vehicle_info['vehicle_reg_month'].'</span> <br>
					<strong>Seats</strong><span style="float:right!important;padding-left: 20px">'.$vehicle_info['vehicle_seat'].'</span> <br>
					<strong>Fuel</strong><span style="float:right!important;padding-left: 20px">'.$vehicle_info['vehicle_fuel'].'</span> <br>
				</div>
				<div style="border: 1px solid black;padding: 5px; margin-left: 235px; margin-top: 10px; width: 225px">
					<strong>Chassis: </strong><span style="float:right!important;padding-left: 20px">'.$vehicle_info['vehicle_chassis_code'].'</span> <br>
					<strong>Engine Size: </strong><span style="float:right!important;padding-left: 20px">'.$vehicle_info['vehicle_engine_type'].'</span> <br>
					<strong>Colour: </strong><span style="float:right!important;padding-left: 20px">'.$vehicle_info['vehicle_color_name'].'</span> <br>
					<strong>Mileage:</strong><span style="float:right!important;padding-left: 20px">D'.$vehicle_info['vehicle_package'].'IESEL</span> <br>
				</div>
				<div style="border: 1px solid black;padding: 5px; margin-left: 470px; margin-top: 10px; width: 205px">
					<strong>Chassis No: </strong><span style="float:right!important;padding-left: 20px">'.$vehicle_info['vehicle_chassis_no'].'</span> <br>
					<strong>Doors: </strong><span style="float:right!important;padding-left: 20px">'.$vehicle_info['vehicle_door'].'</span> <br>
					<strong>Transmission: </strong><span style="float:right!important;padding-left: 20px">'.$vehicle_info['vehicle_transmission'].'</span> <br>
					<strong>Transmission: </strong><span style="float:right!important;padding-left: 20px">'.$vehicle_info['vehicle_transmission'].'</span> <br>
				</div>
			</div>
			<div style="margin-top:-100px; padding-top: -100px; margin-bottom : -500px; height:20px">
				<div style="display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;">
					<div style="-ms-flex:0 0 50%;flex:0 0 51%;max-width:50%; margin-left: 20px;">
						<strong>Vehicle Value :</strong><br>
						<strong>Freight charge: :</strong><br>
						<strong>Warranty :</strong><br>
					</div>
					<div style="-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%; text-align:right!important; margin-left: 450px;">
						US $ <br>
						US $ <br>
						US $ <br>
					</div>
					<div style="-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%; text-align:right!important; margin-left: 510px">
						<strong>'.$vehicle_main['vehicle_est_price'].'</strong> <br>
						<strong>887</strong> <br>
						<strong>21</strong> <br>					
					</div>
				</div>
				<hr style="border: 3px; border-style: double;margin-top: -110px;">
				<div style="display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px">
					<div style="-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%; margin-left:20px;">
						<h4 style="margin-top:-7px;"><strong>TOTAL PRICE LANDED(CIF) Karachi</strong></h4> 
					</div>
					<div style="margin-right: 50px; -ms-flex:0 0 25%;flex:0 0 25%;max-width:25%; text-align:right!important; margin-left: 440px;">
						<h4 style="margin-top:-7px;">US $ </h4>
					</div>
					<div style="text-align:right!important; -ms-flex:0 0 16.666667%;flex:0 0 16.666667%;max-width:16.666667%; margin-left:560px">
					<h4 style="margin-top:-7px;">15,475</h4>			
					</div>
				</div>
			</div>
			<div style="background-color: black; color: white; padding: 2px;padding-left: 5px;margin-bottom:10px;">
				<strong>PAYMENT TERMS: Payment in full in advance</strong>
			</div>
			<div style="display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px; padding-top:-100px;">
				<div style="border: 2px solid black; padding: 10px;margin-left: 20px; height: 240px; width: 300px;">
					TELEGRAPHIC TRANSFER <br>
					1. Go to the nearest bank <br>
					2. Complete TT application form <br>
					3. Collect TT copy and send to us by E-mail <br>
					****************** IMPORTANT!! ****************** <br>
					<strong>Quote Invoice No. 2007397959 <br>
					and Your Name. </strong><br>
					***************************** <br>
				</div>
				<div style="margin-left: 3px;">
					<div style="border: 3px solid black; height: 100px; width: 310px;margin-left:350px; padding:10px;">
						<strong>BENEFICIARY INFORMATION</strong> <br>
						<strong>Name</strong> : AGASTA CO., LTD. <br>
						<strong>Address</strong> : SHIN KIOICHO BLDG. 2F, 4-1 KIOI-CHO, CHIYODA-KU,
						TOKYO, JAPAN <br>
						<strong>Account No.</strong> : 215359 <br>
					</div>
					<div style="border: 3px solid black; height: 100px; width: 310px;margin-left:350px; padding:10px; margin-top: 10px;">
						<strong>BENEFICIARY INFORMATION</strong> <br>
						<strong>Name</strong> : AGASTA CO., LTD. <br>
						<strong>Address</strong> : SHIN KIOICHO BLDG. 2F, 4-1 KIOI-CHO, CHIYODA-KU,
						TOKYO, JAPAN <br>
						<strong>Account No.</strong> : 215359 <br>
					</div>
				</div>
				<div style="margin-top: -100px;">
					<small>
					</small><br>
					<small>
					</small>
				</div>
			</div>
			</div>';
				// <strong>**Please follow AGASTA sales staffs instruction if you wish to pay by other currencies than US dollar.</strong>
				// <strong>**All the payment for this vehicle must be made only into AGASTAs bank account as above.</strong>
					$dompdf = new DOMPDF();
					ob_clean();
					$dompdf->loadHtml(html_entity_decode($html));
					$dompdf->setPaper('A4', 'Portrait');
					$dompdf->render();
					$dompdf->stream("quotation_pdf.pdf");
				}else{
					echo mysqli_error($dbc);
				}
			}else{
				echo mysqli_error($dbc);
			}
		}
	}	


	if (isset($_POST['vehicle_brand1']) && isset($_POST['vehicle_brand1']) != "") {



	$id = $_POST['vehicle_brand1'];



	$q = mysqli_query($dbc,"SELECT * FROM models WHERE brand_id = $id");



	$response = array();



	while($r = mysqli_fetch_assoc($q)){



		$response[] = $r;



	}



	echo json_encode($response);	



	exit();



}
?>