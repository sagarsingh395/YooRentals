<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YooRental</title>
    <link href="<?= base_url('assets/users/css/bootstrap.min.css') ?>" rel="stylesheet"> 
  <link rel="stylesheet" href="<?= base_url('assets/users/css/style.css') ?>">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand brand-logo-mini" href="<?= base_url('admin/dashboard') ?>">
                <img src="<?= base_url('assets/admin/images/logo1a.png') ?>" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo" href="<?= base_url('admin/dashboard') ?>">
                <img src="<?= base_url('assets/admin/images/logo1b.png') ?>" alt="logo" />
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#rooms">Rooms</a></li>
                    <li class="nav-item"><a class="nav-link" href="#cars">Cars</a></li>
                    <li class="nav-item"><a class="nav-link" href="#halls">Halls</a></li>
                    <li class="nav-item ms-3">
                        <button class="btn btn-outline-light btn-sm">Login</button>
                    </li>
                    <li class="nav-item ms-2">
                        <button class="btn btn-primary btn-sm">Sign Up</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HEADER SLIDER -->
    <div id="slider" class="carousel slide position-relative" data-bs-ride="carousel" data-bs-interval="2000">
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="<?= base_url('assets/users/images/header1.jpeg') ?>" alt="Image" class="d-block w-100">
            </div>

            <div class="carousel-item">
                <img src="<?= base_url('assets/users/images/header2.png') ?>" alt="Image" class="d-block w-100">
            </div>

            <div class="carousel-item">
                <img src="<?= base_url('assets/users/images/header3.jpeg') ?>" alt="Image" class="d-block w-100">
            </div>

        </div>

        <!-- SEARCH FORM -->
        <div class="search-box">
            <div class="row g-2">
                <div class="col-md-3">
                    <select class="form-control">
                        <option>What do you want to rent?</option>
                        <option>Room</option>
                        <option>Car</option>
                        <option>Marriage Hall</option>
                    </select>
                </div>


                <div class="col-md-3">
                    <input type="date" class="form-control">
                </div>

                <div class="col-md-3">
                    <select class="form-control">

                        <option>Select City</option>
                        <option>Delhi</option>
                        <option>Mumbai</option>
                        <option>Patna</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ROOMS -->
    <section class="section" id="rooms">
        <div class="container">
            <h2 class="section-title">Popular Rooms</h2>
            <div class="row g-4">

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/rooms/room1.jpeg') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Luxury Room</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/rooms/room2.jpeg') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Deluxe Room</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/rooms/room3.jpeg') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Family Suite</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/rooms/room4.jpeg') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Classic Room</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/rooms/room5.jpeg') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Modern Room</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/rooms/room6.jpeg') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Budget Room</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CARS -->
    <section class="section bg-dark" id="cars">
        <div class="container">
            <h2 class="section-title">Rental Cars</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/cars/car1.png') ?>" alt="Image">
                        <div class="card-body">
                            <h5>BMW</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/cars/car2.png') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Audi</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/cars/car3.png') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Mercedes</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/cars/car4.png') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Mustang</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/cars/car5.png') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Range Rover</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/cars/car6.png') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Toyota</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MARRIAGE HALLS -->
    <section class="section" id="halls">
        <div class="container">
            <h2 class="section-title">Marriage Halls</h2>
            <div class="row g-4">

                <div class="col-md-4">
                    <div class="card">
                       <img src="<?= base_url('assets/users/images/halls/hall1.png') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Royal Hall</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                       <img src="<?= base_url('assets/users/images/halls/hall2.png') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Grand Hall</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/halls/hall3.png') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Classic Hall</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                       <img src="<?= base_url('assets/users/images/halls/hall4.png') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Garden Hall</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/halls/hall5.png') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Luxury Hall</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/halls/hall6.png') ?>" alt="Image">
                        <div class="card-body">
                            <h5>Classic Banquet</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <h4>YooRental</h4>
        <p>All rentals in one platform</p>
        <p>© <?= date('Y') ?> YooRental</p>
    </footer>
  <script src="<?= base_url('assets/users/js/bootstrap.min.js') ?>"></script>
</body>

</html>