<style>
.crdbrder {
border: none !important;
}
</style>
<div class="container"  style="background-color: #efecec">
  <div class="card crdbrder  mt-3">
    <div class="card-body pb-0 pt-1"  style="background-color: #efecec">
      <div class="row mt-0">
        <div class="col-sm-6">
          <div class="arrow-ribbon bg-info" style="padding: 2px 5px;">Search for used Cars</div>
        </div>
      </div>
      <br/><br/>
      <form method="get" class="" action="car-lists.php">
        <input type="hidden" name="advance" value="s">
        <div class="form-row mt-0">
          <div class="col-md-2">
            <label class="m-0" for="validationDefault01">Maker</label>
            <select class="form-control select2-show-search border-bottom-0 w-100 br-3" data-placeholder="Select" name="maker" id="makers">
              <optgroup label="Makers">
                <option value="null">Choose Maker</option>
                <?php $q = get($dbc,"maker WHERE maker_sts = '1'");
                while($r = mysqli_fetch_assoc($q)): ?>
                <option value="<?=$r['maker_id']?>"><?=$r['maker_name']?></option>
                <?php endwhile ?>
              </optgroup>
            </select>
          </div>
          <div class="col-md-2">
            <label class="m-0" for="validationDefault02">Brand</label>
            <select class="form-control select2-show-search border-bottom-0 w-100 br-3"  onchange="loadChassis(this.value)" data-placeholder="Select"  name="brands" id="model" >
              <optgroup label="Brands">
                <option value="null">Select Brand</option>
                <?php $q = get($dbc,"brands WHERE brand_status = 1 LIMIT 1");
                while($r = mysqli_fetch_assoc($q)): ?>
                <option value="<?=$r['brand_id']?>"><?=$r['brand_name']?></option>
                <?php endwhile ?>
              </optgroup>
            </select>
          </div>
          <!-- new field created -->
          <div class="col-md-2">
            <label class="m-0" for="validationDefault02">Chassis</label>
            <select name="vehicle_chassis_code" id="vehicle_chassis_code" class="form-control"  style="text-transform: uppercase ">
              <option value="0">~~SELECT~~</option>
              <!-- <?php $q = get($dbc,"models WHERE model_sts = '1'");
              while($r = mysqli_fetch_assoc($q)): ?>
              <option value="<?=$r['model_id']?>" style="text-transform: uppercase!important;"><?=$r['model_name']?></option>
              <?php endwhile ?> -->
            </select>
          </div>
          <!-- //// created -->
          <div class="col-md-2">
            <label class="m-0" for="validationDefault02">Type</label>
            <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100" data-placeholder="Select" name="body_type" id="body_type">
              <optgroup label="Type">
                <option value="null">Type</option>
                <?php $q = get($dbc,"body_type WHERE body_type_sts = 1 ORDER BY body_type_name ASC ");
                while($r = mysqli_fetch_assoc($q)): ?>
                <option value="<?=$r['body_type_id']?>"><?=$r['body_type_name']?></option>
                <?php endwhile ?>
              </optgroup>
              ?>
            </optgroup>
          </select>
        </div>
        <!-- <div class="col-md-4 text-center">
          <div class="form-row mt-0"> -->
            <div class="col-md-2">
              <label class="m-0" for="validationDefault02">Year From</label>
              <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100" data-placeholder="Select">
                <optgroup label="Type">
                  <option>From</option>
                  <?php
                  $date = date('Y');
                  for ($i = 1920; $i <= $date; $i++) {?>
                  <option value="<?=$i?>"><?=$i?></option>
                  <?php
                  }
                  ?>
                </optgroup>
              </select>
            </div>
            <div class="col-md-2">
              <label class="m-0" for="validationDefault02">Year To</label>
              <select class="form-control select2-show-search border-bottom-0 border-left-0 w-100" data-placeholder="Select">
                <optgroup label="Type">
                  <option>To</option>
                  <?php
                  $date = date('Y');
                  for ($i = 1920; $i <= $date; $i++) {?>
                  <option value="<?=$i?>"><?=$i?></option>
                  <?php
                  }
                  
                  ?>
                </optgroup>
              </select>
            </div>
          <!-- </div>
        </div> -->
        <!-- <div class="col-md-5 text-center">
          <div class="form-row mt-0"> -->
            <div class="col-md-2">
              <label class="m-0" for="validationDefault02">Price From</label>
              <select name="min" class="form-control select2-show-search border-bottom-0 border-left-0 w-100" data-placeholder="Select">
                <optgroup label="MIN">
                  
                  <option>MIN</option>
                  <?php
                  $i =1000;
                  while($i<50001){
                  ?>
                  <option value="<?=$i?>" >$<?=$i?> </option>
                  <?php
                  $i = $i+500;
                  }
                  ?>
                </optgroup>
              </select>
            </div>
            <div class="col-md-2">
              <label class="m-0" for="validationDefault02">Price To</label>
              <select name="max" class="form-control select2-show-search border-bottom-0 border-left-0 w-100" data-placeholder="Select">
                <optgroup label="MAX">
                  
                  <option>MAX</option>
                  <?php
                  $i =1000;
                  while($i<50001){
                  ?>
                  <option value="<?=$i?>" >$<?=$i?> </option>
                  <?php
                  $i = $i+500;
                  }
                  ?>
                </optgroup>
              </select>
            </div>
            <div class="col-md-2">
              <label for="validationDefault04" class="mb-0">Transmission</label><br/>
              <select name="transmission" id="transmission" class="form-control"  style="text-transform: uppercase ">
                <option value="null">~~SELECT~~</option>
                <?php $trans_query = get($dbc,"transmission WHERE transmission_sts = '1' LIMIT 2");
                while($r_trans = mysqli_fetch_assoc($trans_query)): ?>
                <option value="<?=$r_trans['transmission_name']?>" style="text-transform: uppercase!important;"><?=$r_trans['transmission_name']?></option>
                <?php endwhile ?>
              </select>
            </div>
          <!-- </div>
        </div> -->
        <div class="col-md-2">
          <label class="m-0" for="validationDefault04">Stock ID</label><br/>
          <input type="text" name="stockid" class="form-control" placeholder="Stock id">
        </div>
        <div class="col-md pt-5" style="text-align: left">
          <div class="form-group">
            <div class="form-check">
              <div class="row mt-0 pt-1">
                <div class="col">
                  <input class="form-check-input" type="checkbox" name="discount" value="discount" id="invalidCheck2" >
                  <label class="m-0" class="form-check-label" for="invalidCheck2">
                    Discounted Cars
                  </label>
                </div>
                <div class="col">
                  <input class="form-check-input" type="checkbox" name="new" value="new" id="invalidCheck2" >
                  <label class="m-0" class="form-check-label" for="invalidCheck2">
                    New Arrivals
                  </label>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <div class="col-md-12 text-right pb-1">
          <button class="btn btn-primary" style="padding: 3px 5px !important;" type="submit"><span class="mr-2 glyphicon glyphicon-search "></span>Search</button>
          <!-- <div class="p-1" style="font-size: 12px;"> -->
            <a href="advancesearch.php?type=stock" class="btn btn-primary" style="color: white;padding: 3px 5px;">
              <span class="mr-1 glyphicon glyphicon-search "></span>Advance Search
            </a>
          <!-- </div> -->
        </div>
        <!-- <div class="col-md-3 pt-2 text-right" style="">
        </div> -->
      </div>
      
      
    </form>
    </div><!-- main -->
  </div>
