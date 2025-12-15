<?php
session_start();
include("../dbconnect/db.php");

/* default values to avoid undefined usage */
$email = "";
$password = "";
$redirect = "";

/* read login inputs */
if ($_POST["email_login"] != "") {
    $email = $_POST["email_login"];
}

if ($_POST["pass_login"] != "") {
    $password = $_POST["pass_login"];
}

/* read redirect page if provided */
if ($_POST["redirect"] != "") {
    $redirect = $_POST["redirect"];
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

        /* redirect back to calling page if provided */
        if ($redirect != "") {
            echo "
            <script>
            alert('Login successful!');
            window.location='../booking/" . $redirect . "';
            </script>
            ";
            exit();
        }

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