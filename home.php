<?php
include("../booking/locations_data.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container">

        <a class="navbar-brand fw-bold" href="home.php">KOVANA</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../booking/locations.php">Destinations</a></li>
                <li class="nav-item"><a class="nav-link" href="aboutus.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>

            <div class="d-flex">
                <a href="../LoginRegister/login.php" class="btn btn-outline-primary me-2">
                    Login
                </a>
                <a href="../LoginRegister/register.php" class="btn btn-primary">
                    Register
                </a>
            </div>
        </div>

    </div>
</nav>

<div class="container-fluid p-0">
    <div class="bg-dark text-white text-center py-5">
        <h1 class="fw-bold">Majestic Adventures Await YOU</h1>
        <p class="mt-2">Explore destinations, food, and activities</p>
    </div>
</div>

<div class="container py-5" style="max-width:1100px;">
    <h3 class="fw-bold text-center mb-4">Popular Restaurants</h3>

    <div class="row g-4">
        <?php
        for ($i = 0; $i < 3; $i++) {
        ?>
        <div class="col-md-4 d-flex">
            <div class="card shadow-sm h-100 d-flex flex-column">
                <img src="../images/<?php echo $resto[$i][3]; ?>" class="card-img-top">
                <div class="card-body flex-grow-1">
                    <h5 class="fw-bold"><?php echo $resto[$i][0]; ?></h5>
                    <p class="mb-1"><?php echo $resto[$i][1]; ?></p>
                    <p class="fw-bold">₱<?php echo $resto[$i][2]; ?></p>
                </div>
                <a href="../booking/locations.php" class="btn btn-primary w-100">
                    View Details
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<hr class="my-5">

<div class="container py-5" style="max-width:1100px;">
    <h3 class="fw-bold text-center mb-4">Featured Activities</h3>

    <div class="row g-4">
        <?php
        for ($i = 0; $i < 3; $i++) {
        ?>
        <div class="col-md-4 d-flex">
            <div class="card shadow-sm h-100 d-flex flex-column">
                <img src="../images/<?php echo $act[$i][3]; ?>" class="card-img-top">
                <div class="card-body flex-grow-1">
                    <h5 class="fw-bold"><?php echo $act[$i][0]; ?></h5>
                    <p class="mb-1"><?php echo $act[$i][1]; ?></p>
                    <p class="fw-bold">₱<?php echo $act[$i][2]; ?></p>
                </div>
                <a href="../booking/locations.php" class="btn btn-primary w-100">
                    View Details
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php include("footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
