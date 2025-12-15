<?php
session_start();
include("../dbconnect/db.php");

/* LOGIN CHECK */
if (@$_SESSION["userID"] == "") {
    header("Location: ../Home/home.php");
    exit();
}

$userID = $_SESSION["userID"];
$username = "";

if (@$_SESSION["username"] != "") {
    $username = $_SESSION["username"];
}

/* FETCH BOOKINGS */
$sql = "
SELECT id, destination_name, price, selected_date, message, img_file
FROM bookings
WHERE user_id = ?
ORDER BY id DESC
";

$stmt = sqlsrv_query($conn, $sql, array($userID));
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Booked Places</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Home/homestyles.css?v=<?php echo time(); ?>">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg travel-navbar">
        <div class="container">

            <a class="navbar-brand site-logo" href="../Home/home.php">KOVANA</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navmenu">

                <ul class="navbar-nav mx-auto nav-links">
                    <li class="nav-item"><a class="nav-link" href="../Home/home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../booking/locations.php">Destinations</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Home/aboutus.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Home/contact.php">Contact</a></li>
                </ul>

                <div class="d-flex align-items-center">
                    <div class="nav-user-box me-2"><?php echo $username; ?></div>

                    <a href="../booking/bookedplaces.php" class="nav-action-btn ms-2">
                        Your Booked Places
                    </a>

                    <form method="POST" action="../LoginRegister/logout.php">
                        <button class="nav-action-btn logout-btn ms-2">Logout</button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <!-- OFFSET FOR FIXED NAVBAR -->
    <div class="page-offset"></div>

    <!-- PAGE TITLE -->
    <div class="container pt-4">
        <h2 class="fw-bold text-center mb-4">My Booked Places</h2>
    </div>

    <!-- BOOKINGS -->
    <div class="container pb-5">
        <div class="row g-4">

            <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>

                <div class="col-md-4 d-flex">
                    <div class="card shadow-sm h-100 d-flex flex-column">

                        <img src="../images/<?php echo $row["img_file"]; ?>" class="package-img">

                        <div class="p-3 flex-grow-1">
                            <h5 class="fw-bold"><?php echo $row["destination_name"]; ?></h5>
                            <p><strong>Date:</strong> <?php echo $row["selected_date"]; ?></p>
                            <p><strong>Price:</strong> ₱<?php echo $row["price"]; ?></p>
                            <p><strong>Note:</strong> <?php echo $row["message"]; ?></p>
                        </div>

                        <a href="create_payment.php?booking_id=<?php echo $row["id"]; ?>"
                            class="btn btn-success w-100 mt-auto">
                            Pay Now (Demo)
                        </a>

                    </div>
                </div>

            <?php } ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php include("../Home/footer.php"); ?>
</body>

</html>