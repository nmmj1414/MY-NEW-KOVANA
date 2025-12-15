<?php
session_start();
include("../dbconnect/db.php");

$username = "";
$email = "";
$password = "";
$exists = 0;

/* READ INPUTS */
if ($_POST["username_reg"] != "") {
    $username = $_POST["username_reg"];
}
if ($_POST["email_reg"] != "") {
    $email = $_POST["email_reg"];
}
if ($_POST["pass_reg"] != "") {
    $password = $_POST["pass_reg"];
}

/* CHECK IF EMAIL EXISTS */
$sql1 = "SELECT id FROM Registered WHERE email = '$email'";
$res1 = sqlsrv_query($conn, $sql1);

$row1 = sqlsrv_fetch_array($res1);
if ($row1 != null) {
    $exists = 1;
}

/* CHECK IF USERNAME EXISTS */
$sql2 = "SELECT id FROM Registered WHERE username = '$username'";
$res2 = sqlsrv_query($conn, $sql2);

$row2 = sqlsrv_fetch_array($res2);
if ($row2 != null) {
    $exists = 1;
}

/* IF DUPLICATE */
if ($exists == 1) {
    echo "
    <script>
    alert('Email or Username already exists.');
    window.location='../Home/home.php';
    </script>
    ";
    exit();
}

/* INSERT NEW USER */
$sql3 = "
INSERT INTO Registered (username, email, password, profile_pic)
VALUES ('$username', '$email', '$password', '')
";

sqlsrv_query($conn, $sql3);

/* FETCH ID */
$sql4 = "SELECT id FROM Registered WHERE email = '$email'";
$res4 = sqlsrv_query($conn, $sql4);

$userID = 0;
$row4 = sqlsrv_fetch_array($res4);
if ($row4 != null) {
    $userID = $row4["id"];
}

/* SET SESSION */
$_SESSION["userID"] = $userID;
$_SESSION["username"] = $username;

/* REDIRECT */
echo "
<script>
alert('Registration successful!');
window.location='../Home/home.php';
</script>
";
?>