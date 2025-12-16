<?php
session_start();
include("../dbconnect/db.php");

/* READ USER ID IF LOGGED IN */
$user_id = 0;
if (array_key_exists("userID", $_SESSION) != 0) {
    if ($_SESSION["userID"] != "") {
        $user_id = $_SESSION["userID"];
    }
}

/* READ FORM INPUTS */
$fullname = "";
$email = "";
$date = "";
$note = "";
$name = "";
$place = "";
$price = "";
$img = "";

if ($_POST["fullname"] != "") {
    $fullname = $_POST["fullname"];
}
if ($_POST["email"] != "") {
    $email = $_POST["email"];
}
if ($_POST["date"] != "") {
    $date = $_POST["date"];
}
if ($_POST["note"] != "") {
    $note = $_POST["note"];
}

if ($_POST["name"] != "") {
    $name = $_POST["name"];
}
if ($_POST["place"] != "") {
    $place = $_POST["place"];
}
if ($_POST["price"] != "") {
    $price = $_POST["price"];
}
if ($_POST["img"] != "") {
    $img = $_POST["img"];
}

/* BASIC CHECKS */
if ($fullname == "" || $email == "" || $date == "") {
    echo "Required fields missing.";
    exit();
}

$destination_name = $place;
$selected_date = $date;
$message = $note;
$img_file = $img;

$img_file = $img;

/* DOUBLE BOOKING CHECK (SIMPLE) */
$sqlCheck = "SELECT id FROM bookings WHERE user_id = ? AND destination_name = ? AND selected_date = ?";
$resCheck = sqlsrv_query($conn, $sqlCheck, array($user_id, $destination_name, $selected_date));
$rowCheck = sqlsrv_fetch_array($resCheck);

if ($rowCheck != null) {
    echo "
    <script>
    alert('You have already booked this destination for this date.');
    window.location='../booking/locations.php';
    </script>
    ";
    exit();
}

/* INSERT */
$sql = "
INSERT INTO bookings (name, email, destination_name, price, selected_date, message, img_file, user_id)
VALUES (
    '$fullname',
    '$email',
    '$destination_name',
    '$price',
    '$selected_date',
    '$message',
    '$img_file',
    '$user_id'
)
";

$result = sqlsrv_query($conn, $sql);

if ($result) {
    header("Location: Bookedplaces.php");
    exit();
} else {
    echo "Insert failed.";
}
?>