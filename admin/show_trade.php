<?php include_once "includes/header.php"; ?>

<!-- start page content -->

<style>
  .view {

    cursor: pointer;

  }

  .view:hove {

    border-bottom: 1px solid blue;

  }

  .edit {

    cursor: pointer;

  }

  /* Center SweetAlert buttons */
  .swal-footer {
    text-align: center !important;
  }

  /* Make buttons larger and spaced */
  .swal-button {
    min-width: 120px;
    font-weight: bold;
    padding: 10px 20px;
  }

  /* Cancel button styles */
  .swal-button--cancel {
    background-color: #6c757d;
    /* Bootstrap secondary gray */
    color: #fff;
    opacity: 1 !important;
    box-shadow: none !important;
  }

  /* Remove hover effect from Cancel button */
  .swal-button--cancel:hover {
    background-color: #6c757d !important;
    /* keep same color */
    color: #fff !important;
  }
</style>




<div class="card card-box">

  <div class=" card-header card-bg rounded-0" style="color: white">
    <h4 class="font-weight-bold text-white text-center">View Trade</h4>
  </div>

  <div class="card-body">

    <div class="container">

      <table class="table table-hover dataTable" id="example4">

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

          $x = 1;

          $q = get($dbc, "vehicle_info");

          while ($r = mysqli_fetch_assoc($q)):

            ?>

            <tr>

              <td><?= $x ?></td>

              <td>
                <?php if (@$userPrivileges['nav_edit'] == 1 || $fetchedUserRole == "admin"): ?>
                  <a style="color: black;" href="trade.php?vehicle_id=<?= $r['vehicle_id'] ?>">
                  <?php endif ?>

                  <br>

                  Brand Name : <?= fetchRecord($dbc, "brands", "brand_id", $r['vehicle_brand'])['brand_name'] ?> <br>

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
                    <a href="javascript:void(0);" class="dropdown-item deleteVehicleBtn"
                      data-id="<?= $r['vehicle_id'] ?>">
                      <i class="fa fa-trash mr-1"></i> Delete
                    </a>



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
          ?>
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            $(document).on('click', '.deleteVehicleBtn', function (e) {
              e.preventDefault();
              let vehicleId = $(this).data('id');
              let row = $(this).closest('tr'); // table row

              swal({
                title: "Are you sure?",
                text: "This will permanently delete the vehicle Info and its images!",
                icon: "warning",
                dangerMode: true,
                buttons: {
                  cancel: {
                    text: "Cancel",
                    value: false,
                    visible: true,
                    className: "btn btn-secondary mx-2", // Bootstrap gray
                    closeModal: true,
                  },
                  confirm: {
                    text: "Yes, Delete!",
                    value: true,
                    visible: true,
                    className: "btn btn-danger mx-2", // Bootstrap red
                    closeModal: false
                  }
                }
              }).then((willDelete) => {
                if (willDelete) {
                  $.ajax({
                    url: 'php_action/vehicle_delete.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { vehicle_id: vehicleId },
                    success: function (response) {
                      if (response.success) {
                        swal("Deleted!", response.message, "success")
                          .then(() => {
                            row.remove(); // or use location.reload();
                          });
                      } else {
                        swal("Error!", response.message, "error");
                      }
                    },
                    error: function () {
                      swal("Error!", "Something went wrong. Please try again.", "error");
                    }
                  });
                }
              });
            });
          </script>


        </tbody>

      </table>

    </div>

  </div>

</div>




<!-- <a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Trigger modal</a> -->

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

  <?php include_once "includes/footer.php"; ?>