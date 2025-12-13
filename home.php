<?php
session_start();
include("locations_data.php");
if (array_key_exists("username", $_SESSION) == 0) {
    $_SESSION["username"] = "";
}

if (array_key_exists("userID", $_SESSION) == 0) {
    $_SESSION["userID"] = "";
}

// LOGIN CHECK
$logged = 0;
$displayName = "";

if ($_SESSION["username"] != "") {
    $logged = 1;
    $displayName = $_SESSION["username"];
}

// PICK 3 RESTAURANTS
$pick_resto = array();
$pick_resto[0] = 0;
$pick_resto[1] = 7;
$pick_resto[2] = 13;

// PICK 3 ACTIVITIES
$pick_act = array();
$pick_act[0] = 0;
$pick_act[1] = 5;
$pick_act[2] = 12;

?>

<!DOCTYPE html>
<html>

<head>
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homestyles.css">
</head>

<body>
    <header>
        <!-- ===================== NAVBAR ===================== -->
        <nav class="navbar navbar-expand-lg py-0 fixed-top"">
            <div class=" container">

            <a class="navbar-brand fw-bold" href="home.php">
                <img src="images/KOVANA_LOGO.png" alt="logo" style="height:50px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- LOGIN / REGISTER -->
            <?php
            if ($logged == 0) {
            ?>
                <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#authModal">
                    Login / Register
                </button>
            <?php
            }
            ?>

            <?php
            if ($logged == 1) {
            ?>
                <div class="d-flex align-items-center">

                    <!-- Username Box -->
                    <div class="me-2 px-3 py-2 bg-light border rounded">
                        <?php echo $displayName; ?>
                    </div>

                    <!-- YOUR BOOKED PLACES BUTTON -->
                    <a href="bookedplaces.php" class="btn btn-primary ms-2">
                        Your Booked Places
                    </a>

                    <!-- LOGOUT BUTTON -->
                    <form method="POST" action="logout.php">
                        <button class="btn btn-danger ms-2">Logout</button>
                    </form>

                </div>
            <?php
            }
            ?>

            <!-- NAV LINKS -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Destinations</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                </ul>
            </div>
            </div>
        </nav>
    </header>

    <!-- ===================== SLIDER ===================== -->
    <section id="slider">
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="3"></button>
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="4"></button>
            </div>

            <div class="carousel-inner">

                <div class="carousel-item active">
                    <img src="images/TRAVEL.jpg" class="d-block w-100">
                    <div class="carousel-caption">
                        <h5>WELCOME TO KOVANA!</h5>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="images/PAMPANGA.jpg" class="d-block w-100">
                    <div class="carousel-caption">
                        <h5>ANGELES, PAMPANGA</h5>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="images/BANAUE.jpg" class="d-block w-100">
                    <div class="carousel-caption">
                        <h5>BANAUE</h5>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="images/CEBU.jpg" class="d-block w-100">
                    <div class="carousel-caption">
                        <h5>CEBU</h5>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="images/BORACAY.jpg" class="d-block w-100">
                    <div class="carousel-caption">
                        <h5>BORACAY</h5>
                    </div>
                </div>

            </div>

            <button class="carousel-control-prev" type="button"
                data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button"
                data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>
    <section>
        <!-- ===================== ABOUT ===================== -->
        <div class="container py-5">
            <h2 class="text-center fw-bold">Welcome To ISPACE Travel</h2>

            <p class="mt-3 text-center">
                Discover your next destination with curated restaurants and breathtaking adventures.
            </p>

            <p class="text-center">
                Your journey begins here — explore, dine, and experience the best spots around the Philippines.
            </p>

            <div class="text-center mt-4">
                <a href="locations.php" class="btn btn-primary px-4">Browse All Destinations</a>
            </div>
        </div>
    </section>
    <section>
        <!-- ===================== POPULAR RESTAURANTS ===================== -->
        <div class="container py-5">
            <h5 class="section-sub">TOP DESTINATION</h5>
            <h2 class="fw-bold mb-4">Popular Restaurants</h2>

            <div class="row g-4">

                <?php
                for ($i = 0; $i < 3; $i++) {

                    $name = $resto[$i][0];
                    $place = $resto[$i][1];
                    $price = $resto[$i][2];
                    $img = $resto[$i][3];
                ?>
                    <div class="col-md-4 d-flex">
                        <form method="POST" action="landing.php" class="flex-grow-1">

                            <input type="hidden" name="type" value="resto">
                            <input type="hidden" name="index" value="<?php echo $i; ?>">

                            <div class="card shadow-sm h-100 d-flex flex-column">
                                <img src="images/<?php echo $img; ?>" class="package-img">

                                <div class="p-3 flex-grow-1">
                                    <h5 class="fw-bold"><?php echo $name; ?></h5>
                                    <p class="mb-1"><?php echo $place; ?></p>

                                    <p class="fw-bold">₱<?php echo $price; ?></p>
                                </div>

                                <button class="btn btn-primary w-100 mt-auto">View Details</button>
                            </div>

                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section>
        <!-- ===================== FEATURED ACTIVITIES ===================== -->
        <div class="container py-5">
            <h5 class="section-sub">CHOOSE YOUR ACTIVITY</h5>
            <h2 class="fw-bold mb-4">Featured Activities</h2>

            <div class="row g-4">

                <?php
                for ($x = 0; $x < 3; $x++) {

                    $name2 = $act[$x][0];
                    $place2 = $act[$x][1];
                    $price2 = $act[$x][2];
                    $img2 = $act[$x][3];
                ?>
                    <div class="col-md-4 d-flex">
                        <form method="POST" action="landing.php" class="flex-grow-1">

                            <input type="hidden" name="type" value="act">
                            <input type="hidden" name="index" value="<?php echo $x; ?>">

                            <div class="card shadow-sm h-100 d-flex flex-column">
                                <img src="images/<?php echo $img2; ?>" class="package-img">

                                <div class="p-3 flex-grow-1">
                                    <h5 class="fw-bold"><?php echo $name2; ?></h5>
                                    <p class="mb-1"><?php echo $place2; ?></p>

                                    <p class="fw-bold">₱<?php echo $price2; ?></p>
                                </div>

                                <button class="btn btn-primary w-100 mt-auto">View Details</button>
                            </div>

                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section>
        <!-- ================= LOGIN & REGISTER MODAL ================== -->
        <div class="modal fade" id="authModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4" style="border-radius: 15px;">

                    <h3 class="fw-bold text-center mb-4">Welcome to ISPACE</h3>

                    <!-- LOGIN FORM -->
                    <form method="POST" action="login_process.php" class="mb-4">
                        <h5 class="fw-bold mb-2">Login</h5>

                        <label class="mt-2">Email</label>
                        <input type="text" name="email_login" class="form-control mb-2">

                        <label>Password</label>
                        <input type="password" name="pass_login" class="form-control mb-3">

                        <button class="btn btn-primary w-100 py-2" style="border-radius: 8px;">Login</button>
                    </form>

                    <hr class="my-4">

                    <!-- REGISTER FORM -->
                    <form method="POST" action="register_process.php">
                        <h5 class="fw-bold mb-2">Create New Account</h5>

                        <label class="mt-2">Username</label>
                        <input type="text" name="username_reg" class="form-control mb-2">

                        <label>Email</label>
                        <input type="text" name="email_reg" class="form-control mb-2">

                        <label>Password</label>
                        <input type="password" name="pass_reg" class="form-control mb-3">

                        <button class="btn btn-success w-100 py-2" style="border-radius: 8px;">Register</button>
                    </form>

                    <hr class="my-4">
                    <div class="text-center fw-bold mb-2">OR</div>

                    <!-- CUSTOM GOOGLE BUTTON -->
                    <button onclick="googlePrompt()"
                        class="w-100 py-2"
                        style="
                    border: 1px solid #ccc;
                    border-radius: 8px;
                    background: white;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 10px;
                    font-weight: 600;
                ">
                        <img src="images/google_icon.png" width="20">
                        Continue with Google
                    </button>

                    <div id="g_id_onload"
                        data-client_id="397070442652-a36b7hmfeah7sag869fsrgqdcpkvcrs6.apps.googleusercontent.com"
                        data-context="signin"
                        data-ux_mode="popup"
                        data-callback="handleGoogle"
                        data-auto_prompt="false">
                    </div>

                    <div class="g_id_signin" style="display:none;"></div>

                </div>
            </div>
        </div>


        <script src="https://accounts.google.com/gsi/client" async></script>

        <script>
            function googlePrompt() {
                google.accounts.id.prompt();
            }

            function handleGoogle(response) {
                var token = response.credential;

                var form = document.createElement("form");
                form.method = "POST";
                form.action = "google_login.php";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "token";
                input.value = token;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        </script>

        <!-- FOOTER -->
        <footer class="py-3 text-center bg-white mt-4">
            <p class="mb-0">© 2025. All rights reserved.</p>
        </footer>
    </section>



    <!-- BOOTSTRAP JS (REQUIRED) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>