<?php
    session_start();
    $logged = 0;
    if (isset($_SESSION['c_id']) && $_SESSION['c_id'] != null) {
        $logged = 1;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PP travel ltd - Welcome</title>
    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/modern_ui.css">
    
    <style>
        /* Landing page style tweaks */
        body {
            background-color: var(--color-bg-light) !important;
            padding-top: 150px !important;
        }
        
        .hero-title {
            font-family: var(--font-serif) !important;
            font-size: 3.5rem !important;
            font-weight: 900 !important;
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
            text-shadow: 0 3px 20px rgba(0, 0, 0, 0.5) !important;
        }

        .hero-info-text {
            animation: slideUp 0.8s ease forwards;
        }

        /* Video slider overlays & animations */
        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(8, 23, 43, 0.85) 25%, rgba(8, 23, 43, 0.2) 100%) !important;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding-left: 8%;
            padding-right: 8%;
            color: #fff;
            z-index: 5;
        }

        .video-overlay p {
            background-color: transparent !important;
            border: none !important;
            border-radius: 0 !important;
            padding: 0 !important;
            color: #ffffff !important;
            font-size: 1.25rem !important;
            line-height: 1.6 !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.4) !important;
        }

        .carousel-item.active .animate-slide-up {
            animation: slideUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        
        .carousel-item.active .animate-slide-up-delay {
            animation: slideUp 1s cubic-bezier(0.16, 1, 0.3, 1) 0.25s forwards;
        }

        .carousel-item.active .animate-slide-up-delay-2 {
            animation: slideUp 1s cubic-bezier(0.16, 1, 0.3, 1) 0.5s forwards;
        }
        
        .animate-slide-up,
        .animate-slide-up-delay,
        .animate-slide-up-delay-2 {
            opacity: 0;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <!-- Demoxml Preloader -->
    <div id="loader-wrapper">
        <div id="status">
            <div class="inner-spinner"></div>
            <div class="loading-text"><span class="blue">PP Travel</span> <span class="red">Ltd</span></div>
        </div>
    </div>
    <!-- Modern Luxury Split-Row Header -->
    <nav class="navbar navbar-expand-lg fixed-top demoxml-navbar d-flex flex-column py-0">
      <!-- Top Row: Logo, Profile Status, Contact Phone -->
      <div class="navbar-top-row w-100">
        <div class="container-fluid max-width-container d-flex justify-content-between align-items-center px-4" style="height: 60px;">
          <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo $logged ? 'php/home.php' : '#'; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #aae0f7 !important;"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/><path d="M12 18a3 3 0 0 0 3-3c0-1.5-1.5-2.5-3-3.5-1.5 1-3 2-3 3.5a3 3 0 0 0 3 3z"/></svg>
            <div class="d-flex flex-column align-items-start leading-none">
              <span class="brand-text" style="font-size: 1.2rem; font-weight: 800; font-family: var(--font-serif); letter-spacing: 0.5px;">PP Travel Ltd</span>
            </div>
          </a>

          <div class="d-flex align-items-center gap-3 h-100">
            <?php 
               if($logged == 1) {
                echo '<div class="navbar-profile-badge d-flex align-items-center gap-2" style="color:#aaaaaa;">';
                echo '  <div class="navbar-profile-avatar" style="background:#eeeeee; color:#555;">'.strtoupper(substr($_SESSION['c_name'], 0, 1)).'</div>';
                echo '  <a href="php/home.php" class="navbar-profile-name text-decoration-none">'.$_SESSION['c_name'].'</a>';
                echo '  <a class="navbar-logout-btn" href="php/logout.php" style="color:#e74c3c;">Logout</a>';
                echo '</div>';
               } else {
                echo '<a class="nav-link" href="php/login_page.php" style="color:#aaaaaa; font-weight:bold; font-size:11px; text-transform:uppercase;">';
                echo '  LOGIN<br>REGISTER';
                echo '</a>';
               }
            ?>
            <a href="tel:9876543210" class="demoxml-contact-box d-none d-sm-inline-flex text-decoration-none">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              987 654 3210
            </a>

            <!-- Hamburger Icon (visible on mobile only) -->
            <button class="navbar-toggler modern-navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="toggler-icon-bar top-bar"></span>
              <span class="toggler-icon-bar middle-bar"></span>
              <span class="toggler-icon-bar bottom-bar"></span>
            </button>
          </div>
        </div>
      </div>

      <!-- Bottom Row: Navigation Links -->
      <div class="navbar-bottom-row collapse navbar-collapse w-100" id="navbarSupportedContent">
        <div class="container-fluid max-width-container px-4">
          <ul class="navbar-nav mx-auto gap-1 justify-content-center align-items-center flex-column flex-lg-row">
            <?php if($logged == 1): ?>
            <li class="nav-item">
              <a class="nav-link" href="php/home.php">Dashboard</a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link" href="php/about_us.php">About us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="php/contact_us.php">Contact Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="php/state1.php">Explorable Places</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="php/tourpackages.php">Tour Packages</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="php/tourconductions_details.php">Tour Conduction</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="php/states.php">Hotel Booking</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Luxury Video Carousel Slider -->
    <div id="heroCarousel" class="carousel slide carousel-fade demoxml-slider-arrows" data-bs-ride="carousel" data-bs-interval="false">
        <div class="carousel-inner" style="height: 80vh; overflow: hidden; background: #000;">
            
            <!-- Slide 1: India 360 -->
            <div class="carousel-item active" style="height: 80vh;">
                <video class="w-100 h-100 object-fit-cover" autoplay muted playsinline style="object-fit: cover;">
                    <source src="media/India-360-v2.mp4" type="video/mp4">
                </video>
                <div class="video-overlay">
                    <div class="container-fluid max-width-container">
                        <h1 class="hero-title text-uppercase mb-2 animate-slide-up" style="letter-spacing: 2px;">India 360°</h1>
                        <p class="fs-4 text-white opacity-90 mb-4 animate-slide-up-delay" style="max-width: 600px; font-weight: 300;">A journey of discovery through vibrant cultures, spiritual landmarks, and timeless heritage.</p>
                        <a href="php/state1.php" class="btn btn-luxury px-5 py-3 text-uppercase tracking-wider font-bold animate-slide-up-delay-2" style="font-size: 13px;">Explore Places</a>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Nature -->
            <div class="carousel-item" style="height: 80vh;">
                <video class="w-100 h-100 object-fit-cover" muted playsinline style="object-fit: cover;">
                    <source src="media/Nature.mp4" type="video/mp4">
                </video>
                <div class="video-overlay">
                    <div class="container-fluid max-width-container">
                        <h1 class="hero-title text-uppercase mb-2 animate-slide-up" style="letter-spacing: 2px;">Scenic Nature</h1>
                        <p class="fs-4 text-white opacity-90 mb-4 animate-slide-up-delay" style="max-width: 600px; font-weight: 300;">Immerse yourself in scenic backwaters, pristine mountain valleys, and tranquil beaches.</p>
                        <a href="php/state1.php" class="btn btn-luxury px-5 py-3 text-uppercase tracking-wider font-bold animate-slide-up-delay-2" style="font-size: 13px;">Explore Nature</a>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Adventure -->
            <div class="carousel-item" style="height: 80vh;">
                <video class="w-100 h-100 object-fit-cover" muted playsinline style="object-fit: cover;">
                    <source src="media/Adventure.mp4" type="video/mp4">
                </video>
                <div class="video-overlay">
                    <div class="container-fluid max-width-container">
                        <h1 class="hero-title text-uppercase mb-2 animate-slide-up" style="letter-spacing: 2px;">Thrilling Adventure</h1>
                        <p class="fs-4 text-white opacity-90 mb-4 animate-slide-up-delay" style="max-width: 600px; font-weight: 300;">Scale high peaks, brave wild river rapids, and discover the thrill of the unexplored path.</p>
                        <a href="php/tourpackages.php" class="btn btn-luxury px-5 py-3 text-uppercase tracking-wider font-bold animate-slide-up-delay-2" style="font-size: 13px;">View Packages</a>
                    </div>
                </div>
            </div>

            <!-- Slide 4: Heritage -->
            <div class="carousel-item" style="height: 80vh;">
                <video class="w-100 h-100 object-fit-cover" muted playsinline style="object-fit: cover;">
                    <source src="media/Heritage.mp4" type="video/mp4">
                </video>
                <div class="video-overlay">
                    <div class="container-fluid max-width-container">
                        <h1 class="hero-title text-uppercase mb-2 animate-slide-up" style="letter-spacing: 2px;">Glorious Heritage</h1>
                        <p class="fs-4 text-white opacity-90 mb-4 animate-slide-up-delay" style="max-width: 600px; font-weight: 300;">Explore centuries-old palaces, majestic fortresses, and architectural masterworks steeped in lore.</p>
                        <a href="php/state1.php" class="btn btn-luxury px-5 py-3 text-uppercase tracking-wider font-bold animate-slide-up-delay-2" style="font-size: 13px;">Explore Heritage</a>
                    </div>
                </div>
            </div>

            <!-- Slide 5: Wildlife -->
            <div class="carousel-item" style="height: 80vh;">
                <video class="w-100 h-100 object-fit-cover" muted playsinline style="object-fit: cover;">
                    <source src="media/Wildlife.mp4" type="video/mp4">
                </video>
                <div class="video-overlay">
                    <div class="container-fluid max-width-container">
                        <h1 class="hero-title text-uppercase mb-2 animate-slide-up" style="letter-spacing: 2px;">Wild Excursions</h1>
                        <p class="fs-4 text-white opacity-90 mb-4 animate-slide-up-delay" style="max-width: 600px; font-weight: 300;">Witness rare and exotic species roam free in their native, untouched sanctuaries.</p>
                        <a href="php/tourpackages.php" class="btn btn-luxury px-5 py-3 text-uppercase tracking-wider font-bold animate-slide-up-delay-2" style="font-size: 13px;">Book Safaris</a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Carousel controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" style="z-index: 10;">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: invert(1) grayscale(100) brightness(50%);"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" style="z-index: 10;">
            <span class="carousel-control-next-icon" aria-hidden="true" style="filter: invert(1) grayscale(100) brightness(50%);"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Booking Console Container -->
    <div class="container-fluid px-0" style="position: relative; z-index: 30; margin-top: -90px;">
        <div id="booking-console" class="demoxml-booking-bar shadow-sm">
            
            <!-- Floating special offer circle badge -->
            <div class="demoxml-offer-badge d-none d-lg-flex">
                <span class="demoxml-offer-text-sm">Special Offer<br>on Booking</span>
                <span class="demoxml-offer-text-lg">50<span style="font-size:16px;">%</span><br><span style="font-size:12px; margin-top:-10px; display:block;">OFF</span></span>
            </div>

            <form action="php/states.php" method="GET">
                <div class="row align-items-center g-3">
                    <div class="col-lg-2 col-md-12 text-center text-lg-start">
                        <h4 class="mb-0 text-white" style="font-weight: 800; font-size: 22px; line-height: 1.1; letter-spacing: 1px;">
                            BOOK YOUR<br>TRAVEL
                        </h4>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6">
                        <label class="form-label">Arrival <i class="text-white float-end">📅</i></label>
                        <input type="date" name="arrival" class="form-control" required>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6">
                        <label class="form-label">Departure <i class="text-white float-end">📅</i></label>
                        <input type="date" name="departure" class="form-control" required>
                    </div>
                    <div class="col-lg-1 col-md-2 col-4">
                        <label class="form-label text-transparent">&nbsp;</label>
                        <select name="rooms" class="form-select">
                            <option value="1">1 Room</option>
                            <option value="2">2 Rooms</option>
                            <option value="3">3 Rooms</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-2 col-4">
                        <label class="form-label text-transparent">&nbsp;</label>
                        <select name="guests" class="form-select">
                            <option value="1">1 Adult</option>
                            <option value="2">2 Adults</option>
                            <option value="3">3 Adults</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-2 col-4">
                        <label class="form-label text-transparent">&nbsp;</label>
                        <select name="children" class="form-select">
                            <option value="0">0 Child</option>
                            <option value="1">1 Child</option>
                            <option value="2">2 Child</option>
                            <option value="3">3 Child</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12 text-end">
                        <label class="form-label text-transparent d-block">&nbsp;</label>
                        <button type="submit" class="demoxml-btn-book w-100 shadow-sm">Book</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Elegant Welcome Section -->
    <div class="container my-5 p-5 bg-white border-0 shadow-none text-center d-flex flex-column align-items-center" style="max-width: 900px;">
        <h2 class="text-uppercase fw-bold mb-2" style="font-family: var(--font-serif) !important; color: var(--color-navy) !important; letter-spacing: 2px;">Welcome to Our Luxury Resort</h2>
        <div class="deco-divider">
            <span class="deco-divider-icon">⚜</span>
        </div>
        <p class="mb-4 text-muted fs-5 font-serif" style="font-family: var(--font-serif) !important; font-style: italic; border: none !important; background-color: transparent !important; padding: 0 !important; line-height: 1.8;">
            "Experience the ultimate blend of luxury, comfort, and adventure. Located in the heart of pristine destinations, our resort offers a sanctuary where exquisite design meets impeccable service. From serene beachside villas to majestic historical tours, every detail is crafted to ensure an unforgettable escape."
        </p>
        <p class="text-muted" style="border: none !important; background-color: transparent !important; padding: 0 !important; font-size: 15px; line-height: 1.8; max-width: 800px;">
            Whether you are planning a tranquil weekend getaway, a grand family vacation, or exploring the cultural wonders of our curated tour packages, we invite you to immerse yourself in our world of hospitality. Discover our exclusive collections, dine in award-winning culinary spaces, and create memories that will last a lifetime.
        </p>
    </div>

    <!-- Vitour Style Featured Packages Section -->
    <div class="container my-5 p-0 bg-transparent border-0 shadow-none">
        <div class="text-center mb-5">
            <h2 class="text-uppercase fw-bold mb-2" style="font-family: var(--font-serif) !important; color: var(--color-navy) !important; letter-spacing: 2px;">Trending Tour Packages</h2>
            <div class="deco-divider justify-content-center">
                <span class="deco-divider-icon">⚜</span>
            </div>
            <p class="text-muted font-serif mb-0" style="font-style: italic;">Explore our most popular curated tour packages</p>
        </div>
        
        <?php
        $conn = mysqli_connect("localhost", "root", "", "travel_hotel_book");
        if (!$conn) {
            echo "<p class='text-center text-danger'>Connection failed</p>";
        } else {
            $query = "SELECT * FROM tourpackage_details LIMIT 0,6";
            $res = mysqli_query($conn, $query);
            if ($res) {
                echo '<div class="row g-4 justify-content-center">';
                while ($row = mysqli_fetch_assoc($res)) {
                    echo '
                    <div class="col-md-6 col-lg-4">
                        <div class="package-card h-100 d-flex flex-column bg-white">
                            <div class="package-img-container">
                                <img src="image/t_pkg/'.htmlspecialchars($row['tp_id']).'.jpg" alt="'.htmlspecialchars($row['tp_name']).'" onerror="this.src=\'image/s1.jpg\'">
                                <div class="package-badge-price">'.htmlspecialchars($row['tp_cost']).'</div>
                                <div class="package-badge-duration">'.htmlspecialchars($row['tp_dur']).'</div>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="package-rating">
                                    ★★★★★
                                </div>
                                <h4 class="card-title text-primary fw-bold mb-2" style="font-family: var(--font-serif) !important; font-size: 1.35rem;">'.htmlspecialchars($row['tp_name']).'</h4>
                                <p class="card-text text-muted flex-grow-1" style="text-align: justify; font-size: 13px; line-height: 1.6;">'.htmlspecialchars($row['tp_dtls']).'</p>
                                
                                <ul class="package-features">
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        Luxury Accommodations
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        Guided Sightseeing Tours
                                    </li>
                                </ul>
                                
                                <div class="d-flex gap-2 mt-3">
                                    <a href="php/touristspots_details.php?val='.htmlspecialchars($row['p_id']).'" class="btn btn-outline-secondary w-50 py-2 font-bold" style="font-size: 11px; text-transform: uppercase; border-color: #ccd6dd; color: var(--color-navy); text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center;">Spots</a>
                                    <a href="php/tourdate_details.php?tp_id='.htmlspecialchars($row['tp_id']).'" class="btn btn-luxury w-50 py-2">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
                echo '</div>';
            }
            mysqli_close($conn);
        }
        ?>
    </div>

    <!-- Upcoming Tour Conductions Section -->
    <div class="container my-5 p-0 bg-transparent border-0 shadow-none">
        <div class="text-center mb-5">
            <h2 class="text-uppercase fw-bold mb-2" style="font-family: var(--font-serif) !important; color: var(--color-navy) !important; letter-spacing: 2px;">Upcoming Departures</h2>
            <div class="deco-divider justify-content-center">
                <span class="deco-divider-icon">⚜</span>
            </div>
            <p class="text-muted font-serif mb-0" style="font-style: italic;">Book one of our scheduled upcoming tour departures below</p>
        </div>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "travel_hotel_book");
        if ($conn) {
            $query_cond = "SELECT c.tc_id, c.strt_date, p.tp_name, p.tp_dur, p.tp_cost, p.tp_id, pl.p_name, p.p_id
                           FROM `tourconduction_details` c
                           JOIN tourpackage_details p ON c.tp_id = p.tp_id
                           LEFT JOIN place_details pl ON p.p_id = pl.p_id
                           WHERE c.tc_status = 1
                           ORDER BY c.tc_id DESC LIMIT 6";
            $res_cond = mysqli_query($conn, $query_cond);
            if ($res_cond && mysqli_num_rows($res_cond) > 0) {
                echo '<div class="row g-4 justify-content-center">';
                while ($row = mysqli_fetch_assoc($res_cond)) {
                    $tc_id = htmlspecialchars($row['tc_id']);
                    $start_date = htmlspecialchars($row['strt_date']);
                    $tp_name = htmlspecialchars($row['tp_name']);
                    $duration = htmlspecialchars($row['tp_dur']);
                    $price = htmlspecialchars($row['tp_cost']);
                    $tp_id = htmlspecialchars($row['tp_id']);
                    $place_name = !empty($row['p_name']) ? htmlspecialchars($row['p_name']) : "Explore India";
                    
                    echo '
                    <div class="col-md-6 col-lg-4">
                        <div class="package-card h-100 d-flex flex-column bg-white">
                            <div class="package-img-container">
                                <img src="image/t_pkg/'.htmlspecialchars($tp_id).'.jpg" alt="'.htmlspecialchars($tp_name).'" onerror="this.src=\'image/s1.jpg\'">
                                <div class="package-badge-price">'.htmlspecialchars($price).'</div>
                                <div class="package-badge-duration">'.htmlspecialchars($duration).'</div>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="package-rating">★★★★★</div>
                                <h4 class="card-title text-primary fw-bold mb-1" style="font-family: var(--font-serif) !important; font-size: 1.25rem;">'.htmlspecialchars($tp_name).'</h4>
                                <p class="text-muted mb-3" style="font-size: 11px;">📍 '.htmlspecialchars($place_name).' | 📅 Depart: '.htmlspecialchars($start_date).'</p>
                                <div class="d-flex gap-2 mt-auto">
                                    <a href="php/touristspots_details.php?val='.htmlspecialchars($row['p_id']).'" class="btn btn-outline-secondary w-50 py-2 font-bold" style="font-size: 11px; text-transform: uppercase; border-color: #ccd6dd; color: var(--color-navy); text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center;">Spots</a>
                                    <a href="php/bookings_details.php?tc_id='.htmlspecialchars($tc_id).'&pname='.urlencode($tp_name).'&price='.urlencode($price).'" class="btn btn-luxury w-50 py-2">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
                echo '</div>';
            } else {
                echo '<p class="text-center text-muted">No upcoming scheduled departures found at the moment.</p>';
            }
            mysqli_close($conn);
        }
        ?>
    </div>

    <!-- Discover States Preview Section -->
    <div class="container my-5 p-0 bg-transparent border-0 shadow-none">
        <div class="text-center mb-5">
            <h2 class="text-uppercase fw-bold mb-2" style="font-family: var(--font-serif) !important; color: var(--color-navy) !important; letter-spacing: 2px;">Popular Destinations</h2>
            <div class="deco-divider justify-content-center">
                <span class="deco-divider-icon">⚜</span>
            </div>
            <p class="text-muted font-serif mb-0" style="font-style: italic;">Explore beautiful states and local attractions</p>
        </div>

        <?php
        $conn = mysqli_connect("localhost", "root", "", "travel_hotel_book");
        if ($conn) {
            $query = "SELECT * FROM state_details LIMIT 0,3";
            $res = mysqli_query($conn, $query);
            if ($res) {
                echo '<div class="row g-4 justify-content-center">';
                while ($row = mysqli_fetch_assoc($res)) {
                    echo '
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0" style="transition: all 0.3s ease;">
                            <div class="position-relative overflow-hidden" style="height: 240px; border-top-left-radius: 6px; border-top-right-radius: 6px;">
                                <img src="image/State/'.htmlspecialchars($row['st_id']).'.jpg" class="w-100 h-100" alt="'.htmlspecialchars($row['st_name']).'" style="object-fit: cover; transition: transform 0.4s ease;">
                            </div>
                            <div class="card-body d-flex flex-column p-4 bg-white" style="border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;">
                                <h4 class="card-title text-primary fw-bold mb-3" style="font-family: var(--font-serif) !important;">'.htmlspecialchars($row['st_name']).'</h4>
                                <p class="card-text text-muted flex-grow-1" style="text-align: justify; font-size: 13.5px; line-height: 1.6;">'.htmlspecialchars($row['st_details']).'</p>
                                <a href="php/places.php?val='.htmlspecialchars($row['st_id']).'" class="btn btn-luxury mt-4 w-100 py-2" style="text-decoration: none;">Explore Places</a>
                            </div>
                        </div>
                    </div>';
                }
                echo '</div>';
            }
            mysqli_close($conn);
        }
        ?>
    </div>

    <!-- Scripts: jQuery first, then Bootstrap 5 -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function ($) {
        "use strict";

        $(document).ready(function() {
            var heroCarouselEl = document.getElementById('heroCarousel');
            if (heroCarouselEl) {
                // Initialize using Bootstrap 5 Carousel API
                var carouselInstance = new bootstrap.Carousel(heroCarouselEl, {
                    ride: false,
                    interval: false,
                    wrap: true
                });

                // Function to play video on active slide
                function playActiveVideo(item) {
                    var video = item.querySelector('video');
                    if (video) {
                        video.currentTime = 0;
                        var playPromise = video.play();
                        if (playPromise !== undefined) {
                            playPromise.catch(function(error) {
                                console.log("Video play was interrupted or blocked:", error);
                            });
                        }
                    }
                }

                // Function to pause video
                function pauseVideo(item) {
                    var video = item.querySelector('video');
                    if (video) {
                        video.pause();
                    }
                }

                // Add ended event listeners to all videos
                var videos = heroCarouselEl.querySelectorAll('video');
                videos.forEach(function(video) {
                    video.addEventListener('ended', function() {
                        carouselInstance.next();
                    });
                });

                // Play the first video initially
                var activeItem = heroCarouselEl.querySelector('.carousel-item.active');
                if (activeItem) {
                    playActiveVideo(activeItem);
                }

                // Listen for slide change start
                heroCarouselEl.addEventListener('slide.bs.carousel', function(event) {
                    var activeItem = heroCarouselEl.querySelector('.carousel-item.active');
                    if (activeItem) {
                        pauseVideo(activeItem);
                    }
                    var nextVideo = event.relatedTarget.querySelector('video');
                    if (nextVideo) {
                        nextVideo.currentTime = 0;
                    }
                });

                // Listen for slide change complete
                heroCarouselEl.addEventListener('slid.bs.carousel', function(event) {
                    playActiveVideo(event.relatedTarget);
                });
            }
        });

        /** start prelaoder js **/
        function hidePreloader() {
            $('#status').fadeOut('slow', function() {
                $(this).remove();
            });
            $('#loader-wrapper').delay(300).fadeOut('slow', function() {
                $(this).remove();
            });
            $('body').delay(350).css({'overflow-x':'hidden'});
        }

        if (document.readyState === 'complete') {
            hidePreloader();
        } else {
            $(window).on('load', hidePreloader);
            // Fallback to force hide after 2 seconds if something blocks loading
            setTimeout(hidePreloader, 2000);
        }
        /** end prelaoder js **/

    }(jQuery));
    </script>
</body>
</html>
