<?php
session_start();
include("locations_data.php");

/* SESSION SAFE */
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

/* READ POST */
$type = $_POST["type"];
$index = $_POST["index"];

/* DEFAULT */
$name = "";
$place = "";
$price = "";
$img = "";

/* DATA SOURCE */
if ($type == "resto") {
    $name = $resto[$index][0];
    $place = $resto[$index][1];
    $price = $resto[$index][2];
    $img = $resto[$index][3];
}

if ($type == "act") {
    $name = $act[$index][0];
    $place = $act[$index][1];
    $price = $act[$index][2];
    $img = $act[$index][3];
}

/* WEATHER */
$weatherKey = "5e4fb336abdd12d34698f810a87c3ecd";
$weatherCity = $place;

if (strpos($weatherCity, "/") !== false) {
    $parts = explode("/", $weatherCity);
    $weatherCity = trim($parts[0]);
}

$weatherUrl =
    "https://api.openweathermap.org/data/2.5/weather?q=" .
    urlencode($weatherCity) .
    "&appid=" . $weatherKey .
    "&units=metric";

$weatherJson = @file_get_contents($weatherUrl);
$weatherData = json_decode($weatherJson, true);

$temperature = "";
$condition = "";
$icon = "";

if ($weatherData != null && array_key_exists("main", $weatherData)) {
    $temperature = $weatherData["main"]["temp"];
    if (array_key_exists("weather", $weatherData)) {
        $condition = $weatherData["weather"][0]["description"];
        $icon = $weatherData["weather"][0]["icon"];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Booking Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Home/homestyles.css?v=<?php echo time(); ?>">
</head>

<body>

    <!-- NAVBAR (SAME AS HOME) -->
    <nav class="navbar navbar-expand-lg travel-navbar">
        <div class="container">

            <a class="navbar-brand site-logo" href="../Home/home.php">KOVANA</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav mx-auto nav-links">
                    <li class="nav-item"><a class="nav-link" href="../Home/home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="locations.php">Destinations</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Home/aboutus.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Home/contact.php">Contact</a></li>
                </ul>

                <?php if ($logged == 0) { ?>
                    <button class="nav-action-btn" data-bs-toggle="modal" data-bs-target="#authModal">
                        Login / Register
                    </button>
                <?php } else { ?>
                    <div class="d-flex align-items-center">
                        <div class="nav-user-box me-2"><?php echo $displayName; ?></div>

                        <a href="bookedplaces.php" class="nav-action-btn ms-2">
                            Your Booked Places
                        </a>

                        <form method="POST" action="../LoginRegister/logout.php">
                            <button class="nav-action-btn logout-btn ms-2">Logout</button>
                        </form>
                    </div>
                <?php } ?>
            </div>

        </div>
    </nav>
    <div class="page-offset"></div>

    <!-- CONTENT -->
    <div class="container py-5">
        <div class="row g-4">

            <div class="col-md-6 mt-4">
                <img src="../images/<?php echo $img; ?>" class="package-img rounded mb-3">

                <h2 class="fw-bold"><?php echo $name; ?></h2>
                <h5 class="text-muted"><?php echo $place; ?></h5>

                <h4 class="fw-bold mt-4">Price: ₱<?php echo $price; ?></h4>

                <?php if ($temperature != "") { ?>
                    <div class="mt-3 p-3 border rounded bg-light">
                        <img src="https://openweathermap.org/img/wn/<?php echo $icon; ?>@2x.png" width="50">
                        <strong><?php echo $temperature; ?>°C</strong>
                        — <?php echo ucfirst($condition); ?>
                    </div>
                <?php } ?>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card shadow-sm p-4">
                    <h4 class="fw-bold mb-3">Book This Destination</h4>

                    <form method="POST" action="booking_insert.php">

                        <input type="hidden" name="name" value="<?php echo $name; ?>">
                        <input type="hidden" name="place" value="<?php echo $place; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="hidden" name="img" value="<?php echo $img; ?>">

                        <div class="mb-3">
                            <label class="fw-bold">Full Name</label>
                            <input type="text" name="fullname" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Date</label>
                            <input type="date" name="date" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Message</label>
                            <textarea name="note" class="form-control" rows="4"></textarea>
                        </div>

                        <button class="btn btn-primary w-100 py-2">Submit Booking</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- LOGIN / REGISTER MODAL -->
    <div class="modal fade" id="authModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4" style="border-radius:15px;">
                <h3 class="fw-bold text-center mb-4">Welcome to KOVANA</h3>

                <form method="POST" action="../LoginRegister/login_process.php">
                    <input type="text" name="email_login" class="form-control mb-2" placeholder="Email">
                    <input type="password" name="pass_login" class="form-control mb-3" placeholder="Password">
                    <button class="btn btn-primary w-100">Login</button>
                </form>

                <hr>

                <form method="POST" action="../LoginRegister/register_process.php">
                    <input type="text" name="username_reg" class="form-control mb-2" placeholder="Username">
                    <input type="text" name="email_reg" class="form-control mb-2" placeholder="Email">
                    <input type="password" name="pass_reg" class="form-control mb-3" placeholder="Password">
                    <button class="btn btn-success w-100">Register</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php include("../Home/footer.php"); ?>

</body>

</html>