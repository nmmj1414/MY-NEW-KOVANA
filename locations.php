<?php
include("locations_data.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Destinations</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="homestyles.css?v=<?php echo time(); ?>">
</head>
<body>

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

<div class="container py-5">
    <h2 class="fw-bold text-center mb-4">All Available Destinations</h2>
</div>

<!-- ===================== RESTAURANTS ===================== -->
<div class="container py-4">
    <h4 class="fw-bold mb-3">Restaurants</h4>

    <div class="row g-4">

        <?php
        for ($i = 0; $i < 15; $i++) {

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

<!-- ===================== ACTIVITIES ===================== -->
<div class="container py-5">
    <h4 class="fw-bold mb-3">Activities</h4>

    <div class="row g-4">

        <?php
        for ($x = 0; $x < 15; $x++) {

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

<footer class="py-3 text-center bg-white mt-4">
    <p class="mb-0">© 2024. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
