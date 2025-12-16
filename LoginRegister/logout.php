<?php
session_start();

session_unset();
session_destroy();

/* CHECK REDIRECT */
$redirect = "../Home/home.php";
if (array_key_exists("redirect", $_POST) && $_POST["redirect"] != "") {
    $redirect = $_POST["redirect"];
} else if (array_key_exists("redirect", $_GET) && $_GET["redirect"] != "") {
    $redirect = $_GET["redirect"];
}

echo "
<script>
alert('Logged out successfully.');
window.location='$redirect';
</script>
";
?>