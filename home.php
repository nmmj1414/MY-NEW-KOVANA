<?php
session_start();
include("locations_data.php");

if (array_key_exists("username", $_SESSION) == 0) { $_SESSION["username"] = ""; }
if (array_key_exists("userID", $_SESSION) == 0) { $_SESSION["userID"] = ""; }

$logged = 0;
$displayName = "";
if ($_SESSION["username"] != "") {
    $logged = 1;
    $displayName = $_SESSION["username"];
}

$pick_resto = array();
$pick_resto[0] = 0; $pick_resto[1] = 7; $pick_resto[2] = 13;
$pick_act = array();
$pick_act[0] = 0; $pick_act[1] = 5; $pick_act[2] = 12;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homestyles.css">
</head>
<body>

<!-- NAVBAR -->
<header>
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
<div class="container">
    <a class="navbar-brand" href="home.php"><img src="images/KOVANA_LOGO.png" alt="logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link active" href="#slider">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#destinations">Destinations</a></li>
            <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
        </ul>
        <div class="d-flex align-items-center justify-content-end">
            <?php if ($logged == 0) { ?>
                <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#authModal">Login / Register</button>
            <?php } else { ?>
                <div class="me-2 px-3 py-2 bg-light border rounded"><?php echo $displayName; ?></div>
                <a href="bookedplaces.php" class="btn btn-primary ms-2">Your Booked Places</a>
                <form method="POST" action="logout.php" class="ms-2">
                    <button class="btn btn-danger">Logout</button>
                </form>
            <?php } ?>
        </div>
    </div>
</div>
</nav>
</header>

<!-- CAROUSEL -->
<section id="slider">
<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/TRAVEL.jpg" class="d-block w-100" alt="Travel">
            <div class="carousel-caption hero-text"><h1>WELCOME TO KOVANA!</h1></div>
        </div>
        <div class="carousel-item">
            <img src="images/PAMPANGA.jpg" class="d-block w-100" alt="Pampanga">
            <div class="carousel-caption hero-text"><h1>ANGELES, PAMPANGA</h1></div>
        </div>
        <div class="carousel-item">
            <img src="images/BANAUE.jpg" class="d-block w-100" alt="Banaue">
            <div class="carousel-caption hero-text"><h1>BANAUE</h1></div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
</section>

<!-- ABOUT -->
<section id="about" class="welcome">
<div class="container py-5">
    <h2 class="fw-bold">Welcome To ISPACE Travel</h2>
    <p>Discover your next destination with curated restaurants and breathtaking adventures.</p>
    <p>Your journey begins here — explore, dine, and experience the best spots around the Philippines.</p>
    <a href="locations.php" class="btn btn-primary mt-3">Browse All Destinations</a>
</div>
</section>

<!-- RESTAURANTS -->
<section id="destinations" class="restaurant">
<div class="container py-5">
    <h5 class="section-sub">TOP DESTINATION</h5>
    <h2 class="fw-bold mb-4">Popular Restaurants</h2>
    <div class="row g-4">
        <?php for ($i=0;$i<3;$i++){ 
            $name = $resto[$pick_resto[$i]][0]; $place = $resto[$pick_resto[$i]][1]; $price = $resto[$pick_resto[$i]][2]; $img = $resto[$pick_resto[$i]][3]; ?>
        <div class="col-md-4">
            <form method="POST" action="landing.php">
                <input type="hidden" name="type" value="resto">
                <input type="hidden" name="index" value="<?php echo $pick_resto[$i]; ?>">
                <div class="card shadow-sm">
                    <img src="images/<?php echo $img; ?>" class="package-img">
                    <div class="p-3">
                        <h5><?php echo $name; ?></h5>
                        <p><?php echo $place; ?></p>
                        <p class="fw-bold">₱<?php echo $price; ?></p>
                    </div>
                    <button class="btn btn-primary w-100">View Details</button>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</div>
</section>

<!-- ACTIVITIES -->
<section class="activities">
<div class="container py-5">
    <h5 class="section-sub">CHOOSE YOUR ACTIVITY</h5>
    <h2 class="fw-bold mb-4">Featured Activities</h2>
    <div class="row g-4">
        <?php for ($i=0;$i<3;$i++){ 
            $name = $act[$pick_act[$i]][0]; $place = $act[$pick_act[$i]][1]; $price = $act[$pick_act[$i]][2]; $img = $act[$pick_act[$i]][3]; ?>
        <div class="col-md-4">
            <form method="POST" action="landing.php">
                <input type="hidden" name="type" value="act">
                <input type="hidden" name="index" value="<?php echo $pick_act[$i]; ?>">
                <div class="card shadow-sm">
                    <img src="images/<?php echo $img; ?>" class="package-img">
                    <div class="p-3">
                        <h5><?php echo $name; ?></h5>
                        <p><?php echo $place; ?></p>
                        <p class="fw-bold">₱<?php echo $price; ?></p>
                    </div>
                    <button class="btn btn-primary w-100">View Details</button>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</div>
</section>

<!-- MODAL -->
<section>
<div class="modal fade" id="authModal">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content p-4" style="border-radius: 15px;">
<h3 class="fw-bold text-center mb-4">Welcome to ISPACE</h3>
<form method="POST" action="login_process.php" class="mb-4">
    <h5 class="fw-bold mb-2">Login</h5>
    <label>Email</label>
    <input type="text" name="email_login" class="form-control mb-2">
    <label>Password</label>
    <input type="password" name="pass_login" class="form-control mb-3">
    <button class="btn btn-primary w-100 py-2">Login</button>
</form>
<hr class="my-4">
<form method="POST" action="register_process.php">
    <h5 class="fw-bold mb-2">Create New Account</h5>
    <label>Username</label>
    <input type="text" name="username_reg" class="form-control mb-2">
    <label>Email</label>
    <input type="text" name="email_reg" class="form-control mb-2">
    <label>Password</label>
    <input type="password" name="pass_reg" class="form-control mb-3">
    <button class="btn btn-success w-100 py-2">Register</button>
</form>
</div>
</div>
</div>
</section>

<!-- FOOTER -->
<footer>
<p class="mb-0">© 2025. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Navbar scroll
window.addEventListener("scroll", function () {
    var navbar = document.querySelector(".navbar-custom");
    var heroText = document.querySelector(".hero-text");
    if(window.scrollY>50){ navbar.classList.add("scrolled"); if(heroText!=null){ heroText.style.transform="translateX(-50%) translateY(-20px)"; heroText.style.opacity="0.85"; } }
    else{ navbar.classList.remove("scrolled"); if(heroText!=null){ heroText.style.transform="translateX(-50%) translateY(0)"; heroText.style.opacity="1"; } }
});

// Card fade-in
function checkCardsVisibility(){ var cards=document.querySelectorAll(".card"); var triggerBottom=window.innerHeight*0.9; for(var i=0;i<cards.length;i++){ var cardTop=cards[i].getBoundingClientRect().top; if(cardTop<triggerBottom){ cards[i].classList.add("visible"); } } }
window.addEventListener("scroll",checkCardsVisibility);
window.addEventListener("load",checkCardsVisibility);

// Smooth scroll
var navLinks=document.querySelectorAll(".nav-link"); for(var i=0;i<navLinks.length;i++){ navLinks[i].addEventListener("click",function(e){ var target=this.getAttribute("href"); if(target.startsWith("#")){ e.preventDefault(); var targetElement=document.querySelector(target); if(targetElement){ var topOffset=70; var elementPosition=targetElement.offsetTop; window.scrollTo({top:elementPosition-topOffset,behavior:"smooth"}); } } }); }
</script>
</body>
</html>
