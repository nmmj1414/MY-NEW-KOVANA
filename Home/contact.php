<?php
session_start();

/* ensure session values exist */
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
    <title>Contact Us</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homestyles.css?v=<?php echo time(); ?>">
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg travel-navbar">
    <div class="container">

        <a class="navbar-brand site-logo" href="home.php">KOVANA</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav mx-auto nav-links">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../booking/locations.php">Destinations</a></li>
                <li class="nav-item"><a class="nav-link" href="aboutus.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
            </ul>

            <?php if ($logged == 0) { ?>
                <button class="nav-action-btn" data-bs-toggle="modal" data-bs-target="#authModal">
                    Login / Register
                </button>
            <?php } else { ?>
                <div class="d-flex align-items-center">
                    <div class="nav-user-box me-2"><?php echo $displayName; ?></div>
                    <a href="../booking/bookedplaces.php" class="nav-action-btn ms-2">Your Booked Places</a>
                    <form method="POST" action="../LoginRegister/logout.php">
                        <button class="nav-action-btn logout-btn ms-2">Logout</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>

<!-- ================= CONTENT ================= -->
<div class="container py-5">
    <div style="margin-top:40px;"></div>
    <h2 class="fw-bold text-center mb-4">Contact Us</h2>

    <p class="text-muted text-center mb-5">
        Have questions or need assistance? Reach out to us using the information below.
    </p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <p><strong>Email:</strong> support@kovana-travel.com</p>
            <p><strong>Phone:</strong> +63 912 345 6789</p>
            <p><strong>Office:</strong> Manila, Philippines</p>

            <hr>

            <p class="fw-bold">Follow Us</p>
            <p class="text-muted">
                Facebook: facebook.com/kovana <br>
                Instagram: instagram.com/kovana <br>
                Twitter: twitter.com/kovana
            </p>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include("footer.php"); ?>

</body>
</html>
