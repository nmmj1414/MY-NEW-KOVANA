<?php
session_start();
include("../dbconnect/db.php");

/* default values to avoid undefined usage */
$email = "";
$password = "";
/* read login inputs */
if ($_POST["email_login"] != "") {
    $email = $_POST["email_login"];
}

if ($_POST["pass_login"] != "") {
    $password = $_POST["pass_login"];
}

/* fetch user by email */
$sql = "SELECT id, username, password FROM Registered WHERE email = '$email'";
$res = sqlsrv_query($conn, $sql);

$found = 0;
$dbPass = "";
$dbID = 0;
$dbUser = "";

$row = sqlsrv_fetch_array($res);

/* check if user exists */
if ($row != null) {
    $found = 1;
    $dbPass = $row["password"];
    $dbID = $row["id"];
    $dbUser = $row["username"];
}

/* VALIDATE LOGIN */
if ($found == 1) {

    if ($password == $dbPass) {

        /* store login session values */
        $_SESSION["userID"] = $dbID;
        $_SESSION["username"] = $dbUser;

        /* fallback redirect */
        echo "
        <script>
        alert('Login successful!');
        window.location='../Home/home.php';
        </script>
        ";
        exit();
    }
}

/* FAILED LOGIN */
echo "
<script>
alert('Incorrect email or password.');
window.location='../Home/home.php';
</script>
";
exit();
?>