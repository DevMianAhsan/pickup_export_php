
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php 
          include_once 'php_action/db_connect.php';
          include_once 'includes/functions.php';
     $get_company =mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM company ORDER BY id DESC LIMIT 1"));

if(isset($_SESSION['userId'])) {
  header('location: dashboard.php');  
}



if($_POST) {    

   $username = $_POST['username'];
   $password = $_POST['pass'];

  if(empty($username) || empty($password)) {
    if($username == "") {
      $msg = "Username is required";
      $sts="danger";
    } 

    if($password == "") {
      $msg = "Password is required";
      $sts="danger";
    }
  } else {
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $connect->query($sql);

    if($result->num_rows == 1) {
      $password = md5($password);
      // exists
      $mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
      $mainResult = $connect->query($mainSql);

      if($mainResult->num_rows == 1) {
        $value = $mainResult->fetch_assoc();
        $user_id = $value['user_id'];
        $_SESSION['user_id']= $value['user_id'];
          setcookie("user_id",$user_id,time()+(86400),"/");

        // set session
        $_SESSION['userId'] = $user_id;
       header('location: dashboard.php');
?>

<?php
      } else{
        
        $msg = "Incorrect username/password combination";
        $sts="danger";
      } // /else
    } else {    
      $msg = "Username doesnot exists";   
      $sts="danger"; 
    } // /else
  } // /else not empty username // password
  
} // /if $_POST
?>
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
      
    </style>
  </head>
  <body class="light ">
    <div class="container vh-100">
      <div class="row align-items-center h-100">
        <div  class="col-lg-4 col-md-5 col-10 mx-auto text-center bg-white  shadow  rounded">
          
        <form action="" method="POST">
          <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="index.php">
            <img src="img/logo/<?=$get_company['logo']?>" style="width: 100px;height: 100px;">
          </a>
          <h1 class="h4 mb-3"><?=$get_company['name']?></h1>
          <h1 class="h6 mb-3">Sign in</h1>
          <?=@getMessage($msg,$sts)?>
          <div class="form-group">
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="text" id="inputEmail" class="form-control form-control-lg" placeholder="Email address" required="" name="username" autofocus="">
          </div>
          <div class="form-group">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="pass" id="inputPassword" class="form-control form-control-lg" placeholder="Password" required="">
          </div>
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me"> Stay logged in </label>
          </div>
          <button class="btn btn-lg btn-admin btn-block" type="submit">Signin</button>
          <p class="mt-5 mb-3 text-muted">samcreations©2021</p>
        </form>
        </div>
      </div>
    </div>
    <?php include_once 'includes/footer.php'; ?>
  </body>
</html>
</body>
</html>