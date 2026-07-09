      <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
        <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
          <i class="fe fe-x"><span class="sr-only"></span></i>
        </a>
        <nav class="vertnav navbar navbar-light">
          <!-- nav bar -->
          <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="index.php">
            <img src="img/logo/<?=@$get_company['logo']?>" class="img-fluid" alt="" style="height: 120px;">
          </a>
          </div>

          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
              <a class="nav-link" href="index.php?nav=dashboard">
                <i class="fe fe-home fe-16"></i>
                <span class="ml-3 item-text">Dashboard</span>
              </a>
            </li>
          </ul>
           
          <p class="text-muted nav-heading mt-4 mb-1">
            <span>Components</span>
          </p>

         <ul class="navbar-nav flex-fill w-100 mb-2">
<?php       
   if ($fetch_globeluser['user_role']!='admin') {

        $getNav = mysqli_query($dbc,"SELECT * FROM menus where parent_id=0 AND page!='dashboard.php' ORDER BY sort_order ASC LIMIT 9 OFFSET 0 ");    $r=1;
          while ($fetch_nav=mysqli_fetch_assoc($getNav)) {   $c=0;
             $getChild = mysqli_query($dbc,"SELECT * FROM menus where parent_id='".$fetch_nav['id']."' AND page!='dashboard.php' ");
                while ($child=mysqli_fetch_assoc($getChild)) {
                    if (countWhens($dbc,"privileges",'user_id',$user_id_current,'nav_id',$child['id'])>0) {
                                        $c++;
                                         }}
                  if ($c>0 && $r<9) {
                                    ?>
            <li class="nav-item dropdown">
              <a href="#ui-elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                <i class="fe fe-box fe-16"></i>
                <span class="ml-3 item-text"><?=strtoupper($fetch_nav['title'])?></span>
              </a>
 <?php if (countWhen($dbc,"menus",'parent_id',$fetch_nav['id'])>0) { ?>

              <ul class="collapse list-unstyled pl-4 w-100" id="ui-elements">
                       <?php 
                                    $getChild = mysqli_query($dbc,"SELECT * FROM menus where parent_id='".$fetch_nav['id']."' AND page!='dashboard.php' ");
                                 while ($child=mysqli_fetch_assoc($getChild)) {
                                     if (countWhens($dbc,"privileges",'user_id',$user_id_current,'nav_id',$child['id'])>0) {
                                     ?>
                <li class="nav-item">
                  <a class="nav-link pl-3" href="<?=$child['page']?>"><span class="ml-1 item-text"><?=strtoupper($child['title'])?></span>
                  </a>
                </li>
                  <?php } 
                                  }//end while child ?>
                                   <?php  } } }  }//check statement ?>
                                   <?php       
   if ($fetch_globeluser['user_role']=='admin') {
        $getNav = mysqli_query($dbc,"SELECT * FROM menus where parent_id=0 AND page!='dashboard.php' ORDER BY sort_order ASC  ");    $r=1;
          while ($fetch_nav=mysqli_fetch_assoc($getNav)) {   $c=0;
             $getChild = mysqli_query($dbc,"SELECT * FROM menus where parent_id='".$fetch_nav['id']."' AND page!='dashboard.php' ");
                while ($child=mysqli_fetch_assoc($getChild)) {
                   
                                        $c++;
                                         }
                  if ($c>0) {
                                    ?>
            <li class="nav-item dropdown">
              <a href="#ui<?=$fetch_nav['id']?>" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                <i class="fe fe-box fe-16"></i>
                <span class="ml-3 item-text"><?=strtoupper($fetch_nav['title'])?></span>
              </a>
 <?php if (countWhen($dbc,"menus",'parent_id',$fetch_nav['id'])>0) { ?>

              <ul class="collapse list-unstyled pl-4 w-100" id="ui<?=$fetch_nav['id']?>">
                       <?php 
                                    $getChild = mysqli_query($dbc,"SELECT * FROM menus where parent_id='".$fetch_nav['id']."' AND page!='dashboard.php' ");
                                 while ($child=mysqli_fetch_assoc($getChild)) {
                               
                                     ?>
                <li class="nav-item">
                  <a class="nav-link pl-3" href="<?=$child['page']?>"><span class="ml-1 item-text"><?=strtoupper($child['title'])?></span>
                  </a>
                </li>
                  <?php }//end while child 
                 ?>
                                
               
              </ul>
              <?php } } ?>
            </li>
               <?php   }  }//check statement ?>
          </ul>
    
    
        </nav>
      </aside>