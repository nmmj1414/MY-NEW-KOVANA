<?php
session_start();
include("../dbconnect/db.php");

$username = "";
$email = "";
$password = "";
$exists = 0;

// read form inputs
if ($_POST["username_reg"] != "") {
    $username = $_POST["username_reg"];
}
if ($_POST["email_reg"] != "") {
    $email = $_POST["email_reg"];
}
if ($_POST["pass_reg"] != "") {
    $password = $_POST["pass_reg"];
}

// check if email is taken
$sql1 = "SELECT id FROM Registered WHERE email = '$email'";
$res1 = sqlsrv_query($conn, $sql1);

$row1 = sqlsrv_fetch_array($res1);
if ($row1 != null) {
    $exists = 1;
}

// check if username is taken
$sql2 = "SELECT id FROM Registered WHERE username = '$username'";
$res2 = sqlsrv_query($conn, $sql2);

$row2 = sqlsrv_fetch_array($res2);
if ($row2 != null) {
    $exists = 1;
}

// stop if user already exists
if ($exists == 1) {
    echo "
    <script>
    alert('Email or Username already exists.');
    window.location='../Home/home.php';
    </script>
    ";
    exit();
}

// handle profile picture upload
$filename = "default.jpg"; // default image if none uploaded
if (array_key_exists("profile_pic", $_FILES)) {
    if ($_FILES["profile_pic"]["name"] != "") {
        $filename = basename($_FILES["profile_pic"]["name"]);
        $target = "../profpics/" . $filename;
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target);
    }
}

// save new user to database
$sql3 = "
INSERT INTO Registered (username, email, password, profile_pic)
VALUES ('$username', '$email', '$password', '$filename')
";
sqlsrv_query($conn, $sql3);

// get the new user's id
$sql4 = "SELECT id FROM Registered WHERE email = '$email'";
$res4 = sqlsrv_query($conn, $sql4);

$userID = 0;
$row4 = sqlsrv_fetch_array($res4);
if ($row4 != null) {
    $userID = $row4["id"];
}

// start session immediately
$_SESSION["userID"] = $userID;
$_SESSION["username"] = $username;
$_SESSION["profile_pic"] = $filename;

// check where to redirect
$redirect = "../Home/home.php";
if (array_key_exists("redirect", $_POST) && $_POST["redirect"] != "") {
    $redirect = $_POST["redirect"];
}

// done
echo "
<script>
alert('Registration successful!');
window.location='$redirect';
</script>
";
?>
