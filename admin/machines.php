 <?php 
include_once "includes/header.php";
include_once "inc/code.php";

?>
<!-- start page content -->
            <div class="page-content-wrapper">
                <div class="page-content">
                   
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header card-bg" align="center"><h4>Machines</h4></div>
            <div class="card-body">
              <form action="php_action/inner_action.php" method="POST" role="form" id="formDataIQ">
                        <?php 

if (isset($_GET['machine_id'])) {
   @$id =$_GET['machine_id'];
     $q = mysqli_query($dbc,"SELECT * FROM machines WHERE machine_id='$id' ");

      $PartDe= mysqli_fetch_assoc($q);

    
}else{
  $q = mysqli_query($dbc,"SELECT machine_id FROM machines ORDER BY machine_id DESC");

      $id = mysqli_num_rows($q)+1;
}
      ?>

      <div class="vehicel_main_form">

  <input type="hidden" value="<?=@$_GET['machine_id']?>" class="vehicle_idMain"  name="machine_id">
    <input type="hidden" value="<?=@$id?>" class="vehicle_idMain"  name="vehicle_idMain">


  <div class="row form-group">

    <div class="col-sm-2">
       <label for="">Stock ID</label>      
            <select tabindex="1" name="machine_stock_idp" id="machine_stock_id" class="form-control" required> 
                <option <?=@($PartDe['machine_stock_id']=="HX-2022")?"selected":""?> value="HX-2022">HX-2022</option>   

                <option <?=@($PartDe['machine_stock_id']=="HS-2022")?"selected":""?> value="HS-2022">HJ-2022</option>   

                <option <?=@($PartDe['machine_stock_id']=="HT-2022")?"selected":""?> value="HT-2022">HD-2022</option>  

                <option <?=@($PartDe['machine_stock_id']=="HL-2022")?"selected":""?> value="HL-2022">NL-<?=date('y')?></option>  

            </select>
    </div><!-- col -->
    <div class="col-sm-3">
        <label for="">Maker</label>     

        <select tabindex="2" name="machine_maker" onchange="loadBrands(this.value)" id="machine_maker" class="form-control abcCustomNew vehicle_maker" required="required">

          <option value="">~~SELECT~~</option>

          <?php $q = get($dbc,"maker WHERE maker_sts = '1' ORDER BY maker_name ASC");

          while($r = mysqli_fetch_assoc($q)): ?>

            <option <?=@($PartDe['machine_maker']==$r['maker_id'])?"selected":""?> value="<?=$r['maker_id']?>"><?=strtoupper($r['maker_name'])?></option>

              <?php endwhile ?>

        </select>
    </div>
    <div class="col-sm-3">


        <label for="">Brand</label>     

        <select tabindex="3" name="machine_brand" onchange="loadChassis(this.value)" id="vehicle_brand" class="form-control fuckJS vehicle_brand" required="required">

         

          

          <?php
            if (isset($_GET['machine_id'])):
           $q = get($dbc,"brands WHERE brand_id = ".$PartDe['machine_brand']." ");

        $br = mysqli_fetch_assoc($q);?>

            <option  value="<?=$br['brand_id']?>"><?=$br['brand_name']?></option>

              <?php endif; ?>
              <option value="">~~SELECT~~</option>

        </select>

      
    </div>
    <div class="col-sm-2">
        <label for="">Machine Type</label>     

        <input type="text" name="machine_type" id="machine_type" class="form-control form-control-sm machine_type" value="<?=@$PartDe['machine_type']?>">
    </div>
    <div class="col-sm-2">

        <label for="">Hours</label>

        <input  name="machine_hours" id="machine_hours" class="form-control" type="number" min="0"> 
<!-- 

        <select  name="machine_cc" id="machine_cc" class="form-control" required="required">

         <option value="">Select</option>

          <?php $q = get($dbc,"cc WHERE cc_sts = '1'");

        //  while($r = mysqli_fetch_assoc($q)): ?>

            <option <?=@($PartDe['machine_cc']==$r['cc_name'])?"selected":""?> value="<?=$r['cc_name']?>"><?=$r['cc_name']?></option>

          <?php// endwhile ?>-->

        </select>     

      </div>
</div> <!-- end of row -->
<div class="row">
  <div class="col-sm-2">
        <label for="">Part No.</label>     
        <input type="text" value="<?=@$PartDe['part_no']?>" name="part_no" id="part_no" class="form-control form-control-sm part_no">
  </div>
  <div class="col-sm-3">
        <label for="">Color</label>
        <input  name="machine_color" value="<?=@$PartDe['machine_color']?>"  id="machine_color" class="form-control">
  </div>
  <div class="col-sm-3">
        <label for="">Year</label>      
        <select  name="machine_year" id="machine_year" class="form-control machine_reg_month" required="required" onchange="validateyears()">
          <option value="">~~SELECT~~</option>
          <?php

            $date = date('Y');

            for ($i = $date; $i >= 1900; $i--) {?>

              <option <?=@($PartDe['machine_year']==$i)?"selected":""?> value="<?=$i?>"><?=$i?></option>

            <?php

              } 

              ?>

        </select>
  </div>
  <div class="col-sm-2">

        <label for="">Manufacture Year.</label>      
        <select  name="machine_manu_year" id="machine_manu_year" class="form-control vehicle_reg_month" required="required" onchange="validateyears()">

          <option value="">~~SELECT~~</option>

          <?php

            $date = date('Y');

            for ($i = $date; $i >= 1900; $i--) {?>

              <option <?=@($PartDe['machine_manu_year']==$i)?"selected":""?> value="<?=$i?>"><?=$i?></option>

            <?php

              } 

              ?>

        </select>

      </div>
      <div class="col-sm-2">
        

        <label for="">Serial Number</label>

        <input  value="<?=@$PartDe['machine_serial_no']?>" name="machine_serial_no" id="machine_serial_no" class="form-control" autocomplete="off">

      
      </div>
