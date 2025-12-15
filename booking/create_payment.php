<?php
session_start();
include("../dbconnect/db.php");

/* LOGIN CHECK */
if (@$_SESSION["userID"] == "") {
    echo "You must be logged in.";
    exit();
}

$userID = $_SESSION["userID"];

/* READ BOOKING ID */
$bookingID = 0;

if ($_GET["booking_id"] != "") {
    $bookingID = $_GET["booking_id"];
}

if ($bookingID == 0) {
    echo "Invalid booking.";
    exit();
}

/* FETCH BOOKING DATA */
$sql = "SELECT id, destination_name, price FROM bookings WHERE id = ?";
$stmt = sqlsrv_query($conn, $sql, array($bookingID));

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($row == null) {
    echo "Booking not found.";
    exit();
}

$price = $row["price"];
$title = $row["destination_name"];

/* Convert to centavos */
$amount = $price * 100;

/* PAYMONGO KEY */
$secretKey = "sk_test_aojcRtZRJuiea8sCvoGBMXbw";

/* ============================
   BUILD REQUEST PAYLOAD MANUALLY
   ============================ */

$arr = array();
$arr2 = array();
$arr3 = array();

$arr3["amount"] = $amount;
$arr3["currency"] = "PHP";
$arr3["description"] = "Booking Payment for: " . $title;

$arr2["attributes"] = $arr3;
$arr["data"] = $arr2;

$jsonBody = json_encode($arr);

/* ============================
   SEND CURL REQUEST
   ============================ */

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/links");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

$headers = array();
$headers[0] = "Content-Type: application/json";
$headers[1] = "Authorization: Basic " . base64_encode($secretKey . ":");

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

curl_close($ch);

/* ============================
   READ RESPONSE
   ============================ */

$response = json_decode($result, true);

$payURL = "";

if ($response != null) {
    if ($response["data"] != "") {
        if ($response["data"]["attributes"] != "") {
            if ($response["data"]["attributes"]["checkout_url"] != "") {
                $payURL = $response["data"]["attributes"]["checkout_url"];
            }
        }
    }
}

if ($payURL != "") {
    header("Location: " . $payURL);
    exit();
}

/* Failure */
echo "Failed to generate payment link.";

?>