<?php
session_start();

/* =========================
   LOAD DATABASE CONNECTION
   ========================= */
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

/* check if db connection exists */
if ($conn == null) {
    echo "
    <script>
    alert('Database connection failed.');
    window.location='../Home/home.php';
    </script>
    ";
    exit();
}

/* =========================
   READ POST VALUES
   ========================= */
$token = "";

/* read google token */
if ($_POST["token"] != "") {
    $token = $_POST["token"];
}


/* token is required */
if ($token == "") {
    echo "
    <script>
    alert('Google token missing.');
    window.location='../Home/home.php';
    </script>
    ";
    exit();
}

/* =========================
   DECODE GOOGLE JWT PAYLOAD
   ========================= */

/* split token */
$parts = explode(".", $token);
$payload = "";

/* extract payload part */
if ($parts != null) {
    if (count($parts) > 1) {
        if ($parts[1] != "") {
            $payload = $parts[1];
        }
    }
}

/* replace base64 characters */
$payload = str_replace("-", "+", $payload);
$payload = str_replace("_", "/", $payload);

/* fix padding */
$length = strlen($payload);
$extra = $length % 4;

if ($extra == 2) {
    $payload = $payload . "==";
}

if ($extra == 3) {
    $payload = $payload . "=";
}

/* decode payload */
$json = base64_decode($payload);
$data = json_decode($json, true);

/* =========================
   READ GOOGLE USER DATA
   ========================= */
$gEmail = "";
$gName = "";
$gPic = "";

if ($data != null) {

    if ($data["email"] != "") {
        $gEmail = $data["email"];
    }

    if ($data["name"] != "") {
        $gName = $data["name"];
    }

    if ($data["picture"] != "") {
        $gPic = $data["picture"];
    }
}

/* email is required */
if ($gEmail == "") {
    echo "
    <script>
    alert('Could not read Google email.');
    window.location='../Home/home.php';
    </script>
    ";
    exit();
}

/* =========================
   CHECK IF USER EXISTS
   ========================= */
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

/* =========================
   LOGIN EXISTING USER
   ========================= */
if ($userFound == 1) {

    $_SESSION["userID"] = $userID;
    $_SESSION["username"] = $dbUsername;

    echo "
    <script>
    alert('Welcome back! Logged in successfully.');
    window.location='../Home/home.php';
    </script>
    ";
    exit();
}

/* =========================
   REGISTER NEW GOOGLE USER
   ========================= */

/* generate simple random password */
$chars = "ABCDEF123456";
$randpass = "";
$len = strlen($chars);

for ($i = 0; $i < 10; $i++) {
    $pos = rand(0, $len - 1);
    $randpass = $randpass . $chars[$pos];
}

/* insert new user */
$sql_ins = "
INSERT INTO Registered (username, email, password, profile_pic)
VALUES ('$gName', '$gEmail', '$randpass', '$gPic')
";
sqlsrv_query($conn, $sql_ins);

/* get newly created user id */
$sql_get = "SELECT id FROM Registered WHERE email = '$gEmail'";
$res2 = sqlsrv_query($conn, $sql_get);

$newID = 0;
$row2 = sqlsrv_fetch_array($res2);

if ($row2 != null) {
    $newID = $row2["id"];
}

/* set session */
$_SESSION["userID"] = $newID;
$_SESSION["username"] = $gName;

echo "
<script>
alert('Google account registered & logged in successfully!');
window.location='../Home/home.php';
</script>
";
exit();

?>