</div><!-- end of row -->

  <div class="row">
    <div class="col-sm-2">
        <label for="">Weight</label>
        <input  value="<?=@$PartDe['machine_weight']?>" name="machine_weight" id="machine_weight" class="form-control" autocomplete="off">
    </div>
    <div class="col-sm-3">
        <label for="">Fuel</label>
        <select  list="machine_fuel1" name="machine_fuel" id="machine_fuel" class="form-control" >

          <option value="">~~SELECT~~</option>

          <?php  $q = get($dbc,"fuel WHERE fuel_sts = '1'");

          while($r = mysqli_fetch_assoc($q)): ?>

            <option <?=@(strtolower($PartDe['machine_fuel'])==strtolower($r['fuel_name']))?"selected":""?> value="<?=$r['fuel_name']?>"><?=$r['fuel_name']?></option>

          <?php endwhile ?>

        </select>     

      
    </div>
    <div class="col-sm-3">
      
      
        <label for="">FOB Price</label>

        <input  value="<?=@$PartDe['machine_fob_price']?>" name="machine_fob_price" id="machine_fob_price" class="form-control" autocomplete="off" required >

    
    </div>
     <div class="col-sm-2">
        <label for="">Steering</label>
       
         <select  name="machine_steering" id="machine_steering" class="form-control" >

          <option value="">Select</option>

          <?php $q = get($dbc,"options WHERE option_sts = '1'");

              while($r = mysqli_fetch_assoc($q)): ?>

            <option <?=(strtoupper(@$PartDe['machine_steering'])==strtoupper($r['option_name']))?"selected":""?> value="<?=strtoupper($r['option_name'])?>"><?=$r['option_name']?></option>

          <?php endwhile ?>

        </select>
    </div>
    <div class="col-sm-2 m-0 p-0">
        <label for="">L x W x H (M3)</label><br>
        <input placeholder="L" style="width: 30% !important; display: inline-block; "  value="<?=@$PartDe['machine_l']?>" name="machine_l" id="machine_l" class="form-control m-0 p-0" autocomplete="off">
        <input  placeholder="W" style="width: 30% !important; display: inline-block; "  value="<?=@$PartDe['machine_w']?>" name="machine_w" id="machine_w" class="form-control m-0 p-0" autocomplete="off">
        <input  placeholder="H" style="width: 30% !important; display: inline-block; "  value="<?=@$PartDe['machine_h']?>" name="machine_h" id="machine_h" class="form-control m-0 p-0" autocomplete="off">
    </div>
  </div><!-- mian -->


  <div class="row">
    <div class="col-sm-4">
        <label for="">Drive </label>
        <input  value="<?=@$PartDe['machine_drive']?>" name="machine_drive" id="machine_drive" class="form-control" autocomplete="off" required >
    </div>
    <div class="col-sm-4">
        <label for="">Transmission</label>
       <input  value="<?=@$PartDe['machine_transmission']?>" name="machine_transmission" id="machine_transmission" class="form-control" autocomplete="off" required >
    </div>
     <div class="col-sm-4">
        <label for="">Condition</label>
       <input  value="<?=@$PartDe['machine_condition']?>" name="machine_condition" id="machine_condition" class="form-control" autocomplete="off" required >
    </div>
  </div><!-- row -->


  <div class="row">
    <div class="col-sm-6">
        <label for="">Parts Description</label>
        <textarea name="machine_note" placeholder="Parts Description" id="machine_note" class="form-control" rows="2"><?=@$PartDe['machine_note']?></textarea>
    </div>
    <div class="col-sm-6">
        <label for="">Condition Remarks</label>
        <textarea name="machine_condition_remarks" placeholder="Condition Remarks" id="machine_condition_remarks" class="form-control" rows="2"><?=@$PartDe['machine_condition_remarks']?></textarea>
    </div>
  </div><!-- row -->

  <div class="row mt-2">
    <div class="col-sm-10"></div>
    <div class="col-sm-2 ">
      <button class="btn btn-admin float-right" id="formDataIQ_btn" type="submit">Submit</button>
    </div>
  </div><!-- row -->

              </form>
               <label class="mt-3">Upload Parts Images</label>
  <form action="php_action/custom_action.php" class="dropzone " id="dropzoneFrom" method="post" enctype="multipart/form-data">

<input type="text" value="<?=@$id?>"  class="machine_id d-none" name="machine_id" id="machine_id">
    <input type="text" name="images_get" class="machine_id d-none"  value="machine">

   <div class="fallback">
    <input name="file[]" type="file" multiple / >
  </div>
</form>
<div class="row">
  <div class="col-sm-6">
     <button type="button" class="btn btn-success btn-sm float-right" id="reloadimg" onclick="reloaded()">Reload</button>
  </div>
  <div class="col-sm-4">
    
 

  </div>
</div>
              </div>
            </div>
          </div>
  <ul class="row imageGallery list-unstyled" id="post_list">

  </ul>
            

  <script type="text/javascript">
    function reloaded(){
      var id = $("#machine_id").val();

    
     // $("#imageGallery").load(" #imageGallery > *");
      loadImageGallery(id,'machine');
    }
  </script>
  </div></div>
<?php
include_once "includes/footer.php";
?>