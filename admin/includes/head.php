 <?php include_once 'php_action/core.php';
       $get_company =mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM company ORDER BY id DESC LIMIT 1"));

  ?>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <link rel="icon" href="img/logo/<?=$get_company['logo']?>" type="image/gif" sizes="16x16"> 
    <title><?=$get_company['name']?></title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="assets/css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/feather.css">
    <link rel="stylesheet" href="assets/css/select2.css">
    <link rel="stylesheet" href="assets/css/dropzone.css">
    <link rel="stylesheet" href="assets/css/uppy.min.css">
    <link rel="stylesheet" href="assets/css/jquery.steps.css">
    <link rel="stylesheet" href="assets/css/jquery.timepicker.css">
    <link rel="stylesheet" href="assets/css/quill.snow.css">
        <link rel="stylesheet" href="custom/dropzone/dist/dropzone.css" />
            

    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="assets/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="assets/css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="assets/css/app-dark.css" id="darkTheme" disabled>
    <script src="assets/js/sweetalert2.min.js"></script>
    <script src="assets/js/all.min.js"></script>
    <link rel="stylesheet" href="assets/css/sweetalert2.min.css">

    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.css">
         <link rel="stylesheet" href="assets/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
           <link rel="stylesheet" href="assets/plugins/material-datetimepicker/bootstrap-material-datetimepicker.css" />





    <style type="text/css">

        .btn-admin{
                color: #ffffff; 
                background-color: #ff1a1a; 
                border-color: #ff1a1a;
        }
         .btn-admin2{
                color: white; 
                background-color: black; 
                border-color: black;
        }
        .card-bg{
                
                background-color: black; 


               
        }
        .card-bg>h4{
    text-align: center;
    color: #fff !important;
}
        .card-text{
         color: white;    
        }
        .sidebar-left .navbar-brand {
          padding: 1rem 0;
          text-align: center;
        }
        .sidebar-left .navbar-brand img.sidebar-logo {
          max-height: 70px !important;
          height: auto !important;
          width: auto;
          max-width: 100%;
        }
        .vertical.collapsed .sidebar-left .navbar-brand img.sidebar-logo,
        .vertical.narrow .sidebar-left .navbar-brand img.sidebar-logo {
          max-height: 44px !important;
          height: auto !important;
          width: auto;
        }
        body.vertical.collapsed .sidebar-left,
        body.vertical.narrow .sidebar-left,
        .vertical.collapsed .sidebar-left,
        .vertical.narrow .sidebar-left {
          min-width: 5rem !important;
          width: 5rem !important;
          left: 0 !important;
        }
        body.vertical.collapsed.hover .sidebar-left,
        body.vertical.narrow.hover .sidebar-left,
        .vertical.collapsed.hover .sidebar-left,
        .vertical.narrow.hover .sidebar-left {
          min-width: 16rem !important;
          width: 16rem !important;
          left: 0 !important;
        }
        body.vertical.collapsed .wrapper,
        body.vertical.narrow .wrapper,
        body.vertical.collapsed .page-content-wrapper,
        body.vertical.narrow .page-content-wrapper {
          margin-left: 0 !important;
          width: 100% !important;
          padding-left: 0 !important;
        }
        body.vertical.collapsed .main-content,
        body.vertical.narrow .main-content,
        body.vertical.narrow.open .main-content,
        body.vertical.narrow.hover .main-content,
        .vertical.collapsed .main-content,
        .vertical.narrow .main-content,
        .vertical.narrow.open .main-content,
        .vertical.narrow.hover .main-content {
          margin-left: 5rem !important;
          width: calc(100% - 5rem) !important;
        }
        body.vertical.collapsed.hover .main-content,
        body.vertical.narrow.hover .main-content,
        .vertical.collapsed.hover .main-content,
        .vertical.narrow.hover .main-content,
        body.vertical.collapsed.hover .topnav,
        body.vertical.narrow.hover .topnav,
        .vertical.collapsed.hover .topnav,
        .vertical.narrow.hover .topnav {
          margin-left: 16rem !important;
          width: calc(100% - 16rem) !important;
        }
        .vertical .main-content,
        .vertical.hover .main-content,
        .narrow.open .main-content {
          margin-left: 16rem !important;
          width: calc(100% - 16rem) !important;
        }
        @media (max-width: 991.98px) {
          .vertical .sidebar-left,
          .vertical.hover .sidebar-left,
          .vertical.narrow .sidebar-left,
          .vertical.collapsed .sidebar-left {
            min-width: 16rem !important;
            width: 16rem !important;
            left: -16rem !important;
            position: fixed !important;
            top: 0 !important;
            bottom: 0 !important;
            transition: left .3s ease !important;
            z-index: 1050 !important;
          }
          body.vertical.mobile-sidebar-open .sidebar-left,
          body.vertical.mobile-sidebar-open .hover .sidebar-left,
          body.vertical.mobile-sidebar-open .narrow .sidebar-left,
          body.vertical.mobile-sidebar-open .collapsed .sidebar-left {
            left: 0 !important;
          }
          .vertical .main-content,
          .vertical.hover .main-content,
          .vertical.narrow .main-content,
          .vertical.collapsed .main-content,
          .vertical.narrow.open .main-content,
          .vertical.narrow.hover .main-content,
          body.vertical.mobile-sidebar-open .main-content {
            margin-left: 0 !important;
            width: 100% !important;
          }
          .vertical .topnav,
          .vertical.hover .topnav,
          .vertical.narrow .topnav,
          .vertical.collapsed .topnav,
          .vertical.narrow.open .topnav,
          .vertical.narrow.hover .topnav,
          body.vertical.mobile-sidebar-open .topnav {
            margin-left: 0 !important;
            width: 100% !important;
          }
          .sidebar-left .navbar-brand img.sidebar-logo {
            max-height: 50px !important;
          }
          .mobile-sidebar-overlay {
            display: none;
          }
          body.mobile-sidebar-open .mobile-sidebar-overlay {
            display: block;
            position: fixed;
            inset: 0;
            z-index: 1040;
            background: rgba(0,0,0,.45);
          }
        }
      </style>
      </style>
  </head>
  