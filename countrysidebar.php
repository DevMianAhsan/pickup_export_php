<div class="card">
  <div class="card-body" >
    <h4 class="card-title" style="border-bottom: 1px solid">Search By Types</h4>

  	<span class="card-text">
        <?php
                    $sql = mysqli_query($dbc,"SELECT * FROM countries ORDER BY country_name ASC");
                      while($country=mysqli_fetch_assoc($sql)):
                                ?>
          <p style="margin-top: 10px!important">
             <a href="country_info.php?country_code=<?=$country['country_code']?>&country=<?=$country['country_id']?>&countryname=<?=$country['country_name']?>">
                <img src="assets/images/flags/<?=strtolower($country['country_code'])?>.svg" alt="img" style="width: 25px"  >
                
            <span><?=$country['country_name']?></span><br/>
            </a>


           <!--  <a href="search.php?body_type=<?=$maker['body_type_id']?>&?body_type_name=<?=$maker['body_type_name']?>">
            <img src="admin/img/vehicles_images/<?=$maker['body_type_img']?>" style="width: 50px" / >
            <span><?=$maker['body_type_name']?></span><br/>
            </a> -->
          </p>                                
                                <?php
                              endwhile;
                                ?>
      </span>
                  
   								
  </div>
</div>