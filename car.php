<?php
include('db_connection.php');

// Get the sort option from the URL; default sorting if not set.
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

$where = "";
$orderBy = "";

if($sort == 'price_asc'){
    $orderBy = "ORDER BY daily_rate ASC";
} elseif($sort == 'price_desc'){
    $orderBy = "ORDER BY daily_rate DESC";
} elseif($sort == 'price_available'){
    $where = "WHERE status != 'booked'";
    $orderBy = "ORDER BY daily_rate ASC";
} else {
    // Default: available cars first then by ascending price.
    $orderBy = "ORDER BY (CASE WHEN status != 'booked' THEN 0 ELSE 1 END), daily_rate ASC";
}

$query = "SELECT * FROM cars $where $orderBy";
$stmt = $pdo->query($query);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Define mapping arrays for images, year, and mileage.
$imageMapping = [
    1 => "car-rent-1.png",
    2 => "car-rent-2.png",
    3 => "car-rent-3.png",
    4 => "car-rent-4.png",
    5 => "car-rent-5.png",
    6 => "car-rent-6.png"
];

$yearMapping = [
    1 => "2022",
    2 => "2017",
    3 => "2022",
    4 => "2024",
    5 => "2016",
    6 => "2018"
];

$mileageMapping = [
    1 => "18K",
    2 => "15K",
    3 => "18K",
    4 => "17K",
    5 => "14K",
    6 => "21K"
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Car Zone - Car Listing</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    
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
                    <a class="text-body px-3" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="text-body px-3" href=""><i class="fab fa-twitter"></i></a>
                    <a class="text-body px-3" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="text-body px-3" href=""><i class="fab fa-instagram"></i></a>
                    <a class="text-body pl-3" href=""><i class="fab fa-youtube"></i></a>
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
                        <a href="car.php" class="nav-item nav-link active">Cars</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="team.html" class="dropdown-item">The Team</a>
                                
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                        <a href="dashboard.php" class="nav-item nav-link">Dashboard</a>
                        <a href="logout.php" class="nav-item nav-link">Logout</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
    
    <!-- Scrolling Banner Advertisement Start -->
    <div class="container-fluid bg-danger text-white overflow-hidden" style="position: relative;">
      <div class="scrolling-banner py-2">
        <span class="h6">
          Limited-Time Offer: For this weekend only, book any car rental and enjoy an exclusive 10% discount! Experience quality, comfort, and style while saving on your trip.
        </span>
      </div>
    </div>
    <!-- Scrolling Banner Advertisement End -->
    
    <!-- Page Header Start -->
    <div class="container-fluid page-header">
        <h1 class="display-3 text-uppercase text-white mb-3">Car Listing</h1>
        <div class="d-inline-flex text-white">
            <h6 class="text-uppercase m-0"><a class="text-white" href="home.html">Home</a></h6>
            <h6 class="text-body m-0 px-3">/</h6>
            <h6 class="text-uppercase text-body m-0">Car Listing</h6>
        </div>
    </div>
    <!-- Page Header End -->
    <!-- Sorting Control Start -->
<div class="container py-3 mb-4">
  <form method="GET" action="car.php" class="form-inline justify-content-center">
      <label for="sort" class="mr-2">Sort By:</label>
      <select name="sort" id="sort" class="form-control w-auto mr-2">
          <option value="default" <?php if($sort == 'default') echo 'selected'; ?>>Default</option>
          <option value="price_asc" <?php if($sort == 'price_asc') echo 'selected'; ?>>Price: Low to High</option>
          <option value="price_desc" <?php if($sort == 'price_desc') echo 'selected'; ?>>Price: High to Low</option>
	<option value="price_available" <?php if($sort == 'price_available') echo 'selected'; ?>>Status: Available</option>
      </select>
      <button type="submit" class="btn btn-primary">Sort</button>
  </form>
</div>
<!-- Sorting Control End -->

    
    <!-- Rent A Car Start -->
<div class="container-fluid py-5">
    <div class="container pt-5 pb-3">
        <h1 class="display-4 text-uppercase text-center mb-5">Find Your Car</h1>
        <div class="row">
            <?php foreach ($cars as $car): ?>
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="rent-item mb-4">
                    <?php 
                    // Get the image file based on car id from mapping array
                    $imageFile = isset($imageMapping[$car['id']]) ? $imageMapping[$car['id']] : 'default.png';
                    ?>
                    <img class="img-fluid mb-4" src="img/<?php echo htmlspecialchars($imageFile); ?>" alt="">
                    <h4 class="text-uppercase mb-4"><?php echo htmlspecialchars($car['model']); ?></h4>
                    <div class="d-flex justify-content-center mb-4">
                        <div class="px-2">
                            <i class="fa fa-car text-primary mr-1"></i>
                            <span><?php echo htmlspecialchars($yearMapping[$car['id']] ?? 'N/A'); ?></span>
                        </div>
                        <div class="px-2 border-left border-right">
                            <i class="fa fa-cogs text-primary mr-1"></i>
                            <span><?php echo htmlspecialchars($car['transmission'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="px-2">
                            <i class="fa fa-road text-primary mr-1"></i>
                            <span><?php echo htmlspecialchars($mileageMapping[$car['id']] ?? 'N/A'); ?></span>
                        </div>
                    </div>
                    <?php
                        // Mapping the booking page based on car id:
                        if ($car['id'] == 1) {
                            $bookingPage = 'booking.html';
                        } else {
                            $bookingPage = 'booking' . ($car['id'] - 1) . '.html';
                        }
                    ?>
                    <?php if ($car['status'] === 'booked'): ?>
                        <button class="btn btn-danger px-3" disabled>Sold Out</button>
                    <?php else: ?>
                        <a class="btn btn-primary px-3" href="<?php echo $bookingPage; ?>"><?php echo number_format($car['daily_rate'], 0); ?>/Day</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Rent A Car End -->

    <!-- Rent A Car Start 
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <h1 class="display-4 text-uppercase text-center mb-5">Find Your Car</h1>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-2">
                    <div class="rent-item mb-4">
                        <img class="img-fluid mb-4" src="img/car-rent-1.png" alt="">
                        <h4 class="text-uppercase mb-4">NISSAN MAGNITE</h4>
                        <div class="d-flex justify-content-center mb-4">
                            <div class="px-2">
                                <i class="fa fa-car text-primary mr-1"></i>
                                <span>2022</span>
                            </div>
                            <div class="px-2 border-left border-right">
                                <i class="fa fa-cogs text-primary mr-1"></i>
                                <span>MANUAL</span>
                            </div>
                            <div class="px-2">
                                <i class="fa fa-road text-primary mr-1"></i>
                                <span>18K</span>
                            </div>
                        </div>
                        <a class="btn btn-primary px-3" href="booking.html">₹3,800/Day</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-2">
                    <div class="rent-item active mb-4">
                        <img class="img-fluid mb-4" src="img/car-rent-2.png" alt="">
                        <h4 class="text-uppercase mb-4">BMW X1</h4>
                        <div class="d-flex justify-content-center mb-4">
                            <div class="px-2">
                                <i class="fa fa-car text-primary mr-1"></i>
                                <span>2017</span>
                            </div>
                            <div class="px-2 border-left border-right">
                                <i class="fa fa-cogs text-primary mr-1"></i>
                                <span>AUTO</span>
                            </div>
                            <div class="px-2">
                                <i class="fa fa-road text-primary mr-1"></i>
                                <span>15K</span>
                            </div>
                        </div>
                        <a class="btn btn-primary px-3" href="booking1.html">₹7,500/Day</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-2">
                    <div class="rent-item mb-4">
                        <img class="img-fluid mb-4" src="img/car-rent-3.png" alt="">
                        <h4 class="text-uppercase mb-4">SKODA SLAVIA</h4>
                        <div class="d-flex justify-content-center mb-4">
                            <div class="px-2">
                                <i class="fa fa-car text-primary mr-1"></i>
                                <span>2022</span>
                            </div>
                            <div class="px-2 border-left border-right">
                                <i class="fa fa-cogs text-primary mr-1"></i>
                                <span>AUTO</span>
                            </div>
                            <div class="px-2">
                                <i class="fa fa-road text-primary mr-1"></i>
                                <span>18K</span>
                            </div>
                        </div>
                        <a class="btn btn-primary px-3" href="booking2.html">₹4,500/Day</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-2">
                    <div class="rent-item mb-4">
                        <img class="img-fluid mb-4" src="img/car-rent-4.png" alt="">
                        <h4 class="text-uppercase mb-4">KIA SELTOS</h4>
                        <div class="d-flex justify-content-center mb-4">
                            <div class="px-2">
                                <i class="fa fa-car text-primary mr-1"></i>
                                <span>2024</span>
                            </div>
                            <div class="px-2 border-left border-right">
                                <i class="fa fa-cogs text-primary mr-1"></i>
                                <span>AUTO</span>
                            </div>
                            <div class="px-2">
                                <i class="fa fa-road text-primary mr-1"></i>
                                <span>17K</span>
                            </div>
                        </div>
                        <a class="btn btn-primary px-3" href="booking3.html">₹5,000/Day</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-2">
                    <div class="rent-item mb-4">
                        <img class="img-fluid mb-4" src="img/car-rent-5.png" alt="">
                        <h4 class="text-uppercase mb-4">MERCEDES BENZ C200</h4>
                        <div class="d-flex justify-content-center mb-4">
                            <div class="px-2">
                                <i class="fa fa-car text-primary mr-1"></i>
                                <span>2016</span>
                            </div>
                            <div class="px-2 border-left border-right">
                                <i class="fa fa-cogs text-primary mr-1"></i>
                                <span>AUTO</span>
                            </div>
                            <div class="px-2">
                                <i class="fa fa-road text-primary mr-1"></i>
                                <span>14K</span>
                            </div>
                        </div>
                        <a class="btn btn-primary px-3" href="booking4.html">₹8,500/Day</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-2">
                    <div class="rent-item mb-4">
                        <img class="img-fluid mb-4" src="img/car-rent-6.png" alt="">
                        <h4 class="text-uppercase mb-4">SUZUKI BALENO</h4>
                        <div class="d-flex justify-content-center mb-4">
                            <div class="px-2">
                                <i class="fa fa-car text-primary mr-1"></i>
                                <span>2018</span>
                            </div>
                            <div class="px-2 border-left border-right">
                                <i class="fa fa-cogs text-primary mr-1"></i>
                                <span>MANUAL</span>
                            </div>
                            <div class="px-2">
                                <i class="fa fa-road text-primary mr-1"></i>
                                <span>21K</span>
                            </div>
                        </div>
                        <a class="btn btn-primary px-3" href="booking5.html">₹3,000/Day</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    Rent A Car End -->


    <!-- Banner Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row mx-0">
                <div class="col-lg-6 px-0">
                    <div class="px-5 bg-secondary d-flex align-items-center justify-content-between" style="height: 350px;">
                        <img class="img-fluid flex-shrink-0 ml-n5 w-50 mr-4" src="img/banner-left.png" alt="">
                        <div class="text-right">
                            <h3 class="text-uppercase text-light mb-3">Want to be driver?</h3>
                            <p class="mb-4">Join our team and hit the road today!</p>
                            <a class="btn btn-primary py-2 px-4" href="car.php">Start Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 px-0">
                    <div class="px-5 bg-dark d-flex align-items-center justify-content-between" style="height: 350px;">
                        <div class="text-left">
                            <h3 class="text-uppercase text-light mb-3">Looking for a car?</h3>
                            <p class="mb-4">Discover your perfect car and quickly begin your journey today..</p>
                            <a class="btn btn-primary py-2 px-4" href="car.php">Start Now</a>
                        </div>
                        <img class="img-fluid flex-shrink-0 mr-n5 w-50 ml-4" src="img/banner-right.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="owl-carousel vendor-carousel">
                <div class="bg-light p-4">
                    <img src="img/vendor-1.png" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="img/vendor-2.png" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="img/vendor-3.png" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="img/vendor-4.png" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="img/vendor-5.png" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="img/vendor-6.png" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="img/vendor-7.png" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="img/vendor-8.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-secondary py-5 px-sm-3 px-md-5" style="margin-top: 90px;">
        <div class="row pt-5">
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-uppercase text-light mb-4">Get In Touch</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-white mr-3"></i>E.K.N.M Govt, Polytechnic College, <br> Thrikaripur, Udinur(PO), <br> Thrikarippur, Kasaragod Dt , <br> 671310</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-white mr-3"></i>+012 345 67890</p>
                <p><i class="fa fa-envelope text-white mr-3"></i>gptctkr@gmail.com</p>
                <h6 class="text-uppercase text-white py-2">Follow Us</h6>
                <div class="d-flex justify-content-start">
                    <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-lg btn-dark btn-lg-square" href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-uppercase text-light mb-4">Useful Links</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white mr-2"></i>Private Policy</a>
                    <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white mr-2"></i>Term & Conditions</a>
                    <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white mr-2"></i>New Member Registration</a>
                    <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white mr-2"></i>Affiliate Programme</a>
                    <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white mr-2"></i>Return & Refund</a>
                    <a class="text-body" href="#"><i class="fa fa-angle-right text-white mr-2"></i>Help & FAQs</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-uppercase text-light mb-4">Car Gallery</h4>
                <div class="row mx-n1">
                    <div class="col-4 px-1 mb-2">
                        <a href=""><img class="w-100" src="img/gallery-1.jpg" alt=""></a>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <a href=""><img class="w-100" src="img/gallery-2.jpg" alt=""></a>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <a href=""><img class="w-100" src="img/gallery-3.jpg" alt=""></a>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <a href=""><img class="w-100" src="img/gallery-4.jpg" alt=""></a>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <a href=""><img class="w-100" src="img/gallery-5.jpg" alt=""></a>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <a href=""><img class="w-100" src="img/gallery-6.jpg" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-uppercase text-light mb-4">Newsletter</h4>
                <p class="mb-4">Subscribe to our newsletter to stay informed about the latest car listings, exclusive deals, and updates from Car Zone. Get insider tips, special promotions, and news delivered directly to your inbox. Join our community today and never miss an opportunity to upgrade your ride!</p>
                <div class="w-100 mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control bg-dark border-dark" style="padding: 25px;" placeholder="Your Email">
                        <div class="input-group-append">
                            <button class="btn btn-primary text-uppercase px-3">Sign Up</button>
                        </div>
                    </div>
                </div>
                <i>temporarily closed!!</i>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark py-4 px-sm-3 px-md-5">
        <p class="mb-2 text-center text-body">&copy; <a href="#">Car Zone</a>. All Rights Reserved.</p>
        <p class="m-0 text-center text-body">Designed by <a href="#">Team 15</a></p>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
