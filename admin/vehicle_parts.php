 <?php 
include_once "includes/header.php";
include_once "inc/code.php";

?>
<!-- start page content -->
            <div class="page-content-wrapper">
                <div class="page-content">
                   
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header card-bg" align="center"><h4>Vehicle Parts</h4></div>
            <div class="card-body">
              <form action="php_action/inner_action.php" method="POST" role="form" id="formDataIQ">
                        <?php 

if (isset($_GET['part_id'])) {
   @$id =$_GET['part_id'];
     $q = mysqli_query($dbc,"SELECT * FROM vehicle_parts WHERE part_id='$id' ");

      $PartDe= mysqli_fetch_assoc($q);

    
}else{
  $q = mysqli_query($dbc,"SELECT part_id FROM vehicle_parts ORDER BY part_id DESC");
      @$id = mysqli_num_rows($q)+1;
}
      ?>

      <div class="vehicel_main_form">

  <input type="hidden" value="<?=@$_GET['part_id']?>" class="vehicle_idMain"  name="part_id">
    <input type="hidden" value="<?=@$id?>" class="vehicle_idMain"  name="vehicle_idMain">


  <div class="row form-group">

    <div class="col-sm-2">
       <label for="">Stock ID</label>      
            <select tabindex="1" name="part_stock_idp" id="part_stock_id" class="form-control" required> 
                <option <?=@($PartDe['part_stock_id']=="HX-2022")?"selected":""?> value="HX-2022">HX-2022</option>   

                <option <?=@($PartDe['part_stock_id']=="HS-2022")?"selected":""?> value="HS-2022">HJ-2022</option>   

                <option <?=@($PartDe['part_stock_id']=="HT-2022")?"selected":""?> value="HT-2022">HD-2022</option>  

                <option <?=@($PartDe['part_stock_id']=="HL-2022")?"selected":""?> value="HL-2022">NL-<?=date('y')?></option>  

            </select>
    </div><!-- col -->
    <div class="col-sm-3">
        <label for="">Maker</label>     

        <select tabindex="2" name="part_maker" onchange="loadBrands(this.value)" id="part_maker" class="form-control abcCustomNew vehicle_maker" >

          <option value="">~~SELECT~~</option>

          <?php $q = get($dbc,"maker WHERE maker_sts = '1' ORDER BY maker_name ASC");

          while($r = mysqli_fetch_assoc($q)): ?>

            <option <?=@($PartDe['part_maker']==$r['maker_id'])?"selected":""?> value="<?=$r['maker_id']?>"><?=strtoupper($r['maker_name'])?></option>

              <?php endwhile ?>

        </select>
    </div>
    <div class="col-sm-3">


        <label for="">Brand</label>     

        <select tabindex="3" name="part_brand" onchange="loadChassis(this.value)" id="vehicle_brand" class="form-control fuckJS vehicle_brand" >

         

          

          <?php
            if (isset($_GET['part_id'])):
           $q = get($dbc,"brands WHERE brand_id = ".$PartDe['part_brand']." ");

        $br = mysqli_fetch_assoc($q);?>

            <option  value="<?=$br['brand_id']?>"><?=$br['brand_name']?></option>

              <?php endif; ?>
              <option value="">~~SELECT~~</option>

        </select>

      
    </div>
    <div class="col-sm-2">
        <label for="">Chassis No.</label>     

        <input type="text" name="part_chassis_no" id="part_chassis_no" class="form-control form-control-sm part_chassis_no" value="<?=@$PartDe['part_chassis_no']?>">
    </div>
    <div class="col-sm-2">

        <label for="">Engine CC</label>

        <!-- <input list="vehicle_cc1" name="vehicle_cc" id="vehicle_cc" class="form-control" > -->

        <select list="vehicle_cc1" name="part_cc" id="part_cc" class="form-control" >

         <option value="">Select</option>

          <?php $q = get($dbc,"cc WHERE cc_sts = '1'");

          while($r = mysqli_fetch_assoc($q)): ?>

            <option <?=@($PartDe['part_cc']==$r['cc_name'])?"selected":""?> value="<?=$r['cc_name']?>"><?=$r['cc_name']?></option>

          <?php endwhile ?>

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
        <input  name="part_color" value="<?=@$PartDe['part_color']?>"  id="part_color" class="form-control">
  </div>
  <div class="col-sm-3">
        <label for="">Year</label>      
        <select  name="part_year" id="part_year" class="form-control part_reg_month"  onchange="validateyears()">
          <option value="">~~SELECT~~</option>
          <?php

            $date = date('Y');

            for ($i = $date; $i >= 1900; $i--) {?>

              <option <?=@($PartDe['part_year']==$i)?"selected":""?> value="<?=$i?>"><?=$i?></option>

            <?php

              } 

              ?>

        </select>
  </div>
  <div class="col-sm-2">

        <label for="">Manufacture Year.</label>      
        <select  name="part_manu_year" id="part_manu_year" class="form-control vehicle_reg_month"  onchange="validateyears()">

          <option value="">~~SELECT~~</option>

          <?php

            $date = date('Y');

            for ($i = $date; $i >= 1900; $i--) {?>

              <option <?=@($PartDe['part_manu_year']==$i)?"selected":""?> value="<?=$i?>"><?=$i?></option>

            <?php

              } 

              ?>

        </select>

      </div>
      <div class="col-sm-2">
        

        <label for="">Package</label>

        <input list="part_package1" value="<?=@$PartDe['part_package']?>" name="part_package" id="part_package" class="form-control" autocomplete="off">



        <datalist id="part_package1" >

          <option value="">~~SELECT~~</option>

            <?php  // $q = get($dbc,"package WHERE pack_sts = '1'");

            $q = mysqli_query($dbc,"SELECT DISTINCT(pack_name) FROM package WHERE pack_sts = '1' ");



            while($r = mysqli_fetch_assoc($q)): ?>

              <option <?=@($PartDe['part_package']==$r['pack_name'])?"selected":""?>
               value="<?=$r['pack_name']?>">
               <?=$r['pack_name']?>
                 
               </option>

            <?php endwhile ?>

        </datalist>     

      
      </div>
