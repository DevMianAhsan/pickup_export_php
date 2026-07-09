<head>
	<?php

	include_once "php_action/db_connect.php";

	$company_data = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM company ORDER BY id DESC LIMIT 1"));

	$company_name = $company_data['name'];

	$company_logo = $company_data['logo'];

	$company_address = $company_data['address'];

	$company_company_phone = $company_data['company_phone'];

	$company_personal_phone = $company_data['personal_phone'];

	$company_email = $company_data['email'];

	?>

	<meta charset="UTF-8">

	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>

	<meta http-equiv="X-UA-Compatible" content="IE=edge">



	<meta name="msapplication-TileColor" content="#162946">

	<meta name="theme-color" content="#e72a1a">

	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<meta name="apple-mobile-web-app-capable" content="yes">

	<meta name="mobile-web-app-capable" content="yes">

	<meta name="HandheldFriendly" content="True">

	<meta name="Duplex VehiclesOptimized" content="320">

	<meta name="description" content="">

	<meta name="keywords"
		content="autotrader,autotrader dealer portal,car classifieds,autoportal,auto classifieds,car dealer template,Autolist,vehicle sale template,car dealer website,car sale template,automotive websites,auto websites,template for selling car,automotive template,car dealer website template,automotive classifieds,car for sale template,car dealer html template,automotive template,car dealer template,car dealer website template,car service template,html template,bootstrap templates,css templates,responsive template,premium html templates,template premium">

	<!-- 		<link rel="icon" href="favicon.ico" type="image/x-icon"/>

 -->
	<link rel="icon" href="admin/img/logo/<?= $company_data['logo'] ?>" type="image/gif" sizes="16x16">



	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />



	<!-- Title -->

	<title><?= $company_name ?></title>





	<!--Slider-->

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@300;400&family=Roboto&family=Open+Sans:wght@300;400;700&display=swap">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

	<!-- Bootstrap Css -->

	<link href="assets/plugins/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet" />



	<!-- Dashboard Css -->

	<link href="assets/css/style.css" rel="stylesheet" />



	<!-- Font-awesome  Css -->

	<link href="assets/css/icons.css" rel="stylesheet" />



	<!--Horizontal Menu-->

	<link href="assets/plugins/horizontal-menu/horizontal.css" rel="stylesheet" />



	<!--Select2 Plugin -->

	<link href="assets/plugins/select2/select2.min.css" rel="stylesheet" />



	<!-- Owl Theme css-->

	<link href="assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />



	<!-- Date Picker Plugin -->

	<link href="assets/plugins/date-picker/spectrum.css" rel="stylesheet" />



	<!-- Custom scroll bar css-->

	<link href="assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />



	<!-- Color-Skins -->

	<link id="theme" rel="stylesheet" type="text/css" media="all" href="assets/color-skins/color13.css" />

	<link href="assets/plugins/jquery-uislider/jquery-ui.css" rel="stylesheet">









	<!-- UX Enhancements (sticky nav, typography, responsiveness) -->
	<link rel="stylesheet" href="css/ux-enhancements.css">

</head>



<!--Topbar-->

<?php include_once "includes/topbar.php"; ?>

<!--/Topbar-->