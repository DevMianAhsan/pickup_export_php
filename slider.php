<style>
    .homepage-slider {
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    .image-carousel {
        overflow: hidden;
    }

    .carousel-item {
        height: 520px;
        background: #f5f5f5;
    }

    .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 52px;
        height: 52px;
        background: rgba(0, 0, 0, 0.45);
        border-radius: 50%;
        top: 50% !important;
        transform: translateY(-50%);
        padding: 0;
        margin-left: 35px;
        margin-right: 35px;
        opacity: 1;
        border: 2px solid rgba(255,255,255,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease-in-out;
        z-index: 2;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background: rgba(231, 42, 26, 0.85);
        border-color: #fff;
        transform: translateY(-50%) scale(1.05);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 20px;
        height: 20px;
        filter: brightness(0) invert(1);
    }

    @media (max-width: 767px) {
        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            margin-left: 8px;
            margin-right: 8px;
        }
    }

    .carousel-indicators {
        display: none;
    }
</style>

<div class="container-fluid px-0 homepage-slider">
    <div id="imageCarousel" class="carousel slide image-carousel"
         data-ride="carousel"
         data-interval="1800">
        <div class="carousel-inner">
            <?php
            $active = "active";
            $q = mysqli_query($dbc, "SELECT * FROM slider_img WHERE slider_img_sts = 1");
            while($r = mysqli_fetch_assoc($q)):
            ?>
                <div class="carousel-item <?= $active ?>">
                    <img src="admin/img/slider/<?= $r['slider_img'] ?>"
                         class="d-block w-100"
                         alt="Slider Image">
                </div>
            <?php
                $active = '';
            endwhile;
            ?>
        </div>

        <button class="carousel-control-prev" type="button" data-target="#imageCarousel" data-slide="prev" aria-label="Previous slide">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#imageCarousel" data-slide="next" aria-label="Next slide">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>