</div><!-- end of row -->

  <div class="row">
    <div class="col-sm-2">
      
        <label for="">KM</label>

        <input  value="<?=@$PartDe['part_km']?>" name="part_km" id="part_km" class="form-control" autocomplete="off">

    </div>
    <div class="col-sm-3">
        <label for="">Fuel</label>
        <select  list="part_fuel1" name="part_fuel" id="part_fuel" class="form-control" >

          <option value="">~~SELECT~~</option>

          <?php  $q = get($dbc,"fuel WHERE fuel_sts = '1'");

          while($r = mysqli_fetch_assoc($q)): ?>

            <option <?=@($PartDe['part_fuel']==$r['fuel_name'])?"selected":""?> value="<?=$r['fuel_name']?>"><?=$r['fuel_name']?></option>

          <?php endwhile ?>

        </select>     

      
    </div>
    <div class="col-sm-3">
      
      
        <label for="">FOB Price</label>

        <input  value="<?=@$PartDe['part_fob_price']?>" name="part_fob_price" id="part_fob_price" class="form-control" autocomplete="off" required >

    
    </div>
     <div class="col-sm-2">
        <label for="">Steering</label>
    
        <select  name="part_steering" id="part_steering" class="form-control" >

          <option value="">Select</option>

          <?php $q = get($dbc,"options WHERE option_sts = '1'");

              while($r = mysqli_fetch_assoc($q)): ?>

            <option <?=(strtoupper(@$PartDe['part_steering'])==strtoupper($r['option_name']))?"selected":""?> value="<?=strtoupper($r['option_name'])?>"><?=$r['option_name']?></option>

          <?php endwhile ?>

        </select>
    </div>
    <div class="col-sm-2">
        <label for="">Transmission</label>


        <select list="part_transmission"  name="part_transmission" id="vehicle_transmission" class="form-control">
          <option value="">Select</option>

          <?php $q = get($dbc,"transmission WHERE transmission_sts = '1'");
          while($r = mysqli_fetch_assoc($q)): ?>
            <option <?=@(ucwords($r['transmission_name'])==ucwords($PartDe['part_transmission']))?"selected":""?> value="<?=$r['transmission_name']?>"><?=$r['transmission_name']?></option>
              <?php endwhile ?>
        </select>
    </div>
  </div><!-- mian -->


  <div class="row">
    <div class="col-sm-5">
        <label for="">Parts Description</label>
        <textarea name="part_note" placeholder="Parts Description" id="part_note" class="form-control" rows="2"><?=@$PartDe['part_note']?></textarea>
    </div>
    <div class="col-sm-5">
        <label for="">Condition Remarks</label>
        <textarea name="part_condition_remarks" placeholder="Condition Remarks" id="part_condition_remarks" class="form-control" rows="2"><?=@$PartDe['part_condition_remarks']?></textarea>
    </div>
     <div class="col-sm-2">
        <label for="">Weight</label>
        <input  value="<?=@$PartDe['part_weight']?>" name="part_weight" id="part_weight" class="form-control" autocomplete="off">
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

<input type="text" value="<?=@$id?>"  class="part_id d-none" name="part_id" id="part_id">
    <input type="text" name="images_get" class="part_id d-none"  value="part">

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
      var id = $("#part_id").val();

    
     // $("#imageGallery").load(" #imageGallery > *");
      loadImageGallery(id,'part');
    }
  </script>
  </div></div>
<?php
include_once "includes/footer.php";
?>