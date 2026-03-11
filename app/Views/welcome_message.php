<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YooRental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #0f0f0f;
            color: white;
            padding-top: 70px;
            font-family: sans-serif;
        }
        /* NAVBAR */
        .navbar {
            background: #000;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        /* LOGO FIX */
        .navbar-brand img {
            height: 45px;
            width: auto;
            object-fit: contain;
        }
        .brand-logo img {
            height: 45px;
        }
        .brand-logo-mini img {
            height: 35px;
        }
        /* HEADER */
        .carousel-item img {
            height: 65vh;
            object-fit: cover;
            filter: brightness(60%);
        }
        /* SEARCH FORM */
        .search-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            width: 80%;
        }
        /* SECTION */
        .section {
            padding: 80px 0;
        }
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            font-weight: bold;
            color: white;
        }
        /* CARDS */
        .card {
            background: #1a1a1a;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: .3s;
            color: white;
        }
        .card:hover {
            transform: translateY(-8px);
        }
        .card img {
            height: 220px;
            object-fit: cover;
        }
        .btn-primary {
            background: #a855f7;
            border: none;
        }
        /* FOOTER */
        footer {
            background: #000;
            padding: 40px;
            text-align: center;
            color: white;
        }
    </style>

</head>

<body>

    <!-- NAVBAR -->
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
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945" class="d-block w-100">
            </div>

            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85" class="d-block w-100">
            </div>

            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750" class="d-block w-100">
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
                        <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427">
                        <div class="card-body">
                            <h5>Luxury Room</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b">
                        <div class="card-body">
                            <h5>Deluxe Room</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32">
                        <div class="card-body">
                            <h5>Family Suite</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c">
                        <div class="card-body">
                            <h5>Classic Room</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1505691723518-36a5ac3be353">
                        <div class="card-body">
                            <h5>Modern Room</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1501183638710-841dd1904471">
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
                        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70">
                        <div class="card-body">
                            <h5>BMW</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1549921296-3a6bce8e3a5b">
                        <div class="card-body">
                            <h5>Audi</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1502877338535-766e1452684a">
                        <div class="card-body">
                            <h5>Mercedes</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1511919884226-fd3cad34687c">
                        <div class="card-body">
                            <h5>Mustang</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d">
                        <div class="card-body">
                            <h5>Range Rover</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1493238792000-8113da705763">
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
                        <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3">
                        <div class="card-body">
                            <h5>Royal Hall</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1549463511-2f543e4905b4">
                        <div class="card-body">
                            <h5>Grand Hall</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1469371670807-013ccf25f16a">
                        <div class="card-body">
                            <h5>Classic Hall</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1505236858219-8359eb29e329">
                        <div class="card-body">
                            <h5>Garden Hall</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1478147427282-58a87a120781">
                        <div class="card-body">
                            <h5>Luxury Hall</h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1507502707541-f369a3b18502">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>