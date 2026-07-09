<!-- Stocks Grouped by Country (Exact New Arrivals Style) -->
<style>
    .arrival-heading {
        margin: 0 0 1rem 0 !important;
        padding: 0.25rem 1rem;
        background: #b6bcc4;
        color: #000;
        font-weight: 700;
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
            "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.125rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    /* Main vehicle grid */
    .arrival-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    /* Vehicle card */
    .arrival-item {
        width: 100%;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    /* Uniform Image Container & Sizing */
    .arrival-item a {
        display: block;
        width: 100%;
    }

    .arrival-item img {
        width: 100%;
        aspect-ratio: 16 / 9; /* Forces images into identical dimensions */
        object-fit: cover;    /* Prevents stretching or squishing */
        display: block;
        border-radius: 4px;
    }

    /* Large screens */
    @media (min-width: 1200px) {
        .arrival-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    /* Medium screens (tablet/laptop) */
    @media (max-width: 1199px) {
        .arrival-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
    }

    /* Tablet */
    @media (max-width: 768px) {
        .arrival-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .arrival-heading {
            font-size: 14px;
            padding: 8px 10px;
        }

        .arrival-item h4 {
            font-size: 14px;
            margin-top: 8px;
        }

        .arrival-item p {
            font-size: 12px;
        }
    }

    /* Small mobile */
    @media (max-width: 480px) {
        .arrival-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .arrival-item h4 {
            font-size: 13px;
            line-height: 1.3;
            margin-top: 6px;
            margin-bottom: 4px;
            /* Prevents long text from breaking heights */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .arrival-item p {
            font-size: 11px;
            margin-bottom: 5px;
        }

        .arrival-heading {
            font-size: 13px;
            padding: 7px 8px;
        }

        .arrival-btn a {
            font-size: 13px;
        }
    }
</style>

<?php
// Get only countries that have at least 2 vehicles
$sqlCountries = mysqli_query($dbc, "
    SELECT c.country_id, c.country_name 
    FROM countries c 
    INNER JOIN (
        SELECT country_id, COUNT(*) as vehicle_count 
        FROM vehicle_info 
        GROUP BY country_id 
        HAVING COUNT(*) >= 2
    ) vc ON vc.country_id = c.country_id 
    ORDER BY c.country_name ASC
");

while ($country = mysqli_fetch_assoc($sqlCountries)):

    $sqlVehicles = mysqli_query($dbc, "
        SELECT * FROM vehicle_info 
        WHERE country_id = '{$country['country_id']}' 
        ORDER BY vehicle_id DESC LIMIT 4
    ");
    ?>
    <section class="new-arrivals-section">
        <div>
            <!-- Country Heading -->
            <div class="arrival-heading">
                STOCKS IN <?= strtoupper(htmlspecialchars($country['country_name'])) ?> INVENTORY
            </div>

            <div class="arrival-grid">
                <?php while ($vehicle = mysqli_fetch_assoc($sqlVehicles)):
                    $img = mysqli_fetch_assoc(mysqli_query($dbc, "
                        SELECT * FROM vehicle_images 
                        WHERE vehicle_id = '{$vehicle['vehicle_id']}' 
                        AND vehicle_image_featured = '1' 
                        LIMIT 1
                    "));

                    $maker = mysqli_fetch_assoc(mysqli_query($dbc, "
                        SELECT * FROM maker WHERE maker_id = '{$vehicle['vehicle_maker']}'
                    "));

                    $brand = mysqli_fetch_assoc(mysqli_query($dbc, "
                        SELECT * FROM brands WHERE brand_id = '{$vehicle['vehicle_brand']}'
                    "));
                    ?>

                    <div class="arrival-item">
                        <a href="singlecar.php?i=<?= base64_encode($vehicle['vehicle_id']) ?>">
                            <img src="admin/img/vehicles_images/<?= htmlspecialchars($img['vehicle_image_name'] ?? 'placeholder.jpg') ?>" alt="Vehicle Image">
                        </a>

                        <h4>
                            <?= strtoupper(htmlspecialchars($maker['maker_name'] ?? '')) ?>
                            <?= htmlspecialchars($brand['brand_name'] ?? '') ?>
                        </h4>

                        <p>
                            <?= htmlspecialchars($vehicle['vehicle_reg_year'] ?? '') ?> -
                            <?= htmlspecialchars($vehicle['vehicle_transmission'] ?? '') ?>
                            <?php
                            if (!empty($vehicle['vehicle_drive'])) {
                                echo " - " . htmlspecialchars($vehicle['vehicle_drive']);
                            }
                            ?>
                        </p>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="arrival-btn">
                <a href="stock.php?country=<?= $country['country_id'] ?>">See More →</a>
            </div>
			<br>
        </div>
    </section>
<?php endwhile; ?>

<script>
    document.querySelectorAll('.arrival-heading').forEach(function (heading) {
        heading.addEventListener('mouseenter', function () {
            let colors = ['#3498db', '#2ecc71', '#9b59b6', '#e67e22', '#e74c3c', '#1abc9c', '#34495e'];
            let randomColor = colors[Math.floor(Math.random() * colors.length)];
            this.style.backgroundColor = randomColor;
            this.style.color = '#fff';
        });

        heading.addEventListener('mouseleave', function () {
            this.style.backgroundColor = '#b6bcc4';
            this.style.color = '#000';
        });
    });
</script>