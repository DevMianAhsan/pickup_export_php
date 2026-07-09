<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/custom.js"></script>
<?php
include_once "includes/header.php";
include_once "inc/code.php";
// @$pagelink = $_SERVER['QUERY_STRING'];
// // echo $pagelink;
// @$link=explode('&page', $pagelink);
// @$link_page=$link[0];
?>
<style>
  .page-item.active .page-link {
    background-color: #55317E !important;
    border-color: #55317E !important;
  }
</style>
<div class="bg-white">
  <div class="container">
    <div class="page-header">
      <!-- <h4 class="page-title">Advance Search </h4> -->
      <!-- <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Search</a></li>
        <li class="breadcrumb-item active" aria-current="page">Advance Search</li>
      </ol> -->
    </div>
  </div>
</div>
<!--/BreadCrumb-->
<div class="container-fluid">
  <div class="form-row">
    <div class="col-sm-12 col-lg-12 col-md-12">
      <div class="card" style="background-color: #efecec">
        <div class="card-header card-bg text-white h2 text-center">Advance Search</div>
        <div class="card-body p-1" align="center">
          <!-- <div class="h1">Search for used Cars</div> -->
          <br /><br />
          <?php
          @$stock_type = $_GET['type'];
          // @$limit=5;
          // if (isset($_GET['page']))
          // {
          // $page=$_GET['page'];
          // }else{
          // $page=1;
          // }
          // $offsets=($page-1)*$limit;
          if ($stock_type == 'stock') {
            @$query = mysqli_query($dbc, "SELECT * FROM vehicle_info");
            // print_r($query);
          } elseif (isset($_REQUEST['advance'])) {
            $makerV = $brandV = $chasis_veh = $min_year = $colorV = $transmissionV = $optionsV = $min_price = $body_typeV = $fuelV = $stockidV = $eng_size = $eng_km = $load_cap = $eng_typ = $buying_date = $lot_number = $veh_disc = '';
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
            if (isset($_REQUEST['from_date']) and $_REQUEST['from_date'] != '' and $_REQUEST['to_date'] != '') {
              @$buying_date = "AND buying_date BETWEEN '$_REQUEST[from_date]' AND '$_REQUEST[to_date]'";
            }
            if (isset($_REQUEST['from_engine']) and $_REQUEST['from_engine'] != 'null' and $_REQUEST['to_engine'] != 'null') {
              @$eng_size = "AND vehicle_cc BETWEEN " . $_REQUEST['from_engine'] . " AND " . $_REQUEST['to_engine'];
            }
            if (isset($_REQUEST['from_km']) and $_REQUEST['from_km'] != 'null' and $_REQUEST['to_km'] != 'null') {
              @$eng_km = "AND vehicle_km BETWEEN " . $_REQUEST['from_km'] . " AND " . $_REQUEST['to_km'];
            }
            if (isset($_REQUEST['min_load_capacity']) and $_REQUEST['min_load_capacity'] != 'null' and $_REQUEST['max_load_capacity'] != 'null') {
              @$load_cap = "AND vehicle_loading_capacity BETWEEN " . $_REQUEST['from_km'] . " AND " . $_REQUEST['to_km'];
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
            if (isset($_REQUEST['lot_number']) and $_REQUEST['lot_number'] != '') {
              $lot_number = "AND lot_number='" . $_REQUEST['lot_number'] . "'";
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
            if (isset($_REQUEST['min_price']) and $_REQUEST['min_price'] != 'null' and $_REQUEST['max_price'] != 'null') {
              $min_price = "AND vehicle_est_price BETWEEN " . $_REQUEST['min_price'] . " AND " . $_REQUEST['max_price'];
            }
            $sq = "SELECT * FROM vehicle_info WHERE vehicle_status!='' " . $makerV . " " . $brandV . " " . $chasis_veh . " " . $min_year . " " . $colorV . " " . $transmissionV . " " . $optionsV . " " . $min_price . " " . $body_typeV . " " . $fuelV . " " . $stockidV . " " . $eng_size . " " . $eng_km . " " . $load_cap . " " . $eng_typ . " " . $veh_disc . " " . @$buying_date . " " . @$lot_number . " ";
            //echo $sq;
            $query = mysqli_query($dbc, $sq);
          }
          ?>
          <form method="get" style="padding: 0px 5px;" action="advance_search.php?type=stock">
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
                      <option value="<?= $r['maker_id'] ?>"><?= $r['maker_name'] ?></option>
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
                    <?php $q = get($dbc, "brands WHERE brand_status = 1 LIMIT 1");
                    while ($r = mysqli_fetch_assoc($q)): ?>
                      <option value="<?= $r['brand_id'] ?>"><?= $r['brand_name'] ?></option>
                    <?php endwhile ?>
                  </optgroup>
                </select>
              </div>
              <div class="col-md-4 col-lg-2 col-sm">
                <label class="" for="validationDefault02">Chassis</label>
                <select name="vehicle_chassis_code" id="vehicle_chassis_code" class="form-control"
                  style="text-transform: uppercase ">
                  <option value="null">~~SELECT~~</option>
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
                        <option value="<?= $i ?>"><?= $i ?></option>
                      <?php } ?>
                    </select>
                  </div>
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
                        <option value="<?= $i ?>"><?= $i ?></option>
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
                    <option value="Beige">Beige</option>
                    <option value="Black">Black</option>
                    <option value="Blue">Blue</option>
                    <option value="Brown">Brown</option>
                    <option value="Cream">Cream</option>
                    <option value="Gold">Gold</option>
                    <option value="Gray">Gray</option>
                    <option value="Green">Green</option>
                    <option value="Orange">Orange</option>
                    <option value="261,280">Pearl</option>
                    <option value="Pink">Pink</option>
                    <option value="Purple">Purple</option>
                    <option value="Red">Red</option>
                    <option value="Rose">Rose</option>
                    <option value="Silver">Silver</option>
                    <option value="Turquoise">Turquoise</option>
                    <option value="Twotone">Twotone</option>
                    <option value="White">White</option>
                    <option value="Wine">Wine</option>
                    <option value="Yellow">Yellow</option>
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
                      <option value="<?= $r_trans['transmission_name'] ?>" style="text-transform: uppercase!important;">
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
                      <option value="<?= $st_r['option_name'] ?>" style="text-transform: uppercase!important;">
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
                          <option value="<?= $i ?>">$<?= $i ?></option>
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
                          <option value="<?= $i ?>">$<?= $i ?> </option>
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
                      <option value="<?= $body['body_type_id'] ?>"><?= $body['body_type_name'] ?></option>
                      <?php
                    endwhile;
                    ?>
                  </select>
                </div>
                <div class="col-md-6">

                  <label for="validationDefault04" class="text-center">Fuel Type</label><br />
                  <select class="form-control select2-show-search" name="fuel_type">
                    <option value="null">~Select~</option>
                    <?php
                    $fuel_type = mysqli_query($dbc, "SELECT * FROM fuel ORDER BY fuel_name ASC");
                    while ($fuel = mysqli_fetch_assoc($fuel_type)):
                      ?>
                      <option value="<?= $fuel['fuel_name'] ?>"><?= $fuel['fuel_name'] ?></option>
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
              <div class="col-md-6 col-lg-3">
                <label for="validationDefault02">Mileage </label>
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100"
                      data-placeholder="Select" name="from_km">
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
                    <select class="form-control select2-show-search border-bottom-0 border-left-0 "
                      data-placeholder="Select" name="to_km">
                      <optgroup label="Type">
                        <option value="null">To</option>
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
                </div>
              </div>

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
                      </optgroup>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="">From Date</label>
                  <input type="date" name="from_date" id="from_date" class="form-control ">
                </div><!-- form group -->
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="">To Date</label>
                  <input type="date" name="to_date" id="to_date" class="form-control ">
                </div><!-- form group -->
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="">Lot Number</label>
                  <input type="text" name="lot_number" id="lot_number" class="form-control ">
                </div><!-- form group -->
              </div>
              <div class="col-md-2 d-flex align-items-center" style="text-align: left">
                <div class="form-group ">
                  <div class="form-check">
                    <button style="background-color: #55317E !important; color: #fff;margin-top: 30px !important;"
                      class="btn  btns mt-1" type="submit">
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
            <table class="adv table table-striped table-hover dataTable" id="example4">
              <thead>
                <tr>
                  <th>Sr.</th>
                  <th style="width: 20%!important">Vehicle</th>
                  <th>Full Detail</th>
                  <th>Sold Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // print_r(json_encode($_REQUEST));
                if (@$query):
                  // print_r(json_encode($_REQUEST));
                  // print_r($query);
                  if (mysqli_num_rows($query) > 0) {
                    $x = 1;
                    while (@$getV = mysqli_fetch_assoc($query)):
                      // print_r(@$getV);
                      @$r = getVehicleInfo($dbc, @$getV['vehicle_id'], true);
                      // print_r($setVeh);
                      $img = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM vehicle_images WHERE vehicle_id = '$getV[vehicle_id]' LIMIT 1"));
                      ?>
                      <tr>
                        <td><?= $x ?></td>
                        <td>
                          <?php if (@$userPrivileges['nav_edit'] == 1 || $fetchedUserRole == "admin"): ?>
                            <a style="color: black;" href="trade.php?vehicle_id=<?= $r['vehicle_id'] ?>">
                            <?php endif ?>
                            <br>
                            Brand Name : <?= fetchRecord($dbc, "brands", "brand_id", $r['vehicle_brand'])['brand_name'] ?>
                            <br>
                            Stock ID : <?= $r['vehicle_stock_id'] ?> <br>
                            Chassis No : <?= $r['vehicle_chassis_no'] ?> <br>
                            Engine No : <?= $r['vehicle_engine_no'] ?><br>
                            <?php if (@$userPrivileges['nav_edit'] == 1 || $fetchedUserRole == "admin"): ?>
                            </a>
                          <?php endif ?>
                        </td>
                        <td style="font-style: 11px!important">
                          <button onclick="loadData('vehicle_info', <?= $r['vehicle_id'] ?>)"
                            class="dropdown-item text-success view">Vehicle Info</button>
                        </td>
                        <td>
                          <?php
                          $in = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM invoice WHERE invoice_quotation != 'quotation' AND invoice_vehicle = '$r[vehicle_id]'"));
                          $get_trans = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT SUM(credit-debit) as nowbalance,SUM(credit) as paidamount  ,invoice_id,customer_id,vehicle_id  FROM transactions WHERE vehicle_id = '$r[vehicle_id]'  GROUP BY vehicle_id"));
                          //echo "SELECT * FROM invoice WHERE invoice_quotation != 'quotation' AND invoice_vehicle = '$r[vehicle_id]'";
                          if (@$r['vehicle_sale_stts']) {
                            ?>
                            <span class="badge badge-success p-2">Sold</span><br />

                            <?php
                          } else {
                            ?>
                            <span class="badge badge-danger p-2">Not Sold</span>
                            <?php
                          }
                          ?>
                        </td>
                        <td align="center">

                          <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu3"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu3">
                              <a href="trade.php?vehicle_id=<?= $r['vehicle_id'] ?>" class="dropdown-item">
                                <i class="mr-1 fa fa-edit"></i> Edit</a>
                              <a href="vehicle_services.php?vehicle_id=<?= $r['vehicle_id'] ?>" class="dropdown-item"><i
                                  class="mr-1 fa fa-tasks"></i> Add Services</a>
                              <a href="vehicle_docs.php?vehicle_id=<?= $r['vehicle_id'] ?>" class="dropdown-item"><i
                                  class="mr-1 fa fa-plus-circle"></i> Add Documents</a>
                              <a href="crystal_report.php?v_id=<?= $r['vehicle_id'] ?>" class="dropdown-item"><i
                                  class="mr-1 fa fa-print"></i>Crystal Report</a>
                              <button id="myFunction"
                                onclick="stats('vehicle_info','vehicle_id',<?= $r['vehicle_id'] ?>,'vehicle_sale_stts')"
                                class="dropdown-item">
                                <i class="mr-1 fa fa-check"></i>Mark as Sold</button>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php
                      $x++;
                    endwhile;
                  } else {
                    ?>
                    <tr>
                      <td colspan="8" style="color: #D40D0D;font-size: 20px;font-weight: 600;">Not Found</td>
                      <!-- <td></td> -->
                    </tr>
                    <?php
                  }
                endif;
                ?>
              </tbody>
            </table>

          </div>
        </div>
      </div>
      <!-- Vehicle table  -->
    </div>
  </div>
</div>
<div class="modal fade" id="modal-id">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body" id="loadData">
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
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
    $(document).ready(function () {
      $(document).on('change', '#makers', function () {
        var makers = $(this).val();
        $.ajax({
          url: 'php_action/custom_action.php',
          type: "POST",
          data: { makers: makers },
          dataType: "json",
          success: function (response) {
            var model = "<option value=" + 'null' + ">~~SELECT~~</option>";
            $.each(response, function (index, value) {
              model += '<option class="text-capitalize" value="' + value['brand_id'] + '">' + value['brand_name'] + '</option>';
            });
            $("#model").empty().append(model);
          }
        });
      });
      $(document).on('change', '#makers', function () {
        var makers = $(this).val();
        $.ajax({
          url: 'php_action/custom_action.php',
          type: "POST",
          data: { makers: makers },
          dataType: "json",
          success: function (response) {
            var model = "<option value=" + 'null' + ">~~SELECT~~</option>";
            $.each(response, function (index, value) {
              model += '<option class="text-capitalize" value="' + value['brand_id'] + '">' + value['brand_name'] + '</option>';
            });
            $("#model").empty().append(model);
          }
        });
      });
    });
    function loadChassis(vehicle_brand) {
      $.ajax({
        url: 'php_action/custom_action.php',
        type: "POST",
        data: { vehicle_brand1: vehicle_brand },
        dataType: "json",
        success: function (response) {
          console.log(response)
          var fucked = "<option value='null'>~SELECT~</option>";
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
  <?php
  function getVehicleInfo($dbc, $Vid, $fetched = false)
  {
    $q = mysqli_query($dbc, "SELECT vehicle_info.*, maker.*, brands.*,models.*,body_type.* FROM vehicle_info INNER JOIN maker ON vehicle_info.vehicle_maker = maker.maker_id INNER JOIN brands ON brands.brand_id = vehicle_info.vehicle_brand INNER JOIN models ON models.model_id = vehicle_info.vehicle_chassis_code INNER JOIN body_type ON body_type.body_type_id = vehicle_info.vehicle_type WHERE vehicle_info.vehicle_id = $Vid");
    if ($fetched == true) {
      return (mysqli_fetch_assoc($q));
    } else {
      return ($q);
    }

  }
  ?>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script type="text/javascript">
    function stats($tblname, $tblid, $id, $column) {
      // alert($tblname);
      $.ajax({
        url: 'php_action/custom_action.php',
        type: 'post',
        data: { tablename: $tblname, tableid: $tblid, id: $id, column: $column },
        dataType: 'JSON',
        success: function (response) {
          console.log(response.sts);
          swal("Good job!", response.msg, response.sts);
          $("#example4").load(location.href + " #example4 > *");
        }
      });

    }
  </script>