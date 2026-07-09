<?php 	
require_once '../php_action/db_connect.php';
require_once '../inc/functions.php';


//print_r($_REQUEST);
if (isset($_POST['inquiryvehicle'])) {
		$data = [
			'vehicle_id' => $_POST['inquiryvehicle'],
			'customer_id' => $_POST['customer_id'],
			'sold_rate' => $_POST['sold_rate'],
			'currency_id' => $_POST['currency_id'],
		];
		if ($_POST['inquiry_id'] == "") {
			if (insert_data($dbc,"inquiry", $data)) {
				$response=['msg'=>"Inquiry Added Successfully",
							'sts'=>'success',
						];

			}else{
				$response=['msg'=>mysqli_error($dbc),
							'sts'=>'success',
			];

			}
		}else{
			if (update_data($dbc,"inquiry",$data,"inquiry_id",$_POST['inquiry_id'])) {
				$response=['msg'=>"Inquiry Updated Successfully",
							'sts'=>'success',
						];

			}else{
				$response=['msg'=>mysqli_error($dbc),
							'sts'=>'success',
			];

			}
		}
		echo json_encode($response);
	}

	if (isset($_POST['part_stock_idp'])) {
		$data = [
			'part_stock_id' => $_POST['part_stock_idp'],
			'part_chassis_no' => $_POST['part_chassis_no'],
			'part_no' => $_POST['part_no'],
			'part_weight' => $_POST['part_weight'],
			'part_km' => $_POST['part_km'],
			'part_manu_year' => $_POST['part_manu_year'],
			'part_year' => $_POST['part_year'],
			'part_maker' => $_POST['part_maker'],
			'part_brand' => $_POST['part_brand'],
			'part_cc' => $_POST['part_cc'],
			'part_transmission' => $_POST['part_transmission'],
			'part_steering' => $_POST['part_steering'],
			'part_fuel' => $_POST['part_fuel'],
			'part_package' => $_POST['part_package'],
			'part_color' => strtoupper($_POST['part_color']),
			'part_note' => $_POST['part_note'],
			'part_condition_remarks' => $_POST['part_condition_remarks'],
			'part_fob_price' => $_POST['part_fob_price'],
		];
		if ($_POST['part_id'] == "") {
			if (insert_data($dbc, "vehicle_parts", $data)) {

				$response=['msg'=>"Part Added Successfully",
							'sts'=>'success',
						];
				
			}else{
				$response=['msg'=>mysqli_error($dbc),
							'sts'=>'success'];			}
		}else{
			if (update_data($dbc, "vehicle_parts", $data, "part_id ", $_POST['part_id'])) {
$response=['msg'=>"Part Updated Successfully",
							'sts'=>'success',
						];

			}else{
				$response=['msg'=>mysqli_error($dbc),
							'sts'=>'success',
							];
			}

		}
		echo json_encode($response);

	}
if (isset($_POST['machine_stock_idp'])) {
		$data = [
			'machine_stock_id' => $_POST['machine_stock_idp'],
			'machine_type' => $_POST['machine_type'],
			'part_no' => $_POST['part_no'],
			'machine_weight' => $_POST['machine_weight'],
			'machine_manu_year' => $_POST['machine_manu_year'],
			'machine_year' => $_POST['machine_year'],
			'machine_maker' => $_POST['machine_maker'],
			'machine_brand' => $_POST['machine_brand'],
			'machine_hours' => $_POST['machine_hours'],
			'machine_l' => $_POST['machine_l'],
			'machine_w' => $_POST['machine_w'],
			'machine_h' => $_POST['machine_h'],
			'machine_steering' => $_POST['machine_steering'],
			'machine_fuel' => $_POST['machine_fuel'],
			'machine_serial_no' => $_POST['machine_serial_no'],
			'machine_color' => strtoupper($_POST['machine_color']),
			'machine_note' => $_POST['machine_note'],
			'machine_condition_remarks' => $_POST['machine_condition_remarks'],
			'machine_fob_price' => $_POST['machine_fob_price'],
			'machine_drive' => $_POST['machine_drive'],
			'machine_transmission' => $_POST['machine_transmission'],
			'machine_condition' => $_POST['machine_condition'],

		];
		if ($_POST['machine_id'] == "") {
			if (insert_data($dbc, "machines", $data)) {

				$response=['msg'=>"Machine Added Successfully",
							'sts'=>'success',
						];
				
			}else{
				$response=['msg'=>mysqli_error($dbc),
							'sts'=>'success'];			}
		}else{
			if (update_data($dbc, "machines", $data, "machine_id ", $_POST['machine_id'])) {
$response=['msg'=>"Machine Updated Successfully",
							'sts'=>'success',
						];

			}else{
				$response=['msg'=>mysqli_error($dbc),
							'sts'=>'success',
							];
			}

		}
		echo json_encode($response);

	}
if (isset($_POST['inquiry_fullName'])) {
	$inquiry_services='';
		if (isset($_POST['inquiry_services'])) {
				$inquiry_services=json_encode($_POST['inquiry_services']);
		}
		$data = [
			'inquiry_name' => $_POST['inquiry_fullName'],
			'vehicle_id' => base64_decode($_POST['vehicle_id']),
			'inquiry_email' => $_POST['inquiry_email'],
			'inquiry_phone' => $_POST['inquiry_phoneNumber'],
			'inquiry_msg' => $_POST['inquiry_msg'],
			'inquiry_country' => $_POST['inquiry_country'],
			'inquiry_port' => $_POST['inquiry_destPort'],
			'inquiry_of' => $_POST['inquiry_of'],
			'inquiry_sts' => 1,
			'inquiry_services' => $inquiry_services,
		];
			if (insert_data($dbc, "pending_inquiry", $data)) {

				$response=['msg'=>"Inquiry has been submited Successfully",
							'sts'=>'success',
						];
				
			}else{
				$response=['msg'=>mysqli_error($dbc),
							'sts'=>'success'];		
					}
		
		echo json_encode($response);

	}	

 ?>