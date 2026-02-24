<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
include('db_connection.php');

// Retrieve user info (for personalization)
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dashboard - Car Zone</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Car Rental HTML Template" name="keywords">
    <meta content="Car Rental HTML Template" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
	<!-- Topbar Start -->
    <div class="container-fluid bg-dark py-3 px-lg-5 d-none d-lg-block">
        <div class="row">
            <div class="col-md-6 text-center text-lg-left mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center">
                    <a class="text-body pr-3" href=""><i class="fa fa-phone-alt mr-2"></i>+012 345 6789</a>
                    <span class="text-body">|</span>
                    <a class="text-body px-3" href=""><i class="fa fa-envelope mr-2"></i>gptctkr@gmail.com</a>
                </div>
            </div>
            <div class="col-md-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-body px-3" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-body px-3" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-body px-3" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-body px-3" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-body pl-3" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    
    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="position-relative px-lg-5" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg bg-secondary navbar-dark py-3 py-lg-0 pl-3 pl-lg-5">
                <a href="dashboard.php" class="navbar-brand">
                    <h1 class="text-uppercase text-primary mb-1">Car Zone</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <a href="home.html" class="nav-item nav-link">Home</a>
                        <a href="about.html" class="nav-item nav-link">About</a>
                        <a href="service.html" class="nav-item nav-link">Service</a>
                        <a href="car.php" class="nav-item nav-link">Cars</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="team.html" class="dropdown-item">The Team</a>
                                
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                        <a href="dashboard.php" class="nav-item nav-link active">Dashboard</a>
                        <a href="logout.php" class="nav-item nav-link" onclick="alert('Logged Out Successfully.')">Logout</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Carousel / Dashboard Banner Start -->
    <div class="container-fluid p-0" style="margin-bottom: 90px;">
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="img/carousel-1.jpg" alt="Image"> 
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase mb-md-3">Welcome, <?php echo htmlspecialchars($user['username']); ?></h4>
                            <h1 class="display-1 text-white mb-md-4">Your Dashboard</h1>
                            <p class="text-white-50">View your orders and manage your bookings all in one place.</p>
                            <a href="home.html" class="btn btn-primary py-md-3 px-md-5 mt-2">Home</a>
                            <a href="orders.php" class="btn btn-success py-md-3 px-md-5 mt-2">My Orders</a>
                        </div>
                    </div>
                </div>
                <!-- You can add more carousel items if needed -->
            </div>
            <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                <div class="btn btn-dark" style="width: 45px; height: 45px;">
                    <span class="carousel-control-prev-icon mb-n2"></span>
                </div>
            </a>
            <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                <div class="btn btn-dark" style="width: 45px; height: 45px;">
                    <span class="carousel-control-next-icon mb-n2"></span>
                </div>
            </a>
        </div>
    </div>
    <!-- Carousel / Dashboard Banner End -->

    <!-- Additional Dashboard Content -->
    <section class="latest-updates py-5">
  <div class="container">
    <h2 class="text-center mb-4">Latest Updates</h2>
    <div class="row">
      <!-- Narendra Modi Review -->
      <div class="col-md-4 mb-3">
        <div class="card border-0">
          <div class="card-body text-center">
            <h5 class="card-title">Narendra Modi</h5>
            <p class="card-text">"Hamara Dheshavasiyo, this website is a refreshing as a perfectly brewed cup of chai on a crisp morning."</p>
          </div>
        </div>
      </div>
      <!-- Donald Trump Review -->
      <div class="col-md-4 mb-3">
        <div class="card border-0">
          <div class="card-body text-center">
            <h5 class="card-title">Donald Trump</h5>
            <p class="card-text">"Believe me, this site is tremendous—if you want the best bookings, it’s the best. I know winning!"</p>
          </div>
        </div>
      </div>
      <!-- Vladimir Putin Review -->
      <div class="col-md-4 mb-3">
        <div class="card border-0">
          <div class="card-body text-center">
            <h5 class="card-title">Vladimir Putin</h5>
            <p class="card-text">"It’s robust and reliable—steady like a well-oiled machine. Not flashy, but it gets the job done."</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


    <!-- Footer Start -->
    <div class="container-fluid bg-secondary py-5 px-sm-3 px-md-5" style="margin-top: 90px;">
        <p class="mb-2 text-center text-body">&copy; <a href="#">Car Zone</a>. All Rights Reserved.</p>
        <p class="m-0 text-center text-body">Designed by <a href="#">Team 15</a></p>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <!-- Additional JS if needed -->
</body>
</html>

