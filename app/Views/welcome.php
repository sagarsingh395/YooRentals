<?= $this->extend("_layout/master") ?>
<?= $this->section("content") ?>

<style>
    .card img {
        height: 220px;
        width: 100%;
        object-fit: cover;
    }

    .rating {
        color: orange;
        font-size: 14px;
    }

    .price {
        font-weight: bold;
        color: green;
        font-size: 18px;
    }
</style>

<section class="section" id="house">
    <div class="container">
        <h2 class="section-title">The Signature House Series</h2>
        <div class="row g-4">
            <?php if (!empty($house)) {
                foreach ($house as $list) { ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?= base_url('assets/upload/categories/' . $list->image) ?>">
                            <div class="card-body">
                                <h5><?= $list->category_name ?></h5>
                                <div class="rating">⭐⭐⭐⭐☆</div>
                                  <div class="price">₹<?= $list->rent ?? '' ?></div>
                                <a href="<?= base_url('save-booking?category_id=' . $list->category_id) ?>"
                                    class="btn btn-primary w-100">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <p class="text-danger">House Not Available</p>
            <?php } ?>
        </div>
    </div>
</section>

<section class="section" id="rooms">
    <div class="container">
        <h2 class="section-title">Exclusive Rooms Collection</h2>
        <div class="row g-4">
            <?php if (!empty($rooms)) {
                foreach ($rooms as $list) { ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?= base_url('assets/upload/categories/' . $list->image) ?>">
                            <div class="card-body">
                                <h5><?= $list->category_name ?></h5>
                                <div class="rating">⭐⭐⭐⭐⭐</div>
                                <div class="price">₹<?= $list->rent ?? '' ?></div>
                                <a href="<?= base_url('save-booking?category_id=' . $list->category_id) ?>" class="btn btn-success w-100 mt-2">Book Now</a>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <p class="text-danger">Rooms Not Available</p>
            <?php } ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>