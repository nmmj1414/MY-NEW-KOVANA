<?php
session_start();
include("../dbconnect/db.php");

/* LOGIN CHECK */
if (array_key_exists("userID", $_SESSION) == 0) {
    echo "
    <script>
    alert('Please login first.');
    window.location='../Home/home.php';
    </script>
    ";
    exit();
}

/* GET BOOKING ID */
$id = "";
if (array_key_exists("id", $_GET)) {
    $id = $_GET["id"];
}

if ($id != "") {
    /* UPDATE STATUS TO CANCELLED */
    $sql = "UPDATE bookings SET payment_status = 'Cancelled' WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "
    <script>
    alert('Booking cancelled successfully.');
    window.location='Bookedplaces.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('Invalid Booking ID.');
    window.location='Bookedplaces.php';
    </script>
    ";
}
?>
