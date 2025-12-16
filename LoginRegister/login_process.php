<?php
session_start();
include("../dbconnect/db.php");

// set defaults
$email = "";
$password = "";
$redirect = "";

// read login inputs
if ($_POST["email_login"] != "") {
    $email = $_POST["email_login"];
}

if ($_POST["pass_login"] != "") {
    $password = $_POST["pass_login"];
}

// check if we need to redirect somewhere specific
if ($_POST["redirect"] != "") {
    $redirect = $_POST["redirect"];
}

// find user in the database
$sql = "SELECT id, username, password, profile_pic FROM Registered WHERE email = '$email'";
$res = sqlsrv_query($conn, $sql);

$found = 0;
$dbPass = "";
$dbID = 0;
$dbUser = "";
$dbPic = "";

$row = sqlsrv_fetch_array($res);

if ($row != null) {
    $found = 1;
    $dbPass = $row["password"];
    $dbID = $row["id"];
    $dbUser = $row["username"];
    if (array_key_exists("profile_pic", $row)) {
        $dbPic = $row["profile_pic"];
    }
}

// validate the password
if ($found == 1) {

    if ($password == $dbPass) {

        // save session info
        $_SESSION["userID"] = $dbID;
        $_SESSION["username"] = $dbUser;
        $_SESSION["profile_pic"] = $dbPic;

        // redirect back to previous page
        if ($redirect != "") {
            echo "
            <script>
            alert('Login successful!');
            window.location='" . $redirect . "';
            </script>
            ";
            exit();
        }

        // default redirect to home
        echo "
        <script>
        alert('Login successful!');
        window.location='../Home/home.php';
        </script>
        ";
        exit();
    }
}

// if login fails
echo "
<script>
alert('Incorrect email or password.');
window.location='../Home/home.php';
</script>
";
exit();
?>
