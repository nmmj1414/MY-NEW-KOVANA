<?php
include("locations_data.php");

// READ POST DATA
$type = $_POST["type"];
$index = $_POST["index"];

// DEFAULT VALUES
$name = "";
$place = "";
$price = "";
$img = "";

// RESTAURANT
if ($type == "resto") {
    $name = $resto[$index][0];
    $place = $resto[$index][1];
    $price = $resto[$index][2];
    $img = $resto[$index][3];
}

// ACTIVITY
if ($type == "act") {
    $name = $act[$index][0];
    $place = $act[$index][1];
    $price = $act[$index][2];
    $img = $act[$index][3];
}

/* ---------------------------------------
   WEATHER API (OpenWeather)
---------------------------------------- */
/* ---------------------------------------
   WEATHER API (OpenWeather)
---------------------------------------- */
$weatherKey = "5e4fb336abdd12d34698f810a87c3ecd";

$weatherCity = $place;

// FIX INVALID CITY NAMES
if (strpos($weatherCity, "/") !== false) {
    $parts = explode("/", $weatherCity);
    $weatherCity = trim($parts[0]); // Use only the first city name
}

$encodedCity = urlencode($weatherCity);

$weatherUrl =
    "https://api.openweathermap.org/data/2.5/weather?q=" .
    $encodedCity .
    "&appid=" . $weatherKey .
    "&units=metric";

$weatherJson = @file_get_contents($weatherUrl); // prevent warning
$weatherData = json_decode($weatherJson, true);

$temperature = "";
$condition = "";
$icon = "";

if ($weatherData != null && array_key_exists("main", $weatherData)) {

    $temperature = $weatherData["main"]["temp"];

    if (array_key_exists("weather", $weatherData) && count($weatherData["weather"]) > 0) {
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
    <link rel="stylesheet" href="homestyles.css?v=<?php echo time(); ?>">
</head>
<body>

<!-- TOP CONTACT -->
<div class="top-contact">
    <div class="container d-flex justify-content-between">
        <div>
            <span>📞 09123456789</span>
            <span class="ms-3">⏱️ Mon – Fri 09:00 – 17:00</span>
        </div>
        <div>
            <span class="me-3">🌐</span>
            <span class="me-3">📘</span>
            <span class="me-3">📸</span>
        </div>
    </div>
</div>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="home.php">ISPACE</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">HOME</a></li>
                <li class="nav-item"><a class="nav-link active" href="locations.php">DESTINATIONS</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container py-5">
    <div class="row g-4">

        <!-- LEFT SIDE -->
        <div class="col-md-6">
            <img src="images/<?php echo $img; ?>" class="package-img rounded mb-3">

            <h2 class="fw-bold"><?php echo $name; ?></h2>
            <h5 class="text-muted mb-3"><?php echo $place; ?></h5>

            <h4 class="fw-bold mt-4">Price: ₱<?php echo $price; ?></h4>

            <!-- WEATHER DISPLAY -->
            <?php if ($temperature != "") { ?>
                <div class="mt-3 p-3 border rounded bg-light text-dark">
                    <h6 class="fw-bold mb-2">Weather in <?php echo $place; ?>:</h6>
                    <img src="https://openweathermap.org/img/wn/<?php echo $icon; ?>@2x.png"
                         style="width:50px; vertical-align:middle;">
                    <span style="font-size:18px; font-weight:bold;">
                        <?php echo $temperature; ?>°C — <?php echo ucfirst($condition); ?>
                    </span>
                </div>
            <?php } ?>

        </div>

        <!-- RIGHT SIDE FORM -->
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h4 class="fw-bold mb-3">Book This Destination</h4>

                <form method="POST" action="booking_insert.php">

                    <!-- KEEP THESE FOR THE INSERT -->
                    <input type="hidden" name="name" value="<?php echo $name; ?>">
                    <input type="hidden" name="place" value="<?php echo $place; ?>">
                    <input type="hidden" name="price" value="<?php echo $price; ?>">
                    <input type="hidden" name="img" value="<?php echo $img; ?>">

                    <div class="mb-3">
                        <label class="fw-bold">Full Name *</label>
                        <input type="text" name="fullname" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Email *</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Date *</label>
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

<footer class="py-3 text-center bg-white mt-4">
    <p class="mb-0">© 2024. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
