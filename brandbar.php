<div class="sidebar-card">

  <div class="card-title">
    Search By Make
  </div>

  <div class="card-body">

    <ul class="sidebar-list">

      <?php
      $sql = mysqli_query($dbc, "
                SELECT *
                FROM maker
                ORDER BY show_order DESC
                LIMIT 10
            ");

      while ($maker = mysqli_fetch_assoc($sql)):
        ?>

        <li>
          <a href="advancesearch.php?advance=s&maker=<?= $maker['maker_id'] ?>">

            <img src="admin/img/vehicles_images/<?= $maker['maker_img'] ?>" alt="<?= $maker['maker_name'] ?>">

            <span>
              <?= strtoupper($maker['maker_name']) ?>
            </span>

          </a>
        </li>

      <?php endwhile; ?>

    </ul>

  </div>

  <a href="widgets.php?category=maker" class="sidebar-btn">
    More Makes >
  </a>

</div>
<div class="sidebar-card">

  <div class="card-title">
    Search By Types
  </div>

  <div class="card-body">

    <ul class="sidebar-list">

      <?php
      $q = get($dbc, "body_type WHERE body_type_sts='1' LIMIT 10");

      while ($r = mysqli_fetch_assoc($q)):
        ?>

        <li>
          <a href="advancesearch.php?advance=s&body_type=<?= $r['body_type_id'] ?>">
            <img src="admin/img/vehicles_images/<?= $r['body_type_img'] ?>">
            <span><?= $r['body_type_name'] ?></span>
          </a>
        </li>

      <?php endwhile; ?>

    </ul>

  </div>

  <a href="widgets.php?category=bodytype" class="sidebar-btn">
    More Types >
  </a>

</div>

<div class="sidebar-card">

  <div class="card-title">
    Search By Price
  </div>

  <div class="card-body">

    <ul class="sidebar-list">

      <li><a
          href="advancesearch.php?advance=s&min_price=0&max_price=500"><span>Under
            $500</span></a></li>

      <li><a
          href="advancesearch.php?advance=s&min_price=500&max_price=1000"><span>$500
            - $1,000</span></a></li>

      <li><a
          href="advancesearch.php?advance=s&min_price=1000&max_price=1500"><span>$1,000
            - $1,500</span></a></li>

      <li><a
          href="advancesearch.php?advance=s&min_price=1500&max_price=2000"><span>$1,500
            - $2,000</span></a></li>

      <li><a
          href="advancesearch.php?advance=s&min_price=2000&max_price=2500"><span>$2,000
            - $2,500</span></a></li>

      <li><a
          href="advancesearch.php?advance=s&min_price=2500&max_price=4000"><span>$2,500
            - $4,000</span></a></li>

      <li><a
          href="advancesearch.php?advance=s&min_price=4000&max_price=50000000"><span>Over
            $4,000</span></a></li>

    </ul>

  </div>

</div>
<div class="sidebar-card">

  <div class="card-title">
    Other Categories
  </div>

  <div class="card-body">

    <ul class="sidebar-list">

      <?php
      $getfuel = mysqli_query($dbc, "SELECT * FROM fuel ORDER BY fuel_name ASC");

      while ($qbc = mysqli_fetch_assoc($getfuel)):
        ?>

        <li>
          <a href="advancesearch.php?advance=s&fuel_type=<?= $qbc['fuel_name'] ?>">
            <span><?= $qbc['fuel_name'] ?></span>
          </a>
        </li>

      <?php endwhile; ?>

    </ul>

  </div>

</div>


<div class="sidebar-card">

  <div class="card-title">
    Country Type
  </div>

  <div class="card-body">

   <ul class="sidebar-list">
    <?php
    // Show 10 countries that actually have vehicles
    $sqlCountries = mysqli_query($dbc, "
        SELECT DISTINCT c.country_id, c.country_name 
        FROM countries c 
        INNER JOIN vehicle_info v ON v.country_id = c.country_id 
        ORDER BY c.country_name ASC 
        LIMIT 10
    ");

    while ($country = mysqli_fetch_assoc($sqlCountries)):
    ?>
        <li>
            <a href="advancesearch.php?advance=s&country=<?= $country['country_id'] ?>">
                <span><?= htmlspecialchars($country['country_name']) ?></span>
            </a>
        </li>
    <?php endwhile; ?>
</ul>

  </div>

</div>
<style>
  /* =====================================
   SIDEBAR CARD
===================================== */

  .sidebar-card {
    background: #fff;
    border: 1px solid #ddd;
    margin-bottom: 20px;
    overflow: hidden;
    box-shadow: none;
  }

  /* Header */

  .sidebar-card .card-title {
    margin: 0 0 1rem 0 !important; /* mb-3 */
    padding: 0.25rem 1rem;         /* py-1 px-4 */
    background: #000;              /* bg-black */
    color: #fff;                   /* text-white */
    text-align: center;            /* text-center */
    font-weight: 700;              /* font-bold */
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
                 "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; /* font-sans */
    font-size: 1rem;               /* 16px */
    line-height: 1.5;
    border-radius: 0.125rem;       /* rounded-sm */
}

  /* Body */

  .sidebar-card .card-body {
    padding: 0 !important;
    margin: 0 !important;
  }

  /* UL */

  .sidebar-list {
    list-style: none;
    margin: 0 !important;
    padding: 0 !important;
  }

  /* LI */

  .sidebar-list li {
    margin: 0 !important;
    padding: 0 !important;
    border-bottom: 1px solid #ececec;
  }

  .sidebar-list li:last-child {
    border-bottom: none;
  }

  /* LINK */

  .sidebar-list li a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #222;
    padding: 10px 15px;
    margin: 0 !important;
    transition: .2s;
  }

  .sidebar-list li a:hover {
    background: #f8f8f8;
    color: #0d6efd;
    text-decoration: none;
  }

  /* IMAGE */

  .sidebar-list img {
    width: 32px;
    height: 22px;
    object-fit: contain;
    margin-right: 12px;
    flex-shrink: 0;
  }

  /* TEXT */

  .sidebar-list span {
    font-size: 14px;
    font-weight: 500;
    color: #222;
  }

  /* Footer */

  .sidebar-btn {
    display: block;
    text-align: center;
    padding: 10px;
    border-top: 1px solid #ececec;
    text-decoration: none;
    color: #111;
    font-weight: 600;
    background: #fff;
  }

  .sidebar-btn:hover {
    background: #f7f7f7;
    color: #0d6efd;
    text-decoration: none;
  }

  /* Remove Bootstrap spacing */

  .sidebar-card h4,
  .sidebar-card p,
  .sidebar-card ul,
  .sidebar-card li {
    margin: 0 !important;
  }

  /* First item starts immediately below title */

  .sidebar-list li:first-child a {
    margin-top: 0 !important;
  }

  /* Prevent bootstrap card-body spacing */

  .card-body {
    padding: 0;
  }
</style>