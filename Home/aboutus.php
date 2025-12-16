<?php
session_start();

if (array_key_exists("username", $_SESSION) == 0) { $_SESSION["username"] = ""; }
if (array_key_exists("userID", $_SESSION) == 0) { $_SESSION["userID"] = ""; }

$logged = 0;
$displayName = "";
if ($_SESSION["username"] != "") { $logged = 1; $displayName = $_SESSION["username"]; }
?>
<!DOCTYPE html>
<html>
<head>
<title>About Us</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="homestyles.css?v=<?php echo time(); ?>">
</head>

<body>

    <nav class="navbar navbar-expand-lg travel-navbar">
        <div class="container">
            <a class="navbar-brand site-logo" href="../Home/home.php">KOVANA</a>
            <button class="nav-action-btn toggle ms-2" onclick="toggleTheme()">🌙</button>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu"><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav mx-auto nav-links">
                    <li class="nav-item"><a class="nav-link" href="../Home/home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../booking/locations.php">Destinations</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../Home/aboutus.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Home/contact.php">Contact</a></li>
                </ul>

                <?php if ($logged == 0) { ?>
                    <button class="nav-action-btn" data-bs-toggle="modal" data-bs-target="#authModal">Login /
                        Register</button>
                <?php } else { ?>
                    <div class="d-flex align-items-center">
                        <?php
                        $picDisplay = "../images/default.png";
                        if (array_key_exists("profile_pic", $_SESSION) && $_SESSION["profile_pic"] != "") {
                            $pic = $_SESSION["profile_pic"];
                            if (strpos($pic, "http") === 0) {
                                $picDisplay = $pic;
                            } else {
                                $picDisplay = "../profpics/" . $pic;
                            }
                        }
                        ?>
                        <img src="<?php echo $picDisplay; ?>"
                            style="width:35px; height:35px; border-radius:50%; object-fit:cover;" class="me-2">
                        <div class="nav-user-box me-2"><?php echo $displayName; ?></div>
                        <a href="../booking/bookedplaces.php" class="nav-action-btn booked-btn ms-2">Your Booked Places</a>
                        <form method="POST" action="../LoginRegister/logout.php">
                            <input type="hidden" name="redirect" value="../Home/aboutus.php">
                            <button class="nav-action-btn logout-btn ms-2">Logout</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </nav>

<div class="container py-5 mt-3">
<div style="margin-top:40px;"></div>
<h2 class="fw-bold text-center mb-4">About KOVANA</h2>

<p class="text-muted text-center mb-5">
Your trusted platform for discovering destinations, dining experiences, and activities.
</p>

<div class="row">
<div class="col-md-6">
<h5 class="fw-bold">Who We Are</h5>
<p>
KOVANA is a travel and experience booking platform designed to help users explore
restaurants and activities with ease.
</p>
</div>

<div class="col-md-6">
<h5 class="fw-bold">Our Mission</h5>
<p>
We aim to connect people with memorable experiences through a simple booking system.
</p>
</div>
</div>
</div>

<!-- SAME MODAL, DIFFERENT REDIRECT -->
    <!-- COMPACT MODAL -->
    <div class="modal fade" id="authModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-4" style="border-radius:15px;">

                <h3 class="fw-bold text-center mb-4">Welcome to KOVANA</h3>

                <div class="row">
                    <div class="col-md-6" style="border-right: 1px solid #dee2e6;">
                        <form method="POST" action="../LoginRegister/login_process.php" class="mb-4">
                            <input type="hidden" name="redirect" value="../Home/aboutus.php">
                            <h5 class="fw-bold mb-2">Login</h5>
                            <label>Email</label>
                            <input type="text" name="email_login" class="form-control mb-1">
                            <label>Password</label>
                            <input type="password" name="pass_login" class="form-control mb-2">
                            <button class="btn btn-primary w-100 py-1">Login</button>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <form method="POST" action="../LoginRegister/register_process.php" enctype="multipart/form-data">
                            <input type="hidden" name="redirect" value="../Home/aboutus.php">
                            <h5 class="fw-bold mb-1">Create New Account</h5>
                            <label>Username</label>
                            <input type="text" name="username_reg" class="form-control mb-1">
                            <label>Email</label>
                            <input type="text" name="email_reg" class="form-control mb-1">
                            <label>Password</label>
                            <input type="password" name="pass_reg" class="form-control mb-2">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_pic" class="form-control mb-2" accept="image/*">
                            <button class="btn btn-success w-100 py-1">Register</button>
                        </form>
                    </div>
                </div>

                <hr class="my-3">

                <div class="text-center fw-bold mb-2">OR</div>

                <div class="google-wrap text-center">
                    <div class="g_id_signin d-inline-block" data-type="standard" data-size="large" data-theme="outline"
                        data-width="280"></div>
                </div>

                <div id="g_id_onload"
                    data-client_id="397070442652-a36b7hmfeah7sag869fsrgqdcpkvcrs6.apps.googleusercontent.com"
                    data-context="signin" data-ux_mode="popup" data-callback="handleGoogle" data-auto_prompt="false">
                </div>

            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://accounts.google.com/gsi/client" async></script>

<script>
function handleGoogle(response) {
var form = document.createElement("form");
form.method = "POST";
form.action = "../LoginRegister/google_login.php";

var t = document.createElement("input");
t.type = "hidden";
t.name = "token";
t.value = response.credential;

var r = document.createElement("input");
r.type = "hidden";
r.name = "redirect";
r.value = "../Home/aboutus.php";

form.appendChild(t);
form.appendChild(r);
document.body.appendChild(form);
form.submit();
}
</script>

<?php include("footer.php"); ?>
</body>
</html>
