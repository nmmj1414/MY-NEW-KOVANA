<?php
session_start();
include("../booking/locations_data.php");

if (array_key_exists("username", $_SESSION) == 0) {
    $_SESSION["username"] = "";
}

if (array_key_exists("userID", $_SESSION) == 0) {
    $_SESSION["userID"] = "";
}

$logged = 0;
$displayName = "";

if ($_SESSION["username"] != "") {
    $logged = 1;
    $displayName = $_SESSION["username"];
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homestyles.css?v=<?php echo time(); ?>">
</head>

<body>

    <nav class="navbar navbar-expand-lg travel-navbar">
        <div class="container">

            <a class="navbar-brand site-logo" href="../Home/home.php">KOVANA</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav mx-auto nav-links">
                    <li class="nav-item">
                        <a class="nav-link active" href="../Home/home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../booking/locations.php">Destinations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Home/aboutus.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Home/contact.php">Contact</a>
                    </li>
                </ul>

                <?php if ($logged == 0) { ?>

                    <button class="nav-action-btn" data-bs-toggle="modal" data-bs-target="#authModal">
                        Login / Register
                    </button>

                <?php } else { ?>

                    <div class="d-flex align-items-center">
                        <div class="nav-user-box me-2">
                            <?php echo $displayName; ?>
                        </div>

                        <a href="../booking/bookedplaces.php" class="nav-action-btn ms-2">
                            Your Booked Places
                        </a>

                        <form method="POST" action="../LoginRegister/logout.php">
                            <button class="nav-action-btn logout-btn ms-2">
                                Logout
                            </button>
                        </form>
                    </div>

                <?php } ?>
            </div>
        </div>
    </nav>


    <div class="hero-section" style="background-image:url('../images/travel.jpg');">
        <div class="hero-text">
            <h1>Majestic Adventures Await YOU</h1>
        </div>
    </div>

    <!-- RESTAURANTS CAROUSEL (MOVE BY 3) -->
    <div class="container py-5">
        <h5 class="section-sub">TOP DESTINATION</h5>
        <h2 class="fw-bold mb-4">Popular Restaurants</h2>

        <div id="restoCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-wrap="true">
            <div class="carousel-inner">

                <?php
                $total = count($resto);
                $slide = 0;

                for ($i = 0; $i < $total; $i = $i + 3) {

                    if ($i + 2 >= $total) {
                        break;
                    }

                    $active = ($slide == 0) ? "active" : "";
                    $slide = $slide + 1;
                    ?>
                    <div class="carousel-item <?php echo $active; ?>">
                        <div class="row g-4">

                            <?php
                            for ($j = $i; $j < $i + 3; $j++) {
                                ?>
                                <div class="col-md-4 d-flex">
                                    <form method="POST" action="../booking/landing.php" class="flex-grow-1">
                                        <input type="hidden" name="type" value="resto">
                                        <input type="hidden" name="index" value="<?php echo $j; ?>">
                                        <div class="card shadow-sm h-100 d-flex flex-column">
                                            <img src="../images/<?php echo $resto[$j][3]; ?>" class="package-img">
                                            <div class="p-3 flex-grow-1">
                                                <h5 class="fw-bold"><?php echo $resto[$j][0]; ?></h5>
                                                <p><?php echo $resto[$j][1]; ?></p>
                                                <p class="fw-bold">₱<?php echo $resto[$j][2]; ?></p>
                                            </div>
                                            <?php if ($logged == 1) { ?>

                                                <button class="btn btn-primary w-100 mt-auto">
                                                    View Details
                                                </button>

                                            <?php } else { ?>

                                                <button type="button" class="btn btn-primary w-100 mt-auto"
                                                    onclick="requireLogin();">
                                                    View Details
                                                </button>



                                            <?php } ?>

                                        </div>
                                    </form>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                <?php } ?>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#restoCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#restoCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>

    <!-- ACTIVITIES CAROUSEL (MOVE BY 3) -->
    <div class="container py-5">
        <h5 class="section-sub">CHOOSE YOUR ACTIVITY</h5>
        <h2 class="fw-bold mb-4">Featured Activities</h2>

        <div id="actCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-wrap="true">
            <div class="carousel-inner">

                <?php
                $total2 = count($act);
                $slide2 = 0;

                for ($i = 0; $i < $total2; $i = $i + 3) {

                    if ($i + 2 >= $total2) {
                        break;
                    }

                    $active2 = ($slide2 == 0) ? "active" : "";
                    $slide2 = $slide2 + 1;
                    ?>
                    <div class="carousel-item <?php echo $active2; ?>">
                        <div class="row g-4">

                            <?php
                            for ($j = $i; $j < $i + 3; $j++) {
                                ?>
                                <div class="col-md-4 d-flex">
                                    <form method="POST" action="../booking/landing.php" class="flex-grow-1">
                                        <input type="hidden" name="type" value="act">
                                        <input type="hidden" name="index" value="<?php echo $j; ?>">
                                        <div class="card shadow-sm h-100 d-flex flex-column">
                                            <img src="../images/<?php echo $act[$j][3]; ?>" class="package-img">
                                            <div class="p-3 flex-grow-1">
                                                <h5 class="fw-bold"><?php echo $act[$j][0]; ?></h5>
                                                <p><?php echo $act[$j][1]; ?></p>
                                                <p class="fw-bold">₱<?php echo $act[$j][2]; ?></p>
                                            </div>
                                            <button class="btn btn-primary w-100 mt-auto">View Details</button>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                <?php } ?>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#actCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#actCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
    <div id="loginWarning" style="display:none;
            background:#ffeaea;
            border:1px solid #ff4d4d;
            color:#b30000;
            padding:10px;
            border-radius:6px;
            margin-bottom:15px;
            font-weight:600;
            text-align:center;">
        You need to be logged in first before you can book.
    </div>

    <!-- LOGIN / REGISTER MODAL (UNCHANGED, PRESENT) -->
    <div class="modal fade" id="authModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4" style="border-radius: 15px;">

                <h3 class="fw-bold text-center mb-4">Welcome to KOVANA</h3>

                <form method="POST" action="../LoginRegister/login_process.php" class="mb-4">
                    <h5 class="fw-bold mb-2">Login</h5>

                    <label>Email</label>
                    <input type="text" name="email_login" class="form-control mb-1">

                    <label>Password</label>
                    <input type="password" name="pass_login" class="form-control mb-2">

                    <button class="btn btn-primary w-100 py-1">Login</button>
                </form>

                <hr class="my-4">

                <form method="POST" action="../LoginRegister/register_process.php">
                    <h5 class="fw-bold mb-1">Create New Account</h5>

                    <label>Username</label>
                    <input type="text" name="username_reg" class="form-control mb-1">

                    <label>Email</label>
                    <input type="text" name="email_reg" class="form-control mb-1">

                    <label>Password</label>
                    <input type="password" name="pass_reg" class="form-control mb-2">

                    <button class="btn btn-success w-100 py-1">Register</button>
                </form>

                <hr style="margin:10px 0; opacity:0.3;">

                <div class="text-center fw-bold mb-2">OR</div>

                <button onclick="googlePrompt()" class="w-100 py-2" style="border:1px solid #ccc;border-radius:8px;background:white;
                       display:flex;align-items:center;justify-content:center;
                       gap:10px;font-weight:600;">
                    <img src="../images/google_icon.png" width="20">
                    Continue with Google
                </button>

                <div id="g_id_onload"
                    data-client_id="397070442652-a36b7hmfeah7sag869fsrgqdcpkvcrs6.apps.googleusercontent.com"
                    data-context="signin" data-ux_mode="popup" data-callback="handleGoogle" data-auto_prompt="false">
                </div>

                <div class="g_id_signin" style="display:none;"></div>

            </div>
        </div>
    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        new bootstrap.Carousel(document.getElementById("restoCarousel"), {
            interval: 6000,
            wrap: true
        });

        new bootstrap.Carousel(document.getElementById("actCarousel"), {
            interval: 6000,
            wrap: true
        });
    </script>
    <script src="https://accounts.google.com/gsi/client" async></script>

    <script>
        function googlePrompt() {
            google.accounts.id.prompt();
        }

        function handleGoogle(response) {
            var token = response.credential;

            var form = document.createElement("form");
            form.method = "POST";
            form.action = "../LoginRegister/google_login.php";

            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "token";
            input.value = token;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
    <script>
        function requireLogin() {
            var warn = document.getElementById("loginWarning");
            if (warn) {
                warn.style.display = "block";
            }

            var modal = new bootstrap.Modal(document.getElementById("authModal"));
            modal.show();
        }
    </script>
    <?php include("footer.php"); ?>
</body>

</html>