<?php
session_start();
include("locations_data.php");

/* ensure session values exist */
if (array_key_exists("username", $_SESSION) == 0) {
    $_SESSION["username"] = "";
}

if (array_key_exists("userID", $_SESSION) == 0) {
    $_SESSION["userID"] = "";
}

/* determine login state */
$logged = 0;
$displayName = "";

if ($_SESSION["username"] != "") {
    $logged = 1;
    $displayName = $_SESSION["username"];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Destinations</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Home/homestyles.css?v=<?php echo time(); ?>">
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg travel-navbar">
    <div class="container">

        <a class="navbar-brand site-logo" href="../Home/home.php">KOVANA</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav mx-auto nav-links">
                <li class="nav-item"><a class="nav-link" href="../Home/home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="../booking/locations.php">Destinations</a></li>
                <li class="nav-item"><a class="nav-link" href="../Home/aboutus.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="../Home/contact.php">Contact</a></li>
            </ul>

            <?php if ($logged == 0) { ?>
                <button class="nav-action-btn" data-bs-toggle="modal" data-bs-target="#authModal">
                    Login / Register
                </button>
            <?php } else { ?>
                <div class="d-flex align-items-center">
                    <div class="nav-user-box me-2"><?php echo $displayName; ?></div>
                    <a href="../booking/bookedplaces.php" class="nav-action-btn ms-2">Your Booked Places</a>
                    <form method="POST" action="../LoginRegister/logout.php">
                        <button class="nav-action-btn logout-btn ms-2">Logout</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>

<!-- ================= TITLE ================= -->
<div class="container pt-5 mt-4 text-center">
    <h2 class="fw-bold mb-3">All Available Destinations</h2>
</div>

<!-- ================= CATEGORY TABS ================= -->
<div class="container mb-4">
    <ul class="nav nav-tabs justify-content-center" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#restaurantsTab">
                Restaurants
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#activitiesTab">
                Activities
            </button>
        </li>
    </ul>
</div>

<!-- LOGIN WARNING -->
<div id="loginWarning"
     style="display:none;background:#ffeaea;border:1px solid #ff4d4d;
            color:#b30000;padding:10px;border-radius:6px;
            margin-bottom:15px;font-weight:600;text-align:center;">
    You need to be logged in first before you can book.
</div>

<!-- ================= TAB CONTENT ================= -->
<div class="tab-content">

    <!-- ===== RESTAURANTS TAB ===== -->
    <div class="tab-pane fade show active" id="restaurantsTab">
        <div class="container py-4">
            <div class="row g-4">
                <?php
                for ($i = 0; $i < 15; $i++) {
                ?>
                <div class="col-md-4 d-flex">
                    <form method="POST" action="landing.php" class="flex-grow-1">
                        <input type="hidden" name="type" value="resto">
                        <input type="hidden" name="index" value="<?php echo $i; ?>">

                        <div class="card shadow-sm h-100 d-flex flex-column">
                            <img src="../images/<?php echo $resto[$i][3]; ?>" class="package-img">

                            <div class="p-3 flex-grow-1">
                                <h5 class="fw-bold"><?php echo $resto[$i][0]; ?></h5>
                                <p class="mb-1"><?php echo $resto[$i][1]; ?></p>
                                <p class="fw-bold">₱<?php echo $resto[$i][2]; ?></p>
                            </div>

                            <?php if ($logged == 1) { ?>
                                <button class="btn btn-primary w-100 mt-auto">View Details</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary w-100 mt-auto" onclick="requireLogin();">
                                    View Details
                                </button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- ===== ACTIVITIES TAB ===== -->
    <div class="tab-pane fade" id="activitiesTab">
        <div class="container py-4">
            <div class="row g-4">
                <?php
                for ($x = 0; $x < 15; $x++) {
                ?>
                <div class="col-md-4 d-flex">
                    <form method="POST" action="landing.php" class="flex-grow-1">
                        <input type="hidden" name="type" value="act">
                        <input type="hidden" name="index" value="<?php echo $x; ?>">

                        <div class="card shadow-sm h-100 d-flex flex-column">
                            <img src="../images/<?php echo $act[$x][3]; ?>" class="package-img">

                            <div class="p-3 flex-grow-1">
                                <h5 class="fw-bold"><?php echo $act[$x][0]; ?></h5>
                                <p class="mb-1"><?php echo $act[$x][1]; ?></p>
                                <p class="fw-bold">₱<?php echo $act[$x][2]; ?></p>
                            </div>

                            <?php if ($logged == 1) { ?>
                                <button class="btn btn-primary w-100 mt-auto">View Details</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary w-100 mt-auto" onclick="requireLogin();">
                                    View Details
                                </button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>

    <!-- ================= LOGIN / REGISTER MODAL ================= -->
    <div class="modal fade" id="authModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4" style="border-radius:15px;">

                <h3 class="fw-bold text-center mb-4">Welcome to KOVANA</h3>

                <form method="POST" action="../LoginRegister/login_process.php" class="mb-3">
                    <input type="hidden" name="redirect" value="locations.php">

                    <h5 class="fw-bold mb-2">Login</h5>

                    <label>Email</label>
                    <input type="text" name="email_login" class="form-control mb-1">

                    <label>Password</label>
                    <input type="password" name="pass_login" class="form-control mb-2">

                    <button class="btn btn-primary w-100 py-1">Login</button>
                </form>

                <hr style="margin:10px 0; opacity:0.3;">

                <form method="POST" action="../LoginRegister/register_process.php">
                    <h5 class="fw-bold mb-1">Create New Account</h5>

                    <label>Username</label>
                    <input type="text" name="username_reg" class="form-control mb-1">

                    <label>Email</label>
                    <input type="text" name="email_reg" class="form-control mb-1">

                    <label>Password</label>
                    <input type="password" name="pass_reg" class="form-control mb-2">

                    <button class="btn btn-success w-100 py-1">Register</button>
                </form>

                <hr style="margin:10px 0; opacity:0.3;">

                <div class="text-center fw-bold mb-2">OR</div>

                <button onclick="googlePrompt()" class="w-100 py-2" style="border:1px solid #ccc;border-radius:8px;background:white;
                       display:flex;align-items:center;justify-content:center;
                       gap:10px;font-weight:600;">
                    <img src="../images/google_icon.png" width="20">
                    Continue with Google
                </button>

                <div id="g_id_onload"
                    data-client_id="397070442652-a36b7hmfeah7sag869fsrgqdcpkvcrs6.apps.googleusercontent.com"
                    data-context="signin" data-ux_mode="popup" data-callback="handleGoogle" data-auto_prompt="false">
                </div>

                <div class="g_id_signin" style="display:none;"></div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://accounts.google.com/gsi/client" async></script>

    <script>
        function googlePrompt() {
            google.accounts.id.prompt();
        }

        function handleGoogle(response) {
            var token = response.credential;

            var form = document.createElement("form");
            form.method = "POST";
            form.action = "../LoginRegister/google_login.php";

            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "token";
            input.value = token;

            var redir = document.createElement("input");
            redir.type = "hidden";
            redir.name = "redirect";
            redir.value = "locations.php";

            form.appendChild(input);
            form.appendChild(redir);
            document.body.appendChild(form);
            form.submit();
        }

        function requireLogin() {
            var warn = document.getElementById("loginWarning");
            if (warn) {
                warn.style.display = "block";
            }

            var modal = new bootstrap.Modal(document.getElementById("authModal"));
            modal.show();
        }
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function requireLogin() {
    var warn = document.getElementById("loginWarning");
    if (warn) {
        warn.style.display = "block";
    }

    var modal = new bootstrap.Modal(document.getElementById("authModal"));
    modal.show();
}
</script>
<?php include("../Home/footer.php"); ?>

</body>
</html>