</div>
<style>
.select2-container .select2-selection--single {
height: 100% !important;
}
</style>
<script>
function loadChassis(vehicle_brand) {
$.ajax({
url:'php_action/custom_action.php',
type:"POST",
data:{vehicle_brand1 : vehicle_brand},
dataType:"json",
success:function(response) {
console.log(response)
var fucked = "<option>~~SELECT~~</option>";
$.each(response, function (index, value) {
fucked += '<option class="text-capitalize" style="text-transform: uppercase!important;" value="'+value['model_id']+'">'+value['model_name']+'</option>';
});
$("#vehicle_chassis_code").empty().append(fucked);
}
});
$.ajax({
url:'php_action/custom_action.php',
type:"POST",
data:{vehicle_brand_m3 : vehicle_brand},
dataType:"json",
success:function(response) {
console.log(response);
if (response.sts==1) {
$("#vehicle_m3").val(response.m3);
$("#vehicle_length").prop("readonly",true);
$("#vehicle_width").prop("readonly",true);
$("#vehicle_height").prop("readonly",true);
$("#vehicle_length").prop("required",false);
$("#vehicle_width").prop("required",false);
$("#vehicle_height").prop("required",false);
$("#vehicle_length").val('0');
$("#vehicle_width").val('0');
$("#vehicle_height").val('0');
}
if (response.sts==0) {
$("#vehicle_m3").val('');
$("#vehicle_length").val('0');
$("#vehicle_width").val('0');
$("#vehicle_height").val('0');
$("#vehicle_length").prop("readonly",false);
$("#vehicle_width").prop("readonly",false);
$("#vehicle_height").prop("readonly",false);
$("#vehicle_length").prop("required",true);
$("#vehicle_width").prop("required",true);
$("#vehicle_height").prop("required",true);
}

}
});
}
</script>