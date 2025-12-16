<?php
session_start();

// load database connection
$db_file = "../dbconnect/db.php";
if (file_exists($db_file)) {
    include($db_file);
} else {
    echo "
    <script>
    alert('db.php not found.');
    window.location='../Home/home.php';
    </script>
    ";
    exit();
}

// check if db connection works
if ($conn == null) {
    echo "
    <script>
    alert('Database connection failed.');
    window.location='../Home/home.php';
    </script>
    ";
    exit();
}

// read values sent from the form
$token = "";
$redirect = "";

if (array_key_exists("token", $_POST)) {
    $token = $_POST["token"];
}

if (array_key_exists("redirect", $_POST)) {
    $redirect = $_POST["redirect"];
}

// token is needed to proceed
if ($token == "") {
    echo "
    <script>
    alert('Google token missing.');
    window.location='../Home/home.php';
    </script>
    ";
    exit();
}

// decode the google token (jwt)
// we do this manually to avoid installing extra libraries
$parts = explode(".", $token);
$payload = "";

if ($parts != null && count($parts) > 1) {
    $payload = $parts[1];
}

// replace special characters for base64 decode
$payload = str_replace("-", "+", $payload);
$payload = str_replace("_", "/", $payload);

// fix padding issues
$length = strlen($payload);
$extra = $length % 4;

if ($extra == 2) {
    $payload = $payload . "==";
}

if ($extra == 3) {
    $payload = $payload . "=";
}

// decode the json data
$json = base64_decode($payload);
$data = json_decode($json, true);

// get user info from the decoded data
$gEmail = "";
$gName = "";
$gPic = "";

if ($data != null) {
    if (array_key_exists("email", $data)) {
        $gEmail = $data["email"];
    }
    if (array_key_exists("name", $data)) {
        $gName = $data["name"];
    }
    if (array_key_exists("picture", $data)) {
        $gPic = $data["picture"];
    }
}

// email is required for login
if ($gEmail == "") {
    echo "
    <script>
    alert('Could not read Google email.');
    window.location='../Home/home.php';
    </script>
    ";
    exit();
}

// check if this email is already registered
$sql_check = "SELECT id, username FROM Registered WHERE email = '$gEmail'";
$res = sqlsrv_query($conn, $sql_check);

$userFound = 0;
$userID = 0;
$dbUsername = "";

$row = sqlsrv_fetch_array($res);

if ($row != null) {
    $userFound = 1;
    $userID = $row["id"];
    $dbUsername = $row["username"];
}

// login the existing user
if ($userFound == 1) {

    // get the user's profile pic
    $sql_pic = "SELECT profile_pic FROM Registered WHERE id = $userID";
    $res_pic = sqlsrv_query($conn, $sql_pic);
    $row_pic = sqlsrv_fetch_array($res_pic);
    $dbPic = "";
    
    if ($row_pic != null && array_key_exists("profile_pic", $row_pic)) {
        $dbPic = $row_pic["profile_pic"];
    }

    $_SESSION["userID"] = $userID;
    $_SESSION["username"] = $dbUsername;
    $_SESSION["profile_pic"] = $dbPic;

    // go back to the page we came from
    if ($redirect != "") {
        echo "
        <script>
        alert('Welcome back! Logged in successfully.');
        window.location='" . $redirect . "';
        </script>
        ";
        exit();
    }

    echo "
    <script>
    alert('Welcome back! Logged in successfully.');
    window.location='../Home/home.php';
    </script>
    ";
    exit();
}

// register a new user if not found
// create a random password since they use google login
$chars = "ABCDEF123456";
$randpass = "";
$len = strlen($chars);

for ($i = 0; $i < 10; $i++) {
    $pos = rand(0, $len - 1);
    $randpass = $randpass . $chars[$pos];
}

// save the new user
$sql_ins = "
INSERT INTO Registered (username, email, password, profile_pic)
VALUES ('$gName', '$gEmail', '$randpass', '$gPic')
";
sqlsrv_query($conn, $sql_ins);

// get the new user's id
$sql_get = "SELECT id FROM Registered WHERE email = '$gEmail'";
$res2 = sqlsrv_query($conn, $sql_get);

$newID = 0;
$row2 = sqlsrv_fetch_array($res2);

if ($row2 != null) {
    $newID = $row2["id"];
}

// start the session
$_SESSION["userID"] = $newID;
$_SESSION["username"] = $gName;
$_SESSION["profile_pic"] = $gPic;

// redirect
if ($redirect != "") {
    echo "
    <script>
    alert('Google account registered & logged in successfully!');
    window.location='" . $redirect . "';
    </script>
    ";
    exit();
}

echo "
<script>
alert('Google account registered & logged in successfully!');
window.location='../Home/home.php';
</script>
";
exit();
?>
