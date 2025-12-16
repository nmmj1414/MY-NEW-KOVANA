<footer class="bg-white mt-5 border-top">
    <div class="container py-4">
        <div class="row">

            <div class="col-md-4 mb-3">
                <h5 class="fw-bold">KOVANA</h5>
                <p class="mb-1">
                    Discover destinations, restaurants, and activities with ease.
                </p>
                <p class="mb-0">
                    Your travel companion.
                </p>
            </div>

            <div class="col-md-4 mb-3">
                <h6 class="fw-bold">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="../Home/home.php">Home</a></li>
                    <li><a href="../booking/locations.php">Destinations</a></li>
                    <li><a href="../Home/aboutus.php">About Us</a></li>
                    <li><a href="../Home/contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-3">
                <h6 class="fw-bold">Connect With Us</h6>
                <ul class="list-unstyled">
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Twitter</a></li>
                </ul>
            </div>

        </div>

        <hr>

        <div class="text-center">
            © 2025 KOVANA. All rights reserved.
        </div>
    </div>
    </div>
</footer>

<script>
    // Apply on load
    if (localStorage.getItem("theme") == "dark") {
        document.body.classList.add("dark-mode");
    }

    function toggleTheme() {
        var body = document.body;
        body.classList.toggle("dark-mode");
        if (body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
        } else {
            localStorage.setItem("theme", "light");
        }
    }
</script>
