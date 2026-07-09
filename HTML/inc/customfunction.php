
<?php 
function getTotalCost($dbc,$data){
  //Vehicle Info
  $fright = 0;
  $bl = 0;
  $terminal = 0;
  $vehicle_info = fetchRecord($dbc, "vehicle_info", "vehicle_id", $data);
  $fright = $vehicle_info['vehicle_freight_charges'];
  $bl = $vehicle_info['vehicle_bl_charges'];
  $terminal = $vehicle_info['vehicle_terminal_charges'];
  $vehicle_info_total =  $fright + $bl + $terminal;

  //Auction Info
  $fee = 0;
  $win_price = 0;
  $recycle_fee = 0;
  $auction_info = fetchRecord($dbc, "auction_info", "vehicle_id", $data);
  $fee = $auction_info['auction_fee'];
  $win_price = $auction_info['auction_win_price'];
  $recycle_fee = $auction_info['auction_recycle_fee'];
  $auction_info_total = $fee + $win_price + $recycle_fee;

  //Auction Info
  $ricksu_fee = 0;
  $ricksu_repair = 0;
  $ricksu = fetchRecord($dbc, "ricksu", "vehicle_id", $data);
  $ricksu_fee = $ricksu['ricksu_fee'];
  $ricksu_repair = $ricksu['ricksu_repair_fee'];
  $ricksu_total = $ricksu_fee - $ricksu_repair;
  

  $repair_charges_tax = 0;
  $charges = 0;
  $inspection_info = fetchRecord($dbc, "inspection_info", "vehicle_id", $data);
  $repair_charges_tax = $inspection_info['inspection_info_repair_charges'];
  $charges = $inspection_info['inspection_info_charges'];
  $inspection_info_total = $repair_charges_tax + $charges;

  $airmail = fetchRecord($dbc, "airmail", "vehicle_id", $data);
  $airmail_courier =  $airmail['airmail_courier_charges'];
  
  $grandTotal = $vehicle_info_total + $auction_info_total + $ricksu_total + $ricksu_total + $airmail_courier;
  return $grandTotal;
}

function getTotalExpense($dbc,$data){
  $ttl = 0;
  $q = mysqli_query($dbc, "SELECT * FROM vehicle_expense WHERE vehicle_info_id = '$data'");
  while ($r = mysqli_fetch_assoc($q)) {
      $ttl += $r['vehicle_expense_amount'];
  }
  return $ttl;
}
