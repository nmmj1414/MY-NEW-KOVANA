<?php
session_start();
include("../dbconnect/db.php");

/* LOGIN CHECK */
if (array_key_exists("userID", $_SESSION) == 0) {
    $_SESSION["userID"] = "";
}

/* LOGIN CHECK */
if ($_SESSION["userID"] == "") {
    header("Location: ../Home/home.php");
    exit();
}

$userID = $_SESSION["userID"];
$username = "";

if (array_key_exists("username", $_SESSION) != 0) {
    $username = $_SESSION["username"];
}

/* FETCH BOOKINGS */
$sql = "
SELECT id,destination_name,price,selected_date,message,img_file,payment_status
FROM bookings
WHERE user_id = ?
ORDER BY id DESC
";

$oke = sqlsrv_query($conn, $sql, array($userID));
?>
<!DOCTYPE html>
<html>

<head>
    <title>My Booked Places</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Home/homestyles.css?v=<?php echo time(); ?>">
</head>

<body>


    <nav class="navbar navbar-expand-lg travel-navbar">
        <div class="container">
            <a class="navbar-brand site-logo" href="../Home/home.php">KOVANA</a>
            <button class="nav-action-btn toggle ms-2" onclick="toggleTheme()">🌙</button>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navmenu">
                <div class="collapse navbar-collapse show">
                    <ul class="navbar-nav mx-auto nav-links">
                        <li class="nav-item"><a class="nav-link" href="../Home/home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="../booking/locations.php">Destinations</a></li>
                        <li class="nav-item"><a class="nav-link" href="../Home/aboutus.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="../Home/contact.php">Contact</a></li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <?php
                        $picDisplay = "../images/default.jpg";
                        if (array_key_exists("profile_pic", $_SESSION) && $_SESSION["profile_pic"] != "") {
                            $pic = $_SESSION["profile_pic"];
                            if (strpos($pic, "http") === 0) {
                                $picDisplay = $pic;
                            } else {
                                $picDisplay = "../profpics/" . $pic;
                            }
                        }
                        echo '<img src="' . $picDisplay . '" style="width:35px; height:35px; border-radius:50%; object-fit:cover;" class="me-2">';
                        ?>
                        <div class="nav-user-box me-2"><?php echo $username; ?></div>
                        <form method="POST" action="../LoginRegister/logout.php">
                            <input type="hidden" name="redirect" value="../Home/home.php">
                            <button class="nav-action-btn logout-btn ms-2">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="page-offset"></div>

    <div class="container pt-4">
        <h2 class="fw-bold text-center mb-4">My Booked Places</h2>
    </div>

    <div class="container pb-5">
        <div class="row g-4">

            <?php while ($row = sqlsrv_fetch_array($oke, SQLSRV_FETCH_ASSOC)) { ?>

                <?php
                $status = $row["payment_status"];
                $color = "text-warning";
                if ($status == "Paid") {
                    $color = "text-success";
                }
                ?>

                <div class="col-md-4 d-flex">
                    <div class="card shadow-sm h-100 d-flex flex-column">
                        <img src="../images/<?php echo $row["img_file"]; ?>" class="package-img">
                        <div class="p-3 flex-grow-1">
                            <h5 class="fw-bold"><?php echo $row["destination_name"]; ?></h5>
                            <p><strong>Date:</strong> <?php echo $row["selected_date"]->format("Y-m-d"); ?></p>
                            <p><strong>Price:</strong> ₱<?php echo $row["price"]; ?></p>
                            <p><strong>Note:</strong> <?php echo $row["message"]; ?></p>
                            <p class="<?php echo $color; ?>"><strong>Status:</strong> <?php echo $status; ?></p>
                        </div>

                        <?php if ($status == "pending") { ?>

                            <a href="create_payment.php?booking_id=<?php echo $row["id"]; ?>"
                                class="btn btn-success w-100 mt-auto">
                                Pay Now
                            </a>

                        <?php } else if ($status == "Cancelled") { ?>

                            <button class="btn btn-secondary w-100 mt-auto" disabled>
                                Cancelled
                            </button>

                        <?php } else { ?>

                            <a href="cancel_booking.php?id=<?php echo $row["id"]; ?>"
                                class="btn btn-danger w-100 mt-auto"
                                onclick="return confirm('Are you sure you want to cancel this booking?');">
                                Cancel
                            </a>

                        <?php } ?>

                    </div>
                </div>

            <?php } ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php include("../Home/footer.php"); ?>
</body>

</html>