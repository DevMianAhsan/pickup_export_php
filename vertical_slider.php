<style>
    .vertical-homepage-slider {
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    .vertical-carousel {
        overflow: hidden;
    }

    .vertical-carousel .carousel-inner {
        max-height: 520px;
    }

    .vertical-carousel .carousel-item {
        height: 520px;
        background: #f5f5f5;
    }

    .vertical-carousel .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .vertical-slider-caption {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
        color: #fff;
        padding: 30px 20px 20px;
        text-align: center;
    }

    .vertical-slider-caption h3 {
        margin: 0 0 5px;
        font-size: 22px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .vertical-slider-caption p {
        margin: 0;
        font-size: 14px;
    }

    .vertical-carousel .carousel-control-prev,
    .vertical-carousel .carousel-control-next {
        width: 52px;
        height: 52px;
        background: rgba(0, 0, 0, 0.45);
        border-radius: 50%;
        left: 50%;
        right: auto;
        transform: translateX(-50%);
        padding: 0;
        margin: 15px 0;
        opacity: 1;
        border: 2px solid rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease-in-out;
        z-index: 2;
    }

    .vertical-carousel .carousel-control-prev {
        top: 0;
    }

    .vertical-carousel .carousel-control-next {
        top: auto;
        bottom: 0;
    }

    .vertical-carousel .carousel-control-prev:hover,
    .vertical-carousel .carousel-control-next:hover {
        background: rgba(231, 42, 26, 0.85);
        border-color: #fff;
        transform: translateX(-50%) scale(1.05);
    }

    .vertical-carousel .carousel-control-prev-icon,
    .vertical-carousel .carousel-control-next-icon {
        width: 20px;
        height: 20px;
        filter: brightness(0) invert(1);
    }
</style>

<div class="container-fluid px-0 vertical-homepage-slider">
    <div id="verticalImageCarousel" class="carousel slide vertical-carousel"
         data-ride="carousel"
         data-interval="1800">
        <div class="carousel-inner">
            <?php
            $active = "active";
            $q = mysqli_query($dbc, "SELECT * FROM slider_img WHERE slider_img_sts = 1 AND slider_img_type = 'vertical'");
            while ($r = mysqli_fetch_assoc($q)):
            ?>
                <div class="carousel-item <?= $active ?>">
                    <img src="admin/img/slider/<?= $r['slider_img'] ?>"
                         class="d-block w-100"
                         alt="Slider Image">
                    <?php if (!empty($r['slider_img_heading']) || !empty($r['slider_img_desc'])): ?>
                        <div class="vertical-slider-caption">
                            <?php if (!empty($r['slider_img_heading'])): ?>
                                <h3><?= $r['slider_img_heading'] ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($r['slider_img_desc'])): ?>
                                <p><?= $r['slider_img_desc'] ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php
                $active = '';
            endwhile;
            ?>
        </div>

        <button class="carousel-control-prev" type="button" data-target="#verticalImageCarousel" data-slide="prev" aria-label="Previous slide">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#verticalImageCarousel" data-slide="next" aria-label="Next slide">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>
