<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YooRental</title>

    <!-- Bootstrap -->
    <link href="<?= base_url('assets/users/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/users/css/home.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/admin/images/logo1a.png') ?>" />
</head>

<body>

    <!-- NAVBAR -->
    <?= $this->include("_layout/navbar") ?>
    <!-- HEADER SLIDER -->
    <?= $this->include("_layout/header") ?>
    <!-- ROOMS -->
    <?= $this->renderSection("content"); ?>

    <?php /*
    <!-- HALLS -->
    <section class="section" id="halls">
        <div class="container">
            <h2 class="section-title">Marriage Halls</h2>
            <div class="row g-4">
                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?= base_url('assets/users/images/halls/hall' . $i . '.png') ?>" class="card-img-top">
                            <div class="card-body">
                                <h5>Hall <?= $i ?></h5>
                                <button class="btn btn-primary w-100">Book Now</button>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section> */ ?>
    <!-- TESTIMONIALS -->
    <section class="section bg-light" id="testimonials">
        <div class="container">
            <h2 class="section-title">What Our Customers Say</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p>"Best rental service I’ve ever used!"</p>
                            <h6>- Rahul, Delhi</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p>"Affordable and reliable, highly recommended."</p>
                            <h6>- Priya, Mumbai</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p>"Great experience booking halls for my wedding."</p>
                            <h6>- Aman, Patna</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER WITH CONTACT -->
    <?= $this->include("contact") ?>
    <script src="<?= base_url('assets/admin/js/error_remove.js') ?>"></script>


</body>

</html>