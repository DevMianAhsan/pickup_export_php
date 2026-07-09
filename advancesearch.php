<!doctype html>
<html lang="en" dir="ltr">
<?php
include_once "includes/header.php";
// print_r($_REQUEST);
?>
<!--BreadCrumb-->
<style>
  .page-item.active .page-link {
    background-color: #55317E !important;
    border-color: #55317E !important;
  }
</style>
<div class="bg-white">
  <div class="container">
    <div class="page-header">
      <h4 class="page-title">Advance Search </h4>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Search</a></li>
        <li class="breadcrumb-item active" aria-current="page">Advance Search</li>
      </ol>
    </div>
  </div>
</div>
<!--/BreadCrumb-->
<div class="container-fluid mt-3">
  <div class="row align-items-start">
    <div class="col-sm-2 col-lg-2 col-md-2 d-none d-sm-block d-md-block">
      <div style="position:sticky;top:80px;">
        <?php
        include_once "brandbar.php";
        ?>
      </div>
    </div>
    <div class="col-sm-10 col-lg-10 col-md-10">
      <div class="card" style="background-color: #efecec">
        <div class="card-body p-1" align="center">
          <div class="arrow-ribbon bg-info">Search for used Cars</div>
          <br /><br />
          <?php
          @$stock_type = $_GET['type'];
          @$limit = 20;

          if (isset($_GET['page'])) {
            $page = $_GET['page'];
          } else {
            $page = 1;
          }
          $offsets = ($page - 1) * $limit;
          if ($stock_type == 'stock') {

            @$query = mysqli_query($dbc, "SELECT * FROM vehicle_info ORDER BY vehicle_id DESC LIMIT {$offsets},{$limit}");
            $count_query = mysqli_query($dbc, "SELECT COUNT(*) as total FROM vehicle_info");
            // print_r($query);
          } elseif (isset($_REQUEST['advance'])) {
            $makerV = $brandV = $chasis_veh = $min_year = $colorV = $transmissionV = $optionsV = $min_price = $body_typeV = $fuelV = $stockidV = $eng_size = $eng_km = $load_cap = $eng_typ = $veh_disc = $countryV = $driveV = '';
            // echo "advance";
            if (isset($_REQUEST['maker']) and $_REQUEST['maker'] != 'null' and $_REQUEST['maker'] != '0') {
              $makerV = "AND vehicle_maker=" . $_REQUEST['maker'];
            }
            if (isset($_REQUEST['brands']) and $_REQUEST['brands'] != 'null') {
              $brandV = "AND vehicle_brand=" . $_REQUEST['brands'];
            }
            if (isset($_REQUEST['vehicle_chassis_code']) and $_REQUEST['vehicle_chassis_code'] != 'null') {
              $chasis_veh = "AND vehicle_chassis_code=" . $_REQUEST['vehicle_chassis_code'];
            }
            if (isset($_REQUEST['min_year']) and $_REQUEST['min_year'] != 'null' and $_REQUEST['max_year'] != 'null') {
              @$min_year = "AND vehicle_manu_year BETWEEN " . $_REQUEST['min_year'] . " AND " . $_REQUEST['max_year'];
            }
            if (isset($_REQUEST['from_engine']) and $_REQUEST['from_engine'] != 'null' and $_REQUEST['to_engine'] != 'null') {
              @$eng_size = "AND vehicle_cc BETWEEN " . $_REQUEST['from_engine'] . " AND " . $_REQUEST['to_engine'];
            }
            if (isset($_REQUEST['from_km']) and $_REQUEST['from_km'] != 'null' and $_REQUEST['to_km'] != 'null') {
              @$eng_km = "AND vehicle_km BETWEEN " . $_REQUEST['from_km'] . " AND " . $_REQUEST['to_km'];
            }

            if (isset($_REQUEST['min_load_capacity']) and $_REQUEST['min_load_capacity'] != 'null' and $_REQUEST['max_load_capacity'] != 'null') {
              @$load_cap = "AND vehicle_loading_capacity BETWEEN " . $_REQUEST['min_load_capacity'] . " AND " . $_REQUEST['max_load_capacity'];
            }

            if (isset($_REQUEST['min_disc']) and $_REQUEST['min_disc'] != 'null' and $_REQUEST['max_disc'] != 'null') {
              @$veh_disc = "AND vehicle_discount BETWEEN " . $_REQUEST['min_disc'] . " AND " . $_REQUEST['max_disc'];
            }

            if (isset($_REQUEST['color']) and $_REQUEST['color'] != 'null') {
              $colorV = "AND vehicle_color_name='" . $_REQUEST['color'] . "'";
              // print_r($body_typeV);
            }

            if (isset($_REQUEST['engine_type']) and $_REQUEST['engine_type'] != 'null') {
              $eng_typ = "AND vehicle_engine_type='" . $_REQUEST['engine_type'] . "'";
              // print_r($body_typeV);
            }
            if (isset($_REQUEST['body_type']) and $_REQUEST['body_type'] != 'null') {
              $body_typeV = "AND vehicle_type=" . $_REQUEST['body_type'];
              // print_r($body_typeV);
            }
            if (isset($_REQUEST['options']) and $_REQUEST['options'] != 'null') {
              $optionsV = "AND vehicle_option='" . $_REQUEST['options'] . "'";
            }
            if (isset($_REQUEST['drive']) and $_REQUEST['drive'] != 'null' and $_REQUEST['drive'] != '') {
              $driveV = "AND vehicle_drive='" . $_REQUEST['drive'] . "'";
            }
            if (isset($_REQUEST['fuel_type']) and $_REQUEST['fuel_type'] != 'null') {
              $fuelV = "AND vehicle_fuel='" . $_REQUEST['fuel_type'] . "'";
            }
            if (isset($_REQUEST['transmission']) and $_REQUEST['transmission'] != 'null') {
              $transmissionV = "AND vehicle_transmission='" . $_REQUEST['transmission'] . "'";
            }
            if (!empty($_REQUEST['stockid']) and $_REQUEST['stockid'] != 'null') {
              $stockidV = "AND vehicle_stock_id='" . $_REQUEST['stockid'] . "'";
            }
            // echo $stockidV ;
            if (isset($_REQUEST['country']) and $_REQUEST['country'] != 'null' and $_REQUEST['country'] != '') {
              $countryV = "AND country_id=" . $_REQUEST['country'];
            }
          
            // if (isset($_REQUEST['reg_year_from']) AND $_REQUEST['reg_year_from']!='null' AND $_REQUEST['reg_year_to']!='null') {
            // $reg_year_from="AND vehicle_reg_year BETWEEN ".$_REQUEST['reg_year_from']." AND ".$_REQUEST['reg_year_to'] ;
            // }
            if (isset($_REQUEST['min_price']) and $_REQUEST['min_price'] != 'null' and $_REQUEST['max_price'] != 'null') {
              $min_price = "AND vehicle_est_price BETWEEN " . $_REQUEST['min_price'] . " AND " . $_REQUEST['max_price'];
            }
            //$sq="SELECT * FROM vehicle_info WHERE vehicle_status='active' ".$makerV." ".$brandV." ".$body_typeV." ".$transmissionV." ".$optionsV." ".$driveV." ".$fuelV." ".$reg_year_from." ".$min_price." ".$stockidV." ";
            $sq = "SELECT * FROM vehicle_info WHERE vehicle_status!='' " . $makerV . " " . $brandV . " " . $chasis_veh . " " . $min_year . " " . $colorV . " " . $transmissionV . " " . $optionsV . " " . $min_price . " " . $body_typeV . " " . $fuelV . " " . $stockidV . " " . $eng_size . " " . $eng_km . " " . $load_cap . " " . $eng_typ . " " . $veh_disc . " " . $countryV . " " . $driveV . " ORDER BY vehicle_id DESC LIMIT {$offsets},{$limit}";
            //  echo $sq;
            $query = mysqli_query($dbc, $sq);
            $count_sq = "SELECT COUNT(*) as total FROM vehicle_info WHERE vehicle_status!='' " . $makerV . " " . $brandV . " " . $chasis_veh . " " . $min_year . " " . $colorV . " " . $transmissionV . " " . $optionsV . " " . $min_price . " " . $body_typeV . " " . $fuelV . " " . $stockidV . " " . $eng_size . " " . $eng_km . " " . $load_cap . " " . $eng_typ . " " . $veh_disc . " " . $countryV . " " . $driveV;
            $count_query = mysqli_query($dbc, $count_sq);
          }
          ?>
          <form method="get" style="padding: 0px 5px;" action="advancesearch.php">
            <div class="form-row">
              <div class="col-md-4 col-lg-2 col-sm">
                <input type="hidden" name="advance" value="gs">
                <label class="" for="validationDefault01">Maker</label>
                <select class="form-control select2-show-search border-bottom-0 w-100 br-3" data-placeholder="Select"
                  name="maker" id="makers" required>
                  <optgroup label="Makers">
                    <option value="null">Choose Maker</option>
                    <?php $q = get($dbc, "maker WHERE maker_sts = '1'");
                    while ($r = mysqli_fetch_assoc($q)): ?>
                      <option value="<?= $r['maker_id'] ?>" <?= (isset($_REQUEST['maker']) && $_REQUEST['maker'] == $r['maker_id']) ? 'selected' : '' ?>><?= $r['maker_name'] ?></option>
                    <?php endwhile ?>
                  </optgroup>
                </select>
              </div>
              <div class="col-md-4 col-lg-2 col-sm">
                <!-- <label for="validationDefault02">Brands</label>
                <select id="model" class="form-control select2-show-search border-bottom-0 border-left-0 w-100" data-placeholder="Select" name="model"  id="model">
                  <optgroup label="Model">
                    <option value="null"> Model</option>
                    
                  </optgroup>
                </select> -->
                <label class="" for="validationDefault02">Brand</label>
                <select class="form-control select2-show-search border-bottom-0 w-100 br-3"
                  onchange="loadChassis(this.value)" data-placeholder="Select" name="brands" id="model">
                  <optgroup label="Brands">
                    <option value="null">Select Brand</option>
                    <?php $q = get($dbc, "brands WHERE brand_status = 1 Limit 1");
                    while ($r = mysqli_fetch_assoc($q)): ?>
                      <option value="<?= $r['brand_id'] ?>" <?= (isset($_REQUEST['brands']) && $_REQUEST['brands'] == $r['brand_id']) ? 'selected' : '' ?>><?= $r['brand_name'] ?></option>
                    <?php endwhile ?>
                  </optgroup>
                </select>
              </div>
              <div class="col-md-4 col-lg-2 col-sm">
                <label class="" for="validationDefault02">Chassis</label>
                <select name="vehicle_chassis_code" id="vehicle_chassis_code" class="form-control"
                  style="text-transform: uppercase ">
                  <option value="null">Select Chassis</option>
                  <!-- <?php $q = get($dbc, "models WHERE model_sts = '1'");
                  while ($r = mysqli_fetch_assoc($q)): ?>
                  <option value="<?= $r['model_id'] ?>" style="text-transform: uppercase!important;"><?= $r['model_name'] ?></option>
                  <?php endwhile ?> -->
                </select>
              </div>
              <div class="col-md-4 col-lg-2 col-sm">
                <label for="validationDefault02">From year</label>
                <div class="row">
                  <div class="col-md">
                    <select id="inputState1" class="form-control select2" name="min_year">
                      <option value="null">Min Year</option>
                      <?php $date = date('Y');
                      for ($i = $date; $i >= 1900; $i--) { ?>
                        <option value="<?= $i ?>" <?= (isset($_REQUEST['min_year']) && $_REQUEST['min_year'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <!-- <div class="col-md-6">
                    <select id="" class="form-control select2 select2-show-search" name="frommonth">
                      <option value="null">Select</option>
                      <option value="January">January</option>
                      <option value="Febuary">Febuary</option>
                      <option value="March">March</option>
                      <option value="April">April</option>
                      <option value="May">May</option>
                      <option value="June">June</option>
                      <option value="July">July</option>
                      <option value="August">August</option>
                      <option value="September">September</option>
                      <option value="October">October</option>
                      <option value="November">November</option>
                      <option value="December">December</option>
                    </select>
                  </div> -->
                </div>
              </div>
              <div class="col-md-4 col-lg-2 col-sm">
                <label for="validationDefault02">To year</label>
                <div class="row">
                  <div class="col-md">
                    <select id="inputState2" class="form-control select2" name="max_year">
                      <option value="null">Max Year</option>
                      <?php $date = date('Y');
                      for ($i = $date; $i >= 1900; $i--) { ?>
                        <option value="<?= $i ?>" <?= (isset($_REQUEST['max_year']) && $_REQUEST['max_year'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
                      <?php } ?>
                    </select>

                  </div>
                  <!-- <div class="col-md-6">
                    <select id="inputState1" class="form-control select2 select2-show-search" name="tomonth">
                      <option value="null">Select</option>
                      <option value="January">January</option>
                      <option value="Febuary">Febuary</option>
                      <option value="March">March</option>
                      <option value="April">April</option>
                      <option value="May">May</option>
                      <option value="June">June</option>
                      <option value="July">July</option>
                      <option value="August">August</option>
                      <option value="September">September</option>
                      <option value="October">October</option>
                      <option value="November">November</option>
                      <option value="December">December</option>
                    </select>
                  </div> -->
                </div>
              </div>
              <div class="col-md-4 col-lg-2 col-sm" style="">
                <label for="validationDefault02">Color: </label>
                <div class="form-group">
                  <select class="form-control select2-show-search border-bottom-0 border-left-0 "
                    data-placeholder="Select" name="color">
                    <option value="null">Select Color</option>
                    <option value="Beige" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Beige') ? 'selected' : '' ?>>Beige</option>
                    <option value="Black" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Black') ? 'selected' : '' ?>>Black</option>
                    <option value="Blue" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Blue') ? 'selected' : '' ?>>Blue</option>
                    <option value="Brown" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Brown') ? 'selected' : '' ?>>Brown</option>
                    <option value="Cream" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Cream') ? 'selected' : '' ?>>Cream</option>
                    <option value="Gold" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Gold') ? 'selected' : '' ?>>Gold</option>
                    <option value="Gray" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Gray') ? 'selected' : '' ?>>Gray</option>
                    <option value="Green" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Green') ? 'selected' : '' ?>>Green</option>
                    <option value="Orange" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Orange') ? 'selected' : '' ?>>Orange</option>
                    <option value="261,280" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == '261,280') ? 'selected' : '' ?>>Pearl</option>
                    <option value="Pink" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Pink') ? 'selected' : '' ?>>Pink</option>
                    <option value="Purple" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Purple') ? 'selected' : '' ?>>Purple</option>
                    <option value="Red" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Red') ? 'selected' : '' ?>>Red</option>
                    <option value="Rose" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Rose') ? 'selected' : '' ?>>Rose</option>
                    <option value="Silver" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Silver') ? 'selected' : '' ?>>Silver</option>
                    <option value="Turquoise" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Turquoise') ? 'selected' : '' ?>>Turquoise</option>
                    <option value="Twotone" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Twotone') ? 'selected' : '' ?>>Twotone</option>
                    <option value="White" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'White') ? 'selected' : '' ?>>White</option>
                    <option value="Wine" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Wine') ? 'selected' : '' ?>>Wine</option>
                    <option value="Yellow" <?= (isset($_REQUEST['color']) && $_REQUEST['color'] == 'Yellow') ? 'selected' : '' ?>>Yellow</option>
                  </select>
                </div>
              </div>

            </div>
            <div class="form-row">
              <div class="col-md-6 col-lg-3 form-row">
                <div class="col-md-6">
                  <label for="validationDefault04">Transmission</label><br />
                  <select name="transmission" id="transmission" class="form-control" style="text-transform: uppercase ">
                    <option value="null">~~SELECT~~</option>
                    <?php $trans_query = get($dbc, "transmission WHERE transmission_sts = '1'");
                    while ($r_trans = mysqli_fetch_assoc($trans_query)): ?>
                      <option value="<?= $r_trans['transmission_name'] ?>" <?= (isset($_REQUEST['transmission']) && $_REQUEST['transmission'] == $r_trans['transmission_name']) ? 'selected' : '' ?> style="text-transform: uppercase!important;">
                        <?= $r_trans['transmission_name'] ?>
                      </option>
                    <?php endwhile ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="validationDefault04">Steering</label><br />
                  <select name="options" id="options" class="form-control" style="text-transform: uppercase ">
                    <option value="null">~~SELECT~~</option>
                    <?php $st_query = get($dbc, "options WHERE option_sts = '1'");
                    while ($st_r = mysqli_fetch_assoc($st_query)): ?>
                      <option value="<?= $st_r['option_name'] ?>" <?= (isset($_REQUEST['options']) && $_REQUEST['options'] == $st_r['option_name']) ? 'selected' : '' ?> style="text-transform: uppercase!important;">
                        <?= $st_r['option_name'] ?>
                      </option>
                    <?php endwhile ?>
                  </select>
                </div>

              </div>

              <div class="col-md-6 col-lg-3">
                <label for="validationDefault02">Price Range</label>
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100"
                      data-placeholder="Select" name="min_price">
                      <optgroup label="MIN">

                        <option value="null">MIN</option>
                        <?php
                        $i = 1000;
                        while ($i < 50001) {
                          ?>
                          <option value="<?= $i ?>" <?= (isset($_REQUEST['min_price']) && $_REQUEST['min_price'] == $i) ? 'selected' : '' ?>>$<?= $i ?></option>
                          <?php
                          $i = $i + 500;
                        }
                        ?>
                      </optgroup>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100"
                      data-placeholder="Select" name="max_price">
                      <optgroup label="MAX">

                        <option value="null">MAX</option>
                        <?php
                        $i = 1000;
                        while ($i < 50001) {
                          ?>
                          <option value="<?= $i ?>" <?= (isset($_REQUEST['max_price']) && $_REQUEST['max_price'] == $i) ? 'selected' : '' ?>>$<?= $i ?> </option>
                          <?php
                          $i = $i + 500;
                        }
                        ?>
                      </optgroup>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4 form-row">

                <div class="col-md-6">

                  <label for="validationDefault04" class="text-center">Body Type</label><br />

                  <select class="form-control select2-show-search" name="body_type">
                    <option value="null">Select Body Type</option>
                    <?php
                    $type = mysqli_query($dbc, "SELECT * FROM body_type ORDER BY body_type_name ASC");
                    while ($body = mysqli_fetch_assoc($type)):
                      ?>
                      <option value="<?= $body['body_type_id'] ?>" <?= (isset($_REQUEST['body_type']) && $_REQUEST['body_type'] == $body['body_type_id']) ? 'selected' : '' ?>><?= $body['body_type_name'] ?></option>
                      <?php
                    endwhile;
                    ?>
                  </select>
                </div>
                <div class="col-md-6">

                  <label for="validationDefault04" class="text-center">Fuel Type</label><br />
                  <select class="form-control select2-show-search" name="fuel_type">
                    <option value="null">Select Fuel Type</option>
                    <?php
                    $fuel_type = mysqli_query($dbc, "SELECT * FROM fuel ORDER BY fuel_name ASC");
                    while ($fuel = mysqli_fetch_assoc($fuel_type)):
                      ?>
                      <option value="<?= $fuel['fuel_name'] ?>" <?= (isset($_REQUEST['fuel_type']) && $_REQUEST['fuel_type'] == $fuel['fuel_name']) ? 'selected' : '' ?>><?= $fuel['fuel_name'] ?></option>
                      <?php
                    endwhile;
                    ?>
                  </select>
                </div>

              </div>
              <div class="col-md-2" style="">
                <label for="validationDefault02">Keywords </label>
                <div class="form-group">
                  <input type="text" name="stockid" class="form-control" placeholder="STOCKID">
                </div>
              </div>
              <div class="col-md-6 col-lg-3">
                <label for="validationDefault02">Engine Size</label>
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100"
                      data-placeholder="Select" name="from_engine">
                      <optgroup label="Type">
                        <option value="null">From</option>
                        <option value="660">660CC</option>
                        <option value="1000">1000CC</option>
                        <option value="1300">1300CC</option>
                        <option value="1500">1500CC</option>
                        <option value="1800">1800CC</option>
                        <option value="2000">2000CC</option>
                        <option value="2200">2200CC</option>
                        <option value="2400">2400CC</option>
                        <option value="2700">2700CC</option>
                        <option value="3000">3000CC</option>
                      </optgroup>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100"
                      data-placeholder="Select" name="to_engine">
                      <optgroup label="Type">
                        <option value="null">To</option>
                        <option value="660">660CC</option>
                        <option value="1000">1000CC</option>
                        <option value="1300">1300CC</option>
                        <option value="1500">1500CC</option>
                        <option value="1800">1800CC</option>
                        <option value="2000">2000CC</option>
                        <option value="2200">2200CC</option>
                        <option value="2400">2400CC</option>
                        <option value="2700">2700CC</option>
                        <option value="3000">3000CC</option>
                      </optgroup>
                    </select>
                  </div>
                </div>
              </div>
              <!-- <div class="col-md-6 col-lg-3">
                <label for="validationDefault02">Mileage </label>
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100" data-placeholder="Select" name="from_km">
                      <optgroup label="Type">
                        <option value="null">From</option>
                        
                        <?php
                        $r = 10000;
                        while ($r <= 100000):
                          ?>
                        <option value="<?= $r ?>"><?= $r ?>KM</option>
                        <?php
                        $r = $r + 10000;
                        endwhile;
                        ?>
                        <option value="150000">150000KM</option>
                        
                        
                        
                        ?>
                      </optgroup>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control select2-show-search border-bottom-0 border-left-0 " data-placeholder="Select" name="to_km">
                      <optgroup label="Type">
                        <option value="null">To</option>
                        <?php
                        $r = 10000;
                        while ($r <= 100000):
                          ?>
                        <option value="<?= $r ?>" ><?= $r ?>KM</option>
                        <?php
                        $r = $r + 10000;
                        endwhile;
                        ?>
                        <option value="150000">150000KM</option>
                        
                        
                        ?>
                      </optgroup>
                    </select>
                  </div>
                </div>
              </div> -->

              <div class="col-md-2" style="">
                <label for="validationDefault02">Body Length: </label>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100"
                        data-placeholder="Select" name="min_body_len">
                        <optgroup label="MIN">

                          <option value="null">MIN</option>
                          <?php
                          $i = 1;
                          while ($i < 101) {
                            ?>
                            <option value="<?= $i ?>"><?= $i ?> mm</option>
                            <?php
                            $i = $i + 10;
                          }
                          ?>
                        </optgroup>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100"
                        data-placeholder="Select" name="max_body_len">
                        <optgroup label="MAX">

                          <option value="null">MAX</option>
                          <?php
                          $i = 1;
                          while ($i < 101) {
                            ?>
                            <option value="<?= $i ?>"><?= $i ?> mm</option>
                            <?php
                            $i = $i + 10;
                          }
                          ?>

                          ?>
                        </optgroup>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2" style="">
                <label for="validationDefault02">Loading Capacity : </label>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100"
                        data-placeholder="Select" name="min_load_capacity">
                        <optgroup label="MIN">

                          <option value="null">MIN</option>
                          <?php
                          $i = 500;
                          while ($i < 10000) {
                            ?>
                            <option value="<?= $i ?>"><?= $i ?> kg</option>
                            <?php
                            $i = $i + 500;
                          }
                          ?>
                        </optgroup>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100"
                        data-placeholder="Select" name="max_load_capacity">
                        <optgroup label="MAX">

                          <option value="null">MAX</option>
                          <?php
                          $i = 500;
                          while ($i < 10000) {
                            ?>
                            <option value="<?= $i ?>"><?= $i ?> kg</option>
                            <?php
                            $i = $i + 500;
                          }
                          ?>

                          ?>
                        </optgroup>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2" style="">
                <label for="validationDefault02">Engine Type: </label>
                <div class="form-group">
                  <select class="form-control select2-show-search border-bottom-0 border-left-0 "
                    data-placeholder="Select" name="engine_type">
                    <option value="null">Select Type</option>
                    <?php
                    $fuel_type = mysqli_query($dbc, "SELECT DISTINCT vehicle_engine_type FROM vehicle_info ORDER BY vehicle_engine_type ASC");
                    while ($fuel = mysqli_fetch_assoc($fuel_type)):
                      ?>
                      <option value="<?= $fuel['vehicle_engine_type'] ?>"><?= $fuel['vehicle_engine_type'] ?></option>
                      <?php
                    endwhile;
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-lg-3">
                <label for="validationDefault02">Discount%</label>
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100"
                      data-placeholder="Select" name="min_disc">
                      <optgroup label="MIN">

                        <option value="null">MIN</option>
                        <?php
                        $i = 1;
                        while ($i < 101) {
                          ?>
                          <option value="<?= $i ?>"><?= $i ?>% </option>
                          <?php
                          $i = $i + 10;
                        }
                        ?>
                      </optgroup>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100"
                      data-placeholder="Select" name="max_disc">
                      <optgroup label="MAX">

                        <option value="null">MAX</option>
                        <?php
                        $i = 1;
                        while ($i < 101) {
                          ?>
                          <option value="<?= $i ?>"><?= $i ?>% </option>
                          <?php
                          $i = $i + 10;
                        }
                        ?>

                        ?>
                      </optgroup>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-2" style="">
                <label for="validationDefault02">Country: </label>
                <div class="form-group">
                  <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100"
                    data-placeholder="Select" name="country">
                    <option value="null">Select Country</option>
                    <?php
                    $sql_country = mysqli_query($dbc, "SELECT DISTINCT c.country_id, c.country_name FROM countries c ORDER BY c.country_name ASC");
                    while ($country = mysqli_fetch_assoc($sql_country)):
                      ?>
                      <option value="<?= $country['country_id'] ?>" <?= (isset($_REQUEST['country']) && $_REQUEST['country'] == $country['country_id']) ? 'selected' : '' ?>><?= htmlspecialchars($country['country_name']) ?></option>
                    <?php
                    endwhile;
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2 pt-5" style="text-align: left">
                <div class="form-group">
                  <div class="form-check">
                    <button style="background-color: #55317E !important; color: #fff;" class="btn  btns mt-1"
                      type="submit">
                      <span class="glyphicon glyphicon-search "></span>
                      Search
                    </button>
                  </div>
                </div>
              </div>
            </div>
        </div><!-- main -->
      </div>
      </form>
      <!-- <hr/> -->
      <!-- <div class="col-sm-12 form-row "  style="background-color: #efecec;"> -->
      <!-- <br/><br/><br/><br/><br/> -->
      <!-- <div class="col-sm-2">
            <h3>Total Price Calculator</h3>
            <p>Estimate the price of the vehicle(s) based on your destination.
              <span style="color: red">Note:</span> In some cases the total price cannot be estimated.</p>
            </div>
            <div class="col-sm-4 form-row ">
              <div class="col-sm-6">
                Destination Country:
              </div>
              <div class="col-sm-6">
                <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100" data-placeholder="Select" id="countryFee" name="country">
                  <optgroup label="Select Country" name="country">
                    <option>Select Country</option>
                    <?php
                    $sql = mysqli_query($dbc, "SELECT * FROM country_regulation GROUP BY country_regulation_country");
                    while ($countries = mysqli_fetch_assoc($sql)):
                      ?>
                    <option value="<?= $countries['country_regulation_country'] ?>"><?= $countries['country_regulation_country'] ?></option>
                    <?php
                    endwhile;
                    ?>
                  </optgroup>
                </select>
              </div>
              
              <div class="col-sm-6" >
                Select Port:
              </div>
              <div class="col-sm-6" >
                <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100" data-placeholder="Select" id="countryPorts" name="port">
                  <option>Select Port</option>
                  <?php
                  $q = mysqli_query($dbc, "SELECT * FROM country_regulation");
                  while ($r = mysqli_fetch_assoc($q)):
                    ?>
                  <option value="<?= $r['country_regulation_id'] ?>"><?= $r['country_regulation_destination_port'] ?></option>
                  <?php
                  endwhile;
                  ?>
                </select>
              </div>
              <div class="col-sm-6" >
                Shipment:
              </div>
              <div class="col-sm-6" >
                <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100" data-placeholder="Select" id="countryPorts" name="port">
                  <option>Container</option>
                  <option>RoRo</option>
                </select>
              </div>
              <div class="col-sm-6" >
                Freight:
              </div>
              <div class="col-sm-6" >
                Included
              </div>
            </div>
            <div class="col-sm-4 form-row ">
              <div class="col-sm-6 text-center">
                Currency :
              </div>
              <div class="col-sm-6">
                <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100" data-placeholder="Select" id="Currency" name="Currency">
                  <optgroup label="Select Country" name="country">
                    <option>Select Currency</option>
                    <option value="USD" selected>USD</option>
                    <option value="JPY" >JPY</option>
                    <option value="GBP" >GBP</option>
                    <option value="EUR" >EUR</option>
                    
                  </optgroup>
                </select>
              </div>
              
              <div class="col-sm-6 text-center" >
                Insurance :
              </div>
              <div class="col-sm-6 text-center" align="center" >
                <div class="form-row">
                  <input type="radio" name="yes"> &nbsp;Yes:
                  <input type="radio" name="yes">&nbsp; No:
                </div>
              </div>
              <div class="col-sm-6 text-center" align="center">
                Inspection
              </div>
              <div class="col-sm-6 text-center" >
                <div class="form-row">
                  <input type="radio" name="yes">&nbsp; Yes:
                  <input type="radio" name="yes">&nbsp; No:
                </div>
              </div>
              <div class="col-sm-6" >
                
              </div>
              <div class="col-sm-6" >
                
              </div>
            </div>
            
            
            <div class="col-sm-2">
              <button class="btn btn-primary" style="margin-top: 100px">Calculate Price</button>
            </div>
          </div> -->
      <!-- </div> -->
      <!-- Vehicle table -->
      <div class="container-fluid mt-5 p-3">
        <div class="row">
          <div class="col p-0 table-responsive">
            <table class="adv table table-striped table-hover">
              <thead style="background-color: #55317E;color: #fff;">
                <tr align="center" style="line-height: 30px !important;">
                  <td>REF NO</td>
                  <td>Image</td>
                  <td>Car name</td>
                  <td>Year<br>
                    <hr width="50%" class="mt-0 mb-0">Engine
                  </td>
                  <!-- <td>Mileage</td> -->
                  <td>Trans<br>
                    <hr width="50%" class="mt-0 mb-0">Steering
                  </td>
                  <td>Vehicle Price</td>
                  <td>Action</td>
                </tr>
              </thead>
              <style>
                .midle {
                  padding: 3px 5px !important;
                  text-align: center;
                  vertical-align: middle !important;
                }
              </style>
              <div class="center-block text-center pt-3">
                <?php
                if (@$count_query && mysqli_num_rows($count_query) > 0) {
                  $count_row = mysqli_fetch_assoc($count_query);
                  $total_row = $count_row['total'];
                  $totalpage = ceil($total_row / $limit);

                  // Build query string for pagination links to preserve filters
                  $query_string = '';
                  if (isset($_REQUEST['advance'])) {
                    $params = $_REQUEST;
                    unset($params['page']); // Remove page parameter to avoid duplication
                    $query_string = http_build_query($params);
                  } else {
                    $query_string = 'type=stock';
                  }
                  ?>
                  <ul class="pagination mb-3 d-flex justify-content-center">
                    <?php if ($page > 1) { ?>
                      <li class="page-item"><a class="page-link"
                          href="advancesearch.php?<?php echo $query_string; ?>&page=<?php echo $page - 1; ?>">Pre</a></li>
                    <?php } ?>
                    <?php
                    for ($i = 1; $i <= $totalpage; $i++) {
                      $active = ($i == $page) ? 'active' : '';
                      ?>
                      <li class="page-item <?php echo $active; ?>"><a class="page-link ml-1 mr-1"
                          href="advancesearch.php?<?php echo $query_string; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                      </li>
                    <?php } ?>
                    <?php if ($totalpage > $page) { ?>
                      <li class="page-item"><a class="page-link"
                          href="advancesearch.php?<?php echo $query_string; ?>&page=<?php echo $page + 1; ?>">Next</a></li>
                    <?php } ?>
                  </ul>
                <?php } ?>
              </div>
              <tbody>
                <?php
                // print_r(json_encode($_REQUEST));
                
                if (@$query):
                  // print_r(json_encode($_REQUEST));
                
                  // print_r($query);
                  if (mysqli_num_rows($query) > 0) {
                    while (@$getV = mysqli_fetch_assoc($query)):
                      // print_r(@$getV);
                      @$setVeh = getVehicleInfo($dbc, @$getV['vehicle_id'], true);
                      // print_r($setVeh);
                      $img = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM vehicle_images WHERE vehicle_id = '$getV[vehicle_id]' AND vehicle_image_featured = 1 LIMIT 1"));
                      ?>
                      <tr class="border-bottom">
                        <td class="midle font-weight-bold" width="7%"
                          style="background-color: #55317E;color: #fff;text-align: center;">
                          <?= @$setVeh['vehicle_stock_id'] ?>
                        </td>
                        <td class="midle" width="10%">
                          <a href="singlecar.php?i=<?= base64_encode(@$getV['vehicle_id']) ?>">
                            <?php
                            if (@$img['vehicle_image_name'] == '') {
                              ?>
                              <img src="admin/img/logo/alternative.png" alt="img" class="cover-image" width="100%"
                                style="height: 110px;">
                              <?php
                            } else {
                              ?>
                              <img src="admin/img/vehicles_images/<?= @$img['vehicle_image_name'] ?>" alt="img"
                                class="cover-image" style="height: 110px;">
                              <?php
                            }
                            ?>
                          </a>
                        </td>
                        <td class="midle" width="15%">
                          <a class="text-dark" href="singlecar.php?i=<?= base64_encode(@$getV['vehicle_id']) ?>">
                            <span class="font-weight-bold"><?= @$setVeh['maker_name'] ?>
                              <?= @$setVeh['brand_name'] ?></span></a>
                          <br><span class="text-danger"><b>Ext. Color</b>/<?= @$setVeh['vehicle_color_name'] ?></span><br>
                          <?= @$setVeh['vehicle_access'] ?>
                        </td>
                        <td class="midle" width="10%">
                          <?= @$setVeh['vehicle_manu_year'] ?>-<?= @$setVeh['vehicle_manu_month'] ?><br>
                          <hr width="50%" class="mt-0 mb-0"><?= @$setVeh['vehicle_cc'] ?> cc
                        </td>
                        <!-- <td class="midle" width="10%"><?= @$setVeh['vehicle_km'] ?> km</td> -->
                        <td class="midle" width="10%"><?= ucwords(@$setVeh['vehicle_transmission']) ?><br>
                          <hr width="50%" class="mt-0 mb-0"><?= ucwords(@$setVeh['vehicle_option']) ?>
                        </td>
                        <td class="midle font-weight-bold" width="10%"><?php
                        if (@$setVeh['vehicle_est_price'] == '0') {
                          echo "ASK";
                        } else {
                          echo "US " . "$" . @$setVeh['vehicle_est_price'];
                        }
                        ?>
                        </td>
                        <td class="midle" width="10%">
                          <a href="" class="btn btn-purple mb-2">Inquiry Now</a><br>
                          <!-- <?php
                          if (@$setVeh['vehicle_location'] != '') {
                            ?>
                        <hr width="80%" class="mt-0 mb-0">
                      <span style="font-weight: 600;text-transform: uppercase;letter-spacing: .5px;" class=""><?= ucwords(@$setVeh['vehicle_location']) ?></span>
                      <?php
                          }
                          ?> -->
                        </td>
                      </tr>
                      <?php
                    endwhile;
                  } else {
                    $message = "No vehicles found matching your search criteria. Please try adjusting your filters.";
                    ?>
                    <tr>
                      <td colspan="7" style="color: #D40D0D;font-size: 20px;font-weight: 600;">
                        <?php echo htmlspecialchars($message); ?>
                      </td>
                    </tr>
                    <?php
                  }
                endif;
                ?>
              </tbody>
            </table>
            <div class="center-block text-center pt-3">
              <ul class="pagination mb-3 d-flex justify-content-center">
                <?php if ($page > 1) { ?>
                  <li class="page-item"><a class="page-link"
                      href="advancesearch.php?<?php echo $query_string; ?>&page=<?php echo $page - 1; ?>">Pre</a></li>
                <?php } ?>
                <?php
                for ($i = 1; $i <= @$totalpage; $i++) {
                  $active = ($i == $page) ? 'active' : '';
                  ?>
                  <li class="page-item <?php echo $active; ?>"><a class="page-link ml-1 mr-1"
                      href="advancesearch.php?<?php echo $query_string; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                  </li>
                <?php } ?>
                <?php if (@$totalpage > $page) { ?>
                  <li class="page-item"><a class="page-link"
                      href="advancesearch.php?<?php echo $query_string; ?>&page=<?php echo $page + 1; ?>">Next</a></li>
                <?php } ?>
              </ul>

            </div>
          </div>
        </div>
      </div>
      <!-- Vehicle table  -->
    </div>
  </div>
</div>
<style>
  .select2-container .select2-selection--single {
    height: auto !important;
  }

  .btns {
    padding: 5px 10px;
  }
</style>
<?php
include_once "includes/footer.php";
?>
<script>
  function loadChassis(vehicle_brand) {
    $.ajax({
      url: 'php_action/custom_action.php',
      type: "POST",
      data: { vehicle_brand1: vehicle_brand },
      dataType: "json",
      success: function (response) {
        console.log(response)
        var fucked = "<option disabled selected>Select Chassis</option>";
        $.each(response, function (index, value) {
          fucked += '<option class="text-capitalize" style="text-transform: uppercase!important;" value="' + value['model_id'] + '">' + value['model_name'] + '</option>';
        });
        $("#vehicle_chassis_code").empty().append(fucked);
      }
    });
    $.ajax({
      url: 'php_action/custom_action.php',
      type: "POST",
      data: { vehicle_brand_m3: vehicle_brand },
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response.sts == 1) {
          $("#vehicle_m3").val(response.m3);
          $("#vehicle_length").prop("readonly", true);
          $("#vehicle_width").prop("readonly", true);
          $("#vehicle_height").prop("readonly", true);
          $("#vehicle_length").prop("required", false);
          $("#vehicle_width").prop("required", false);
          $("#vehicle_height").prop("required", false);
          $("#vehicle_length").val('0');
          $("#vehicle_width").val('0');
          $("#vehicle_height").val('0');
        }
        if (response.sts == 0) {
          $("#vehicle_m3").val('');
          $("#vehicle_length").val('0');
          $("#vehicle_width").val('0');
          $("#vehicle_height").val('0');
          $("#vehicle_length").prop("readonly", false);
          $("#vehicle_width").prop("readonly", false);
          $("#vehicle_height").prop("readonly", false);
          $("#vehicle_length").prop("required", true);
          $("#vehicle_width").prop("required", true);
          $("#vehicle_height").prop("required", true);
        }

      }
    });
  }
</script>
</html>