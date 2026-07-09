<style>
  .sidebar-section-header {
    margin: 0 0 1rem 0 !important;
    padding: 0.25rem 1rem;
    background: #000;
    color: #fff;
    text-align: center;
    font-weight: 700;
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
      "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    font-size: 1rem !important;
    line-height: 1.5 !important;
    border-radius: 0.125rem;
  }

  .sidebar-quick-search {
    background: linear-gradient(to bottom, #ff4d3d, #e72a1a);
border: 1px solid #c61d10;
    padding: 12px 10px 14px;
    margin-bottom: 15px;
    margin-top: 16px;
  }

  .sidebar-quick-search .form-control {
    font-size: 13px;
    height: 32px;
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #999;
  }

  .sidebar-quick-search label {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 3px;
    color: #333;
  }

  .sidebar-year-row {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .sidebar-year-row .form-control {
    flex: 1;
  }

  .sidebar-year-sep {
    font-weight: bold;
    color: #333;
    line-height: 32px;
  }

  .sidebar-search-btn {
    background-color: #1a73e8;
    border-color: #1a73e8;
    color: #fff;
    font-weight: 600;
    padding: 6px 30px;
    border-radius: 4px;
    margin-top: 8px;
  }

  .sidebar-search-btn:hover {
    background-color: #1558b0;
    border-color: #1558b0;
    color: #fff;
  }

  .sidebar-fb-section {
    margin-bottom: 15px;
  }

  .sidebar-fb-content {
    border: 1px solid #ddd;
    border-top: none;
    padding: 10px;
    background: #fff;
  }


  /* ================================
   Sidebar Responsive Design
================================ */

.sidebar-quick-search-wrap,
.sidebar-fb-section {
    width: 100%;
    overflow: hidden;
}

/* Search box */
.sidebar-quick-search {
    width: 100%;
    box-sizing: border-box;
}

.sidebar-quick-search form {
    width: 100%;
}

.sidebar-quick-search .form-control {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}


/* Facebook responsive */
.sidebar-fb-content {
    width: 100%;
    overflow: hidden;
}

.fb-page,
.fb-page span,
.fb-page iframe {
    max-width: 100% !important;
    width: 100% !important;
}


/* Year dropdown responsive */
.sidebar-year-row {
    display: flex;
    width: 100%;
}

.sidebar-year-row .form-control {
    min-width: 0;
    width: 100%;
}


/* Button */
.sidebar-search-btn {
    width: 100%;
    max-width: 200px;
}


/* ================================
   Tablet
================================ */
@media (max-width: 991px) {

    .sidebar-section-header {
        font-size: 15px;
        padding: 8px 10px;
    }

    .sidebar-quick-search {
        padding: 10px;
    }

    .sidebar-quick-search .form-control {
        font-size: 12px;
        height: 34px;
    }

    .sidebar-search-btn {
        padding: 7px 25px;
    }
}


/* ================================
   Mobile
================================ */
@media (max-width: 576px) {

    .sidebar-section-header {
        font-size: 14px;
        margin-bottom: 10px !important;
        padding: 7px 8px;
    }


    .sidebar-quick-search {
        padding: 10px 8px;
        margin-top: 10px;
    }


    .sidebar-quick-search .form-control {
        height: 36px;
        font-size: 13px;
    }


    /* Year fields stack nicely */
    .sidebar-year-row {
        gap: 5px;
    }


    .sidebar-year-sep {
        font-size: 14px;
        line-height: 36px;
    }


    .sidebar-search-btn {
        width: 100%;
        max-width: none;
        margin-top: 5px;
        font-size: 14px;
    }


    /* Facebook button */
    .sidebar-fb-content {
        padding: 8px;
    }


    .sidebar-fb-content .btn {
        width: 100%;
        font-size: 13px;
    }


    /* Prevent Facebook iframe overflow */
    .fb-page,
    .fb-page iframe,
    .fb-page span {
        width: 100% !important;
        min-width: 100% !important;
    }

}


/* ================================
   Very Small Devices
================================ */
@media (max-width: 360px) {

    .sidebar-section-header {
        font-size: 13px;
    }


    .sidebar-quick-search .form-control {
        font-size: 12px;
        height: 34px;
    }


    .sidebar-year-row {
        flex-direction: column;
    }


    .sidebar-year-sep {
        display: none;
    }

}
</style>

<!-- Quick Search -->
<div class="sidebar-quick-search-wrap mb-3">
  <h4 class="sidebar-section-header">Quick Search</h4>
  <div class="sidebar-quick-search">
    <form method="get" action="advancesearch.php">
      <input type="hidden" name="advance" value="gs">

      <div class="form-group mb-2">
        <!-- <label for="sidebar_makers">Make:</label> -->
        <select class="form-control" name="maker" id="sidebar_makers" onchange="sidebarLoadBrands(this.value)">
          <option value="null">Make:</option>
          <?php $q = get($dbc, "maker WHERE maker_sts = '1' ORDER BY maker_name ASC");
          while ($r = mysqli_fetch_assoc($q)): ?>
            <option value="<?= $r['maker_id'] ?>"><?= $r['maker_name'] ?></option>
          <?php endwhile ?>
        </select>
      </div>

      <div class="form-group mb-2">
        <!-- <label for="sidebar_model">Model:</label> -->
        <select class="form-control" name="brands" id="sidebar_model" onchange="sidebarLoadChassis(this.value)">
          <option value="null">Model:</option>
        </select>
      </div>

      <div class="form-group mb-2">
        <!-- <label for="sidebar_vehicle_chassis_code">Code:</label> -->
        <select name="vehicle_chassis_code" id="sidebar_vehicle_chassis_code" class="form-control"
          style="text-transform: uppercase;">
          <option value="null">Code:</option>
        </select>
      </div>

      <div class="form-group mb-2">
        <!-- <label for="sidebar_options">Steering:</label>   -->
        <select name="options" id="sidebar_options" class="form-control" style="text-transform: uppercase;">
          <option value="null">Steering:</option>
          <?php $st_query = get($dbc, "options WHERE option_sts = '1'");
          while ($st_r = mysqli_fetch_assoc($st_query)): ?>
            <option value="<?= $st_r['option_name'] ?>" style="text-transform: uppercase!important;">
              <?= $st_r['option_name'] ?>
            </option>
          <?php endwhile ?>
        </select>
      </div>

      <div class="form-group mb-2">
        <!-- <label>Year:</label> -->
        <div class="sidebar-year-row">
          <select class="form-control" name="min_year" id="sidebar_min_year">
            <option value="null">Year:</option>
            <?php $date = date('Y');
            for ($i = $date; $i >= 1920; $i--): ?>
              <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor ?>
          </select>
          <span class="sidebar-year-sep">~</span>
          <select class="form-control" name="max_year" id="sidebar_max_year">
            <option value="null">Year:</option>
            <?php for ($i = $date; $i >= 1920; $i--): ?>
              <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor ?>
          </select>
        </div>
      </div>

      <div class="text-center">
        <button class="btn sidebar-search-btn" type="submit">Search</button>
      </div>
    </form>
  </div>
</div>

<!-- <div class="card">
  <div class="card-body" align="center">
    <h4 class="card-title">Customer Reviews</h4>
    <p class="card-text">Our Satisfaied Customer Reviews </p>

    <?php
    $sql = mysqli_query($dbc, "SELECT * FROM customer_reviews LIMIT  1");
    while ($review = mysqli_fetch_assoc($sql)):
      ?>

      <img class="card-img img img-responsive" src="admin/img/reviews/<?= $review['review_img'] ?>"
        style="width: 200px"><br />
      <h3>
        <?= $review['review_title'] ?>
      </h3>
      <p>
        <?= $review['review_text'] ?>
      </p>

      <?php

    endwhile;
    ?>

    <a href="#" class="card-link btn btn-primary">Add your review</a>
    <a href="#" class="card-link btn btn-primary mt-2">All Reviews</a>
  </div>
</div> -->

<!-- Facebook Page -->
<div class="sidebar-fb-section" align="center">
  <h4 class="sidebar-section-header">Facebook Page</h4>

  <!-- <div class="sidebar-fb-content">
    <div id="fb-root"></div>

    <script async defer crossorigin="anonymous"
      src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v7.0&appId=281789882030150&autoLogAppEvents=1"
      nonce="cyenlrTN">
      </script>

    <div class="fb-page" data-href="https://www.facebook.com/nexcojapan/" data-tabs="timeline" data-width=""
      data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false"
      data-show-facepile="true">

      <blockquote cite="https://www.facebook.com/nexcojapan/" class="fb-xfbml-parse-ignore">
        <a href="https://www.facebook.com/nexcojapan/">nexcojapan</a>
      </blockquote>

    </div>

    <hr />

    <a href="https://www.facebook.com/nexcojapan/" class="card-link btn btn-primary mb-2" target="_blank">
      Check Our Fb Page
    </a>

  </div> -->
</div>

<!-- <div class="card">
  <div class="card-body">
    <h4 class="card-title text-center">Like </h4>

    <img src="admin/img/web/revo.jpg" class="img img-responsive" />

    <hr />
    <img src="admin/img/web/usedcar.jpg" class="img img-responsive" />
  </div>
</div> -->

<script>
  function sidebarLoadBrands(makers) {
    $.ajax({
      url: 'php_action/custom_action1.php',
      type: "POST",
      data: { makers: makers },
      dataType: "json",
      success: function (response) {
        var options = '<option value="null">Model</option>';
        $.each(response, function (index, value) {
          options += '<option class="text-capitalize" value="' + value['brand_id'] + '">' + value['brand_name'] + '</option>';
        });
        $("#sidebar_model").empty().append(options);
        $("#sidebar_vehicle_chassis_code").empty().append('<option value="null">Code</option>');
      }
    });
  }

  function sidebarLoadChassis(vehicle_brand) {
    $.ajax({
      url: 'php_action/custom_action.php',
      type: "POST",
      data: { vehicle_brand1: vehicle_brand },
      dataType: "json",
      success: function (response) {
        var options = '<option value="null">Code</option>';
        $.each(response, function (index, value) {
          options += '<option class="text-capitalize" style="text-transform: uppercase!important;" value="' + value['model_id'] + '">' + value['model_name'] + '</option>';
        });
        $("#sidebar_vehicle_chassis_code").empty().append(options);
      }
    });
  }
</script>