<?php
session_start();
include("../dbconnect/db.php");

/* LOGIN CHECK */
if (array_key_exists("userID", $_SESSION) == 0) {
    $_SESSION["userID"] = "";
}

if ($_SESSION["userID"] == "") {
    header("Location: ../Home/home.php");
    exit();
}

/* READ BOOKING ID */
$bookingID = 0;

if ($_GET["booking_id"] != "") {
    $bookingID = $_GET["booking_id"];
}

if ($bookingID == 0) {
    echo "Invalid booking.";
    exit();
}

/* FETCH CURRENT STATUS */
$sql0 = "SELECT payment_status,destination_name,price FROM bookings WHERE id = ?";
$res0 = sqlsrv_query($conn, $sql0, array($bookingID));
$row0 = sqlsrv_fetch_array($res0, SQLSRV_FETCH_ASSOC);

if ($row0 == null) {
    echo "Booking not found.";
    exit();
}

$currentStatus = $row0["payment_status"];

/* IF REFUND */
if ($currentStatus == "Paid") {

    $sqlRefund = "UPDATE bookings SET payment_status = 'pending' WHERE id = ?";
    sqlsrv_query($conn, $sqlRefund, array($bookingID));

    header("Location: bookedplaces.php");
    exit();
}

/* =======================
   PAY NOW (DEMO PAYMONGO)
   ======================= */

$title = $row0["destination_name"];
$price = $row0["price"];
$amount = $price * 100;

/* UPDATE STATUS FIRST (DEMO) */
$sqlPay = "UPDATE bookings SET payment_status = 'Paid' WHERE id = ?";
sqlsrv_query($conn, $sqlPay, array($bookingID));

/* PAYMONGO KEY */
$secretKey = "sk_test_aojcRtZRJuiea8sCvoGBMXbw";

/* BUILD REQUEST */
$arr = array();
$arr2 = array();
$arr3 = array();

$arr3["amount"] = $amount;
$arr3["currency"] = "PHP";
$arr3["description"] = "Booking Payment for: " . $title;

$arr2["attributes"] = $arr3;
$arr["data"] = $arr2;

$jsonBody = json_encode($arr);

/* CURL */
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

/* READ RESPONSE */
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

header("Location: bookedplaces.php");
exit();
