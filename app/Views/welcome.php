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
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand brand-logo-mini" href="<?= base_url('/') ?>">
                <img src="<?= base_url('assets/admin/images/logo1a.png') ?>" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo" href="<?= base_url('/') ?>">
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
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
                    <button onclick="showModal('loginModal')" class="btn btn-primary ms-2">
                        Login
                    </button>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HEADER SLIDER -->
    <div id="slider" class="carousel slide position-relative" data-bs-ride="carousel" data-bs-interval="2000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?= base_url('assets/users/images/header1.jpeg') ?>" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="<?= base_url('assets/users/images/header2.png') ?>" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="<?= base_url('assets/users/images/header3.jpeg') ?>" class="d-block w-100">
            </div>
        </div>

        <!-- SEARCH BOX -->
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
                <?php for ($i = 1; $i <= 6; $i++): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/rooms/room' . $i . '.jpeg') ?>"
                            class="card-img-top">
                        <div class="card-body">
                            <h5>Room <?= $i ?></h5>
                            <a href="<?= base_url('booking') ?>" class="btn btn-primary w-100">Book Now</a>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- CARS -->
    <section class="section" id="cars">
        <div class="container">
            <h2 class="section-title">Rental Cars</h2>
            <div class="row g-4">
                <?php for ($i = 1; $i <= 6; $i++): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('assets/users/images/cars/car' . $i . '.png') ?>" class="card-img-top">
                        <div class="card-body">
                            <h5>Car <?= $i ?></h5>
                            <button class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

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
    </section>
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
    <footer class="bg-light text-dark">
        <div class="container">
            <div class="row g-4">

                <!-- Contact Info -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title">YooRental</h4>
                            <p>All rentals in one platform</p>
                            <p><strong>Phone:</strong> +91 98765 43210</p>
                            <p><strong>Email:</strong> support@yoorental.com</p>
                            <p><strong>Address:</strong> Arrah, Bihar, India</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Contact Us</h5>
                            <form class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Your Name">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Your Email">
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" rows="3" placeholder="Your Message"></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="mt-4 text-center">
                <a href="#"><img src="<?= base_url('assets/users/images/icons/facebook.png') ?>" width="30"></a>
                <a href="#"><img src="<?= base_url('assets/users/images/icons/instagram.png') ?>" width="30"></a>
                <a href="#"><img src="<?= base_url('assets/users/images/icons/twitter.png') ?>" width="30"></a>
            </div>

            <p class="text-center mt-3">© <?= date('Y') ?> YooRental</p>
        </div>
    </footer>

    <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        width: 100%;
        max-width: 400px;
        position: relative;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 22px;
        cursor: pointer;
    }
    </style>


    <!-- NAVBAR -->


    <!-- LOGIN MODAL -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="hideModal('loginModal')">&times;</span>
            <h3>Student Login</h3>
            <form onsubmit="handleLogin(event)">
                <input type="text" class="form-control mb-2" placeholder="Student ID or Email" required>
                <input type="password" class="form-control mb-2" placeholder="Password" required>
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
            </form>
        </div>
    </div>

    <script>
    function showModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
    }

    function hideModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }

    function handleLogin(event) {
        event.preventDefault(); // IMPORTANT: page reload रोकता है
        alert("Login Successful (Demo)");
        hideModal('loginModal');
    }
    </script>

</body>

</html>
```